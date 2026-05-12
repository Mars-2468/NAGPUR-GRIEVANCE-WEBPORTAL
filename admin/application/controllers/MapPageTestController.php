<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class MapPageTestController extends CI_Controller {

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
	    
	 }
	 
	 public function saveNewMenu()
	 {
	     
	   if($this->session->userdata('session_id')==session_id())
	    {  
	     
	     
	     if($this->security->xss_clean(trim($this->input->post('savemenu'))))
	     {
	         if($this->security->xss_clean(trim($this->input->post('menuname')))==='')
	         {
	             $this->session->set_flashdata('message',"<div class='alert alert-danger'>Please enter menu name</div>");
	         }
	         else
	         {
	             $menu_type_id=$this->MapPageModel->getMenutypeid($this->session->userdata('ulbid'));
	             
	             
	             $params=array(
	                 'menu_type_id'=>$menu_type_id['menu_type_id']+1,
	                 'ulbid'=>$this->session->userdata('ulbid'),
	                 'menu_type_desc'=>$this->input->post('menuname')
	                 );
	                 
	                 $result=$this->MapPageModel->saveNewMenu($params);
	                 if($result)
	                 {
	                     $this->session->set_flashdata('message',"<div class='alert alert-success'>Updated successfully</div>");
	                 }
	                 else
	                 {
	                     $this->session->set_flashdata('message',"<div class='alert alert-danger'>Unable to add menu, try again</div>");
	                 }
	         }
	         
	         
	     }
	     redirect('map-pages');
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 public function updatePageInfo()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    {
                	        if(!empty($this->security->xss_clean(trim($this->input->post('page_id')))) && !empty($this->security->xss_clean(trim($this->input->post('page_name')))) &&  !empty($this->security->xss_clean(trim($this->input->post('page_title')))))
                	        {
                    	     
                    	     $params=array(
                    	         'page_id'=>$this->security->xss_clean(trim($this->input->post('page_id'))),
                    	         'page_name'=>$this->security->xss_clean(trim($this->input->post('page_name'))),
                    	         'page_title'=>$this->security->xss_clean(trim($this->input->post('page_title'))),
                    	         'is_targetblank'=>$this->security->xss_clean(trim($this->input->post('is_targetblank'))),
                    	         'is_alert'=>$this->security->xss_clean(trim($this->input->post('is_alert'))),
                    	         'hover_title'=>$this->security->xss_clean(trim($this->input->post('hover_title'))),
                    	         'page_url'=>$this->security->xss_clean(trim($this->input->post('page_url')))
                    	         );
                    	         
                    	        
                    	         
                    	       $result = $this->MapPageModel->updatePageInfo($params);
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
                	        if($this->security->xss_clean(trim($this->input->post('page_id'))))
                	        {
                    	     $page_id=$this->security->xss_clean(trim($this->input->post('page_id')));
                    	     $params=array('page_id'=>$page_id);
                    	     $result = $this->MapPageModel->getPageInfo($params);
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
	         'pageheading'=>$linkText,
	         'is_alert'=>$this->security->xss_clean(trim($this->input->post('is_alert'))),
	         'is_target_blank'=>$this->security->xss_clean(trim($this->input->post('is_targetblank')))
	         );
	     
	     $result=$this->MapPageModel->createCustomLink($params,$menu_type_id);
	     
	     
	     
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
	     
	    $jsonobject=json_decode($this->security->xss_clean(trim($this->input->post('aaa'))),true);
	    $menu_type=$this->security->xss_clean(trim($this->input->post('menu_type')));
	    
	    $result=$this->MapPageModel->updatePages($jsonobject,$menu_type);
	    echo $result;
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
	    
	    
	    
	    $data['menu_types']=$this->AddMenuModel->getMenuData($this->session->userdata('ulbid'));// menu types
	    $params=array(
	        'ulbid'=>$this->session->userdata('ulbid'),
	        'is_draft'=>'0',
	        'is_custumlink'=>0,
	        'langId'=>$this->session->userdata('langId')
	        );
	        
	        $data['publishedPages']=$this->AddMenuModel->publishedPages($params); // published pages 
	        $params=array(
	        'ulbid'=>$this->session->userdata('ulbid'),
	        'is_draft'=>'0',
	        ' is_custumlink'=>2
	        );
	        $data['publishedPosts']=$this->AddMenuModel->publishedPages($params); // published posts
	        
	        
	         $params=array(
	        'ulbid'=>$this->session->userdata('ulbid'),
	        'is_draft'=>'0',
	        ' is_custumlink'=>1
	        );
	        $data['publishedCustomlinks']=$this->AddMenuModel->publishedPages($params); // published custom links
	        
	        
	        
	        
	        
	        $params=array(
	        'ulbid'=>$this->session->userdata('ulbid'),
	        'is_draft'=>'0',
	        ' is_custumlink'=>3,
	        'langId'=>$this->session->userdata('langId')
	        );
	        $data['publishedCategories']=$this->AddMenuModel->publishedPages($params);
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    if($this->security->xss_clean(trim($this->input->post('select'))))
	        {
	           $this->security->xss_clean(trim($this->input->post('menuType')));
	         $selectedMenu=$this->security->xss_clean(trim($this->input->post('menuType')));
	       }
	       else if($this->session->flashdata('menu_type_id'))
	       {
	           $selectedMenu=$this->session->flashdata('menu_type_id');
	       }else
	       {
	           $selectedMenu=1;
	       }
	       
	       $params=array(
	        'sm.ulbid'=>$this->session->userdata('ulbid'),
	        'menu_type_id'=>$selectedMenu,
	        'flag'=>1,
	        'sm.langId'=>$this->session->userdata('langId')
	        ); 
	       
	       $data['menu_type_selected']=$selectedMenu;
	       
	      $data['dragdropMainmenudata']=$this->MapPageModel->getDragDropMainMenuData($params);
	      $data['dragdropSubmenudata']=$this->MapPageModel->getDragDropSubMenuData($params);
	      $data['dragdropSubSubmenudata']=$this->MapPageModel->getDragDropSubSubMenuData($params);
	      
	      
	      
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
	         }else
	         {
	             $ispage='Post';
	         }
	         
	          $parent_menus[$val->menu_id][$val->page_id]['page_name']=$val->page_name;
	          $parent_menus[$val->menu_id][$val->page_id]['page']=$ispage;
	      }
	      
	      
	      
	      array_push($data['parentMenus'],$parent_menus);
	      
	      
	      
	       foreach($data['dragdropSubmenudata']->result() as $key=>$val)
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
	         }else
	         {
	             $ispage='Post';
	         }
	          $sub_menus[$val->main_menu_id][$val->sub_menu_id ][$val->page_id]['page_name']=$val->page_name;
	          $sub_menus[$val->main_menu_id][$val->sub_menu_id ][$val->page_id]['page']=$ispage;
	      }
	      
	      array_push($data['subMenus'],$sub_menus);
	      
	      foreach($data['dragdropSubSubmenudata']->result() as $key=>$val)
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
	         }else
	         {
	             $ispage='Post';
	         }
	          $sub_sub_menus[$val->main_menu_id][$val->sub_menu_id ][$val->sub_sub_menu_id][$val->page_id]['page_name']=$val->page_name;
	          $sub_sub_menus[$val->main_menu_id][$val->sub_menu_id ][$val->sub_sub_menu_id][$val->page_id]['page']=$ispage;
	      }
	        
	       array_push($data['subSubMenus'],$sub_sub_menus); 
	        $params=array(
	        'ulbid'=>$this->session->userdata('ulbid'),
	        
	        ); 
	    
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $this->load->view('header',$data);
		$this->load->view('mappagetest',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	public function ajax_pages_search(){
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	        $id=$this->security->xss_clean(trim($_POST['page_val']));
	        $id1=$this->security->xss_clean(trim($_POST['post_val']));
	        $id2=$this->security->xss_clean(trim($_POST['customlink_val']));
	        $id3=$this->security->xss_clean(trim($_POST['categori_val']));
	       
	        $ulbid=$this->session->userdata('ulbid');
	        $is_draft='0';
	        $is_custumlink='0';
	        $langId=$this->session->userdata('langId');
	        $keyword4 =$this->security->xss_clean(trim($_POST['keyword']));
	       
	         
	      $searching_pages = $this->AddMenuModel->ajax_page_search($ulbid,$is_draft,$is_custumlink,$langId,$keyword4,$id);
	        
	        
	        
	        $ulbid=$this->session->userdata('ulbid');
	        $is_draft='0';
	        $is_custumlink='2';
	        $langId=$this->session->userdata('langId');
	        $keyword5 =$this->security->xss_clean(trim($_POST['keywordpost']));
	       
	         
	     $searching_posts = $this->AddMenuModel->ajax_page_search($ulbid,$is_draft,$is_custumlink,$langId,$keyword5,$id1);
	     
	        
	        $ulbid=$this->session->userdata('ulbid');
	        $is_draft='0';
	        $is_custumlink='1';
	        $langId=$this->session->userdata('langId');
	        $keyword6 =$this->security->xss_clean(trim($_POST['keywordcustomlink']));
	       
	         
	      $searching_customlinks = $this->AddMenuModel->ajax_page_search($ulbid,$is_draft,$is_custumlink,$langId,$keyword6,$id2);  
	        
	        
	        $ulbid=$this->session->userdata('ulbid');
	        $is_draft='0';
	        $is_custumlink='3';
	        $langId=$this->session->userdata('langId');
	        $keyword7 =$this->security->xss_clean(trim($_POST['keywordcategories']));
	       
	         
	      $searching_categories = $this->AddMenuModel->ajax_page_search($ulbid,$is_draft,$is_custumlink,$langId,$keyword7,$id3);
	        
	       
	        //search for pages
	    if(isset($_POST['page_val'])){
	   
	    foreach($searching_pages->result_array() as $key=>$value) {
	        
	        $output .="<label class='ckbox' style='width:100%;'>";
	        $output .="<input type='checkbox' id='addInputSlug" . $value['page_id'] . "' value='".$value['page_id']."' class='chk'><span>".$value['page_name']."</span><br>";
	        $output .="<input type='hidden' id='addInputName" . $value['page_id'] . "' value='".$value['page_name']."'>";
	      
	      $output .="</label>";
	      
	    }
	     echo $output;
	    
	    }
	    
	     //search for posts
	    if(isset($_POST['post_val'])) {
	   
	    foreach($searching_posts->result_array() as $key=>$value1) {
	        
	        
	        $output1 .="<label class='ckbox' style='width:100%;'>";
	        $output1 .="<input type='checkbox' id='addInputSlug" . $value1['page_id'] . "' value='".$value1['page_id']."' class='chk'><span>".$value1['page_name']."</span><br>";
	        $output1 .="<input type='hidden' id='addInputName" . $value1['page_id'] . "' value='".$value1['page_name']."'>";
	      
	      $output1 .="</label>";
	      
	    }
	     echo $output1;
	        
	    }
	     
	     
	     //search for customlinks
	    
	    if(isset($_POST['customlink_val'])) {
	        
	    foreach($searching_customlinks->result_array() as $key=>$value2) {
	        
	        $output2 .="<label class='ckbox' style='width:100%;'>";
	        $output2 .="<input type='checkbox' id='addInputSlug" . $value2['page_id'] . "' value='".$value2['page_id']."' class='chk'><span>".$value2['page_name']."</span><br>";
	        $output2 .="<input type='hidden' id='addInputName" . $value2['page_id'] . "' value='".$value2['page_name']."'>";
	      
	      $output2 .="</label>";
	       
	    }
	     echo $output2;
	    }
	    
	    
	    //search for categories
	    
	    if(isset($_POST['categori_val'])){
	        
	    foreach($searching_categories->result_array() as $key=>$value3){
	        
	        $output3 .="<label class='ckbox' style='width:100%;'>";
	        $output3 .="<input type='checkbox' id='addInputSlug" . $value3['page_id'] . "' value='".$value3['page_id']."' class='chk'><span>".$value3['page_name']."</span><br>";
	        $output3 .="<input type='hidden' id='addInputName" . $value3['page_id'] . "' value='".$value3['page_name']."'>";
	      
	      $output3 .="</label>";
	       
	    }
	     echo $output3;
	    }
	    }
	    else
	    {
	        redirect('login');
	    }
	   
	}
}
