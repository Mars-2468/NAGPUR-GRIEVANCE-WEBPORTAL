<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class AddnewsiteController extends CI_Controller {

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
	     $this->load->model('AddnewsiteModel');
	     $this->load->model('CreaUlbUserModel');
	     $this->load->library('form_validation');
	    
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
	    $data['ulblist']=$this->AddnewsiteModel->getulblist();
	    $data['existedSiteList']=$this->AddnewsiteModel->getexistedsitelist();
	    $data['theme_list']=$this->AddnewsiteModel->themelist();
	  
	    
	   
	    
	    if($this->input->post('save'))
	    {
	        $inputCaptcha = $this->input->post('captcha');
            $sessCaptcha =  $this->session->userdata('captchaCode');
	         if($inputCaptcha === $sessCaptcha){
	        
	        
	        
	                  $this->form_validation->set_rules('ulbname', 'Name of the ULB', 'required');
	                  $this->form_validation->set_rules('districtname', 'District', 'required');
	                  $this->form_validation->set_rules('systemid', 'System id', 'required');
	                  $this->form_validation->set_rules('base_url', 'Department Url', 'required');
	                  $this->form_validation->set_rules('admin_concerned_person', 'concerned person', 'required');
	                  $this->form_validation->set_rules('admin_desigantion', 'Designation', 'required');
	                  $this->form_validation->set_rules('mobile', 'Mobile number', 'required|regex_match[/^[0-9]{10}$/]');
	                  $this->form_validation->set_rules('tech_concerned_person_name', 'Technical concerned person', 'required');
	                  $this->form_validation->set_rules('tech_concerned_person_designation', 'Designation', 'required');
	                  $this->form_validation->set_rules('tech_concerned_person_mobile', 'Mobile number', 'required|regex_match[/^[0-9]{10}$/]');
	                  $this->form_validation->set_rules('tech_concerned_person_email', 'Email id', 'required');
	                  $this->form_validation->set_rules('user_id', 'Admin username', 'required');
	                  $this->form_validation->set_rules('password', 'Admin password', 'required');
	                  $this->form_validation->set_rules('keywords', 'Related tags', 'required');
	                  $this->form_validation->set_rules('meta_desc', 'Description', 'required');
	                  $this->form_validation->set_rules('meta_subject', 'Subject', 'required');
                      if ($this->form_validation->run() == FALSE)
                      {
                      //$this->session->set_flashdata('errors', validation_errors());
                      //redirect('add-new-site'); 
                      }
                      else
                      {
	        
	        $params=array(
	            'theme_id'=>'1',
	            'ulbname'=>$this->security->xss_clean(trim(strip_tags($this->input->post('ulbname')))),
	            'distid'=>$this->security->xss_clean(trim(strip_tags($this->input->post('districtname')))),
	            'ulbid'=>$this->security->xss_clean(trim(strip_tags($this->input->post('systemid')))),
	            'base_url'=>$this->security->xss_clean(trim(strip_tags($this->input->post('base_url')))),
	            'concerned_person'=>$this->security->xss_clean(trim(strip_tags($this->input->post('admin_concerned_person')))),
	            'designation'=>$this->security->xss_clean(trim(strip_tags($this->input->post('admin_desigantion')))),
	            'mobile'=>$this->security->xss_clean(trim(strip_tags($this->input->post('mobile')))),
	            'tech_concerned_person_name'=>$this->security->xss_clean(trim(strip_tags($this->input->post('tech_concerned_person_name')))),
	            'tech_concerned_person_designation'=>$this->security->xss_clean(trim(strip_tags($this->input->post('tech_concerned_person_designation')))),
	            'tech_concerned_person_mobile'=>$this->security->xss_clean(trim(strip_tags($this->input->post('tech_concerned_person_mobile')))),
	            'tech_concerned_person_email'=>$this->security->xss_clean(trim($this->input->post('tech_concerned_person_email'))),
	            'keywords'=>$this->security->xss_clean(trim(strip_tags($this->input->post('keywords')))),
	            'description'=>$this->security->xss_clean(trim(strip_tags($this->input->post('meta_desc')))),
	            'subject'=>$this->security->xss_clean(trim(strip_tags($this->input->post('meta_subject'))))
	            );
	            $userdetails=array(
	                'user_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('user_id')))),
	                'password'=>$this->security->xss_clean(sha1(md5(trim(strip_tags($this->input->post('password')))))),
	                'author'=>$this->security->xss_clean(trim($this->session->userdata('userid'))),
	                'user_category'=>1, 
	                'ulb_type'=>2
	                );
	           // print_r($userdetails);
	           // exit
	            $result = $this->AddnewsiteModel->configureSite($params,$userdetails);
	            $this->session->set_flashdata('message',"<div class='alert alert-danger'>site created successfully</div>");
	           // redirect('add-new-site');
	            redirect('view-existing-sites');
	           //redirect('permission-page');
	           
	           // if($result)
	           // {
	           //    //  $this->session->set_flashdata('message','site created successfully');
	           //     redirect('permission-page');
	           // }
	        
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
	    
	    
	    
	   $params=array('ulbid'=>$this->session->userdata('ulbid'));
	   $data['designationList']=$this->CreaUlbUserModel->getDesignations($params);
	   $data['destrictList']=$this->AddnewsiteModel->getDistricts();
	   
	    
	  
	   
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('addnewsite',$data);
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
	
	public function edit_newsite()
	{
	    $ulbid=$this->security->xss_clean(trim($this->uri->segment('2')));
	   
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
	    $data['ulblist']=$this->AddnewsiteModel->getulblist();
	    $data['existedSiteList']=$this->AddnewsiteModel->getexistedsitelist();
	    $data['theme_list']=$this->AddnewsiteModel->themelist();
	  
	    $data['edit_sites']=$this->AddnewsiteModel->edit_site($ulbid);
	  // print_r($data1); exit;
	    
	    
	   $params=array('ulbid'=>$this->session->userdata('ulbid'));
	   $data['designationList']=$this->CreaUlbUserModel->getDesignations($params);
	   $data['destrictList']=$this->AddnewsiteModel->getDistricts();
	   
	    
	  
	   
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('edit_new_site',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	public function update_add_new_site(){
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	       $ulb=$this->security->xss_clean(trim(strip_tags($this->input->post('ulb'))));
	       
	     if($this->input->post('save'))
	     
	    {
	        
	         $params=array(
	            'theme_id'=>'1',
	            'ulbname'=>$this->security->xss_clean(trim(strip_tags($this->input->post('ulbname')))),
	            'distid'=>$this->security->xss_clean(trim(strip_tags($this->input->post('districtname')))),
	            'ulbid'=>$this->security->xss_clean(trim(strip_tags($this->input->post('systemid')))),
	            'base_url'=>$this->security->xss_clean(trim(strip_tags($this->input->post('base_url')))),
	            'concerned_person'=>$this->security->xss_clean(trim(strip_tags($this->input->post('admin_concerned_person')))),
	            'designation'=>$this->security->xss_clean(trim(strip_tags($this->input->post('admin_desigantion')))),
	            'mobile'=>$this->security->xss_clean(trim(strip_tags($this->input->post('mobile')))),
	            'tech_concerned_person_name'=>$this->security->xss_clean(trim(strip_tags($this->input->post('tech_concerned_person_name')))),
	            'tech_concerned_person_designation'=>$this->security->xss_clean(trim(strip_tags($this->input->post('tech_concerned_person_designation')))),
	            'tech_concerned_person_mobile'=>$this->security->xss_clean(trim(strip_tags($this->input->post('tech_concerned_person_mobile')))),
	            'tech_concerned_person_email'=>$this->security->xss_clean(trim($this->input->post('tech_concerned_person_email'))),
	            'keywords'=>$this->security->xss_clean(trim(strip_tags($this->input->post('keywords')))),
	            'description'=>$this->security->xss_clean(trim(strip_tags($this->input->post('meta_desc')))),
	            'subject'=>$this->security->xss_clean(trim(strip_tags($this->input->post('meta_subject'))))
	            );
	            
	       // print_r($params);
	       // exit;
	         
	         $result=$this->AddnewsiteModel->update_site_configure($params,$ulb);
	         
	         if($result)
	            {
	                redirect('view-existing-sites');
	            }
	    }
	    else
	    {
	        redirect('view-existing-sites');
	    }
	    
	    
	    } else {
	        redirect('login');
	    }
	    
	    
	}
}
