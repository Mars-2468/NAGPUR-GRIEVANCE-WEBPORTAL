<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
class CreatepageController extends MY_Controller {

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
	    $this->load->model('CreatepageModel');
	    $this->load->model('ViewAlbumModel');
	    $this->load->library('form_validation');
	    
	   // Load the captcha helper
        $this->load->helper('captcha');
     
	    $this->load->model('CustomModel');
		
	    
	 }
	 
	 
	 
	 public function is_existingPagename($pagename,$ulbid)
	 {
	     
	     
	      if($this->session->userdata('session_id')==session_id())
    	    {
    	        
    	        if(($pagename != '') && ($ulbid !=''))
    	        {
    	        $pagename=$this->security->xss_clean(trim($pagename));
    	        $ulbid=$this->security->xss_clean(trim($ulbid));
    	     
    	     $params=array('controller'=>$pagename,'ulbid'=>$ulbid);
    	     $result=$this->CreatepageModel->is_existingPagename($params);
    	     return $result[0]['count'];
    	        }
    	        else
    	        {
    	            die('Invalid Details');
    	        }
    	     
    	    }
    	    else
    	    {
    	        redirect('/');
    	    }
	 }
	 
	 
	 public function input_check($str){
	     if (ctype_alnum($str)) {
            return true;
        }else{
            // $this->form_validation->set_message('input_check' ,'Please Enter a Valid Input');
            // return false;
              return true;
        }
	 }
	 
	 
	 
	public function addPageRecord(){
				
		if($this->session->userdata('session_id')==session_id())
	    {
			
			$this->_verify_nonce();
						
			$this->form_validation->set_rules('pagename', 'Page Name', 'required|callback_input_check|xss_clean');
			$this->form_validation->set_rules('hover_title', 'Hover Title', 'required|xss_clean');
			$this->form_validation->set_rules('ptags', 'Tags', 'required|xss_clean');
			$this->form_validation->set_rules('meta_desc', 'Description', 'required|xss_clean');
			$this->form_validation->set_rules('meta_subject', 'Subject', 'required|xss_clean');
	    
			if($this->input->post('save') || $this->input->post('is_draft'))
			{
			   $inputCaptcha = $this->input->post('captcha');
			   //$sessCaptcha = $this->session->userdata('captchaCode');
			   $sessCaptcha = $this->input->post('session_captcha'); 
			   
				if($inputCaptcha == $sessCaptcha){
					
					
					$db = get_instance()->db->conn_id;
					
					//$content=$this->input->post('content');
					$content=$_POST['content'];
					$replaceUrl="../";
					$content=str_replace($replaceUrl,'/',$content);
					$replaceUrl="//assets";
					$content=str_replace($replaceUrl,'/assets',$content);
					$content=str_replace("'",' ',$content);
					
					if($this->session->userdata('langId')=='1')
					{
					$pagename=substr(strtolower(trim($this->security->xss_clean(preg_replace('/[^A-Za-z0-9_]/', ' ', htmlspecialchars(strip_tags($this->input->post('pagename'))))))),0,60);
					}
					else
					{
						// if content in telugu creatinig hashed urls
						$pagename=rand(1,10000);
						 $pagename=substr(md5($pagename),0,60);
					}
					
					$pagename=preg_replace("![^a-z0-9]+!i", "-", $pagename);
					$pagename2=preg_replace("![^a-z0-9]+!i", "-", $pagename);
					
					//$pagename=str_replace(" ", "-", $pagename); // replacing spaces with hypens in url
					//$pagename2=str_replace(" ", "-", $pagename);
					
					$pagename3=preg_replace('/\s+/', "-", $pagename2); // replacing spaces with hypens in url
					$pagename2=preg_replace('/\s+/', "-", $pagename3);
					
					//preg_replace('/\s+/', '_', $journalName);
					
					$this->form_validation->set_rules('pagename', 'Page Name', 'trim|required|callback_input_check');
					$this->form_validation->set_rules('pagetitle', 'pagetitle', 'trim|required|callback_input_check');
					$this->form_validation->set_rules('ptags', 'ptags', 'trim|required|callback_input_check');
					
						  $this->form_validation->set_rules('hover_title', 'Hover Title', 'required|callback_input_check');
						  
							$this->form_validation->set_rules('meta_desc', 'Description', 'required|callback_input_check');
							$this->form_validation->set_rules('meta_subject', 'Subject', 'required|callback_input_check');
					// $this->form_validation->set_rules('content', 'content', 'alpha_dash|trim|required');
										
					 if ($this->form_validation->run() == FALSE)
						{
							// $this->session->set_flashdata('Error', validation_errors());
								// redirect(base_url());
								//$this->load->view('myform');
						}
						else
						{
					   // $site_controller=$pagename2."/".$this->session->userdata('ulbid');
					   $portal_url=$this->CustomModel->getPortalUrl($this->session->userdata('ulbid'));
					   //$site_controller=$this->session->userdata('ulbid')."/".$pagename2;
					   $site_controller=$pagename2;
						$result=$this->is_existingPagename($pagename,$this->session->userdata('ulbid'));
						if($result > 0)
						{
							
							$pagename=$pagename.time();
							$pagename2=$pagename2.time();
							//$site_controller=$this->session->userdata('ulbid')."/".$pagename2; 
							$site_controller=$pagename2; 
						}
					
					 $permalink=$portal_url['base_url'].$site_controller; // creating permallinks
					 $this->session->set_flashdata('permalink',$permalink);
					 
					 // set default side 
				   //$captc = $this->input->post('captc');
				   //$captcha = $this->input->post('captcha');
					
					$content_new = $_POST['content'];

					// 1. Remove <script> tags completely
					//$content_new = preg_replace('#<script\b[^>]*>(.*?)</script>#is', '', $content_new);

					// 2. Extra safety: remove standalone <script ...> tags (without closing tag)
					//$content_new = preg_replace('#<script\b[^>]*>#is', '', $content_new);

					// 3. Use CodeIgniter XSS clean (very important)
					//$content_new = $this->security->xss_clean($content_new);
						
						$params=array(
					   'ulbid'=>$this->session->userdata('ulbid'),
					 //  'content'=> $this->security->xss_clean(trim(htmlspecialchars(strip_tags($_POST['content_new'])))),
					   'controller'=>$pagename,
					   'is_draft'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('is_draft')))))),
					   'page_name'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagename'))))),
					   'page_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('pagetitle'))))),
					   'pagekeywords'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('ptags'))))),
					   'is_custumlink'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('is_custumlink')))))),
					   'permalink'=>htmlspecialchars(strip_tags($permalink)),
					   'langId'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->session->userdata('langId')))))),
					   'author'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->session->userdata('userid')))))),
					   'site_controller'=>htmlspecialchars(strip_tags($site_controller)),
					   'page_sidebars_id'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('layourid')))))),
					   'meta_desc'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_desc'))))),
					   'hover_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('hover_title'))))),
					   'meta_subject'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('meta_subject'))))),
					   'user_level'=>$this->security->xss_clean(trim(preg_replace('/[^A-Z]/', ' ', htmlspecialchars(strip_tags($this->session->userdata('user_type')))))),
					   'pageheading'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('pagename'))))))
					  );
					  
					  //print_r($params);
					   
						foreach($params as $key=>$param){
							if (preg_match('/<[^<]+>/', $param)) {
								$this->session->set_flashdata('error_message', "Error: HTML or script tag detected in ".$key." field!");
					
								redirect($_SERVER['HTTP_REFERER']);
								exit;
							}
						}
					   
					   $params['content']=$content_new;
					   
					   //print_r($params);
					   //exit;
						
						
					$data1=$this->CreatepageModel->customePageDataInsert($params);
					if($data1['result']=='1')
					{
						$pagename="'".$pagename."'";
						$configFilePath=$_SERVER['DOCUMENT_ROOT'].'/admin/application/config/routes.php'; // adding url in admin confing file
						$configFilePath2=$_SERVER['DOCUMENT_ROOT'].'/application/config/routes.php'; // adding url in site config
						$file=fopen($configFilePath,'a') or die('cannot append to file');
					
						$controllerNameNoextension='CustomePageController/getPageContent/'.$data['pageId'];
						$controller='$route['.$pagename.']='."'".$controllerNameNoextension."';";
						fwrite($file,"\n".$controller);
						fclose($file);						
						
						$pagename="'".$pagename2."'";
						
						$file=fopen($configFilePath2,'a') or die('cannot append to file');
					
						$controllerNameNoextension='CustomePageController/getPageContent/';
						 $controller='$route['.$pagename.']='."'".$controllerNameNoextension."';";
						fwrite($file,"\n".$controller);
						fclose($file);
						
						$this->session->set_flashdata('message','Page created successfully');
						redirect('view-pages');
						exit;
					}
					else
					{
						$this->session->set_flashdata('message','Unable to create page , Please try again');
						redirect($_SERVER['HTTP_REFERER'] ?? 'view-pages');
						exit;
					}
					
					}
					
				
				}else{
					$this->session->set_flashdata('message',"<div class='alert alert-danger'>Captcha code does not match, please try again. </div>");
					redirect($_SERVER['HTTP_REFERER'] ?? 'view-pages');
					exit;
			   } 
			}
		}
	}
	
	public function index()
	{  

		if (!in_array($this->session->userdata('userid'),super_dev_admin())) {
			$this->session->set_flashdata('error_message','Sorry you dont have permissions');
			//echo "Error: Sorry you don't have permissions!" ;
			redirect ('dashboard');
			exit;
		}
		
		 // Limit: 3 submissions per 60 seconds per IP+URI
       /*  $is_allowed=rate_limit_check(1, 60, 'createPage');
		
		//echo "<pre>";print_r($is_allowed);echo "</pre>";die();
		
		if (!$is_allowed) {
			$this->session->set_flashdata('error_message', "Too many requests. Please wait 60 seconds and try again(submission rate is limited to store 5 records within 60 seconds).!");
			
			redirect('create-page');
			exit;
		} */


	    if($this->session->userdata('session_id')==session_id())
	    {
				    
	    
	    
	    
	  $submenudata=array();
	    
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
	    $subMenus=$this->MenuModel->getSubMenu();
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    
	   
	   
	    
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    $data['sub_menus']=$submenudata;
	    
	    
	   
	    
	      
	    // gettin innper page sidbars and default sidebar id set by admin
	    
	    $layoutList=$this->MenuModel->getinnerpagelayouts($params);
	    //print_r($layoutList);exit;
	    foreach($layoutList as $key=>$val)
	    {
	        
	        if($val['superadmin_defautl_layout'] !='')
	        {
	            $data['defaultsidebar']=$val['superadmin_defautl_layout'];
	        }
	        
	            $data['layoutlists'][$val['sidebars_id']]=$val['sidebars_desc'];
	        
	        
	        
	    }
	    
		$config = array(
            'img_path'      => 'assets/captcha_images/',
            'img_url'       => base_url().'assets/captcha_images/',
            'font_path'     => base_url().'system/fonts/texb.ttf',
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
        
        // Pass captcha image to view
        // $data_cap['captchaImg'] = $captcha['image'];
        $data['captchaImg'] = $captcha['image'];
	    
// 		$this->load->view('createpage',$data_cap);
	        
	    
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $params = array('ulbid'=>$this->session->userdata('ulbid'),'status'=>1);
	    $data['create_media_data']=$this->ViewAlbumModel->createMediaData($params);
	   // $data_cap['captchaImg'] = $captcha['image'];
	    
		
		if (!$this->session->userdata('form_nonce')) {
            $nonce = bin2hex(random_bytes(16));
            $this->session->set_userdata('form_nonce', $nonce);
        } else {
            $nonce = $this->session->userdata('form_nonce');
        }

        $data['form_nonce'] = $nonce;
		
		
		
	    $this->load->view('header',$data);
   	    $this->load->view('createpage',$data);
	   // $this->load->view($data_cap);
		$this->load->view('divdata',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('/');
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
            'font_path'     => base_url().'system/fonts/texb.ttf',
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

	/** 🔒 Central nonce verification method */
    private function _verify_nonce()
    {
        $nonce_post    = $this->input->post('form_nonce');
        $nonce_session = $this->session->userdata('form_nonce');

        if (empty($nonce_post) || $nonce_post !== $nonce_session) {
            $this->session->set_flashdata('error', 'Invalid or reused submission!');
            redirect($_SERVER['HTTP_REFERER'] ?? 'view-pages');
            exit;
        }

        // destroy nonce to prevent reuse
        $this->session->unset_userdata('form_nonce');
    }
	
}
