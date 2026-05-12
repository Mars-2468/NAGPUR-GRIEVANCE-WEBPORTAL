<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreatepageModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function is_existingPagename($params)
    {
        $select_array=array('COUNT(page_id) as count');
        $this->db->select($select_array);
        $this->db->where($params);
        $result = $this->db->get('custom_menus')->result_array();
        
        return $result;
    }
    
    public function customePageDataInsert($params)
    {
        
        
      
      
      
       $result=$this->db->insert('custom_menus',$params);
      
       $data['result']=$result;
       $data['pageId']=$this->db->insert_id();
       if($result!='')
       {
       $query = $this->db->query("select * from custom_menus where page_id='".$data['pageId']."';");
       foreach ($query->result_array()  as $user)
       $page_id= $user['page_id'];
       $is_custumlink= $user['is_custumlink'];
       $query1 = $this->db->query("select * from page_type_mst where page_type_id='".$is_custumlink."';");
       foreach ($query1->result_array()  as $page)
       $page_type_desc= $page['page_type_desc'];
       $content= $user['content'];
       $ts= $user['ts'];
       $author= $user['author'];
       
       $sql="insert into  logs(content_id,content_type,modified_content,datetime,author) values('".$page_id."','".$page_type_desc."','".$content."','".$ts."','".$author."')";
               $this->db->query($sql); 
       }
       //$result=$this->db->insert('about_mst',$string);
      
       return $data;
        
    }
    public function getaboutData($params)
    {
        $result=$this->db->select('content')->where($params)->get('about_mst')->result_array();
        return $result;
    }
    
}
?>