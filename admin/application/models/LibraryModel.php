<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class LibraryModel extends CI_Model
{
    
    
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function insertMediaFilestowidget($params,$table)
    {
        $this->db->insert($table,$params);
    }
    
    public function addLibraryFiles($params)
    {
        $this->db->insert('medialibrary',$params);
    }
    
    public function getFileInfo($val)
    {
        $where=array('slide_id'=>$val);
        $result=$this->db->select('*')->where($where)->get('medialibrary');
        return $result;
    }
    
    public function getLibraryData2($params)
    {
        $result=$this->db->select('*')->where($params)->get('medialibrary')->result_array();
        return $result;
    }
    
    public function getLibraryData($params)
    {
        $result=$this->db->select('*')->where($params)->get('medialibrary');
        return $result;
    }
    
    public function insertMediaFiles($params)
    {
        /*foreach($params as $key=>$val)
        {
            $arg=array('full_path'=>$val,'album_id'=>$this->session->userdata('albumid'),'ulbid'=>$this->session->userdata('ulbid'));
           $this->db->insert('photo_gallery_mst',$arg);
        }
        return true;*/
        
        $result=$this->db->insert('photo_gallery_mst',$params);
        return $result;
        
    }
    
    public function deleteMediaFiles($params)
    {
        $this->db->where($params);
        $result=$this->db->delete('medialibrary');
    }
}
?>