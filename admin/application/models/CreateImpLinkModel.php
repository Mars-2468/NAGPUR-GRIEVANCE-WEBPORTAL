<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreateImpLinkModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
		$this->load->database();
    }
    	  
	public function all($table)
	{	
	//var_dump($table);die();
		$this->db->select('*');
		$this->db->order_by('id', 'DESC');
	    $query = $this->db->get($table);
	    if ($query) 
	    {
	    	return $query->result();
	    }
	    else
	    {
	    	return 0;
	    }
	}

    public function insert($table,$params)
    {
		//echo "<pre>";print_r($array);echo "</pre>";die();
        $this->db->insert($table,$params);
		
		return true;
    }
    public function update($table,$params,$id)
    {
		//echo "<pre>";print_r($id);echo "</pre>";die();
		$this->db->where('id', $id);  
       $update = $this->db->update('imp_links', $params); 
		
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
	
   
}
?>