<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreateMediaModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
        //$this->load->database();
    }
    
    public function addImageInfo_temp($params){
        
        $this->db->insert('medialibrary_temp',$params);
       
    }
    
    
    public function addImageInfo($params){
         $list=array(
            'user_id'=>$this->session->userdata('userid'),
            'query'=>$this->db->error()
            );
        
        $this->db->insert('medialibrary',$params);
        $this->db->insert('query_logs',$list);
       
        echo 1;
        
    }
    
    public function getContentimg($params){
        
        $select_array=array('m.*','u.base_url');
        $this->db->select($select_array);
        $this->db->from('medialibrary m');
        $this->db->join('ulbmst u','m.ulbid=u.ulbid');
        $this->db->where($params);
        $result=$this->db->get()->result_array();
       // $result=$this->db->select('*')->where($params)->get('medialibrary')->result_array();
        return $result;
    }
    public function deleteContentimg($params)
    {
        $this->db->select('*');
        $this->db->from('medialibrary');
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
            
            //echo $thumbnail_path300.", ".$thumbnail_path.", ".$image_path;exit;
            if (file_exists($thumbnail_path300)){
                unlink($thumbnail_path300);
            }
            if (file_exists($thumbnail_path)){
                unlink($thumbnail_path);
            }
            if(file_exists($image_path)){
                unlink($image_path);
            }
            $this->db->where($params);
            $result=$this->db->delete('medialibrary');
            $this->db->last_query();
            return $result;
        }
        
        /*$this->db->where($params);
        $result=$this->db->delete('medialibrary');
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
        $update_array=array('heading'=>$params['heading'],'description'=>$params['description'],'title'=>$params['title'],'alttext'=>$params['alttext'],'updatedBy'=>$params['updatedby']);
        $where_array=array('slide_id'=>$params['slide_id']);
        $this->db->set($update_array);
        $this->db->where($where_array);
        $result=$this->db->update('medialibrary');
        return $result;
    }
    public function updateImgInfoPhotoGallery($params){
        $array = $params['val'];
        $len = count($array);
         //print_r($array);
        // echo $len;
        //$result = array();
        if($len >0){
            for($i=0;$i<$len;$i++){
                /*$param = array('slide_id'=>$array[$i],'album_id'=>$params['album_id'],'flag'=>1);
                $result = $this->db->insert('photogallery_media_map',$param);*/
                $result = $this->db->query("INSERT INTO photogallery_media_map(slide_id,album_id,ulbid,flag) VALUES ('".$array[$i]."','".$params['album_id']."','".$params['ulbid']."','1') ON DUPLICATE KEY UPDATE  flag = 1");		
            }
            return $result;
        }else{
            return false;
        }
    }
    
    public function getDefaultAlbumdet($params)
    {
        
        
        $this->db->select('*');
        $this->db->where($params);
        $this->db->from('medialibrary');
        $this->db->order_by('slide_id','ASC');
        $this->db->limit(1,0);
       $result=$this->db->get()->result_array();
      
        return $result;
    }
    public function getAngularAlbumData($params)
    {
        $this->db->select('*');
        $this->db->where($params);
        $result=$this->db->get('medialibrary')->result_array();
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
    
    public function mediaOnStatus($params){
        $result=$this->db->select('*')->where($params)->get('medialibrary')->result_array();
        return $result;
    }
    
}
?>