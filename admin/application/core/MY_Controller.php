<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
		
		// ✅ Allow from any origin (for development)
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        // ✅ Handle preflight OPTIONS requests quickly
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            // Stop further execution for preflight requests
            exit(0);
        }
		
		
   $this->load->helper('rate_limiter');
//echo "<pre>";print_r($this->session->userdata());echo "</pre>";die('xxxxxxx');
        // Apply to logged-in users only
        if ($this->session->userdata('userid')) {
            $ip = $this->input->ip_address();
            $session_id = $this->session->userdata('session_id');
            $user_id = $this->session->userdata('userid');

            $this->load->model('LoginModel');
            $sessionid = $this->LoginModel->getUserSessionByUidIp($user_id, $session_id);

            if (empty($sessionid) ) {
                $this->session->sess_destroy();
                $message="new_session";
                redirect('/?message='.$message);
            }
        }
		
		
		
		
		 // Set idle timeout duration (in seconds)
      // $timeout = 7200; // 15 minutes
        $timeout = 86400; // 1 day

        // If user is logged in
        if ($this->session->userdata('userid')) {
			$user_id = $this->session->userdata('userid');
            $last_activity = $this->session->userdata('last_activity');

            if ($last_activity && (time() - $last_activity > $timeout)) {
                // Session has expired due to inactivity
                $this->session->sess_destroy();
				  
				$this->LoginModel->update_session_id($user_id, $session_id='');
				$message="new_session";
                redirect('/?message='.$message);
            } else {
                // Update last activity time
                $this->session->set_userdata('last_activity', time());
            }
        }
    }
	
	protected function validate_request_origin_or_referer() {
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') return TRUE;
/* 
		$allowed_origins = [
			'https://mh.nagpurnmc.in/'			
		]; */
		$allowed_origins = [
			'http://localhost:8081/'			
		];

		if (!empty($_SERVER['HTTP_ORIGIN'])) {
			$origin = rtrim($_SERVER['HTTP_ORIGIN'], '/');
			if (!in_array($origin, $allowed_origins)) return FALSE;
		} else if (!empty($_SERVER['HTTP_REFERER'])) {
			$ref = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			if ($ref !== $_SERVER['HTTP_HOST']) return FALSE;
		} else {
			// no origin/referrer — reject (stricter)
			return FALSE;
		}

		return TRUE;
	}
	
	public function check_submission_throttle($form_key = 'default_form', $cooldown_seconds = 9000)
	{
		$CI =& get_instance();
		$CI->load->library('session');

		$key = 'last_submit_' . $form_key;
		$now = time();

		$last_submit = $CI->session->userdata($key);

		if ($last_submit && ($now - $last_submit) < $cooldown_seconds) {
			$wait = $cooldown_seconds - ($now - $last_submit);
		   /*  echo "Please wait {$wait} more seconds before submitting again.";
			http_response_code(429); // Too Many Requests
			exit; */
			
			$this->session->set_flashdata('error_message', "Please wait {$wait} more seconds before submitting again.!");
			redirect($_SERVER['HTTP_REFERER']);
			exit;
		}

		// Allow and set new time
		$CI->session->set_userdata($key, $now);
		return true;
	}

}
