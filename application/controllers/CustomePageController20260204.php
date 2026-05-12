<?php

defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 1);

class CustomePageController extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		Parent::__construct();
		$this->load->model('CustomModel');
		$this->load->library('BreadcrumbComponent');
		$this->breadcrumbs = new BreadcrumbComponent();
		$this->load->library('Mylibrary');
		$this->load->library('Themeonelayoutwidgets');
		$this->load->library('Staticpagefunctions');
		$this->Mylibrary = new Mylibrary();
		$this->Themeonelayoutwidgets = new Themeonelayoutwidgets();
		$this->Staticpagefunctions = new Staticpagefunctions();
		$this->load->helper('cookie');
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function angularhomepagecontent()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$params = array('ulbid' => $request->ulbid, 'langId' => $this->session->userdata('lang_Id'), 'is_homepage_content' => 1);

		$result = $this->MenuModel->angularhomepagecontent($params);
		echo json_encode($result);
	}

	public function angularSliderData()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$params = array('ulbid' => $request->ulbid, 'langId' => $this->session->userdata('lang_Id'));


		$result = $this->MenuModel->anggetsliderdata($params);
		echo json_encode($result);
	}
	public function changLanguage()
	{
		$langid =	$this->uri->segment(3);
		$this->session->set_userdata('lang_Id', $langid);
		//echo  $this->session->userdata('lang_Id');  exit;
		redirect('/');

		//  if($this->session->userdata('lang_Id')=='1')
		//  {
		//      $this->session->unset_userdata('lang_Id');
		//      $this->session->unset_userdata('langtext');
		//      $this->session->set_userdata('lang_Id','2');
		//      $this->session->set_userdata('langtext','English');

		//  }
		//  else
		//  {
		//      $this->session->unset_userdata('lang_Id');
		//      $this->session->unset_userdata('langtext');
		//      $this->session->set_userdata('lang_Id','1');
		//      $this->session->set_userdata('langtext','??????');
		//  }






	}

	/**** Library functions ****/
	public function widget_desc($widget_id)
	{
		$params = array('widget_id' => $widget_id);
		$result = $this->MenuModel->widget_desc($params);
		return $result;
	}


	public function getMenuTypeId($params)
	{
		$params = array('widget_id' => $params);
		$result = $this->MenuModel->getMenuTypeId($params);
		return $result;
	}

	public function footerWebsitePolicies($ulbid)
	{

		$result = $this->Themeonelayoutwidgets->footerWebsitePoliciess($ulbid);
		return $result;
	}

	public function getGovtLinkstData($gove_widgets)
	{
		$result = $this->Themeonelayoutwidgets->getGovtLinkstData($gove_widgets);
		return $result;
	}

	public function getWidgetData($widget_id, $is_common_page, $left_menu_id)
	{

		$params = array('widget_id' => $widget_id);
		$result = $this->MenuModel->getWidgetData($params);
		$widget_type = $result[0]['widget_type'];
		$params = array('widget_id' => $widget_id, 'widget_type' => $widget_type, 'ulbid' => $this->session->userdata('ulb_id'), 'langId' => $this->session->userdata('lang_Id'), 'uri' => $this->uri->segment('1'));
		//echo $url =  $this->uri->segment('1');exit;
		$result = $this->Themeonelayoutwidgets->getIndwidgetdata($params, $widget_type, $is_common_page, $left_menu_id);
		//echo $this->db->last_query();

		return $result;
	}

	public function updatePageContent()
	{

		if ($this->session->userdata('username')) {
			if ($this->input->post('save')) {
				$content = str_replace("'", "\'", $this->input->post('content'));
				$pageid = $this->input->post('pageid');



				$params = array(
					'pageid' => $pageid,
					'content' => $content
				);
				$result = $this->CustomModel->updatePageContent($params);
				if ($result == '1') {



					$this->session->set_flashdata('message', 'Page Updated successfully');
				} else {
					$this->session->set_flashdata('message', 'Unable to update page , Please try again');
				}

				redirect($this->input->post('page'));
			}
		} else {
			redirect('login');
		}
	}

	public function getAlbumPhotos()
	{
		$album_id = $this->uri->segment(3);
		$data['content'][0]['content'] = $this->Staticpagefunctions->getAlbumPhotos($album_id);
		$this->getPageContent();
	}

	public function pageInformation($params)
	{
		//$pageinfo=$this->MenuModel->getcustomPageInfo($params);
		//return $pageinfo;
	}

	public function do_upload()
	{
		$config['upload_path']   = '../pms/assets/petetion_images/';
		$config['allowed_types'] = 'gif|jpg|png|pdf';
		$config['max_size']      = 100;
		$config['max_width']     = 1024;
		$config['max_height']    = 768;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile')) {
		} else {
			return $data = array('upload_data' => $this->upload->data());
		}
	}

	public function getPageContent()
	{
		$ip = $this->input->ip_address();
		/*$url= "http://www.geoplugin.net/json.gp?ip=" . $ip;

		// Use JSON encoded string and converts
		// it into a PHP variable
		$ipdat = @json_decode(file_get_contents(
		"http://www.geoplugin.net/json.gp?ip=" . $ip));

		// Initialize a CURL session.
		$ch = curl_init();

		// Return Page contents.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//grab URL and pass it to the variable.
		curl_setopt($ch, CURLOPT_URL, $url);

		$result = curl_exec($ch);
		$result =json_decode($result);
		$result->geoplugin_countryName;



		$login_logo = array(
			'ip' => $_SERVER['SERVER_ADDR'],
			'updated_at' => date('Y-m-d H:i:s'),
			'username'=>'web',
			'session_id'=>session_id(),
			'refr'=>$_SERVER['REQUEST_URI'],
			'process_id'=>sha1(rand(1000,99999)),
			'user_agent'=>$this->agent->browser(),
			'url'=>$_SERVER['HTTP_REFERER'],
			'country'=>$result->geoplugin_countryName,
			'attempt_status'=>'Success'
		);


		$this->db->insert('userlogs', $login_logo);*/





		$data['languages'] = array('1' => 'English', '2' => 'Marathi', '3' => 'Hindi', '4' => 'Urdu');
		$data['visitors_count'] = $this->MenuModel->getVisitorCount() +  156862;
		// $ulbid = $this->session->userdata('ulb_id');//$this->security->xss_clean($this->uri->segment('1'));
		$ulbid = 300;
		// get Townprofile details
		$params = array('ulbid' => $ulbid);
		$data['townprofile_details'] = $this->MenuModel->getTownProfiledata($params);


		$this->breadcrumbs->add('Home', base_url(), '', '');
		$this->session->set_userdata('ulb_id', $ulbid);
		// echo $this->session->set_userdata('lang_Id','1');
		//$lang = file_get_contents('language_sel.txt');
		//echo $lang = $this->input->cookie('lang');

		//$lang = $this->input->cookie('lang');
		
		if(empty($this->input->cookie('lang'))){
			$lang=2;
		}else{
			$lang = $this->input->cookie('lang');
		}

		$this->session->set_userdata('lang_id', $lang);
		//echo $this->session->userdata('lang_Id');
		if (empty($lang) || $lang == 1) {

			$this->session->set_userdata('lang_Id', 1);
		} else {
			$this->session->set_userdata('lang_Id', 2);
		}

		$page = $this->security->xss_clean($this->uri->segment(1));

		$params = array('c.ulbid' => $ulbid, 'controller' => $page);

		$data['pageinfo'] = $this->MenuModel->getpageInfo($params);
		//print_r($data['pageinfo']);




		/** taking if it is common page or not to get left side menu **/

		$is_common_page = $data['pageinfo'][0]->is_common_page;
		$left_menu_id = $data['pageinfo'][0]->menu_type_id;



		if ($data['pageinfo'][0]->is_draft == 1) {

			echo "<h1>Page not found</h1>";
			exit;
		}

		/**************************************************************************************** page info ************/
		$albumid = $this->input->get('q');


		$params = array('ulbid' => $ulbid, 'controller' => $page);



		$data['pageinformation'] = $this->pageInformation($params);


		$data['pageinfo'] = $this->MenuModel->getcustomPageInfo($params);


		$data['description'] = $data['pageinfo'][0]->meta_desc;
		$data['keywords'] = $data['pageinfo'][0]->pagekeywords;
		$data['subject'] = $data['pageinfo'][0]->meta_subject;

		$params = array('ulbid' => $ulbid);
		$data['ulbinfo'] = $this->MenuModel->getULBInfo($params);
		//print_r($data['ulbinfo']);

		$data['footertitle'] = $data['ulbinfo'][0]->ulbname . " " . $data['ulbinfo'][0]->ulb_type_desc;;

		$data['ulbnametelutu'] = $data['ulbinfo'][0]->ulbtelugu . " " . $data['ulbinfo'][0]->ulb_type_desctelugu;
		$data['ulbnameenglish'] = $data['ulbinfo'][0]->ulbname . " " . $data['ulbinfo'][0]->ulb_type_desc;
		$data['generalsettings'] = $this->MenuModel->getULBgeneralsettings($params);


		$data['logo'] = $data['generalsettings'][0]['file_path'];
		$data['logo_alt'] = $data['generalsettings'][0]['alt'];
		$data['logo_title'] = $data['generalsettings'][0]['title'];
		if ($data['generalsettings'][0]['file_path'] == '') {
			$data['feviicon'] = "assets/cdma/img/logo1.png";
		} else {
			$data['generalsettings'][0]['file_path'];
			$data['feviicon'] = $data['generalsettings'][0]['file_path'];
		}


		$data['ulbid'] = $ulbid;

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 1);
		$result = $this->Mylibrary->getMenus($params);
		$data['mainmenus'] = $result['mainmenu'][0];
		$data['submenus'] = $result['submenu'][0];
		$data['subsubmenus'] = $result['chilemenu'][0];

		/*** left menus **/

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 2);
		$result = $this->Mylibrary->getMenus($params);
		$data['leftmainmenus']['leftmainmenus'] = $result['mainmenu'][0];
		$data['leftsubmenus']['leftsubmenus'] = $result['submenu'][0];
		$data['leftsubsubmenus']['leftsubsubmenus'] = $result['chilemenu'][0];

		/** footer menus **/

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 3);
		$result = $this->Mylibrary->getMenus($params);
		$data['footermainmenus']['footermainmenus'] = $result['mainmenu'][0];
		$data['footerleftsubmenus']['footerleftsubmenus'] = $result['submenu'][0];
		$data['footerleftsubsubmenus']['footerleftsubsubmenus'] = $result['chilemenu'][0];

		$params = array('ulbid' => $ulbid, 'controller' => $page);

