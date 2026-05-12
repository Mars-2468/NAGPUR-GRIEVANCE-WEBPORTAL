<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class UserCategoryController extends MY_Controller {

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
	     $this->load->model('CreaUlbUserModel');
	     $this->load->library('form_validation');
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
	    
	    if($this->session->userdata('user_type') !='A')
	    {
	        
	    // get main menus which are permitted by super admin to ulb admin
	    
	    $params=array('us.user_id'=>$this->session->userdata('userid'),'us.status'=>1,'m.is_common_page'=>'2');
	    $data['user_permission_pages']=$this->CreaUlbUserModel->getUserPermissionPages($params);
	    $user_permission_subpages=$this->CreaUlbUserModel->getUserPermissionSubPages($params);
	    
	    
	    
	    //captcha code
	    
	    
	    $config = array(
            'img_path'      => 'assets/captcha_images/',
            'img_url'       => base_url().'assets/captcha_images/',
            'font_path'     => 'system/fonts/texb.ttf',
            'img_width'     => '180',
            'img_height'    => 50,
            'expiration'    => 3600,
            'word_length'   => 6,
            'font_size'     => 18,
            'colors'        => array(
                        'background' => array(255, 255, 227),
                        'border' => array(33, 23, 96),
                        'text' => array(57, 44, 112),
                        'grid' => array(174, 222, 252)
                )
        );
        $captcha = create_captcha($config);
        
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
        
        // Pass captcha image to view
        // $data_cap['captchaImg'] = $captcha['image'];
        $data['captchaImg'] = $captcha['image'];
	    
	    
	    
	    
	    //captcha code
	    
	    foreach($user_permission_subpages->result() as $key=>$val)
	    {
	        $data['user_permission_subpages'][$val->main_menu_id][$val->sub_menu_id]['page_name']=$val->sub_menu_desc;
	    }
	    // designation list
	    
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['designationList']=$this->CreaUlbUserModel->getDesignations($params);
	    $params = array(
	                    'userid'=>$this->session->userdata('userid'),
	                    'langId'=>$this->session->userdata('langId'),
	                    'user_type'=>$this->session->userdata('user_type'),
	                    'ulbid'=>$this->session->userdata('ulbid'),
	                    'user_category'=>$this->session->userdata('user_category')
	               );
	    $data['widgetList']=$this->CreaUlbUserModel->getwidgetList($params);
	    
	    }
	    
	    else
	    {
	       
	       
	       
	   $data['user_permission_pages']=$this->CreaUlbUserModel->getMainMenupages();
	   $user_permission_subpages=$this->CreaUlbUserModel->getSubMenupages();
	       
	   foreach($user_permission_subpages->result() as $key=>$val)
	    {
	        $data['user_permission_subpages'][$val->main_menu_id][$val->sub_menu_id]['page_name']=$val->sub_menu_desc;
	    }
	    $params=array('langId'=>$this->session->userdata('langId'),'user_type'=>$this->session->userdata('user_type'));
	    $data['widgetList']=$this->CreaUlbUserModel->getwidgetList($params);
	    
	    
	    }
	    
	    
	    
	    
	   if($this->input->post('save'))
	   {
	       
	       
	       $this->form_validation->set_rules('user_category_name', 'User Category', 'required');
	       if ($this->form_validation->run() == FALSE)
                {
                        //$this->load->view('myform');
                }
                else
                {
	       
	       
	       
	        $userdetails=array(
	              
	              'user_category_name'=>$this->security->xss_clean(preg_replace('/[^A-Za-z0-9]/', ' ', $this->input->post('user_category_name'))),
	              'ulbid'=>$this->session->userdata('ulbid'),
	              'flag'=>'1',
	              'user_level'=>$this->session->userdata('user_type'),
	              'author'=>$this->session->userdata('userid')
	              
	              );
	              
	              $result=$this->CreaUlbUserModel->createcategory($userdetails);
	              $result=1;
	              $last_categiry_id=$this->db->insert_id();
	              if($result)
	              {
	       
            	      $page_count=$this->security->xss_clean($this->input->post('pagecount'));
            	      $widget_count=$this->security->xss_clean($this->input->post('widgetCount'));
            	      $params=array();
            	      for($i=1;$i<=$page_count;$i++)
            	      {
            	          
            	         
            	          $create="create".$i;
            	          $create_arr=explode("_",$this->security->xss_clean($this->input->post($create)));
            	        
            	          
            	          if($create_arr[0] > 0) // if main menu id is 0 then skip from code
            	          {
            	             
            	          
                    	          if($create_arr[1]=='') // if sub menu id is NULL the make it to 0
                    	          {
                    	              $create_arr[1]=0;
                    	          }
                    	         
                    	          //$params['user_id']=$last_categiry_id;
                    	          $params['user_category']=$last_categiry_id;
                    	          $params['main_menu_id']=$create_arr[0];
                    	          $params['sub_menu_id']=$create_arr[1];
                    	          $params['status']=1;
                    	          
                    	     $this->CreaUlbUserModel->pageprevilizes($params);
            	          }
            	      }
            	      
            	      for($j=1;$j<$widget_count-1;$j++)
            	      {
            	          $widget="widget".$j;
            	          $params2=array();
            	          
            	          if($this->input->post($widget) > 0)
            	          {
            	              $params2['widget_id']=$this->input->post($widget);
            	              //$params2['user_id']=$last_categiry_id;
            	              $params2['user_category']=$last_categiry_id;
            	              $params2['is_edit_permission']=1;
            	              $params2['is_delete_permission']=0;
            	              $params2['author']=$this->session->userdata('userid');
            	              
            	              $this->CreaUlbUserModel->widgetprevilizes($params2);
            	              
            	          }
            	      }
            	      
            	      $result=$this->CreaUlbUserModel->addCommonpages_user_category($last_categiry_id);
            	      if($result)
            	      {
            	          $this->session->set_flashdata('message',"<div class='btn btn-success'> User added successfully </div>");
            	          redirect('site-admin-view-user-category');
            	      }
            	      
            	      
	            }
	     }
	   }
	   
	    
	    $this->load->view('header',$data);
		$this->load->view('usercategory',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	public function getCaptcha(){
	    
	    $captcha_reload = $this->input->post('captcha_reload');
	    if($captcha_reload=='Reload'){
            $digits='2';
            $i = 0; 
            $pin = ""; 
            while($i < $digits){
                $pin .= mt_rand(0, 9);
                $i++;
            }
            echo  $pin;
        
        }
	}
	
	
	public function refresh(){
        // Captcha configuration
        $config = array(
            'img_path'      => 'assets/captcha_images/',
            'img_url'       => base_url().'assets/captcha_images/',
            'font_path'     => 'system/fonts/texb.ttf',
            'img_width'     => '180',
            'img_height'    => 50,
            'expiration'    => 3600,
            'word_length'   => 6,
            'font_size'     => 18,
            'colors'        => array(
                        'background' => array(255, 255, 227),
                        'border' => array(33, 23, 96),
                        'text' => array(57, 44, 112),
                        'grid' => array(174, 222, 252)
                )
        );
        $captcha = create_captcha($config);
        
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        
        // Display captcha image
        echo $captcha['image'];
    }
	
	
	
	
}
