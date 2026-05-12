<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class LoginModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function deleteSessionUniqepaams()
    {
        
        $result = $this->db->delete('query_logs', array('sno!=' => "")); 
         
    }
    public function checkSessionUniqepaams($chkUniqParams)
    {
        return $result = $this->db->where($chkUniqParams)->get('query_logs')->result_array();
        
    }
    public function checkhashvalues($hashparm){
        $query = "select * from login_hash_check where hash1='$hashparm[0]' and hash2='$hashparm[1]' and length='$hashparm[2]'";
        
        return $result = $this->db->query($query)->result_array();
    }
        
    public function insertUniqueId($params)
    {
        return $this->db->insert('login_hash_check',$params);
    }
    
    public function loginCheck($params)
    {
		
       /* $select=array('user_id','user_name','user_type','ulbid');
        $where ="user_id='".$this->db-escape($params['username'])."' and user_pwd=PASSWORD('".$params['password']."')";*/
        
        //$query="select users.user_id,users.user_name,users.user_type,users.ulbid,users.banner,ulbmst.base_url,users.user_category,users.is_custom_user,users.has_access from users JOIN ulbmst ON ulbmst.ulbid=users.ulbid  where user_id=".$this->db->escape($params['username'])." and user_pwd=PASSWORD(".$this->db->escape($params['password']).")";
		     $query="select users.user_id,users.user_name,users.user_type,users.ulbid,users.banner,ulbmst.base_url,users.user_category,users.is_custom_user,users.has_access from users JOIN ulbmst ON ulbmst.ulbid=users.ulbid  where user_id=".$this->db->escape($params['username'])." and user_pwd=PASSWORD(".$this->db->escape($params['password']).")";
    
        $result=$this->db->query($query)->result_array();
        //echo $this->db->last_query();
        
        if(!$result)
        { 
            $data['result']=0;
            return $data;
        }
        else
        {
            $data['result']=1;
            
            $data['object']=$result[0];
            return $data;
        }
        
         
    }
    
    public function insert_hash($params){
        return $this->db->insert('login_hash_check',$params);
    }
   
    public function ulbDetails($params)
    {
        $select_array=array('ut.ulb_type_desc','u.ulbname');
        $this->db->select($select_array);
        $this->db->from('ulbmst u');
        $this->db->join('ulb_type ut','u.ulb_type=ut.ulb_type_id');
        $this->db->where($params);
        $result=$this->db->get()->result_array();
       // echo $this->db->last_query();
        
        return $result[0];
    }
	
	public function update_session_id($user_id, $session_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('user_sessions', ['session_id' => $session_id]);
	}
     	
	public function getUserSessionByUidIp($user_id,$session_id)
	{	
		$this->db->where('user_id', $user_id)->where('session_id', $session_id); 
		$query =$this->db->get('user_sessions');
		
        if ($query->num_rows() == 1) {
            return $query->row(); // Return user object
        } else {
            return false; // No user found
        }
	}
       
	public function is_strong_password($password) {
		return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
	}
	
}
?>