// Search 

		if ($page == 'search') 
		{
			if ($this->input->post('search_keyword') != '') {

				$serackkeyname = $this->security->xss_clean(strip_tags(htmlspecialchars($this->input->post('search_keyword'))));

				$params = array('ulbid' => $ulbid, 'keyword' => $serackkeyname);
				$where = array('ulbid' => $ulbid);
				
				$searchContent = $this->CustomModel->getsearchData($params, $where);

				$content = "";

				if (empty($searchContent)) {
					$content = "<div class='alert alert-warning'>No result found . </div>";
				} else {

					$content = "<div class='alert alert-success mt-4 b-0 bg-warning'><b>Result Found</b> </div>";
				}

				foreach ($searchContent as $key => $val) {


					if ($val['is_custumlink'] == 1) {
						$url = $val['site_controller'];
					} else {
						$url = base_url() . $val['site_controller'];
					}
					$content .= "<div>";

					$content .= "<div><a href='" . $url . "' class='ser_link_tex' target='_blank' style='text-decoration:underline'><b> " . $val['page_name'] . " </b></a></div>";
					// $content.="<div class='ser_url'> <a href='".$url."' class='ser_url' target='_blank'>".$url."</a></div>";
					$content .= "<div class='ser_dectex'>" . substr(strip_tags(trim($val['content'])), 0, 200) . "</div>";
					$content .= "</div>";

					$content .= "<hr style='margin-top:10px; margin-bottom:10px;'>";
				}
			} else {
				$content = "<div class='alert alert-warning'>Your not supplied any input</div>";
			}


			$sidebarid = $data['content'][0]['page_sidebars_id'] = 4;
			$data['content'][0]['content'] = $content;
		} else {

			$data['content'] = $this->CustomModel->getpageData($params);


			//$data['content'][0]['content']=str_replace('/assets',base_url().'assets/',$data['content'][0]['content']);
			if ($data['content'][0]['page_sidebars_id'] >= 5) {
				$default_page_sidebar = $this->CustomModel->getpageSidebarId();
				$data['content'][0]['page_sidebars_id'] = $default_page_sidebar['superadmin_defautl_layout'];
			}
			$parameters = array('page_sidebars_id' => $data['content'][0]['page_sidebars_id']);

			if ($data['content']['is_code_page'] == '1') {

				$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 1);

				if ($data['content']['controller'] == 'sitemap') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getSitemap($params);

					// print_r($data['content'][0]['content']);
					//$data['content'][0]['content']=$this->Staticpagefunctions->getSitemap($params);
				} else if ($data['content']['controller'] == 'feedback') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getFeedbackform($ulbid);
				} else if ($data['content']['controller'] == 'feedback') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getFeedbackform($ulbid);
				} else if ($data['content']['controller'] == 'blood-donations') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getBloodDonationForm();
				} else if ($data['content']['controller'] == 'petetions') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getPetetionForm();
				} else if ($data['content']['controller'] == 'albums') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getAlbums($ulbid, $langid = 1);
				} else if ($data['content']['controller'] == 'faqs') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getFaqs($ulbid, $langid = 1);
				} else if ($data['content']['controller'] == 'gallery') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getGallery($albumid);
				} else if ($data['content']['controller'] == 'video-gallery') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getVidoGallery();
				} else if ($data['content']['controller'] == 'agenda-and-minutes') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getAgendaAndMinutes();
				} else if ($data['content']['controller'] == 'agenda-and-minutes-year') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getAgendaAndMinutesYears();
				} else if ($data['content']['controller'] == 'agenda-and-minutes-details') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getAgendaAndMinutesDetails();
				} else if ($data['content']['controller'] == 'know-your-property-tax') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getKnowYourPropertyTaxDetails();
				} else if ($data['content']['controller'] == 'complaint') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getComplaintDetails();
				} else if ($data['content']['controller'] == 'monthly') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getMonthlyDetails();
				} else if ($data['content']['controller'] == 'quarterly') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getQuarterlyDetails();
				} else if ($data['content']['controller'] == 'annual') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getAnnualDetails();
				} else if ($data['content']['controller'] == 'public-notices') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getPublicNotice($this->session->userdata('lang_Id'));
				} else if ($data['content']['controller'] == 'work-orders') {
					//echo $this->session->userdata('lang_Id');
					//exit;
					$data['content'][0]['content'] = $this->Staticpagefunctions->getWorkOrders($this->session->userdata('lang_Id'));
				} else if ($data['content']['controller'] == 'quotations') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getquotations($this->session->userdata('lang_Id'));
				} else if ($data['content']['controller'] == 'faq') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getFaq($this->session->userdata('lang_Id'));
				}


				/*************************************************************************************************************************************/
				// echo $sidebarid=$data['content'][0]['page_sidebars_id'];
				$sidebarid = $data['content']['page_sidebars_id'];

				//$this->breadcrumbs->add($data['content']['page_name'], $data['content']['site_controller'],$target,$class); 
			} else {

				//print_r($data['content']);
				$sidebarid = $data['content'][0]['page_sidebars_id'];
				// $sidebarid=$page_sidebars_id;
				$sidebarid = $sidebarid;
			}
		}

		$category_id = $this->uri->segment('3');

		// if requested page id is category getting all posts of that category


