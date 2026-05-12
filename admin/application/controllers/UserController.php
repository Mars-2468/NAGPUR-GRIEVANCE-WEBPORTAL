<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
class UserController extends MY_Controller {

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
	    $this->load->model('CheckPasswordModel');
	    $this->load->model('CreatePublicNoticeCustModel');
	    $this->load->model('CreateImpLinkModel');
	    $this->load->model('CreatePostModel');
	    $this->load->model('ViewAlbumModel');
	    $this->load->library('form_validation');
	    $this->load->library('CategoryFunctions');
	    $this->load->helper('captcha');
	    $this->CategoryFunctions=new CategoryFunctions();
	    
	}
	 
	 
	public function userPasswordGen(){
		
		$user_id = $this->input->post('user_id');
	 
		$user=$this->CreateUserModel->get_user_row('users',$user_id);	  
		
		//$user->show_pwd=$this->decrypt_data($user->show_pwd,'mars-india-2025');			
	
		//$data2=$this->decrypt_data($data,'mars-india-2025');
		
		$pass=$this->generate_random_string();
	   
		//$en_pass = hash('SHA256',$pass);
		$en_pass = sha1(md5($pass));
		$input_pass=$this->encrypt_data($pass);
	   
	    $userdetails=array(		
			'user_pwd'=>$en_pass,
			'show_pwd'=>$input_pass,
			'user_id'=>$user_id,
			'author'=>trim(htmlspecialchars(strip_tags($this->session->userdata('userid'))))		
		);
		
		foreach($userdetails as $userdetail){
			if (preg_match('/<[^<]+>/', $userdetail)) {
				echo "Error: HTML or script tag detected in ".$userdetail." field!" ;
				redirect ('all-user-list');
				exit;
			}
		}
		
	   //echo "<pre>";print_r($userdetails); echo "</pre>";die();
	   
		$this->CreateUserModel->updateUser($userdetails,$user_id);			
		
		//redirect('all-user-list');
		
		echo json_encode($user);  
    } 

	public function removeZoneDept()
	{
		$user_id = $this->uri->segment(3);
		
		//var_dump($user_id);die();
		
		$dept_zone_id = intval($this->uri->segment(4));

		// Validate inputs
		if (empty($user_id) || empty($dept_zone_id)) {
			$this->session->set_flashdata('error', 'Invalid request!');
			redirect('user-assigned-dept-and-zone-list');
		}

		$del = $this->CreateUserModel->delete(
			'user_department_map',
			[
				'user_id' => $user_id,
				'dept_id' => $dept_zone_id
			]
		);

		if ($del) {
			$this->session->set_flashdata('success', 'Deleted Successfully !!');
		} else {
			$this->session->set_flashdata('error', 'Delete failed!');
		}

		redirect('user-assigned-dept-and-zone-list/'.$user_id);
	}	
 	
	public function userAssignedDeptAndZoneList() {
		
		$user_id = $this->uri->segment('2');
			//echo "<pre>";print_r($user_id);echo "</pre>";die('sss');
		
		if (!in_array($this->session->userdata('userid'),['superadmin','devspace'])) {
			$this->session->set_flashdata('error_message','Sorry you dont have permissions');
			//echo "Error: Sorry you don't have permissions!" ;
			redirect ('dashboard');
			exit;
		}
	
		if($this->session->userdata('session_id')==session_id())
	    {		        
	        	       
			$submenudata=array();
			
			$data['main_menu_list']=$this->MenuModel->getMainMenu();
			
			$subMenus=$this->MenuModel->getSubMenu();
			
			$params=array('ulbid'=>$this->session->userdata('ulbid'),'is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
					
			foreach($subMenus as $key=>$val)
			{
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
			}
					 
			$data['sub_menus']=$submenudata;
			$assignedDepartments=array();
					
			$params=array('ulbid'=>$this->session->userdata('ulbid'));
			$data['languageList']=$this->MenuModel->getLanguages($params);
						
			$params=array('user_level'=>'A','is_custumlink'=>3);
			$formdata=$this->MenuModel->getformsdata($params);
			
			foreach($formdata as $key=>$val)
			{
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
			foreach($getselectoptionsdata->result() as $key=>$val)
			{
				$select_options[$val->select_id][$val->option_id]['option_id']=$val->option_id;
				$select_options[$val->select_id][$val->option_id]['option_desc']=$val->option_desc;       
				
			}
			
			$data['select_options']=$select_options;
			// close 
			 $config = array(
				'img_path'      => 'assets/captcha_images/',
				'img_url'       => base_url().'assets/captcha_images/',
				'font_path'     => base_url().'system/fonts/texb.ttf',
				'img_width'     => '180',
				'img_height'    => 50,
				'expiration'    => 3600,
				'word_length'   => 6,
				'font_size'     => 18,
				'colors'        => array(
							'background' => array(255, 255, 227),
							'border' => array(33, 23, 96),
							'text' => array(57, 44, 112),
							'grid' => array(174, 222, 252)
					)
			);
			
			$captcha = create_captcha($config);
			
			// Unset previous captcha and set new captcha word
			$this->session->unset_userdata('captchaCode');
			$this->session->set_userdata('captchaCode', $captcha['word']);
			
			//print_r($data['dependentfieldslist']);
		   
			$params = array('status' => 'Enable');
			
			
			/* $data['designations']=$this->CreateUserModel->getDesignations();
			
			$data['departments_list']=$this->CreateUserModel->getDepartments();
			$data['zones_departments_list']=$this->CreateUserModel->getZOfficesDepts();
			$data['categories']=$this->CreateUserModel->getCategories(); */
			
			
			$data['user_id']=$user_id;
			$data['zone_departments_options']=$this->get_all_zonal_and_depts();
				//echo "<pre>";print_r($user_id);echo "</pre>";die();
			$user_zone_deptids=$this->get_user_zone_and_depts($user_id);

			$data['user_zone_dept_list']=[];	
			
			foreach($user_zone_deptids as $key=>$id){
				
				$data['user_zone_dept_list'][$id]=$data['zone_departments_options'][$id];
			}			
						
						
						
			//echo "<pre>";print_r($data['zone_departments_options']);echo "</pre>";
			//echo "<pre>";print_r($data['user_zone_dept_list']);echo "</pre>";die('11');
				
			if (!$this->session->userdata('form_nonce')) {
				$nonce = bin2hex(random_bytes(16));
				$this->session->set_userdata('form_nonce', $nonce);
			} else {
				$nonce = $this->session->userdata('form_nonce');
			}

			$data['form_nonce'] = $nonce;

			$this->load->view('header',$data);
			$this->load->view('user-assigned-dept-and-zone-list',$data);
			$this->load->view('divdata',$data);
			$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('/');
	    }
		
	} 	
	public function generate_random_string($length = 8) {
		
		if ($length < 8) {
			$length = 8; // enforce minimum length
		}

		// Character sets
		$lower = 'abcdefghijklmnopqrstuvwxyz';
		$upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$digits = '0123456789';
		//$special = '!@#$%^&*?';
		$special = '@#$%'; // safe chars only
		$all = $lower . $upper . $digits . $special;

		// Pick one from each category to ensure at least one of each
		$password = '';
		$password .= $lower[random_int(0, strlen($lower) - 1)];
		$password .= $upper[random_int(0, strlen($upper) - 1)];
		$password .= $digits[random_int(0, strlen($digits) - 1)];
		$password .= $special[random_int(0, strlen($special) - 1)];

		// Fill the remaining length
		for ($i = 4; $i < $length; $i++) {
			$password .= $all[random_int(0, strlen($all) - 1)];
		}

		// Shuffle the final string so characters are randomly placed
		return str_shuffle($password);
		
	}
	 
	public function updateUserAccess($user_id,$status)
	{	
		//var_dump($user_id.'=>'.$status);die();
		$result=($status=='enable')?1:0;
		$data = array(
			'has_access' => $result			
		);
		
		$this->db->where('user_id', $user_id);  // Set the WHERE condition
		$this->db->update('users', $data);
		$this->session->unset_userdata('has_access');
		$this->session->set_userdata('has_access', $result);
		redirect('all-user-list');
	}
	
	public function updateUserZoneDept()
	{	
		$user_id = $this->input->post('input_user_id');
		$zone_dept_ids = $this->input->post('zone_dept_ids');
		
		foreach($zone_dept_ids as $key=>$value){
		
			$data = array(
				'user_id' => $user_id,			
				'dept_id' => $value,			
			);
			$this->db->insert('user_department_map', $data);
		}
		
		//$this->db->insert('users', $data);
		
		redirect('all-user-list');
	}
	
	public function get_zonal_or_depts()
	{	

		$main_menu_id = $this->input->post('main_menu_id');
	//echo json_encode($main_menu_id);
			if ($this->session->userdata('userid') === 'superadmin') {
        
				// Get department IDs mapped to the superadmin
				
					
					$data = $this->db
					->select('page_id, sub_menu_desc')
					->where('main_menu_id', $main_menu_id)
					->get('site_sub_menus')
					->result_array();
					
			} else {
				// For regular users, fetch all sub menus under selected zonal/department
				$userDeptMap = $this->db
					->select('dept_id')
					->where('user_id', $this->session->userdata('userid'))
					->get('user_department_map')
					->result_array();

				// Extract just the dept_ids into a flat array
				$deptIds = array_column($userDeptMap, 'dept_id');

				// Get matching sub menus based on main_menu_id and mapped dept_ids
				$data = $this->db
					->select('page_id, sub_menu_desc')
					->where('main_menu_id', $main_menu_id)
					->where_in('page_id', $deptIds)
					->get('site_sub_menus')
					->result_array();
			}
			
			
			$dataArray=[
					'data' => $data,
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash()
				];
			
			echo json_encode($dataArray);
	}
	
	
	
	public function updateUserRecord(){
		
		if($this->session->userdata('session_id')==session_id())
	    {


		$nonce_post    = $this->input->post('form_nonce');
        $nonce_session = $this->session->userdata('form_nonce');

        // ✅ 1. Validate custom nonce
        if (empty($nonce_post) || ($nonce_post !== $nonce_session)) {
            $this->session->set_flashdata('error', 'Invalid or reused submission!');
            redirect('faq-details');
        }

        // remove nonce to prevent reuse
        $this->session->unset_userdata('form_nonce');	
		

			
			//echo"<pre>";print_r($this->input->post('updateuserdetails'));echo"</pre>";die();
			
	        $editid = $this->uri->segment('2');	 
		
	        $data['dtl'] = $this->CreateUserModel->get_row('users',  $editid);
	        
			if($this->input->post('updateuserdetails'))
	        {
				$dept_id = $this->input->post('dept_id');
	            $user_id = $this->input->post('user_id');
	            $user_name = $this->input->post('user_name');
	            $user_mobile = $this->input->post('user_mobile');
	            $user_email = $this->input->post('user_email');	           
	            $designation_id = $this->input->post('designation_id');
	            $user_type = $this->input->post('user_type');
	            $user_category = $this->input->post('user_category');           
			   
			   
			   if (isset($_FILES['photo_url']) && $_FILES['photo_url']['error'] == 0) {

					// Get file information
					$file_name = $_FILES['photo_url']['name'];
					$file_tmp = $_FILES['photo_url']['tmp_name'];
					$file_size = $_FILES['photo_url']['size'];
					$file_error = $_FILES['photo_url']['error'];
					
					// Allowed file types
					$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
					$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					
					// Validate the file extension
					if (!in_array($file_ext, $allowed_extensions)) {
						echo "Error: Only pdf files are allowed.";
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
                                                            $upload_path.=$folder."upload/notice/";
                                                            //$thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                   // mkdir($thumbspath, 0777, true);
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
                                                            $upload_path.=$folder."upload/notice/";
                                                           // $thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                   // mkdir($thumbspath, 0777, true);
                                                                }
                                                             
                                                            
                                                        }
                                        }
                                        else
                                        {
                                             $upload_path.=$curmonth."/";
                                            
                                            if (!file_exists($upload_path)) 
                                                        {
                                                            $upload_path.=$folder."upload/notice/";
                                                           // $thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                   // mkdir($thumbspath, 0777, true);
                                                                }
                                                             
                                                            
                                                        }
                                                        else
                                                        {
                                                            $upload_path.=$folder."upload/notice/";
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
							if (!move_uploaded_file($_FILES['photo_url']['tmp_name'], $file_name_path)) {
								return "Error: Failed to upload the image.";
							}
						
					}
					
				} else {
					echo "Error: No file selected or file upload error.";
				}
			   	           
                date_default_timezone_set('Asia/Kolkata');
                $todat_date_time = date('Y-m-d H:i:s');
                
				if(!empty($file_name_path)){
					$Array = array(
						'user_id' => $user_id, 
						'user_type' => $user_type, 
						'user_name' => $user_name,				
						'user_mobile' => $user_mobile, 
						'user_category' => $user_category, 
						'user_email' => $user_email, 
						'author' => $_SESSION['userid'],		
						'designation_id' => $designation_id                  
						//'photo_url' => $file_name_path,
                    );
				}else{
					$Array = array(
						'user_id' => $user_id, 
						'user_type' => $user_type, 
						'user_name' => $user_name,
						'user_mobile' => $user_mobile, 
						'user_category' => $user_category, 
						'user_email' => $user_email, 	
						'author' => $_SESSION['userid'],								
						'designation_id' => $designation_id	
                    );
				}	
				
				foreach($Array as $Arr){
					if (preg_match('/<[^<]+>/', $Arr)) {
						echo "Error: HTML or script tag detected in ".$Arr." field!" ;
						redirect ('all-user-list');
						exit;
					}
				}
					
				//echo "<pre>";print_r($Array);echo "</pre>";die();  
				
                $run = $this->CreatePublicNoticeCustModel->update('users', $Array,$editid);
                 if ($run) 
				   {
				     $this->session->set_flashdata('success', 'Updated Successfully !!');
				     redirect ('all-user-list');
				   }
	        }
		}
	}
	public function addUserRecord(){
				
		
		if($this->session->userdata('session_id')==session_id())
	    {	


		$nonce_post    = $this->input->post('form_nonce');
        $nonce_session = $this->session->userdata('form_nonce');

        // ✅ 1. Validate custom nonce
        if (empty($nonce_post) || ($nonce_post !== $nonce_session)) {
            $this->session->set_flashdata('error', 'Invalid or reused submission!');
            redirect('faq-details');
        }

        // remove nonce to prevent reuse
        $this->session->unset_userdata('form_nonce');	
		

		//echo "<pre>";print_r($this->input->post('submituserdetails'));echo "</pre>";die();  
	
	        if($this->input->post('submituserdetails')=='Submit')
	        {					          
				$dept_id = $this->input->post('zonal_dept_id');
	            $user_id = $this->input->post('user_id');
	            $user_name = $this->input->post('user_name');
	            $user_mobile = $this->input->post('user_mobile');
	            $user_email = $this->input->post('user_email');	           
	            $designation_id = $this->input->post('designation_id');
	            $user_type = $this->input->post('user_type');
	            $user_category = $this->input->post('user_category');
				
				if (isset($_FILES['photo_url']) && $_FILES['photo_url']['error'] == 0) {

					// Get file information
					$file_name = $_FILES['photo_url']['name'];
					$file_tmp = $_FILES['photo_url']['tmp_name'];
					$file_size = $_FILES['photo_url']['size'];
					$file_error = $_FILES['photo_url']['error'];
					
					// Allowed file types
					$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
					$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					
					// Validate the file extension
					if (!in_array($file_ext, $allowed_extensions)) {
						echo "Error: Only image files are allowed.";
						exit;
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
                                                            $upload_path.=$folder."upload/notice/";
                                                           // $thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                  //  mkdir($thumbspath, 0777, true);
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
														$upload_path.=$folder."upload/notice/";
														//$thumbspath=$upload_path."thumbnails";
														if (!file_exists($upload_path)) 
															{
																mkdir($upload_path, 0777, true);
															   // mkdir($thumbspath, 0777, true);
															}
													}
                                        }
                                        else
                                        {
                                             $upload_path.=$curmonth."/";
                                            
                                            if (!file_exists($upload_path)) 
                                                        {
                                                            $upload_path.=$folder."upload/notice/";
                                                           // $thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                   // mkdir($thumbspath, 0777, true);
                                                                }                                                            
                                                            
                                                        }
                                                        else
                                                        {
                                                            $upload_path.=$folder."upload/notice/";
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
							if (!move_uploaded_file($_FILES['photo_url']['tmp_name'], $file_name_path)) {
								return "Error: Failed to upload the image.";
							}
						
					}
					
				} else {
					echo "Error: No file selected or file upload error.";
				}
				
				if ($user_type!='' && $user_name!='' && $user_mobile!='' && $user_email!='' ){					
					
					date_default_timezone_set('Asia/Kolkata');
					$todat_date_time = date('Y-m-d H:i:s');	
					$password = 'Department@2k25';
					$hashedPassword = $this->mysql_old_password($password);
					// Hash the password
										
					$Array = array(
						'user_id' => $user_id, 
						'user_type' => $user_type, 
						'user_name' => $user_name, 
						'user_pwd' => $hashedPassword, 
						'show_pwd' => $password, 
						'user_mobile' => $user_mobile, 
						'user_category' => $user_category, 
						'user_email' => $user_email, 
						'ulbid' => '300', 
						'base_url' => 'http://localhost:8080/', 
						'designation_id' => $designation_id,                   
						//'photo_url' => $file_name_path,					
						'author' => $_SESSION['userid'],					
						'flag' => 1,					
						'banner' => 'new user',					
						'is_custom_user' => 'No',					
						'ts' =>$todat_date_time
						);
		
					foreach($Array as $Arr){
						if (preg_match('/<[^<]+>/', $Arr)) {
							echo "Error: HTML or script tag detected in ".$Arr." field!" ;
							redirect ('all-user-list');
							exit;
						}
					}	
					
					$DeptArray = array(
						'user_id' => $user_id, 
						'dept_id' => $dept_id						
						);
				
					foreach($DeptArray as $Arr){
						if (preg_match('/<[^<]+>/', $Arr)) {
							echo "Error: HTML or script tag detected in ".$Arr." field!" ;
							redirect ('all-user-list');
							exit;
						}
					}

		
		
					$run = $this->CreateUserModel->insert('users', $Array);
					$run2 = $this->CreateUserModel->userDepartmentMap('user_department_map', $DeptArray);
					
					//echo "<pre>";print_r($run2);echo "</pre>";die();	
					
					if ($run){
						
						$this->session->set_flashdata('success', 'Added Successfully !!');
						redirect('/all-user-list');
					}
					
				}

	        }
		}
		
		
	}
	
	
	public function index()
	{
		//echo "<pre>";print_r($_SESSION);echo "</pre>";die('sss');
		
		if (!in_array($this->session->userdata('userid'),super_dev_admin())) {
			$this->session->set_flashdata('error_message','Sorry you dont have permissions');
			//echo "Error: Sorry you don't have permissions!" ;
			redirect ('dashboard');
			exit;
		}
	
		if($this->session->userdata('session_id')==session_id())
	    {		        
	        	       
			$submenudata=array();
			
			$data['main_menu_list']=$this->MenuModel->getMainMenu();
			
			$subMenus=$this->MenuModel->getSubMenu();
			
			$params=array('ulbid'=>$this->session->userdata('ulbid'),'is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
					
			foreach($subMenus as $key=>$val)
			{
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
			}
					 
			$data['sub_menus']=$submenudata;
			$assignedDepartments=array();
					
			$params=array('ulbid'=>$this->session->userdata('ulbid'));
			$data['languageList']=$this->MenuModel->getLanguages($params);
						
			$params=array('user_level'=>'A','is_custumlink'=>3);
			$formdata=$this->MenuModel->getformsdata($params);
			
			foreach($formdata as $key=>$val)
			{
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
			foreach($getselectoptionsdata->result() as $key=>$val)
			{
				$select_options[$val->select_id][$val->option_id]['option_id']=$val->option_id;
				$select_options[$val->select_id][$val->option_id]['option_desc']=$val->option_desc;       
				
			}
			
			$data['select_options']=$select_options;
			// close 
			 $config = array(
				'img_path'      => 'assets/captcha_images/',
				'img_url'       => base_url().'assets/captcha_images/',
				'font_path'     => base_url().'system/fonts/texb.ttf',
				'img_width'     => '180',
				'img_height'    => 50,
				'expiration'    => 3600,
				'word_length'   => 6,
				'font_size'     => 18,
				'colors'        => array(
							'background' => array(255, 255, 227),
							'border' => array(33, 23, 96),
							'text' => array(57, 44, 112),
							'grid' => array(174, 222, 252)
					)
			);
			
			$captcha = create_captcha($config);
			
			// Unset previous captcha and set new captcha word
			$this->session->unset_userdata('captchaCode');
			$this->session->set_userdata('captchaCode', $captcha['word']);
			
			//print_r($data['dependentfieldslist']);
		   
			$params = array('status' => 'Enable');
			
			$data['all']=$this->CreateUserModel->allUsers('users');
			
			foreach($data['all'] as $row){
				//$row->show_pwd=$this->decrypt_data($row->show_pwd);
				$row->show_pwd=$this->decrypt_data($row->show_pwd);
			} 
			
			$data['designations']=$this->CreateUserModel->getDesignations();
			
			$data['departments_list']=$this->CreateUserModel->getDepartments();
			$data['zones_departments_list']=$this->CreateUserModel->getZOfficesDepts();
			$data['categories']=$this->CreateUserModel->getCategories();
			$data['zone_departments_options']=$this->get_all_zonal_and_depts();
						
			//echo "<pre>";print_r($data['zone_departments_options']);echo "</pre>";die();
				
			if (!$this->session->userdata('form_nonce')) {
				$nonce = bin2hex(random_bytes(16));
				$this->session->set_userdata('form_nonce', $nonce);
			} else {
				$nonce = $this->session->userdata('form_nonce');
			}

			$data['form_nonce'] = $nonce;

			$this->load->view('header',$data);
			$this->load->view('all-user-list',$data);
			$this->load->view('divdata',$data);
			$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('/');
	    }

	}
	
	public function mysql_old_password($password) {
		return '*5067BBC356CD288604FEF30FFDA4FEAB067DF338'; //Department@2k25
		//return md5($password);
	}
	
	public function delete()
	{
	    $delid = intval($this->uri->segment('3'));
		//var_dump($delid);die();
	    $del = $this->CreatePublicNoticeCustModel->delete('cust_public_notices', array('id' => $delid));
	    if ($del) 
	     {
	   	  $this->session->set_flashdata('success', 'Deleted Successfully !! ');
	      redirect('public-notices-cust');
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
	
	public function edit_user()
	{
	    
	   if($this->session->userdata('session_id')==session_id())
	    {
			
			//echo"<pre>";print_r($this->input->post('updateuserdetails'));echo"</pre>";die();
			
	        $editid = $this->uri->segment('2');	 
		
	        $data['dtl'] = $this->CreateUserModel->get_row('users',  $editid);		
	        
		
		$submenudata=array();
	    	
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
				
	    $subMenus=$this->MenuModel->getSubMenu();
			    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'),'is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
	  
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    $data['sub_menus']=$submenudata;
					
	    //$data['categories']=$this->CreatePostModel->getPostCategories($params);
		$assignedDepartments=array();
		
	    $categories=$this->CreatePostModel->getPostCategories($params,$assignedDepartments);
		
			    // echo "<pre>";print_r($categories);echo "</pre>";die();  
				 
	    foreach($categories['ulbcategories']->result() as $key=>$val)
	    {
	        $data['categories'][$val->category_id]=$val->category_desc;
	        $data['tbls'][$val->category_id]=$val->table_name;
	    }
	  
	    foreach($categories['admincategories']->result() as $key=>$val)
	    {
	        $data['categories'][$val->category_id]=$val->category_desc;
	        $data['tbls'][$val->category_id]=$val->table_name;
	    }
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	 
	    // category form data
	    $params=array('user_level'=>'A','is_custumlink'=>3);
	    $formdata=$this->MenuModel->getformsdata($params);
		
		    //echo "<pre>";print_r($formdata);echo "</pre>";die();
		
	    foreach($formdata as $key=>$val)
	    {
	        $forms[$val->category_id][$val->sno]['label']=$val->label;
	        $forms[$val->category_id][$val->sno]['type']=$val->type;
	        $forms[$val->category_id][$val->sno]['name']=$val->name;
	        $forms[$val->category_id][$val->sno]['id']=$val->id;
	        $forms[$val->category_id][$val->sno]['class']=$val->class;
	        $forms[$val->category_id][$val->sno]['data_type']=$val->data_type;
	        $forms[$val->category_id][$val->sno]['min_date_after']=$val->min_date_after;
	        
	    }
	    
	    
	    $data['forms']=$forms;
	   // print_r($forms);
	    // getting select options from the table ' select_options_map'
	    
	    $getselectoptionsdata=$this->MenuModel->getselectoptionsdata();
	    foreach($getselectoptionsdata->result() as $key=>$val)
	    {
	        $select_options[$val->select_id][$val->option_id]['option_id']=$val->option_id;
	        $select_options[$val->select_id][$val->option_id]['option_desc']=$val->option_desc;
	       
	        
	    }
	    $data['select_options']=$select_options;
	    // close 
	     $config = array(
            'img_path'      => 'assets/captcha_images/',
            'img_url'       => base_url().'assets/captcha_images/',
            'font_path'     => base_url().'system/fonts/texb.ttf',
            'img_width'     => '180',
            'img_height'    => 50,
            'expiration'    => 3600,
            'word_length'   => 6,
            'font_size'     => 18,
            'colors'        => array(
                        'background' => array(255, 255, 227),
                        'border' => array(33, 23, 96),
                        'text' => array(57, 44, 112),
                        'grid' => array(174, 222, 252)
                )
        );
        $captcha = create_captcha($config);
        
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
        
        // Pass captcha image to view
        // $data_cap['captchaImg'] = $captcha['image'];
        $data['captchaImg'] = $captcha['image'];
	    
	    // getting all dependent fields from the table 'category_form_dependent_mst'
	    
	    $dependent_field_data=$this->MenuModel->getDependentFielddata();
	    foreach($dependent_field_data->result() as $key=>$val)
	    {
	        $dependentParentFields[$val->field_id]=$val->field_id; // dependent parent fields
	        $hiddenfields[$val->dependent_field_id]=$val->dependent_field_id; // dependent child fields
	        $setFunctionValues[$val->field_id]=$val->dependent_field_id; // in view we are setting 'dependentFunction' for that purpose we are setting this array values 
	    }
	    $data['dependentfieldslist']=$dependentfieldslist;
	    $data['hiddenfields']=$hiddenfields;
	    $data['dependentParentFields']=$dependentParentFields;
	    $data['setFunctionValues']=$setFunctionValues;
	    
	    //print_r($data['dependentfieldslist']);
	    
	    // close 
		
	    $params = array('ulbid'=>$this->session->userdata('ulbid'),'status'=>1);
	    $data['create_media_data']=$this->ViewAlbumModel->createMediaData($params);
	     
	    $params = array('status' => 'Enable');
	    $data['all']= $this->CreatePostModel->all_records('cust_public_notices', $params);
	    //print_r($data['all_startups_partners']);exit;
		
		$data['designations']=$this->CreateUserModel->getDesignations();
			
		$data['departments_list']=$this->CreateUserModel->getDepartments();
		$data['categories']=$this->CreateUserModel->getCategories();
		
	    $this->load->view('header',$data);
	
	    $this->load->view('edit_user',$data);
	    		
		$this->load->view('divdata',$data);
		$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('/admin/');
	    }
	}
	
	
	public function get_all_zonal_and_depts()
	{	
		// Get Zonal Offices and Departments from model
		$zoneDeptData = $this->CreateUserModel->getZOfficesDepts();

		// Extract just the dept_ids (keys) into a flat array
		$zonedeptIds = array_keys($zoneDeptData);

		// Get matching sub menus based on main_menu_id and mapped dept_ids
		$data = $this->db
			->select('page_id, sub_menu_desc')
			->where_in('main_menu_id', $zonedeptIds) // Corrected method name: where_id ? where_in
			->get('site_sub_menus')
			->result_array();
			
			$dataArray=[];
			
			foreach($data as $key=>$value){
				$dataArray[$value['page_id']]=$value['sub_menu_desc'];
			}
			
		return $dataArray;
	}
	
	public function get_user_zone_and_depts($userid)
	{	
		// Get Zonal Offices and Departments from model
		$zoneDeptData = $this->CreateUserModel->getUserZonesDepts($userid);



		
			
		return $zoneDeptData;
	}
}

