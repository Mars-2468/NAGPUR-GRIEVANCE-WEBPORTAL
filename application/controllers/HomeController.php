<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 1);

class HomeController extends CI_Controller
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
		$this->load->library('Mylibrary');
		$this->load->library('Themeonelayoutwidgets');
		$this->load->helper('email_send');
		$this->Mylibrary = new Mylibrary();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->Themeonelayoutwidgets = new Themeonelayoutwidgets();
		//  $this->load->helper('cookie');
		$this->load->helper('url');
		$headers = getallheaders();
		$this->load->helper('cookie');

		// Delete cookies by setting them to expire
		delete_cookie('acceptcookiefreecounterstat');
		delete_cookie('counter');
		delete_cookie('counter_nv');
		delete_cookie('acceptcookie');
		delete_cookie('ci_session');

		// Delay for a short period to allow the browser to receive the response
		sleep(1);
	$this->output->set_header('Cache-Control: max-age=3600');
    $this->output->set_header('Pragma: public');
		// echo 'Cookies removed!';
		// print_r($headers);exit;	

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
		
		// $langid = $this->input->post('langid');
		$langid =	$this->uri->segment(3);

		$this->session->set_userdata('lang_Id', $langid);

		$my_cookie = array(

			'name'   => 'lang',
			'value'  => $langid,
			'expire' => '300000',
			'secure' => TRUE

		);
		
		$this->input->set_cookie($my_cookie);

		redirect('/');

		/* if($this->session->userdata('lang_Id')=='1')
	     {
	         $this->session->unset_userdata('lang_Id');
	         $this->session->unset_userdata('langtext');
	         $this->session->set_userdata('lang_Id','2');         
	         
	     }
	     else
	     {
	         $this->session->unset_userdata('lang_Id');
	         $this->session->unset_userdata('langtext');
	         $this->session->set_userdata('lang_Id','1');
	         
	     }*/
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

	public function getWidgetData($widget_id)
	{

		$params = array('widget_id' => $widget_id);
		$result = $this->MenuModel->getWidgetData($params);
		//print_r($result);
		$widget_type = $result[0]['widget_type'];
		$params = array('widget_id' => $widget_id, 'widget_type' => $widget_type, 'ulbid' => $this->session->userdata('ulb_id'), 'langId' => $this->session->userdata('lang_Id'), 'uri' => $this->uri->segment('1'));
		//echo $url =  $this->uri->segment('1');exit;
		$result = $this->Themeonelayoutwidgets->getIndwidgetdata($params, '', '', '');

		return $result;
	}

	/***** close ****/
	public function index()
	{


		//echo "<pre>";print_r($this->input->cookie('lang')); echo "</pre>"; die();
		
		
		$this->session->unset_userdata('color');
		$ip = $this->input->ip_address();
		$this->session->unset_userdata('counter');
	
		// 		$data['languages'] = array('1'=>'English','2'=>'Marathi','3'=>'Hindi','4'=>'Urdu');
		$data['languages'] = array('1' => 'English', '2' => 'Marathi');
	
		$ulbid = 300;
		if ($ulbid == '') {
			die('Invalid url');
		}
		$params = array('ulbid' => $ulbid);

		// visitor count

		$vcount = $this->MenuModel->getVisitCountDB();
		//print_r($vcount);
		//exit;

		$vcountinc = $vcount + 1;

		$this->MenuModel->updateVisitCountDB($vcountinc);

		$data['visitor_counter'] = str_pad($vcount, 8, '0', STR_PAD_LEFT);

		$this->session->unset_userdata('onlineservice_widget_count');

		// get Townprofile details
		$params = array('ulbid' => $ulbid);
		$data['townprofile_details'] = $this->MenuModel->getTownProfiledata($params);

//print_r( empty($this->input->cookie('lang')));
//exit;
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

		$this->session->set_userdata('ulb_id', $ulbid);
		
		
		$params = array('ulbid' => $ulbid);
		$data['ulbinfo'] = $this->MenuModel->getULBInfo($params);

		$data['description'] = $data['ulbinfo'][0]->description;
		$data['keywords'] = $data['ulbinfo'][0]->keywords;
		$data['subject'] = $data['ulbinfo'][0]->subject;
		$data['title'] = $data['ulbinfo'][0]->ulb_type_desc;
		$data['ulbnametelutu'] = $data['ulbinfo'][0]->ulbtelugu . " " . $data['ulbinfo'][0]->ulb_type_desctelugu;
		$data['ulbnameenglish'] = $data['ulbinfo'][0]->ulbname . " " . $data['ulbinfo'][0]->ulb_type_desc;
		$data['base_url'] = $data['ulbinfo'][0]->base_url;

		$data['generalsettings'] = $this->MenuModel->getULBgeneralsettings($params);
		//exit;

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

//var_dump($this->session->userdata());die();

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 1);
		$result = $this->Mylibrary->getMenus($params);
		
		$data['mainmenus'] = $result['mainmenu'][0];
		$data['submenus'] = $result['submenu'][0];
		$data['subsubmenus'] = $result['chilemenu'][0];

