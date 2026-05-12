<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class EncroachmentQueriesController extends MY_Controller {

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
	    $this->load->model('CreateUserModel');
	    $this->load->model('CreateEncroachmentQueriesModel');
	    $this->load->model('CreatePostModel');
	    $this->load->model('ViewAlbumModel');
	    $this->load->library('form_validation');
	    $this->load->library('CategoryFunctions');
	    $this->load->helper('captcha');
	    $this->CategoryFunctions=new CategoryFunctions();
	    
	}
	 
		 
		 
	public function saveRecord(){
		if($this->session->userdata('session_id')==session_id()){			
				//echo "<pre>";print_r($this->input->post('submitencroachmentqueries'));echo "</pre>";die();
		if($this->input->post('submitencroachmentqueries')=='Submit'){
					
			$main_menu_id = $this->input->post('main_menu_id');
			$lang_id = $this->input->post('lang_id');
			$page_id = $this->input->post('zonal_dept_id');
			$description = strip_tags($this->input->post('description'));
			
			$show_cause_notice=$this->filePath($_FILES['show_cause_notice']);			
			$applicant_reply=$this->filePath($_FILES['applicant_reply']);
			$answer=$this->filePath($_FILES['answer']);
						

			if($lang_id!='' && $main_menu_id!='' && $page_id!='' && $show_cause_notice!='' && $applicant_reply!='' && $answer!=''){					
				
				date_default_timezone_set('Asia/Kolkata');
				$todat_date_time = date('Y-m-d H:i:s');
				
				$Array = array(
					'lang_id' => $lang_id,			                  
					'main_menu_id' => $main_menu_id,			                  
					'page_id' => $page_id, 							                   
					'show_cause_notice' => $show_cause_notice, 			                   
					'applicant_reply' => $applicant_reply, 			                   
					'answer' => $answer, 			                   
					'description' => $description, 			                   
					'user_id' => $this->session->userdata('userid'), 			                   
					'created_by' => $this->session->userdata('userid'),  			                   
					'status' => 'Enable',
					'created_at' =>$todat_date_time
				);
									
				$run = $this->CreateEncroachmentQueriesModel->insert('encroachment_queries', $Array);
				
				//echo "<pre>";print_r($run);echo "</pre>";
				
				if ($run) {	
					$this->session->set_flashdata('success', 'Added Successfully !!');
					redirect('encroachment-queries');
				} 
				
				$this->removeFile($show_cause_notice);
				$this->removeFile($applicant_reply);
				$this->removeFile($answer);	
						
				$this->session->set_flashdata('error', 'Please write unique description !!');
				redirect ('encroachment-queries'); 				
			}

		}
		}
	}
	
	
	
	public function updateRecord(){
		
		if($this->input->post('updateencroachmentqueries')){       
	           
			$editid = $this->input->post('id');
			$main_menu_id = $this->input->post('main_menu_id');
			$lang_id = $this->input->post('lang_id');
			$dept_id = $this->input->post('zonal_dept_id');
			$description = $this->input->post('description');
			
			$show_cause_notice=$this->filePath($_FILES['show_cause_notice']);			
			$applicant_reply=$this->filePath($_FILES['applicant_reply']);
			$answer=$this->filePath($_FILES['answer']);

		   // echo "<pre>";print_r($title);echo "</pre>";die();   
			date_default_timezone_set('Asia/Kolkata');
			$todat_date_time = date('Y-m-d H:i:s');
						
			$Array = array(
				'main_menu_id' => $main_menu_id,			                  
				'lang_id' => $lang_id,			                  
				'page_id' => $dept_id, 							                   
				'updated_by' => $this->session->userdata('userid'), 				                   
				'description' => $description, 							                   
				'status' => 'Enable',                 
				'updated_at' =>$todat_date_time
				);
			
			if(!empty($show_cause_notice)){
				
				$Array['show_cause_notice']=$show_cause_notice;
				
			}
			
			if(!empty($applicant_reply)){
				
				$Array['applicant_reply']=$applicant_reply;
				
			}
			
			if(!empty($answer)){
				
				$Array['answer']=$answer;
				
			}
			
//echo "<pre>";print_r($Array);echo "<pre>";die();			
			$run = $this->CreateEncroachmentQueriesModel->update('encroachment_queries', $Array,$editid);
			
			if ($run){
				 
				 $this->session->set_flashdata('success', 'Updated Successfully !!');
				 redirect ('encroachment-queries');
				 
			}
			
			$this->removeFile($show_cause_notice);
			$this->removeFile($applicant_reply);
			$this->removeFile($answer);	
					
			$this->session->set_flashdata('error', 'Please write unique description !!');
			redirect ('encroachment-queries'); 				
			
		}
			
	}
	
	public function index()
	{
					
		if($this->session->userdata('session_id')==session_id()){	
		
			//var_dump($this->input->post('submitencroachmentqueries'));die();
       

			$submenudata=array();
			
			$data['main_menu_list']=$this->MenuModel->getMainMenu();
			
			$subMenus=$this->MenuModel->getSubMenu();
			
			$params=array('ulbid'=>$this->session->userdata('ulbid'),'is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
					
			foreach($subMenus as $key=>$val){
				
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
			
			}
					 
			$data['sub_menus']=$submenudata;
			$assignedDepartments=array();
					
			$params=array('ulbid'=>$this->session->userdata('ulbid'));
			$data['languageList']=$this->MenuModel->getLanguages($params);
		
			$params=array('user_level'=>'A','is_custumlink'=>3);
			$formdata=$this->MenuModel->getformsdata($params);
			
			foreach($formdata as $key=>$val){
				
				$forms[$val->category_id][$val->sno]['label']=$val->label;
				$forms[$val->category_id][$val->sno]['type']=$val->type;
				$forms[$val->category_id][$val->sno]['name']=$val->name;
				$forms[$val->category_id][$val->sno]['id']=$val->id;
				$forms[$val->category_id][$val->sno]['class']=$val->class;
				$forms[$val->category_id][$val->sno]['data_type']=$val->data_type;
				$forms[$val->category_id][$val->sno]['min_date_after']=$val->min_date_after;
				
			}
					
			$data['forms']=$forms;
			 
			$getselectoptionsdata=$this->MenuModel->getselectoptionsdata();
			foreach($getselectoptionsdata->result() as $key=>$val){
				
				$select_options[$val->select_id][$val->option_id]['option_id']=$val->option_id;
				$select_options[$val->select_id][$val->option_id]['option_desc']=$val->option_desc; 
				
			}
	   
			$params = array('status' => 'Enable');
			
		//echo "<pre>";print_r(strcmp($this->session->userdata('userid'),"suepradmin"));die();	
			
			if(strcmp($this->session->userdata('userid'),"suepradmin")>0){
				$data['all']=$this->CreateEncroachmentQueriesModel->all('encroachment_queries', $params);
			}else{				
				$data['all']=$this->CreateEncroachmentQueriesModel->userAll('encroachment_queries', $this->session->userdata('userid'));
			}
			
			
			
			$data['zones_departments_list']=$this->CreateUserModel->getZOfficesDepts();
			$data['page_departments_list']=$this->CreateEncroachmentQueriesModel->getPageDepartments();
			
			
			//echo"<pre>";print_r( $data['zones_departments_list']);echo"</pre>";die();
			
			
			$data['languages']=$this->CreateEncroachmentQueriesModel->getLanguages();
			
			$this->load->view('header',$data);
			$this->load->view('encroachment_queries',$data);
			$this->load->view('divdata',$data);
			$this->load->view('footer');
	    
	    }else{
			
	        redirect('login');
			
	    }
	    
	
	}
		
	public function delete_encroachment_queries(){
		
	    $delid = $this->uri->segment('2');
		//var_dump($delid);die();
	    $del = $this->CreateEncroachmentQueriesModel->delete_recs('encroachment_queries', array('id' => $delid),['show_cause_notice', 'applicant_reply', 'answer']);
	    
		if ($del){
			
			$this->session->set_flashdata('success', 'Deleted Successfully !! ');
			redirect('encroachment-queries');
			
	    }
		
	}
	
	public function removeFile($filePath){
		if (file_exists($filePath)) {
			if (unlink($filePath)) {
				log_message('info', "Deleted file: {$filePath}");
			} 
		}
	}
	
	public function getCaptcha(){
	    
	    $captcha_reload = strip_tags($this->input->post('captcha_reload'));
		
	    if($captcha_reload=='Reload'){
			
            $digits='2';
            $i = 0; 
            $pin = ""; 
			
            while($i < $digits){
				
                $pin .= mt_rand(0, 9);
                $i++;
				
            }
			
            echo  $pin;
        
        }
		
	}
	
	public function edit_encroachment_queries(){
	    
		if($this->session->userdata('session_id')==session_id()){
			
			//echo"<pre>";print_r($this->input->post('updateencroachmentqueries'));echo"</pre>";die();
			
	        $editid = $this->uri->segment('2');	 
		
	        $data['dtl'] = $this->CreateEncroachmentQueriesModel->get_row('encroachment_queries',  $editid);
	 	        
			
	     
			$submenudata=array();
				
			$data['main_menu_list']=$this->MenuModel->getMainMenu();
					
			$subMenus=$this->MenuModel->getSubMenu();
					
			$params=array('ulbid'=>$this->session->userdata('ulbid'),'is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
		  
			foreach($subMenus as $key=>$val){
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
			}
			$data['sub_menus']=$submenudata;					
		  
			$assignedDepartments=array();
			
			$categories=$this->CreatePostModel->getPostCategories($params,$assignedDepartments);
			
					// echo "<pre>";print_r($categories);echo "</pre>";die();  
					 
			foreach($categories['ulbcategories']->result() as $key=>$val){
				$data['categories'][$val->category_id]=$val->category_desc;
				$data['tbls'][$val->category_id]=$val->table_name;
			}
		  
			foreach($categories['admincategories']->result() as $key=>$val){
				$data['categories'][$val->category_id]=$val->category_desc;
				$data['tbls'][$val->category_id]=$val->table_name;
			}
			
			$params=array('ulbid'=>$this->session->userdata('ulbid'));
			$data['languageList']=$this->MenuModel->getLanguages($params);
		 
			// category form data
			$params=array('user_level'=>'A','is_custumlink'=>3);
			$formdata=$this->MenuModel->getformsdata($params);
			
			//echo "<pre>";print_r($formdata);echo "</pre>";die();
			
			foreach($formdata as $key=>$val){
				
				$forms[$val->category_id][$val->sno]['label']=$val->label;
				$forms[$val->category_id][$val->sno]['type']=$val->type;
				$forms[$val->category_id][$val->sno]['name']=$val->name;
				$forms[$val->category_id][$val->sno]['id']=$val->id;
				$forms[$val->category_id][$val->sno]['class']=$val->class;
				$forms[$val->category_id][$val->sno]['data_type']=$val->data_type;
				$forms[$val->category_id][$val->sno]['min_date_after']=$val->min_date_after;
				
			}

			$data['forms']=$forms;
			
			$getselectoptionsdata=$this->MenuModel->getselectoptionsdata();
			
			foreach($getselectoptionsdata->result() as $key=>$val){
				$select_options[$val->select_id][$val->option_id]['option_id']=$val->option_id;
				$select_options[$val->select_id][$val->option_id]['option_desc']=$val->option_desc;
			}
			
			$dependent_field_data=$this->MenuModel->getDependentFielddata();
		   
			foreach($dependent_field_data->result() as $key=>$val){
				
				$dependentParentFields[$val->field_id]=$val->field_id; // dependent parent fields
				$hiddenfields[$val->dependent_field_id]=$val->dependent_field_id; // dependent child fields
				$setFunctionValues[$val->field_id]=$val->dependent_field_id; // in view we are setting 'dependentFunction' for that purpose we are setting this array values 
			}
			
			$data['dependentfieldslist']=$dependentfieldslist;
			$data['hiddenfields']=$hiddenfields;
			$data['dependentParentFields']=$dependentParentFields;
			$data['setFunctionValues']=$setFunctionValues;
			
			$params = array('ulbid'=>$this->session->userdata('ulbid'),'status'=>1);
			$data['create_media_data']=$this->ViewAlbumModel->createMediaData($params);
			 
			$params = array('status' => 'Enable');
			$data['all']= $this->CreatePostModel->all_records('encroachment_queries', $params);
			//print_r($data['all_startups_partners']);exit;

			$data['departments']=$this->CreateEncroachmentQueriesModel->getDepartments();
			$data['languages']=$this->CreateEncroachmentQueriesModel->getLanguages();

			$data['zones_departments_list']=$this->CreateUserModel->getZOfficesDepts();
			$zones_department_keys = array_keys($data['zones_departments_list']);
			$data['zones_departments_arraylist']=$this->CreateEncroachmentQueriesModel->getZoneDepartments($zones_department_keys);
			
			//echo "<pre>"; print_r($data['zones_departments_arraylist']);echo "</pre>";exit;
	
			$this->load->view('header',$data);
		
			$this->load->view('edit_encroachment_queries',$data);
			$this->load->view('divdata',$data);
			$this->load->view('footer');
	    
	    }else{
			
	        redirect('login');
			
	    }
		
	}
	
	
	public function filePath($FILESS){
		
		//echo "<pre>";print_r($FILESS['name']);echo "</pre>";die();
		if (isset($FILESS) && $FILESS['error'] == 0) {

			// Get file information
			$file_name = $FILESS['name'];
			$file_tmp = $FILESS['tmp_name'];
			$file_size = $FILESS['size'];
			$file_error = $FILESS['error'];
			
			// Allowed file types
			$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif','pdf'];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			
			// Validate the file extension
			if (!in_array($file_ext, $allowed_extensions)) {
				echo "Error: Only JPG, JPEG, PNG,GIF, and PDF files are allowed.";
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
													$upload_path.=$folder."upload/encroachment_queries/";
												   // $thumbspath=$upload_path."thumbnails";
													if (!file_exists($upload_path)) 
														{
															mkdir($upload_path, 0777, true);
															//mkdir($thumbspath, 0777, true);
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
													$upload_path.=$folder."upload/encroachment_queries/";
													//$thumbspath=$upload_path."thumbnails";
													if (!file_exists($upload_path)) 
														{
															mkdir($upload_path, 0777, true);
														  //  mkdir($thumbspath, 0777, true);
														}
													 
													
												}
								}
								else
								{
									 $upload_path.=$curmonth."/";
									
									if (!file_exists($upload_path)) 
												{
													$upload_path.=$folder."upload/encroachment_queries/";
													//$thumbspath=$upload_path."thumbnails";
													if (!file_exists($upload_path)) 
														{
															mkdir($upload_path, 0777, true);
														   // mkdir($thumbspath, 0777, true);
														}
													 
													
												}
												else
												{
													$upload_path.=$folder."upload/encroachment_queries/";
													//$thumbspath=$upload_path."thumbnails";
													if (!file_exists($upload_path)) 
														{
															mkdir($upload_path, 0777, true);
														   // mkdir($thumbspath, 0777, true);
														}
												}
								}
					}
					
					
					// Generate a unique file name to avoid conflicts
					$file_path =$upload_path;
					$new_file_name = uniqid() . '.' . $file_ext;
					$file_name_path =$upload_path.$new_file_name;
					
		//	echo "<pre>";print_r($file_name_path);echo "</pre>";die();	
			
					// Move the uploaded file to the target directory
					if (move_uploaded_file($FILESS['tmp_name'], $file_name_path)) {
						//return "Error: Failed to upload the image.";
						return $file_name_path;
					}
				
			}
			
		} else {
			return null;
		}
	}
}

