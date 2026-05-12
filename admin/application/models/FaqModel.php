<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class FaqModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function getDependentFielddata()
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $result=$this->db->get('category_form_dependent_mst');
        return $result;
    }
    
    public function insert_data($data){
     return   $this->db->insert('faqs',$data);
    }
    
  
    public function get_all_faqs()
    {
       
        $this->db->select('*');
        $this->db->from('faqs');
        $this->db->order_by('id','DESC');
        $result=$this->db->get()->result_array();
        
        
        return $result;
    }
    public function get_single_faqs($id)
    {
       
        $this->db->select('*');
        $this->db->from('faqs');
        $this->db->where('id',$id);
        $this->db->order_by('id','DESC');
        $result=$this->db->get()->row();
        return $result;
    }
    public function update_data($data,$id){
                 $this->db->where('id',$id);
        return   $this->db->update('faqs',$data);
    }
    public function faq_delete($id){
        $this->db->where('id',$id);
     return   $this->db->delete('faqs');
    } 
    
   
    public function get_my_department($user_id)
    {
       
        $this->db->select('*');
        $this->db->from('departments_mst');
        $this->db->where('user_id',$user_id);
        $result=$this->db->get()->row();
        return $result;
    }
    
  
  
}
?>