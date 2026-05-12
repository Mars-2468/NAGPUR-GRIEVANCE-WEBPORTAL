<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class CreateWidgetController extends MY_Controller {

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
	 * 
	 */
	 public function __construct()
	 {
	     Parent::__construct();
	     $this->load->model('CreateWidgetModel');
	     $this->load->library('Textwidgetlibrary');
	     $this->load->library('Menulibrary');
	     $this->textwidgetlibrary=new Textwidgetlibrary();
	     $this->menuwidgetlibrary=new Menulibrary();
	     $this->load->helper('form');
	     $this->load->library('form_validation');
	     $this->load->model('ViewAlbumModel');
	 }
	 
	 public function savepageWidget()
	 {
         if($this->session->userdata('session_id')==session_id())
	    {
        
        if($this->input->post('save'))
	    {
        $ulbid = $this->session->userdata('ulbid');
        $ulb_check_list = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('ulb_check_list')))));
        
        array_push($ulb_check_list,$ulbid);
        
        $params=array(
            'widget_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgetname'))))),
            'widget_type'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgettype'))))),
            'check_list'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('check_list'))))),
            'ulb_check_list'=>$ulb_check_list,
            'flag'=>1,
            'langId'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('langId'))))),
            'author'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('userid'))))),
            'user_level'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('user_type')))))
        );
      //  print_r($params);exit;
        
        $result=$this->CreateWidgetModel->savepageWidget($params);  
        if($result)
        {
        $this->session->set_flashdata('message',"<div class='alert alert-success'> Widget added successfully </div>");
        }
        else
        {
        $this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to add , try again </div>");
        }
        redirect('creage-widget');
	    }
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 
	 
	  public function saveSliderpostWidget()
	 {
	     
	     if($this->session->userdata('session_id')==session_id())
	    { 
    	     if($this->input->post('save'))
    	    {
        $ulbid = $this->session->userdata('ulbid');
        $ulb_check_list = $this->input->post('ulb_check_list');
        
        array_push($ulb_check_list,$ulbid);
        
        $params=array(
            'widget_name'=>$this->security->xss_clean(trim(strip_tags($this->input->post('widgetname')))),
            'widget_type'=>$this->security->xss_clean(trim(strip_tags($this->input->post('widgettype')))),
            'check_list'=>$this->security->xss_clean(trim(strip_tags($this->input->post('check_list')))),
            'ulb_check_list'=>$ulb_check_list,
            'flag'=>1,
            'langId'=>strip_tags($this->session->userdata('langId')),
            'author'=>strip_tags($this->session->userdata('userid')),
            'user_level'=>strip_tags($this->session->userdata('user_type'))
        );
        
		foreach($params as $param){			
			if (preg_match('/<[^<]+>/', $param)) {
				echo "Error: HTML or script tag detected in ".$param." field!" ;
				redirect ('creage-widget');
				exit;
			}
		}
			
        //print_r($params);
        
        $result=$this->CreateWidgetModel->saveSliderpostWidget($params);  
        
        if($result){
            $this->session->set_flashdata('message',"<div class='alert alert-success'> Widget added successfully </div>");
        }else{
            $this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to add , try again </div>");
        }
        redirect('creage-widget');
	    }
	   }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 
	 
	 
	 
	  public function savepostWidget()
	 {
	     
	     if($this->session->userdata('session_id')==session_id())
	    { 
	     
	      if($this->input->post('save'))
	    {
	     // print_r($this->input->post()); exit;
        $ulbid = $this->session->userdata('ulbid');
        $ulb_check_list = $this->input->post('ulb_check_list');
        //print_r($ulb_check_list);
        //echo  $ulb_check_list[0];
        array_push($ulb_check_list,$ulbid);
        
        $params=array(
            'widget_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgetname'))))),
            'widget_type'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgettype'))))),
            'check_list'=>$this->input->post('check_list'),
         
            'ulb_check_list'=>$ulb_check_list,
            'flag'=>1,
            'langId'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('langId'))))),
            'author'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('userid'))))),
            'user_level'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('user_type')))))
        );
        
			foreach($params as $param){			
				if (preg_match('/<[^<]+>/', $param)) {
					echo "Error: HTML or script tag detected in ".$param." field!" ;
					redirect ('creage-widget');
					exit;
				}
			}
      //print_r($params);
     
        $result=$this->CreateWidgetModel->savepostWidget($params);  
       // echo "hi"; exit;
      //  echo $this->db->last_query(); exit;
        if($result){
            $this->session->set_flashdata('message',"<div class='alert alert-success'> Widget added successfully </div>");
        }else{
            $this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to add , try again </div>");
        }
        redirect('creage-widget');
	    }
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 
	 public function saveTabWidget()
	 {
	     
	      if($this->session->userdata('session_id')==session_id())
	    {
	        if($this->input->post('save'))
	    {
	     
	    $ulbid = $this->session->userdata('ulbid');
        $ulb_check_list = trim(htmlspecialchars(strip_tags($this->input->post('ulb_check_list'))));
      
        array_push($ulb_check_list,$ulbid);
	     
	    $params=array(
            'widget_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgetname'))))),
            'widget_type'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgettype'))))),
            'tab_type_id'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('tab_type_id'))))),
            'check_list'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('check_list'))))),
        	'ulb_check_list' => $ulb_check_list,
            'flag'=>1,
            'langId'=>htmlspecialchars(strip_tags($this->session->userdata('langId'))),
            'author'=>htmlspecialchars(strip_tags($this->session->userdata('userid'))),
            'user_level'=>htmlspecialchars(strip_tags($this->session->userdata('user_type')))
         );
          	foreach($params as $param){			
				if (preg_match('/<[^<]+>/', $param)) {
					echo "Error: HTML or script tag detected in ".$param." field!" ;
					redirect ('creage-widget');
					exit;
				}
			}
    	  $result=$this->CreateWidgetModel->saveTabWidget($params);  
    	  
    	  if($result)
    	  {
    	      $this->session->set_flashdata('message',"<div class='alert alert-success'> Widget added successfully </div>");
    	  }
    	  else
    	  {
    	      $this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to add , try again </div>");
    	  }
    	  redirect('creage-widget');
	    }
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 
	 	public function set_upload_options($upload_path)
        {   
            if($this->session->userdata('session_id')==session_id())
	    {
            
            if (!file_exists($upload_path)) 
            {
                    mkdir($upload_path, 0777, true);
            }
            $config = array();
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = '20480';
            $config['overwrite']     = FALSE;
        
            return $config;
	    }
	    else
	    {
	        redirect('login');
	    }
        }
        
        public function saveMediaGallerywidget()
        {
            
             if($this->session->userdata('session_id')==session_id())
	    {
            
            if($this->input->post('save'))
            {
            $ulbid = $this->session->userdata('ulbid');
            $ulb_check_list = htmlspecialchars(strip_tags($this->input->post('ulb_check_list')));
            
            array_push($ulb_check_list,$ulbid);
            $errors=array();
            $params=array(
        	         'widget_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgetname'))))),
        	         'widget_type'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgettype'))))),
        	         'flag'=>1,
        	         'ulbid'=>htmlspecialchars(strip_tags($this->session->userdata('ulbid'))),
        	         'langId'=>htmlspecialchars(strip_tags($this->session->userdata('langId'))),
        	         'author'=>htmlspecialchars(strip_tags($this->session->userdata('userid'))),
        	         'user_level'=>htmlspecialchars(strip_tags($this->session->userdata('user_type'))),
        	         'ulb_check_list'=>$ulb_check_list
        	         );
         //	print_r($params);
         	
			foreach($params as $param){			
				if (preg_match('/<[^<]+>/', $param)) {
					echo "Error: HTML or script tag detected in ".$param." field!" ;
					redirect ('creage-widget');
					exit;
				}
			}
        	 $widgetIdArray = $this->CreateWidgetModel->create_widget($params);       
            
           
            
            //$count=count($this->input->post("title"));
           
            $cnt=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('cnt')))));
            $curyear=date("Y");
            $curmonth=date('m');
            
               $upload_path='../assets/'.$this->session->userdata('ulbid').'/';
             
           
            //echo $upload_path;                
            if (!file_exists($upload_path)) 
            {
                mkdir($upload_path, 0777, true);
                $upload_path.=$curyear."/";
                if (!file_exists($upload_path)) 
                {
                    mkdir($upload_path, 0777, true);
                    $upload_path.=$curmonth."/";
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
                        $upload_path.="gallery/";
                        
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
                    $upload_path.=$curmonth."/";
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
                        $upload_path.="gallery/";
                        if (!file_exists($upload_path)) 
                        {
                            mkdir($upload_path, 0777, true);
                        }
                    }
                }
                else
                {
                    $upload_path.=$curmonth."/";
                    $thumbspath=$upload_path;
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
                        $upload_path.="gallery/";
                        if (!file_exists($upload_path)) 
                        {
                            mkdir($upload_path, 0777, true);
                        }
                    }
                    else
                    {
                        $upload_path.="gallery/";
                        
                           
                            $thumbspath=$upload_path;
                            if (!file_exists($upload_path)) 
                            {
                                mkdir($upload_path, 0777, true);
                            }
                       
                        else
                        {
                            
                            $thumbspath=$upload_path;
                            if (!file_exists($upload_path)) 
                            {
                                mkdir($upload_path, 0777, true);
                            }
                        }
                    }
                }
            }
            
            $thumbspath1 = $thumbspath;
            $fileuploadpath=$upload_path;
            
            foreach($_FILES as $key=>$val)
            {
                
                for($i=0;$i<=$cnt;$i++)
                {
                    
                    $files = $_FILES;
                
                
                    $_FILES['userfile']['name']= $val['name'][$i];
                    $_FILES['userfile']['type']= $val['type'][$i];
                    $_FILES['userfile']['tmp_name']= $val['tmp_name'][$i];
                    $_FILES['userfile']['error']= $val['error'][$i];
                    $_FILES['userfile']['size']= $val['size'][$i];   
                        
                        
                        
                        
                    $config['upload_path'] = $fileuploadpath;
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size']      = '20480';
                    $config['overwrite']     = FALSE;
                        
                    // Load and initialize upload library
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    
                           
                    if(!$this->upload->do_upload('userfile'))
                    {
                        print_r($this->upload->display_errors());
                    }
                    
                    $upload_data = $this->upload->data();
                    $upload_path1=substr($upload_path,2).$upload_data['file_name'];
                    
                    $imgWidth=474;
                    $imgHeight=250;
                    $imgPath=$upload_path.$upload_data['file_name'];
                    $result = $this->setImage($imgWidth,$imgHeight,$imgPath,$upload_data['file_name'],$thumbspath1);
                
                    if($_FILES['userfile']['name']==='')
                    {
                        $upload_data['file_name']=$this->security->xss_clean(trim(strip_tags(htmlspecialchars($this->input->post("image_url")))))[$i];
                        $full_path=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post("image_url")))))[$i];
                        $folder_path=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post("image_url")))))[$i];
                    }  
                    
                    foreach($widgetIdArray as $value){
                        $params1=array(
                            'widget_id'=>$value,
                            'thumbnail_path'=>$result,
                            'file_name'=>$upload_data['file_name'],
                            'folder_path'=>$upload_path1,
                            'full_path'=>$upload_path1,
                            'title'=> trim(htmlspecialchars(strip_tags($this->input->post('title')[$i]))),
                            'url_link'=>trim(htmlspecialchars(strip_tags($this->input->post('page_url')[$i]))),
                            'flag'=>1,
                            'target'=>trim(htmlspecialchars(strip_tags($this->input->post('target')[$i])))
                        );
                       //print_r($params1);exit;
						foreach($params1 as $param){			
							if (preg_match('/<[^<]+>/', $param)) {
								echo "Error: HTML or script tag detected in ".$param." field!" ;
								redirect ('creage-widget');
								exit;
							}
						}
        	             
        	         $resultGallery = $this->CreateWidgetModel->saveMediaGallerywidget($params1);
                    }
        	         if($resultGallery != 1){
        	             
        	             $errors[]=$_FILES['userfile']['name']." Not uploaded ";
        	         }else{
                        
                        $this->session->set_flashdata('message',"<div class='alert alert-success'>Photo gallery added successfully</div>");
                        //redirect('view-widgets');
                    }
                }
                
            }
            if(count($errors) > 0){
	           
	             $string="";
	             foreach($errors as $key=>$val)
	             {
	                 $string.=$val;
	             }
	             $this->session->set_flashdata('message',"<div class='alert alert-danger'>".$string."</div>");
	         }else{
	             $this->session->set_flashdata('message',"<div class='alert alert-success'>Photo gallery added successfully</div>");
	         }
	         
	        redirect('creage-widget');
	    }
	    }
	    else
	    {
	        redirect('login');
	    }
        }
        
        
    public function updateMediaGallerywidget()
    {
        
         if($this->session->userdata('session_id')==session_id())
	    {
        $errors=array();
        
        /*$userLevel = $this->session->userdata('user_type');
        $reDir = 'edite-widget/'.$this->input->post("widget_id").'/'.$this->input->post("widget_type");
        $this->form_validation->set_rules('widget_name', 'widget_name', 'trim|required');
        
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
                $params=array(
                    'widget_id'=>$this->input->post('widget_id'),
                    'content'=>$this->input->post('content'),
                    'widget_name'=>$this->input->post('widget_name'),
                    'widget_type'=>$this->input->post('widget_type'),
                    'author' => $this->session->userdata('userid'),
                    'ulb_check_list' => $this->input->post('ulb_check_list'),
                    'radio' => $this->input->post('radio'),
                    'user_level' => $this->session->userdata('user_type'),
                    'flag' => 1,
                    'langId'=>$this->session->userdata('langId')
                );
            }
        }else{
            
        }    
        */
      
       // $widget_id=$this->CreateWidgetModel->updatecreate_widget($params);      
        
        $widg=trim(htmlspecialchars(strip_tags($this->input->post("widget_id"))));
       
        $count=count(trim(htmlspecialchars(strip_tags($this->input->post("title")))));
       
        $curyear=date("Y");
        $curmonth=date('m');
        $file_name = trim(htmlspecialchars(strip_tags($this->input->post('fileName'))));
        $upload_path='../assets/'.$this->session->userdata('ulbid').'/';
        
        if (!file_exists($upload_path)) 
        {
            mkdir($upload_path, 0777, true);
            $upload_path.=$curyear."/";
            if (!file_exists($upload_path)) 
            {
                mkdir($upload_path, 0777, true);
                $upload_path.=$curmonth."/";
                if (!file_exists($upload_path)) 
                {
                    mkdir($upload_path, 0777, true);
                    $upload_path.="gallery/";
                 
                        $thumbspath=$upload_path;
                        if (!file_exists($upload_path))
                        {
                            mkdir($upload_path, 0777, true);
                        }
                
                }
            }
        }else{
            $upload_path.=$curyear."/";
            if (!file_exists($upload_path)) 
            {
                mkdir($upload_path, 0777, true);
                $upload_path.=$curmonth."/";
                $thumbspath=$upload_path;
                if (!file_exists($upload_path)) 
                {
                    mkdir($upload_path, 0777, true);
                    $upload_path.="gallery/";
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
                    }
                }
            }else{
                $upload_path.=$curmonth."/";
                $thumbspath=$upload_path;
                if (!file_exists($upload_path)) 
                {
                    mkdir($upload_path, 0777, true);
                    $upload_path.="gallery/";
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
                    }
                }else{
                    $upload_path.="gallery/";
                 
                        $thumbspath=$upload_path;
                        if (!file_exists($upload_path)) 
                        {
                            mkdir($upload_path, 0777, true);
                        }
                 
                    else{
                        
                    //     $thumbspath.= "thumbs/";
                    //     if(!file_exists($thumbspath)){
                    //         mkdir($thumbspath, 0777, true);
                    //     }
            	       // $thumbspath.= $file_name;
    	        
                        $thumbspath=$upload_path;
                        if (!file_exists($upload_path)) 
                        {
                            mkdir($upload_path, 0777, true);
                        }
                    }
                }
            }
        }
        
        $thumbspath1 = $thumbspath;
        $fileuploadpath=$upload_path;
        
        
        foreach($_FILES as $key=>$val)
        {
        
            for($i=0;$i<$count;$i++)
            {
               
                $files = $_FILES;
        
                $_FILES['userfile']['name']= $val['name'][$i];
                $_FILES['userfile']['type']= $val['type'][$i];
                $_FILES['userfile']['tmp_name']= $val['tmp_name'][$i];
                $_FILES['userfile']['error']= $val['error'][$i];
                $_FILES['userfile']['size']= $val['size'][$i];   
        
                $config['upload_path'] = $fileuploadpath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size']      = '20480';
                $config['overwrite']     = FALSE;
        
                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
        
        
                if(!$this->upload->do_upload('userfile'))
                {
                    //print_r($this->upload->display_errors());
                }
        
                $upload_data = $this->upload->data();
                
                
                
                /** checking for malicious file upload **/
                    $file_info = new finfo(FILEINFO_MIME_TYPE);
                    $mime_types_array = array('image/jpg','image/jpeg','image/png');
                    $finopath = $target_file;
                    $a = getimagesize($upload_data['full_path']);
                   
                    $filename = date('YmdHis').rand(999,100000).".jpg";
                    
               
                    $mime_type = $file_info->buffer(file_get_contents($upload_data['full_path']));
                   
                        if(!in_array($mime_type,$mime_types_array))
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
                                unlink($upload_data['full_path']);
                               
                           }
                   
                    /** close **/
                    
                
                
                $upload_data['file_name']=$filename;
                $folder_path=substr($upload_path,1).$upload_data['file_name'];
               
                if($_FILES['userfile']['name']==='')
                    {
                    $upload_data['file_name']=trim(htmlspecialchars(strip_tags($this->input->post("fileName")[$i])));
                    $folder_path=trim(htmlspecialchars(strip_tags($this->input->post("folder_path_name")[$i])));
                    //$thumbspath =$this->input->post("thumbnail_path")[$i];
                    }
               
                    $params1=array(
                        'id'=>trim(htmlspecialchars(strip_tags($this->input->post('pid')[$i]))),
                        'widget_name'=>trim(htmlspecialchars(strip_tags($this->input->post("widget_name")))),
                        'widget_id'=>trim(htmlspecialchars(strip_tags($this->input->post("widget_id")))),
                        'file_name'=>trim(htmlspecialchars(strip_tags($upload_data['file_name']))),
                        'folder_path'=>$folder_path,
                        'full_path'=>$folder_path,
                        'thumbnail_path'=>$thumbspath1,
                        'title'=>trim(htmlspecialchars(strip_tags($this->input->post("title")[$i]))),
                        'url_link'=>trim(htmlspecialchars(strip_tags($this->input->post("page_url")[$i]))),
                        'flag'=>1,
                        'target'=>trim(htmlspecialchars(strip_tags($this->input->post("target")[$i]))),
                        'author' => trim(htmlspecialchars(strip_tags($this->session->userdata('userid')))),
                        'langId'=>trim(htmlspecialchars(strip_tags($this->session->userdata('langId')))),
                        'user_level'=>trim(htmlspecialchars(strip_tags($this->session->userdata('user_type'))))
                    );
					
					// print_r($params1);exit;
			   
					foreach($params1 as $param){			
						if (preg_match('/<[^<]+>/', $param)) {
							echo "Error: HTML or script tag detected in ".$param." field!" ;
							redirect ('creage-widget');
							exit;
						}
					}
			
                    $result=$this->CreateWidgetModel->updateMediaGallerywidget($params1);
            
              
                if(!$result){
                
                    $errors[]=$_FILES['userfile']['name']." Not uploaded ";
                }
            }
        }
       
        if(count($errors) > 0){
            $string="";
            foreach($errors as $key=>$val)
            {
                $string.=$val;
            }
            $this->session->set_flashdata('message',"<div class='alert alert-danger'>".$string." not uploaded</div>");
        }else{
            $this->session->set_flashdata('message',"<div class='alert alert-success'>Photo gallery Updated successfully</div>");
            redirect('view-widgets');
        }
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
        
        
	 
	 
	 public function saveImageTextwidget()
	 {
	    if($this->session->userdata('session_id')==session_id())
	    {
	       
	     
	    if($this->input->post('save'))
	    {
	        $curyear=date("Y");
            $curmonth=date('m');
            
	        $files = $_FILES;
	        $this->load->library('upload');
	        
	        $upload_path='../assets/'.$this->session->userdata('ulbid').'/';
                            
            if (!file_exists($upload_path)) 
            {
                mkdir($upload_path, 0777, true);
                $upload_path.=$curyear."/";
                if (!file_exists($upload_path)) 
                {
                    mkdir($upload_path, 0777, true);
                    $upload_path.=$curmonth."/";
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
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
                    $upload_path.=$curmonth."/";
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
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
                    $upload_path.=$curmonth."/";
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
                        $upload_path.="widgets/";
                        $thumbspath=$upload_path;
                        if (!file_exists($upload_path)) 
                        {
                            mkdir($upload_path, 0777, true);
                        }
                    }
                    else
                    {
                        $upload_path.="widgets/";
                        $thumbspath=$upload_path;
                        if (!file_exists($upload_path)) 
                        {
                            mkdir($upload_path, 0777, true);
                        }
                    }
                }
            }
            
            // $cpt = count($_FILES['userfile']['name']);
            
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
            
            
            
            $imgWidth=388;
            $imgHeight=150;
            $imgPath=$upload_path.$upload_data['file_name'];
          //  echo 
            
            
            
            
            $folder_path=substr($path, 2);
          
            if($_FILES['userfile']['name']==='')
            {
            $upload_data['file_name']=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('image_url')))));
            $full_path=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('image_url')))));
            $folder_path=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('image_url')))));
            }
            
           
             /** checking for malicious file upload **/
                    $file_info = new finfo(FILEINFO_MIME_TYPE);
                    $mime_types_array = array('image/jpg','image/jpeg','image/png');
                    $finopath = $target_file;
                    $a = getimagesize($upload_data['full_path']);
                   
                    $filename = date('YmdHis').rand(999,100000).".jpg";
                    $res = $this->setImage($imgWidth,$imgHeight,$path,$filename,$thumbspath);
                    $path=$upload_path.$upload_data['file_name'];
                    $full_path=substr($path, 2);
                    
               
                    $mime_type = $file_info->buffer(file_get_contents($upload_data['full_path']));
                   
                        if(!in_array($mime_type,$mime_types_array))
                           {
                               //unlink($upload_data['full_path']);
                               //die('Invalid file type');
                           }
                           else
                           {
                            //   $src_file = $upload_data['full_path'];
                            //   $dest_file = $upload_path.$filename;
                            //     $img_quality = 70;
                            //      header('Content-Type: image/png');
                            //     $im = imagecreatefromstring(file_get_contents($src_file));
                            //     $im_w = imagesx($im);
                            //     $im_h = imagesy($im);
                            //     $tn = imagecreatetruecolor($im_w, $im_h);
                            //     imagecopyresampled ( $tn , $im, 0, 0, 0, 0, $im_w, $im_h, $im_w, $im_h );
                            //     imagejpeg($tn,$dest_file,$img_quality);
                            //     unlink($upload_data['full_path']);
                               
                           }
                              
                   
                    /** close **/
                    
            
            $params1=array(
            
                'file_name'=>$filename,
                'thumbnail_path'=>$res,
                'source_path'=>$full_path,
                'title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('title'))))),
                'url_link'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('page_url'))))),
                'flag'=>1,
                'target'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('target'))))),
                'widget_type_style'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widget_type_style'))))),
                'description'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('description'))))),
                'eventDate'=>date('Y-m-d', strtotime(htmlspecialchars(strip_tags($this->input->post('eventDate'))))),
                'eventTime'=>date('H:i:s', strtotime(htmlspecialchars(strip_tags($this->input->post('eventTime')))))
            );
           
            foreach($params1 as $param){			
				if (preg_match('/<[^<]+>/', $param)) {
					echo "Error: HTML or script tag detected in ".$param." field!" ;
					redirect ('creage-widget');
					exit;
				}
			}
			
            $this->session->unset_userdata('cropimgparams');
            
           
            
            $params2=array(
                'widget_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgetname'))))),
                'widget_type'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgettype'))))),
                'flag'=>1,
                //'ulbid'=>$this->session->userdata('ulbid'),
                'langId'=>htmlspecialchars(strip_tags($this->session->userdata('langId'))),
                'author' => htmlspecialchars(strip_tags($this->session->userdata('userid'))),
                'user_level'=>htmlspecialchars(strip_tags($this->session->userdata('user_type'))),
                'widget_type_style'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widget_type_style')))))
            );
            
			foreach($params2 as $param){			
				if (preg_match('/<[^<]+>/', $param)) {
					echo "Error: HTML or script tag detected in ".$param." field!" ;
					redirect ('creage-widget');
					exit;
				}
			}
            
             $ulbid = $this->session->userdata('ulbid');
             
             $ulb_check_list = $this->input->post('ulb_check_list');
             
             array_push($ulb_check_list,$ulbid);
             
            //  print_r($ulb_check_list);die;
            
           
            $result = $this->CreateWidgetModel->saveImageTextwidget($params1,$params2,$ulb_check_list);
           if(trim(htmlspecialchars(strip_tags($this->input->post('widgettype'))))==5)
            {
                foreach($result as $k => $v){
                    if($v['ulbid'] == ($this->session->userdata('ulbid'))){
                        $widgetIdAdmin = $v['widget_admin_code'];
                        $widget_name = $v['widget_name'];
                        $widgetId = $v['widget_id'];
                    }
                }
                $cropimgparams=array(
                    'widgetIdAdmin' => $widgetIdAdmin,
    	            'widget_name' => $widget_name,
    	            'widgetId'=>$widgetId,
    	            'id'=>0,
                    'widgetType'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgettype'))))),
                    'destinationWidth'=>trim(htmlspecialchars(strip_tags($this->input->post('image_crop_width')))),
                    'destinationHeight'=>trim(htmlspecialchars(strip_tags($this->input->post('image_crop_height')))),
                    'x'=>0,
                    'y'=>0,
                    'w'=>0,
                    'h'=>0,
                    'file_name'=>$upload_data['file_name'],
                    'resource'=>$full_path,
                    'destination_path'=>$res
                    
                );
                
               // print_r($cropimgparams);exit;
                
                $this->session->set_flashdata('message',"<div class='alert alert-success'>Widget saved successfully</div>");
                redirect('creage-widget');
                
                /*if($this->input->post('widget_type_style') ==2)
                {
                  $this->session->set_flashdata('message',"<div class='alert alert-success'>Widget saved successfully</div>");
                    redirect('creage-widget');
               
                }
                else
                {
                    $this->session->set_userdata('cropimgparams',$cropimgparams);
                
                   redirect('image-text-crop'); 
                }*/
            }
            else
            {
                if($result){
                    $this->session->set_flashdata('message',"<div class='alert alert-success'>Widget saved successfully</div>");
                }else{
                    $this->session->set_flashdata('message',"<div class='alert alert-danger'>Unable to save widget . try again</div>");
                }
                redirect('creage-widget');
            }
        }
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	 /** Start Photo Gallery Image Cropping code  **/
	 public function cropImagePhotoGallery()
	 {
	     
	      if($this->session->userdata('session_id')==session_id())
	    {
	     
	     $full_path = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('full_path')))));
	     $widget_name = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgetName')))));
	     $file_name = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('fileName')))));
	     $widgetId = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgetId')))));
	     $widgetIdAdmin = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgetIdAdmin')))));
	     $id = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('id')))));
	     $result  = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('thumbnail_path')))));
	     //echo $file_name;
	     //exit;
	     $params = array('id'=>$id,'Widget_id'=>$widgetId);
	     $res = $this->CreateWidgetModel->getGalleryWidgetIdDetails($params);
	     //print_r($res);exit;
	     if($res){
	         $x = $res[0]['imgx'];
	         $y = $res[0]['imgy'];
	         $w = $res[0]['width'];
	         $h = $res[0]['height'];
	     }else{
	         $x = 0;
	         $y = 0;
	         $w = 0;
	         $h = 0;
	     }
	     $cropimgparams=array(
	            'widgetIdAdmin' => $widgetIdAdmin,
	            'widget_name' => $widget_name,
	            'widgetType'=>4,
	            'widgetId'=>$widgetId,
	            'id'=>$id,
                'destinationWidth'=>'474',
                'destinationHeight'=>'250',
                'x'=>$x,
                'y'=>$y,
                'w'=>$w,
                'h'=>$h,
                'file_name'=>$file_name,
                'resource'=>$full_path,
                'destination_path'=>$result
            );
        $this->session->set_userdata('cropimgparams',$cropimgparams);
        redirect('image-text-crop');  
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 /** End Photo Gallery Image Cropping code  **/
	 
	 /**start Delete Photogallery image one by one function**/
	 public function deletePhotoGallerySingleImage(){
	      if($this->session->userdata('session_id')==session_id())
	    {
	     $params = array('id'=>trim(htmlspecialchars(strip_tags($this->input->get('pid')))));
	     //print_r($params);
	     $result = $this->CreateWidgetModel->deletePhotoGallerySingleImage($params);
	     echo $result;
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 /**end Delete Photogallery image one by one function**/
	 public function saveTextwidget()
	 {
	     
	      if($this->session->userdata('session_id')==session_id())
	    {
	     // echo "okkkkk"; exit;
	     if($this->input->post('save'))
	    {
	         $ulbid = $this->session->userdata('ulbid'); 
            $ulb_check_list = $this->input->post('ulb_check_list');
        //  print_r( $ulb_check_list);
        //     exit;
            array_push($ulb_check_list,$ulbid);
            $content = trim(($this->input->post('content')));
            $replaceUrl="../";
	        $content=str_replace($replaceUrl,'/',$content);
	        $replaceUrl="//";
	        $content=str_replace($replaceUrl,'/',$content);
	        $params=array(
	         'widgetname'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgetname'))))),
	         'widget_type'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgettype'))))),
	         'content'=>$content,
	         'flag'=>1,
	         'ulbid'=>strip_tags($this->session->userdata('ulbid')),
	         'langId'=>strip_tags($this->session->userdata('langId')),
	         'author'=>strip_tags($this->session->userdata('userid')),
	         'user_level'=>strip_tags($this->session->userdata('user_type')),
	         'ulb_check_list'=>$ulb_check_list
	         );
	       //  echo json_encode($params);
	       //  exit;
		   
		   	foreach($params as $param){			
				if (preg_match('/<[^<]+>/', $param)) {
					echo "Error: HTML or script tag detected in ".$param." field!" ;
					redirect ('creage-widget');
					exit;
				}
			}
			
	         $this->form_validation->set_rules('content','content','required');
	         
	         if($this->form_validation->run()===TRUE)
	         {
	         
	         
    	         $result=$this->CreateWidgetModel->saveTextwidget($params);
    	       //  echo $this->db->last_query();
    	       //  echo $result; exit;
    	         if($result){
    	             $this->session->set_flashdata('message',"<div class='alert alert-success'>Widget saved successfully</div>");
    	         }else{
    	             $this->session->set_flashdata('message',"<div class='alert alert-danger'>Unable to save widget . try again</div>");
    	         }
	         }else{
	             $this->session->set_flashdata('message',"<div class='alert alert-danger'>Content is required</div>");
	         }
	         redirect('creage-widget');
	    }
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 public function saveMenuwidget()
	 {
	     
	     if($this->session->userdata('session_id')==session_id())
	    { 
	     
	    $ulbid = $this->session->userdata('ulbid');
        $ulb_check_list = $this->security->xss_clean($this->input->get('ulb_check_list'));
        
    
       
        
        array_push($ulb_check_list,$ulbid);          
	      $params=array(
	         'widgetname'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('widgetname'))))),
	         'widget_type'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('widgettype'))))),
	         'menu_type_id'=>$this->security->xss_clean(trim($this->input->get('menu_type_id'))),
	         'flag'=>1,
	         'langId'=>strip_tags($this->session->userdata('langId')),
	         'author'=>strip_tags($this->session->userdata('userid')),
	         'user_level'=>strip_tags($this->session->userdata('user_type')),
	         'ulb_check_list'=>$ulb_check_list,
	         'menu_type_id'=>trim(htmlspecialchars(strip_tags($this->input->get('menu_type_id')))),
	         'menu_type_style'=>trim(htmlspecialchars(strip_tags($this->input->get('menu_type_style'))))
	         );
	       
		   	foreach($params as $param){			
				if (preg_match('/<[^<]+>/', $param)) {
					echo "Error: HTML or script tag detected in ".$param." field!" ;
					redirect ('creage-widget');
					exit;
				}
			}
			
	         $result=$this->CreateWidgetModel->saveMenuwidget($params);
	       
	         if($result)
	         {
	             $this->session->set_flashdata('message',"<div class='alert alert-success'>Widget saved successfully</div>");
	         }
	         else
	         {
	             $this->session->set_flashdata('message',"<div class='alert alert-danger'>Unable to save widget . try again</div>");
	         }
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 public function getWidgetData()
	 {
	     
	      if($this->session->userdata('session_id')==session_id())
	    {
	     $params=array(
	         'widgetname'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widgetname'))))),
	         'widget_type'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('widget_type')))))
	         );
	         
	         if(trim(strip_tags($this->input->post('widget_type'))) =='2')
	         {
	             echo $this->textwidgetlibrary->getForm();
	         }
	         if(trim(strip_tags($this->input->post('widget_type'))) =='1')
	         {
	             
	             echo $this->menuwidgetlibrary->getForm();
	         }
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 
	 
	 
	  public function getMenuNames()
        {
            
           if($this->session->userdata('session_id')==session_id())
	    {  
            
            
            $params = array('ulbid' => $this->session->userdata('ulbid'),'user_type'=>$this->session->userdata('user_type')=='A');
           
            
            $result = $this->menuwidgetlibrary->getMenuNames($params);
            return $result;
	    }
	    else
	    {
	        redirect('login');
	    }
        }
	 
	 
	public function widgetNameValidation()
	{
	    
	     if($this->session->userdata('session_id')==session_id())
	    {
	    
	    
	    $params = array('widget_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('widgetname'))))));
	    
	    $result = $this->CreateWidgetModel->widgetNameValidation($params);
	    //echo json_encode($params);
	    echo json_encode($result);
	    }
	    else
	    {
	        redirect('login');
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
	    
	    if($this->session->userdata('username'))
	    {
	    $submenudata=array();
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
	    $subMenus=$this->MenuModel->getSubMenu();
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    
	    $data['sub_menus']=$submenudata;
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $data['widgettypes']=$this->CreateWidgetModel->getwidgettypes();
	    //echo $this->db->last_query();exit;
	    $data['menunames']=$this->getMenuNames();
	    $data['tabtypes']=array('1'=>'Horizontal tabs','2'=>'Vertical tabs');
	    $params=array('ulbid'=>strip_tags($this->session->userdata('ulbid')),'langId'=>strip_tags($this->session->userdata('langId')),'is_custumlink'=>3);
	    $array = $this->CreateWidgetModel->getCategories($params);
	   
	    $result = [];
	    foreach ($array as $value) {
            $result = array_merge($result, $value);
        }
	   $data['categories'] = $result;
	   $params=array('ulbid'=>$this->session->userdata('ulbid'),'langId'=>$this->session->userdata('langId'),'is_custumlink'=>2);
	   $data['slider_posts'] = $this->CreateWidgetModel->getSliderPosts();
	   
	   $param = array();
	   $data['ulbList'] = $this->CreateWidgetModel->getUlbList();
	   //print_r($data['ulbList']);
	   
	   /*** all pages ***/
	    $params=array('ulbid'=>strip_tags($this->session->userdata('ulbid')),'langId'=>strip_tags($this->session->userdata('langId')),'is_custumlink'=>0);
	   $data['custom_menus']=$this->MenuModel->getCustomMenu($params);
	    
	   
	    if($this->input->post('next'))
	    {
	        
	        $data['widgetdet']=array(
	            
	            
	            'widget_type'=>trim(htmlspecialchars(strip_tags($this->input->post('widget_type')))),
	            'widgetname'=>trim(htmlspecialchars(strip_tags($this->input->post('widgetname')))),
	            'widget_type_style'=>trim(htmlspecialchars(strip_tags($this->input->post('widget_type_style'))))
	    );
	    }
	    
	    $params = array('ulbid'=>strip_tags($this->session->userdata('ulbid')),'status'=>1);
	    $data['create_media_data']=$this->ViewAlbumModel->createMediaData($params);
	    
	    
	    
	   
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('createwidget',$data);
		$this->load->view('divdata',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
