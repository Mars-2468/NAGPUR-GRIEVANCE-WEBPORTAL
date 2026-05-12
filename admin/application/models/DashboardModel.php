<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class DashboardModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function add_user($val)
    {
       // echo $sql ="insert into users ('user_id','user_pwd','user_type','ulbid') values('".$val['user_id']."',PASSWORD('".$val['user_id']."','U','".$val['ulbid']."'))";
        //$this->db->query($sql);
        //echo "<br>";
    }
    
    public function ulb_list()
    {
        $select_array=array('ulbid','ulbname');
        $this->db->select($select_array);
        $result=$this->db->get('ulbmst');
        return $result;
        
    }
    
    public function updatepagename($params)
    {
    $set_array=array('site_controller'=>$params['site_controller']);
      $condition=array('page_id'=>$params['page_id']);
      $this->db->set($set_array);
      $this->db->where($condition);
     
      $result=$this->db->update('custom_menus');
    }
    
    public function copysite()
    {
        $condition=array('ulbid'=>'056','theme_layout_id'=>1);
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($condition);
        $result=$this->db->get('custom_page_layouts');
        return $result;
    }
    
    public function addsite($params)
    {
        $this->db->insert('custom_page_layouts',$params);
        $this->db->insert('page_layouts',$params);
    }
    
    public function conf($params)
    {
      
      $select_array=array('site_controller','page_id');
      $condition=array('is_custumlink'=>'0');
      $this->db->select($select_array);
      $this->db->where($condition);
      $result=$this->db->get('custom_menus');
      
      return $result;
      
        
    }
   
}
?>