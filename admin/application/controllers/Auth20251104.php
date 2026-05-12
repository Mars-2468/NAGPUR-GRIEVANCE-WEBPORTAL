<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct()
	 {
	     Parent::__construct();
	     $this->load->model('LoginModel');
	     // Load session library
        $this->load->library('session');
        //   $this->load->helper('cookie');
        
        // Load the captcha helper
        $this->load->helper('captcha');
      
      	$this->db->database();
	 }
	 
    public function logout_on_close() {
		
		$user_id = $this->session->userdata('userid');
	
		$this->session->sess_destroy(); // Destroy session
		unset($_COOKIE['PHPSESSID']);	
		// Delete the session record from the database
		$this->db->where('user_id', $user_id);
		//$this->db->delete('user_sessions');
		$this->db->update('user_sessions', ['session_id' => '']);	
		redirect('/');
		//  exit(); // Ensure no extra output
	  
    }
	
	public function check_session() {
		
		$this->db->database();
		$user_id = $this->session->userdata('userid');
		
		//$this->db->where('user_id', $user_id)->where('ip_address', $ip_address); 
		//$query =$this->db->get('user_sessions');
		
		if (!$this->session->userdata('user_id') || (time() - $this->session->userdata('last_activity') > 3600)) {
			
			$this->session->sess_destroy();
    		unset($_COOKIE['PHPSESSID']);	
			// Delete the session record from the database
			$this->db->where('user_id', $user_id);
			//$this->db->delete('user_sessions');
			$this->db->update('user_sessions', ['session_id' => '']);	
			redirect('/');
			
			echo "expired";
			
		} else {
			
			echo "active";
			
		}
		
	}

}
?>
