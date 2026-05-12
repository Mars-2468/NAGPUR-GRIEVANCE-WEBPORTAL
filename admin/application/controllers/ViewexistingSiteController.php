<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class ViewexistingSiteController extends CI_Controller {

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
	     $this->load->model('AddnewsiteModel');
	 }
	 
	 public function getUserData()
	 {
	     
	      if($this->session->userdata('session_id')==session_id())
	    {
	     $user_id=$this->security->xss_clean(trim($this->input->post('user_id')));
	     $data['allmainmenus']=$this->AddnewsiteModel->getallmainmenus();
	     $data['allsubmenus']=$this->AddnewsiteModel->getallsubmenus();
	    }
	    else
	    {
	        redirect('login');
	    }
	     
	 }
	 
	 public function editPagePermissions()
	 {
	     
	    if($this->session->userdata('session_id')==session_id())
	    {  
	     
	     
	     $check_list=$this->security->xss_clean(trim($this->input->post('check_list')));
	     $user_id=$this->security->xss_clean(trim($this->input->post('user_id')));
	     $result= $this->AddnewsiteModel->editPagePermissions($check_list,$user_id);
	     if($result==1)
	     {
	         $message="<div class='alert alert-success'>Permissions updated successfully</div>";
	     }
	     else
	     {
	         $message="<div class='alert alert-danger'> Error: please try after some time </div>";
	     }
	     echo $message;
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
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    
	    $data['sub_menus']=$submenudata;
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $data['existedSiteList']=$this->AddnewsiteModel->getexistedsitelist();
	    $data['siteAdminList']=$this->AddnewsiteModel->getexistedsiteAdminlist();
	    
	    
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('viewexistingsites',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	
	public function editSite()
	{
	      if($this->session->userdata('session_id')==session_id())
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
        	     
        	    $this->load->view('header',$data);
        		$this->load->view('editsite',$data);
        		$this->load->view('footer');
	    }
	    
	    else
	    {
	        redirect('login');
	    }
	     
	                                                                                        
	     
	     /*
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
	    $data['existedSiteList']=$this->AddnewsiteModel->getexistedsitelist();
	    $data['siteAdminList']=$this->AddnewsiteModel->getexistedsiteAdminlist();
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	  //$data['designationList']=$this->CreaUlbUserModel->getDesignations($params);
	   $data['destrictList']=$this->AddnewsiteModel->getDistricts();
	   if($this->input->post('save'))
	    {
	        
	        //$this->load->library('form_validation');
	        
	        $params=array(
	            'theme_id'=>'1',
	            'ulbname'=>$this->input->post('ulbname'),
	            'distid'=>$this->input->post('districtname'),
	            'ulbid'=>$this->input->post('systemid'),
	            'base_url'=>$this->input->post('base_url'),
	            'concerned_person'=>$this->input->post('admin_concerned_person'),
	            'designation'=>$this->input->post('admin_desigantion'),
	            'mobile'=>$this->input->post('mobile'),
	            'tech_concerned_person_name'=>$this->input->post('tech_concerned_person_name'),
	            'tech_concerned_person_designation'=>$this->input->post('tech_concerned_person_designation'),
	            'tech_concerned_person_mobile'=>$this->input->post('tech_concerned_person_mobile'),
	            'tech_concerned_person_email'=>$this->input->post('tech_concerned_person_email'),
	            'keywords'=>$this->input->post('keywords'),
	            'description'=>$this->input->post('meta_desc'),
	            'subject'=>$this->input->post('meta_subject')
	            );
	            $userdetails=array(
	                'user_id'=>$this->input->post('user_id'),
	                'password'=>$this->input->post('password'),
	                'author'=>$this->session->userdata('userid'),
	                'user_category'=>1,
	                'ulb_type'=>2
	                );
	            
	            $result=$this->AddnewsiteModel->configureSite($params,$userdetails);
	            if($result)
	            {
	                redirect('permission-page');
	            }
	        
	        
	    }
	    
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('editsite',$data);
		$this->load->view('footer');
	    
	    
	    }
	     
	   
	   
	    
	  
	   
	    
	    
	    */
	     
	     
	     
	     
	     
	     
	     
	 }
	 
	 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
