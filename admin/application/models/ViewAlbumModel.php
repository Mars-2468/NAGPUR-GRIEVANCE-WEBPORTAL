<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class ViewAlbumModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
        $this->load->helper("file");
    }
    
    
    
    public function getAlbumsPhotosCount($params)
    {
        
        $groupby = array('album_id','sub_album_id');
        $this->db->select('COUNT(id) as count,album_id,sub_album_id');
        $this->db->group_by($groupby);
        $result = $this->db->get('album_image_map');
        return $result; 
    }
    
    public function getSubAlbums($params)
    {
        $this->db->select('*');
        $this->db->where($params);
        $result = $this->db->get('sub_album_mst');
        return $result;
    }
    
    public function addSubAlbum($params)
    {
        $result = $this->db->insert('sub_album_mst',$params);
        return $result;
    }
    public function getAlbums($params)
    {
        $this->db->where($params);
        $result=$this->db->get('album_mst');
        return $result;
    }
    
    public function deleteContentimg($params)
    {
        $this->db->where($params);
        $result=$this->db->delete('medialibrary_temp');
        return $result;
    }
    
    public function deleteMediaTempfiles($slides)
    {
        
        $this->db->where_in('slide_id',$slides);
        $this->db->delete('medialibrary_temp');
        
    }
    
    public function insertImageDet($params)
    {
        $result=$this->db->insert('medialibrary',$params);
        return $result;
    }
    
    public function getImageDet($slide_id)
    {
        $condition=array('slide_id'=>$slide_id);
        $this->db->select('*');
        $this->db->where($condition);
        $result=$this->db->get('medialibrary_temp')->row_array();
        return $result;
    }
    
    public function addPhotogallery($params)
    {
        $this->db->insert('album_image_map',$params);
        
    }
    public function lastUpdatedTS($params){
        //$param = array('lastUpdatedBy'=>$this->session->userdata('username'),'lastUpdatedTS'=>'NOW()');
        $update_array=array('lastUpdatedBy'=>$params['lastUpdatedBy']);
        $delete_array=array('lastUpdatedBy'=>'');
        $where_array=array('ulbid'=>$params['ulbid'],'album_id'=>$params['album_id']);
        
        $this->db->set($delete_array);
        $this->db->where($where_array);
        $this->db->update('album_mst');
        
        $this->db->set($update_array);
        $this->db->where($where_array);
        $result = $this->db->update('album_mst');
        echo $result;
    }
    
    public function getSubAlbumimages($params)
    {
        $this->db->select('*');
        $this->db->where($params);
        $result = $this->db->get('album_image_map');
        return $result;
    }
    
    public function getSubAlbumdet1($params)
    {
        $select_array=array('album_id','sub_album_id','album_desc');
        $this->db->select($select_array);
        $this->db->from('sub_album_mst');
         $this->db->where($params);
         $result=$this->db->get()->result_array();
        //echo $this->db->last_query();
        
        return $result;
    }
    
    public function getAlbumdet1($params)
    {
        $select_array=array('album_id','album_desc');
        $this->db->select($select_array);
        $this->db->from('album_mst');
         $this->db->where($params);
         $result=$this->db->get()->result_array();
        $this->db->last_query();
        return $result;
    }
    
    public function getAlbumdet($params)
    {
        $array1 = array();
        $select_array=array('a.album_id','a.album_desc','aim.*');
        $this->db->select($select_array);
        $this->db->from('album_image_map aim');
        $this->db->join('album_mst a','a.album_id=aim.album_id');
        $this->db->where($params);
        $this->db->order_by('ts','DESC');
        $result1=$this->db->get()->result_array();
        $array1[] = $result1;
        
        $param = array('album_id'=>$params['aim.album_id']);
        $this->db->select('*');
        $this->db->from('medialibrary ml');
        $this->db->join('photogallery_media_map pmp','pmp.slide_id=ml.slide_id');
        $this->db->where($param);
        $this->db->order_by('ml.ts','DESC');
        $result2 = $this->db->get()->result_array();
        $array1[] = $result2;
        //echo $this->db->last_query();
        return $array1;
    }
    
    
    
    public function addAlbum($params)
    {
        $result=$this->db->insert('album_mst',$params);
        return $result;
    }
    
    public function getAlbumList($params)
    {
        $select_array1=array('album_desc','album_id','ulbid','langId');
        $this->db->select('*');
        $this->db->where($params);
        $this->db->order_by('ts','DESC');
        $data['albumList']=$this->db->get('album_mst')->result_array();
        
        $allAlbum_id = array();
        $this->db->select('album_id','photosCount');
        $this->db->where($params);
        $this->db->order_by('ts','DESC');
        $allAlbum_id = $this->db->get('album_mst')->result_array();
        
        $result1 = array();
        $result2 = array();
        $select_array=array('IFNULL(COUNT(id),0) as photosCount','album_id');
        $this->db->select($select_array);
        $this->db->where($params);
        $this->db->order_by('ts','DESC');
        $this->db->group_by('album_id');
        //$data['countList']=$this->db->get('album_image_map')->result_array();
        //print_r($data['countList']);
        $result1 = $this->db->get('album_image_map')->result_array();
        
        
        $select_array1=array('IFNULL(COUNT(slide_id),0) as photosCount','album_id');
        $this->db->select($select_array1);
        $this->db->where($params);
        $this->db->order_by('ts','DESC');
        $this->db->group_by('album_id');
        //$data['countList1']=$this->db->get('photogallery_media_map')->result_array();
        $result2 = $this->db->get('photogallery_media_map')->result_array();
        
        $result_1 = array();
        $result_2 = array();
        $result = array();
        
        foreach($result1 as $key=>$value){
           $result_1[$value['album_id']]['photosCount'] = $value['photosCount'];
        }
        foreach($result2 as $key2=>$value2){
            $result_2[$value2['album_id']]['photosCount'] = $value2['photosCount']; 
        }
        
        foreach($allAlbum_id as $key=>$value){
             $result[$value['album_id']]['album_id'] = $value['album_id'];
            $result[$value['album_id']]['photosCount'] += $result_1[$value['album_id']]['photosCount'];
            $result[$value['album_id']]['photosCount'] += $result_2[$value['album_id']]['photosCount'];
        }
       
        //print_r($result);
        
        
        $data['countList'] = $result;
        
        $sel_array = array('ts as ts1','updatedBy as updatedBy1','album_id');
        $this->db->select($sel_array);
        $this->db->where($params);
        $this->db->group_by('album_id');
        $this->db->order_by('ts','DESC');
        $data['updatedList']=$this->db->get('album_image_map')->result_array();
       
        return $data;
    }
    
    public function getMediaData_temp($params){
        $this->db->select('*');
        $this->db->from('medialibrary_temp');
        $this->db->where($params);
        $this->db->order_by('ts','DESC');
        $result=$this->db->get()->result_array();
        //$this->db->last_query();
        return $result;
    }
    
    
    public function getMediaData($params){
        $this->db->select('*');
        $this->db->from('medialibrary');
        $this->db->where($params);
        $this->db->order_by('ts','DESC');
        $result=$this->db->get()->result_array();
        //$this->db->last_query();
        return $result;
    }
    
    public function createMediaData($params){
        $this->db->select('*');
        $this->db->from('medialibrary');
        $this->db->where($params);
        $this->db->order_by('ts','DESC');
        $result=$this->db->get()->result_array();
        
        return $result;
    }
    
    public function checkingAlbumName($params){
        $this->db->select('album_desc');
        $this->db->where($params);
        $this->db->from('album_mst');
        $result = $this->db->get();
        //$result=$this->db->select($select_array)->where($params)->get('album_mst')->result_array();
        if($result->num_rows()>0)
            return TRUE;
        else
            return FALSE;
    }
    
    public function updateAlbumName($params){
        $now = date('Y-m-d H:i:s');
        $update_array = array('album_desc'=>$params['album_desc'],'lastUpdatedBy'=>$params['updatedBy']);
        $album_id = $params['album_id'];
        $ulbid = $params['ulbid'];
        $where_array = array('album_id'=>$params['album_id'],'ulbid'=>$params['ulbid']);
        $this->db->set($update_array);
        $this->db->where($where_array);
        $result = $this->db->update('album_mst');
        return $result;
    }
    
    public function getAlbumName($params){
        $this->db->select('*');
        $this->db->where($params);
        $this->db->from('album_mst');
        $result = $this->db->get()->result_array();
        //$result=$this->db->select($select_array)->where($params)->get('album_mst')->result_array();
        
        return $result;
    }
    
    public function deleteAlbum($params){
        
        $curyear=date("Y");
        $curmonth=date('m');
        $ulbid = $params['ulbid'];
        $folder_path = "../assets/".$ulbid."/".$curyear."/".$curmonth."/albums/";
        
        $album_id = $params['album_id'];
        $select_album_mst = $this->db->query("SELECT * FROM album_mst WHERE album_id = '".$album_id."' AND ulbid='".$ulbid."'");
        
        $select_album_image_map = $this->db->query("SELECT * FROM album_image_map WHERE album_id = '".$album_id."' AND ulbid='".$ulbid."'");
        $row_album_image_map = $select_album_image_map->num_rows();
        
        $select_photogallery_media_map = $this->db->query("SELECT * FROM photogallery_media_map WHERE album_id = '".$album_id."' AND ulbid='".$ulbid."'");
        $row_photogallery_media_map = $select_photogallery_media_map->num_rows();
        
        
        if($row_album_image_map > 0 && $row_photogallery_media_map == 0){
            foreach($select_album_mst->result() as $record){
                //return $folder_path.$record->album_desc;
                $folder_path1 = $folder_path.$record->album_desc;
                delete_files($folder_path1, true);
                rmdir($folder_path1);
                $query = $this->db->query("DELETE album_mst,album_image_map FROM album_mst INNER JOIN album_image_map ON album_image_map.album_id=album_mst.album_id WHERE album_mst.album_id = '".$album_id."' AND album_mst.ulbid='".$ulbid."'");
                return $this->db->affected_rows();
            }
           // $query = $this->db->query("DELETE album_mst,album_image_map FROM album_mst INNER JOIN album_image_map ON album_image_map.album_id=album_mst.album_id WHERE album_mst.album_id = '".$album_id."' AND album_mst.ulbid='".$ulbid."'");
           // return $this->db->affected_rows();
        }else if($row_photogallery_media_map > 0 && $row_album_image_map == 0){
            $query = $this->db->query("DELETE album_mst,photogallery_media_map FROM album_mst INNER JOIN photogallery_media_map ON photogallery_media_map.album_id=album_mst.album_id WHERE album_mst.album_id = '".$album_id."' AND album_mst.ulbid='".$ulbid."'");
            return $this->db->affected_rows();
        }else if($row_album_image_map > 0 && $row_photogallery_media_map > 0){
            foreach($select_album_mst->result() as $record){
                
                $folder_path1 = $folder_path.$record->album_desc;
                delete_files($folder_path1, true);
                rmdir($folder_path1);
                
                $query = $this->db->query("DELETE photogallery_media_map,album_image_map,album_mst FROM album_image_map INNER JOIN album_mst INNER JOIN photogallery_media_map WHERE album_image_map.album_id=album_mst.album_id AND photogallery_media_map.album_id=album_mst.album_id AND album_mst.album_id='".$album_id."'");
            }   
            
          
            return $this->db->affected_rows();
        }else{
            foreach($select_album_mst->result() as $record){
                //return $folder_path.$record->album_desc;
                $folder_path1 = $folder_path.$record->album_desc;
                delete_files($folder_path1, true);
                rmdir($folder_path1);
                $this->db->where($params);
                $this->db->delete('album_mst');
                return $this->db->affected_rows();
            }    
        }
        
    }
    
    public function getMediaImgData($params){
        $uid = $this->session->userdata('ulbid');
        $is_image = '1';
        $this->db->select('*');
        $this->db->from('medialibrary');
        $this->db->where($params);
        $result = $this->db->get()->result_array();
        return $result;
        // $result = $this->db->query("SELECT * FROM medialibrary WHERE ulbid='".$uid."' AND is_image='".$is_image."'");
        // return $result->result_array();
    }
    public function getMediaImgDatas($params){
        //$uid = $this->session->userdata('ulbid');
        $album_id= $this->session->userdata('album_id');
        $is_image = '1';
        $this->db->select('*');
        $this->db->from('album_image_map');
        $this->db->where($params);
        $result = $this->db->get()->result_array();
        return $result;
       
    }
}
?>