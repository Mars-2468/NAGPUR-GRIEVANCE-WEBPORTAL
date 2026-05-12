<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	ini_set('display_errors',0);
	class ViewWidgetsController extends MY_Controller {
		
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
			
			$this->load->library('form_validation');
			$this->load->model('ViewPagesModel');
			$this->load->model('ViewWidgetModel');
			$this->load->model('ViewAlbumModel');
			$this->load->model('CreateWidgetModel');
			//$this->load->helper('secure');
		}
		/*** edit image text widget ****/
		
	 	public function set_upload_options($upload_path)
        {  
            if($this->session->userdata('session_id')==session_id())
			{
				
				$config = array();
				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']      = '20480';
				$config['overwrite']     = FALSE;
				
				return $config;
			}
			else
			{
				redirect('/');
			}
		}
        
        /*** image cropping **/
        public function cropimage($params)
        {
            
            if($this->session->userdata('session_id')==session_id())
			{
				
				$destinationWidth  = $params['destinationWidth'];
				$destinationHeight = $params['destinationHeight'];
				$x=$params['x'];
				$y=$params['y'];
				$w=$params['w'];
				$h=$params['h'];
				$resource=$params['resource'];
				$resource    = imagecreatefromjpeg($resource);
				$destination = imagecreatetruecolor($destinationWidth, $destinationHeight);
				imagecopyresized($destination, $resource, 0, 0, -$x, -$y, $destinationWidth, $destinationHeight, $w, $h);
				header('Content-Type: image/jpg');
				imagepng($destination, $params['destination_path']);
			}
			else
			{
				redirect('/');
			}
		}
        /**** close ****/
        
        
        public function getFilepath()
        {
            
			if($this->session->userdata('session_id')==session_id())
			{   
				
				$curyear=date("Y");
                $curmonth=date('m');
				
				$upload_path='../assets/'.$this->session->userdata('ulbid').'/';
				
				if (!file_exists($upload_path)) 
				{
					mkdir($upload_path, 0777, true);
					$upload_path.=$curyear."/";
					if (!file_exists($upload_path)) 
					{
						mkdir($upload_path, 0777, true);
						//$upload_path.="widgets/";
						$upload_path.=$curmonth."/";
						if (!file_exists($upload_path)) 
						{
							mkdir($upload_path, 0777, true);
							//$upload_path.=$curmonth."/";
							$upload_path.="widgets/";
							$thumbspath=$upload_path;
							if (!file_exists($upload_path)) 
							{
								mkdir($upload_path, 0777, true);
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
						//$upload_path.="widgets/";
						$upload_path.=$curmonth."/";
						if (!file_exists($upload_path)) 
						{
							mkdir($upload_path, 0777, true);
							//$upload_path.=$curmonth."/";
							$upload_path.="widgets/";
							$thumbspath=$upload_path;
							if (!file_exists($upload_path)) 
							{
								mkdir($upload_path, 0777, true);
							}
						}
					}
					else
					{
						//$upload_path.="widgets/";
						$upload_path.=$curmonth."/";
						if (!file_exists($upload_path)) 
						{
							mkdir($upload_path, 0777, true);
							//$upload_path.=$curmonth."/";
							$upload_path.="widgets/";
							$thumbspath=$upload_path;
							if (!file_exists($upload_path)) 
							{
								mkdir($upload_path, 0777, true);
							}
						}
						else
						{
							//$upload_path.=$curmonth."/";
							$upload_path.="widgets/";
							$thumbspath=$upload_path;
							if (!file_exists($upload_path)) 
							{
								mkdir($upload_path, 0777, true);
							}
						}
					}
				}
				
				$thumbspath.="thumbs/";
				
				if (!file_exists($thumbspath)) 
				{
					mkdir($thumbspath, 0777, true);
				}
				
				$data['upload_path']=$upload_path;
				$data['thumbspath']=$thumbspath;
				
				
				return $data;
			}
			else
			{
				redirect('/');
			}
		}
        
        public function uploadfile()
        {
		//echo "<pre>";print_r($this->session->userdata('session_id'));echo "</pre>";die();
			
            if($this->session->userdata('session_id')==session_id())
			{
				
				$data=$this->getFilepath();
				$upload_path=$data['upload_path'];
				$thumbs_path=$data['thumbspath'];
				$files = $_FILES;
				$this->load->library('upload');
				
				$_FILES['userfile']['name']= $files['userfile']['name'];
				$_FILES['userfile']['type']= $files['userfile']['type'];
				$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
				$_FILES['userfile']['error']= $files['userfile']['error'];
				$_FILES['userfile']['size']= $files['userfile']['size'];
            
				$this->upload->initialize($this->set_upload_options($upload_path));
				if(!$this->upload->do_upload())
				{
					//print_r($this->upload->display_errors());
				}
				
				$upload_data = $this->upload->data();
				
					
				/** checking for malicious file upload **/
				
                    $file_info = new finfo(FILEINFO_MIME_TYPE);
                    $mime_types_array = array('image/jpg','image/jpeg','image/png','image/gif');
                    $mime_types_array2 = array('image/jpg','image/jpeg','image/png');
                    $finopath = $target_file;
                    //$a = getimagesize($upload_data['full_path']);
                   
                    $filename = date('YmdHis').rand(999,100000).".".$upload_data['image_type'];
                  
                    $mime_type = $file_info->buffer(file_get_contents($upload_data['full_path']));
					
           //echo "<pre>";print_r($mime_type);echo "</pre>";die();
						
                        if(!in_array($mime_type,$mime_types_array))
                           {
                               unlink($upload_data['full_path']);
                               //die('Invalid file type');
							   $this->session->set_flashdata('image_error','Invalid file format - '.$mime_type.'<br> ( jpeg, jpg, png, gif are only allowed formats! )');
							   redirect($this->input->post('url'));
                           }
                           else
                           {
								$src_file = $upload_data['full_path'];
								$dest_file = $upload_path.$filename; 
							 
							 	$upload_path=$upload_path.$filename;
								$thumbs_path=$thumbs_path.$filename;
									 
								$this->session->set_flashdata('resource',$upload_path);
								$this->session->set_flashdata('thumbs',$thumbs_path);
								$this->session->set_flashdata('filename',$filename);
								//$this->session->set_flashdata('dest_file',$dest_file);
								
								if (move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_path)) {
									echo "The file ". htmlspecialchars( basename( $_FILES['userfile']["name"])). " has been uploaded.";
								} else {
									echo "Sorry, there was an error uploading your file.";
								}
								
							//echo "<pre>";print_r($upload_path);echo "</pre>";die();
							
								/* $img_quality = 70;
								header('Content-Type: image/png');
								$im = imagecreatefromstring(file_get_contents($src_file));
								$im_w = imagesx($im);
								$im_h = imagesy($im);
								$tn = imagecreatetruecolor($im_w, $im_h);
								 
								imagecopyresampled ( $tn , $im, 0, 0, 0, 0, $im_w, $im_h, $im_w, $im_h );
																 	
								imagejpeg($tn,$dest_file,$img_quality);								
								
								unlink($upload_data['full_path']); */
								

								unlink($upload_data['full_path']); // Remove original file

							
                               
                           }
                   
                    /** close **/
                    
				
				//$params = array('widget_name' => $this->input->post('widget_name'),'widget_id' => $this->input->post('widget_id'));
				// $this->ViewWidgetModel->singleImageLinkWidget($params);
			
				//$url="edite-widget/".$this->input->post('widget_id')."/".$this->input->post('widget_type');
				redirect($this->input->post('url'));
			}
			else
			{
				redirect('/');
			}
            
		}
		
		public function editImageTextwidget()
		{
			if($this->session->userdata('session_id')==session_id())
			{ 
				
				if($this->input->post('save'))
				{
					$userLevel = $this->session->userdata('user_type');
					$reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type_style")));
					
					$this->form_validation->set_rules('widget_name', 'widget_name', 'trim|required');
					
					/** open getting categories and ulb list **/
					
					$data['widget_det']=array(					
    					'widget_id'         =>  $this->security->xss_clean(trim($this->input->post('widget_id'))),
    					'widget_type'       =>  $this->security->xss_clean(trim($this->input->post('widget_type'))),
    					'widget_type_style' =>  $this->security->xss_clean(trim(strip_tags($this->input->post('widget_type_style')))),
    					'ulbid'             =>  $this->session->userdata('ulbid'),
    					'user_type'         =>  $this->session->userdata('user_type'),
    					'langId'            =>  $this->session->userdata('langId')
					);
					
					$data['result'] =   $this->getImageTextwidgetContent($data['widget_det']);
					
					$allCategories = array();
					foreach($data['result']['allcategories'] as $key=>$val){
						$allCategories[] = $val['page_id'];
					}
					
					$data['ulbList'] = $this->CreateWidgetModel->getUlbList();
					$allUlbList = array();
					foreach($data['ulbList'] as $key=>$val){
						$allUlbList[] = $val['ulbid'];
					}
					/** close getting categories and ulb list **/
										
				
					if ($this->form_validation->run() == FALSE){
						$this->session->set_flashdata('message',"<div class='alert alert-danger'>  Please Enter Widget Name </div>");
						redirect($reDir);
					}
					
					if($userLevel == 'A'){
						
						$this->form_validation->set_rules('radio', 'radio', 'required');
						
						if ($this->form_validation->run() == FALSE){
							$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , Please select Edit</div>");
							redirect($reDir);
						}
						else
						{
							/** start based on radio button value if else condtion **/
							
							$radioVal = $this->security->xss_clean(trim($this->input->post('radio')));
							if($radioVal == 'edit')  /// edit radio button function
							{          
								$ulbid = $this->session->userdata('ulbid');
								
								$ulb_check_list = $this->input->post('ulb_check_list');
								//  print_r($ulb_check_list);echo "<br/>";
								array_push($ulb_check_list,$ulbid);
								//print_r($ulb_check_list);echo "<br/>";								
								
								$params=array(
								'widget_id'         =>  $this->security->xss_clean(trim($this->input->post('widget_id'))),
								'widget_name'       =>  $this->security->xss_clean(trim($this->input->post('widget_name'))),
								'widget_type'       =>  $this->security->xss_clean(trim($this->input->post('widget_type'))),
								'widget_type_style' =>  $this->security->xss_clean(trim(strip_tags($this->input->post('widget_type_style')))),
								'file_name'         =>  $this->security->xss_clean(trim($this->input->post('file_name'))),
								'thumbnail_path'    =>  substr($this->security->xss_clean(trim($this->input->post('thumbspath'))),2),
								'source_path'       =>  substr($this->security->xss_clean(trim($this->input->post('resource'))),2),
								'title'             =>  $this->security->xss_clean(trim($this->input->post('title'))),
								'url_link'          =>  $this->security->xss_clean(trim($this->input->post('page_url'))),
								'target'            =>  $this->security->xss_clean(trim($this->input->post('target'))),
								'imgx'              =>  $this->security->xss_clean(trim($this->input->post('imgx'))),
								'imgy'              =>  $this->security->xss_clean(trim($this->input->post('imgy'))),
								'width'             =>  $this->security->xss_clean(trim($this->input->post('width'))),
								'height'            =>  $this->security->xss_clean(trim($this->input->post('height'))),
								'description'       =>  $this->security->xss_clean(trim($this->input->post('description'))),
								'eventDate'         =>  date('Y-m-d', strtotime($this->input->post('eventDate'))),
								'eventTime'         =>  date('H:i:s', strtotime($this->input->post('eventTime'))),	
								'ulb_check_list'    =>  $ulb_check_list,
								'radio'             =>  $this->security->xss_clean(trim($this->input->post('radio'))),
								'author'            =>  $this->session->userdata('userid'),
								'user_level'        =>  $this->session->userdata('user_type'),
								'flag'              =>  1,
								'langId'            =>  $this->session->userdata('langId')
								);
								
								// print_r($params);exit;
								
								$result=$this->ViewWidgetModel->editImageTextwidget($params);
							}
							
							/** end based on radio button value if else condtion **/
						}
					}
					
					if($result)
					{
						$this->session->set_flashdata('message',"<div class='alert alert-success'> Widget updated successfully </div>");
						redirect('view-widgets');
					}
					else
					{
						$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , try again </div>");
						redirect($reDir);
					}
				}
			}
			else
			{
				redirect('/');
			}
		}
		
		/*** close ****/
		/**** text widget functions *****/
		
		
		public function editMenuwidget()
		{
			
			if($this->session->userdata('session_id')==session_id())
			{
				
				
				if($this->input->post('save')){
					$userLevel = $this->session->userdata('user_type');
					//  $reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type")));
					$reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type_style")));
					$this->form_validation->set_rules('widget_name', 'widget_name', 'trim|required');
					
					
					$data['widget_det']=array(
					
					'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
					'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
					'widget_type_style'=>$this->security->xss_clean(trim(strip_tags($this->input->post('widget_type_style')))),
					'ulbid' => $this->session->userdata('ulbid'),
					'user_type'=> $this->session->userdata('user_type'),
					'langId' => $this->session->userdata('langId')
					);
					
					$data['result']=$this->getMenuwidgetContent($data['widget_det']);
					
					
					
					/** open getting ulb list **/
					
					$data['ulbList'] = $this->CreateWidgetModel->getUlbList();
					$allUlbList = array();
					foreach($data['ulbList'] as $key=>$val){
						$allUlbList[] = $val['ulbid'];
					}
					/** close getting ulb list **/
					
					if ($this->form_validation->run() == FALSE){
						$this->session->set_flashdata('message',"<div class='alert alert-danger'>  Please Enter Widget Name </div>");
						redirect($reDir);
					}
					if($userLevel == 'A'){
						
						$this->form_validation->set_rules('radio', 'radio', 'required');
						
						if ($this->form_validation->run() == FALSE){
							$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , Please select Edit or Delete </div>");
							redirect($reDir);
							}else{
							
							/** start based on radio button value if else condtion **/
							
							$radioVal = $this->security->xss_clean(trim($this->input->post('radio')));
							if($radioVal == 'edit'){          /// edit radio button function
							
								$ulbid = $this->session->userdata('ulbid');
								$ulb_check_list = $this->input->post('ulb_check_list');
								// print_r($ulb_check_list);echo "<br/>";
								array_push($ulb_check_list,$ulbid);
								//print_r($ulb_check_list);echo "<br/>";
								
								
								
								$params=array(
								'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
								'menu_type_id'=>$this->security->xss_clean(trim($this->input->post('menu_type_id'))),
								'widget_name'=>$this->security->xss_clean(trim($this->input->post('widget_name'))),
								'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
								'author' => $this->session->userdata('userid'),
								'ulb_check_list' => $ulb_check_list,
								'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
								'user_level' => $this->session->userdata('user_type'),
								'flag' => 1,
								'langId'=>$this->session->userdata('langId')
								);
								$result=$this->ViewWidgetModel->editMenuwidget($params);
								
								}else if($radioVal == 'editexcept'){    /// edit except radio button function
								$ulbList = $this->security->xss_clean(trim($this->input->post('ulb_check_list')));
								$ulb_check_list = array();
								
								$ulb_check_list = array_diff($allUlbList,$ulbList);
								
								$params=array(
								'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
								'menu_type_id'=>$this->security->xss_clean(trim($this->input->post('menu_type_id'))),
								'widget_name'=>$this->security->xss_clean(trim($this->input->post('widget_name'))),
								'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
								'author' => $this->session->userdata('userid'),
								'ulb_check_list' => $ulb_check_list,
								'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
								'user_level' => $this->session->userdata('user_type'),
								'flag' => 1,
								'langId'=>$this->session->userdata('langId')
								);
								$result=$this->ViewWidgetModel->editMenuwidget($params);
								
								}else if($radioVal == 'delete'){   /// delete radio button function
								$params=array(
								'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
								'menu_type_id'=>$this->security->xss_clean(trim($this->input->post('menu_type_id'))),
								'widget_name'=>$this->security->xss_clean(trim($this->input->post('widget_name'))),
								'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
								'author' => $this->session->userdata('userid'),
								'ulb_check_list' => $this->input->post('ulb_check_list'),
								'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
								'user_level' => $this->session->userdata('user_type'),
								'flag' => 1,
								'langId'=>$this->session->userdata('langId')
								);
								$result=$this->ViewWidgetModel->editMenuwidget($params);
								
								}else if($radioVal == 'deleteexcept'){  /// delete except radio button function
								$ulbList = $this->security->xss_clean(trim($this->input->post('ulb_check_list')));
								$ulb_check_list = array();
								
								$ulb_check_list = array_diff($allUlbList,$ulbList);
								
								$params=array(
								'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
								'menu_type_id'=>$this->security->xss_clean(trim($this->input->post('menu_type_id'))),
								'widget_name'=>$this->security->xss_clean(trim($this->input->post('widget_name'))),
								'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
								'author' => $this->session->userdata('userid'),
								'ulb_check_list' => $ulb_check_list,
								'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
								'user_level' => $this->session->userdata('user_type'),
								'flag' => 1,
								'langId'=>$this->session->userdata('langId')
								);
								$result=$this->ViewWidgetModel->editMenuwidget($params);
							}
							
							/** end based on radio button value if else condtion **/
							
						}
						}else{
						
						$params=array(
						'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
						'menu_type_id'=>$this->security->xss_clean(trim($this->input->post('menu_type_id'))),
						'widget_name'=>$this->security->xss_clean(trim($this->input->post('widget_name'))),
						'author' => $this->session->userdata('userid'),
						'user_level' => $this->session->userdata('user_type'),
						'ulbid' => $this->session->userdata('ulbid')
						);
						$result=$this->ViewWidgetModel->editMenuwidget($params);
						
					}      
					if($result){
						$this->session->set_flashdata('message',"<div class='alert alert-success'> Widget updated successfully </div>");
						redirect('view-widgets');
						}else{
						$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , try again </div>");
						redirect($reDir);
					}
					}else{
					redirect('dashboard');
				}
			}
			else
			{
				redirect('/');
			}
			
		}
		
		
		
		public function editTextwidget()
		{
			
			if($this->session->userdata('session_id')==session_id())
			{
				
				
				$userLevel = $this->session->userdata('user_type');
				//$reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type")));
				$reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type_style")));
				$this->form_validation->set_rules('widget_name', 'widget_name', 'trim|required');
				$data['widget_det']=array(
				
				'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
				'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
				'widget_type_style'=>$this->security->xss_clean(trim(strip_tags($this->input->post('widget_type_style')))),
				'ulbid' => $this->session->userdata('ulbid'),
				'user_type'=> $this->session->userdata('user_type'),
				'langId' => $this->session->userdata('langId')
				);
				
				$data['result']=$this->getTextwidgetContent($data['widget_det']);
				
				// print_r($data['result']);
				/** open getting ulb list **/
				
				$data['ulbList'] = $this->CreateWidgetModel->getUlbList();
				$allUlbList = array();
				foreach($data['ulbList'] as $key=>$val){
					$allUlbList[] = $val['ulbid'];
				}
				/** close getting ulb list **/
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('message',"<div class='alert alert-danger'>  Please Enter Widget Name </div>");
					redirect($reDir);
				}
				if($userLevel == 'A'){
					
					$this->form_validation->set_rules('radio', 'radio', 'required');
					
					if ($this->form_validation->run() == FALSE){
						$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , Please select Edit or Delete </div>");
						redirect($reDir);
						}else{
						
						/** Replace Contect text value  here **/
						$content=$this->input->post('content');
						$replaceUrl="../../../";
						$content=str_replace($replaceUrl,'/',$content);
						//$replaceUrl="//";
						//$content=str_replace($replaceUrl,'/',$content);
						
						//echo $content;exit;
						/** start based on radio button value if else condtion **/
						
						$radioVal = $this->security->xss_clean(trim($this->input->post('radio')));
						if($radioVal == 'edit'){          /// edit radio button function
							$ulbid = $this->session->userdata('ulbid');
							$ulb_check_list = $this->input->post('ulb_check_list');
							
							array_push($ulb_check_list,$ulbid);
							
							$params=array(
							'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
							'content'=>$content,
							'widget_name'=>$this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
							'widget_type_style'=>$this->security->xss_clean(trim(strip_tags($this->input->post('widget_type_style')))),
							'author' => $this->session->userdata('userid'),
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							
							$result=$this->ViewWidgetModel->editTextwidget($params);
							
							}else if($radioVal == 'editexcept'){    /// edit except radio button function
							$ulbList = $this->security->xss_clean(trim($this->input->post('ulb_check_list')));
							$ulb_check_list = array();
							
							$ulb_check_list = array_diff($allUlbList,$ulbList);
							
							$params=array(
							'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
							'content'=>$content,
							'widget_name'=>$this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
							'author' => $this->session->userdata('userid'),
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							//print_r($params);
							//exit;
							$result=$this->ViewWidgetModel->editTextwidget($params);
							
							}else if($radioVal == 'delete'){   /// delete radio button function
							$params=array(
							'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
							'content'=>$content,
							'widget_name'=>$this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
							'author' => $this->session->userdata('userid'),
							'ulb_check_list' => $this->input->post('ulb_check_list'),
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							$result=$this->ViewWidgetModel->editTextwidget($params);
							
							}else if($radioVal == 'deleteexcept'){  /// delete except radio button function
							$ulbList = $this->security->xss_clean(trim($this->input->post('ulb_check_list')));
							$ulb_check_list = array();
							
							$ulb_check_list = array_diff($allUlbList,$ulbList);
							
							$params=array(
							'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
							'content'=>$content,
							'widget_name'=>$this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
							'author' => $this->session->userdata('userid'),
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							$result=$this->ViewWidgetModel->editTextwidget($params);
						}
						
						/** end based on radio button value if else condtion **/
					}
					}else{
					
					
					$content=$this->input->post('content');
					$replaceUrl="../../../";
					$content=str_replace($replaceUrl,'/',$content);
					$replaceUrl="//";
					$content=str_replace($replaceUrl,'/',$content);
					
					$params=array(
					'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
					'content'=>$content,
					'widget_name'=>$this->security->xss_clean(trim($this->input->post('widget_name'))),
					'widget_type_style'=>$this->security->xss_clean(trim($this->input->post('widget_type_style'))),
					'author' => $this->session->userdata('userid'),
					'user_level' => $this->session->userdata('user_type'),
					'ulbid' => $this->session->userdata('ulbid')
					);
					
					$result=$this->ViewWidgetModel->editTextwidget($params);
					
				}
				if($result){
					$this->session->set_flashdata('message',"<div class='alert alert-success'> Widget updated successfully </div>");
					redirect('view-widgets');
					}else{
					$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , try again </div>");
					redirect($reDir);
				}
			}
			else
			{
				redirect('/');
			}
		}
		
		
		public function getphotogallerywidgetContent($params)
		{
			if($this->session->userdata('session_id')==session_id())
			{
				
				
				$result=$this->ViewWidgetModel->getphotogallerywidgetContent($params);
				return $result;
			}
			else
			{
				redirect('/');
			}
		}
		
		
		
		public function getImageTextwidgetContent($params)
		{
			
			if($this->session->userdata('session_id')==session_id())
			{
				$result=$this->ViewWidgetModel->getImageTextwidgetContent($params);
				//print_r($result);exit;
				return $result;
			}
			else
			{
				redirect('/');
			}
			
		}
		
		
		
		public function getMenuwidgetContent($params)
		{
			if($this->session->userdata('session_id')==session_id())
			{
				
				$result=$this->ViewWidgetModel->getMenuwidgetContent($params);
				
				return $result;
			}
			else
			{
				redirect('/');
			}
		}
		
		
		public function getMenuwidgetname($params)
		{
			if($this->session->userdata('session_id')==session_id())
			{
				
				
				$Menus=$this->ViewWidgetModel->getMenuwidgetname($params);
				
				
				foreach($Menus as $key=>$val)
				{
					
					$Menus[$val['widget_id']]['widget_name']=$val['widget_name'];
					//print_r($Menus);
					
				}
				
				$data['menus']=$Menus;
				
			}
			else
			{
				redirect('/');
			}
			
			
			
			
		}
		
		
		
		
		public function getTextwidgetContent($params)
		{
			
			if($this->session->userdata('session_id')==session_id())
			{
				
				$result=$this->ViewWidgetModel->getTextwidgetContent($params);
				return $result;
			}
			else
			{
				redirect('/');
			}
		}
		/*****  text widget functions closed ****/ 
		/** tab widget content ***/
		
		public function gettabwidgetContent($params)
		{
			if($this->session->userdata('session_id')==session_id())
			{
				$result=$this->ViewWidgetModel->gettabwidgetContent($params);
				return $result;
			}
			else
			{
				redirect('/');
			}
		}
		
		/*** close ***/
		
		/** post widget **/
		public function getpostwidgetContent($params)
    	{
    	    if($this->session->userdata('session_id')==session_id())
			{
				$result=$this->ViewWidgetModel->getpostwidgetContent($params);
				return $result;
			}
			else
			{
				redirect('/');
			}
		}
		/** close **/
		
		/** page widget **/
	    public function getpagewidgetContent($params){
	        if($this->session->userdata('session_id')==session_id())
			{
				$result = $this->ViewWidgetModel->getpagewidgetContent($params);
				return $result;
			}
			else
			{
				redirect('/');
			}
			
		}
	    
		/** close **/
		
		/** slider widget **/
	    public function getsliderwidgetContent($params){
			// echo "okk";
			//print_r($params);
	        if($this->session->userdata('session_id')==session_id())
			{
				$result = $this->ViewWidgetModel->getsliderwidgetContent($params);
				return $result;
			}
			else
			{
				redirect('/');
			}
			
		}
	    
		/** close **/
		
		
		/** edit tab widget **/
		public function editTabWidget()
		{
			
			if($this->session->userdata('session_id')==session_id())
			{ 
				
				
				$userLevel = $this->session->userdata('user_type');
				//$reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type")));
				$reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type_style")));
				
				$this->form_validation->set_rules('widget_name', 'widget_name', 'trim|required');
				
				/** open getting categories and ulb list **/
				$data['widget_det']=array(
				
				'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
				'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
				'widget_type_style'=>$this->security->xss_clean(trim(strip_tags($this->input->post('widget_type_style')))),
				'ulbid' => $this->session->userdata('ulbid'),
				'user_type'=> $this->session->userdata('user_type'),
				'langId' => $this->session->userdata('langId')
				);
				
				$data['result']=$this->gettabwidgetContent($data['widget_det']);
				$allCategories = array();
				foreach($data['result']['allcategories'] as $key=>$val){
					$allCategories[] = $val['page_id'];
				}
				
				$data['ulbList'] = $this->CreateWidgetModel->getUlbList();
				$allUlbList = array();
				foreach($data['ulbList'] as $key=>$val){
					$allUlbList[] = $val['ulbid'];
				}
				/** close getting categories and ulb list **/
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('message',"<div class='alert alert-danger'>  Please Enter Widget Name </div>");
					redirect($reDir);
				}
				
				if($userLevel == 'A'){
					
					$this->form_validation->set_rules('radio', 'radio', 'required');
					
					if ($this->form_validation->run() == FALSE){
						$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , Please select Edit or Delete </div>");
						redirect($reDir);
						}else{
						/** start based on radio button value if else condtion **/
						
						$radioVal = $this->security->xss_clean(trim($this->input->post('radio')));
						if($radioVal == 'edit'){          /// edit radio button function
							$ulbid = $this->session->userdata('ulbid');
							$ulb_check_list = $this->input->post('ulb_check_list');
							//print_r($ulb_check_list);echo "<br/>";
							array_push($ulb_check_list,$ulbid);
							//print_r($ulb_check_list);echo "<br/>";
							
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'tab_type_id' => $this->security->xss_clean(trim($this->input->post('tab_type_id'))),
							'check_list' => $this->input->post('check_list'),
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							
							$result = $this->ViewWidgetModel->editTabWidget($params);
							
							}else if($radioVal == 'editexcept'){    /// edit except radio button function
							$categoryList = $this->security->xss_clean(trim($this->input->post('check_list')));
							$ulbList = $this->security->xss_clean(trim($this->input->post('ulb_check_list')));
							$check_list = array();
							$ulb_check_list = array();
							
							$check_list = array_diff($allCategories,$categoryList);
							$ulb_check_list = array_diff($allUlbList,$ulbList);
							
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'tab_type_id' => $this->security->xss_clean(trim($this->input->post('tab_type_id'))),
							'check_list' => $check_list,
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							$result = $this->ViewWidgetModel->editTabWidget($params);
							
							}else if($radioVal == 'delete'){   /// delete radio button function
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'tab_type_id' => $this->security->xss_clean(trim($this->input->post('tab_type_id'))),
							'check_list' => $this->input->post('check_list'),
							'ulb_check_list' =>$this->input->post('ulb_check_list'),
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							
							// print_r($params);
							
							$result = $this->ViewWidgetModel->editTabWidget($params);
							
							}else if($radioVal == 'deleteexcept'){  /// delete except radio button function
							$categoryList = $this->security->xss_clean(trim($this->input->post('check_list')));
							$ulbList = $this->security->xss_clean(trim($this->input->post('ulb_check_list')));
							$check_list = array();
							$ulb_check_list = array();
							
							$check_list = array_diff($allCategories,$categoryList);
							$ulb_check_list = array_diff($allUlbList,$ulbList);
							
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'tab_type_id' => $this->security->xss_clean(trim($this->input->post('tab_type_id'))),
							'check_list' => $check_list,
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							$result = $this->ViewWidgetModel->editTabWidget($params);
						}
						
						/** end based on radio button value if else condtion **/
						
					}
					}else{
					$params = array(
					'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
					'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
					'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
					'tab_type_id' => $this->security->xss_clean(trim($this->input->post('tab_type_id'))),
					'check_list' => $this->security->xss_clean(trim($this->input->post('check_list'))),
					'author' => $this->session->userdata('userid'),
					'user_level' => $this->session->userdata('user_type'),
					'flag' => 1,
					'langId'=>$this->session->userdata('langId'),
					'ulbid'=>$this->session->userdata('ulbid')
					);
					$result = $this->ViewWidgetModel->editTabWidget($params);
				}
				
				if($result){
					$this->session->set_flashdata('message',"<div class='alert alert-success'> Widget update successfully </div>");
					redirect('view-widgets');
					}else{
					$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , try again </div>");
					redirect($reDir);
				}
			}
			else
			{
				redirect('/');
			}
			
		}
		
		/**/
		
		/** edit tab widget **/
		public function editpostWidget()
		{
			
			if($this->session->userdata('session_id')==session_id())
			{
				
				$userLevel = $this->session->userdata('user_type');
				//$reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type")));
				$reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type_style")));
				$this->form_validation->set_rules('widget_name', 'widget_name', 'trim|required');
				
				/** open getting categories and ulb list **/
				$data['widget_det']=array(
				
				'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
				'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
				'widget_type_style'=>$this->security->xss_clean(trim(strip_tags($this->input->post('widget_type_style')))),
				'ulbid' => $this->session->userdata('ulbid'),
				'user_type'=> $this->session->userdata('user_type'),
				'langId' => $this->session->userdata('langId')
				);
				
				$data['result']=$this->getpostwidgetContent($data['widget_det']);
				
				$allCategories = array();
				foreach($data['result']['allcategories'] as $key=>$val){
					$allCategories[] = $val['page_id'];
				}
				
				$data['ulbList'] = $this->CreateWidgetModel->getUlbList();
				$allUlbList = array();
				foreach($data['ulbList'] as $key=>$val){
					$allUlbList[] = $val['ulbid'];
				}
				/** close getting categories and ulb list **/
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('message',"<div class='alert alert-danger'>  Please Enter Widget Name </div>");
					redirect($reDir);
				}
				
				if($userLevel == 'A'){
					
					$this->form_validation->set_rules('radio', 'radio', 'required');
					
					if ($this->form_validation->run() == FALSE){
						$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , Please select Edit or Delete </div>");
						redirect($reDir);
						}else{
						/** start based on radio button value if else condtion **/
						
						$radioVal = $this->security->xss_clean(trim($this->input->post('radio')));
						if($radioVal == 'edit'){          /// edit radio button function
							$ulbid = $this->session->userdata('ulbid');
							$ulb_check_list = $this->input->post('ulb_check_list');
							//print_r($ulb_check_list);echo "<br/>";
							array_push($ulb_check_list,$ulbid);
							//print_r($ulb_check_list);echo "<br/>";
							
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'widget_type_style'=>$this->security->xss_clean(trim(strip_tags($this->input->post('widget_type_style')))),
							'check_list' =>  $this->input->post('check_list'),
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							
							$result = $this->ViewWidgetModel->editpostWidget($params);
							
							}else if($radioVal == 'editexcept'){    /// edit except radio button function
							$categoryList = $this->security->xss_clean(trim($this->input->post('check_list')));
							$ulbList = $this->security->xss_clean(trim($this->input->post('ulb_check_list')));
							$check_list = array();
							$ulb_check_list = array();
							
							$check_list = array_diff($allCategories,$categoryList);
							$ulb_check_list = array_diff($allUlbList,$ulbList);
							
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							
							'check_list' => $check_list,
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							$result = $this->ViewWidgetModel->editpostWidget($params);
							
							}else if($radioVal == 'delete'){   /// delete radio button function
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'check_list' => $this->security->xss_clean(trim($this->input->post('check_list'))),
							'ulb_check_list' => $this->input->post('ulb_check_list'),
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							$result = $this->ViewWidgetModel->editpostWidget($params);
							
							}else if($radioVal == 'deleteexcept'){  /// delete except radio button function
							$categoryList = $this->security->xss_clean(trim($this->input->post('check_list')));
							$ulbList = $this->security->xss_clean(trim($this->input->post('ulb_check_list')));
							$check_list = array();
							$ulb_check_list = array();
							
							$check_list = array_diff($allCategories,$categoryList);
							$ulb_check_list = array_diff($allUlbList,$ulbList);
							
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'check_list' => $check_list,
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							$result = $this->ViewWidgetModel->editpostWidget($params);
						}
						
						/** end based on radio button value if else condtion **/
						
					}
					}else{
					$params = array(
					'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
					'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
					'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
					'check_list' => $this->security->xss_clean(trim($this->input->post('check_list'))),
					'author' => $this->session->userdata('userid'),
					'user_level' => $this->session->userdata('user_type'),
					'flag' => 1,
					'langId'=>$this->session->userdata('langId'),
					'ulbid'=>$this->session->userdata('ulbid')
					);
					$result = $this->ViewWidgetModel->editpostWidget($params);
				}
				
				if($result){
					$this->session->set_flashdata('message',"<div class='alert alert-success'> Widget update successfully </div>");
					redirect('view-widgets');
					}else{
					$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , try again </div>");
					redirect($reDir);
				}
			}
			else
			{
				redirect('/');
			}
			
		}
		
		/**/
		
		public function editpageWidget()
		{
			
			if($this->session->userdata('session_id')==session_id())
			{ 
				
				$userLevel = $this->session->userdata('user_type');
				// $reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type")));
				$reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type_style")));
				
				$this->form_validation->set_rules('widget_name', 'widget_name', 'trim|required');
				
				/** open getting categories and ulb list **/
				$data['widget_det']=array(
				
				'widget_id'=>$this->security->xss_clean(trim($this->input->post('widget_id'))),
				'widget_type'=>$this->security->xss_clean(trim($this->input->post('widget_type'))),
				'ulbid' => $this->session->userdata('ulbid'),
				'user_type'=> $this->session->userdata('user_type'),
				'langId' => $this->session->userdata('langId')
				);
				
				$data['result']=$this->getpagewidgetContent($data['widget_det']);
				$allCategories = array();
				foreach($data['result']['allcategories'] as $key=>$val){
					$allCategories[] = $val['page_id'];
				}
				
				$data['ulbList'] = $this->CreateWidgetModel->getUlbList();
				$allUlbList = array();
				foreach($data['ulbList'] as $key=>$val){
					$allUlbList[] = $val['ulbid'];
				}
				/** close getting categories and ulb list **/
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('message',"<div class='alert alert-danger'>  Please Enter Widget Name </div>");
					redirect($reDir);
				}
				
				if($userLevel == 'A'){
					
					$this->form_validation->set_rules('radio', 'radio', 'required');
					
					if ($this->form_validation->run() == FALSE){
						$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , Please select Edit or Delete </div>");
						redirect($reDir);
						}else{
						/** start based on radio button value if else condtion **/
						
						$radioVal = $this->security->xss_clean(trim($this->input->post('radio')));
						if($radioVal == 'edit'){          /// edit radio button function
							$ulbid = $this->session->userdata('ulbid');
							$ulb_check_list = $this->input->post('ulb_check_list');
							//print_r($ulb_check_list);echo "<br/>";
							array_push($ulb_check_list,$ulbid);
							//print_r($ulb_check_list);echo "<br/>";
							
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'check_list' => $this->input->post('check_list'),
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							//print_r($params);
							//exit;
							$result = $this->ViewWidgetModel->editpageWidget($params);
							
							}else if($radioVal == 'editexcept'){    /// edit except radio button function
							$categoryList = $this->input->post('check_list');
							$ulbList = $this->input->post('ulb_check_list');
							$check_list = array();
							$ulb_check_list = array();
							
							$check_list = array_diff($allCategories,$categoryList);
							$ulb_check_list = array_diff($allUlbList,$ulbList);
							
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'check_list' => $check_list,
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							$result = $this->ViewWidgetModel->editpageWidget($params);
							
							}else if($radioVal == 'delete'){   /// delete radio button function
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'check_list' => $this->security->xss_clean(trim($this->input->post('check_list'))),
							'ulb_check_list' => $this->input->post('ulb_check_list'),
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							$result = $this->ViewWidgetModel->editpageWidget($params);
							
							}else if($radioVal == 'deleteexcept'){  /// delete except radio button function
							$categoryList = $this->security->xss_clean(trim($this->input->post('check_list')));
							$ulbList = $this->security->xss_clean(trim($this->input->post('ulb_check_list')));
							$check_list = array();
							$ulb_check_list = array();
							
							$check_list = array_diff($allCategories,$categoryList);
							$ulb_check_list = array_diff($allUlbList,$ulbList);
							
							$params = array(
							'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
							'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
							'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
							'check_list' => $check_list,
							'ulb_check_list' => $ulb_check_list,
							'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
							'author' => $this->session->userdata('userid'),
							'user_level' => $this->session->userdata('user_type'),
							'flag' => 1,
							'langId'=>$this->session->userdata('langId')
							);
							$result = $this->ViewWidgetModel->editpageWidget($params);
						}
						
						/** end based on radio button value if else condtion **/
						
					}
					}else{
					$params = array(
					'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
					'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
					'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
					'check_list' => $this->security->xss_clean(trim($this->input->post('check_list'))),
					'author' => $this->session->userdata('userid'),
					'user_level' => $this->session->userdata('user_type'),
					'flag' => 1,
					'langId'=>$this->session->userdata('langId'),
					'ulbid'=>$this->session->userdata('ulbid')
					);
					$result = $this->ViewWidgetModel->editpageWidget($params);
				}
				if($result){
					$this->session->set_flashdata('message',"<div class='alert alert-success'> Widget update successfully </div>");
					redirect('view-widgets');
					}else{
					$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , try again </div>");
					redirect($reDir);
				}
			}
			else
			{
				redirect('/');
			}
			
		}
		
		
	 	public function editsliderWidget()
		{
			
			
			if($this->session->userdata('session_id')==session_id())
			{ 
				
				if($this->input->post('save')){
					
					$userLevel = $this->session->userdata('user_type');
					// $reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widgetname"))).'/'.$this->security->xss_clean(trim($this->input->post("widgettype")));
					$reDir = 'edite-widget/'.$this->security->xss_clean(trim($this->input->post("widget_id"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type"))).'/'.$this->security->xss_clean(trim($this->input->post("widget_type_style"))); 
					$this->form_validation->set_rules('widget_name', 'widget_name', 'trim|required');
					
					/** open getting categories and ulb list **/
					$data['widget_det']=array(
					
					'widget_id'=>$this->security->xss_clean(trim($this->input->post('widgetname'))),
					'widget_type'=>$this->security->xss_clean(trim($this->input->post('widgettype'))),
					'ulbid' => $this->session->userdata('ulbid'),
					'user_type'=> $this->session->userdata('user_type'),
					'langId' => $this->session->userdata('langId')
					);
					
					$data['result']=$this->getsliderwidgetContent($data['widget_det']);
					//print_r($data['result']);
					$allCategories = array();
					foreach($data['result']['allcategories'] as $key=>$val){
						$allCategories[] = $val['page_id'];
					}
					
					
					$data['ulbList'] = $this->CreateWidgetModel->getUlbList();
					$allUlbList = array();
					foreach($data['ulbList'] as $key=>$val){
						$allUlbList[] = $val['ulbid'];
					}
					/** close getting categories and ulb list **/
					
					if ($this->form_validation->run() == FALSE){
						$this->session->set_flashdata('message',"<div class='alert alert-danger'>  Please Enter Widget Name </div>");
						redirect($reDir);
					}
					
					if($userLevel == 'A'){
						
						$this->form_validation->set_rules('radio', 'radio', 'required');
						
						if ($this->form_validation->run() == FALSE){
							$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , Please select Edit or Delete </div>");
							redirect($reDir);
							}else{
							/** start based on radio button value if else condtion **/
							
							$radioVal = $this->security->xss_clean(trim($this->input->post('radio')));
							if($radioVal == 'edit'){          /// edit radio button function
								
								$ulbid = $this->session->userdata('ulbid');
								$ulb_check_list = $this->input->post('ulb_check_list');
								$check_list = $this->input->post('check_list');
								//echo  $check_listCount  = count($check_list);exit;
								//print_r($ulb_check_list);echo "<br/>";
								array_push($ulb_check_list,$ulbid);
								//print_r($ulb_check_list);echo "<br/>";
								
								$params = array(
								'widget_id' => $this->security->xss_clean(trim($this->input->post('widgetname'))),
								'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
								'widget_type' => $this->security->xss_clean(trim($this->input->post('widgettype'))),
								'check_list' => $this->input->post('check_list'),
								'ulb_check_list' => $ulb_check_list,
								'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
								'author' => $this->session->userdata('userid'),
								'user_level' => $this->session->userdata('user_type'),
								'flag' => 1,
								'langId'=>$this->session->userdata('langId')
								);
								
								//print_r($params);
								
								$result = $this->ViewWidgetModel->editsliderWidget($params);
								
								}else if($radioVal == 'editexcept'){    /// edit except radio button function
								//echo "editexcept";
								$categoryList = $this->input->post('check_list');
								$ulbList = $this->input->post('ulb_check_list');
								$check_list = array();
								$ulb_check_list = array();
								
								$check_list = array_diff($allCategories,$categoryList);
								$ulb_check_list = array_diff($allUlbList,$ulbList);
								
								$params = array(
								'widget_id' => $this->security->xss_clean(trim($this->input->post('widgetname'))),
								'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
								'widget_type' => $this->security->xss_clean(trim($this->input->post('widgettype'))),
								'check_list' => $check_list,
								'ulb_check_list' => $ulb_check_list,
								'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
								'author' => $this->session->userdata('userid'),
								'user_level' => $this->session->userdata('user_type'),
								'flag' => 1,
								'langId'=>$this->session->userdata('langId')
								);
								//print_r($params);
								$result = $this->ViewWidgetModel->editsliderWidget($params);
								
								}else if($radioVal == 'delete'){   /// delete radio button function
								
								
								$params = array(
								'widget_id' => $this->security->xss_clean(trim($this->input->post('widgetname'))),
								'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
								'widget_type' => $this->security->xss_clean(trim($this->input->post('widgettype'))),
								'check_list' => $this->security->xss_clean(trim($this->input->post('check_list'))),
								'ulb_check_list' =>$this->input->post('ulb_check_list'),
								'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
								'author' => $this->session->userdata('userid'),
								'user_level' => $this->session->userdata('user_type'),
								'flag' => 1,
								'langId'=>$this->session->userdata('langId')
								);
								$result = $this->ViewWidgetModel->editsliderWidget($params);
								// print_r($params);
								}else if($radioVal == 'deleteexcept'){  /// delete except radio button function
								$categoryList = $this->input->post('check_list');
								$ulbList = $this->input->post('ulb_check_list');
								$check_list = array();
								$ulb_check_list = array();
								
								$check_list = array_diff($allCategories,$categoryList);
								$ulb_check_list = array_diff($allUlbList,$ulbList);
								
								$params = array(
								'widget_id' => $this->security->xss_clean(trim($this->input->post('widgetname'))),
								'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
								'widget_type' => $this->security->xss_clean(trim($this->input->post('widgettype'))),
								'check_list' => $check_list,
								'ulb_check_list' => $ulb_check_list,
								'radio' => $this->security->xss_clean(trim($this->input->post('radio'))),
								'author' => $this->session->userdata('userid'),
								'user_level' => $this->session->userdata('user_type'),
								'flag' => 1,
								'langId'=>$this->session->userdata('langId')
								);
								$result = $this->ViewWidgetModel->editsliderWidget($params);
							}
							
							/** end based on radio button value if else condtion **/
							
						}
						}else{
						$params = array(
						'widget_id' => $this->security->xss_clean(trim($this->input->post('widget_id'))),
						'widget_name' => $this->security->xss_clean(trim($this->input->post('widget_name'))),
						'widget_type' => $this->security->xss_clean(trim($this->input->post('widget_type'))),
						'check_list' => $this->input->post('check_list'),
						'author' => $this->session->userdata('userid'),
						'user_level' => $this->session->userdata('user_type'),
						'flag' => 1,
						'langId'=>$this->session->userdata('langId'),
						'ulbid'=>$this->session->userdata('ulbid')
						);
						$result = $this->ViewWidgetModel->editsliderWidget($params);
					}
					if($result){
						$this->session->set_flashdata('message',"<div class='alert alert-success'> Widget update successfully </div>");
						redirect('view-widgets');
						}else{
						$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to update , try again </div>");
						redirect($reDir);
					}
				}
				else
				{
					redirect('dashboard');
				}
			}
			else
			{
				redirect('/');
			}
			
		}
		
		public function editWidget()
		{
			if($this->session->userdata('session_id')==session_id())
			{
				//echo "okk";
				
				$widget_id=(int)decrypt_data($this->uri->segment('2'));
				$widget_type=(int)decrypt_data($this->uri->segment('3'));
				$widget_type_style=(int)decrypt_data($this->uri->segment('4'));
				//var_dump($widget_id);die('ssss');
				
				$data['widget_det']=array(
				
				'widget_id'=>$widget_id,
				'widget_type'=>$widget_type,
				'widget_type_style'=>$widget_type_style,
				'ulbid' => $this->session->userdata('ulbid'),
				'user_type'=> $this->session->userdata('user_type'),
				'langId' => $this->session->userdata('langId')
				);
				//print_r($data['widget_det']);
				
				if($widget_type=='1' || $widget_type=='6' || $widget_type=='11')
				{
					$data['menunames']=$this->getMenuwidgetContent($data['widget_det']);
					
					//$data['widget_edit']=$this->ViewWidgetModel->getwidget_edit($widget_id);
					
					//$data['menus']=$this->getMenuwidgetname($data['widget_det']);
					
					
				}else if($widget_type=='2')
				{
					$data['result'] = $this->getTextwidgetContent($data['widget_det']);
				}
				else if($widget_type=='5' || $widget_type=='7')
				{
					$data['result']=$this->getImageTextwidgetContent($data['widget_det']);
					
				}
				else if($widget_type=='4')
				{
					$data['result']=$this->getphotogallerywidgetContent($data['widget_det']);
					
					
				}
				else if($widget_type=='8')
				{
					$data['result']=$this->gettabwidgetContent($data['widget_det']);
					$data['tabtypes']=array('1'=>'Horizontal tabs','2'=>'Vertical tabs');
					
				}
				else if($widget_type=='9')
				{
					$data['result']=$this->getpostwidgetContent($data['widget_det']);
					
				}
				else if($widget_type=='10'){
					$data['result']=$this->getpagewidgetContent($data['widget_det']);
					
				}
				else if($widget_type=='12'){
					
					$data['result']=$this->getsliderwidgetContent($data['widget_det']);
					
					//$data['widget_edit']=$this->ViewWidgetModel->getwidget_edit($widget_id);
				}
				
				
				
				
				
				$submenudata=array();
				
				$data['main_menu_list']=$this->MenuModel->getMainMenu(); 
				$subMenus=$this->MenuModel->getSubMenu();
				
				$params=array('ulbid'=>$this->session->userdata('ulbid'));
				
				// $data['aboutData']=$aboutData=$this->AboutModel->getaboutData($params);
				
				
				foreach($subMenus as $key=>$val)
				{
					$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
					$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
				}
				$data['sub_menus']=$submenudata;
				$params=array('ulbid'=>$this->session->userdata('ulbid'),'langId'=>$this->session->userdata('langId'),'user_type'=>$this->session->userdata('user_type'));
				
				$customMenus=$this->ViewWidgetModel->getWidgets($params);
				
				if(count($customMenus['widgetData']) > 0)
				{
					$count1 = count($customMenus['widgetData']);
					$count['count']=$count1;
					
					foreach($customMenus['widgetData'] as $key=>$val){
						foreach($customMenus['widgetType'] as $key2=>$val2){
							if($val['widget_type'] == $val2['widget_type_id']){
								$customemenudata[$val['widget_id']]['widget_type_name'] = $val2['widget_type_desc'];
							}
							
							$customemenudata[$val['widget_id']]['widget_id']=$val['widget_id'];
							$customemenudata[$val['widget_id']]['widget_name']=$val['widget_name'];
							$customemenudata[$val['widget_id']]['author']=$val['author'];
							$customemenudata[$val['widget_id']]['widget_type']=$val['widget_type'];
							$customemenudata[$val['widget_id']]['widget_type_style']=$val['widget_type_style'];
							$customemenudata[$val['widget_id']]['ts']=$val['ts'];
							$customemenudata[$val['widget_id']]['is_edit_permission']=$val['is_edit_permission'];
							$customemenudata[$val['widget_id']]['is_delete_permission']=$val['is_delete_permission'];
						}
					}
					
					$data['custom_menus']=$customemenudata;
					//print_r($data['custom_menus']);exit;
					$data['count']= $count;
				}
				
				$data['ulbList'] = $this->CreateWidgetModel->getUlbList();
				
				$params = array('ulbid'=>$this->session->userdata('ulbid'),'status'=>1);
				$data['create_media_data']=$this->ViewAlbumModel->createMediaData($params);
				
				//print_r($data);exit;
				
				$data['languageList']=$this->MenuModel->getLanguages($params);
				$this->load->view('header',$data);
				$this->load->view('editwidgets',$data);
				$this->load->view('divdata',$data);
				$this->load->view('footer');
				
			}
			else
			{
				redirect('/');
			}
			
			
		}
		
		
		public function selectDeleteWidgetData()
		{
			if($this->session->userdata('session_id')==session_id())
			{
				
				$check_list = $this->input->get('check_val');
				
				$result = $this->ViewWidgetModel->selectDeleteWidgetData($check_list);
				echo $result;
				//print_r($result);
				/*if($result == '1'){
					$this->session->set_flashdata('message',"<div class='alert alert-success'> Widget Deleted successfully </div>");
					}else{
					$this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to delete , try again </div>");
					}
				redirect('view-widgets');*/
			}
			else
			{
				redirect('/');
			}
		}
		
		
		public function deleteContent()
		{
			if($this->session->userdata('session_id')==session_id())
			{
				$widget_id=$this->security->xss_clean(trim($this->input->post('widget_id')));
				$params=array('widget_id'=>$widget_id);
				$result = $this->ViewWidgetModel->deleteContent($params);
				echo 1;
			}
			else
			{
				redirect('/');
			}
		}
		
		public function updateStatus()
		{
			if($this->session->userdata('session_id')==session_id())
			{
				$page_id=$this->security->xss_clean(trim($this->input->post('page_id')));
				$status=$this->security->xss_clean(trim($this->input->post('status')));
				$params=array('page_id'=>$page_id,'is_draft'=>$status);
				$result=$this->ViewPagesModel->updateStatus($params);
				echo $result;
			}
			else
			{
				redirect('/');
			}
		}
		
		
		
		public function index()
		{
			
			if (!in_array($this->session->userdata('userid'),['superadmin'])) {
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
				
				$params=array('ulbid'=>$this->session->userdata('ulbid'));
				
				// $data['aboutData']=$aboutData=$this->AboutModel->getaboutData($params);
				
				foreach($subMenus as $key=>$val)
				{
					$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
					$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
				}
				$data['sub_menus']=$submenudata;
				$params=array('ulbid'=>$this->session->userdata('ulbid'),'langId'=>$this->session->userdata('langId'),'user_type'=>$this->session->userdata('user_type'));
				
				$customMenus = $this->ViewWidgetModel->getWidgets($params);
				
				/*if(count($customMenus) > 0)
					{
					foreach($customMenus as $key=>$val)
					{
					$customemenudata[$val['widget_id']]['widget_name']=$val['widget_name'];
					$customemenudata[$val['widget_id']]['author']=$val['author'];
					$customemenudata[$val['widget_id']]['widget_type']=$val['widget_type'];
					$customemenudata[$val['widget_id']]['ts']=$val['ts'];
					
					}
					
					
					$data['custom_menus']=$customemenudata;
				}*/
				
				if(count($customMenus['widgetData']) > 0){
					$count1 = count($customMenus['widgetData']);
					$count['count']=$count1;
					
					foreach($customMenus['widgetData'] as $key=>$val){
						foreach($customMenus['widgetType'] as $key2=>$val2){
							if($val['widget_type'] == $val2['widget_type_id']){
								$customemenudata[$val['widget_id']]['widget_type_name'] = $val2['widget_type_desc'];
							}
							
							$customemenudata[$val['widget_id']]['widget_id']=$val['widget_id'];
							$customemenudata[$val['widget_id']]['widget_name']=$val['widget_name'];
							$customemenudata[$val['widget_id']]['author']=$val['author'];
							$customemenudata[$val['widget_id']]['widget_type']=$val['widget_type'];
							$customemenudata[$val['widget_id']]['widget_type_style']=$val['widget_type_style'];
							$customemenudata[$val['widget_id']]['ts']=$val['ts'];
							$customemenudata[$val['widget_id']]['is_edit_permission']=$val['is_edit_permission'];
							$customemenudata[$val['widget_id']]['is_delete_permission']=$val['is_delete_permission'];
						}
					}
					
					$data['custom_menus']=$customemenudata;
					$data['count']= $count;
				}
				
				$params = array('ulbid'=>$this->session->userdata('ulbid'),'status'=>1);
				$data['create_media_data']=$this->ViewAlbumModel->createMediaData($params);
				
				
				
				
				
				
				$data['languageList']=$this->MenuModel->getLanguages($params);
				$this->load->view('header',$data);
				$this->load->view('viewwidgets',$data);
				$this->load->view('divdata',$data);
				$this->load->view('footer');
			}
			else
			{
				redirect('/');
			}
		}
	}
