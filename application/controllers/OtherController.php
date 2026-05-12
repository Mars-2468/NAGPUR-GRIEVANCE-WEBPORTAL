<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class OtherController extends CI_Controller {
    

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
	     $this->load->library('MenuModel');
	     $this->load->library('Mylibrary');
	     $this->load->library('Themeonelayoutwidgets');
	     $this->Mylibrary=new Mylibrary();
	     $this->Themeonelayoutwidgets=new Themeonelayoutwidgets();
	     
	 }
	 
	 
	 
	 public function getSubcast()
	 {
	     $cast_id = $this->input->get('cast_id');
	     $params = array('caste_id'=>$cast_id);
	     $result=$this->MenuModel->getSubcast($params);
	     
	     $dropdown = "<option value=''>-- select --</option>";
	     foreach($result as $key=>$val)
	     {
	         $dropdown.= "<option value='".$val['subcaste_id']."'>".$val['subcaste_desc']."</option>";
	     }
	     
	     echo $dropdown;
	 }
	 
	  
	 public function getVillages()
	 {
	     $mandal_id = $this->input->get('mandal_id');
	     $params = array('mandal_id'=>$mandal_id);
	     $result=$this->MenuModel->getVillages($params);
	     
	     $dropdown = "<option value=''>-- select --</option>";
	     foreach($result as $key=>$val)
	     {
	         $dropdown.= "<option value='".$val['village_id']."'>".$val['village_desc']."</option>";
	     }
	     
	     echo $dropdown;
	     
	 }
	
	 
	
	 
	/**** Library functions ****/
	
	public function widget_desc($widget_id)
	{
	    $params=array('widget_id'=>$widget_id);
        $result=$this->MenuModel->widget_desc($params);
	    return $result;
	}
	
    
     
    
    
	


}
