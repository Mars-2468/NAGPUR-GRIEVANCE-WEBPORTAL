<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class MenuController extends CI_Controller {
    

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
	     
	 }
	
	
	public function getMenus()
	{
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $result=$this->MenuModel->getMenus($params);
	   
	    
	    
	      $pages=array();
	    
	    foreach($result['sub_menus'] as $key=>$submenuarray)
	    {
	        
	       // $page['pagename']=$submenuarray['page_name'];
	       // $page['template']=$submenuarray['controller'];
	       // $page['controller']=$submenuarray['controller'];
	       // array_push($pages,$page);
	        
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['page_name']=$submenuarray['page_name'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['controller']=$submenuarray['controller'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
	        
	        
	    }
	    
	    
	    
	    foreach($result['sub_sub_menus'] as $key=>$submenuarray)
	    {
	       // $page['pagename']=$submenuarray['page_name'];
	       // $page['template']=$submenuarray['controller'];
	       // $page['controller']=$submenuarray['controller'];
	       // array_push($pages,$page);
	        
	        
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['page_name']=$submenuarray['page_name'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['controller']=$submenuarray['controller'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
	        
	    }
	    
	    foreach($result['main_menus'] as $key=>$mainmenuarray)
	    {
	        
	       // $page['pagename']=$mainmenuarray['page_name'];
	       // $page['template']=$mainmenuarray['controller'];
	       // $page['controller']=$mainmenuarray['controller'];
	       // array_push($pages,$page);
	        
	        
	        $data1[$mainmenuarray['menu_id']]['page_name']=$mainmenuarray['page_name'];
	        $data1[$mainmenuarray['menu_id']]['controller']=$mainmenuarray['controller'];
	        $data1[$mainmenuarray['menu_id']]['site_controller']=$mainmenuarray['site_controller'];
	        $data1[$mainmenuarray['menu_id']]['child']=array();
	        
	        
	        
	   }
	   
	   print_r($data1);
	   
	   $data['mainmenus']=$data1;
	   $data['submenus']=$data2;
	   $data['subsubmenus']=$data3;
	   
	    
	    //echo json_encode($pages);
	    
	    
	}
}
