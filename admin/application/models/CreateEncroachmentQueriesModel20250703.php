<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreateEncroachmentQueriesModel extends CI_Model
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
	
	public function userAll($table,$userId)
	{	
	//var_dump($table);die();
		$this->db->select('*');
		$this->db->where('user_id', $userId);
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
		//echo "<pre>";print_r($table);echo "</pre>";die();
      return  $this->db->insert($table,$params);
    }
	
    public function update($table,$params,$id)
    {
		//echo "<pre>";print_r($id);echo "</pre>";die();
		$this->db->where('id', $id);  
		$update = $this->db->update('encroachment_queries', $params); 
		
		    // Check if the update was successful
		if ($update) {
			return true;
		} else {
			// Query failed, print the error for debugging
			return false;
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
	
	public function getLanguages()
	{	
		//var_dump($table);die();
		$this->db->select('languageId,language_desc');
		//$this->db->order_by('dept_id', 'DESC');
	    $query = $this->db->get('language_mst');
		$arrdata = $query->result_array();
	    if (count($arrdata)) 
	    {
			$deptArray = array();

			foreach ($arrdata as $data) {
				$deptArray[$data['languageId']] = $data['language_desc'];
			}
	    	return $deptArray;
	    }
	    else
	    {
	    	return 0;
	    }
	}
	
	public function getDepartments()
	{	
	//var_dump($table);die();
		$this->db->select('dept_id,dept_desc');
		//$this->db->order_by('dept_id', 'DESC');
	    $query = $this->db->get('dept_mst');
		$arrdata = $query->result_array();
	    if (count($arrdata)) 
	    {
			$deptArray = array();

			foreach ($arrdata as $data) {
				$deptArray[$data['dept_id']] = $data['dept_desc'];
			}
	    	return $deptArray;
	    }
	    else
	    {
	    	return 0;
	    }
	}	
	public function getPageDepartments()
	{	
	//var_dump($table);die();
		$this->db->select('page_id,sub_menu_desc');
		$this->db->order_by('page_id', 'DESC');
	    $query = $this->db->get('site_sub_menus');
		$arrdata = $query->result_array();

	    if (count($arrdata)) 
	    {
			$deptArray = array();

			foreach ($arrdata as $data) {
				$deptArray[$data['page_id']] = $data['sub_menu_desc'];
			}
	    	return $deptArray;
	    }
	    else
	    {
	    	return 0;
	    }
	}
	public function getZoneDepartments($params)
	{	
	//var_dump($table);die();
		$this->db->select('page_id,sub_menu_desc');
		$this->db->where_in('main_menu_id',$params);
		$this->db->order_by('page_id', 'DESC');
	    $query = $this->db->get('site_sub_menus');
		$arrdata = $query->result_array();

	    if (count($arrdata)) 
	    {
			$deptArray = array();

			foreach ($arrdata as $data) {
				$deptArray[$data['page_id']] = $data['sub_menu_desc'];
			}
	    	return $deptArray;
	    }
	    else
	    {
	    	return 0;
	    }
	}
	
	
	public function delete_recs($table, $array, $fileFields = [])
	{
		// Step 1: Get the record (so we know which files to delete)
		$record = $this->db->get_where($table, $array)->row_array();

		if ($record) {
			// Step 2: Delete files if file field names provided
			foreach ($fileFields as $field) {
				if (!empty($record[$field])) {
					$filePath = FCPATH . $record[$field];
					if (file_exists($filePath)) {
						@unlink($filePath); // @ suppresses warning if unlink fails
					}
				}
			}

			// Step 3: Delete the DB record
			$this->db->where($array);
			$query = $this->db->delete($table);

			return $query ? 1 : 0;
		}

		return 0; // Record not found
	}

}
?>