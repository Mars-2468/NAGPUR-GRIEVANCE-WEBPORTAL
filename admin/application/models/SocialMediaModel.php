<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class SocialMediaModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    // public function getDependentFielddata()
    // {
    //     $select_array=array('*');
    //     $this->db->select($select_array);
    //     $result=$this->db->get('category_form_dependent_mst');
    //     return $result; 
    // }
    
    // public function insert_data($data){
    //  return   $this->db->insert('faqs',$data);
    // }
    
  
    // public function get_all_faqs()
    // {
       
    //     $this->db->select('*');
    //     $this->db->from('faqs');
    //     $this->db->order_by('id','DESC');
    //     $result=$this->db->get()->result_array();
        
        
    //     return $result;
    // }
    public function get_link_data() 
    {
       
        $this->db->select('distid,facebook_link,twitter_link,instagram_link');
        $this->db->from('ulbmst');
        $this->db->where('distid','18');
        $result=$this->db->get()->row();
        return $result;
    }
    public function update_data($data,$id){
                 $this->db->where('distid',$id);
        return   $this->db->update('ulbmst',$data);
    }
    // public function faq_delete($id){
    //     $this->db->where('id',$id);
    //  return   $this->db->delete('faqs');
    // } 
    
   
   
    
  
  
}
?>