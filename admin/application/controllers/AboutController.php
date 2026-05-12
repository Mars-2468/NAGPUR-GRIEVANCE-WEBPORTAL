<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AboutController extends CI_Controller {

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
	    $this->load->model('AboutModel');
	 }
	 
	 
	 
	public function index()
	{
	  
	  
	  
	    
	    if($this->input->post('save'))
	    {
	        $this->input->post('content');
	        $params=array(
	            'ulbid'=>$this->session->userdata('ulbid'),
	            'content'=>$this->input->post('content')
	            
	            );
	        $this->AboutModel->aboutDataInsert($params);
	        
	    }
	    
	    
	     if($this->session->userdata('session_id')==session_id())
	    {
	    $submenudata=array();
	    
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
	    $subMenus=$this->MenuModel->getSubMenu();
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['aboutData']=$aboutData=$this->AboutModel->getaboutData($params);
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	   
	    
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    $data['sub_menus']=$submenudata;
	    $customMenus=$this->MenuModel->getCustomMenu();
	   
	    $this->load->view('header',$data);
		$this->load->view('about',$data['aboutData']);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
