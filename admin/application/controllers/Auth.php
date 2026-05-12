<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('LoginModel');
        $this->load->library('session');
        $this->load->helper(['captcha', 'cookie']);
        $this->load->database();
    }

    public function logout_on_close1()
    {
        $user_id = $this->session->userdata('user_id');
        // Destroy session
        $this->session->sess_destroy();
        // Delete PHPSESSID cookie properly
        delete_cookie('PHPSESSID');
        // Clear session record from DB
        $this->db->where('user_id', $user_id);
        $this->db->update('user_sessions', ['session_id' => '']);
        redirect('/');
        exit;
    }

    public function check_session()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id || (time() - $this->session->userdata('last_activity') > 3600)) {
            $this->session->sess_destroy();
            delete_cookie('PHPSESSID');
            $this->db->where('user_id', $user_id);
            $this->db->update('user_sessions', ['session_id' => '']);
            redirect('/');
            exit;
        } else {
            echo "active";
        }
    }
}
?>
