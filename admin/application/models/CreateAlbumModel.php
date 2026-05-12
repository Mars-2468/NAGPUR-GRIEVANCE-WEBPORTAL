<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreateAlbumModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function albumDataInsert($params)
    {
       $string=str_replace("'", "\'", $params['album_desc']);
       $query="insert into album_mst (ulbid,album_desc,album_title) values ('".$params['ulbid']."','".$string."','".$params['album_title']."')";
       $result=$this->db->query($query);
       return $result;
    }
     public function deleteContent($params)
    {
        $this->db->where($params);
        $result=$this->db->delete('album_mst');
        return $result;
    }
    
    public function updateContent($params)
    {
        $data=array('album_desc'=>$params['album_desc'],'album_title'=>$params['album_title']);
        $this->db->set($data);
        $this->db->where('album_id',$params['album_id']);
        $result=$this->db->update('album_mst');
        return $result;
    }
    public function getalbumData($params)
    {
        $select_array=array('album_id','album_desc','ts','album_title');
        $result=$this->db->select($select_array)->where($params)->get('album_mst');
        return $result;
    }
    
     public function albamdata($params,$album_id)
    {
       $result=$this->db->where('album_id',$album_id);
       $result=$this->db->update('album_mst',$params);
       return $result;
    }
      public function get_edits($id)
    {
$this->db->select('*');
$this->db->from('album_mst');
$this->db->where('album_id',$id);
$query = $this->db->get();
$result = $query->result();
return $result;
    }
    
}
?>