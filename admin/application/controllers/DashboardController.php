<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class DashboardController extends MY_Controller {

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
		 $this->load->library('session');
	 }
	public function index()
	{
		
		//echo "<pre>";print_r($this->session->userdata());echo "</pre>";die();
		
		if (!$this->session->userdata('logged_in')) {
            redirect('/?message=session_expired');
        }
		
		// echo phpinfo();
		   // print_r($_SESSION); exit;
	    //print_r($this->session->userdata());exit();
	     if($this->session->userdata())
	    {

 //echo "dashboard";
 //exit;
	        
	      
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
	  // echo  $_SESSION['ulbname']=strtolower($this->session->userdata('username'));
	  //$_SESSION['ulbname']='001';
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    //echo '<pre>';print_r($data['languageList']);exit;
	    $ulb_list=$this->DashboardModel->ulb_list();
	   
	    foreach($ulb_list->result() as $key=>$val)
	    {
	        $this->DashboardModel->add_user($val);
	    }
	    
	    
	   // $result=$this->DashboardModel->conf();
	   // foreach($result->result() as $key=>$val)
	   // {
	   //     $arr=explode("/",$val->site_controller);
	   //     $params=array(
	            
	   //         'site_controller'=>$arr[1]."/".$arr[0],
	   //         'page_id'=>$val->page_id
	   //         );
	   //         $result=$this->DashboardModel->updatepagename($params);
	            
	   // }
	     
	   $result=$this->DashboardModel->copysite();
	   
	    foreach($result->result() as $key=>$val)
	    {
	        
	        /*$params=array(
	            'ulbid'=>'052',
	            'page_layout_id'=>$val->page_layout_id,
	            'theme_layout_id'=>$val->theme_layout_id,
	            'page_layout_desc'=>$val->page_layout_desc,
	            'langId'=>$val->langId,
	            'author'=>'Kairmnagar',
	            'flag'=>$val->flag,
	            'source'=>$val->source,
	            
	            
	            );
	            $result=$this->DashboardModel->addsite($params);*/
	            
	    }
		
	    
	    $this->load->view('header',$data);
		
		$this->load->view('dashboard');
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect();
	    }
	}
}