//echo "<pre>";print_r($data['content'][0]['content']);echo "</pre>";die();

		if ($category_id != '') {
			//$params=array('category_id'=>$category_id);
			$params = array('site_controller' => $category_id);
			$category_name = $this->CustomModel->getCategoryName($params);
			// print_r($category_name);
			$params = array('category_id' => $category_name['page_id']);
			$posts = $this->CustomModel->getCategoryPosts($params);
			$category_content = "";
			$category_content .= "<h3>" . $category_name['page_name'] . "</h3><br>";
			foreach ($posts as $key => $val) {
				if ($val['is_custumlink'] == '1') {
					$base_url = "";
				} else {
					$base_url = base_url();
				}
				if ($val['is_target_blank'] == '2') {
					$target = "target='_blank'";
				} else {
					$target = "target=''";
				}
				if ($val['is_alert'] == '1') {
					$class = "class='confirmation'";
				} else {
					$class = "class=''";
				}




				$category_content .= "<div>";
				$category_content .= "<div class='col-md-12 note_style'>";
				$category_content .= "<div class='col-md-1 note_box'>";
				$category_content .= "<div class='note_circle'>";
				$category_content .= "<i class='fa fa-bell'></i>";
				$category_content .= "</div>";
				$category_content .= "</div>";
				$category_content .= "<div class='col-md-11 note_top'>";
				$category_content .= "<p><a href='" . $base_url . $val['site_controller'] . "' " . $target . " " . $class . ">" . $val['page_name'] . "</a></p>";
				$category_content .= "<div class='post-details'> Published on : <span class='post_ti'>" . date('d-m-Y H:i:s', strtotime($val['datetime'])) . "</span> , Posted by : <span class='post_ti'> " . $val['author'] . " </span></div>";
				$category_content .= "</div>";
				$category_content .= "</div>";
				$category_content .= "</div>";
			}


			$data['content'][0]['content'] = $category_content;
			$sidebarid = 1;

			if ($category_name['is_custumlink'] == '1') {
				$base_url = "";
			} else {
				$base_url = base_url();
			}
			if ($category_name['is_target_blank'] == '2') {
				$target = "target='_blank'";
			} else {
				$target = "target=''";
			}
			if ($category_name['is_alert'] == '1') {
				$class = "class='confirmation'";
			} else {
				$class = "class=''";
			}

			$this->breadcrumbs->add($category_name['page_name'], $base_url . $ulbid . "/" . $category_name['site_controller'], $target, $class);
		}

		//echo $data['content'][0]['content'];

		$album_id = $this->uri->segment('4');
		if (is_numeric($album_id)) {
			$data['content'][0]['content'] = $this->Staticpagefunctions->getAlbumPhotos($album_id);
			$album_name = $this->Staticpagefunctions->getAlbumName($album_id);


			$this->breadcrumbs->add('Phot gallery', $base_url . $ulbid . "/albums", $target, $class);
			$this->breadcrumbs->add($album_name[0]['album_desc'], $base_url . $ulbid . "/albums/photos", 1, $class);
		}



		/*echo $data['content'][0]['content'];
	   exit;*/



		$params_sidebar = array('layout_id' => $sidebarid);


		$data['sidebar_list'] = $this->CustomModel->sidebar_list($params_sidebar);
		//print_r($data['sidebar_list']);

		/*echo "<pre>";
		print_r($data['content']);exit;*/





		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'));
		$data['headerNews'] = $this->MenuModel->getHeaderNews($params);

		$params = array('ulbid' => $ulbid);
		$themefolder = $this->MenuModel->getthemefolder($params); // selecting ulb mapped theme
		$theme = $themefolder[0]['folder'];
		$data['theme'] = $themefolder[0]['folder'];
		$themeLayoutId = $themefolder[0]['theme_id'];



		$params = array('theme_layout_id' => $themeLayoutId);
		$layoutwidgets = $this->MenuModel->getLayout_innerpage($params);
		$layouts = array();
		foreach ($layoutwidgets->result() as $key => $val) {
			$layouts[$val->page_layout_id] = $val->page_layout_desc;
		}



		$data['layoutwidgets'] = $this->Themeonelayoutwidgets->getLayoutwidgets($layouts, $ulbid, $langId = $this->session->userdata('lang_Id'), $is_common_page, $left_menu_id);
		//print_r($data['layoutwidgets']);

		$params = array('ulbid' => $this->session->userdata('ulb_id'), 'theme_layout_id' => $themeLayoutId, 'flag' => 1);
		$data['customepagelayouts'] = $this->MenuModel->getLayout($params);

		//print_r($data['customepagelayouts']);
		//exit;

		//$page_content="<div><h3>".$data['content'][0]['page_name']."</h3><br></div>";

		// text replacing with short codes here
		/*echo "<pre>";
	    print_r($data['customepagelayouts']);
		exit;*/


		$page_content .= str_replace('{municipality}', $data['ulbnameenglish'], $data['content'][0]['content']);
		$page_content = str_replace('{feedbackform}', $this->Staticpagefunctions->getFeedbackform($ulbid), $page_content);



		if ($data['content'][0]['is_custumlink'] == '2') {


			$category = $this->MenuModel->category_name($data['content'][0]['page_id']);
			$page_content .= "<div>";
			$page_content .= "<hr class='post-hr'>";
			$page_content .= "<div class='post-details'> ";
			$page_content .= "Published on : <span class='post_ti'>" . date('d-m-Y H:i:s', strtotime($data['content'][0]['datetime'])) . "</span>,";
			$page_content .= "Posted by : <span class='post_ti'> " . $data['content'][0]['author'] . " ,</span>";
			$page_content .= "Category : <span class='post_ti'> " . $category['page_name'] . " </span>	";
			$page_content .= "</div>";
			$page_content .= "</div>";


			//$page_content.="<div class='post-details'>Date of publication: ".date('d-m-Y H:i:s',strtotime($data['content'][0]['ts']))." Category : ".$category['page_name']." Updated by: ".$data['content'][0]['author']."</div>"; 
		}
		 //print_r($page_content);
		// exit;
		// adding base url to link in content



		$i = 1;

		/* print_r($data['sidebar_list']);
	  exit;*/
		//print_r($data['layoutwidgets']);


		foreach ($data['sidebar_list'] as $key => $val) {

			if ($themeLayoutId == 1) {
				//print_r($val);exit;

				if ($val['layout_id'] == '4') {
					$data['layout_list'][$i]['content'] = "<div id='print_divv '><div class='inner_txt'>" . $page_content . "</div></div>";
					$data['layout_list'][$i]['code'] = $val->code;
				} else {
					if ($val['layout_id'] == '1') {
						if ($i == 1) {
							/** if we have multiple widgets in section 
							 * we have to add all widget to content 
							 * */
							foreach ($data['layoutwidgets'][1] as $index => $indexvalue) {
								$sidebardata .= $indexvalue;
							}
							//$data['layout_list'][$i]['content']=$data['layoutwidgets'][1][0];
							$data['layout_list'][$i]['content'] = $sidebardata;;
							$data['layout_list'][$i]['code'] = $val['code'];
						} else {
							$data['layout_list'][$i]['content'] = "<div id='print_divv'><div class='inner_txt'>" . $page_content . "</div></div>";
							$data['layout_list'][$i]['code'] = $val['code'];
						}
					} else if ($val['layout_id'] == '2') {

						if ($i == 1) {
							foreach ($data['layoutwidgets'][3] as $index => $indexvalue) {
								$sidebardata .= $indexvalue;
							}

							$data['layout_list'][$i]['content'] = $sidebardata;
							$data['layout_list'][$i]['code'] = $val['code'];
						} else {
							$data['layout_list'][$i]['content'] = "<div id='print_divv'><div class='inner_txt'>" . $page_content . "</div></div>";
							$data['layout_list'][$i]['code'] = $val['code'];
						}
					} else if ($val['layout_id'] == '3') {

						if ($i == 1) {
							//$data['layout_list'][$i]['content']=$data['layoutwidgets'][1][0];
							$content1 = "";
							foreach ($data['layoutwidgets'][1] as $key => $val2) {
								$content1 .= $val2;
							}
							$data['layout_list'][$i]['content'] = $content1;
							$data['layout_list'][$i]['code'] = $val['code'];
						} else if ($i == 2) {
							$data['layout_list'][$i]['content'] = "<div id='print_divv'><div class='inner_txt'>" . $page_content . "</div></div>";
							$data['layout_list'][$i]['code'] = $val['code'];
						} else {


							$content3 = "";
							foreach ($data['layoutwidgets'][3] as $key => $val2) {
								$content3 .= $val2;
							}


							$data['layout_list'][$i]['content'] = $content3;
							$data['layout_list'][$i]['code'] = $val['code'];
						}
					}
				}
			}
			$i++;
		}

	//	print_r($data['layout_list']);exit;





		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId);
		$data['customepagelayouts'] = $this->MenuModel->getLayout($params);
		$data['pagesidebarid'] = 1;
		$params = array('ulbid' => $ulbid, 'controller' => $page);

		$page_name = $this->MenuModel->getPagename($params);


		// if pagename not found setting controller name as page name

		if (count($page_name) <= 0) {

			$page_name['page_name'] = str_replace("-", " ", $this->uri->segment(2));
		}


		$arr = explode(",", $data['ulbinfo'][0]->title); /// page title here 
		//echo $data['ulbinfo'][0]->ulbname." ".$data['ulbinfo'][0]->ulb_type_desc;
		//$title=$arr[0];

		$data['title'] = $page_name['page_name'] . ", " . $data['ulbinfo'][0]->ulb_type_desc;
		$params = array('ulbid' => $ulbid, 'page_id' => $page_name['page_id']);
		$breadcrumbs_submenus = $this->MenuModel->getBreadcrumbsSubmenus($params);

		$breadCrumbcount = count($breadcrumbs_submenus);








		//$this->breadcrumbs->add('Spring Tutorial', base_url().'tutorials/spring-tutorials');
		if ($page == 'search') {
		} else {

			for ($i = $breadCrumbcount; $i > 0; $i--) {


				if ($breadcrumbs_submenus[$i]['is_custumlink'] == '1') {
					$controller = $breadcrumbs_submenus[$i]['site_controller'];
				} else {
					$controller = base_url() . $breadcrumbs_submenus[$i]['site_controller'];
				}


				if ($breadcrumbs_submenus[$i]['site_controller'] === '' || $breadcrumbs_submenus[$i]['site_controller'] === '#') {
					$controller = base_url() . $ulbid . "/home-page";
				}
				$target = "''";
				if ($breadcrumbs_submenus[$i]['is_target_blank'] == '2') {
					$target = "_blank";
				}
				$class = "''";
				if ($breadcrumbs_submenus[$i]['is_alert'] == '1') {
					$class = "confirmation";
				}



				$this->breadcrumbs->add($breadcrumbs_submenus[$i]['page_name'], $controller, $target, $class);
			}



			$data['breadcrumbs'] = $this->breadcrumbs->render();
		}

		// $themeLayoutId=1;
		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId, 'flag' => 1);

		$layoutwidgets = $this->MenuModel->getLayout($params);
		//echo $this->db->last_query(); exit;
		$layouts = array();
		foreach ($layoutwidgets->result() as $key => $val) {
			$layouts[$val->page_layout_id] = $val->page_layout_desc;
		}

		//print_r($layouts);

		$data['layoutwidgets'] = $this->Themeonelayoutwidgets->getLayoutwidgets($layouts, $ulbid, $langId = $this->session->userdata('lang_Id'), '', '');
		//  	  print_r($data['layoutwidgets']);
		// 	  exit;



		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId, 'flag' => 1);
		//$paramsWhereIn=array(10,11);
		// $data['customepagelayouts']=$this->MenuModel->getLayout($params);
		$data['customepagelayouts'] = $this->MenuModel->getLayout_custom($params);
		// echo $this->db->last_query(); exit;
		//////////////chaitanya//////

		$data['applymenu'] = $this->MenuModel->all_records('apply_now_menu', array('status' => 'Enable'));
		
	/* 	foreach($data['mainmenus'] as $key=>$value){			
		 	if(in_array($key,[5026,5016])){
				$serviceId=$key;
				break;
			} 
		} */
		
		foreach($data['mainmenus'] as $key=>$value){			
		 	if(in_array($value['page_name'],['सेवा','services','Services'])){
				$serviceId=$key;
				break;
			} 
		}
		$data['bottom_services']=$data['submenus'][$serviceId];
		
		$data['bottom_services']=$data['submenus'][$serviceId];
		$data['language_id']=$this->session->userdata('lang_Id');

		$arraylng= array('lang_id' => $this->session->userdata('lang_Id'));
		$data['important_links']=$this->MenuModel->getImportantLinks($arraylng);	

