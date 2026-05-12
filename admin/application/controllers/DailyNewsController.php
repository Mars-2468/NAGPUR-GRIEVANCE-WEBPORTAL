<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class DailyNewsController extends CI_Controller {

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
	     $this->load->model('CheckPasswordModel');
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
	    $ulb_list=$this->DashboardModel->ulb_list();
	    
	    foreach($ulb_list->result() as $key=>$val)
	    {
	        $this->DashboardModel->add_user($val);
	    }
	    
	    if($this->input->post('submit'))
        {
            /*$params = array(
                
                'NewsType'=>htmlspecialchars(strip_tags()),
                //htmlspecialchars(
                
                );*/
        }
	   
	    $this->load->view('header',$data);
		$this->load->view('daily-news',$result);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
}
