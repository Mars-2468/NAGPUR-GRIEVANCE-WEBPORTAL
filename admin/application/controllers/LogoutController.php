<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogoutController extends MY_Controller {

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
	    $this->load->model('LoginModel');
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->load->database();
	    
	 }
	public function index()
	{
		
		$user_id = $this->session->userdata('userid');
	  
	 // var_dump(site_url('logout'));die();
	    
		if($user_id)
	    {		
	
			$this->session->sess_destroy();
    		unset($_COOKIE['PHPSESSID']);	
			// Delete the session record from the database
			$this->db->where('user_id', $user_id);
			//$this->db->delete('user_sessions');
			$this->db->update('user_sessions', ['session_id' => '']);	

			$session_cookie = $this->config->item('sess_cookie_name');
			if ($session_cookie) {
				delete_cookie($session_cookie);
			}

			// 3) Delete CSRF cookie (if you use CSRF cookie)
			$csrf_cookie = $this->config->item('csrf_cookie_name');
			if ($csrf_cookie) {
				delete_cookie($csrf_cookie);
			}			
    		
	    }
		   
		redirect();
	}
	
	public function forceLogout($user_id,$ip)
	{

		$existing_session = $this->db->where('user_id', $user_id)->where('ip_address', $ip)->get('user_sessions')->row();
  
		//echo "<pre>";print_r($existing_session);echo "</pre>";die();	
	    
		if(!empty($existing_session))
	    {	
					
			$this->session->sess_destroy();
    		unset($_COOKIE['PHPSESSID']);	
			// Delete the session record from the database
			$this->db->where('user_id', $user_id);
			//$this->db->where('ip_address', $ip);
			//$this->db->delete('user_sessions');	
			 $this->db->update('user_sessions', ['session_id' => '']);
			$this->session->set_flashdata('error_message', "<div class='alert alert-success'>Successfully logged out...</div>");
				
	    }
	    	   
		redirect();
	}

	public function changePassword(){
	    $password = $this->input->post('password');
	    echo $base_password = base64_encode($password);
	}
}
