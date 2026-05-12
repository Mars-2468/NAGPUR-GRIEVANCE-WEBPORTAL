<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class AddNewsController extends CI_Controller {

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
	       $this->load->model('MapNewsModel');
	       
	       
	    
	 }
	 
	
	 public function updatePageInfo()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    {
                	        if(!empty(strip_tags($this->input->post('page_id'))) && !empty(strip_tags($this->input->post('page_name'))) &&  !empty(strip_tags($this->input->post('page_title'))))
                	        {
                    	     
                    	     $params=array(
                    	         'page_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('page_id')))),
                    	         'page_name'=>$this->security->xss_clean(trim(strip_tags($this->input->post('page_name')))),
                    	         'page_title'=>$this->security->xss_clean(trim(strip_tags($this->input->post('page_title')))),
                    	         'is_targetblank'=>$this->security->xss_clean(trim(strip_tags($this->input->post('is_targetblank'))))
                    	         );
                    	         
                    	       $result = $this->MapNewsModel->updatePageInfo($params);
                    	       if($result=1)
                    	       {
                    	           $data['status_code']=1;
                    	           $data['message']='updated successfully';
                    	       }
                    	       else
                    	       {
                    	           $data['status_code']=0;
                    	           $data['message']='Unable to updated , Try again';
                    	           
                    	       }
                    	     
                    	     echo json_encode($data);
                	            
                	        }
                	       else
                	       {
                	        
                	        $errors=array('page_id'=>'required','page_name'=>'required','page_title'=>'required');
                	        echo json_encode($errors);
                	       }
    	     
    	     }
    	    else
    	    {
    	     redirect('login');
    	     
    	   }
	 }
	 
	 
	 public function getPageInfo()
	 {
    	     if($this->session->userdata('session_id')==session_id())
	    {
                	        if($this->input->post('page_id'))
                	        {
                    	     $page_id=$this->security->xss_clean(trim(strip_tags($this->input->post('page_id'))));
                    	     $params=array('page_id'=>$page_id);
                    	     $result = $this->MapNewsModel->getPageInfo($params);
                    	     echo json_encode($result[0]);
                    	     //print_r($result[0]);
                    	     
                    	     
                    	     
                	            
                	        }
                	       else
                	       {
                	         redirect('dashboard');
                	         
                	       }
    	     
    	     }
    	    else
    	    {
    	     redirect('login');
    	     
    	   }
	 }
	 
	 public function createCustomLink()
	 {
	    
	    if($this->session->userdata('session_id')==session_id())
	    { 
	     
	     $url = $this->security->xss_clean(trim(strip_tags($this->input->post('urlname'))));
	     $linkText=$this->security->xss_clean(trim(strip_tags($this->input->post('linktext'))));
	     $menu_type_id=$this->security->xss_clean(trim(strip_tags($this->input->post('menu_type'))));
	     $params=array('page_name'=>$linkText,'controller'=>$url,'is_custumlink'=>5,'ulbid'=>$this->session->userdata('ulbid'),'langId'=>$this->session->userdata('langId'),'page_title'=>$linkText,'content'=>$url);
	     $result=$this->MapNewsModel->createCustomLink($params,$menu_type_id);
	     
	     //echo $result;
	     if($result=='1')
	     {
	         $this->session->set_flashdata('menu_type_id',$menu_type_id);
	         echo $result;
	     }
	     else
	     {
	         $this->session->set_flashdata('message','Error: Custom link not added , please try again');
	         echo $result;
	     }
	    }
	    else
	    {
	        redirect('login');
	    }
	     
	 }
	 
	 public function updatePages()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    {
	     
	    $jsonobject=json_decode($this->security->xss_clean(trim(strip_tags($this->input->post('aaa')))),true);
	    //$menu_type=$this->input->post('menu_type');
	    
	    $result=$this->MapNewsModel->updatePages($jsonobject);
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
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    //$data['aboutData']=$aboutData=$this->AboutModel->getaboutData($params);
	   
	    
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    $data['sub_menus']=$submenudata;
	    $params=array('ulbid'=>$this->session->userdata('ulbid'),'langId'=>$this->session->userdata('langId'));
	    $customMenus=$this->MenuModel->getCustomMenu($params);
	    
	    if(count($customMenus) > 0)
	    {
    	    foreach($customMenus as $key=>$val)
    	    {
    	        $customemenudata[$val['page_id']]['page_name']=$val['page_name'];
    	        
    	    }
	    
	   
	        $data['custom_menus']=$customemenudata;
	    }
	    
	    
	    
	    $data['menu_types']=$this->AddMenuModel->getMenuData();
	    $params=array(
	        'ulbid'=>$this->session->userdata('ulbid'),
	        'is_draft'=>'0',
	        'is_custumlink'=>0,
	        'langId'=>$this->session->userdata('langId')
	        );
	        $data['publishedPages']=$this->AddMenuModel->publishedPages($params);
	        $params=array(
	        'ulbid'=>$this->session->userdata('ulbid'),
	        'is_draft'=>'0',
	        ' is_custumlink'=>2
	        );
	        $data['publishedPosts']=$this->AddMenuModel->publishedPages($params);
	        
	        $params=array(
	        'ulbid'=>$this->session->userdata('ulbid'),
	        'is_draft'=>'0',
	        ' is_custumlink'=>3,
	        'langId'=>$this->session->userdata('langId')
	        );
	        $data['publishedCategories']=$this->AddMenuModel->publishedPages($params);
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    if($this->input->post('select'))
	        {
	           
	         $selectedMenu=$this->security->xss_clean(trim(strip_tags($this->input->post('menuType'))));
	       }
	       else if($this->session->flashdata('menu_type_id'))
	       {
	           $selectedMenu=$this->session->flashdata('menu_type_id');
	       }else
	       {
	           $selectedMenu=1;
	       }
	       
	       $params=array(
	        'c.ulbid'=>$this->session->userdata('ulbid'),
	        
	        'flag'=>1,
	        'c.langId'=>$this->session->userdata('langId')
	        ); 
	       
	       $data['menu_type_selected']=$selectedMenu;
	       
	      $data['dragdropMainmenudata']=$this->MapNewsModel->getDragDropMainMenuData($params);
	      $data['dragdropSubmenudata']=$this->MapNewsModel->getDragDropSubMenuData($params);
	      $data['dragdropSubSubmenudata']=$this->MapNewsModel->getDragDropSubSubMenuData($params);
	      
	      
	      
	      // Declaration of arrays
	      $data['parentMenus']=array();
	      $data['subMenus']=array();
	      $data['subSubMenus']=array();
	      
	      
	      
	      foreach($data['dragdropMainmenudata']->result() as $key=>$val)
	      {
	         if($val->is_custumlink=='0')
	         {
	         $ispage='Page';
	         }
	         else if($val->is_custumlink=='1')
	         {
	         $ispage='Custom Link';
	         }
	         else if($val->is_custumlink=='3')
	         {
	            $ispage='Category'; 
	         }else if($val->is_custumlink=='5')
	         {
	             $ispage='News';
	         }
	         else
	         {
	             $ispage='Post';
	         }
	         
	         
	         
	          $parent_menus[$val->menu_id][$val->page_id]['page_name']=$val->page_name;
	          $parent_menus[$val->menu_id][$val->page_id]['page']=$ispage;
	      }
	      
	      
	      
	      array_push($data['parentMenus'],$parent_menus);
	      
	      
	      
	   //    foreach($data['dragdropSubmenudata']->result() as $key=>$val)
	   //   {
	   //      if($val->is_custumlink=='0')
	   //      {
	   //      $ispage='Page';
	   //      }
	   //      else if($val->is_custumlink=='1')
	   //      {
	   //      $ispage='Custom Link';
	   //      }
	   //      else if($val->is_custumlink=='3')
	   //      {
	   //         $ispage='Category'; 
	   //      }else
	   //      {
	   //          $ispage='Post';
	   //      }
	   //       $sub_menus[$val->main_menu_id][$val->sub_menu_id ][$val->page_id]['page_name']=$val->page_name;
	   //       $sub_menus[$val->main_menu_id][$val->sub_menu_id ][$val->page_id]['page']=$ispage;
	   //   }
	      
	   //   array_push($data['subMenus'],$sub_menus);
	      
	   //   foreach($data['dragdropSubSubmenudata']->result() as $key=>$val)
	   //   {
	   //      if($val->is_custumlink=='0')
	   //      {
	   //      $ispage='Page';
	   //      }
	   //      else if($val->is_custumlink=='1')
	   //      {
	   //      $ispage='Custom Link';
	   //      }
	   //      else if($val->is_custumlink=='3')
	   //      {
	   //         $ispage='Category'; 
	   //      }else
	   //      {
	   //          $ispage='Post';
	   //      }
	   //       $sub_sub_menus[$val->main_menu_id][$val->sub_menu_id ][$val->sub_sub_menu_id][$val->page_id]['page_name']=$val->page_name;
	   //       $sub_sub_menus[$val->main_menu_id][$val->sub_menu_id ][$val->sub_sub_menu_id][$val->page_id]['page']=$ispage;
	   //   }
	        
	   //    array_push($data['subSubMenus'],$sub_sub_menus); 
	   
	        $params=array(
	        'ulbid'=>$this->session->userdata('ulbid'),
	        
	        ); 
	    
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $this->load->view('header',$data);
		$this->load->view('addnews',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
