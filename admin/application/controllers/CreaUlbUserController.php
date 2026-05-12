<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class CreaUlbUserController extends CI_Controller {

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
	     $this->load->helper('captcha');
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
	    
	    $params=array('us.user_id'=>$this->session->userdata('username'),'us.status'=>1,'m.is_common_page'=>'2');
	    $data['user_permission_pages']=$this->CreaUlbUserModel->getUserPermissionPages($params);
	    $user_permission_subpages=$this->CreaUlbUserModel->getUserPermissionSubPages($params);
	    foreach($user_permission_subpages->result() as $key=>$val)
	    {
	        $data['user_permission_subpages'][$val->main_menu_id][$val->sub_menu_id]['page_name']=$val->sub_menu_desc;
	    }
	    // designation list
	    
	    $params=array('ulbid'=>strip_tags($this->session->userdata('ulbid')));
	    $data['designationList']=$this->CreaUlbUserModel->getDesignations($params);
	    
	     $user_category=strip_tags($this->session->userdata('user_category'));
	     $ulbid=$this->session->userdata('ulbid');
	    $data['getuser_categories']=$this->CreaUlbUserModel->getuser_categories($user_category,$ulbid);
	    
	   /* $params=array('user_id'=>$this->session->userdata('username'),'langId'=>$this->session->userdata('langId'));
	    $data['widgetList']=$this->CreaUlbUserModel->getwidgetList($params);*/
	    
        $params = array(
                    'userid'=>strip_tags($this->session->userdata('userid')),
                    'langId'=>strip_tags($this->session->userdata('langId')),
                    'user_type'=>strip_tags($this->session->userdata('user_type')),
                    'ulbid'=>strip_tags($this->session->userdata('ulbid')),
                    'user_category'=>strip_tags($this->session->userdata('user_category'))
               );
	    $data['widgetList']=$this->CreaUlbUserModel->getwidgetList($params);
	    $p = array('user_type'=>$this->session->userdata('user_type'));
	    $data['userLevel'] = $this->CreaUlbUserModel->getUserLevelList($p);
	    }
	    
	    else {
	        $user_level=$this->session->userdata('user_type');
	       $data['user_permission_pages']=$this->CreaUlbUserModel->getMainMenupages();
	       $user_permission_subpages=$this->CreaUlbUserModel->getSubMenupages();
	     foreach($user_permission_subpages->result() as $key=>$val)
	    {
	        $data['user_permission_subpages'][$val->main_menu_id][$val->sub_menu_id]['page_name']=$val->sub_menu_desc;
	    }
	    
	    $data['designationList']=$this->CreaUlbUserModel->supergetDesignations();
	    $data['getuser_categories']=$this->CreaUlbUserModel->supergetuser_categories($user_level);
	    
	    $params = array(
                    'userid'=>strip_tags($this->session->userdata('userid')),
                    'langId'=>strip_tags($this->session->userdata('langId')),
                    'user_type'=>strip_tags($this->session->userdata('user_type')),
                    'ulbid'=>strip_tags($this->session->userdata('ulbid')),
                    'user_category'=>strip_tags($this->session->userdata('user_category'))
               );
	    $data['widgetList']=$this->CreaUlbUserModel->getwidgetpages($params);
	    $data['ulbList'] = $this->CreaUlbUserModel->getUlbList();
	    $p = array('user_type'=>strip_tags($this->session->userdata('user_type')));
	    $data['userLevel'] = $this->CreaUlbUserModel->getUserLevelList($p);
	    }
	    
        if($this->input->post('save'))
        {
            if($this->session->userdata('user_level') == 'A'){
                $ulbid = strip_tags($this->input->post('municipality'));
            }else{
                $ulbid = strip_tags($this->session->userdata('ulbid'));
            }
             $inputCaptcha = strip_tags($this->input->post('captcha'));
                  $sessCaptcha = strip_tags($this->session->userdata('captchaCode'));
	                if($inputCaptcha === $sessCaptcha){
            $userdetails=array(
            
                'user_name'=>$this->security->xss_clean(preg_replace('/[^A-Za-z0-9]/', ' ', strip_tags($this->input->post('person_name')))),
                'designation_id'=>$this->security->xss_clean(preg_replace('/[^A-Za-z0-9]/', ' ', strip_tags($this->input->post('designation_id')))),
                'user_mobile'=>$this->security->xss_clean(preg_replace('/[^0-9]/', ' ', strip_tags($this->input->post('mobile')))),
                'user_email'=>$this->security->xss_clean(preg_replace('/[^A-Za-z0-9.@]/', ' ', strip_tags($this->input->post('email')))),
                'user_id'=>$this->security->xss_clean(strip_tags($this->input->post('user_id'))),
                'user_pwd'=>$this->security->xss_clean((sha1($this->input->post('fk')))),
                'user_type'=>$this->security->xss_clean(strip_tags($this->input->post('user_level_id'))),
                'ulbid'=> $ulbid,
                'user_category'=>$this->security->xss_clean(strip_tags($this->input->post('user_category'))),
                'is_custom_user'=>$this->security->xss_clean(strip_tags($this->input->post('is_custom_user'))),
                'author'=>$this->session->userdata('userid')
            
            );
            
            //print_r($userdetails);
            //exit;
            $result=$this->CreaUlbUserModel->createUser($userdetails);
            if($result)
            {
            
                if($this->input->post('is_custom_user')=='Yes'){
                
                    $page_count=$this->security->xss_clean(strip_tags($this->input->post('pagecount')));
                    $widget_count=$this->security->xss_clean(strip_tags($this->input->post('widgetCount')));
                    $params=array();
                    for($i=1;$i<=$page_count;$i++)
                    {
                    // echo $i;
                
                
                        $create="create".$i;
                        $create_arr=explode("_",$this->security->xss_clean(strip_tags($this->input->post($create))));
                        
                        
                        if($create_arr[0] > 0) // if main menu id is 0 then skip from code
                        {
                        
                        
                            if($create_arr[1]=='') // if sub menu id is NULL the make it to 0
                            {
                            $create_arr[1]=0;
                            }
                        
                            $params['user_id']=$this->security->xss_clean(strip_tags($this->input->post('user_id')));
                            $params['main_menu_id']=$create_arr[0];
                            $params['sub_menu_id']=$create_arr[1];
                            $params['status']=1;
                        
                        // print_r($params);
                        
                        $this->CreaUlbUserModel->pageprevilizes($params);
                        }
                    }
                    //exit;
                    
                    for($j=1;$j<$widget_count-1;$j++)
                    {
                        $widget="widget".$j;
                        $params2=array();
                        
                        if($this->input->post($widget) > 0)
                        {
                            $params2['widget_id']=$this->security->xss_clean(strip_tags($this->input->post($widget)));
                            $params2['user_id']=$this->security->xss_clean(strip_tags($this->input->post('user_id')));
                            $params2['is_edit_permission']=1;
                            $params2['is_delete_permission']=0;
                            $params2['author']=strip_tags($this->session->userdata('username'));
                            
                            $this->CreaUlbUserModel->widgetprevilizes($params2);
                        
                        }
                    }
            
                    $result1=$this->CreaUlbUserModel->addCommonpages($this->security->xss_clean(strip_tags($this->input->post('user_id'))));
                    if($result1){
                        //echo "okkkk";exit;
                        $this->session->set_flashdata('message',"<div class='alert alert-success'> User added successfully </div>");
                        redirect('site-admin-creat-user');
                    }else{
                       // echo "not  okkkk";exit;
                        $this->session->set_flashdata('message',"<div class='alert alert-danger'> Please Try Again! </div>");
                        redirect('site-admin-creat-user');
                    }
                    
                }else{
                    if($result){
                        $this->session->set_flashdata('message',"<div class='alert alert-success'> User added successfully </div>");
                        redirect('site-admin-creat-user');
                    }else{
                        $this->session->set_flashdata('message',"<div class='alert alert-danger'> Please Try Again! </div>");
                        redirect('site-admin-creat-user');
                    }
                }
            }
            
        }
	   else{
	           $this->session->set_flashdata('message',"<div class='alert alert-danger'>Captcha code does not match, please try again. </div>");
	       }
            
        }
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
	    
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('createulbuser',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('Login');
	    }
	}
	
		public function check_userid_avalibility(){
		    
		    
		    
		    
		    if($this->session->userdata('session_id')==session_id())
		    {
	    
	     if($this->CreaUlbUserModel->check_userid_avalibility($this->security->xss_clean(strip_tags($_POST["user"]))))  
               {  
                     
                    echo '0';
                    
               } else {
                   echo '1';
               } 
		    }
		    else
		    {
		        redirect('Login');
		    }
                
	    
	}
	
	public function getCaptcha(){
	    
	    $captcha_reload = strip_tags($this->input->post('captcha_reload'));
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
