<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
class UserViewCategoryController extends CI_Controller {

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
	    $this->load->model('ViewUlbUserModel');
	    $this->load->model('CreaUlbUserModel');
	    $this->load->model('ViewUlbUserCategoryModel');
	    
	    
	 }
	 
	 public function deleteContent()
	 {
	     if($this->session->userdata('session_id')==session_id())
	     {
	         
	         if($this->input->post('user_id'))
	         {
        	     $user_id=$this->security->xss_clean($this->input->post('user_id'));
        	     $params=array('id'=>$user_id);
        	     echo $result=$this->ViewUlbUserCategoryModel->deleteContent($params);
	         }
	         else
	         {
	            redirect('Login'); 
	         }
	     }
	     else
	     {
	         redirect('Login');
	     }
	 }
	 
	 public function updateStatus()
	 {
	      if($this->session->userdata('session_id')==session_id())
	     {
	         
	         if($this->input->post('user_id') && $this->input->post('status'))
	         {
        	     $user_id=$this->security->xss_clean($this->input->post('user_id'));
        	     $status=$this->security->xss_clean($this->input->post('status'));
        	     $params=array('user_id'=>$user_id,'flag'=>$status);
        	     $result=$this->ViewUlbUserModel->updateStatus($params);
        	     echo $result;
	         }
	         else
	         {
	            redirect('Login'); 
	         }
	     }
	     else
	     {
	         redirect('Login');
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
	    $params=array('author'=>$this->session->userdata('username'));
	    
	    $userid=$this->session->userdata('username');
	    $user_level=$this->session->userdata('user_type');
	    $ulbid=$this->session->userdata('ulbid');
	   
	   if($this->session->userdata('user_type') !='A')
	    {
	    $data['users_data']=$this->ViewUlbUserCategoryModel->getulbusercategories($user_level,$ulbid);
	    } 
	    else {
	    $data['users_data']=$this->ViewUlbUserCategoryModel->getulbusercategories($user_level,$ulbid);
	    }
	    $data['count_active']=$this->ViewUlbUserModel->countofactive($userid);
	    $data['count_Inactive']=$this->ViewUlbUserModel->countofInactive($userid);
	   
	    
	    
	    
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $this->load->view('header',$data);
		$this->load->view('viewulbcategories',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	public function editulbuser_category()
	{
	    
	   if($this->session->userdata('session_id')==session_id())
	    {
	          $user_id=$this->security->xss_clean($this->uri->segment('3'));
	        
	    
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
	    $params=array('author'=>$this->session->userdata('username'));
	    
	     if($this->session->userdata('user_type') !='A')
	    {
	        
	    $params=array('us.user_id'=>$this->session->userdata('username'),'us.status'=>1,'m.is_common_page'=>'2');
	    $data['user_permission_pages']=$this->ViewUlbUserModel->getUserPermissionPages($params);
	    $user_permission_subpages=$this->ViewUlbUserModel->getUserPermissionSubPages($params);
	    foreach($user_permission_subpages->result() as $key=>$val)
	    {
	        $data['user_permission_subpages'][$val->main_menu_id][$val->sub_menu_id]['page_name']=$val->sub_menu_desc;
	    }
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['designationList']=$this->ViewUlbUserModel->getDesignations($params);
	    $data['getuser_categories']=$this->ViewUlbUserModel->getuser_categories($params);
	    
	    
	    
	    //$params=array('user_id'=>$this->session->userdata('username'),'langId'=>$this->session->userdata('langId'));
	    $params = array(
	                    'userid'=>$this->session->userdata('userid'),
	                    'langId'=>$this->session->userdata('langId'),
	                    'user_type'=>$this->session->userdata('user_type'),
	                    'ulbid'=>$this->session->userdata('ulbid'),
	                    'user_category'=>$this->session->userdata('user_category')
	               );
	    
	    
	    $data['widgetList']=$this->ViewUlbUserModel->getwidgetList($params);
	    
	    $edit_widgetList=$this->ViewUlbUserModel->edit_getwidgetList($user_id);
	    foreach($edit_widgetList->result() as $key=>$val)
	    {
	        $data['chkedwidgets'][$val->widget_id]['checked']='checked';
	    }
	    
	    $edit_main_menu_List=$this->ViewUlbUserModel->edit_getmain_menuList($user_id);
	    
	   
	    foreach($edit_main_menu_List->result() as $key=>$val2)
	    {
	         
	        $data['chkedmainmenu'][$val2->main_menu_id]['checked']='checked';
	        
	    }
	    
	    
	    $edit_sub_menu_List=$this->ViewUlbUserModel->edit_getsub_menuList($user_id);
	    
	     foreach($edit_sub_menu_List->result() as $key=>$val3)
	    {
	        //print_r($edit_sub_menu_List);
	         
	        $data['chkedsubmenu'][$val3->sub_menu_id]['checked']='checked';
	        
	    }
	   
	    $data['edit_users_data']=$this->ViewUlbUserCategoryModel->get_edit_ulbusers_category($user_id);
	    }
	    
	    
	    else {
	       
	       $data['user_permission_pages']=$this->CreaUlbUserModel->getMainMenupages();
	       $user_permission_subpages=$this->CreaUlbUserModel->getSubMenupages();
	     foreach($user_permission_subpages->result() as $key=>$val)
	    {
	        $data['user_permission_subpages'][$val->main_menu_id][$val->sub_menu_id]['page_name']=$val->sub_menu_desc;
	    }
	    
	    //$data['designationList']=$this->CreaUlbUserModel->supergetDesignations();
	    //$data['getuser_categories']=$this->CreaUlbUserModel->supergetuser_categories();
	    $params=array('langId'=>$this->session->userdata('langId'));
	    $data['widgetList']=$this->CreaUlbUserModel->getwidgetpages($params);
	    
	    $data['edit_users_data']=$this->ViewUlbUserCategoryModel->get_edit_ulbusers_category($user_id);
	   
	    $edit_widgetList=$this->ViewUlbUserModel->edit_getwidgetList($user_id);
	    
	    foreach($edit_widgetList->result() as $key=>$val)
	    {
	        
	        $data['chkedwidgets'][$val->widget_id]['checked']='checked';
	    }
	    
	    $edit_main_menu_List=$this->ViewUlbUserModel->edit_getmain_menuList($user_id);
	   
	   
	    foreach($edit_main_menu_List->result() as $key=>$val2)
	    {
	        
	         
	        $data['chkedmainmenu'][$val2->main_menu_id]['checked']='checked';
	        
	    }
	    
	    $edit_sub_menu_List=$this->ViewUlbUserModel->edit_getsub_menuList($user_id);
	    
	     foreach($edit_sub_menu_List->result() as $key=>$val3)
	    {
	        //print_r($edit_sub_menu_List);
	         
	        $data['chkedsubmenu'][$val3->sub_menu_id]['checked']='checked';
	        
	    }
	    
	    
	    }
	    
	   
	   //print_r($data['users_data']);
	    //exit;
	    
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $this->load->view('header',$data);
		$this->load->view('editulbuser_category',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	public function update_user_category($id){
	    
	    
	  if($this->session->userdata('session_id')==session_id())
	    {
	        
	    $user_id=$this->security->xss_clean($this->uri->segment('3'));
	       
	   if($this->input->post('save'))
	   {
	       
	       $this->ViewUlbUserModel->deletewidget_permission($user_id);
	       $this->ViewUlbUserModel->delete_user_services($user_id);
	              
	        $userdetails=array(
	              
	              'ulbid'=>$this->input->post('ulbid'),
	              'user_category_name'=>$this->security->xss_clean(preg_replace('/[^A-Za-z0-9]/', ' ', $this->input->post('user_category_name'))),
	              'author'=>$this->session->userdata('username')
	               );
	               
	             $result=$this->ViewUlbUserCategoryModel->update_user_category($userdetails,$user_id);
	             
	             if($result)
	              {
	                  
	                  $page_count=$this->input->post('pagecount');
            	      $widget_count=$this->input->post('widgetCount');
            	      $params=array();
            	      for($i=1;$i<=$page_count;$i++)
            	      {
            	          
            	          $create="create".$i;
            	          $create_arr=explode("_",$this->input->post($create));
            	        
            	          
            	          if($create_arr[0] > 0) // if main menu id is 0 then skip from code
            	          {
            	             
            	          
                    	          if($create_arr[1]=='') // if sub menu id is NULL the make it to 0
                    	          {
                    	              $create_arr[1]=0;
                    	          }
                    	         
                    	          //$params['user_id']=$user_id;
                    	          $params['user_category']=$user_id;
                    	          $params['main_menu_id']=$create_arr[0];
                    	          $params['sub_menu_id']=$create_arr[1];
                    	          $params['status']=1;
                    	          
                    	         //print_r($params);
                    	         
                    	         $this->ViewUlbUserCategoryModel->pageprevilizes($params);
            	          }
            	      }
            	      
            	      
            	      
            	      for($j=1;$j<$widget_count;$j++)
            	      {
            	          $widget="widget".$j;
            	          $params2=array();
            	          
            	          if($this->input->post($widget) > 0)
            	          {
            	              $params2['widget_id']=$this->input->post($widget);
            	              //$params2['user_id']=$user_id;
            	              $params2['user_category']=$user_id;
            	              $params2['is_edit_permission']=1;
            	              $params2['is_delete_permission']=0;
            	              $params2['author']=$this->session->userdata('username');
            	              
            	              $this->ViewUlbUserCategoryModel->widgetprevilizes($params2);
            	              
            	          }
            	      }
            	      
            	      $result=$this->CreaUlbUserModel->addCommonpages_user_category($user_id);
            	      if($result)
            	      {
            	          $this->session->set_flashdata('message',"<div class='btn btn-success'> User added successfully </div>");
            	          redirect('site-admin-view-user-category');
            	      }
            	      
            	      
	            }
	     
	   }
	        
	    }
	    else {
	        redirect('login');
	    }
	    
	}
	
	public function check_userid_avalibility(){
	    
	     if($this->ViewUlbUserModel->check_userid_avalibility($_POST["user"],$_POST['exist_user']))  
               {  
                    //echo '<label class="text-danger"><span class="glyphicon glyphicon-remove"></span> User Id Already register</label>';  
                    echo '0';
                    
               } else {
                   echo '1';
               } 
                
	    
	}

}
