<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
class ViewUlbUserController extends CI_Controller {

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
	    $this->load->library('pagination');
	    
	 }
	 
	 public function deleteContent()
	 {
	     
	     if($this->session->userdata('session_id')==session_id())
	     {
	     $user_id=$this->security->xss_clean(trim($this->input->post('user_id')));
	     $params=array('user_id'=>$user_id);
	     echo $result=$this->ViewUlbUserModel->deleteContent($params);
	     }
	     else
	     {
	         exit('Invalid function call');
	     }
	 }
	 
	 public function updateStatus()
	 {
	    if($this->session->userdata('session_id')==session_id())
	     { 
	     
	     
	     $user_id=$this->security->xss_clean(trim($this->input->post('user_id')));
	     $status=$this->security->xss_clean(trim($this->input->post('status')));
	     $params=array('user_id'=>$user_id,'flag'=>$status);
	     $result=$this->ViewUlbUserModel->updateStatus($params);
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
	    $params=array('author'=>$this->session->userdata('username'));
	      $userid=$this->session->userdata('username');
	   
	    $data['users_data']=$this->ViewUlbUserModel->getulbusers($userid);
	    $data['count_active']=$this->ViewUlbUserModel->countofactive($userid);
	    $data['count_Inactive']=$this->ViewUlbUserModel->countofInactive($userid);
	    
	    $last_login_time=$this->ViewUlbUserModel->last_login_time_users();
	    
	    foreach($last_login_time->result() as $key=>$val2)
	    {
	        
	        $data['last_login'][$val2->user_id]['ipaddress']=$val2->ip;
	        
	       $data['last_login'][$val2->user_id]['time']=$val2->datetime;
	       
	        
	    }
	    //displaying data
            $config["base_url"] = base_url() . "viewulbusers";
            $config["total_rows"] = $this->ViewUlbUserModel->users_count();
            $config["per_page"] = 85;
            $config["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(2))? $this->uri->segment(2) : 0;
            $data["results"]  = $this->ViewUlbUserModel->get_userslist($config["per_page"], $page);
           // $data["links"] = $this->pagination->create_links();
 
	    
	    //print_r($data['last_login_time']);
	    //exit;
	   //print_r($data['users_data']);
	    //exit;
	    
	    
	    
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $this->load->view('header',$data);
		$this->load->view('viewulbusers',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	public function editulbuser()
	{
	    
	   if($this->session->userdata('session_id')==session_id())
	     {
	         $user_id=$this->uri->segment('3');
	    
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
	    $params=array('user_id'=>$this->session->userdata('username'),'langId'=>$this->session->userdata('langId'));
	    $data['widgetList']=$this->ViewUlbUserModel->getwidgetList($params);
	    
	    $edit_widgetList=$this->ViewUlbUserModel->user_edit_getwidgetList($user_id);
	    foreach($edit_widgetList->result() as $key=>$val)
	    {
	        $data['chkedwidgets'][$val->widget_id]['checked']='checked';
	    }
	    
	    $edit_main_menu_List=$this->ViewUlbUserModel->user_edit_getmain_menuList($user_id);
	    
	   
	    foreach($edit_main_menu_List->result() as $key=>$val2)
	    {
	         
	        $data['chkedmainmenu'][$val2->main_menu_id]['checked']='checked';
	        
	    }
	    
	    
	    $edit_sub_menu_List=$this->ViewUlbUserModel->user_edit_getsub_menuList($user_id);
	    
	     foreach($edit_sub_menu_List->result() as $key=>$val3)
	    {
	        //print_r($edit_sub_menu_List);
	         
	        $data['chkedsubmenu'][$val3->sub_menu_id]['checked']='checked';
	        
	    }
	   
	    $data['edit_users_data']=$this->ViewUlbUserModel->get_edit_ulbusers($user_id);
	    
	   //print_r($data['users_data']);
	    //exit;
	    
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $this->load->view('header',$data);
		$this->load->view('editulbuser',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	public function update_user($id){
	    
	     
	  if($this->session->userdata('session_id')==session_id())
	     {
	        
	   $user_id=$this->uri->segment('3');
	       
	   if($this->input->post('save'))
	   {
	       
	       $this->ViewUlbUserModel->user_deletewidget_permission($user_id);
	       $this->ViewUlbUserModel->user_delete_user_services($user_id);
	              
	        $userdetails=array(
	              
	              'user_id'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', $this->input->post('userid')))),
	              'user_name'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', $this->input->post('user_name')))),
	              'designation_id'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', $this->input->post('designation_id')))),
                  'user_mobile'=>$this->security->xss_clean(trim(preg_replace('/[^0-9]/', ' ', $this->input->post('user_mobile')))),
                  'user_email'=> $this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9_.@]/', ' ', $this->input->post('user_email')))),
	              'ulbid'=>$this->session->userdata('ulbid'),
	              'user_category'=>$this->security->xss_clean(trim($this->input->post('user_category'))),
	              'is_custom_user'=>$this->security->xss_clean(trim($this->input->post('is_custom_user'))),
	              'author'=>$this->session->userdata('username')
	              
	              );
	              
	       
	               
	              $result=$this->ViewUlbUserModel->update_user($userdetails,$user_id);
	             
	             
	             if($result)
	              {
	                  
	                  $this->session->set_flashdata('message',"User Details updated successfully ");
	       
	                 if($this->input->post('is_custom_user')=='Yes'){
	                     
            	      $page_count=$this->security->xss_clean(trim($this->input->post('pagecount')));
            	      $widget_count=$this->security->xss_clean(trim($this->input->post('widgetCount')));
            	      $params=array();
            	      for($i=1;$i<$page_count-1;$i++)
            	      {
            	          
            	         
            	          $create="create".$i;
            	         
            	          $create_arr=explode("_",$this->input->post($create));
            	          //print_r($create_arr);
            	         
            	          
            	         if($create_arr[0] > 0) // if main menu id is 0 then skip from code
            	          {
            	             
            	          
                    	          if($create_arr[1]=='') // if sub menu id is NULL the make it to 0
                    	          {
                    	              $create_arr[1]=0;
                    	          }
                    	         
                    	          $params['user_id']=$this->security->xss_clean(trim($this->input->post('user_id')));
                    	          $params['main_menu_id']=$create_arr[0];
                    	          $params['sub_menu_id']=$create_arr[1];
                    	          $params['status']=1;
                    	          
                    	          
                    	         
                    	         $this->ViewUlbUserModel->pageprevilizes($params);
            	          }
            	      }
            	      
            	   
            	     
            	      for($j=1;$j<=$widget_count;$j++)
            	      {
            	          $widget="widget".$j;
            	          $params2=array();
            	          
            	          if($this->input->post($widget) > 0)
            	          {
            	              $params2['widget_id']=$this->security->xss_clean(trim($this->input->post($widget)));
            	              $params2['user_id']=$this->security->xss_clean(trim($this->input->post('user_id')));
            	              $params2['is_edit_permission']=1;
            	              $params2['is_delete_permission']=0;
            	              $params2['author']=$this->session->userdata('username');
            	             
            	              $this->ViewUlbUserModel->widgetprevilizes($params2);
            	              
            	          }
            	      }
            	      
            	       $result=$this->CreaUlbUserModel->addCommonpages($this->security->xss_clean(trim($this->input->post('user_id'))));
            	      
            	      $this->session->set_flashdata('message',"User Category updated successfully ");
            	      redirect('site-admin-view-user');
            	      
	              }
	              else
	              {
	                  redirect('site-admin-view-user');
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
