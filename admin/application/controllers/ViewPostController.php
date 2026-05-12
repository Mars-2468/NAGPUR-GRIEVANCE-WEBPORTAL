<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
class ViewPostController extends MY_Controller {

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
	    
	 }
	 
	 public function deleteContent()
	 {
		 $this->load->database();
		// var_dump($this->input->post('page_id'));die();
	     if($this->session->userdata('session_id')==session_id())
	    {
	     
	       $page_id=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('page_id')))));
	   
	     $params=array('page_id'=>$page_id);
	     echo $result=$this->ViewPagesModel->deleteContent($params);
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
	     
	     $page_id=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('page_id')))));
	     $status=$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('status')))));
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
	    //print_r($this->session->userdata()); exit;
	  
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
	    
	    if($this->session->userdata('user_type') === 'D'){
	        $params=array('ulbid'=>$this->session->userdata('ulbid'),'is_custumlink'=>2,'author'=>$this->session->userdata('userid'));
	        
	    }else{
	    $params=array('ulbid'=>$this->session->userdata('ulbid'),'langId'=>$this->session->userdata('langId'),'is_custumlink'=>2,'author'=>$this->session->userdata('userid'));
	    }
	    
	    $customMenus=$this->MenuModel->getPosts($params);
		
		 //echo "<pre>";print_r($customMenus); echo "</pre>";die();
		
	    $ulb=$this->session->userdata('ulbid');
	    $ulb_baseurl=$this->ViewPagesModel->getulb_baseurl($ulb);
	    
	 foreach($ulb_baseurl->result() as $key=>$val2){
	     
	     $data['ulb_base_url'][$val2->ulbid]['base_url']=$val2->base_url;
	    
	 }
	    
	    if(count($customMenus) > 0)
	    {
    	    foreach($customMenus as $key=>$val)
    	    {
    	        $customemenudata[$val['page_id']]['page_name']=$val['page_name'];
    	        $customemenudata[$val['page_id']]['controller']=$val['controller'];
    	        $customemenudata[$val['page_id']]['content']=$val['content'];
    	        $customemenudata[$val['page_id']]['ts']=$val['ts'];
    	        $customemenudata[$val['page_id']]['is_draft']=$val['is_draft'];
    	        $customemenudata[$val['page_id']]['author']=$val['author'];
    	        $customemenudata[$val['page_id']]['permalink']=$val['permalink'];
    	        $customemenudata[$val['page_id']]['site_controller']=$val['site_controller'];
    	        $customemenudata[$val['page_id']]['ulbid']=$val['ulbid'];
    	    }
	    
	   
	        $data['custom_menus']=$customemenudata;
	    }
	    
	    
	    $data['count_isdraft']=$this->MenuModel->countofdraft_post($params);
	    $data['count_ispublish']=$this->MenuModel->countofpublish_post($params);
	    
	      $data['pageids']=$this->ViewPagesModel->getPageIds();
	   // echo "<pre>";print_r($data['pageids']); echo "</pre>";die();
	    
	    
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $this->load->view('header',$data);
		$this->load->view('viewposts',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('/');
	    }
	}
}
