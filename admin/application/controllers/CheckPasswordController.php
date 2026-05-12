<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class CheckPasswordController extends MY_Controller {

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
	     $this->load->model('DashboardModel');
	     $this->load->model('CheckPasswordModel');
		   $this->load->library('form_validation');
		  $this->load->helper('security_helper');
	}
	 	 
	public function updatePassword(){
		
		if($this->session->userdata('session_id')==session_id())
	    {
			if($this->input->post('submit'))
			{
			   
				
				$password=$this->security->xss_clean($this->input->post('password'));
				$confirm_password=$this->security->xss_clean($this->input->post('confirm_password'));
				$old_password=$this->security->xss_clean($this->input->post('old_password'));
				
				$inpOldPassword=$this->input->post('old_password');
				$inpPassword=$this->input->post('password');
				$inpConfPassword=$this->input->post('confirm_password');
				
				
				$decryptOldPwd=decryptData($inpOldPassword);
				$decryptPwd=decryptData($inpPassword);
				$decryptCnfPwd=decryptData($inpConfPassword);
					
				
				if (!is_valid_password($decryptPwd)) {
					$this->session->set_flashdata('message', "<div class='alert alert-danger'>Password must be at least 8 characters long and include at least one uppercase letter, one number, and one special character.!</div>");
					return redirect('change-password');
				} 
					//echo "<pre>";print_r($decryptCnfPwd);die(); 
				
				
				if(!is_valid_password($decryptOldPwd)){
					$this->session->set_flashdata('message', "<div class='alert alert-danger'>Your old password does not match!</div>");
					return redirect('change-password');
				}
					
				if(!is_valid_password($decryptCnfPwd)){
					$this->session->set_flashdata('message', "<div class='alert alert-danger'>Confirm password does not match!</div>");
					
					return redirect('change-password');
				} 
				
				$olduserdetails=array(             
				   'user_pwd'=>sha1(md5($decryptOldPwd)),
				   'user_id'=>$this->session->userdata('userid'),
					'author'=>$this->session->userdata('userid')
				
				);  
				
				$userdetails=array(             
				   'user_pwd'=>sha1(md5($decryptPwd)),
				   'user_id'=>$this->session->userdata('userid'),
					'author'=>$this->session->userdata('userid')            
				);
						
				
				$user_id = $this->session->userdata('userid');
		   
			
		   //echo "<pre>";print_r($user_id);die(); 
				  
	   
			  $oldresult=$this->CheckPasswordModel->checkUserOldPwd($olduserdetails,$user_id);
				
			  
				if(!$oldresult){
					//echo "<script>alert('Your old password does not matched!'); window.location='" . $_SERVER['PHP_SELF'] . "';</script>";
					//exit;
					
					$this->session->set_flashdata('message', "<div class='alert alert-danger'>Your old password does not match!</div>");

					  redirect('change-password');
				}
			  
				$result=$this->CheckPasswordModel->createUser($userdetails,$user_id);
			  
			  
				if($result){
					$this->session->sess_destroy();
					
					$this->LoginModel->update_session_id($user_id, $session_id='');
					
					echo "<script>alert('Your password has been successfully updated!'); window.location='/admin/';</script>";
					exit;
					 // redirect(base_url());
				} else{
					  redirect('change-password');
				}
			}
		}
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
	    $ulb_list=$this->DashboardModel->ulb_list();
	    
	    foreach($ulb_list->result() as $key=>$val)
	    {
	        $this->DashboardModel->add_user($val);
	    }
	    	   	
		
		$secret_key_iv=$this->secretKeyIv();
		
		//echo "<pre>";print_r($secret_key_iv['key']);echo "</pre>";die();
		
		$data2 = [
			'result' => $result,
			'key' => $secret_key_iv['key'],
			'iv' => $secret_key_iv['iv']
		];
		
		if (!$this->session->userdata('form_nonce')) {
            $nonce = bin2hex(random_bytes(16));
            $this->session->set_userdata('form_nonce', $nonce);
        } else {
            $nonce = $this->session->userdata('form_nonce');
        }

        $data['form_nonce'] = $nonce;
		
	    $this->load->view('header',$data);
		$this->load->view('checkpassword',$data2);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('/');
	    }
	}
	
	public function secretKeyIv() {
		$key = "1234567890123456";     // same as JS
		$iv  = "abcdefghijklmnop";     // same as JS
		
		$data=array(
		'key'=>$key,
		'iv'=>$iv
		);
		return $data;
	}
	
	public function encrypt_text($plain_text, $secretKey) {
		// Generate an encryption key from the secretKey
		$key = hash('sha256', $secretKey, true);
		
		// Define the cipher method (AES-256-CBC)
		$cipher_method = 'AES-256-CBC';
		
		// Generate an initialization vector (IV) for encryption (must be random and 16 bytes for AES-256-CBC)
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
		
		// Encrypt the text
		$encrypted_text = openssl_encrypt($plain_text, $cipher_method, $key, 0, $iv);
		
		// Return the encrypted text along with the IV (IV is needed for decryption)
		return base64_encode($encrypted_text . '::' . $iv);
	}


	//decrypt
	public function decrypt_text($encrypted_text, $secretKey) {
		// Extract the encrypted data and IV from the encoded string
		list($encrypted_data, $iv) = explode('::', base64_decode($encrypted_text), 2);
		
		// Generate the same encryption key from the secretKey
		$key = hash('sha256', $secretKey, true);
		
		// Define the cipher method (AES-256-CBC)
		$cipher_method = 'AES-256-CBC';
		
		// Decrypt the text
		$decrypted_text = openssl_decrypt($encrypted_data, $cipher_method, $key, 0, $iv);
		
		return $decrypted_text;
	}
	
	/** 🔒 Central nonce verification method */
    private function _verify_nonce()
    {
        $nonce_post    = $this->input->post('form_nonce');
        $nonce_session = $this->session->userdata('form_nonce');

        if (empty($nonce_post) || $nonce_post !== $nonce_session) {
            $this->session->set_flashdata('error', 'Invalid or reused submission!');
            redirect($_SERVER['HTTP_REFERER'] ?? 'change-password');
            exit;
        }

        // destroy nonce to prevent reuse
        $this->session->unset_userdata('form_nonce');
    }
}
