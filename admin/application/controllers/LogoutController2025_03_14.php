<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogoutController extends CI_Controller {

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
			$this->db->delete('user_sessions');
					
    		
	    }
	    //session_regenerate_id();
	    
		//$this->LoginModel->user_id(); 
		 /*$login_logo = array(
                    'user_id' => $this->session->userdata('username'),
                    'log_type' => 2,
                    'ip' => $_SERVER['SERVER_ADDR']
                    );
	               $this->db->insert('login_logs', $login_logo);*/

				//    $login_logo = array(
                //     'user_id' => $this->session->userdata('username'),
				// 	'uniqcode' => $uniqueValue,
                //     'status' => 1
                //     //'ip' => $_SERVER['SERVER_ADDR']
                //     );
	            //    $this->db->insert('user_log', $login_logo);
	   
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
			$this->db->where('ip_address', $ip);
			$this->db->delete('user_sessions');	
			$this->session->set_flashdata('error_message', "<div class='alert alert-success'>Successfully logged out...</div>");
				
	    }
	    	   
		redirect();
	}
	
	/*public function index()
{
    $uniqueValue = $this->generateUUID();
    
    if ($this->session->userdata('session_id')) {
        $status = 1;

        if ($status == 0) {
            // Get user ID from the session
            $id = $this->session->userdata('session_id');

            // Insert data into 'user_log' table
            $data = array(
                'user_id' => $id,
                'uniqcode' => $uniqueValue,
                'status' => $status
            );

            // Assuming you have a 'user_log' table in your database
            $this->db->insert('user_log', $data);
        }

        $this->session->sess_destroy();
        unset($_COOKIE['PHPSESSID']);
    }

    // Redirect to the home page or any other page as needed
    redirect();
}

// Function to generate UUID
private function generateUUID()
{
    if (function_exists('uuid_create')) {
        $uuid = uuid_create(UUID_TYPE_RANDOM);
        return uuid_to_str($uuid);
    } else {
        // Fallback if uuid_create is not available (PHP < 7.2)
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}*/

	public function changePassword(){
	    $password = $this->input->post('password');
	    echo $base_password = base64_encode($password);
	}
}
