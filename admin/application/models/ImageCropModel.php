<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class ImageCropModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function updateCroppedThumbnailPath($params)
    {
        $update_array=array('thumbnail_path'=>$params['thumbnail_path']);
        $condition=array('slide_id'=>$params['slide_id']);
        $this->db->set($update_array);
        $this->db->where($condition);
        $result=$this->db->update('slider_mst');
        return $result;
    }
    
    public function getSourceImage($params)
    {
        $select_array=array('full_path','image_path','slide_id');
        
        $this->db->select($select_array);
        $this->db->where($params);
        $reslut=$this->db->get('slider_mst')->row_array();
        return $reslut;
    }
    public function getSourceImage2($params)
    {
        $select_array=array('*');
        
        $this->db->select($select_array);
        $this->db->where($params);
        $reslut=$this->db->get('slider_mst2')->row_array();
        return $reslut;
    }
}
?>