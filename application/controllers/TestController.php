<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class TestController extends CI_Controller {
    

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
	     $this->load->library('Mylibrary');
	     $this->load->library('Themeonelayoutwidgets');
	     $this->Mylibrary=new Mylibrary();
	     $this->Themeonelayoutwidgets=new Themeonelayoutwidgets();
	     
	 }
	 
	  public function angularhomepagecontent()
	 {
	     $postdata = file_get_contents("php://input");
	     $request = json_decode($postdata);
	     
	   $params=array('ulbid'=>$request->ulbid,'langId'=>$this->session->userdata('lang_Id'),'is_homepage_content'=>1);
	   
	   $result=$this->MenuModel->angularhomepagecontent($params);
	   echo json_encode($result);
	 }
	 
	 public function angularSliderData()
	 {
	     $postdata = file_get_contents("php://input");
	     $request = json_decode($postdata);
	     
	   $params=array('ulbid'=>$request->ulbid,'langId'=>$this->session->userdata('lang_Id'));
	   
	  
	   $result=$this->MenuModel->anggetsliderdata($params);
	   echo json_encode($result);
	 }
	 public function changLanguage()
	 {
	     
	     if($this->session->userdata('lang_Id')=='1')
	     {
	         $this->session->unset_userdata('lang_Id');
	         $this->session->unset_userdata('langtext');
	         $this->session->set_userdata('lang_Id','2');
	         
	         
	     }
	     else
	     {
	         $this->session->unset_userdata('lang_Id');
	         $this->session->unset_userdata('langtext');
	         $this->session->set_userdata('lang_Id','1');
	         
	     }
	     
	    
	     
	      
	     
	  
	 }
	 
	/**** Library functions ****/
	
	public function widget_desc($widget_id)
	{
	    $params=array('widget_id'=>$widget_id);
        $result=$this->MenuModel->widget_desc($params);
	    return $result;
	}
	
    public function getMenuTypeId($params)
    {
       $params=array('widget_id'=>$params);
        $result=$this->MenuModel->getMenuTypeId($params);
	    return $result;
    }
     public function footerWebsitePolicies($ulbid)
    {
        $result=$this->Themeonelayoutwidgets->footerWebsitePoliciess($ulbid);
        return $result;
    }
    
    public function getGovtLinkstData($gove_widgets)
    {
        $result=$this->Themeonelayoutwidgets->getGovtLinkstData($gove_widgets);
        return $result;
    }
	
	public function getWidgetData($widget_id)
	{
	    
	    $params=array('widget_id'=>$widget_id);
	    $result=$this->MenuModel->getWidgetData($params);
	    $widget_type=$result[0]['widget_type'];
	    $params=array('widget_id'=>$widget_id,'widget_type'=>$widget_type,'ulbid'=>$this->session->userdata('ulb_id'),'langId'=>$this->session->userdata('lang_Id'));
	   
	    $result=$this->Themeonelayoutwidgets->getIndwidgetdata($params);
	    
	    return $result;
	    
	    
	    
	}
	
	/***** close ****/
	public function index()
	{
	  
	    $ulbid = $this->uri->segment('1');
	   if(!$this->session->userdata('lang_Id'))
	    {
	        
	        $this->session->set_userdata('lang_Id',1);
	        $this->session->set_userdata('langtext',' తెలుగు');
	        
	    }
	    
	   
	    
	    $this->session->set_userdata('ulb_id',$ulbid);
	    $params=array('ulbid'=>$ulbid);
	    $data['ulbinfo']=$this->MenuModel->getULBInfo($params);
	    
	   // $data['ulbinfo']=$this->CommonData->getULBInfo($params);
	    $data['description']=$data['ulbinfo'][0]->description;
	    $data['keywords']=$data['ulbinfo'][0]->keywords;
	    $data['subject']=$data['ulbinfo'][0]->subject;
	     $data['title']=$data['ulbinfo'][0]->title;
	    $data['ulbnametelutu']=$data['ulbinfo'][0]->ulbtelugu." ".$data['ulbinfo'][0]->ulb_type_desctelugu;
	    $data['ulbnameenglish']=$data['ulbinfo'][0]->ulbname." ".$data['ulbinfo'][0]->ulb_type_desc;
	    
	    $data['generalsettings']=$this->MenuModel->getULBgeneralsettings($params);
	    
	    
	    $data['logo']=$data['generalsettings'][0]['file_path'];
	    $data['logo_alt']=$data['generalsettings'][0]['alt'];
	    $data['logo_title']=$data['generalsettings'][0]['title'];
	    if($data['generalsettings'][0]['file_path'] ==='')
	    {
	        $data['feviicon']="assets/cdma/img/logo1.png";
	    }
	    else
	    {
	        $data['generalsettings'][0]['file_path'];
	        $data['feviicon']=$data['generalsettings'][0]['file_path'];
	    }
	    
	    
	    
	    $data['ulbid']=$ulbid;
	    $data['ulbid']['ulbid']=$ulbid;
	    
	   
	    /** getting menus **/
	    
	    /** top menus **/
	    
	    $params=array('ulbid'=>$ulbid,'langId'=>$this->session->userdata('lang_Id'),'menu_type_id'=>1);
	    $result=$this->Mylibrary->getMenus($params);
	    $data['mainmenus']=$result['mainmenu'][0];
	    $data['submenus']=$result['submenu'][0];
	    $data['subsubmenus']=$result['chilemenu'][0];
	    
	    /*** left menus **/
	    
	    $params=array('ulbid'=>$ulbid,'langId'=>$this->session->userdata('lang_Id'),'menu_type_id'=>2);
	    $result=$this->Mylibrary->getMenus($params);
	    $data['leftmainmenus']['leftmainmenus']=$result['mainmenu'][0];
	    $data['leftsubmenus']['leftsubmenus']=$result['submenu'][0];
	    $data['leftsubsubmenus']['leftsubsubmenus']=$result['chilemenu'][0];
	    
	    
	    //print_r($data['leftsubmenus']['leftsubmenus']);
	    
	    
	    
	    
	    /** footer menus **/
	    
	    $params=array('ulbid'=>$ulbid,'langId'=>$this->session->userdata('lang_Id'),'menu_type_id'=>3);
	    $result=$this->Mylibrary->getMenus($params);
	    $data['footermainmenus']['footermainmenus']=$result['mainmenu'][0];
	    $data['footerleftsubmenus']['footerleftsubmenus']=$result['submenu'][0];
	    $data['footerleftsubsubmenus']['footerleftsubsubmenus']=$result['chilemenu'][0];
	    
	    
	 
	   
	   
	  
	   
	   
	   /** end **/
	   // news information
	   
	   
	   $params=array('ulbid'=>$ulbid,'langId'=>$this->session->userdata('lang_Id'));
	   $data['headerNews']=$this->MenuModel->getHeaderNews($params);
	   //print_r($params);
	   $data['sliderdata']['sliderdata']=$this->MenuModel->getsliderdata($params);
	   $params=array('ulbid'=>$ulbid);
	   $themefolder=$this->MenuModel->getthemefolder($params); // selecting ulb mapped theme
	   $theme=$themefolder[0]['folder'];
	   $data['theme']=$themefolder[0]['folder'];
	   $themeLayoutId=$themefolder[0]['theme_id'];
	   
	   
	   $params=array('ulbid'=>$ulbid,'theme_layout_id'=>$themeLayoutId,'flag'=>1);
	   $layoutwidgets=$this->MenuModel->getLayout($params);
	   $layouts=array();
	   foreach($layoutwidgets->result() as $key=>$val)
	   {
	       $layouts[$val->page_layout_id]=$val->page_layout_desc;
	   }
	   
	   //print_r($layouts);
	   
	   $data['layoutwidgets']=$this->Themeonelayoutwidgets->getLayoutwidgets($layouts,$ulbid,$langId=$this->session->userdata('lang_Id'));
	  // print_r($data['layoutwidgets']);
	   
	   
	   
	   $params=array('ulbid'=>$this->session->userdata('ulb_id'),'theme_layout_id'=>$themeLayoutId,'flag'=>1);
	   $data['customepagelayouts']=$this->MenuModel->getLayout($params);
	   
	   
	   
	   
	   
	   
	   
	   

	   
	  
	   
	   
	   
	    $this->load->view($theme.'/header',$data);
 		//$this->load->view('theme1/mainmenu',$data);
 		$this->load->view($theme.'/hometest',$data);
 		//$this->load->view('theme1/footer');
		$this->load->view($theme.'/footerjs',$data['theme']);
	}
}