//echo "<pre>";print_r($data['submenus'] );echo "</pre>";die();	
		/*** left menus **/

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 2);
		$result = $this->Mylibrary->getMenus($params);
		$data['leftmainmenus']['leftmainmenus'] = $result['mainmenu'][0];
		$data['leftsubmenus']['leftsubmenus'] = $result['submenu'][0];
		$data['leftsubsubmenus']['leftsubsubmenus'] = $result['chilemenu'][0];

		//print_r($data['leftsubmenus']['leftsubmenus']);

		/** footer menus **/

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 3);
		$result = $this->Mylibrary->getMenus($params);
		$data['footermainmenus']['footermainmenus'] = $result['mainmenu'][0];
		$data['footerleftsubmenus']['footerleftsubmenus'] = $result['submenu'][0];
		$data['footerleftsubsubmenus']['footerleftsubsubmenus'] = $result['chilemenu'][0];

		/** end **/
		// news information

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'));
		$data['headerNews'] = $this->MenuModel->getHeaderNews($params);
		//print_r($params);
		$data['sliderdata']['sliderdata'] = $this->MenuModel->getsliderdata($params);
		$params = array('ulbid' => $ulbid);
		$themefolder = $this->MenuModel->getthemefolder($params); // selecting ulb mapped theme
		$theme = $themefolder[0]['folder'];
		$data['theme'] = $themefolder[0]['folder'];
		$themeLayoutId = $themefolder[0]['theme_id'];

//echo "<pre>";print_r($data['submenus']);echo "</pre>";die();

		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId, 'flag' => 1);
		$layoutwidgets = $this->MenuModel->getLayout($params);
		$layouts = array();
		foreach ($layoutwidgets->result() as $key => $val) {
			$layouts[$val->page_layout_id] = $val->page_layout_desc;
		}

		//print_r($layouts);

		$data['layoutwidgets'] = $this->Themeonelayoutwidgets->getLayoutwidgets($layouts, $ulbid, $langId = $this->session->userdata('lang_Id'), '', '');
		
		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId, 'flag' => 1);
		$data['customepagelayouts'] = $this->MenuModel->getLayout($params);

		/** get slider details **/
		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'));

		$data['sliderposts'] = $this->MenuModel->getSliderPosts($params);

		/** close **/

		$data['tabsContent'] = $this->MenuModel->all_records('custom_menus', array('tabs_status' => 1));
		$data['applymenu'] = $this->MenuModel->all_records('apply_now_menu', array('status' => 'Enable'));
		$data['membersDTL'] = $this->MenuModel->all_prioritized_records('testimonials', array('category' => 2, 'status' => 'Enable'));
		
		$style = "7"; ////////////statically calling the 7 th widget (ministers)////
		$data['ministers'] = $this->MenuModel->getStaticSingleWidget($style);
		$style = "8"; ////////////statically calling the 8 th widget (marquee)////
		$data['marquee'] = $this->MenuModel->getStaticSingleWidget($style);

//echo "<pre>";print_r(empty($data['sliderposts']) );echo "</pre>";die();	
	
		$data['slides']=!empty($data['sliderposts'])?$data['sliderposts']->result_array():null;
		
		
		$data['language_id']=$this->session->userdata('lang_Id');
		
		$data['visitors_count'] = $this->MenuModel->getVisitCountDB();
		
