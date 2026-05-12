<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 0);

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
		$this->load->model('CreatepageModel');
		$this->load->model('CreatePostModel');
		$this->load->model('ViewAlbumModel');
		$this->load->model('ViewPagesModel');
		$this->load->library('form_validation');
	}
	public function getFilepath($page_name, $file_name)
	{
		if ($this->session->userdata('session_id') == session_id()) {
			$curyear = date("Y");
			$curmonth = date('m');
			$folder = str_replace(" ", "-", $page_name);


			$upload_path = '../assets/' . $this->session->userdata('ulbid') . '/';

			if (!file_exists($upload_path)) {
				mkdir($upload_path, 0777, true);
				$upload_path .= $curyear . "/";
				if (!file_exists($upload_path)) {
					$upload_path .= $curmonth . "/";
					if (!file_exists($upload_path)) {
						$upload_path .= $folder . "/";
						$thumbspath = $upload_path . "thumbnails";
						if (!file_exists($upload_path)) {
							mkdir($upload_path, 0777, true);
							mkdir($thumbspath, 0777, true);
						}
					}
				}
			} else {
				$upload_path .= $curyear . "/";
				if (!file_exists($upload_path)) {
					mkdir($upload_path, 0777, true);
					$upload_path .= $curmonth . "/";
					if (!file_exists($upload_path)) {
						$upload_path .= $folder . "/";
						$thumbspath = $upload_path . "thumbnails";
						if (!file_exists($upload_path)) {
							mkdir($upload_path, 0777, true);
							mkdir($thumbspath, 0777, true);
						}
					}
				} else {
					$upload_path .= $curmonth . "/";

					if (!file_exists($upload_path)) {
						$upload_path .= $folder . "/";
						$thumbspath = $upload_path . "thumbnails";
						if (!file_exists($upload_path)) {
							mkdir($upload_path, 0777, true);
							mkdir($thumbspath, 0777, true);
						}
					} else {
						$upload_path .= $folder . "/";
						$thumbspath = $upload_path . "thumbnails";
						if (!file_exists($upload_path)) {
							mkdir($upload_path, 0777, true);
							mkdir($thumbspath, 0777, true);
						}
					}
				}
			}





			$config = array();
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
			$config['max_size']      = '20480';
			$config['overwrite']     = FALSE;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			//$this->upload->initialize($this->set_upload_options());

			if (!$this->upload->do_upload($file_name)) {
				print_r($this->upload->display_errors());
			}
			$upload_data = $this->upload->data();

			/** checking for malicious file upload **/
			$file_info = new finfo(FILEINFO_MIME_TYPE);
			$mime_types_array = array('image/jpg', 'image/jpeg', 'image/png', 'application/pdf');
			$finopath = $target_file;
			$a = getimagesize($upload_data['full_path']);


			//$filename = date('YmdHis').rand(999,100000).".jpg";

			$mime_type = $file_info->buffer(file_get_contents($upload_data['full_path']));

			if (!in_array($mime_type, $mime_types_array)) {
				unlink($upload_data['full_path']);
				die('Invalid file type');
			} else {
				/*$src_file = $upload_data['full_path'];
                                       $dest_file = $upload_path.$filename;
                                        $img_quality = 70;
                                         header('Content-Type: image/png');
                                        $im = imagecreatefromstring(file_get_contents($src_file));
                                        $im_w = imagesx($im);
                                        $im_h = imagesy($im);
                                        $tn = imagecreatetruecolor($im_w, $im_h);
                                        imagecopyresampled ( $tn , $im, 0, 0, 0, 0, $im_w, $im_h, $im_w, $im_h );
                                        imagejpeg($tn,$dest_file,$img_quality);
                                        
                                        array_push($imgg, $filename);
                                        unlink($upload_data['full_path']);*/
			}

			/** close **/
			$upload_data['file_name'] = $upload_data['file_name'];


			$upload_data['file_folder_path'] = $upload_path;

			$this->session->set_userdata('pathimagesaveurl', $thumbspath);

			return $upload_data;
		} else {
			redirect('Login');
		}
	}

	public function input_check($str)
	{
		if (ctype_alnum($str)) {
			return true;
		} else {
			$this->form_validation->set_message('input_check', 'Please Enter a Valid Input');
			return false;
		}
	}

	public function updatePageContent()
	{
		//echo $_POST['content_new']; exit;
		//print_r($_POST);die;
		$this->form_validation->set_rules('page_name', 'Page Name', 'required');
		//$this->form_validation->set_rules('pagetitle', 'Page Title', 'required|callback_input_check');
		$this->form_validation->set_rules('hover_title', 'Hover Title', 'required');
		$this->form_validation->set_rules('ptags', 'Tags', 'required');
		$this->form_validation->set_rules('meta_desc', 'Description', 'required');
		$this->form_validation->set_rules('meta_subject', 'Subject', 'required');


		if ($this->session->userdata('session_id') == session_id()) {
			if ($this->form_validation->run() == TRUE) {
				if ($this->input->post('save')) {

					$content = $this->input->post('content');
					$replaceUrl = "../";
					$content = str_replace($replaceUrl, '/', $content);
					$replaceUrl = "//assets";
					$content = str_replace($replaceUrl, '/assets', $content);
					$content = str_replace("'", ' ', $content);

					$pageid = $this->security->xss_clean(trim($this->input->post('pageid')));
					if ($this->security->xss_clean(trim($this->input->post('is_target_blank') == ''))) {
						$target = "1";
					} else {
						$target = $this->security->xss_clean(trim($this->input->post('is_target_blank')));
					}
					
					 $photo_file_url=$this->fileUpload($_FILES);
					
				
					//echo $_POST['content_new']; exit;

					$params4 = array(

						'content' => $_POST['content_new'],
						'page_name' => $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('page_name'))))),
						'hover_title' => $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('hover_title'))))),
						'page_sidebars_id' => $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('layoutid'))))),
						'pagekeywords' => $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('ptags'))))),
						'meta_desc' => $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_desc'))))),
						'meta_subject' => $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_subject'))))),
						'meta_photo' => $photo_file_url,
						'is_draft' => $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('is_draft'))))),
						'is_target_blank' => $target,
						'langId' => htmlspecialchars(strip_tags($this->input->post('lang_id')))

					);

					if (count($this->input->post('categories')) > 0) {

						$params = array('page_id' => $pageid);
						$this->CreatePostModel->deletePageCategories($params);
						foreach ($this->input->post('categories') as $val) {

							$params2 = array(
								'category_id' => $val,
								'page_id' => $pageid,
								'flag' => 1
							);



							$this->CreatePostModel->mapCategoryPost($params2);

							$params2 = array('category_id' => $val);

							// getting all field names from table with this category id table: category_forms_mst

							$fieldname = $this->CreatePostModel->getCategoryFieldnames($params2);

							// making query with database field names

							$total_fieldnames = count($fieldname); // find total number of records in array

							// getting category name for identifying the table names


							$tbl = "tbl" . $val;

							$table = $this->security->xss_clean(trim($this->input->post($tbl)));
							$alltables[] = $table;


							if ($table != '') {

								$query1 = "insert into $table (";
								$query2 = ")values(";
								$onduplicatekyupdate = "";

								$i = 1; // initializing for the purpose of to remove ',' on last reocrd

								$code = 0; // variable initializing here for the purpose of if it is slider imgage is updated to redirect cropimage page 
								foreach ($fieldname as $key => $val2) {
									// finding file type fields
									$upload_data = array();

									if ($val2['type'] == 'file') {

										if ($_FILES[$val2['name'] . $val]['name'] != '') {

											$code = 1;
											$upload_data = $this->getFilepath($val2['page_name'], $val2['name'] . $val); // calling function to get file path

											$this->session->set_userdata('source_image', $upload_data['file_folder_path'] . $upload_data['file_name']);
											$filepath = substr($upload_data['file_folder_path'], 2) . $upload_data['file_name'];

											if ($table == 'slider_mst2') {

												$thumbspath = $this->session->userdata('pathimagesaveurl') . "/" . $upload_data['file_name'];
												$this->session->set_userdata('pathimagesaveurl', $thumbspath);
											}
										} else {
											$prefix = "prev" . $val2['name'] . $val;
											$filepath = $this->input->post($prefix);
										}
									} else {
										$postvalue = $val2['name'] . $val;
									}
									// adding set field name to query 1
									$query1 .= $val2['name'];
									$onduplicatekyupdate .= $val2['name'] . "=";


									if ($val2['data_type'] == 'date') {
										// adding value to field name to query 2    
										$query2 .= "'" . date('Y-m-d', strtotime($this->security->xss_clean(trim($this->input->post($postvalue))))) . "'";
										$onduplicatekyupdate .= "'" . date('Y-m-d', strtotime($this->security->xss_clean(trim($this->input->post($postvalue))))) . "'";
									} else if ($val2['type'] == 'hidden') {
										// adding value to field name to query 2 
										$query2 .= "'" . $pageid . "'";
										$onduplicatekyupdate .= "'" . $pageid . "'";
									} else if ($val2['type'] == 'file') {
										// adding value to field name to query 2 
										$query2 .= "'" . $filepath . "'";
										$onduplicatekyupdate .= "'" . $filepath . "'";
									} else {
										$query2 .= "'" . $this->security->xss_clean(trim($this->input->post($postvalue))) . "'";
										$onduplicatekyupdate .= "'" . $this->security->xss_clean(trim($this->input->post($postvalue))) . "'";
									}

									if ($i < $total_fieldnames) {
										// if the record last record no need to add ','
										$query1 .= ",";
										$query2 .= ",";
										$onduplicatekyupdate .= ",";
									}


									$i++;
								}

								$query2 .= ") ON DUPLICATE KEY UPDATE ";

								$query = $query1 . $query2 . $onduplicatekyupdate;
								$fieldname = $this->CreatePostModel->insertCategoryFormdetails($query);
							}


							/*** updating slider thumbnail image ****/

							if ($table == 'slider_mst2') {
								if ($code == 1) {
									$this->CreatePostModel->updateSliderThumbnailimage($pageid, substr($this->session->userdata('pathimagesaveurl'), 2));
								}
							}
							/*** close ***/
						}


						if (in_array('slider_mst2', $alltables)) {
							if ($code == 1) {
								$redirect_url = "crop-image/" . $pageid;
								redirect($redirect_url);
							}
						}
					}
					
	//echo "<pre>";print_r($params4);echo "</pre>";die();	
	
					$result = $this->CustomModel->updatePageContent($params4, $pageid);
					
					if ($result == '1') {



						$this->session->set_flashdata('message', 'Page / post Updated successfully');
					} else {
						$this->session->set_flashdata('message', 'Unable to update page , Please try again');
					}

					redirect($this->security->xss_clean(trim($this->input->post('page'))));
				}
			} else {
				// loading 
				$page = $this->input->post('page');
				$submenudata = array();
				$data['main_menu_list'] = $this->MenuModel->getMainMenu();
				$subMenus = $this->MenuModel->getSubMenu();
				foreach ($subMenus as $key => $val) {
					$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname'] = $val['sub_menu_desc'];
					$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName'] = $val['SubcontrollerName'];
				}

				$data['sub_menus'] = $submenudata;



				$data['custom_menus'] = $customemenudata;
				$params = array('ulbid' => $this->session->userdata('ulbid'), 'controller' => $page);
				$data['content'] = $this->CustomModel->getpageData($params);



				$ulb = $this->session->userdata('ulbid');
				$ulb_baseurl = $this->ViewPagesModel->getulb_baseurl($ulb);

				foreach ($ulb_baseurl->result() as $key => $val2) {

					$data['ulb_base_url'][$val2->ulbid]['base_url'] = $val2->base_url;
				}



				$data['languageList'] = $this->MenuModel->getLanguages($params);
				$params = array('ulbid' => $this->session->userdata('ulbid'));
				$data['theme_id'] = $this->CustomModel->getThemeId($params);
				// getting innerpage layouts
				$data['innerpagelayouts'] = $this->CustomModel->getInnerpageLayouts($data['theme_id']['theme_id']);

				$params = array('ulbid' => $this->session->userdata('ulbid'), 'is_custumlink' => 3, 'langId' => $this->session->userdata('langId'));

				$assignedDepartments = array();

				if ($this->session->userdata('user_type') === 'D') {

					$assign_params = array('user_id' => $this->session->userdata('userid'));
					$assignedDepartments = $this->CreatePostModel->getAssignedCategories($assign_params);

					$params = array('ulbid' => $this->session->userdata('ulbid'), 'is_custumlink' => 3, 'langId' => $this->session->userdata('langId'));
				} else {


					$params = array('ulbid' => $this->session->userdata('ulbid'), 'is_custumlink' => 3, 'langId' => $this->session->userdata('langId'));
				}
				// will get all categories created by users and super admin


				$categories = $this->CreatePostModel->getPostCategories($params, $assignedDepartments);

				// adding ulb categories and admin categories
				foreach ($categories['ulbcategories']->result() as $key => $val) {
					$data['categories'][$val->category_id] = $val->category_desc;
					$data['tbls'][$val->category_id] = $val->table_name;
				}
				// adding ulb categories and admin categories
				foreach ($categories['admincategories']->result() as $key => $val) {
					$data['categories'][$val->category_id] = $val->category_desc;
					$data['tbls'][$val->category_id] = $val->table_name;
				}





				// category form data
				$params = array('user_level' => 'A', 'is_custumlink' => 3);
				// getting all fields name from the the table : 'category_forms'
				$formdata = $this->MenuModel->getformsdata($params);
				foreach ($formdata->result() as $key => $val) {
					$forms[$val->category_id][$val->sno]['label'] = $val->label;
					$forms[$val->category_id][$val->sno]['type'] = $val->type;
					$forms[$val->category_id][$val->sno]['name'] = $val->name;
					$forms[$val->category_id][$val->sno]['id'] = $val->id;
					$forms[$val->category_id][$val->sno]['class'] = $val->class;
				}




				$data['forms'] = $forms;
				// Getting all select options from the table 'select_option_map'
				$getselectoptionsdata = $this->MenuModel->getselectoptionsdata();
				foreach ($getselectoptionsdata->result() as $key => $val) {
					$select_options[$val->select_id][$val->option_id]['option_id'] = $val->option_id;
					$select_options[$val->select_id][$val->option_id]['option_desc'] = $val->option_desc;
				}

				$data['select_options'] = $select_options;


				// params to get tender details
				$params = array('pcm.page_id' => $data['content'][0]['page_id']);

				// select all categories mapped with this page
				$selected_values = $this->MenuModel->getTenderdetails($params);

				foreach ($selected_values as $key => $val) {
					$data['categories_selcted'][$val['category_id']]['checked'] = 'checked'; // adding checked values to the mapped with this page or post
					if ($val['table_name'] != '') {
						$category_name[$val['category_id']] = $val['table_name']; // to get table name of categories mapped with this page or post
					}
				}


				// getting additional data  of categories 

				echo $data['content'][0]['page_id'];
				exit;
				$data['category_details'] = $this->MenuModel->getCategorydata($category_name, $data['content'][0]['page_id']);


				$params = array('ulbid' => $this->session->userdata('ulbid'), 'status' => 1);
				$data['create_media_data'] = $this->ViewAlbumModel->createMediaData($params);

				// gettin innper page sidbars and default sidebar id set by admin

				$layoutList = $this->MenuModel->getinnerpagelayouts($params);


				foreach ($layoutList as $key => $val) {

					if ($val['superadmin_defautl_layout'] != '') {
						$data['defaultsidebar'] = $val['superadmin_defautl_layout'];
					}

					$data['layoutlists'][$val['sidebars_id']] = $val['sidebars_desc'];
				}
				$this->load->view('header', $data);
				$this->load->view('custompage', $data['content'], $data['innerpagelayouts']);
				$this->load->view('divdata', $data);
				$this->load->view('footer');
			}
		} else {
			redirect('login');
		}
	}

	public function is_existingPagename($pagename, $ulbid)
	{
		if ($this->session->userdata('session_id') == session_id()) {

			$params = array('controller' => $pagename, 'ulbid' => $ulbid);
			$result = $this->CustomModel->is_existingPagename($params);


			return $result;
		} else {
			redirect('login');
		}
	}


	public function updatePagename()
	{

		if ($this->session->userdata('session_id') == session_id()) {


			$configFilePath = $_SERVER['DOCUMENT_ROOT'] . '/sites/admin/application/config/routes.php';
			$configFilePath2 = $_SERVER['DOCUMENT_ROOT'] . '/sites/application/config/routes.php';


			// creating new urs 
			$pagename = strtolower($this->security->xss_clean(trim($this->input->post('pagename'))));
			$pagename = str_replace(" ", "-", $pagename);
			$pagename2 = $pagename;










			$site_controller = $this->session->userdata('ulbid') . "/" . $pagename2;
			$pagecount = $this->is_existingPagename($pagename, $this->session->userdata('ulbid'));

			// if($pagecount['count'] =='1')
			// {

			//     $pagename=$pagename.time();
			//     $pagename2=$pagename2.time();

			//     $site_controller=$this->session->userdata('ulbid')."/".$pagename2; 
			// }

			$adminControllers = $pagename;
			$siteControllers = $site_controller;



			// setting controllers





			// select base url from the table 'ulbmst'

			$portal_url = $this->CustomModel->getPortalUrl($this->session->userdata('ulbid'));

			//set admin url and permanant link url

			$url = $portal_url['base_url'];
			$adminurl = $url . "admin/";
			$permalink = $url . $siteControllers;
			$url = $adminurl . $pagename;


			$pagename = "'" . $pagename . "'";



			$file = fopen($configFilePath, 'a') or die('cannot append to file');
			$controllerNameNoextension = 'CustomePageController/getPageContent/';
			$controller = '$route[' . $pagename . ']=' . "'" . $controllerNameNoextension . "';";
			fwrite($file, "\n" . $controller);
			fclose($file);

			// for site

			$pagename = "'(:num)/" . $pagename2 . "'";

			$file = fopen($configFilePath2, 'a') or die('cannot append to file');
			$controllerNameNoextension = 'CustomePageController/getPageContent/';
			$controller = '$route[' . $pagename . ']=' . "'" . $controllerNameNoextension . "';";
			fwrite($file, "\n" . $controller);
			fclose($file);





			$params = array('controller' => str_replace(" ", "-", $adminControllers), 'page_id' => $this->input->post('pageid'), 'permalink' => $permalink, 'site_controller' => $siteControllers);
			$result = $this->CustomModel->updatePagename($params);
			echo $url;
		} else {
			redirect('login');
		}
	}



	public function getPageContent()
	{
		$page = $this->uri->segment(1);

		if ($this->session->userdata('session_id') == session_id()) {
			$submenudata = array();
			$data['main_menu_list'] = $this->MenuModel->getMainMenu();
			$subMenus = $this->MenuModel->getSubMenu();
			foreach ($subMenus as $key => $val) {
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname'] = $val['sub_menu_desc'];
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName'] = $val['SubcontrollerName'];
			}

			$data['sub_menus'] = $submenudata;

			$data['custom_menus'] = $customemenudata;
			$params = array('ulbid' => $this->session->userdata('ulbid'), 'controller' => $page);
			$data['content'] = $this->CustomModel->getpageData($params);

			$ulb = $this->session->userdata('ulbid');
			$ulb_baseurl = $this->ViewPagesModel->getulb_baseurl($ulb);

			foreach ($ulb_baseurl->result() as $key => $val2) {

				$data['ulb_base_url'][$val2->ulbid]['base_url'] = $val2->base_url;
			}

			$data['languageList'] = $this->MenuModel->getLanguages($params);
			$params = array('ulbid' => $this->session->userdata('ulbid'));
			$data['theme_id'] = $this->CustomModel->getThemeId($params);
			// getting innerpage layouts
			$data['innerpagelayouts'] = $this->CustomModel->getInnerpageLayouts($data['theme_id']['theme_id']);

			$params = array('ulbid' => $this->session->userdata('ulbid'), 'is_custumlink' => 3, 'langId' => $this->session->userdata('langId'));
			// will get all categories created by users and super admin

			$assignedDepartments = array();


			if ($this->session->userdata('user_type') === 'D') {

				$assign_params = array('user_id' => $this->session->userdata('userid'));
				$assignedDepartments = $this->CreatePostModel->getAssignedCategories($assign_params);
				// echo $this->db->last_query();
				// print_r($assignedDepartments);
				$assignDepArray = array();
				foreach ($assignedDepartments as $val) {
					//array_push($assignDepArray,$val);
					//print_r($val['dept_id']);
					$assignDeptArray[$val['dept_id']] = $val['dept_id'];
				}
				//print_r($assignDeptArray);
				//exit;
				$params = array('ulbid' => $this->session->userdata('ulbid'), 'is_custumlink' => 3, 'langId' => $this->session->userdata('langId'));
			} else {


				$params = array('ulbid' => $this->session->userdata('ulbid'), 'is_custumlink' => 3, 'langId' => $this->session->userdata('langId'));
			}

			$categories = $this->CreatePostModel->getPostCategoriescustom($params, $assignedDepartments);


			

			// adding ulb categories and admin categories
			foreach ($categories['ulbcategories']->result() as $key => $val) {
				$data['categories'][$val->category_id] = $val->category_desc;
				$data['tbls'][$val->category_id] = $val->table_name;
			}

			// adding ulb categories and admin categories
			if ($this->session->userdata('user_type') !== 'D') {
				foreach ($categories['admincategories']->result() as $key => $val) {
					$data['categories'][$val->category_id] = $val->category_desc;
					$data['tbls'][$val->category_id] = $val->table_name;
				}
			}

			// category form data
			$params = array('user_level' => 'A', 'is_custumlink' => 3);
			// getting all fields name from the the table : 'category_forms'
			$formdata = $this->MenuModel->getformsdata($params);
			
			//echo "<pre>"; print_r($formdata->result());echo "</pre>"; die();	
	
			foreach ($formdata as $key => $val) {
				$forms[$val->category_id][$val->sno]['label'] = $val->label;
				$forms[$val->category_id][$val->sno]['type'] = $val->type;
				$forms[$val->category_id][$val->sno]['name'] = $val->name;
				$forms[$val->category_id][$val->sno]['id'] = $val->id;
				$forms[$val->category_id][$val->sno]['class'] = $val->class;
			}

			$data['forms'] = $forms;
			// Getting all select options from the table 'select_option_map'
			$getselectoptionsdata = $this->MenuModel->getselectoptionsdata();
			foreach ($getselectoptionsdata->result() as $key => $val) {
				$select_options[$val->select_id][$val->option_id]['option_id'] = $val->option_id;
				$select_options[$val->select_id][$val->option_id]['option_desc'] = $val->option_desc;
			}

			$data['select_options'] = $select_options;


			// params to get tender details
			$params = array('pcm.page_id' => $data['content'][0]['page_id']);

			// select all categories mapped with this page
			$selected_values = $this->MenuModel->getTenderdetails($params);




			foreach ($selected_values as $key => $val) {
				$data['categories_selcted'][$val['category_id']]['checked'] = 'checked'; // adding checked values to the mapped with this page or post
				if ($val['table_name'] != '') {
					$category_name[$val['category_id']] = $val['table_name']; // to get table name of categories mapped with this page or post
				}
			}



			// getting additional data  of categories 
			$data['category_details'] = $this->MenuModel->getCategorydata($category_name, $data['content'][0]['page_id']);


			$params = array('ulbid' => $this->session->userdata('ulbid'), 'status' => 1);
			$data['create_media_data'] = $this->ViewAlbumModel->createMediaData($params);

			// gettin innper page sidbars and default sidebar id set by admin

			$layoutList = $this->MenuModel->getinnerpagelayouts($params);


			foreach ($layoutList as $key => $val) {

				if ($val['superadmin_defautl_layout'] != '') {
					$data['defaultsidebar'] = $val['superadmin_defautl_layout'];
				}

				$data['layoutlists'][$val['sidebars_id']] = $val['sidebars_desc'];
			}



			$this->load->view('header', $data);
			$this->load->view('custompage', $data['content'], $data['innerpagelayouts'], $data);
			$this->load->view('divdata', $data);
			$this->load->view('footer');
		} else {
			redirect('login');
		}
	}
	
	
	public function fileUpload($FILESS){
			   
		 
			   if (isset($FILESS['meta_photo']) && $FILESS['meta_photo']['error'] == 0) {

					// Get file information
					$file_name = $FILESS['meta_photo']['name'];
					$file_tmp = $FILESS['meta_photo']['tmp_name'];
					$file_size = $FILESS['meta_photo']['size'];
					$file_error = $FILESS['meta_photo']['error'];
				//echo "<pre>";print_r($FILESS['meta_photo']['tmp_name']);echo "</pre>";die('ssss');		
					// Allowed file types
					$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
					$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					
					// Validate the file extension
					if (!in_array($file_ext, $allowed_extensions)) {
						echo "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
					} else {
						
						// Check if file size is within limit (e.g., 5MB)
						
						/* if ($file_size > 5 * 1024 * 1024) { // 5MB
							echo "Error: File size must be less than 5MB.";
						} else {} */
						
							// Define the upload directory

							$curyear=date("Y");
							$curmonth=date('m');
							$folder=str_replace(" ","-",$page_name);
												
							$upload_path='../assets/'.$this->session->userdata('ulbid').'/';
                            
                            if (!file_exists($upload_path)) 
                            {
                                    mkdir($upload_path, 0777, true);
                                    $upload_path.=$curyear."/";
                                    if (!file_exists($upload_path)) 
                                        {
                                                   $upload_path.=$curmonth."/";
                                                    if (!file_exists($upload_path)) 
                                                        {
                                                            $upload_path.=$folder."upload/";
                                                            $thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                    mkdir($thumbspath, 0777, true);
                                                                }
                                                             
                                                            
                                                        }
                                            
                                          
                                        }
                                    
                            }
                            else
                            {
                               $upload_path.=$curyear."/";
                                    if (!file_exists($upload_path)) 
                                        {
                                             mkdir($upload_path, 0777, true);
                                             $upload_path.=$curmonth."/";
                                                    if (!file_exists($upload_path)) 
                                                        {
                                                            $upload_path.=$folder."upload/";
                                                            $thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                    mkdir($thumbspath, 0777, true);
                                                                }
                                                             
                                                            
                                                        }
                                        }
                                        else
                                        {
                                             $upload_path.=$curmonth."/";
                                            
                                            if (!file_exists($upload_path)) 
                                                        {
                                                            $upload_path.=$folder."upload/";
                                                            $thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                    mkdir($thumbspath, 0777, true);
                                                                }
                                                             
                                                            
                                                        }
                                                        else
                                                        {
                                                            $upload_path.=$folder."upload/";
                                                            $thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                    mkdir($thumbspath, 0777, true);
                                                                }
                                                        }
                                        }
                            }
                            
							
							// Generate a unique file name to avoid conflicts
							$file_path =$upload_path;
							$new_file_name = uniqid() . '.' . $file_ext;
							$file_name_path =$upload_path.$new_file_name;
							
					//echo "<pre>";print_r($file_name_path);echo "</pre>";die('ssss');	
					
							// Move the uploaded file to the target directory
							if (move_uploaded_file($file_tmp, $file_name_path)) {
								return $file_name_path;
							}
						
					}
					
				} else {
					echo false;
				}
			   	   
		
	}
	
	
}
