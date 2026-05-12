<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreateUserModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
		$this->load->database();
    }
    	  
	public function all($table)
	{	
	
		$this->db->select('*');
		//$this->db->order_by('user_id', 'DESC');
	    $query = $this->db->get($table);
		//$result = $query->result_array(); 
		//var_dump($result);die();
	    if ($query) 
	    {
	    	return $query->result();
	    }
	    else
	    {
	    	return 0;
	    }
	}   	  
	public function allUsers($table)
	{	
	
		$this->db->select('user_id,user_name,user_mobile,user_email,user_type,designation_id,show_pwd,has_access');
		//$this->db->order_by('user_id', 'DESC');
	    $query = $this->db->get($table);
		//$result = $query->result_array(); 
		//var_dump($result);die();
	    if ($query) 
	    {
	    	return $query->result();
	    }
	    else
	    {
	    	return 0;
	    }
	}   	  
	public function getDepartments()
	{	
	//var_dump($table);die();
		$this->db->select('id,depart_name');
		//$this->db->order_by('id', 'DESC');
	    $query = $this->db->get('departments_mst');
		$arrdata = $query->result_array();
	    if (count($arrdata)) 
	    {
			$deptArray = array();

			foreach ($arrdata as $data) {
				$deptArray[$data['id']] = $data['depart_name'];
			}
	    	return $deptArray;
	    }
	    else
	    {
	    	return 0;
	    }
	}
	public function getZOfficesDepts()
	{	
	//var_dump($table);die();
		$this->db->select('menu_id,menu_name');
		$this->db->where_in('menu_name', ['Zonal Offices','Departments']);
	    $query = $this->db->get('site_main_menu');
		$arrdata = $query->result_array();
	    if (count($arrdata)) 
	    {
			$zoffdeptArray = array();

			foreach ($arrdata as $data) {
				$zoffdeptArray[$data['menu_id']] = $data['menu_name'];
			}
	    	return $zoffdeptArray;
	    }
	    else
	    {
	    	return 0;
	    }
	}
	
	public function getUserZonesDepts($userid)
	{	
		$this->db->select('dept_id');
		$this->db->where('user_id',$userid );
	    $query = $this->db->get('user_department_map');
		$arrdata = $query->result_array();
			//echo "<pre>";print_r($arrdata);echo "</pre>";die();	
	    if (count($arrdata)) 
	    {
			$zoffdeptArray = array();

			foreach ($arrdata as $data) {
				$zoffdeptArray[] = $data['dept_id'];
			}
			
			//echo "<pre>";print_r($zoffdeptArray);echo "</pre>";die();	
			
	    	return $zoffdeptArray;
	    }
	    else
	    {
	    	return 0;
	    }
	}

	public function getDesignations()
	{	
	//var_dump($table);die();
		$this->db->select('desg_id,desg_desc');
	    $query = $this->db->get('desg_mst');
		$arrdata = $query->result_array();
	    if (count($arrdata)) 
	    {
			$desgArray = array();

			foreach ($arrdata as $data) {
				$desgArray[$data['desg_id']] = $data['desg_desc'];
			}
	    	return $desgArray;
	    }
	    else
	    {
	    	return 0;
	    }
	}
	
	public function getCategories()
	{	
	//var_dump($table);die();
		$this->db->select('id,user_category_name');
	    $query = $this->db->get('user_categories');
		$arrdata = $query->result_array();
	    if (count($arrdata)) 
	    {
			$desgArray = array();

			foreach ($arrdata as $data) {
				$desgArray[$data['id']] = $data['user_category_name'];
			}
	    	return $desgArray;
	    }
	    else
	    {
	    	return 0;
	    }
	}

    public function insert($table,$params)
    {
	//echo "<pre>";print_r($params);echo "</pre>";die();
        $this->db->insert($table,$params);
		return true;
    }
	
    public function userDepartmentMap($table,$params)
    {
	//echo "<pre>";print_r($params);echo "</pre>";die();
        $this->db->insert($table,$params);
		
		return true;
    }
	
    public function update($table,$params,$id)
    {
		//echo "<pre>";print_r($params);echo "</pre>";die();
		$this->db->where('user_id', $id);  
		$update = $this->db->update('users', $params); 
		
		    // Check if the update was successful
		if ($update) {
			if ($this->db->affected_rows() > 0) {
				return "Record updated successfully!";
			} else {
				return "No records were updated. Perhaps the data is already the same.";
			}
		} else {
			// Query failed, print the error for debugging
			return "Error: " . $this->db->error();
		}
		
	
		//echo "<pre>";print_r($this->db->last_query());echo "</pre>";die();
		
    }	
	
    public function delete($table, $array)
	{
	
		$this->db->where($array);
		$query = $this->db->delete($table);	
		//echo "<pre>";print_r($this->db->last_query());echo "</pre>";die();
		if ($query) 
		{
			return true;
		}
		else
		{
			return 0;
		}
	}
	public function get_row($table, $id)
	{	
		$this->db->where('id',$id);
		$query = $this->db->get($table);
		$row = $query->row();
		//echo "<pre>";print_r($row);echo "</pre>";die();   
	    if ($query) 
	    {
	    	return $query->row();
	    }
	    else
	    {
	    	return 0;
	    }		
	}	
	
	public function get_user_row($table, $id)
	{	
		$this->db->select('user_id,user_name,user_mobile,user_email,user_type,designation_id,show_pwd,has_access',$id);
		$this->db->where('user_id',$id);
		$query = $this->db->get($table);
		$row = $query->row();
		//echo "<pre>";print_r($row);echo "</pre>";die();   
	    if ($query) 
	    {
	    	return $query->row();
	    }
	    else
	    {
	    	return 0;
	    }   
	}
	
    public function updateUser($userdetails,$userid) {
      
        $sql=$this->db->query("UPDATE  users SET  user_pwd=PASSWORD('".$userdetails['user_pwd']."'),show_pwd='".$userdetails['show_pwd']."'  where user_id='".$userdetails['user_id']."'");
         //echo $sql;exit;
			/* if($sql){
				//echo "okkkk";exit;
				$this->session->set_flashdata('message',"<div class='alert alert-success'>Password Changed Successfully </div>");
				redirect('all-user-list');
			} */
    }	
    public function showUserPwd($pwd='xxxx') {
		
      return json_encode(['pwd'=>$pwd]);
    }
}
?>