//echo "<pre>";print_r($data['layoutwidgets'][4][0] );echo "</pre>";die();	
		
		
		foreach($data['mainmenus'] as $key=>$value){			
		 	if(in_array($value['page_name'],['सेवा','services','Services'])){
				$serviceId=$key;
				break;
			} 
		}
		$data['bottom_services']=$data['submenus'][$serviceId];
		

		
		
		/*  foreach($data['mainmenus'] as $key=>$value){			
		 	if(in_array($key,[5029,5016])){
				$serviceId=$key;
				break;
			} 
		}
		$data['bottom_services']=$data['submenus'][$serviceId];  */
		
		//echo "<pre>";print_r($data['submenus'] );echo "</pre>";die();	

		$arraylng= array('lang_id' => $this->session->userdata('lang_Id'));
		$data['important_links']=$this->MenuModel->getImportantLinks($arraylng);		
		$data['social_links']=$this->MenuModel->getSocialMediaLinks();
		$this->load->view($theme . '/header', $data);		
		$this->load->view($theme . '/home', $data);
		$this->load->view($theme . '/footerjs', $data['theme']);
	}


	public function testslider()
	{
		$params = array(
			'ip_address' => $this->input->ip_address(),
			'url' => base_url(),
			'date' => date('Y-m-d'),
			'ts' => date('Y-m-d H:i:s')
		);

		$this->MenuModel->insertVisitor($params);
		$data['visitors_count'] = $this->MenuModel->getVisitorCount() +  156862;

		$ulbid = 300;
		if ($ulbid == '') {
			die('Invalid url');
		}
		$params = array('ulbid' => $ulbid);

		$this->session->unset_userdata('onlineservice_widget_count');

		// get Townprofile details
		$params = array('ulbid' => $ulbid);
		$data['townprofile_details'] = $this->MenuModel->getTownProfiledata($params);


		if (!$this->session->userdata('lang_Id')) {

			$this->session->set_userdata('lang_Id', 1);
			$this->session->set_userdata('langtext', ' à°¤à±†à°²à±à°—à±');
		}



		$this->session->set_userdata('ulb_id', $ulbid);
		$params = array('ulbid' => $ulbid);
		$data['ulbinfo'] = $this->MenuModel->getULBInfo($params);
		//print_r($data['ulbinfo']);
		// $data['ulbinfo']=$this->CommonData->getULBInfo($params);
		$data['description'] = $data['ulbinfo'][0]->description;
		$data['keywords'] = $data['ulbinfo'][0]->keywords;
		$data['subject'] = $data['ulbinfo'][0]->subject;
		$data['title'] = $data['ulbinfo'][0]->ulb_type_desc;
		$data['ulbnametelutu'] = $data['ulbinfo'][0]->ulbtelugu . " " . $data['ulbinfo'][0]->ulb_type_desctelugu;
		$data['ulbnameenglish'] = $data['ulbinfo'][0]->ulbname . " " . $data['ulbinfo'][0]->ulb_type_desc;
		$data['base_url'] = $data['ulbinfo'][0]->base_url;

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
		//$data['ulbid']['ulbid']=$ulbid;

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


		//print_r($data['leftsubmenus']['leftsubmenus']);




		/** footer menus **/

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 3);
		$result = $this->Mylibrary->getMenus($params);
		$data['footermainmenus']['footermainmenus'] = $result['mainmenu'][0];
		$data['footerleftsubmenus']['footerleftsubmenus'] = $result['submenu'][0];
		$data['footerleftsubsubmenus']['footerleftsubsubmenus'] = $result['chilemenu'][0];


		/** end **/
		// news information


		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'));
		$data['headerNews'] = $this->MenuModel->getHeaderNews($params);
		//print_r($params);
		$data['sliderdata']['sliderdata'] = $this->MenuModel->getsliderdata($params);
		$params = array('ulbid' => $ulbid);
		$themefolder = $this->MenuModel->getthemefolder($params); // selecting ulb mapped theme
		$theme = $themefolder[0]['folder'];
		$data['theme'] = $themefolder[0]['folder'];
		$themeLayoutId = $themefolder[0]['theme_id'];


		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId, 'flag' => 1);
		$layoutwidgets = $this->MenuModel->getLayout($params);
		$layouts = array();
		foreach ($layoutwidgets->result() as $key => $val) {
			$layouts[$val->page_layout_id] = $val->page_layout_desc;
		}

		// print_r($layouts);

		$data['layoutwidgets'] = $this->Themeonelayoutwidgets->getLayoutwidgets($layouts, $ulbid, $langId = $this->session->userdata('lang_Id'), '', '');
		// 	  print_r($data['layoutwidgets']);
		// 	  exit;



		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId, 'flag' => 1);
		$data['customepagelayouts'] = $this->MenuModel->getLayout($params);

		/** get slider details **/
		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'));
		$data['sliderposts'] = $this->MenuModel->getSliderPosts($params);

		/** close **/

		$data['tabsContent'] = $this->MenuModel->all_records('custom_menus', array('tabs_status' => 1));
		$data['applymenu'] = $this->MenuModel->all_records('apply_now_menu', array('status' => 'Enable'));
		//echo $this->db->last_query();
		$this->load->view($theme . '/testslider', $data);
	}

	public function sendMail()
	{
		$email = $this->input->get('email');

		$subject = 'Subscribe to ISKCON Portland';
		$body = '
	            <!doctype html>
                <html>
                	<head>
                	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                		
                		<title>Untitled Document</title>
                		
                		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,900" rel="stylesheet">
                		
                		<style>
                			
                			body{
                			font-size: 14px;
                			font-family: "Source Sans Pro", sans-serif;
                			}
                		</style>
                		
                	</head>
                	
                	<body>
                		<table width="600">
                			<tr>
                				<td>Hare Krishna,</td>
                			</tr>
                			<tr>
                			    <td></td>
                			</tr>
                			<tr>
                				<td>Please enroll me to the ISKCON Portland temple wide mailing list.</td>
                			</tr>
                			<tr>
                			    <td></td>
                			</tr>
                			<tr>
                				<td>Here is my email: ' . $email . '</td>
                			</tr>
                			<tr>
                			    <td></td>
                			</tr>
                			<tr>
                				<td>Thank you</td>
                			</tr>
                		</table>
                	</body>
                </html>';
		$protected_methods = get_email_details($subject, $body, '', '', '');
		echo json_encode($protected_methods);
	}
	public function VisitorsCounter()
	{
		$ip = $this->input->ip_address();
		$check = $this->MenuModel->count('tbl_visitors_counter', array('ip_address' => $ip)); //check ip address
		if ($check) {
		} else {
			$params = array('ip_address' => $ip);
			$insert = $this->MenuModel->insert('tbl_visitors_counter', $params); //  insert 
		}
	}
	public function GetSchemaCategory()
	{
		$category = htmlspecialchars(strip_tags($this->input->post('schema')));

		if ($category) {
			$result = $this->MenuModel->all_by_array('tbl_agenda_mst', array('category_id' => $category)); // all dependency 
			//echo $this->db->last_query();exit;
			echo json_encode($result); // return response array as array
		} else {
			echo json_encode(array()); // return response array as array
		}
	}
	public function ComplaintDetails()
	{
		if ($this->input->post('submit')) // if form submit
		{
			// validatiom 
			$this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
			$this->form_validation->set_rules('subcategory', 'Sub Category', 'trim|required|xss_clean');
			$this->form_validation->set_rules('name', 'name', 'regex_match[/^[a-zA-Z0-9 .]+$/u]|trim|required|xss_clean');
			$this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]|xss_clean');
			$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('details', 'Details', 'trim|required|xss_clean');
			// validatiom 
			if ($this->form_validation->run() == TRUE) // if validatiom true
			{
				$category = htmlspecialchars(strip_tags(xss_clean($this->input->post('category'))));
				$subcategory = htmlspecialchars(strip_tags(xss_clean($this->input->post('subcategory'))));
				$name = htmlspecialchars(strip_tags(xss_clean($this->input->post('name'))));
				$mobile = htmlspecialchars(strip_tags(xss_clean($this->input->post('mobile'))));
				$email_address = htmlspecialchars(strip_tags(xss_clean($this->input->post('email_address'))));
				$details = htmlspecialchars(strip_tags(xss_clean($this->input->post('details'))));


				$recaptchaResponse = trim(xss_clean($this->input->post('g-recaptcha-response')));

				$userIp = $this->input->ip_address();

				$secret = $this->config->item('google_secret');

				$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptchaResponse . "&remoteip=" . $userIp;

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$output = curl_exec($ch);
				curl_close($ch);

				$status = json_decode($output, true);
				//$status['success']=1;
				if ($status['success']) {
					$fileUpload = $_FILES['userfile']['name'];

					if ($this->input->post('userfile')) {
						$this->load->library('upload');
						$dataInfo = array();
						$files = $_FILES;
						$cpt = count($_FILES['userfile']['name']);
						$imgg = array();
						for ($i = 0; $i < $cpt; $i++) {



							$_FILES['userfile']['name'] = $files['userfile']['name'][$i];
							$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
							$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
							$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
							$_FILES['userfile']['size'] = $files['userfile']['size'][$i];

							$this->upload->initialize($this->set_upload_options());
							$this->upload->do_upload('userfile');
							$dataInfo[] = $this->upload->data();


							/** checking for malicious file upload **/
							$file_info = new finfo(FILEINFO_MIME_TYPE);
							$mime_types_array = array('image/jpg', 'image/jpeg', 'image/png');
							$finopath = $target_file;
							$a = getimagesize($dataInfo[$i]['full_path']);


							$filename = date('YmdHis') . rand(999, 100000) . ".jpg";





							$mime_type = $file_info->buffer(file_get_contents($dataInfo[$i]['full_path']));

							if (!in_array($mime_type, $mime_types_array)) {
								unlink($dataInfo[$i]['full_path']);
								die('Invalid file type');
							} else {
								$src_file = $dataInfo[$i]['full_path'];
								$dest_file = './assets/complaint_files/' . $filename;
								$img_quality = 70;
								header('Content-Type: image/png');
								$im = imagecreatefromstring(file_get_contents($src_file));
								$im_w = imagesx($im);
								$im_h = imagesy($im);
								$tn = imagecreatetruecolor($im_w, $im_h);
								imagecopyresampled($tn, $im, 0, 0, 0, 0, $im_w, $im_h, $im_w, $im_h);
								imagejpeg($tn, $dest_file, $img_quality);

								array_push($imgg, $filename);
								unlink($dataInfo[$i]['full_path']);
							}

							/** close **/
						}
					}
					//print_r($imgg);exit;
					if (!empty($imgg)) {
						$attachment = implode(',', $imgg);
					} else {
						$attachment = NULL;
					}

					$insertArray = array(
						'category' => $category,
						'sub_category' => $subcategory,
						'name' => $name,
						'mobile' => $mobile,
						'email_address' => $email_address,
						'details' => $details,
						'attachment' => $attachment
					);
					$insert = $this->MenuModel->insert('tbl_complaint_details', $insertArray); // all insert 
					//echo $this->db->last_query();exit;
					if ($insert) {
						$this->session->set_flashdata('success', 'Thank you for your Complaint. We will get back to you soon..!');
						redirect(base_url('complaint'));
					}
				} else {
					$this->session->set_flashdata('Error', 'Sorry Google Recaptcha Unsuccessful!!');
					redirect(base_url('complaint'));
				}
			} else {
				$this->session->set_flashdata('Error', validation_errors());
				redirect(base_url('complaint'));
			}
		}
	}


	private function set_upload_options()
	{
		//upload an image options
		$config = array();
		$config['upload_path'] = './assets/complaint_files/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size']      = '0';
		$config['overwrite']     = FALSE;
		$config['encrypt_name'] = FALSE;

		return $config;
	}
	public function getReportsDetails()
	{
		$reportId = $this->uri->segment(2);

		$params = array(
			'ip_address' => $this->input->ip_address(),
			'url' => base_url(),
			'date' => date('Y-m-d'),
			'ts' => date('Y-m-d H:i:s')
		);

		$this->MenuModel->insertVisitor($params);
		$data['visitors_count'] = $this->MenuModel->getVisitorCount() +  156862;
		//	echo $data['visitors_count']=$this->MenuModel->getVisitorCount();

		//$ulbid = $this->uri->segment('1');
		$ulbid = 300;
		if ($ulbid == '') {
			die('Invalid url');
		}
		$params = array('ulbid' => $ulbid);
		// $ulbchk =  $this->MenuModel->checkUlbid($params);
		//echo count($ulbchk);
		//echo $ulbchk->num_rows();
		/* if($ulbchk->num_rows() <=0)
	    {
	        die(' Invalid ulbid ');
	    }*/



		$this->session->unset_userdata('onlineservice_widget_count');

		// get Townprofile details
		$params = array('ulbid' => $ulbid);
		$data['townprofile_details'] = $this->MenuModel->getTownProfiledata($params);


		if (!$this->session->userdata('lang_Id')) {

			$this->session->set_userdata('lang_Id', 1);
			$this->session->set_userdata('langtext', ' à°¤à±†à°²à±à°—à±');
		}
		//echo $this->session->set_userdata('lang_Id',1);exit;


		$this->session->set_userdata('ulb_id', $ulbid);
		$params = array('ulbid' => $ulbid);
		$data['ulbinfo'] = $this->MenuModel->getULBInfo($params);
		//print_r($data['ulbinfo']);
		// $data['ulbinfo']=$this->CommonData->getULBInfo($params);
		$data['description'] = $data['ulbinfo'][0]->description;
		$data['keywords'] = $data['ulbinfo'][0]->keywords;
		$data['subject'] = $data['ulbinfo'][0]->subject;
		$data['title'] = $data['ulbinfo'][0]->ulb_type_desc;
		$data['ulbnametelutu'] = $data['ulbinfo'][0]->ulbtelugu . " " . $data['ulbinfo'][0]->ulb_type_desctelugu;
		$data['ulbnameenglish'] = $data['ulbinfo'][0]->ulbname . " " . $data['ulbinfo'][0]->ulb_type_desc;
		$data['base_url'] = $data['ulbinfo'][0]->base_url;

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
		//$data['ulbid']['ulbid']=$ulbid;


		/** getting menus **/

		/** top menus **/

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


		//print_r($data['leftsubmenus']['leftsubmenus']);




		/** footer menus **/

		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'), 'menu_type_id' => 3);
		$result = $this->Mylibrary->getMenus($params);
		$data['footermainmenus']['footermainmenus'] = $result['mainmenu'][0];
		$data['footerleftsubmenus']['footerleftsubmenus'] = $result['submenu'][0];
		$data['footerleftsubsubmenus']['footerleftsubsubmenus'] = $result['chilemenu'][0];


		/** end **/
		// news information


		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'));
		$data['headerNews'] = $this->MenuModel->getHeaderNews($params);
		//print_r($params);
		$data['sliderdata']['sliderdata'] = $this->MenuModel->getsliderdata($params);
		$params = array('ulbid' => $ulbid);
		$themefolder = $this->MenuModel->getthemefolder($params); // selecting ulb mapped theme
		$theme = $themefolder[0]['folder'];
		$data['theme'] = $themefolder[0]['folder'];
		$themeLayoutId = $themefolder[0]['theme_id'];


		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId, 'flag' => 1);
		$layoutwidgets = $this->MenuModel->getLayout($params);
		$layouts = array();
		foreach ($layoutwidgets->result() as $key => $val) {
			$layouts[$val->page_layout_id] = $val->page_layout_desc;
		}

		// print_r($layouts);

		$data['layoutwidgets'] = $this->Themeonelayoutwidgets->getLayoutwidgets($layouts, $ulbid, $langId = $this->session->userdata('lang_Id'), '', '');
		// 	  print_r($data['layoutwidgets']);
		// 	  exit;



		$params = array('ulbid' => $ulbid, 'theme_layout_id' => $themeLayoutId, 'flag' => 1);
		$data['customepagelayouts'] = $this->MenuModel->getLayout($params);

		/** get slider details **/
		$params = array('ulbid' => $ulbid, 'langId' => $this->session->userdata('lang_Id'));
		$data['sliderposts'] = $this->MenuModel->getSliderPosts($params);

		/** close **/

		$report_id = $this->uri->segment(2);

		$data['reports'] = $this->MenuModel->all_records('tbl_reports_sub_category', array('cat' => $report_id, 'status' => 'Enable'));
		//print_r($data['reports']);exit;
		$this->load->view($theme . '/notebook', $data);
	}
}
