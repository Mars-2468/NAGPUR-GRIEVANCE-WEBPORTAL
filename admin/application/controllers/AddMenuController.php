<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class AddMenuController extends CI_Controller {

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
	    $this->load->model('CreatePhotoGalleryModel');
	    $this->load->model('CreateAlbumModel');
	    $this->load->model('AddMenuModel');
	    $this->load->library('form_validation');
	 }
	 
	 
	public function changeLanguage()
	{

	  if($this->session->userdata('session_id')==session_id())
	    {  
	    
	    $langId=$this->input->get('langId');
	    $this->session->set_userdata('langId',$langId);
	    $params=array('languageId'=>$langId);
	    $result=$this->AddMenuModel->changeLanguage($params);
	    $this->session->set_userdata('btncolor',$langId);
	    
	    echo $result[0]['language_desc'];
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
	                 'slide_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('slide'))))[$i],
	                 'slide_desc'=>$this->security->xss_clean(trim(strip_tags($this->input->post('description'))))[$i],
	                 'title'=>$this->security->xss_clean(trim(strip_tags($this->input->post('title'))))[$i]
	                 );
	                 $this->CreatePhotoGalleryModel->updateContent($params);
	                 
	                 
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
	     
	     $params=array('photo_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('slide_id')))));
	     $result=$this->CreatePhotoGalleryModel->deleteContent($params);
	     echo $result;
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 public function deleteMenu()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    {
	     
	     $params=array('menu_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('menu_id')))));
	     $result=$this->CreatePhotoGalleryModel->deleteMenu($params);
	     echo $result;
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 
	 
	
	 
	public function index()
	{
	    //$this->session->unset_userdata('albumid');
	    
	   if($this->session->userdata('session_id')==session_id())
	    {
	        
	        
	        if($this->input->post('save'))
	        {
	            
	             $this->form_validation->set_rules('menu_type_id','Menu type','required');
        	     $this->form_validation->set_rules('menu_desc','Menu Description','required|maxlenght[20]');
        	     if($this->form_validation->run()==FALSE)
        	     {
        	        
        	         $params=array(
        	             'ulbid'=>$this->session->userdata('ulbid'),
        	             'menu_type_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('menu_type_id')))),
        	             'menu_name'=>$this->security->xss_clean(trim(strip_tags($this->input->post('menu_desc')))),
        	             'author'=>$this->session->userdata('username'),
        	             'flag'=>1
        	             
        	             );
        	             
        	             $result=$this->AddMenuModel->menuInsert($params);
        	             if($result)
        	             {
        	                 $this->session->set_flashdata('message','Menu added successfuly');
        	                 //redirect('add-menu');
        	             }
        	             else
        	             {
        	                 $this->session->set_flashdata('message','Unable to add Pls try again');
        	             }
        	             
        	     }
	        }
	        
	        
	        
	        
	        
	        
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
	    $data['menudata']=$this->AddMenuModel->getMenuData();
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['sitemenudata']=$this->AddMenuModel->getSiteMenuData($params);
	    
	   
	    $this->load->view('header',$data);
		$this->load->view('addmenu',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	public function editsitemenu(){
	    
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
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $data['menudata']=$this->AddMenuModel->getMenuData();
	    //$params=array('ulbid'=>$this->session->userdata('ulbid'));
	    
	    if($this->input->post('update'))
	    {
	        $id=$this->security->xss_clean(trim($this->input->post('menuid')));
	        $data['sitemenueditdata']=$this->AddMenuModel->geteditSiteMenuData($id);
	    }
	    
	    
	    
	   
	    $this->load->view('header',$data);
		$this->load->view('editmenu',$data);
		$this->load->view('footer');
		
	    }
	    
	    else {
	        
	         redirect('login');
	    }
	    
	}
	
	public function update_sitemenu($id)
	{
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	    
	    
	     if($this->input->post('save'))
	     
	        {
	            
	             $this->form_validation->set_rules('menu_type_id','Menu type','required');
        	     $this->form_validation->set_rules('menu_desc','Menu Description','required|maxlenght[20]');
        	     if($this->form_validation->run()==FALSE)
        	     {
        	        
        	         $params=array(
        	             //'ulbid'=>$this->session->userdata('ulbid'),
        	             'menu_type_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('menu_type_id')))),
        	             'menu_name'=>$this->security->xss_clean(trim(strip_tags($this->input->post('menu_desc'))))
        	             //'author'=>$this->session->userdata('username'),
        	             //'flag'=>1
        	             
        	             );
        	             
        	             $result=$this->AddMenuModel->menuupdate($id,$params);
        	             if($result)
        	             {
        	                 $this->session->set_flashdata('message','Menu updated successfuly');
        	                 redirect('add-menu');
        	             }
        	             else
        	             {
        	                 $this->session->set_flashdata('message','Unable to add Pls try again');
        	             }
        	             
        	     }
	        }
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
