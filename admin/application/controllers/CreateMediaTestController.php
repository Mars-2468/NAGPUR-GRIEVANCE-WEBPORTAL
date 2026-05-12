<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class CreateMediaTestController extends MY_Controller {

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
	     $this->load->model('DashboardModel');
	     $this->load->model('ViewAlbumModel');
	     //$this->load->model('CreatePhotoGalleryModel');
	     $this->load->model('CreateMediaModel');
	 }
	 
	 
	public function setImage($imgWidth,$imgHeight,$imgPath,$filename,$thumbspath)
	{
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
      
	    $curyear=date("Y");
        $curmonth=date('m');
           
        $thumbspath = $thumbspath."thumbs/";
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
	 
	 
	 
	 
	public function imageUploadPost()
	{
	    
	  if($this->session->userdata('session_id')==session_id())
	    {  
	    
	    $curyear=date("Y");
        $curmonth=date('m');
                           
        $upload_path = '../assets/'.$this->session->userdata('ulbid').'/';
                            
        if (!file_exists($upload_path)) 
        {
            mkdir($upload_path, 0777, true);
            $upload_path.=$curyear."/";
            if (!file_exists($upload_path)) 
            {
                mkdir($upload_path, 0777, true);
                $upload_path.="mediafiles/";
                $thumbs=$upload_path;
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
                $upload_path.="mediafiles/";
                $thumbs=$upload_path;
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
                $upload_path.="mediafiles/";
                $thumbs=$upload_path;
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
        $config['upload_path']   = $upload_path; 

		$config['allowed_types'] = 'gif|jpg|png|jpeg'; 

		$config['max_size']      = '20480';
		


      	$this->load->library('upload', $config);
      	
      	if(!is_dir($config['upload_path']))
        {
            mkdir($config['upload_path'], 0755, TRUE);
        }
            
        $this->upload->do_upload('file');
	    $upload_data = $this->upload->data(); 
        
        $path=$this->setImage($thumnailWidth=178,$thumbnaidHeight=130,$imgPath=$upload_path.$upload_data['file_name'],$filename=$upload_data['file_name'],$thumbimgpath=$thumbs); 
        $file_name = substr($upload_path,2).$upload_data['file_name'];
        
        $params=array(
	    'ulbid'=>$this->session->userdata('ulbid'),
	    'folder_path'=>$file_name,
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
	    'thumbnail_path'=>$path
	    );
		    
		$this->CreateMediaModel->addImageInfo($params);
		$this->session->set_flashdata('message','Images uploaded successfully');
	    }
	    else
	    {
	        redirect('login');
	    }

	}

	public function getContent()
	{
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	    $params = array('slide_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('slide_id')))));
	    
	     $result=$this->CreateMediaModel->getContentimg($params);
	     echo json_encode($result);
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
	     $params=array('slide_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('slide_id')))));
	     
	     $result=$this->CreateMediaModel->deleteContentimg($params);
	     echo 1;
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 
	 
	 public function updateImgInfo()
	 {
	     
	    if($this->session->userdata('session_id')==session_id())
	    { 
	     
	     $params=array(
	         'slide_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('slide_id')))),
	         'heading'=>$this->security->xss_clean(trim(strip_tags($this->input->post('heading')))),
	         'description'=>$this->security->xss_clean(trim(strip_tags($this->input->post('description')))),
	         'title'=>$this->security->xss_clean(trim(strip_tags($this->input->post('title')))),
	         'alttext'=>$this->security->xss_clean(trim(strip_tags($this->input->post('alttext')))),
	         'status'=>$this->security->xss_clean(trim(strip_tags($this->input->post('status')))),
	         'updatedby'=>$this->session->userdata('username')
	         );
	         
	         $result=$this->CreateMediaModel->updateImgInfo($params);
	         echo json_encode($result);
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
	    
	    
	    $album_id=$this->uri->segment(2);
	    
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
	   // $params=array('album_id'=>$album_id);
	   // $data['album_det1']=$this->ViewAlbumModel->getAlbumdet1($params);
	   // $params=array('aim.album_id'=>$album_id);
	   // $data['album_det']=$this->ViewAlbumModel->getAlbumdet($params);
	    $params = array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['media_data']=$this->ViewAlbumModel->getMediaData($params);
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('mediatest',$data);
		//$this->load->view('createpage',$data);
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
	
	
	
	public function mediaOnStatus()
	{
	    
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	    
	    $params = array('slide_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('slide_id')))),'ulbid'=>$this->session->userdata('ulbid'),'status'=>$this->security->xss_clean(trim(strip_tags($this->input->post('status')))));
	    
        $result=$this->CreateMediaModel->getContentimg($params);
        echo json_encode($result);
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
