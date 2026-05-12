<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreatePostModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function updateSliderThumbnailimage($postid,$thumbspath)
    {
		/* //var_dump($thumbspath);die();
        $condition=array('page_id'=>$postid);
        $set_array=array('thumbnail_path'=>$thumbspath);
        $this->db->set($set_array);
        $this->db->where($condition);
        $this->db->update('slider_mst2'); */
		
		
		$condition = ['page_id' => $postid];
		$set_array = ['image_path' => $thumbspath,'thumbnail_path' => $thumbspath];

		$this->db->where($condition);
		$this->db->update('slider_mst2', $set_array);
			   
        
    }
    

    public function deletePageCategories($params)
    {
        
        $this->db->where($params);
        $this->db->delete('post_category_map');
    }
    
    public function insertCategoryFormdetails($query)
    {
        $this->db->query($query);
    }
    
     public function getCategoryFieldnames($params)
    {
        $select_array=array('cfm.*','c.page_name');
        $this->db->select($select_array);
        $this->db->from('category_forms_mst cfm');
        $this->db->join('custom_menus c','cfm.category_id=c.page_id');
        $this->db->where($params);
        $result=$this->db->get()->result_array();
       
        
       
        return $result;
    }
    
    public function getCatDet($params)
    {
        $select_array=array('page_id','page_name','author','user_level');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('custom_menus')->row_array();
        return $result;
    }
    
    public function getTenderForm($params)
    {
        $select_array=array('funcname');
       $this->db->select($select_array);
       $this->db->where($params);
       $result=$this->db->get('custom_menus')->row_array();
       return $result;
    }
    
    public function mapCategoryPost($params)
    {
        $this->db->insert('post_category_map',$params);
    }
    
    public function getAssignedCategories($params){
        
         $select_array=array('dept_id');
        $this->db->select($select_array);
        $this->db->where($params);
		
		//var_dump($params);die();
		
        $sel_departments=$this->db->get('user_department_map');
        return $sel_departments->result();
        
    }


    public function getPostCategoriescustom($params,$assignedDepartments)
    {
        
        
        if(count($assignedDepartments) > 0){
            
            foreach($assignedDepartments as $key=>$deptid){
                
                $assignedDepartments2[$deptid['dept_id']] = $deptid['dept_id'];
                
            }

            
            
        $select_array=array('page_id as category_id','page_name as category_desc','table_name');
        $this->db->select($select_array);
        $this->db->where($params);
        $this->db->where_in('page_id',$assignedDepartments2);
        $data['ulbcategories']=$this->db->get('custom_menus');
        $data['admincategories']=array();
            
        }else{
        
        $select_array=array('page_id as category_id','page_name as category_desc','table_name');
        $this->db->select($select_array);
        $this->db->where($params);
        $data['ulbcategories']=$this->db->get('custom_menus');
        
        $select_array=array('page_id as category_id','page_name as category_desc','table_name');
        $condition=array('user_level'=>'A','is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
        $this->db->select($select_array);
        $this->db->where($condition);
        $data['admincategories']=$this->db->get('custom_menus');
        }

        
        return $data;
    }
    
    public function getPostCategories($params,$assignedDepartments)
    {
               //echo "<pre>";print_r($params);echo "</pre>";die();   
		if(!empty($assignedDepartments) && count($assignedDepartments) > 0){
            
            foreach($assignedDepartments as $key=>$deptid){
                
                $assignedDepartments2[$deptid] = $deptid;
                
            }
            
			$select_array=array('page_id as category_id','page_name as category_desc','table_name');
			$this->db->select($select_array);
			$this->db->where($params);
			$this->db->where_in('page_id',$assignedDepartments2);
			$data['ulbcategories']=$this->db->get('custom_menus');
			$data['admincategories']=array();
            // ECHO "EE"; EXIT;
        }else{
            // ECHO "DD"; EXIT;
      
			// $select_array=array('page_id as category_id','page_name as category_desc','table_name');
			// $this->db->select($select_array);
			// $this->db->where($params);.
			$select_array=array('page_id as category_id','page_name as category_desc','table_name');
			$condition=array('user_type'=>'A','is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
			$this->db->select($select_array);
			$this->db->where($condition);
			$data['ulbcategories']=$this->db->get('custom_menus');
			//    $data['ulbcategories']=array();
			$select_array=array('page_id as category_id','page_name as category_desc','table_name');
			$condition=array('user_type'=>'A','is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
			$this->db->select($select_array);
			$this->db->where($condition);
			$data['admincategories']=$this->db->get('custom_menus');
		   //print_r( $data['admincategories']->result_array()); exit;
     
        }
        
       
        return $data;
    }
    
    public function customePageDataInsert($params)
    {
       
      $result=$this->db->insert('custom_menus',$params);
     
       $data['result']=$result;
       $data['pageId']=$this->db->insert_id();
       
        if($result!='')
        // echo "<script>alert('okkk')</script>";
       {
           
       $condition=array('page_id'=>$data['pageId']);
       $this->db->select('*');
       $this->db->where($condition);
       $query=$this->db->get('custom_menus');
       
       foreach ($query->result_array()  as $user)
       $page_id= $user['page_id'];
       $is_custumlink= $user['is_custumlink'];
       
       $condition=array('page_type_id'=>$is_custumlink);
       $this->db->select('*');
       $this->db->where($condition);
       $query1=$this->db->get('page_type_mst');
       
       foreach ($query1->result_array()  as $page)
       $page_type_desc= $page['page_type_desc'];
       $content= $user['content'];
       $ts= $user['ts'];
       $author= $user['author'];
       
       $content_array=array(
           'content_id'=>$page_id,
           'content_type'=>$page_type_desc,
           'modified_content'=>$content,
           'datetime'=>$ts,
           'author'=>$author
           );
           $this->db->insert('logs',$content_array);
       
      
       }
       
    //   return $data;
       if($result && ($params['is_custumlink']=='5'))
       {
           $params=array('ulbid'=>$this->session->userdata('ulbid'),'page_id'=>$this->db->insert_id(),'langId'=>$this->session->userdata('langId'),'menu_name'=>$params['page_name'],'author'=>$this->session->userdata('username'),'flag'=>1);
           $this->db->insert('news_mst',$params);
       }
       
       //$result=$this->db->insert('about_mst',$string);
      
       return $data;
        
    }
    public function getaboutData($params)
    {
        $result=$this->db->select('content')->where($params)->get('about_mst')->result_array();
        return $result;
    }
    
    public function checkingcatInfo($params){
        $this->db->select('*');
        $this->db->where($params);
        $this->db->from('custom_menus');
        $result = $this->db->get();
        if($result->num_rows()>0)
            return TRUE;
        else
            return FALSE;
    }
    public function updatecatInfo($params){
        $update_array = array('page_name'=>$this->input->post('page_name'));
        $where_array = array('page_id'=>$this->input->post('id'),
	                    'langId'=>$this->session->userdata('langId'),
                        'ulbid'=>$this->session->userdata('ulbid'));
        $this->db->set($update_array);
        $this->db->where($where_array);
        $result = $this->db->update('custom_menus');
        return $result;
    }

	public function insert($table, $array)
	{	
		$query = $this->db->insert($table, $array);
		$insert_id = $this->db->insert_id();
	    if ($query) 
	    {
	    	return $insert_id;
	    }
	    else
	    {
	    	return 0;
	    }   
	}
	public function all_records($table, $array)
	{	
		$this->db->select('*');
		$this->db->where($array);
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
	  
	public function all_complaint_details()
	{	
		$this->db->select('tbl_agenda_category_mst.category as scheme, tbl_agenda_mst.text as cat, tbl_complaint_details.*');
		$this->db->from('tbl_complaint_details');
		$this->db->join('tbl_agenda_category_mst', 'tbl_complaint_details.category=tbl_agenda_category_mst.id');
		$this->db->join('tbl_agenda_mst', 'tbl_complaint_details.sub_category=tbl_agenda_mst.id');
	    $query = $this->db->get();
	    if ($query) 
	    {
	    	return $query->result();
	    }
	    else
	    {
	    	return 0;
	    }
	  }
	  
	public function all($table)
	{	
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
	public function get_row($table, $array)
	{	
		$this->db->where($array);
		$query = $this->db->get($table);
		$row = $query->row();
	    if ($query) 
	    {
	    	return $query->row();
	    }
	    else
	    {
	    	return 0;
	    }   
	}
	public function update($table, $array, $where)
	{
		$this->db->where($where);
		$query = $this->db->update($table, $array);
		if ($query) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}
    public function getDepartments()
    { 
       
        $this->db->select('*');
        $this->db->from('departments_mst');
        $result=$this->db->get()->result_array(); 
       
        
       
        return $result;
    }

}
?>