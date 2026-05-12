<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class VideosModel extends CI_Model
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
        $result=$this->db->update('slider_mst');
        
        return $result;
    }
    
    public function deleteContent($params)
    {
        $this->db->where($params);
        $result=$this->db->delete('videos_mst');
        return $result;
    }
    
    public function insertVideos($params)
    {
       foreach($params as $key=>$values)
       {
       $result=$this->db->insert('videos_mst',$values);
       }
       return $result;
        
    }
    public function getVideos($params)
    {
        $select_array=array('video_id','link_url','thumbnail_url','ts','is_iframe'); 
        $result=$this->db->select($select_array)->where($params)->get('videos_mst');
        return $result;
    }
}
?>