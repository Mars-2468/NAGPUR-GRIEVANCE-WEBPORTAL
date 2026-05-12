<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class AboutModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function aboutDataInsert($params)
    {
        $string=str_replace("'", "\'", $params['content']);
        
      $query="insert into about_mst (ulbid,content) values ('".$params['ulbid']."','".$string."') ON DUPLICATE KEY UPDATE content='".$string."'";
       $result=$this->db->query($query);
       
       //$result=$this->db->insert('about_mst',$string);
      
       return $result;
        
    }
    public function getaboutData($params)
    {
        $result=$this->db->select('content')->where($params)->get('about_mst')->result_array();
        return $result;
    }
}
?>