<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class HomeGalleryModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    
    public function updateContent($params)
    {
        $updateFields=array('slide_desc'=>$params['slide_desc'],'title'=>$params['title']);
        $this->db->set($updateFields);
        $this->db->where('slide_id',$params['slide_id']);
        $result=$this->db->update('gallery_mst');
        
        return $result;
    }
    
    public function deleteContent($params)
    {
        $this->db->where($params);
        $result=$this->db->delete('gallery_mst');
        return $result;
    }
    
    public function addSlider($params)
    {
       
       $result=$this->db->insert('gallery_mst',$params);
       return $result;
        
    }
    public function getSliderList($params)
    {
        $select_array=array('*');
        $result=$this->db->select($select_array)->where($params)->get('gallery_mst')->result_array();
        return $result;
    }
}
?>