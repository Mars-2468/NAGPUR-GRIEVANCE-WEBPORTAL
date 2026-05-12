<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
class ReportController extends CI_Controller {

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
	    $this->load->library('form_validation');
	    $this->load->library('CategoryFunctions');
	    $this->load->helper('captcha');
	    $this->CategoryFunctions=new CategoryFunctions();
	    
	 }
	 
	
	 
	public function index()
	{
	   if($this->session->userdata('session_id')==session_id())
	    {
	        
	        
	        if($this->input->post('submit'))
	        {
	            $title = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('title')))));
	            $cat = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('cat')))));
	            $open = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('open')))));
				if($cat == 1)
				{
				   $name = 'Monthly' ;
				}
				else if($cat == 2)
				{
				    $name = 'Quarlerly' ;
				}
				else if($cat == 3)
				{
				    $name = 'Yearly' ;
				}
                date_default_timezone_set('Asia/Kolkata');
                $todat_date_time = date('Y-m-d H:i:s');
                $file = $_FILES['file']['name'];
				if ($file) 
					{
					$this->load->library('upload');
					  if (!empty($_FILES['file']['name']))
					   {
			            $config['upload_path'] = './../assets/reports';
			            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|JPEG|PNG'; 
					    $this->upload->initialize($config);

			            if ($this->upload->do_upload('file'))
			              {
			                $file = $this->upload->data();
			                
			                /** checking for malicious file upload **/
                            $file_info = new finfo(FILEINFO_MIME_TYPE);
                            $mime_types_array = array('image/jpg','image/jpeg','image/png');
                            $finopath = $target_file;
                            $a = getimagesize($file['full_path']);
                            
                            $filename = date('YmdHis').rand(999,100000).".jpg";
                            
                            $mime_type = $file_info->buffer(file_get_contents($file['full_path']));
                           
                                if(!in_array($mime_type,$mime_types_array))
                                   {
                                       unlink($file['full_path']);
                                       die('Invalid file type');
                                   }
                                   else
                                   {
                                       $src_file = $file['full_path'];
                                       $dest_file = '../assets/reports/'.$filename;
                                        $img_quality = 70;
                                         header('Content-Type: image/png');
                                        $im = imagecreatefromstring(file_get_contents($src_file));
                                        $im_w = imagesx($im);
                                        $im_h = imagesy($im);
                                        $tn = imagecreatetruecolor($im_w, $im_h);
                                        imagecopyresampled ( $tn , $im, 0, 0, 0, 0, $im_w, $im_h, $im_w, $im_h );
                                        imagejpeg($tn,$dest_file,$img_quality);
                                        
                                        unlink($file['full_path']);
                                       
                                   }
                           
                            /** close **/
			                
			                date_default_timezone_set('Asia/Kolkata');
                            $todat_date_time = date('Y-m-d H:i:s');
			                $Array = array(
                            'cat' => $cat, 
                            'title' => $title, 
                            'name' => $name, 
                            'img' => $filename, 
                            'open' => $open,
                            'status' => 'Enable',
                            'created_at' =>$todat_date_time,
                            'updated_at' =>$todat_date_time
                            );
        	            
                        $run = $this->CreatePostModel->insert('tbl_reports_category', $Array);
                        //echo $this->db->last_query();exit;
                         if ($run) 
        				   {
        				     $this->session->set_flashdata('success', 'Apply Now Menu Added Successfully !!');
        				     redirect ('report-category');
        				   }
					      }
					   }
					}
					
                
	        }
	        
	        
	        
	        if($this->input->post('save') || $this->input->post('is_draft'))
	        {
	            
	            $inputCaptcha = htmlspecialchars(strip_tags($this->input->post('captcha')));
                  $sessCaptcha = strip_tags($this->session->userdata('captchaCode'));
	                if($inputCaptcha === $sessCaptcha){
	        
	           
    	         $content=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('content')))));
    	         $content=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('content')))));
    	        $replaceUrl="../";
    	        $content=str_replace($replaceUrl,'/',$content);
    	        $replaceUrl="//";
    	        $content=str_replace($replaceUrl,'/',$content);
    	        $content=str_replace("'",' ',$content);
    	        
    	        if($this->session->userdata('langId')==1)
    	        {
    	            
    	            $pagename=substr(strtolower(trim($this->security->xss_clean(trim(strip_tags($this->input->post('pagename')))))),0,60);
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
            
                $this->form_validation->set_rules('pagename', 'Pagename', 'trim|required');
                $this->form_validation->set_rules('pagetitle', 'pagetitle', 'trim|required');
                $this->form_validation->set_rules('ptags', 'ptags', 'trim|required');
                
                 $this->form_validation->set_rules('hover_title', 'Hover Title', 'required');
	              
	                $this->form_validation->set_rules('meta_desc', 'Description', 'required');
	                 $this->form_validation->set_rules('meta_subject', 'Subject', 'required');
                // $this->form_validation->set_rules('content', 'content', 'alpha_dash|trim|required');
            
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
            
                    $permalink="https://municipalservices.in/SaidiReddy/" .$site_controller; // creating permallinks
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
	            
    	            $params=array(
        	           'ulbid'=>$this->session->userdata('ulbid'),
        	           'content'=>$content,
        	           'controller'=>$pagename,
        	           'is_draft'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('is_draft'))))),
        	           'page_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagename'))))),
        	           'page_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagetitle'))))),
        	            'pagekeywords'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('ptags'))))),
        	           'is_custumlink'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('is_custumlink')))))),
        	           'permalink'=>preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($permalink))),
        	           'fromDate'=>$from,
        	           'toDate'=>$to,
        	           'datetime'=>date('Y-m-d H:i:s'),
        	           'langId'=>$this->security->xss_clean(trim($this->session->userdata('langId'))),
        	           'author'=>$this->security->xss_clean(trim($this->session->userdata('username'))),
        	           'site_controller'=>$site_controller,
        	           'page_sidebars_id'=>'4',
        	           'meta_desc'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_desc'))))),
        	            'meta_subject'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_subject'))))),
        	            'hover_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('hover_title'))))),
        	           'user_level'=>'U',
        	           'pageheading'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9,]/', ' ', htmlspecialchars(strip_tags($this->input->post('pagename'))))))
    	            );
    	            
    	        
	       
    	           if($this->input->post('is_draft') == 0)
    	           {
        	         
        	           if($this->input->post('fromDate') > date('d-m-Y'))
        	           {
        	               $this->session->set_flashdata('message','Your Post will be live from'.htmlspecialchars(strip_tags($this->input->post('fromDate'))));
        	           }
        	           else
        	           {
        	               $this->session->set_flashdata('message','Your Post will be live from'.htmlspecialchars(strip_tags($this->input->post('fromDate'))));
        	           }
    	           }
    	           else
    	           {
    	               $this->session->set_flashdata('message','Your Post Saved successfully');
    	           }
    	           
    	           // print_r ($params);exit;
    	           
	           
	               $data1=$this->CreatePostModel->customePageDataInsert($params);
        	       if($data1['result']=='1')
        	       {
        	            $pagename="'".$pagename."'";
        	            $configFilePath=$_SERVER['DOCUMENT_ROOT'].'/iimvfieldweb/admin/application/config/routes.php'; // adding url in admin confing file
        	            $configFilePath2=$_SERVER['DOCUMENT_ROOT'].'/iimvfieldweb/application/config/routes.php'; // adding url in site config
        				$file=fopen($configFilePath,'a') or die('cannot append to file');
        			
        				$controllerNameNoextension='CustomePageController/getPageContent/'.$data['pageId'];
        				$controller='$route['.$pagename.']='."'".$controllerNameNoextension."';";
        				fwrite($file,"\n".$controller);
        				fclose($file);
        				
        				
        				$pagename="'".$pagename2."'";
        				
        				$file=fopen($configFilePath2,'a') or die('cannot append to file');
        			
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
        				               
        				               $query2.="'".htmlspecialchars(strip_tags($this->input->post($postvalue)))."'"; 
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
    	            
    	            
    	            $this->session->set_flashdata('message','Post created successfully');
    	        }
    	        else
    	        {
    	            $this->session->set_flashdata('message','Unable to create post , Please try again');
    	            
    	        }
	        
	    }
	    	
	}
	   else{
	           $this->session->set_flashdata('message',"<div class='alert alert-danger'>Captcha code does not match, please try again. </div>");
	       }  
	    
	        }
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
	    $categories=$this->CreatePostModel->getPostCategories($params);
	   
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
	    foreach($formdata->result() as $key=>$val)
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
            'font_path'     => 'system/fonts/texb.ttf',
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
	    $data['all']= $this->CreatePostModel->all('tbl_reports_category', $params);
	    //print_r($data['all_startups_partners']);exit;
	    $this->load->view('header',$data);
		$this->load->view('report/report-category',$data);
		$this->load->view('divdata',$data);
		$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('login');
	    }
	    
	
	}
	
	public function deletereportcategory()
	{
	    $delid = $this->uri->segment('3');
	    $del = $this->CreatePostModel->delete('tbl_reports_category', array('id' => $delid));
	    if ($del) 
	     {
	         
	   	  $this->session->set_flashdata('success', 'Deleted Successfully !! ');
	      redirect('report-category');
	     }
	}
	public function getCaptcha(){
	    
	    $captcha_reload = htmlspecialchars(strip_tags($this->input->post('captcha_reload')));
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
	
	public function editreportcategory()
	{
	    
	   if($this->session->userdata('session_id')==session_id())
	    {
	        $editid = $this->uri->segment('2');
	        $data['dtl'] = $this->CreatePostModel->get_row('tbl_reports_category', array('id' => $editid));
	        
	        
	        if($this->input->post('update_01'))
	        {
	            $title = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('title')))));
	            $name = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('name')))));
	            $cat = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('cat')))));
	            $open = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('open')))));
				$status = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('status')))));
				if($cat == 1)
				{
				   $name = 'Monthly' ;
				}
				else if($cat == 2)
				{
				    $name = 'Quarlerly' ;
				}
				else if($cat == 3)
				{
				    $name = 'Yearly' ;
				}
				
				$file = $_FILES['file']['name'];
				if ($file) 
					{
					$this->load->library('upload');
					  if (!empty($_FILES['file']['name']))
					   {
			            $config['upload_path'] = './../assets/reports';
			            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|JPEG|PNG'; 
					    $this->upload->initialize($config);

			            if ($this->upload->do_upload('file'))
			              {
			                $file = $this->upload->data();
			             //   $file = $file['file_name'];
			                
			                 /** checking for malicious file upload **/
                            $file_info = new finfo(FILEINFO_MIME_TYPE);
                            $mime_types_array = array('image/jpg','image/jpeg','image/png');
                            $finopath = $target_file;
                            $a = getimagesize($file['full_path']);
                            
                            $filename = date('YmdHis').rand(999,100000).".jpg";
                            
                            $mime_type = $file_info->buffer(file_get_contents($file['full_path']));
                           
                                if(!in_array($mime_type,$mime_types_array))
                                   {
                                       unlink($file['full_path']);
                                       die('Invalid file type');
                                   }
                                   else
                                   {
                                       $src_file = $file['full_path'];
                                       $dest_file = '../assets/reports/'.$filename;
                                        $img_quality = 70;
                                         header('Content-Type: image/png');
                                        $im = imagecreatefromstring(file_get_contents($src_file));
                                        $im_w = imagesx($im);
                                        $im_h = imagesy($im);
                                        $tn = imagecreatetruecolor($im_w, $im_h);
                                        imagecopyresampled ( $tn , $im, 0, 0, 0, 0, $im_w, $im_h, $im_w, $im_h );
                                        imagejpeg($tn,$dest_file,$img_quality);
                                        
                                        unlink($file['full_path']);
                                       
                                   }
                           
                            /** close **/
			                
			                $Array = array(
			                    'img' => $filename, 
			                    );
			                $run = $this->CreatePostModel->update('tbl_reports_category', $Array, array('id' => $editid));
					      }
					   }
					}
					
                date_default_timezone_set('Asia/Kolkata');
                $todat_date_time = date('Y-m-d H:i:s');
                $Array = array(
                    'title' => $title, 
                    'name' => $name,
                    'cat' => $cat, 
                    'open' => $open, 
                    'status' => $status,
                    'created_at' =>$todat_date_time
                    );
                $run = $this->CreatePostModel->update('tbl_reports_category', $Array, array('id' => $editid));
                 if ($run) 
				   {
				     $this->session->set_flashdata('success', 'About Slider Updated Successfully !!');
				     redirect ('report-category');
				   }
	        }
	       
	        
	        if($this->input->post('save') || $this->input->post('is_draft'))
	        {
	            
	            $inputCaptcha = htmlspecialchars(strip_tags($this->input->post('captcha')));
                  $sessCaptcha = htmlspecialchars(strip_tags($this->session->userdata('captchaCode')));
	           if($inputCaptcha === $sessCaptcha){
    	        $content=$this->input->post('content');
    	        $content=$this->input->post('content');
    	        $replaceUrl="../";
    	        $content=str_replace($replaceUrl,'/',$content);
    	        $replaceUrl="//";
    	        $content=str_replace($replaceUrl,'/',$content);
    	        $content=str_replace("'",' ',$content);
    	        
    	        if($this->session->userdata('langId')==1)
    	        {
    	            $pagename=substr(strtolower(trim($this->security->xss_clean(trim(strip_tags($this->input->post('pagename')))))),0,60);
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
            
                $this->form_validation->set_rules('pagename', 'Pagename', 'trim|required');
                $this->form_validation->set_rules('pagetitle', 'pagetitle', 'trim|required');
                $this->form_validation->set_rules('ptags', 'ptags', 'trim|required');
                
                 $this->form_validation->set_rules('hover_title', 'Hover Title', 'required');
	              
	                $this->form_validation->set_rules('meta_desc', 'Description', 'required');
	                 $this->form_validation->set_rules('meta_subject', 'Subject', 'required');
                // $this->form_validation->set_rules('content', 'content', 'alpha_dash|trim|required');
            
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
            
                    $permalink="https://municipalservices.in/SaidiReddy/" .$site_controller; // creating permallinks
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
	            
    	            $params=array(
        	           'ulbid'=>$this->session->userdata('ulbid'),
        	           'content'=>$content,
        	           'controller'=>$pagename,
        	           'is_draft'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('is_draft'))))),
        	           'page_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagename'))))),
        	           'page_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagetitle'))))),
        	            'pagekeywords'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('ptags'))))),
        	           'is_custumlink'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('is_custumlink')))))),
        	           'permalink'=>preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($permalink))),
        	           'fromDate'=>$from,
        	           'toDate'=>$to,
        	           'datetime'=>date('Y-m-d H:i:s'),
        	           'langId'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('langId'))))),
        	           'author'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('username'))))),
        	           'site_controller'=>$site_controller,
        	           'page_sidebars_id'=>'4',
        	           'meta_desc'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_desc'))))),
        	            'meta_subject'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_subject'))))),
        	            'hover_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('hover_title'))))),
        	           'user_level'=>'U',
        	           'pageheading'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9,]/', ' ', htmlspecialchars(strip_tags($this->input->post('pagename'))))))
    	            );
    	            
    	        
	       
    	           if($this->input->post('is_draft') == 0)
    	           {
        	         
        	           if($this->input->post('fromDate') > date('d-m-Y'))
        	           {
        	               $this->session->set_flashdata('message','Your Post will be live from'.htmlspecialchars(strip_tags($this->input->post('fromDate'))));
        	           }
        	           else
        	           {
        	               $this->session->set_flashdata('message','Your Post will be live from'.htmlspecialchars(strip_tags($this->input->post('fromDate'))));
        	           }
    	           }
    	           else
    	           {
    	               $this->session->set_flashdata('message','Your Post Saved successfully');
    	           }
    	           
    	           // print_r ($params);exit;
    	           
	           
	               $data1=$this->CreatePostModel->customePageDataInsert($params);
        	       if($data1['result']=='1')
        	       {
        	            $pagename="'".$pagename."'";
        	            $configFilePath=$_SERVER['DOCUMENT_ROOT'].'/iimvfieldweb/admin/application/config/routes.php'; // adding url in admin confing file
        	            $configFilePath2=$_SERVER['DOCUMENT_ROOT'].'/iimvfieldweb/application/config/routes.php'; // adding url in site config
        				$file=fopen($configFilePath,'a') or die('cannot append to file');
        			
        				$controllerNameNoextension='CustomePageController/getPageContent/'.$data['pageId'];
        				$controller='$route['.$pagename.']='."'".$controllerNameNoextension."';";
        				fwrite($file,"\n".$controller);
        				fclose($file);
        				
        				
        				$pagename="'".$pagename2."'";
        				
        				$file=fopen($configFilePath2,'a') or die('cannot append to file');
        			
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
        				               
        				               $query2.="'".htmlspecialchars(strip_tags($this->input->post($postvalue)))."'"; 
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
    	            
    	            
    	            $this->session->set_flashdata('message','Post created successfully');
    	        }
    	        else
    	        {
    	            $this->session->set_flashdata('message','Unable to create post , Please try again');
    	            
    	        }
	        
	    }
	    	
	}
	   else{
	           $this->session->set_flashdata('message',"<div class='alert alert-danger'>Captcha code does not match, please try again. </div>");
	       }  
	    
	        }
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
	    $categories=$this->CreatePostModel->getPostCategories($params);
	   
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
	    foreach($formdata->result() as $key=>$val)
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
            'font_path'     => 'system/fonts/texb.ttf',
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
	    $data['all']= $this->CreatePostModel->all_records('testimonials', $params);
	    //print_r($data['all_startups_partners']);exit;
	    $this->load->view('header',$data);
	    
	    $this->load->view('report/edit-report-category',$data);
	    
		
		$this->load->view('divdata',$data);
		$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	public function editreportcategorydetails()
	{
	   if($this->session->userdata('session_id')==session_id())
	    {
	        $editid = $this->uri->segment('2');
	        $data['dtl'] = $this->CreatePostModel->get_row('tbl_reports_category', array('id' => $editid));
	       
    	    $params = array('cat' => $data['dtl']->id);
    	    $data['all']= $this->CreatePostModel->all_records('tbl_reports_sub_category', $params);
    	    //echo $this->db->last_query();exit; 
	        if($this->input->post('upload'))
	        {
	            $fileUpload = $_FILES['userfile']['name'];
        	    if($fileUpload)
        	    {
        	        $this->load->library('upload');
                    $dataInfo = array();
                    $files = $_FILES;
                    $cpt = count($_FILES['userfile']['name']);
                    $imgg = array();
                    for($i=0; $i<$cpt; $i++)
                    {           
                        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                        $_FILES['userfile']['size']= $files['userfile']['size'][$i];    
                
                        $this->upload->initialize($this->set_upload_options());
                        $this->upload->do_upload('userfile');
                        $dataInfo[] = $this->upload->data();
                        
                        date_default_timezone_set('Asia/Kolkata');
                        $todat_date_time = date('Y-m-d H:i:s');
                        $Array = array(
                            'cat' => $editid, 
                            'img' => $dataInfo[$i]['file_name'], 
                            'status' => 'Enable',
                            'created_at' =>$todat_date_time
                            );
                        $run = $this->CreatePostModel->insert('tbl_reports_sub_category', $Array);
                        //echo $this->db->last_query();exit;
                        
                    }
        	    }
				 $this->session->set_flashdata('success', 'Uploaded Successfully !!');
        		 redirect ('report-category-details/'.$editid);	
               
	        }
	       
	        
	        if($this->input->post('save') || $this->input->post('is_draft'))
	        {
	            
	            $inputCaptcha = htmlspecialchars(strip_tags($this->input->post('captcha')));
                  $sessCaptcha = htmlspecialchars(strip_tags($this->session->userdata('captchaCode')));
	                if($inputCaptcha === $sessCaptcha){
	        
	           
    	         $content=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('content')))));
    	         $content=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('content')))));
    	        $replaceUrl="../";
    	        $content=str_replace($replaceUrl,'/',$content);
    	        $replaceUrl="//";
    	        $content=str_replace($replaceUrl,'/',$content);
    	        $content=str_replace("'",' ',$content);
    	        
    	        if($this->session->userdata('langId')==1)
    	        {
    	            
    	            $pagename=substr(strtolower(trim($this->security->xss_clean(trim(strip_tags($this->input->post('pagename')))))),0,60);
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
            
                $this->form_validation->set_rules('pagename', 'Pagename', 'trim|required');
                $this->form_validation->set_rules('pagetitle', 'pagetitle', 'trim|required');
                $this->form_validation->set_rules('ptags', 'ptags', 'trim|required');
                
                 $this->form_validation->set_rules('hover_title', 'Hover Title', 'required');
	              
	                $this->form_validation->set_rules('meta_desc', 'Description', 'required');
	                 $this->form_validation->set_rules('meta_subject', 'Subject', 'required');
                // $this->form_validation->set_rules('content', 'content', 'alpha_dash|trim|required');
            
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
            
                    $permalink="https://municipalservices.in/SaidiReddy/" .$site_controller; // creating permallinks
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
	            
    	            $params=array(
        	           'ulbid'=>$this->session->userdata('ulbid'),
        	           'content'=>$content,
        	           'controller'=>$pagename,
        	           'is_draft'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('is_draft'))))),
        	           'page_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagename'))))),
        	           'page_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagetitle'))))),
        	            'pagekeywords'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('ptags'))))),
        	           'is_custumlink'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', strip_tags($this->input->post('is_custumlink'))))),
        	           'permalink'=>preg_replace('/[^A-Za-z0-9]/', ' ', strip_tags($permalink)),
        	           'fromDate'=>$from,
        	           'toDate'=>$to,
        	           'datetime'=>date('Y-m-d H:i:s'),
        	           'langId'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('langId'))))),
        	           'author'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('username'))))),
        	           'site_controller'=>$site_controller,
        	           'page_sidebars_id'=>'4',
        	           'meta_desc'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_desc'))))),
        	            'meta_subject'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_subject'))))),
        	            'hover_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('hover_title'))))),
        	           'user_level'=>'U',
        	           'pageheading'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9,]/', ' ', htmlspecialchars(strip_tags($this->input->post('pagename'))))))
    	            );
    	            
    	        
	       
    	           if($this->input->post('is_draft') == 0)
    	           {
        	         
        	           if($this->input->post('fromDate') > date('d-m-Y'))
        	           {
        	               $this->session->set_flashdata('message','Your Post will be live from'.htmlspecialchars(strip_tags($this->input->post('fromDate'))));
        	           }
        	           else
        	           {
        	               $this->session->set_flashdata('message','Your Post will be live from'.htmlspecialchars(strip_tags($this->input->post('fromDate'))));
        	           }
    	           }
    	           else
    	           {
    	               $this->session->set_flashdata('message','Your Post Saved successfully');
    	           }
    	           
    	           // print_r ($params);exit;
    	           
	           
	               $data1=$this->CreatePostModel->customePageDataInsert($params);
        	       if($data1['result']=='1')
        	       {
        	            $pagename="'".$pagename."'";
        	            $configFilePath=$_SERVER['DOCUMENT_ROOT'].'/iimvfieldweb/admin/application/config/routes.php'; // adding url in admin confing file
        	            $configFilePath2=$_SERVER['DOCUMENT_ROOT'].'/iimvfieldweb/application/config/routes.php'; // adding url in site config
        				$file=fopen($configFilePath,'a') or die('cannot append to file');
        			
        				$controllerNameNoextension='CustomePageController/getPageContent/'.$data['pageId'];
        				$controller='$route['.$pagename.']='."'".$controllerNameNoextension."';";
        				fwrite($file,"\n".$controller);
        				fclose($file);
        				
        				
        				$pagename="'".$pagename2."'";
        				
        				$file=fopen($configFilePath2,'a') or die('cannot append to file');
        			
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
        				               
        				               $query2.="'".htmlspecialchars(strip_tags($this->input->post($postvalue)))."'"; 
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
    	            
    	            
    	            $this->session->set_flashdata('message','Post created successfully');
    	        }
    	        else
    	        {
    	            $this->session->set_flashdata('message','Unable to create post , Please try again');
    	            
    	        }
	        
	    }
	    	
	}
	   else{
	           $this->session->set_flashdata('message',"<div class='alert alert-danger'>Captcha code does not match, please try again. </div>");
	       }  
	    
	        }
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
	    $categories=$this->CreatePostModel->getPostCategories($params);
	   
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
	    foreach($formdata->result() as $key=>$val)
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
            'font_path'     => 'system/fonts/texb.ttf',
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
	     
	    //print_r($data['all_startups_partners']);exit;
	    $this->load->view('header',$data);
	    
	    $this->load->view('report/report-category-details',$data);
	    
		
		$this->load->view('divdata',$data);
		$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	private function set_upload_options()
    {   
        //upload an image options
        $config = array();
        $config['upload_path'] = './../assets/reports/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = '0';
        $config['overwrite']     = FALSE;
    
        return $config;
    }
	public function deletereportsubcategory()
	{
	    $delid = $this->uri->segment('3');
	    $redirectid = $this->uri->segment('4');
	    $del = $this->CreatePostModel->delete('tbl_reports_sub_category', array('id' => $delid));
	    if ($del) 
	     {
	         
	   	  $this->session->set_flashdata('success', 'Deleted Successfully !! ');
	      redirect('report-category-details/'.$redirectid);
	     }
	}
}

