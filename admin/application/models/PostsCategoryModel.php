<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class PostsCategoryModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    function add_cat($data2)
    {
        $this->db->insert('category_posts',$data2);
    }

public function select()  
     {  
          $select_array=array('*');
          $condition=array('ulbid'=>$this->session->userdata('ulbid'),'is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
          $this->db->select($select_array);
          $this->db->where($condition);
          $this->db->from('custom_menus');
          $query = $this->db->get();
          return $query->result();
     }  

 public function edit_cat($id)
    {
        $select=array('*');
        $result=$this->db->select($select)->where('page_id',$id)->get('custom_menus')->result_array();
        return $result;
    }
    
    function update_cat($data2,$id)
    {
       $this->db->where('page_id',$id);
       $this->db->update('custom_menus',$data2);
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
        $update_array = array('page_name'=>$params['page_name']);
        $where_array = array('page_id'=>$params['page_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
        $this->db->set($update_array);
        $this->db->where($where_array);
        $result = $this->db->update('custom_menus');
        return $result;
    }
    
    public function deletecatInfo($params){
        $this->db->where($params);
        $result=$this->db->delete('custom_menus');
        return $result;
    }
    
    public function getcatInfo($params){
        $this->db->select('*');
        $this->db->where($params);
        $this->db->from('custom_menus');
        $result = $this->db->get()->result_array();
        echo $result;
    } 
    public function gettingcatInfo($params){
        $this->db->select('page_name');
        $this->db->where($params);
        $this->db->from('custom_menus');
        $result = $this->db->get();
        return $result->result();
    }
}
?>