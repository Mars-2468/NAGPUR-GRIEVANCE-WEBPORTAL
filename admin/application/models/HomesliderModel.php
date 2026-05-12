<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class HomesliderModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function updateSortOrder($params)
    {
        $this->db->set('sort_order',$params['sort_order']);
        $this->db->where('slide_id',$params['slide_id']);
        $this->db->update('slider_mst');
        
        return $this->db->last_query();
    }
    public function updateContent($params)
    {
        $updateFields=array('slide_desc'=>$params['slide_desc'],'title'=>$params['title']);
        $this->db->set($updateFields);
        $this->db->where('slide_id',$params['slide_id']);
        $result=$this->db->update('slider_mst');
        
        return $result;
    }
    
    public function deleteContent($params)
    {
        $this->db->where($params);
        $result=$this->db->delete('slider_mst');
        return $result;
    }
    
    public function addSlider($params)
    {
       //$this->db->insert('medialibrary',$params2);
       $result=$this->db->insert('slider_mst',$params);
       return $result;
        
    }
    public function getSliderList($params)
    {
        $select_array=array('*');
        //$result=$this->db->select($select_array)->where($params)->order_by('sort_order','ASC')->get('slider_mst')->result_array();
        return $result;
    }
    
    public function getImgInfo($params)
    {
        $select_array=array('*');
        $result=$this->db->select($select_array)->where($params)->get('slider_mst')->result_array();
        return $result;
    }
    
    public function insertImgInfo($params)
    {
        $update_array=array('title'=>$params['title'],'alttext'=>$params['alttext'],'status'=>$params['status'],'slide_desc'=>$params['slide_desc'],'slide_heading'=>$params['slide_heading']);
        $where_array=array('slide_id'=>$params['slide_id']);
        $this->db->set($update_array);
        $this->db->where($where_array);
        $result=$this->db->update('slider_mst');
        return $result;
    }
}
?>