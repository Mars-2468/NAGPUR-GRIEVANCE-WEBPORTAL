<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class CheckPasswordController extends CI_Controller {

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
	    
	    if($this->input->post('submit'))
        {
            //exit;
            $p = array(
              "1df8" => 'a',
              "9jfr" => 'b',
              "8rlB" => 'c',
              "UlPT" => 'd',
              "MpFe" => 'e',
              "Ui18" => 'f',
              "WrM3" => 'g',
              "N1JL" => 'h',
              "6RIy" => 'i',
              "fzkd" => 'j',
              "QniU" => 'k',
              "p1JP" => 'l',
              "vKzW" => 'm',
              "7fwK" => 'n',
             "tfxt" => 'o',
             "kODR" => 'p',
             "2Du6" => 'q',
             "tTlj" => 'r',
             "8r5N" => 's',
             "GyiK" => 't',
             "XQbC" => 'u',
             "yySm" => 'v',
             "5Adl" => 'w',
             "wTvg" => 'x',
             "MocI" => 'y',
             "Ey0U" => 'z',
             "P6gE" => 'A',
             "f0vQ" => 'B',
             "CCQ5" => 'C',
             "448z" => 'D',
             "dbQN" => 'E',
             "IugC" => 'F',
             "RClE" => 'G',
             "3HF5" => 'H',
             "2UlP" => 'I',
             "PxYV" => 'J',
             "6JpV" => 'K',
             "F9Xf" => 'L',
             "A1T6" => 'M',
             "t10l" => 'N',
             "aizD" => 'O',
             "1T43" => 'P',
             "4uRh" => 'Q',
             "LuYr" => 'R',
             "oO35" => 'S',
             "Rj5w" => 'T',
             "l6cg" => 'U',
             "N512" => 'V',
             "htoG" => 'W',
             "YreT" => 'X',
             "RH71" => 'Y',
             "D9Es" => 'Z',
             "s886" => '0',
             "hnjJ" => '1',
             "em8X" => '2',
             "v0hA" => '3',
             "xVZ4" => '4',
             "1eoo" => '5',
             "Drt7" => '6',
             "51ZX" => '7',
             "U6e0" => '8',
             "tVWf" => '9',
             "VzoA" => '!',
             "tO3B" => '@',
             "ulGb" => '#',
             "JAmW" => '$',
             "cUmA" => '%',
             "gOyf" => '^',
             "vzFy" => '&',
             "IFFu" => '*',
             "gO5a" => '?',
            );
            
            
                $old_ciper = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('old_password')))));
                $p_text1 = str_split($old_ciper, 4);
                $dummy = array();
                $dummy1 = array();
                
                
                for($i=0;$i<sizeof($p_text1);$i++){
                    array_push($dummy,$p[$p_text1[$i]]);
                }
              
                $dummy = implode('',$dummy);
                $dummy = str_split($dummy, 4);
                 
                
                for($j=0;$j<sizeof($dummy);$j++){
                    array_push($dummy1,$p[$dummy[$j]]);
                }
                 
                $old_password = implode('',$dummy1);
               
                
                $ciper = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('password')))));
                $pass_text1 = str_split($ciper, 4);
                $p_dummy = array();
                $p_dummy1 = array();
                
                for($i=0;$i<sizeof($pass_text1);$i++){
                    array_push($p_dummy,$p[$pass_text1[$i]]);
                }
                $p_dummy = implode('',$p_dummy);
                $p_dummy = str_split($p_dummy, 4);
                
                
                for($j=0;$j<sizeof($p_dummy);$j++){
                    array_push($p_dummy1,$p[$p_dummy[$j]]);
                }
                $pass = implode('',$p_dummy1);
                
                $ciper1 = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('password')))));
                $cn_pass_text1 = str_split($ciper1, 4);
                $cp_dummy = array();
                $cp_dummy1 = array();
                // print_r($cn_pass_text1);die;
                
                for($i=0;$i<sizeof($cn_pass_text1);$i++){
                    array_push($cp_dummy,$p[$cn_pass_text1[$i]]);
                }
                $cp_dummy = implode('',$cp_dummy);
                $cp_dummy = str_split($cp_dummy, 4);
                
                
                for($j=0;$j<sizeof($cp_dummy);$j++){
                    array_push($cp_dummy1,$p[$cp_dummy[$j]]);
                }
                $pass2 = implode('',$cp_dummy1);
                
                //  print_r($pass);die;
                
               
                // $old_password = $old_password;
                $user_id = $this->session->userdata('userid');
                $params = array('user_id'=>$user_id,'user_pwd'=>hash('SHA256',$old_password));
                        // print_r($params);die;
                   
                    
                    $chkoldpassword = $this->CheckPasswordModel->chkOldPassword($params);
                    // echo $chkoldpassword;die;
                    //$chkoldpassword=1;
                    // exit;
                    if($chkoldpassword) {
                                // $pass = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('password')))));
                                $en_pass = hash('SHA256',$pass);
                                // $pass2 = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('password2')))));
                                // $old_pass = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('old_password')))));
                                if ($pass == $old_pass) {
                                    $this->session->set_flashdata('message','Password And Old Password Should Not be Same');
                                }
                                elseif ($pass != $pass2) {
                                    $this->session->set_flashdata('message','Password And Confirm Password Should be Same');
                                }
                                elseif (strlen($pass) < 8 || strlen($pass) > 16) {
                                    $this->session->set_flashdata('message','Password should be min 8 characters and max 16 characters');
                                }
                                elseif (!preg_match("/\d/", $pass)) {
                                    $this->session->set_flashdata('message','Password should contain at least one digit');
                                }
                                elseif (!preg_match("/[A-Z]/", $pass)) {
                                    $this->session->set_flashdata('message','Password should contain at least one Capital Letter');
                                }
                                elseif (!preg_match("/[a-z]/", $pass)) {
                                    $this->session->set_flashdata('message','Password should contain at least one small Letter');
                                }
                                elseif (!preg_match("/\W/", $pass)) {
                                    $this->session->set_flashdata('message','Password should contain at least one special character');
                                }
                                elseif (preg_match("/\s/", $pass)) {
                                    $this->session->set_flashdata('message','Password should not contain any white space');
                                }else{
                                    
                                        $userdetails=array(
                                          // 'user_id'=>$this->security->xss_clean($this->input->post('user_id')),
                                           'user_pwd'=>$en_pass,
                                           'show_pwd'=>$pass,
                                           'user_id'=>trim(htmlspecialchars(strip_tags($this->session->userdata('userid')))),
                                            'author'=>trim(htmlspecialchars(strip_tags($this->session->userdata('userid'))))
                                        
                                        );
                                        $user_id = $this->session->userdata('userid');
                                      
                               
                                      $result=$this->CheckPasswordModel->createUser($userdetails,$user_id);
                                       
                                }
                    }
                    else
                    {
                        $this->session->set_flashdata('message','Invalid old password');
                    }
                    
            // redirect('logout');
        }
	   
	    $this->load->view('header',$data);
		$this->load->view('checkpassword',$result);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
}
