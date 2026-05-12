<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeGalleryController extends CI_Controller {

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
	    $this->load->model('HomeGalleryModel');
	    $this->load->library('image_lib');
	 }
	 
	 public function updateContent()
	 {
	     
	    if($this->session->userdata('session_id')==session_id())
	    { 
	     
	     if(!empty($this->security->xss_clean(trim($this->input->post('slide')))))
	     {
	         for($i=0; $i<count($this->security->xss_clean(trim($this->input->post('slide')))); $i++)
	         {
	             $params=array(
	                 'slide_id'=>$this->security->xss_clean(trim($this->input->post('slide')))[$i],
	                 'slide_desc'=>$this->security->xss_clean(trim($this->input->post('description')))[$i],
	                 'title'=>$this->security->xss_clean(trim($this->input->post('title')))[$i]
	                 );
	                 $this->HomeGalleryModel->updateContent($params);
	                 
	                 
	         }
	         $this->session->set_flashdata('message','Content updated successfully');
	         redirect('home-gallery');
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
	     
	     $params=array('slide_id'=>$this->security->xss_clean(trim($this->input->post('slide_id'))));
	     $result=$this->HomeGalleryModel->deleteContent($params);
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

	    $config['upload_path']   = 'assets/gallery'; 
        $config['allowed_types'] = 'gif|jpg|png|jpeg'; 
        $config['max_size']      = 8192;
		$config['remove_spaces'] = true;
		$this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('file');
        $upload_data=$this->upload->data();
        $sourcePath="assets/gallery/".$upload_data['file_name'];
        $file_name=$upload_data['file_name'];
        
        
        
        
        $config['image_library'] = 'gd2';
        $config['source_image'] = $sourcePath;
        $config['quality'] = '100%';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = true;
        $config['thumb_marker'] = '';
        $config['width'] = 900;
        $config['height'] = 800;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
		
		
		
	
        
       
		
		
		$params=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'slide_desc'=>'',
		    'image_path'=>$file_name,
		    'full_path'=>$sourcePath
		    );
        
		
		$this->HomeGalleryModel->addSlider($params);
		
		
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
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    
	    
	    $data['sliderList']=$this->HomeGalleryModel->getSliderList($params);
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    
	    $this->load->view('header',$data);
		$this->load->view('homegallery',$data['sliderList']);
		$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
