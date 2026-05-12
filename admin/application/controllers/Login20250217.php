<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
	 * 
	 * 
	 */
	 
	 public function __construct()
	 {
	     Parent::__construct();
	     $this->load->model('LoginModel');
	     // Load session library
        $this->load->library('session');
        //   $this->load->helper('cookie');
        
        // Load the captcha helper
        $this->load->helper('captcha');
      
      
	 }public function insert_hash(){
	     $gen_hash = $this->input->post('gen_string');
	     $gen_hash1 = $this->input->post('gen_string1');
	     $ran = $this->input->post('ran');
	     
	     $params = array(
	      'length' => $ran,
	      'hash1' => $gen_hash,
	      'hash2' => $gen_hash1,
	      'ts' => date('Y-m-d H:i:s'),
	      );
	     $result =$this->LoginModel->insert_hash($params);
	     echo $result;
	 }
	 
	 
	public function index()
	{	//echo "hi"; exit;
	    //session_regenerate_id(true);
	   
	    if($this->session->userdata('session_id') == session_id())
	    {
	        redirect('dashboard');
	    }else{
	        if($this->session->userdata('session_id'))
    	    {
    	       
    	        
    		    $this->session->sess_destroy();
    		    $this->session->set_flashdata('error_message',"<div class='alert alert-danger'>Session Expired</div>");
    		    
    		    $uniqUserSession=rand(1000,222222);
    		    $params = array('user_id'=>'','query'=>$uniqUserSession,'status'=>0);
    		    
    		    
    		    
    		    $result = $this->LoginModel->insertUniqueId($params);
    		    //redirect('login');
    	    }
	    }
	    
	    
	     $this->session->set_userdata('logged_in', TRUE);
	    
	    
	    if($this->input->post('submit'))
	    {
	        
	         $this->input->post('password');
	       // exit;
	      $inputCaptcha = $this->input->post('captcha');
          $recaptchaResponse = $this->input->post('g-recaptcha-response');
 
	      //echo $recaptchaResponse;exit;
          $userIp=$this->input->ip_address();
     
          $secret = $this->config->item('google_secret');
   
         /* $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
 
          $ch = curl_init(); 
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
          $output = curl_exec($ch); 
          curl_close($ch);      
             
          $status= json_decode($output, true);*/
        //   if ($status['success'])
          if (1)
          {
        
            $str1 = str_replace(' ', '', htmlspecialchars(strip_tags($this->input->post('password'))));
			
            $len = $str1[0];
            $hash1 = substr($str1,1,$len);
            $hash2 = substr($str1, -$len);
            $password1 = substr($str1, $len+1);
            $password = substr($password1, 0 , -$len);
            
            // echo $password;
            // exit;
            
            $hashparm = array($hash1, $hash2,$len);
          
            $hash_result =$this->LoginModel->checkhashvalues($hashparm);
            //  print_r($hashparm);die;
            if(count($hash_result) > 0){
                $hashparm1 = array(
                   'hash1'=> $hash1,
                   'hash2'=>$hash2,
                   'length'=>$len,
                );
                $this->db->truncate('login_hash_check');
                
                // $hahs_del_result =$this->LoginModel->delhashvalues($hashparm1);
                //  print_r($hashparm1);die;
            }else{
                $this->session->set_flashdata('error_message',"<div class='alert alert-danger'>Invalid username or password!</div>");
                redirect('/');
            }
            
               
	        $params=array(
	            'username'=>$this->security->xss_clean(trim(strip_tags($this->input->post('username')))),
	            'password'=> $password
	            );
	            
	       // $chkUniqParams = array('query'=>$this->security->xss_clean(trim(strip_tags($this->input->post('uniqs')))),'status'=>0);
	        
	       // $result =$this->LoginModel->checkSessionUniqepaams($chkUniqParams);
	         
	         //$params111 =$uniqs;
	       //  if(count($result)<= 0)
	       //  {
	       //      $this->session->set_flashdata('error_message',"<div class='alert alert-danger'>Invalid username or password entry failed</div>");
	            
	       //      $this->LoginModel->deleteSessionUniqepaams();
	             
	       //      redirect('/');
	       //  }
	       //  else
	       //  {
	             
	       //      $this->LoginModel->deleteSessionUniqepaams();
	             
	             
	       //  }
	         
	         
	            
	           
	            $data=$this->LoginModel->loginCheck($params);
				//echo $this->db->last_query();
	            
               //  print_r($data);die;
	            if($data['result']=='0')
	            {
	                
	                $ip = $this->input->ip_address();
	    $url= "http://www.geoplugin.net/json.gp?ip=" . $ip;
  
                // Use JSON encoded string and converts
                // it into a PHP variable
                $ipdat = @json_decode(file_get_contents(
                    "http://www.geoplugin.net/json.gp?ip=" . $ip));
                    
                    
                   
               // Initialize a CURL session.
                        $ch = curl_init();
                         
                        // Return Page contents.
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                         
                        //grab URL and pass it to the variable.
                        curl_setopt($ch, CURLOPT_URL, $url);
                         
                        /*$result = curl_exec($ch);
                        $result =json_decode($result);
                        $result->geoplugin_countryName;
                         
                       
	    
	    $login_logo = array(
                    'ip' => $_SERVER['SERVER_ADDR'],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'username'=>$this->security->xss_clean(trim(strip_tags($this->input->post('username')))),
                    'session_id'=>session_id(),
                    'refr'=>$_SERVER['REQUEST_URI'],
                    'process_id'=>sha1(rand(1000,99999)),
                    'user_agent'=>$this->agent->browser(),
                    'url'=>$_SERVER['HTTP_REFERER'],
                    'country'=>$result->geoplugin_countryName,
                    'attempt_status'=>'Fail'
                    
                    );
                    
                    
	               $this->db->insert('userlogs', $login_logo);*/
	                $params111 = array('query'=>$this->security->xss_clean(trim(strip_tags($this->input->post('uniqs')))));
	            
	            
	                
	                $this->session->set_flashdata('error_message',"<div class='alert alert-danger'>Invalid username or password.</div>");
	            }
	            else
	            {
	                
	                
	                $ip = $this->input->ip_address();
	    /*$url= "http://www.geoplugin.net/json.gp?ip=" . $ip;
  
                // Use JSON encoded string and converts
                // it into a PHP variable
                $ipdat = @json_decode(file_get_contents(
                    "http://www.geoplugin.net/json.gp?ip=" . $ip));
                    
                    
                   
               // Initialize a CURL session.
                        $ch = curl_init();
                         
                        // Return Page contents.
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                         
                        //grab URL and pass it to the variable.
                        curl_setopt($ch, CURLOPT_URL, $url);
                         
                        $result = curl_exec($ch);
                        $result =json_decode($result);
                        $result->geoplugin_countryName;
                         
                       
	    
	    $login_logo = array(
                    'ip' => $_SERVER['SERVER_ADDR'],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'username'=>$this->security->xss_clean(trim(strip_tags($this->input->post('username')))),
                    'session_id'=>session_id(),
                    'refr'=>$_SERVER['REQUEST_URI'],
                    'process_id'=>sha1(rand(1000,99999)),
                    'user_agent'=>$this->agent->browser(),
                    'url'=>$_SERVER['HTTP_REFERER'],
                    'country'=>$result->geoplugin_countryName,
                    'attempt_status'=>'Success'
                    
                    );
                    
                    
	               $this->db->insert('userlogs', $login_logo);*/
	            
	             
	            
	             $a = $this->LoginModel->deleteSessionUniqepaams();
	             
	             
	                
	                $this->session->set_userdata(array( 
	                    'userid'=>$data['object']['user_id'],
	                    'username'=>$data['object']['user_name'],
	                    'user_type'=>$data['object']['user_type'],
	                    'ulbid'=>$data['object']['ulbid'],
	                    'banner'=>$data['object']['banner'],
	                    'langId'=>1,
	                    'user_category'=>$data['object']['user_category'],
	                    'is_custom_user'=>$data['object']['is_custom_user'],
	                    'base_url'=>$data['object']['base_url'],
	                    'session_id'=>session_regenerate_id(true)
	                    ));
	               $params=array('ulbid'=>$data['object']['ulbid']);
	               
	               if($data['object']['user_type'] !=='A')
	               {
	               $data=$this->LoginModel->ulbDetails($params);
	               $this->session->set_userdata(array(
	                    'ulbname'=>$data['ulbname'],
	                    'ulbtype'=>$data['ulb_type_desc']));
	               }
	               else
	               {
	                    $this->session->set_userdata(array(
	                    'ulbname'=>'Superadmin',
	                    'ulbtype'=>''));
	               }
	                
	               $login_logo = array(
                    'user_id' => trim(strip_tags($this->input->post('username'))),
                    'log_type' => 1,
                    'ip' => $_SERVER['SERVER_ADDR']
                    );
	               $this->db->insert('login_logs', $login_logo);
	               
	               // if language id not set setting default language id as 'english'
	               if(!$this->session->userdata('btncolor'))
	               {
	                   $this->session->set_userdata('btncolor','1');
	               }
	                redirect('dashboard');
	            }
	       }
	       else
	       {
	           $this->session->set_flashdata('error_message',"<div class='alert alert-danger'>Captcha Not done, please try again. </div>");
	       }
	       
	       //$inputCaptcha = $this->input->post('captcha');
        //   $sessCaptcha = $this->session->userdata('captchaCode');  
           
        //   if($inputCaptcha === $sessCaptcha){
               
	       // $params=array(
	       //     'username'=>$this->input->post('username'),
	       //     'password'=> (sha1($this->input->post('fk')))
	       //     );
	           
	       //     $data=$this->LoginModel->loginCheck($params);
        //         //print_r($data);exit;
	       //     if($data['result']=='0')
	       //     {
	       //         $this->session->set_flashdata('error_message',"<div class='alert alert-danger'>Invalid username or password</div>");
	       //     }
	       //     else
	       //     {
	       //         session_regenerate_id(true);
	                
	       //         setcookie("PHPSESSID", session_id(), time() + (60*60*24*10),
        //                         true  // this is the httpOnly flag you need to set
        //                     );
	                
	       //         $this->session->set_userdata(array( 
	       //             'userid'=>$data['object']['user_id'],
	       //             'username'=>$data['object']['user_name'],
	       //             'user_type'=>$data['object']['user_type'],
	       //             'ulbid'=>$data['object']['ulbid'],
	       //             'banner'=>$data['object']['banner'],
	       //             'langId'=>1,
	       //             'user_category'=>$data['object']['user_category'],
	       //             'is_custom_user'=>$data['object']['is_custom_user'],
	       //             'base_url'=>$data['object']['base_url'],
	       //             'session_id'=>session_regenerate_id(true)
	       //             ));
	       //        $params=array('ulbid'=>$data['object']['ulbid']);
	               
	       //        if($data['object']['user_type'] !=='A')
	       //        {
	       //        $data=$this->LoginModel->ulbDetails($params);
	       //        $this->session->set_userdata(array(
	       //             'ulbname'=>$data['ulbname'],
	       //             'ulbtype'=>$data['ulb_type_desc']));
	       //        }
	       //        else
	       //        {
	       //             $this->session->set_userdata(array(
	       //             'ulbname'=>'Superadmin',
	       //             'ulbtype'=>''));
	       //        }
	                
	       //        $login_logo = array(
        //             'user_id' => $this->input->post('username'),
        //             'log_type' => 1,
        //             'ip' => $_SERVER['SERVER_ADDR']
        //             );
	       //        $this->db->insert('login_logs', $login_logo);
	               
	       //        // if language id not set setting default language id as 'english'
	       //        if(!$this->session->userdata('btncolor'))
	       //        {
	       //            $this->session->set_userdata('btncolor','1');
	       //        }
	               
	       //         redirect('dashboard');
	       //     }
	       //}
	       //else
	       //{
	       //    $this->session->set_flashdata('error_message',"<div class='alert alert-danger'>Captcha code does not match, please try again. </div>");
	       //}
	    }
	    
	    $config = array(
            'img_path'      => 'assets/captcha_images/',
            'img_url'       => base_url().'assets/captcha_images/',
            'font_path'     => 'system/fonts/texb.ttf',
            'img_width'     => '200',
            'img_height'    => 50,
            'expiration'    => 3600,
            'word_length'   => 3,
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
        $data_cap['captchaImg'] = $captcha['image'];
        $data_cap['uniqstring'] = $captcha['image'];
        
        
        $rand_number=rand(5,9);
        $hash1 = $this->generateRandomString($rand_number);
        $hash2 = $this->generateRandomString($rand_number);
        $data_cap['hash1'] = $hash1;
        $data_cap['hash2'] = $hash2;
        $data_cap['length'] = $rand_number;
       
    	$params = array(
    	    'length'=>$rand_number,
    	    'hash1'=>$hash1,
    	    'hash2' => $hash2,
    	    'ts'=>date('Y-m-d H:i:s'),
    	    );
    	
    	$result = $this->LoginModel->insertUniqueId($params);
	    
		$this->load->view('login',$data_cap);
	    
	}
	
	public function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
	
	public function getCaptcha(){
	    
	    $captcha_reload = $this->input->post('captcha_reload');
	    if($captcha_reload=='Reload'){
            $digits='4';
            $i = 0; 
            $pin = ""; 
            while($i < $digits){
                $pin .= mt_rand(0, 9);
                $i++;
            }
            echo  $pin;
        
        }
	}
	
	public function changePassword(){
	    $password = $this->input->post('password');
	    echo $base_password = base64_encode($password);
	}
	
	public function refresh(){
        // Captcha configuration
        $config = array(
            'img_path'      => 'assets/captcha_images/',
            'img_url'       => base_url().'assets/captcha_images/',
            'font_path'     => 'system/fonts/texb.ttf',
            'img_width'     => '200',
            'img_height'    => 50,
            'expiration'    => 3600,
            'word_length'   => 3,
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