//echo "<pre>";print_r($data['content'][0]['content']);echo "</pre>";die();		

		$this->load->view($theme . '/header2', $data);
		//	$this->load->view($theme.'/mainmenu',$data);

		$this->load->view($theme . '/custompage', $data);

		//$this->load->view($theme.'/footer');
		$this->load->view($theme . '/footerjs2', $data['theme']);
	}

	public function ajax_get_captcha()
	{

		$captcha_reload = $_POST['captcha_reload'];

		if ($captcha_reload == 'Realod') {
			$digits = '4';
			$i = 0;
			$pin = "";
			while ($i < $digits) {
				$pin .= mt_rand(0, 9);
				$i++;
			}
			echo  $pin;
		}
	}

	public function add_feedback()
	{

		if (isset($_POST['submit'])) {
			$ulbid = $this->input->post('ulbid');
			$currenturl = $this->input->post('currenturl');

			$this->CustomModel->add_feedback_from();



			$this->session->set_flashdata('message', "<div class='alert alert-success'>Feedback Inserted Successfully!!</div>");

			// $page=base_url().$ulbid."/feedback";
			redirect($currenturl);
		}
	}
public function getEncroachmentQueries()
	{
		
		$ip = $this->input->ip_address();
		
		$data['languages'] = array('1' => 'English', '2' => 'Marathi', '3' => 'Hindi', '4' => 'Urdu');
		$data['visitors_count'] = $this->MenuModel->getVisitorCount() +  156862;
		// $ulbid = $this->session->userdata('ulb_id');//$this->security->xss_clean($this->uri->segment('1'));
		$ulbid = 300;
		// get Townprofile details
		$params = array('ulbid' => $ulbid);
		//$data['townprofile_details'] = $this->MenuModel->getTownProfiledata($params);


		$this->breadcrumbs->add('Home', base_url(), '', '');
		$this->session->set_userdata('ulb_id', $ulbid);
		
		$lang = $this->input->cookie('lang');

		$this->session->set_userdata('lang_id', $lang);
		//echo $this->session->userdata('lang_Id');
		if (empty($lang) || $lang == 1) {

			$this->session->set_userdata('lang_Id', 1);
		} else {
			$this->session->set_userdata('lang_Id', 2);
		}

		$page = $this->security->xss_clean($this->uri->segment(1));

		$params = array('c.ulbid' => $ulbid, 'controller' => $page);

		$data['pageinfo'] = $this->MenuModel->getpageInfo($params);
		
		$is_common_page = $data['pageinfo'][0]->is_common_page;
		$left_menu_id = $data['pageinfo'][0]->menu_type_id;



		if ($data['pageinfo'][0]->is_draft == 1) {

			echo "<h1>Page not found</h1>";
			exit;
		}

		/**************************************************************************************** page info ************/
		$albumid = $this->input->get('q');


		$params = array('ulbid' => $ulbid, 'controller' => $page);



		$data['pageinformation'] = $this->pageInformation($params);


		$data['pageinfo'] = $this->MenuModel->getcustomPageInfo($params);


		$data['description'] = $data['pageinfo'][0]->meta_desc;
		$data['keywords'] = $data['pageinfo'][0]->pagekeywords;
		$data['subject'] = $data['pageinfo'][0]->meta_subject;

		$params = array('ulbid' => $ulbid);
		$data['ulbinfo'] = $this->MenuModel->getULBInfo($params);
		//print_r($data['ulbinfo']);

		$data['footertitle'] = $data['ulbinfo'][0]->ulbname . " " . $data['ulbinfo'][0]->ulb_type_desc;;

		$data['ulbnametelutu'] = $data['ulbinfo'][0]->ulbtelugu . " " . $data['ulbinfo'][0]->ulb_type_desctelugu;
		$data['ulbnameenglish'] = $data['ulbinfo'][0]->ulbname . " " . $data['ulbinfo'][0]->ulb_type_desc;
		$data['generalsettings'] = $this->MenuModel->getULBgeneralsettings($params);


		$data['logo'] = $data['generalsettings'][0]['file_path'];
		$data['logo_alt'] = $data['generalsettings'][0]['alt'];
		$data['logo_title'] = $data['generalsettings'][0]['title'];
		if ($data['generalsettings'][0]['file_path'] == '') {
			$data['feviicon'] = "assets/cdma/img/logo1.png";
		} else {
			$data['generalsettings'][0]['file_path'];
			$data['feviicon'] = $data['generalsettings'][0]['file_path'];
		}


		$data['ulbid'] = $ulbid;

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 1);
		$result = $this->Mylibrary->getMenus($params);
		$data['mainmenus'] = $result['mainmenu'][0];
		$data['submenus'] = $result['submenu'][0];
		$data['subsubmenus'] = $result['chilemenu'][0];

		/*** left menus **/

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 2);
		$result = $this->Mylibrary->getMenus($params);
		$data['leftmainmenus']['leftmainmenus'] = $result['mainmenu'][0];
		$data['leftsubmenus']['leftsubmenus'] = $result['submenu'][0];
		$data['leftsubsubmenus']['leftsubsubmenus'] = $result['chilemenu'][0];

		/** footer menus **/

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 3);
		$result = $this->Mylibrary->getMenus($params);
		$data['footermainmenus']['footermainmenus'] = $result['mainmenu'][0];
		$data['footerleftsubmenus']['footerleftsubmenus'] = $result['submenu'][0];
		$data['footerleftsubsubmenus']['footerleftsubsubmenus'] = $result['chilemenu'][0];

		$params = array('ulbid' => $ulbid, 'controller' => $page);

		if ($page == 'search') 
		{
			if ($this->input->post('search_keyword') != '') {

				$serackkeyname = $this->security->xss_clean(strip_tags(htmlspecialchars($this->input->post('search_keyword'))));

				$params = array('ulbid' => $ulbid, 'keyword' => $serackkeyname);
				$where = array('ulbid' => $ulbid);
				$searchContent = $this->CustomModel->getsearchData($params, $where);

				$content = "";

				if (empty($searchContent)) {
					$content = "<div class='alert alert-warning'>No result found . </div>";
				} else {

					$content = "<div class='alert alert-success mt-4 b-0 bg-warning'><b>Result Found</b> </div>";
				}

				foreach ($searchContent as $key => $val) {


					if ($val['is_custumlink'] == 1) {
						$url = $val['site_controller'];
					} else {
						$url = base_url() . $val['site_controller'];
					}
					$content .= "<div>";

					$content .= "<div><a href='" . $url . "' class='ser_link_tex' target='_blank' style='text-decoration:underline'><b> " . $val['page_name'] . " </b></a></div>";
					// $content.="<div class='ser_url'> <a href='".$url."' class='ser_url' target='_blank'>".$url."</a></div>";
					$content .= "<div class='ser_dectex'>" . substr(strip_tags(trim($val['content'])), 0, 200) . "</div>";
					$content .= "</div>";

					$content .= "<hr style='margin-top:10px; margin-bottom:10px;'>";
				}
			} else {
				$content = "<div class='alert alert-warning'>Your not supplied any input</div>";
			}


			$sidebarid = $data['content'][0]['page_sidebars_id'] = 4;
			$data['content'][0]['content'] = $content;
		} else {

			$data['content'] = $this->CustomModel->getpageData($params);


			//$data['content'][0]['content']=str_replace('/assets',base_url().'assets/',$data['content'][0]['content']);
			if ($data['content'][0]['page_sidebars_id'] >= 5) {
				$default_page_sidebar = $this->CustomModel->getpageSidebarId();
				$data['content'][0]['page_sidebars_id'] = $default_page_sidebar['superadmin_defautl_layout'];
			}
			$parameters = array('page_sidebars_id' => $data['content'][0]['page_sidebars_id']);

			if ($data['content']['is_code_page'] == '1') {

				$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 1);

				if ($data['content']['controller'] == 'sitemap') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getSitemap($params);

					// print_r($data['content'][0]['content']);
					//$data['content'][0]['content']=$this->Staticpagefunctions->getSitemap($params);
				} else if ($data['content']['controller'] == 'feedback') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getFeedbackform($ulbid);
				} else if ($data['content']['controller'] == 'feedback') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getFeedbackform($ulbid);
				} else if ($data['content']['controller'] == 'blood-donations') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getBloodDonationForm();
				} else if ($data['content']['controller'] == 'petetions') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getPetetionForm();
				} else if ($data['content']['controller'] == 'albums') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getAlbums($ulbid, $langid = 1);
				} else if ($data['content']['controller'] == 'faqs') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getFaqs($ulbid, $langid = 1);
				} else if ($data['content']['controller'] == 'gallery') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getGallery($albumid);
				} else if ($data['content']['controller'] == 'video-gallery') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getVidoGallery();
				} else if ($data['content']['controller'] == 'agenda-and-minutes') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getAgendaAndMinutes();
				} else if ($data['content']['controller'] == 'agenda-and-minutes-year') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getAgendaAndMinutesYears();
				} else if ($data['content']['controller'] == 'agenda-and-minutes-details') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getAgendaAndMinutesDetails();
				} else if ($data['content']['controller'] == 'know-your-property-tax') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getKnowYourPropertyTaxDetails();
				} else if ($data['content']['controller'] == 'complaint') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getComplaintDetails();
				} else if ($data['content']['controller'] == 'monthly') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getMonthlyDetails();
				} else if ($data['content']['controller'] == 'quarterly') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getQuarterlyDetails();
				} else if ($data['content']['controller'] == 'annual') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getAnnualDetails();
				} else if ($data['content']['controller'] == 'public-notices') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getPublicNotice($this->session->userdata('lang_Id'));
				} else if ($data['content']['controller'] == 'work-orders') {
					//echo $this->session->userdata('lang_Id');
					//exit;
					$data['content'][0]['content'] = $this->Staticpagefunctions->getWorkOrders($this->session->userdata('lang_Id'));
				} else if ($data['content']['controller'] == 'quotations') {
					$data['content'][0]['content'] = $this->Staticpagefunctions->getquotations($this->session->userdata('lang_Id'));
				} else if ($data['content']['controller'] == 'faq') {

					$data['content'][0]['content'] = $this->Staticpagefunctions->getFaq($this->session->userdata('lang_Id'));
				}


				/*************************************************************************************************************************************/
				// echo $sidebarid=$data['content'][0]['page_sidebars_id'];
				$sidebarid = $data['content']['page_sidebars_id'];

				//$this->breadcrumbs->add($data['content']['page_name'], $data['content']['site_controller'],$target,$class); 
			} else {

				//print_r($data['content']);
				$sidebarid = $data['content'][0]['page_sidebars_id'];
				// $sidebarid=$page_sidebars_id;
				$sidebarid = $sidebarid;
			}
		}

		$category_id = $this->uri->segment('3');

		// if requested page id is category getting all posts of that category


		if ($category_id != '') {
			//$params=array('category_id'=>$category_id);
			$params = array('site_controller' => $category_id);
			$category_name = $this->CustomModel->getCategoryName($params);
			// print_r($category_name);
			$params = array('category_id' => $category_name['page_id']);
			$posts = $this->CustomModel->getCategoryPosts($params);
			$category_content = "";
			$category_content .= "<h3>" . $category_name['page_name'] . "</h3><br>";
			foreach ($posts as $key => $val) {
				if ($val['is_custumlink'] == '1') {
					$base_url = "";
				} else {
					$base_url = base_url();
				}
				if ($val['is_target_blank'] == '2') {
					$target = "target='_blank'";
				} else {
					$target = "target=''";
				}
				if ($val['is_alert'] == '1') {
					$class = "class='confirmation'";
				} else {
					$class = "class=''";
				}

				$category_content .= "<div>";
				$category_content .= "<div class='col-md-12 note_style'>";
				$category_content .= "<div class='col-md-1 note_box'>";
				$category_content .= "<div class='note_circle'>";
				$category_content .= "<i class='fa fa-bell'></i>";
				$category_content .= "</div>";
				$category_content .= "</div>";
				$category_content .= "<div class='col-md-11 note_top'>";
				$category_content .= "<p><a href='" . $base_url . $val['site_controller'] . "' " . $target . " " . $class . ">" . $val['page_name'] . "</a></p>";
				$category_content .= "<div class='post-details'> Published on : <span class='post_ti'>" . date('d-m-Y H:i:s', strtotime($val['datetime'])) . "</span> , Posted by : <span class='post_ti'> " . $val['author'] . " </span></div>";
				$category_content .= "</div>";
				$category_content .= "</div>";
				$category_content .= "</div>";
			}


			$data['content'][0]['content'] = $category_content;
			$sidebarid = 1;

			if ($category_name['is_custumlink'] == '1') {
				$base_url = "";
			} else {
				$base_url = base_url();
			}
			if ($category_name['is_target_blank'] == '2') {
				$target = "target='_blank'";
			} else {
				$target = "target=''";
			}
			if ($category_name['is_alert'] == '1') {
				$class = "class='confirmation'";
			} else {
				$class = "class=''";
			}

			$this->breadcrumbs->add($category_name['page_name'], $base_url . $ulbid . "/" . $category_name['site_controller'], $target, $class);
		}

		//echo $data['content'][0]['content'];

		$album_id = $this->uri->segment('4');
		if (is_numeric($album_id)) {
			$data['content'][0]['content'] = $this->Staticpagefunctions->getAlbumPhotos($album_id);
			$album_name = $this->Staticpagefunctions->getAlbumName($album_id);


			$this->breadcrumbs->add('Phot gallery', $base_url . $ulbid . "/albums", $target, $class);
			$this->breadcrumbs->add($album_name[0]['album_desc'], $base_url . $ulbid . "/albums/photos", 1, $class);
		}

		$params_sidebar = array('layout_id' => $sidebarid);


		$data['sidebar_list'] = $this->CustomModel->sidebar_list($params_sidebar);

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'));
		$data['headerNews'] = $this->MenuModel->getHeaderNews($params);

		$params = array('ulbid' => $ulbid);
		$themefolder = $this->MenuModel->getthemefolder($params); // selecting ulb mapped theme
		$theme = $themefolder[0]['folder'];
		$data['theme'] = $themefolder[0]['folder'];
		$themeLayoutId = $themefolder[0]['theme_id'];



		$params = array('theme_layout_id' => $themeLayoutId);
		$layoutwidgets = $this->MenuModel->getLayout_innerpage($params);
		$layouts = array();
		foreach ($layoutwidgets->result() as $key => $val) {
			$layouts[$val->page_layout_id] = $val->page_layout_desc;
		}



		$data['layoutwidgets'] = $this->Themeonelayoutwidgets->getLayoutwidgets($layouts, $ulbid, $langId = $this->session->userdata('lang_Id'), $is_common_page, $left_menu_id);
		//print_r($data['layoutwidgets']);

		$params = array('ulbid' => $this->session->userdata('ulb_id'), 'theme_layout_id' => $themeLayoutId, 'flag' => 1);
		$data['customepagelayouts'] = $this->MenuModel->getLayout($params);

		//print_r($data['customepagelayouts']);
		//exit;

		//$page_content="<div><h3>".$data['content'][0]['page_name']."</h3><br></div>";

		// text replacing with short codes here
		/*echo "<pre>";
	    print_r($data['customepagelayouts']);
		exit;*/


		$page_content .= str_replace('{municipality}', $data['ulbnameenglish'], $data['content'][0]['content']);
		$page_content = str_replace('{feedbackform}', $this->Staticpagefunctions->getFeedbackform($ulbid), $page_content);



		if ($data['content'][0]['is_custumlink'] == '2') {


			$category = $this->MenuModel->category_name($data['content'][0]['page_id']);
			$page_content .= "<div>";
			$page_content .= "<hr class='post-hr'>";
			$page_content .= "<div class='post-details'> ";
			$page_content .= "Published on : <span class='post_ti'>" . date('d-m-Y H:i:s', strtotime($data['content'][0]['datetime'])) . "</span>,";
			$page_content .= "Posted by : <span class='post_ti'> " . $data['content'][0]['author'] . " ,</span>";
			$page_content .= "Category : <span class='post_ti'> " . $category['page_name'] . " </span>	";
			$page_content .= "</div>";
			$page_content .= "</div>";


			//$page_content.="<div class='post-details'>Date of publication: ".date('d-m-Y H:i:s',strtotime($data['content'][0]['ts']))." Category : ".$category['page_name']." Updated by: ".$data['content'][0]['author']."</div>"; 
		}
		// print_r($page_content);
		// exit;
		// adding base url to link in content



		$i = 1;

		/* print_r($data['sidebar_list']);
	  exit;*/
		//print_r($data['layoutwidgets']);


		foreach ($data['sidebar_list'] as $key => $val) {

			if ($themeLayoutId == 1) {
				//print_r($val);exit;

				if ($val['layout_id'] == '4') {
					$data['layout_list'][$i]['content'] = "<div id='print_divv '><div class='inner_txt'>" . $page_content . "</div></div>";
					$data['layout_list'][$i]['code'] = $val->code;
				} else {
					if ($val['layout_id'] == '1') {
						if ($i == 1) {
							/** if we have multiple widgets in section 
							 * we have to add all widget to content 
							 * */
							foreach ($data['layoutwidgets'][1] as $index => $indexvalue) {
								$sidebardata .= $indexvalue;
							}
							//$data['layout_list'][$i]['content']=$data['layoutwidgets'][1][0];
							$data['layout_list'][$i]['content'] = $sidebardata;;
							$data['layout_list'][$i]['code'] = $val['code'];
						} else {
							$data['layout_list'][$i]['content'] = "<div id='print_divv'><div class='inner_txt'>" . $page_content . "</div></div>";
							$data['layout_list'][$i]['code'] = $val['code'];
						}
					} else if ($val['layout_id'] == '2') {

						if ($i == 1) {
							foreach ($data['layoutwidgets'][3] as $index => $indexvalue) {
								$sidebardata .= $indexvalue;
							}

							$data['layout_list'][$i]['content'] = $sidebardata;
							$data['layout_list'][$i]['code'] = $val['code'];
						} else {
							$data['layout_list'][$i]['content'] = "<div id='print_divv'><div class='inner_txt'>" . $page_content . "</div></div>";
							$data['layout_list'][$i]['code'] = $val['code'];
						}
					} else if ($val['layout_id'] == '3') {

						if ($i == 1) {
							//$data['layout_list'][$i]['content']=$data['layoutwidgets'][1][0];
							$content1 = "";
							foreach ($data['layoutwidgets'][1] as $key => $val2) {
								$content1 .= $val2;
							}
							$data['layout_list'][$i]['content'] = $content1;
							$data['layout_list'][$i]['code'] = $val['code'];
						} else if ($i == 2) {
							$data['layout_list'][$i]['content'] = "<div id='print_divv'><div class='inner_txt'>" . $page_content . "</div></div>";
							$data['layout_list'][$i]['code'] = $val['code'];
						} else {


							$content3 = "";
							foreach ($data['layoutwidgets'][3] as $key => $val2) {
								$content3 .= $val2;
							}


							$data['layout_list'][$i]['content'] = $content3;
							$data['layout_list'][$i]['code'] = $val['code'];
						}
					}
				}
			}
			$i++;
		}

		//print_r($data['layout_list']);exit;

		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId);
		$data['customepagelayouts'] = $this->MenuModel->getLayout($params);
		$data['pagesidebarid'] = 1;
		$params = array('ulbid' => $ulbid, 'controller' => $page);

		$page_name = $this->MenuModel->getPagename($params);


		// if pagename not found setting controller name as page name

		if (count($page_name) <= 0) {

			$page_name['page_name'] = str_replace("-", " ", $this->uri->segment(2));
		}


		$arr = explode(",", $data['ulbinfo'][0]->title); /// page title here 
		//echo $data['ulbinfo'][0]->ulbname." ".$data['ulbinfo'][0]->ulb_type_desc;
		//$title=$arr[0];

		$data['title'] = $page_name['page_name'] . ", " . $data['ulbinfo'][0]->ulb_type_desc;
		$params = array('ulbid' => $ulbid, 'page_id' => $page_name['page_id']);
		$breadcrumbs_submenus = $this->MenuModel->getBreadcrumbsSubmenus($params);

		$breadCrumbcount = count($breadcrumbs_submenus);

		//$this->breadcrumbs->add('Spring Tutorial', base_url().'tutorials/spring-tutorials');
		if ($page == 'search') {
		} else {

			for ($i = $breadCrumbcount; $i > 0; $i--) {


				if ($breadcrumbs_submenus[$i]['is_custumlink'] == '1') {
					$controller = $breadcrumbs_submenus[$i]['site_controller'];
				} else {
					$controller = base_url() . $breadcrumbs_submenus[$i]['site_controller'];
				}


				if ($breadcrumbs_submenus[$i]['site_controller'] === '' || $breadcrumbs_submenus[$i]['site_controller'] === '#') {
					$controller = base_url() . $ulbid . "/home-page";
				}
				$target = "''";
				if ($breadcrumbs_submenus[$i]['is_target_blank'] == '2') {
					$target = "_blank";
				}
				$class = "''";
				if ($breadcrumbs_submenus[$i]['is_alert'] == '1') {
					$class = "confirmation";
				}



				$this->breadcrumbs->add($breadcrumbs_submenus[$i]['page_name'], $controller, $target, $class);
			}



			$data['breadcrumbs'] = $this->breadcrumbs->render();
		}

		// $themeLayoutId=1;
		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId, 'flag' => 1);

		$layoutwidgets = $this->MenuModel->getLayout($params);
		//echo $this->db->last_query(); exit;
		$layouts = array();
		foreach ($layoutwidgets->result() as $key => $val) {
			$layouts[$val->page_layout_id] = $val->page_layout_desc;
		}

		//print_r($layouts);

		$data['layoutwidgets'] = $this->Themeonelayoutwidgets->getLayoutwidgets($layouts, $ulbid, $langId = $this->session->userdata('lang_Id'), '', '');
		//  	  print_r($data['layoutwidgets']);
		// 	  exit;



		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId, 'flag' => 1);
		//$paramsWhereIn=array(10,11);
		// $data['customepagelayouts']=$this->MenuModel->getLayout($params);
		$data['customepagelayouts'] = $this->MenuModel->getLayout_custom($params);
		// echo $this->db->last_query(); exit;
		//////////////chaitanya//////

		$data['applymenu'] = $this->MenuModel->all_records('apply_now_menu', array('status' => 'Enable'));
		
		foreach($data['mainmenus'] as $key=>$value){			
		 	if(in_array($value['page_name'],['services','Services'])){
				$serviceId=$key;
				break;
			} 
		}
		
		$data['bottom_services']=$data['submenus'][$serviceId];
		
		//$arraylng= array('lang_id' => $this->session->userdata('lang_Id'));
		//$data['important_links']=$this->MenuModel->getImportantLinks($arraylng);	
		
		$data['encroachment_queries']=$this->CustomModel->getEncQueries();
		
		$data['language_id']=$this->session->userdata('lang_Id');

	/* 	foreach($data['encroachment_queries'] as $key=>$value){
		foreach($data['encroachment_queries'][$key]['queries'] as $key2=>$value2){
			echo "<pre>";print_r($data['encroachment_queries'][$key]['queries'][$key2]['created_at']);echo "</pre>";
		}
		}die(); */
//echo "<pre>";print_r($data['encroachment_queries'][0]['queries'][0]['created_at']);echo "</pre>";die();
		

		$this->load->view($theme . '/header2', $data);
		//	$this->load->view($theme.'/mainmenu',$data);

		$this->load->view($theme . '/encroachment_queries', $data);

		//$this->load->view($theme.'/footer');
		$this->load->view($theme . '/footerjs2', $data['theme']);
	}
}
