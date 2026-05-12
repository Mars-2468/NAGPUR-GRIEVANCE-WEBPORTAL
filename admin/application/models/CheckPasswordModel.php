<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CheckPasswordModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    
    public function chkOldPassword($params)
    {
        $sql=$this->db->query("select  * from users where  user_pwd=PASSWORD('".$params['user_pwd']."')  and  user_id='".$params['user_id']."'");
        
        $result = $sql->num_rows();
        return $result;
    }
     
     public function checkUserOldPwd($params,$userid) {
	          
        $query="select users.user_id,users.user_name,users.user_type,users.ulbid,users.banner,ulbmst.base_url,users.user_category,users.is_custom_user from users JOIN ulbmst ON ulbmst.ulbid=users.ulbid  where user_id=".$this->db->escape($params['user_id'])." and user_pwd=PASSWORD(".$this->db->escape($params['user_pwd']).")";
        $result=$this->db->query($query)->result_array();
        
        if(!empty($result))
        {           
            return 1;
        }
        else
        {
            return 0;
        }
        
	 }
	 
     public function createUser($userdetails,$userid) {
      
        $sql=$this->db->query("UPDATE  users SET  user_pwd=PASSWORD('".$userdetails['user_pwd']."'),show_pwd='".$userdetails['show_pwd']."'  where user_id='".$userdetails['user_id']."'");
         //echo $sql;exit;
          if($sql){
                                //echo "okkkk";exit;
                                $this->session->set_flashdata('message',"<div class='alert alert-success'>Password Changed Successfully </div>");
                                redirect('logout');
                            }else{
                               // echo "not  okkkk";exit;
                                $this->session->set_flashdata('message',"<div class='alert alert-danger'> Please Try Again! </div>");
                                redirect('change-password');
                            }
                           // $qq = $this->db->query($sql);
                    	    //return $query->result();
    }
    

    
}