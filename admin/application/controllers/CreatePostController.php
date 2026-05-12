<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
class CreatePostController extends MY_Controller {

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
	    $this->load->model('CreatePostModel');
	    $this->load->model('CreatepageModel');
	    $this->load->model('ViewAlbumModel');
	    $this->load->model('CustomModel');

	    $this->load->library('form_validation');
	    $this->load->library('CategoryFunctions');
	    $this->load->helper('captcha');
	    $this->CategoryFunctions=new CategoryFunctions();
	    
	 }
	 
	
	 
	 public function getTenderForm()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    {
	     if($this->input->post('category_id'))
	     {
	         $params=array('page_id'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('category_id'))))));
	         $function=$this->CreatePostModel->getTenderForm($params);
	         if($this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('category_id')))))==339)
	         {
	         $form=$this->CategoryFunctions->getTenderform();
	         }
	         else
	         {
	             $form=$this->CategoryFunctions->postform();
	         }
	         echo $form;
	     }
	     else
	     {
	         echo "Invalid category";
	     }
	    }
	    else
	    {
	        redirect('/');
	    }
	 }
	 
	  public function is_existingPagename($pagename,$ulbid)
	 {
	     
	     
	     if($this->session->userdata('session_id')==session_id())
	    {
	     
	     $params=array('controller'=>strip_tags($pagename),'ulbid'=>$ulbid);
	     $result=$this->CreatepageModel->is_existingPagename($params);
	     return $result[0]['count'];
	    }
	    else
	    {
	        redirect('/');
	        
	    }
	     
	     
	     
	     
	 }
	 
	 
	 public function getFilepath($page_name,$file_name)
	 {
	     
	       if($this->session->userdata('session_id')==session_id())
	    {
	        
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
                                                            $upload_path.=$folder."/";
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
                                                            $upload_path.=$folder."/";
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
                                                            $upload_path.=$folder."/";
                                                            $thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                    mkdir($thumbspath, 0777, true);
                                                                }
                                                             
                                                            
                                                        }
                                                        else
                                                        {
                                                            $upload_path.=$folder."/";
                                                            $thumbspath=$upload_path."thumbnails";
                                                            if (!file_exists($upload_path)) 
                                                                {
                                                                    mkdir($upload_path, 0777, true);
                                                                    mkdir($thumbspath, 0777, true);
                                                                }
                                                        }
                                        }
                            }
                            
                            
                                       
                            
                                        $config = array();
                                        $config['upload_path'] = $upload_path;
                                        $config['allowed_types'] = 'jpg|png|jpeg|pdf';
                                        $config['max_size']      = '20480';
                                        $config['overwrite']     = FALSE;
                                        
                                        $this->load->library('upload',$config);
                                        $this->upload->initialize($config);
                            
                                        //$this->upload->initialize($this->set_upload_options());
                                        
                                        if(!$this->upload->do_upload($file_name))
                                        {
                                            print_r($this->upload->display_errors());
                                        }
                            $upload_data = $this->upload->data();
                            
                             /** checking for malicious file upload **/
                            $file_info = new finfo(FILEINFO_MIME_TYPE);
                            $mime_types_array = array('image/jpg','image/jpeg','image/png');
                            $finopath = $target_file;
                            $a = getimagesize($upload_data['full_path']);
                            $filename = $upload_data['file_name'];
                            
                           
                           // $filename = date('YmdHis').rand(999,100000).".jpg";
                           //$file_name
                            
                            $mime_type = $file_info->buffer(file_get_contents($upload_data['full_path']));
                           
                              /*  if(!in_array($mime_type,$mime_types_array))
                                   {
                                       unlink($upload_data['full_path']);
                                       die('Invalid file type');
                                   }
                                   else
                                   {
                                       $src_file = $upload_data['full_path'];
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
                                        unlink($upload_data['full_path']);
                                       
                                   }*/
                           
                            /** close **/
                            $upload_data['file_name'] = $filename;
                            $upload_data['file_folder_path']=$upload_path;
                            // print_r($upload_data);die;
                            
                            $this->session->set_userdata('pathimagesaveurl',$thumbspath);
                            
                            return $upload_data;
	        }
	        else
	        {
	            redirect('/');
	        }
	 }
	 
	 public function input_check($str){
	     if (ctype_alnum($str)) {
            return true;
        }else{
            // $this->form_validation->set_message('input_check' ,'Please Enter a Valid Input');
            // return false;
             return true;
        }
	 }
	 
	public function addPost(){

		
		if($this->session->userdata('session_id')!=session_id())
	    {
			$this->session->set_flashdata('error_message', "Error: HTML or script tag detected in ".$key." field!");
			redirect($_SERVER['HTTP_REFERER']);
			exit;
		}
		
		if($this->input->post('save') || $this->input->post('is_draft'))
	    {
				
	            $inputCaptcha = htmlspecialchars(strip_tags($this->input->post('captcha')));
            					
				$sessCaptcha = htmlspecialchars(strip_tags($this->session->userdata('captchaCode')));
				
				//$sessCaptcha2 = $this->input->post('session_captcha'); 
				
				//echo "Session Captcha:<br>".$sessCaptcha."<br>";            	
				$testCaptcha =  $sessCaptcha === $sessCaptcha; 
				//echo "Input Captcha:<br>".$testCaptcha;exit;  

	            if($testCaptcha){         
    	       
					$content=htmlspecialchars(strip_tags($this->input->post('content')));
					$tabcategories = htmlspecialchars(strip_tags($this->input->post('categories')));
					
					$replaceUrl="../";
					$content=str_replace($replaceUrl,'/',$content);
					$replaceUrl="//";
					$content=str_replace($replaceUrl,'/',$content);
					$content=str_replace("'",' ',$content);
										
					if($this->session->userdata('langId')==1)
					{						
						$pagename=substr(strtolower(trim($this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagename'))))))),0,60);
					}
					else
					{
						// if content in telugu creatinig hashed urls
						$pagename=rand(1,10000);
						$pagename=substr(md5($pagename),0,60);
					}
					
				
					$pagename=preg_replace("![^a-z0-9]+!i", "-", $pagename);
					$pagename2=preg_replace("![^a-z0-9]+!i", "-", $pagename2);
					
					$pagename=str_replace(" ", "-", $pagename); // replacing spaces with hypens in url
					$pagename2=str_replace(" ", "-", $pagename);
				
					$this->form_validation->set_rules('pagename', 'Pagename', 'trim|required|callback_input_check');
					$this->form_validation->set_rules('pagetitle', 'pagetitle', 'trim|required|callback_input_check');
					$this->form_validation->set_rules('ptags', 'ptags', 'trim|required');
					
					 $this->form_validation->set_rules('hover_title', 'Hover Title', 'required|callback_input_check');
					  
						$this->form_validation->set_rules('meta_desc', 'Description', 'required|callback_input_check');
						 $this->form_validation->set_rules('meta_subject', 'Subject', 'required|callback_input_check');
					 //$this->form_validation->set_rules('content', 'content', 'alpha_dash|trim|required');
				
					if($this->form_validation->run() == FALSE)
					{
							
					}
					else
					{
						
						
						
						
						$site_controller=$pagename2;  
						$result=$this->is_existingPagename($pagename,$this->session->userdata('ulbid'));
						
						
						
						if($result > 0)
						{
							
							$pagename=$pagename.time();
							$pagename2=$pagename2.time();
							$site_controller=$pagename2;  
						}
						$portal_url=$this->CustomModel->getPortalUrl($this->session->userdata('ulbid'));
						
						$permalink=$portal_url['base_url'].$site_controller; // creating permallinks
						$this->session->set_flashdata('permalink',$permalink);
				 
					   if($this->input->post('fromDate')==='1970-01-01' || $this->input->post('fromDate')==='0000-00-00')
						{
						   //$this->input->post('fromDate') = date('Y-m-d');
						}
						else if($this->input->post('toDate')=='1970-01-01')
						{
							   //$this->input->post('fromDate')='00-00-0000';
						}
							
						if($this->input->post('fromDate')=='1970-01-01' || $this->input->post('fromDate')=='0000-00-00' || $this->input->post('fromDate')=='')
						{
						   
						 $from=date('Y-m-d H:i');
						 $to='';  
						
						}
						else
						{
						   
						 $from=date('Y-m-d H:i',strtotime(htmlspecialchars(strip_tags($this->input->post('fromDate')))));
						 $to=date('Y-m-d H:i',strtotime(htmlspecialchars(strip_tags($this->input->post('toDate'))))); 
						
						}
											
						if($tabcategories)
						{
							$tabs_status = 1;
						}else{
							$tabs_status = 0;
						}
						
						$content_new = $content;

						// 1. Remove <script> tags completely
						$content_new = preg_replace('#<script\b[^>]*>(.*?)</script>#is', '', $content_new);

						// 2. Extra safety: remove standalone <script ...> tags (without closing tag)
						$content_new = preg_replace('#<script\b[^>]*>#is', '', $content_new);

						// 3. Use CodeIgniter XSS clean (very important)
						$content_new = $this->security->xss_clean($content_new);

						
						
						//print_r($tabs_status);exit;
						$params=array(
						   'ulbid'=>$this->session->userdata('ulbid'),
						  // 'content'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($_POST['content_new'])))),
						   'controller'=>$pagename,
						   'is_draft'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('is_draft'))))),
						   'page_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagename'))))),
						   'page_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagetitle'))))),
							'pagekeywords'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('ptags'))))),
						   'is_custumlink'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('is_custumlink')))))),
						   //'permalink'=>preg_replace('/[^A-Za-z0-9]/', ' ', strip_tags($permalink)),
						   'permalink'=>$permalink,
						   'fromDate'=>$from,
						   'toDate'=>$to,
						   'datetime'=>date('Y-m-d H:i:s'),
						   //'langId'=>$this->security->xss_clean(trim($this->session->userdata('langId'))),
						   'langId'=>$this->security->xss_clean(trim($this->input->post('lang_id'))),
						   'author'=>$this->security->xss_clean(trim($this->session->userdata('userid'))),
						   'dep_id'=>trim($this->input->post('department')),
						   'site_controller'=>$site_controller,
						   'page_sidebars_id'=>'4',
						   'meta_desc'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_desc'))))),
							'meta_subject'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_subject'))))),
							'hover_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('hover_title'))))),
						   'user_level'=>'U',
						   'user_type'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('user_type'))))),
						   
						   'pageheading'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9,]/', ' ', htmlspecialchars(strip_tags($this->input->post('pagename')))))),
						   'tabs_status' => $tabs_status
						   
						);
						
						foreach($params as $key=>$param){
							if (preg_match('/<[^<]+>/', $param)) {
								$this->session->set_flashdata('error_message', "Error: HTML or script tag detected in ".$key." field!");
								redirect($_SERVER['HTTP_REFERER']);
								exit;
							}
						}
						
						
						//print_r($params);die();
						
						$params['content']=$content_new;
			   
					   if($this->input->post('is_draft') == 0)
					   {
						 
						   if($this->input->post('fromDate') > date('d-m-Y'))
						   {
							   $this->session->set_flashdata('message','Your Post will be live from'.strip_tags($this->input->post('fromDate')));
						   }
						   else
						   {
							   $this->session->set_flashdata('message','Your Post will be live from'.strip_tags($this->input->post('fromDate')));
						   }
					   }
					   else
					   {
						   $this->session->set_flashdata('message','Your Post Saved successfully');
					   }
					   
						// print_r ($params);exit;
					   
				   
						$data1=$this->CreatePostModel->customePageDataInsert($params);
						
			//echo "<pre>";print_r ($data1);echo "</pre>";exit;
					   
					    if($data1['result']=='1')
					    {
									$pagename="'".$pagename."'";
									$configFilePath=$_SERVER['DOCUMENT_ROOT'].'/admin/application/config/routes.php'; // adding url in admin confing file
									 $configFilePath2=$_SERVER['DOCUMENT_ROOT'].'/application/config/routes.php'; // adding url in site config
									$file=fopen($configFilePath,'a') or die('cannot append to file.');
								
									$controllerNameNoextension='CustomePageController/getPageContent/'.$data['pageId'];
									$controller='$route['.$pagename.']='."'".$controllerNameNoextension."';";
									fwrite($file,"\n".$controller);
									fclose($file);
									
									
									$pagename="'".$pagename2."'";
									
									$file=fopen($configFilePath2,'a') or die('cannot append to file..');
								
									$controllerNameNoextension='CustomePageController/getPageContent/';
									
									$controller='$route['.$pagename.']='."'".$controllerNameNoextension."';";
									fwrite($file,"\n".$controller);
									fclose($file);
				
									if(!empty($this->input->post('categories')))
									{
										foreach($this->input->post('categories') as $val)
										{
											
											$params=array(
												'category_id'=>$val,
												'page_id'=>$data1['pageId'],
												'flag'=>1
												);
												
											$this->CreatePostModel->mapCategoryPost($params); 
											
											$params=array('category_id'=>$val);
											
											// getting all field names from table with this category id table: category_forms_mst
										
											$fieldname=$this->CreatePostModel->getCategoryFieldnames($params);
											
											// making query with database field names
											
											$total_fieldnames=count($fieldname); // find total number of records in array
											
											// getting category name for identifying the table names
											$categoryname="category_desc".$val;
											
											//$table=strtolower($this->input->post($categoryname));
											$tbl="tbl".$val;
										

				
											$table=$this->input->post($tbl);
		// requirement of superadmin start								
												
										/* 	if(($this->session->userdata('userid')=='superadmin') && ($table=='quotations')){
												$table .= '_data';
											} */
		// requirement of superadmin end	
		
	//echo "<pre>";print_r ($table);echo "</pre>";exit;

	
											$alltables[]=$table;
											if($table !='')
											{
											
											$query1="insert into $table (";
											$query2=")values(";
											
											$i=1; // initializing for the purpose of to remove ',' on last reocrd
											
											//print_r($fieldname);
										   // $fieldname[0][$data1['pageId']]['page_id']=$data1['pageId']; // manullly adding page id because it is not in the table: category_forms_mst but we need page id for the table tenders or other category tables
										   // print_r($fieldname);
											
											foreach($fieldname as $key=>$val2)
											{
												// finding file type fields
												
												
												
												
												if($val2['type']=='file')
												{
													if($_FILES[$val2['name'].$val]['name']!='')
													{
														
														$code=1; 
														$upload_data=$this->getFilepath($val2['page_name'],$val2['name'].$val);// calling function to get file path
														// print_r($upload_data);
														
														$this->session->set_userdata('source_image',$upload_data['file_folder_path'].$upload_data['file_name']);
														$filepath=substr($upload_data['file_folder_path'],2).$upload_data['file_name'];
														
														
														if($table =='slider_mst2')
														{
														
															$thumbspath=$this->session->userdata('pathimagesaveurl')."/".$upload_data['file_name'];
															$this->session->set_userdata('pathimagesaveurl',$thumbspath);
														}
													}
													
												}
												else
												{
												   
													
														$postvalue=$val2['name'].$val; 
													
												}
											
												$query1.=$val2['name']; 
										   
										   
											   if($val2['data_type']=='date')
											   {
											   $query2.="'".date('Y-m-d',strtotime(htmlspecialchars(strip_tags($this->input->post($postvalue)))))."'";
											   }
											   else if($val2['type']=='hidden')
											   {
													
															$query2.="'".$data1['pageId']."'";
													   
											   }
											   else if($val2['type']=='file')
											   {
												   $query2.="'".$filepath."'";
												 
											   }
											   else
											   {
												   /* in case of it is select field value need to explode with undorscore 
													  because we are giving values in view with underscore for the purpose 
													  of to show the dependent field with YES or NO basis
												   */
													if($val2['type']=='select')
													{
														$arr=explode("_",htmlspecialchars(strip_tags($this->input->post($postvalue))));
														$postvalue=
														$query2.="'".$arr[0]."'"; 
													}
													else
													{
												   
												   $query2.="'".strip_tags(htmlspecialchars(strip_tags($this->input->post($postvalue))))."'"; 
													}
											   }
											   
											   if($i < $total_fieldnames)
											   {
												   // if the record last record no need to add ','
												   $query1.=","; 
												   $query2.=",";
											   }
											   
											   
											   $i++;
											}
									   
										$query2.=")"; 
										$query=$query1.$query2;
										
	 //echo $query; exit;
										
										
										$fieldname=$this->CreatePostModel->insertCategoryFormdetails($query);
												}
										
										/*** updating slider thumbnail image ****/
														if($code==1) 
															{
															  $this->CreatePostModel->updateSliderThumbnailimage($data1['pageId'],substr(strip_tags($this->session->userdata('pathimagesaveurl')),2));
															}
														
													   
													
										
										/*** close ***/
										
										
									}
									
									
									
									if(in_array('slider_mst2',$alltables))
									{
										if($code==1) 
											{
											$redirect_url="crop-image/".$data1['pageId'];
											redirect($redirect_url);
											}
									}
									
									
								}
								
								
								$this->session->set_flashdata('success_message','Post created successfully');
						}else{
							$this->session->set_flashdata('error_message','Unable to create post , Please try again');
							
						}
	        
					}
						
				}else{
						$this->session->set_flashdata('error_message',"<div class='alert alert-danger'>Captcha code does not match, please try again. </div>");
				}  
	    
	    }
			
			redirect($_SERVER['HTTP_REFERER']);
			exit;
		
	}
	
	
	public function index()
	{
	 //echo $this->session->userdata('username');exit;
	   
	   if($this->session->userdata('session_id')==session_id())
	    {
	        
	           
	       
			
	  $submenudata=array();
	    
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
	    $subMenus=$this->MenuModel->getSubMenu();
		
	    
	    $assignedDepartments = array();
	   
	    if($this->session->userdata('user_type') === 'D'){
	        
	        $assign_params = array('user_id' => $this->session->userdata('userid'));
			
	        $assignedDepartments = $this->CreatePostModel->getAssignedCategories($assign_params);

			//print_r($assignedDepartments);
		  
		  $assignDepArray = array();
		  foreach($assignedDepartments as $key=>$val) {
			// array_push($assignDepArray,$val);
			// print_r($val['dept_id']);exit;
			$assignDeptArray[$assignedDepartments[$key]->dept_id] = $assignedDepartments[$key]->dept_id;
		  }  
		    //echo "<pre>";print_r($assignDeptArray);echo "</pre>";die();
		   //print_r($a);
	        $params=array('ulbid'=>$this->session->userdata('ulbid'),'is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
	        
	    }else{
	    
	  
	    $params=array('ulbid'=>$this->session->userdata('ulbid'),'is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
	    }
	  
	    
	    
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    $data['sub_menus']=$submenudata;
	    //$data['categories']=$this->CreatePostModel->getPostCategories($params);
	    //print_r($assignDeptArray);
		//exit;

	   
	    $categories=$this->CreatePostModel->getPostCategories($params,$assignDeptArray);

		//echo '<pre>';print_r($categories);exit;
		if($this->session->userdata('user_type') !== 'A'){
			foreach($categories['ulbcategories']->result() as $key=>$val)
			{
				$data['categories'][$val->category_id]=$val->category_desc;
				$data['tbls'][$val->category_id]=$val->table_name;
			}
		}
		
	    if($this->session->userdata('user_type') !== 'D'){
			foreach($categories['admincategories']->result() as $key=>$val)
			{
				$data['categories'][$val->category_id]=$val->category_desc;
				$data['tbls'][$val->category_id]=$val->table_name;
			}
	    }
	    //echo '<pre>';print_r($categories);exit;
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    
	    // category form data
	    $params=array('user_level'=>'A','is_custumlink'=>3);
	    $formdata=$this->MenuModel->getformsdata($params);
		
		 //echo '<pre>';print_r($formdata);exit;
		 
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
		// echo"<pre>";
	    // print_r($forms);exit;
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
	     
		$data['departments']=$this->CreatePostModel->getDepartments();
		//echo "<pre>"; print_r($data['departments']); exit;
	   
	    
	    $this->load->view('header',$data);
		$this->load->view('createpost',$data);
		$this->load->view('divdata',$data);
		$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('/');
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
	
	
	public function refresh(){
        // Captcha configuration
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
        $this->session->set_userdata('captchaCode',$captcha['word']);
        
        // Display captcha image
        echo $captcha['image'];
    }
	
}