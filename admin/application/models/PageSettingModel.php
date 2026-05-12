<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class PageSettingModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function selectedPage($params)
    {
        $select_array=array('page_id');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('custom_menus')->row_array();
       
        return $result;
    }
    
    public function sethomepagecontent($params)
    {
        $update_array=array('is_homepage_content'=>'');
        $condition=array('ulbid'=>$params['ulbid'],'langId'=>$params['langId']);
        $this->db->set($update_array);
        $this->db->where($condition);
        if($this->db->update('custom_menus'))
        {
            $update_array=array('is_homepage_content'=>'1');
            $condition=array('ulbid'=>$params['ulbid'],'langId'=>$params['langId'],'page_id'=>$params['page_id']);
            $this->db->set($update_array);
            $this->db->where($condition);
            if($this->db->update('custom_menus'))
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            
        }
        
    }
    
    
}
?>