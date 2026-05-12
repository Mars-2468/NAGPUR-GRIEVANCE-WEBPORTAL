<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
class ImpLinksController extends MY_Controller {

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
	    $this->load->model('CreateImpLinkModel');
	    $this->load->model('CreatePostModel');
	    $this->load->model('ViewAlbumModel');
	    $this->load->library('form_validation');
	    $this->load->library('CategoryFunctions');
	    $this->load->helper('captcha');
	    $this->CategoryFunctions=new CategoryFunctions();
	    
	}
	 
	
	 
	public function addImpLinkRecord(){
		
		if($this->session->userdata('session_id')==session_id())
	    {		
	
			$this->_verify_nonce();
			
	        if($this->input->post('submitimplinks')=='Submit')
	        {
						
	            $lang_id = $this->security->xss_clean(trim($this->input->post('lang_id')));
	            $des = $this->security->xss_clean(trim($this->input->post('des')));
	            $title = $this->security->xss_clean(trim($this->input->post('title')));
	            $linkurl = $this->security->xss_clean(trim($this->input->post('linkurl')));
				
				if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {

					// Get file information
					$file_name = $_FILES['logo']['name'];
					$file_tmp = $_FILES['logo']['tmp_name'];
					$file_size = $_FILES['logo']['size'];
					$file_error = $_FILES['logo']['error'];
					
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
							
				//	echo "<pre>";print_r($file_name_path);echo "</pre>";die();	
					
							// Move the uploaded file to the target directory
							if (!move_uploaded_file($_FILES['logo']['tmp_name'], $file_name_path)) {
								return "Error: Failed to upload the image.";
							}
						
					}
					
				} else {
					echo "Error: No file selected or file upload error.";
				}

				if ($lang_id!='' && $des!='' && $title!='' && $linkurl!=''){					
					
					date_default_timezone_set('Asia/Kolkata');
					$todat_date_time = date('Y-m-d H:i:s');
					
					$Array = array(
						'lang_id' => $lang_id,			                  
						'des' => $des, 
						'title' => $title, 			                 
						'url' => $linkurl, 			                   
						'logo' => $file_name_path, 			                   
						'status' => 'Enable',
						'created_at' =>$todat_date_time
						);
					
					foreach($Array as $Arr){
						if (preg_match('/<[^<]+>/', $Arr)) {
							echo "Error: HTML or script tag detected in ".$Arr." field!" ;
							redirect ('imp-links');
							exit;
						}
					}	
					
					$run = $this->CreateImpLinkModel->insert('imp_links', $Array);
					
					if ($run){
						$this->session->set_flashdata('success', 'Added Successfully !!');
						redirect('imp-links');
					}
					
				}

	        }
		}
	}
	
	
	public function index()
	{
		if (!in_array($this->session->userdata('userid'),super_admin_dept_user_ids())) {
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
			//$data['categories']=$this->CreatePostModel->getPostCategories($params);
		   // $categories=$this->CreatePostModel->getPostCategories($params, $assignedDepartments);
					
			$params=array('ulbid'=>$this->session->userdata('ulbid'));
			$data['languageList']=$this->MenuModel->getLanguages($params);
						
			// category form data
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
					   
			$params = array('status' => 'Enable');
			
			$data['all']=$this->CreateImpLinkModel->all('imp_links', $params);
			
			//echo"<pre>";print_r( $data['all']);echo"</pre>";die();
			 
						
			if (!$this->session->userdata('form_nonce')) {
				$nonce = bin2hex(random_bytes(16));
				$this->session->set_userdata('form_nonce', $nonce);
			} else {
				$nonce = $this->session->userdata('form_nonce');
			}

			$data['form_nonce'] = $nonce;
				
						
			$this->load->view('header',$data);
			$this->load->view('imp-links',$data);
			$this->load->view('divdata',$data);
			$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('login');
	    }
	    
	
	}
	
	public function delete()
	{
	    $delid = $this->uri->segment('3');
	    $del = $this->CreateImpLinkModel->delete('imp_links', array('id' => $delid));
	    if ($del) 
	     {
	   	  $this->session->set_flashdata('success', 'Deleted Successfully !! ');
	      redirect('imp-links');
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
	
	public function updateImpLinkRecord(){
		
		
		//$editid = $this->uri->segment('2');	 
		
	    $this->_verify_nonce();
    	
		//echo "<pre>";print_r($this->input->post());echo "</pre>";die();
		
		if($this->input->post('updateimplinks')){
			
			$editid = $this->security->xss_clean(trim($this->input->post('id')));
			$des = $this->security->xss_clean(trim($this->input->post('des')));
			$title = $this->security->xss_clean(trim($this->input->post('title')));
			$linkurl = $this->security->xss_clean(trim($this->input->post('linkurl')));
			 $lang_id = $this->security->xss_clean(trim($this->input->post('lang_id')));
		   
		   
		   if (!empty($_FILES['logo']) && $_FILES['logo']['error'] == 0) {

				// Get file information
				$file_name = $_FILES['logo']['name'];
				$file_tmp = $_FILES['logo']['tmp_name'];
				$file_size = $_FILES['logo']['size'];
				$file_error = $_FILES['logo']['error'];
				
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
						
			//	echo "<pre>";print_r($file_name_path);echo "</pre>";die();	
				
						// Move the uploaded file to the target directory
						if (!move_uploaded_file($_FILES['logo']['tmp_name'], $file_name_path)) {
							return "Error: Failed to upload the image.";
						}
					
				}
				
			} /* else {
				
				//$file_path_name=null;
				echo "Error: No file selected or file upload error.";
			} */
		   
		   
		   // echo "<pre>";print_r($title);echo "</pre>";die();   
			date_default_timezone_set('Asia/Kolkata');
			$todat_date_time = date('Y-m-d H:i:s');
			
		   if(!empty($file_name_path)){
			 $Array = array(
					'des' => $des, 
					'title' => $title, 
					'url' => $linkurl,  
					'lang_id' => $lang_id,                   
					'logo' => $file_name_path,                   
					'updated_at' =>$todat_date_time
					);
		   }else{
			$Array = array(
					'des' => $des, 
					'title' => $title, 
					'url' => $linkurl,  
					'lang_id' => $lang_id,    
					'updated_at' =>$todat_date_time
					);
		  }	
			

//echo "<pre>";print_r($Array);echo "</pre>";die();
			
			$run = $this->CreateImpLinkModel->update('imp_links', $Array,$editid);
			 if ($run) 
			   {
				 $this->session->set_flashdata('success', 'Updated Successfully !!');
				 redirect ('imp-links');
			   }
		}
	        
		
	}
	
	
	
	public function edit_text_implinks()
	{
	    
	   if($this->session->userdata('session_id')==session_id())
	    {
			
			//echo"<pre>";print_r($this->input->post('updateimplinks'));echo"</pre>";die();
			
	        $editid = $this->uri->segment('2');	 
		
	        $data['dtl'] = $this->CreateImpLinkModel->get_row('imp_links',  $editid);
	     
		
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
	    $data['all']= $this->CreatePostModel->all_records('imp_links', $params);
	    //print_r($data['all_startups_partners']);exit;
	    
		if (!$this->session->userdata('form_nonce')) {
            $nonce = bin2hex(random_bytes(16));
            $this->session->set_userdata('form_nonce', $nonce);
        } else {
            $nonce = $this->session->userdata('form_nonce');
        }

        $data['form_nonce'] = $nonce;
		
		$this->load->view('header',$data);
		$this->load->view('edit_text_implinks',$data);
	 	$this->load->view('divdata',$data);
		$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
		  /** 🔒 Central nonce verification method */
    private function _verify_nonce()
    {
        $nonce_post    = $this->input->post('form_nonce');
        $nonce_session = $this->session->userdata('form_nonce');

        if (empty($nonce_post) || $nonce_post !== $nonce_session) {
            $this->session->set_flashdata('error', 'Invalid or reused submission!');
            redirect($_SERVER['HTTP_REFERER'] ?? 'imp-links');
            exit;
        }

        // destroy nonce to prevent reuse
        $this->session->unset_userdata('form_nonce');
    }
	
}

