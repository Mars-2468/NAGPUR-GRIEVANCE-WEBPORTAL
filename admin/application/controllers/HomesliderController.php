<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class HomesliderController extends CI_Controller {

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
	    $this->load->model('HomesliderModel');
	    $this->load->library('form_validation');
	    
	 }
	 
	 
	 public function insertImgInfo()
	 {
	      if($this->session->userdata('session_id')==session_id())
	    {
	     $params=array(
	         'title'=>$this->security->xss_clean(trim($this->input->post('title'))),
	         'slide_desc'=>$this->security->xss_clean(trim($this->input->post('description'))),
	         'status'=>$this->security->xss_clean(trim($this->input->post('status'))),
	         'alttext'=>$this->security->xss_clean(trim($this->input->post('alttext'))),
	         'slide_id'=>$this->security->xss_clean(trim($this->input->post('slide_id'))),
	         'slide_heading'=>$this->security->xss_clean(trim($this->input->post('heading')))
	         );
	         
	         $result=$this->HomesliderModel->insertImgInfo($params);
	         echo $result;
	    }
	    else
	    {
	        redirect('login');
	    }
	         
	 }
	 
	 public function getImgInfo()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    {
	     $params=array('slide_id'=>$this->input->post('slide_id'));
	     $result=$this->HomesliderModel->getImgInfo($params);
	     echo json_encode($result);
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 public function updateSortOrder()
	 {
	         if($this->session->userdata('session_id')==session_id())
	    {   
            	if($this->input->post('selectedslides')) {
            
            	
            	for($i=0;$i<count($this->security->xss_clean(trim($this->input->post('selectedslides'))));$i++) {
            	    
            	    $params=array(
            	        'slide_id'=>$this->security->xss_clean(trim($this->input->post('selectedslides')))[$i],
            	        'sort_order'=>$i
            	        );
            	        
            	        $this->HomesliderModel->updateSortOrder($params);
            	
            	}
            	
            
            }
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 public function updateContent()
	 {
	      if($this->session->userdata('session_id')==session_id())
	    {
	     
	     
	     
	     if(!empty($this->input->post('slide')))
	     {
	         for($i=0; $i<count($this->security->xss_clean(trim($this->input->post('slide')))); $i++)
	         {
	             $params=array(
	                 'slide_id'=>$this->security->xss_clean(trim($this->input->post('slide')))[$i],
	                 'slide_desc'=>$this->security->xss_clean(trim($this->input->post('description')))[$i],
	                 'title'=>$this->security->xss_clean(trim($this->input->post('title')))[$i]
	                 
	                 );
	                 $this->HomesliderModel->updateContent($params);
	                 
	                 
	         }
	         $this->session->set_flashdata('message','Content updated successfully');
	         redirect('add-slider');
	     }
	    }
	    else
	    {
	        redirect('login');
	    }
	    
	    
	 }
	 
	 
	 
	 public function deleteContent()
	 {
	      if($this->session->userdata('session_id')==session_id())
	    {
	     $params=array('slide_id'=>$this->input->post('slide_id'));
	     $result=$this->HomesliderModel->deleteContent($params);
	     echo $result;
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 

	 
	 
	 
	 
	 
		public function imageUploadPost()

	{
	    
	     if($this->session->userdata('session_id')==session_id())
	    {
	    
	    

		$config['upload_path']   = 'assets/sliders/2019/'.$this->session->userdata('username')."/"; 

		$config['allowed_types'] = 'gif|jpg|png|jpeg'; 

		$config['max_size']      = '20480';
		


      	$this->load->library('upload', $config);
      	
      	if(!is_dir($config['upload_path']))
            {
            mkdir($config['upload_path'], 0755, TRUE);
            }
            
            $this->upload->do_upload('file');
		    $upload_data = $this->upload->data(); 
	        $file_name = $upload_data['file_name'];
            
            $thumbnailpath=$config['upload_path']."thumbnails/";
            
                if(!is_dir($thumbnailpath))
                {
                mkdir($thumbnailpath, 0755, TRUE);
                
                }
             $thumbnailpath=$config['upload_path']."thumbnails/".$file_name;  
                 

		
		$full_path=base_url()."assets/sliders/2019/".$this->session->userdata('username')."/".$file_name;
		
		$params=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'folder_path'=>$config['upload_path'].$file_name,
		    'image_path'=>$file_name,
		    'status'=>0,
		    'file_type'=>$upload_data['file_name'],
		    'file_path'=>$upload_data['file_path'],
		    'full_path'=>$upload_data['full_path'],
		    'raw_name'=>$upload_data['raw_name'],
		    'orig_name'=>$upload_data['orig_name'],
		    'client_name'=>$upload_data['client_name'],
		    'file_ext'=>$upload_data['file_ext'],
		    'file_size'=>$upload_data['file_size'],
		    'is_image'=>$upload_data['is_image'],
		    'image_width'=>$upload_data['image_width'],
		    'image_height'=>$upload_data['image_height'],
		    'image_type'=>$upload_data['image_type'],
		    'image_size_str'=>$upload_data['image_size_str'],
		    'thumbnail_path'=>$thumbnailpath
		    );
		    
		    $params2=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'folder_path'=>$config['upload_path'].$file_name,
		    'image_path'=>$file_name,
		    
		    'file_type'=>$upload_data['file_name'],
		    'file_path'=>$upload_data['file_path'],
		    'full_path'=>$full_path,
		    'raw_name'=>$upload_data['raw_name'],
		    'orig_name'=>$upload_data['orig_name'],
		    'client_name'=>$upload_data['client_name'],
		    'file_ext'=>$upload_data['file_ext'],
		    'file_size'=>$upload_data['file_size'],
		    'is_image'=>$upload_data['is_image'],
		    'image_width'=>$upload_data['image_width'],
		    'image_height'=>$upload_data['image_height'],
		    'image_type'=>$upload_data['image_type'],
		    'image_size_str'=>$upload_data['image_size_str']
		    );
		    
		    $uploadData=$this->setImage($imgWidth=1210,$imgHeight=311,$thumnailWidth=200,$thumbnaidHeight=51,$imgPath=$config['upload_path'].$file_name,$thumbimgpath=$thumbnailpath."/".$file_name);
        
		
		$this->HomesliderModel->addSlider($params,$params2);
		
		$this->session->set_flashdata('message','Images uploaded successfully');
		
		
		
	    }
	    else
	    {
	        redirect('login');
	    }


		

	}
	
	
        
        public function setImage($imgWidth,$imgHeight,$imgPath,$filename,$thumbspath)
        	{
        	   if($this->session->userdata('session_id')==session_id())
	    { 
        	    $curyear=date("Y");
                $curmonth=date('m');
                   
                                                
                 $thumbspath.="thumbs/";
                 if (!file_exists($thumbspath)) 
                    {
                        mkdir($thumbspath, 0777, true);
                         $thumbspath.=$curmonth."/";
                        if (!file_exists($thumbspath)) 
                            {
                                mkdir($thumbspath, 0777, true);
                            }
                    }
                    else
                    {
                         $thumbspath.=$curmonth."/";
                        if (!file_exists($thumbspath)) 
                            {
                                mkdir($thumbspath, 0777, true);
                            }
                    }
                
                                               
                                             
        	        $this->load->library('image_lib');
        			$config = array(
        			'source_image' => $imgPath,
        			'maintain_ratio' => FALSE,
        			'new_image' => $thumbspath.$filename,
        			'width' => $imgWidth,
        			'height' => $imgHeight,
        			'x_axis' => 50,
        			'y_axis' => 50
        			);
        			$this->image_lib->clear();
        			$this->image_lib->initialize($config);
        		    $this->image_lib->crop();
        		    
        		    $path=$thumbspath.$filename;
        		    
        		    $str = substr($path, 2);
        		    
        		    
        		    return $str;
        			
	    }
	    else
	    {
	        redirect('login');
	    }
        	}
        
        
        
	 
	public function index()
	{
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	    $submenudata=array();
	    
	    
	    if($this->input->post('save'))
	    {
	        
	                $this->form_validation->set_rules('userfile', 'Image', 'required');
                    $this->form_validation->set_rules('title', 'Image Name', 'required');
                    $this->form_validation->set_rules('alttext', 'Alt tag', 'required');
                    $this->form_validation->set_rules('slide_heading', 'Heading', 'required');
                    $this->form_validation->set_rules('slide_desc', 'Description', 'required');
                    $this->form_validation->set_rules('check_list', 'languages', 'required');
	        
	        
	               if ($this->form_validation->run() == FALSE)
                {
                        //$this->load->view('myform');
                }
                else
                {
	                
	                
	               
	                $dataInfo = array();
                    $files = $_FILES;
                    $cpt = count($_FILES['userfile']['name']);
                    for($i=0; $i<$cpt; $i++)
                    {     
                        
                        
                        $this->form_validation->set_rules("title[$i]",'Title','required');
                        $this->form_validation->set_rules("alttext[$i]",'Title','required');
                        $this->form_validation->set_rules("slide_heading[$i]",'Title','required');
                        $this->form_validation->set_rules("slide_desc[$i]",'Title','required');
                        
                        if($this->form_validation->run()==FALSE)
                        {
                            $data['file_errors']=array('error'=>"<div class='alert alert-danger'>All fields are required</div>");
                        }
                        else
                        {
                            $image_info = getimagesize($files['userfile']["tmp_name"][$i]);
                            $image_width = $image_info[0];
                            $image_height = $image_info[1];
                            
                            //1210,311
                            if($image_width < 1210 || $image_height < 311)
                            {
                                $data['file_errors']=array('error'=>"<div class='alert alert-danger'> Image ".$i." Dimensions are not matched image dimensions should be greater than or equalant to 1210 X 311</div>");
                            }
                            else
                            {
                            
                            
                        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                        $_FILES['userfile']['size']= $files['userfile']['size'][$i]; 
                        
                        
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
                                             $upload_path.="sliderimages/";
                                             $thumbspath=$upload_path;
                                             if (!file_exists($upload_path)) 
                                                {
                                                    mkdir($upload_path, 0777, true);
                                                    $upload_path.=$curmonth."/";
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
                                             $upload_path.="sliderimages/";
                                             $thumbspath=$upload_path;
                                             if (!file_exists($upload_path)) 
                                                {
                                                    mkdir($upload_path, 0777, true);
                                                    $upload_path.=$curmonth."/";
                                                    if (!file_exists($upload_path)) 
                                                        {
                                                            mkdir($upload_path, 0777, true);
                                                        }
                                                }
                                        }
                                        else
                                        {
                                             $upload_path.="sliderimages/";
                                             $thumbspath=$upload_path;
                                             if (!file_exists($upload_path)) 
                                                {
                                                    mkdir($upload_path, 0777, true);
                                                    $upload_path.=$curmonth."/";
                                                    if (!file_exists($upload_path)) 
                                                        {
                                                            mkdir($upload_path, 0777, true);
                                                        }
                                                }
                                                else
                                                {
                                                    $upload_path.=$curmonth."/";
                                                    if (!file_exists($upload_path)) 
                                                        {
                                                            mkdir($upload_path, 0777, true);
                                                        }
                                                }
                                        }
                            }
                            $config = array();
                            $config['upload_path'] = $upload_path;
                            $config['allowed_types'] = 'gif|jpg|png|jpeg';
                            $config['max_size']      = '20480';
                            $config['overwrite']     = FALSE;
                        
                        
                         $this->load->library('upload',$config);
                
                        //$this->upload->initialize($this->set_upload_options());
                        if(!$this->upload->do_upload())
                        {
                            print_r($this->upload->display_errors());
                        }
                        
                        $upload_data = $this->upload->data();
                        
                        $imgWidth=1210;
                        $imgHeight=311;
                        
                        $imgPath=$upload_path.$upload_data['file_name'];
                        
                        
                        $result = $this->setImage($imgWidth,$imgHeight,$imgPath,$upload_data['file_name'],$thumbspath);
                         
                        
                        
                        
                     
                        
                        
                    
                        
                       $params=array(
                		    'ulbid'=>$this->session->userdata('ulbid'),
                		    'folder_path'=>$upload_path.$upload_data['file_name'],
                		    'image_path'=>$upload_data['file_name'],
                		    'status'=>0,
                		    'file_type'=>$upload_data['file_ext'],
                		    'file_path'=>$upload_data['file_path'],
                		    'full_path'=>$upload_path.$upload_data['file_name'],
                		    'raw_name'=>$upload_data['raw_name'],
                		    'orig_name'=>$upload_data['orig_name'],
                		    'client_name'=>$upload_data['client_name'],
                		    'file_ext'=>$upload_data['file_ext'],
                		    'file_size'=>$upload_data['file_size'],
                		    'is_image'=>$upload_data['is_image'],
                		    'image_width'=>$upload_data['image_width'],
                		    'image_height'=>$upload_data['image_height'],
                		    'image_type'=>$upload_data['image_type'],
                		    'image_size_str'=>$upload_data['image_size_str'],
                		    'thumbnail_path'=>$result,
                		    'title'=>$this->security->xss_clean(trim($this->input->post('title')))[$i],
                		    'alttext'=>$this->security->xss_clean(trim($this->input->post('alttext')))[$i],
                		    'slide_heading'=>$this->security->xss_clean(trim($this->input->post('slide_heading')))[$i],
                		    'slide_desc'=>$this->security->xss_clean(trim($this->input->post('slide_desc')))[$i]
                		    );
                		    
                		    if(!empty($this->security->xss_clean(trim($this->input->post('check_list')))))
                		    {
                		        if(!in_array($this->security->xss_clean(trim($this->input->post('langId'))),$this->security->xss_clean(trim($this->input->post('check_list')))))
                		        {
                		            $params['langId']=$this->session->userdata('langId');
                		            $this->HomesliderModel->addSlider($params);
                		        }
                		        
                		        foreach($this->security->xss_clean(trim($this->input->post('check_list'))) as $val)
                		        {
                		            
                		            
                		            $params['langId']=$val;
                		            $this->HomesliderModel->addSlider($params);
                		            
                		        }
                		    }
                		    else
                		    {
                		        $params['langId']=$this->session->userdata('langId');
                		        $this->HomesliderModel->addSlider($params);
                		    }
                		    
                         
                        }
                        }
                    }
             }     
                
	    }
	    
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
	    $subMenus=$this->MenuModel->getSubMenu();
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    //$data['aboutData']=$aboutData=$this->AboutModel->getaboutData($params);
	   
	    
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    $data['sub_menus']=$submenudata;
	    
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'),'langId'=>$this->session->userdata('langId'));
	    
	    
	    
	    $data['sliderList']=$this->HomesliderModel->getSliderList($params);
	    
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('homeslider',$data['sliderList']);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
