<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class WidgetLayoutMapController extends MY_Controller {

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
		$this->load->model('AddMenuModel');
		$this->load->model('MapPageModel');
		$this->load->model('WidgetLayoutMapModel');
		$this->load->library('form_validation');	    
	 }
	 
	public function updatePageInfo()
	{
	    if($this->session->userdata('session_id')==session_id())
	    {
				if(!empty($this->input->post('page_id')) && !empty($this->input->post('page_name')) &&  !empty($this->input->post('page_title'))){
				 
					$params=array(
						'page_id'=>$this->security->xss_clean(trim($this->input->post('page_id'))),
						'page_name'=>$this->security->xss_clean(trim($this->input->post('page_name'))),
						'page_title'=>$this->security->xss_clean(trim($this->input->post('page_title'))),
						'is_targetblank'=>$this->security->xss_clean(trim($this->input->post('is_targetblank')))
					);
					 
					$result = $this->MapPageModel->updatePageInfo($params);
					
					if($result=1)
					{
					   $data['status_code']=1;
					   $data['message']='updated successfully';
					}else{
					   $data['status_code']=0;
					   $data['message']='Unable to updated , Try again';
					   
					}
			 
					echo json_encode($data);
					
				}else{                	        
					$errors=array('page_id'=>'required','page_name'=>'required','page_title'=>'required');
					echo json_encode($errors);
				}
    	     
		}else{
			redirect('login');    	     
		}
	}
	 
	 
	 public function getPageInfo()
	 {
    	if($this->session->userdata('session_id')==session_id())
	    {
			if($this->input->post('page_id'))
			{
				 $page_id=$this->security->xss_clean(trim($this->input->post('page_id')));
				 $params=array('page_id'=>$page_id);
				 $result = $this->MapPageModel->getPageInfo($params);
				 echo json_encode($result[0]);
				//print_r($result[0]);
			}else{
				redirect('dashboard');			 
			}
    	     
		}else{
			redirect('login');		 
	   }
	 }
	 
	 public function createCustomLink()
	 {
	    if($this->session->userdata('session_id')==session_id())
	    {  
	     
			$url =$this->security->xss_clean(trim($this->input->post('urlname')));
			$linkText=$this->security->xss_clean(trim($this->input->post('linktext')));
			$menu_type_id=$this->security->xss_clean(trim($this->input->post('menu_type')));
			$params=array(
				'page_title'=>$linkText,
				'page_name'=>$linkText,
				'controller'=>$url,
				'is_custumlink'=>1,
				'ulbid'=>$this->session->userdata('ulbid'),
				'langId'=>$this->session->userdata('langId'),
				'content'=>$linkText,
				'site_controller'=>$url,
				'pageheading'=>$linkText	         
	         );
	     
			$result=$this->MapPageModel->createCustomLink($params,$menu_type_id);
			
			//echo $result;
			if($result=='1')
			{
				$this->session->set_flashdata('menu_type_id',$menu_type_id);
				echo $result;
			}else{				
				$this->session->set_flashdata('message','Error: Custom link not added , please try again');
				echo $result;
			}
			
	    }else{
	        redirect('login');
	    }
	     
	 }
	 
	public function updatePages(){
	     
	     if($this->session->userdata('session_id')==session_id())
	    { 
	     
	    $jsonobject=json_decode($this->security->xss_clean(trim($this->input->get('aaa'))),true);
	    $menu_type=$this->security->xss_clean(trim($this->input->get('menu_type')));
	    $ulbid=$this->security->xss_clean(trim($this->input->get('ulbid')));
	    
	    $result=$this->WidgetLayoutMapModel->updatePages($jsonobject,$menu_type,$ulbid);
	    echo $result;
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	 
	
	 
	public function index(){
	   
		if (!in_array($this->session->userdata('userid'),['superadmin'])) {
			$this->session->set_flashdata('error_message','Sorry you dont have permissions');
			//echo "Error: Sorry you don't have permissions!" ;
			redirect ('dashboard');
			exit;
		}

	   
	   //echo "<pre>";print_r('test');echo "</pre>";die();
	   
	    if($this->session->userdata('session_id')==session_id())
	    {
			// echo "<pre>";print_r('test');echo "</pre>";die();
			
			$submenudata=array();
			
			$data['main_menu_list']=$this->MenuModel->getMainMenu();
			$subMenus=$this->MenuModel->getSubMenu();
			$params=array('ulbid'=>$this->session->userdata('ulbid'));
			//$data['aboutData']=$this->AboutModel->getaboutData($params);		  
			
			foreach($subMenus as $key=>$val)
			{
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
				$submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
			}
			
			$data['sub_menus']=$submenudata;
			
			$params=array('ulbid'=>$this->session->userdata('ulbid'));
			$customMenus=$this->MenuModel->getCustomMenu($params);
			
			if(count($customMenus) > 0)
			{
				foreach($customMenus as $key=>$val)
				{
					$customemenudata[$val['page_id']]['page_name']=$val['page_name'];
					
				}
			
		   
				$data['custom_menus']=$customemenudata;
			}
			
			
			$params=array('theme_layout_id'=>1,'ulbid'=>$this->session->userdata('ulbid'));
			
			$data['menu_types']=$this->WidgetLayoutMapModel->getPageLayouts($params);
			
			$ulbid=$this->session->userdata('ulbid');
			
			if($this->session->user_type=='A')
			{
				$ulbid=$this->security->xss_clean(trim($this->input->post('ulbid')));
			}
			
			//echo $ulbid;
			
			$params=array(
	        'ulbid'=>$ulbid,
	        'langId'=>$this->session->userdata('langId'),
	        'flag'=>1,
	       // 'user_type'=>$this->session->userdata('user_type')
	        ); 
			
	        $data['publishedPages']=$this->WidgetLayoutMapModel->publishedPages($params);
			//echo $this->db->last_query(); exit;
	        $data['ulblist']=$this->WidgetLayoutMapModel->ulbList();
	    
			$params=array('ulbid'=>$this->session->userdata('ulbid'));
			
			if($this->input->post('select')){	           
				$selectedMenu=$this->security->xss_clean(trim($this->input->post('menuType')));
			}else if($this->session->flashdata('menu_type_id')){
				$selectedMenu=$this->session->flashdata('menu_type_id');
			}else{
				$selectedMenu=1;
			}
			
			
			
			$ulbid=$this->session->userdata('ulbid');
			
			if($this->session->user_type=='A')
			{
				$ulbid=$this->security->xss_clean(trim($this->input->post('ulbid')));
			}
	  
			$params=array(
				'c.ulbid'=>$ulbid,
				'page_layout_id'=>$selectedMenu,
				'sm.flag'=>1,
				'c.langId'=>$this->session->userdata('langId'),
				//'user_type'=>$this->session->userdata('user_type')
			); 
			
			$data['ulbidselected']=$ulbid;
	       
			$data['menu_type_selected']=$selectedMenu;
	      
			$data['dragdropMainmenudata']=$this->WidgetLayoutMapModel->getDragDropMainMenuData($params);
			  
			// Declaration of arrays
			$data['parentMenus']=array();
			 
			foreach($data['dragdropMainmenudata']->result() as $key=>$val){
				$parent_menus[$val->sno][$val->widget_id]['page_name']=$val->menu_name;
			}
			
	    // echo "<pre>";print_r($data['dragdropMainmenudata']->result());echo "</pre>";die();
		 
			array_push($data['parentMenus'],$parent_menus);
	    
			$data['languageList']=$this->MenuModel->getLanguages($params);
			$this->load->view('header',$data);
			$this->load->view('widgetlayoutmap',$data);
			$this->load->view('footer');
			
	    }else{
	        redirect('login');
	    }
	}
	
	public function ajax_pages_search()
	{
	   
	    if($this->session->userdata('session_id')==session_id())
	    { 
	    
	        $keyword=$this->security->xss_clean(trim($_POST['keyword_widget']));
	      
	          $ulbid=$this->security->xss_clean(trim($_POST['ulbid']));
	            
	            
	            if(!empty($keyword) && !empty($ulbid))
	            {
	        //echo $ulbid=$this->session->userdata('ulbid');
	        $flag='0';
	        $langId=$this->session->userdata('langId');
	        $searching_widgets = $this->WidgetLayoutMapModel->ajax_page_search($ulbid,$flag,$langId,$keyword);
	        
	         foreach($searching_widgets->result_array() as $key=>$value) {
	        
	        $output .="<label class='ckbox' style='width:100%;'>";
	        $output .="<input type='checkbox' id='addInputSlug" . $value['widget_id'] . "' value='".$value['widget_id']."' class='chk'><span>".$value['widget_name']."</span><br>";
	        $output .="<input type='hidden' id='addInputName" . $value['widget_id'] . "' value='".$value['widget_name']."'>";
	      
	      $output .="</label>";
	      
	    }
	     echo $output;
	     
	     
	     
	    }
	    else
	    {
	        die('Invalid Details');
	    }
	    }
	    
  
	    else
	    {
	        redirect('login');
	    }
	    
	}
}
