<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreatePhotoGalleryModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function getContentimg($params){
        
        $select_array=array('*');
        $result=$this->db->select($select_array)->where($params)->order_by('sort_order','ASC')->get('album_image_map')->result_array();
        return $result;
    }
    
    public function getContentMediaImg($params){
        $this->db->select('*');
        $this->db->from('medialibrary');
        $this->db->where($params);
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function deleteContentimg($params)
    {
        //unlink($params);
        $this->db->select('*');
        $this->db->from('album_image_map');
        $this->db->where($params);
        $rr = $this->db->get();
        foreach($rr->result() as $record){
            $image_path = "..".$record->image_path;
            if($record->thumbnail_path){
                $thumbnail_path = "..".$record->thumbnail_path;    
            }else{
                $thumbnail_path = '';
            }
            if($record->thumbnail_path300){
                $thumbnail_path300 = "..".$record->thumbnail_path300;    
            }else{
                $thumbnail_path300 = '';
            }
            
            if(file_exists($thumbnail_path300)){
                unlink($thumbnail_path300);
            }
            if(file_exists($thumbnail_path)){
                unlink($thumbnail_path);
            }
            if(file_exists($image_path)){
                unlink($image_path);
            }
            $this->db->where($params);
            $result=$this->db->delete('album_image_map');
            //$this->db->last_query();
            return $result;
        }
        //echo $thumbnail_path." <br /> ".$image_path;
        /*$this->db->where($params);
        $result=$this->db->delete('album_image_map');
        $this->db->last_query();
        return $result;*/
    }
    public function deleteContentMediaImg($params){
        $this->db->where($params);
        $result = $this->db->delete('photogallery_media_map');
        $this->db->last_query();
        return $result;
        /*$update_array = array('is_photogallery'=>'','is_photogallery_album_id'=>0);
        $this->db->set($update_array);
        $this->db->where($params);
        $result = $this->db->update('medialibrary');
        return $result;*/
    }
    public function updateImgInfo($params){
        $update_array=array('heading'=>$params['heading'],'description'=>$params['description'],'title'=>$params['title'],'alttext'=>$params['alttext'],'status'=>$params['status'],'updatedBy'=>$params['updatedby']);
        $where_array=array('id'=>$params['id']);
        $this->db->set($update_array);
        $this->db->where($where_array);
        $result=$this->db->update('album_image_map');
        return $result;
    }
    public function updateMediaImgInfo($params){
        $update_array=array('heading'=>$params['heading'],'description'=>$params['description'],'title'=>$params['title'],'alttext'=>$params['alttext'],'status'=>$params['status'],'updatedBy'=>$params['updatedby']);
        $where_array=array('slide_id'=>$params['slide_id']);
        $this->db->set($update_array);
        $this->db->where($where_array);
        $result=$this->db->update('medialibrary');
        return $result;
    }
    
    public function getDefaultAlbumdet($params)
    {
        
        
        $this->db->select('*');
        $this->db->where($params);
        $this->db->from('album_mst');
        $this->db->order_by('album_id','ASC');
        $this->db->limit(1,0);
       $result=$this->db->get()->result_array();
      
        return $result;
    }
    public function getAngularAlbumData($params)
    {
        $this->db->select('*');
        $this->db->where($params);
        $result=$this->db->get('album_mst')->result_array();
        return $result;
    }
    
    public function getAngularPhotoGalleryData($params)
    {
        $this->db->select('*');
        $this->db->where($params);
        $result=$this->db->get('photo_gallery_mst')->result_array();
       
        return $result;
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
        $result=$this->db->delete('photo_gallery_mst');
        
        return $result;
    }
    
    public function addPhotos($params,$params2)
    {
       $this->db->insert('medialibrary',$params);
       $result=$this->db->insert('photo_gallery_mst',$params2);
       return $result;
        
    }
    public function getphotosList($params)
    {
        $select_array=array('*'); 
        $result=$this->db->select($select_array)->where($params)->get('photo_gallery_mst')->result_array();
        return $result;
    }
    
     public function deleteMenu($params)
    {
        $this->db->where($params);
        $result=$this->db->delete('site_main_menu');
        return $result;
    }
    
    
    
    
    
}
?>