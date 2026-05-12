<?php
if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Mylibrary
{
    function __construct() 
    {
    $this->CI =& get_instance();
    $this->CI->load->database();
    }

 
    
    public function getMenus($params)
    {
        // Main menus 
        $condition=array('c.ulbid'=>$params['ulbid'],'c.langId'=>$params['langId'],'s.menu_type_id'=>$params['menu_type_id']);
        
        $select_array=array('s.page_id','s.menu_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller');
        $this->CI->db->select($select_array);
        $this->CI->db->from('site_main_menu s');
        $this->CI->db->join('custom_menus c','s.page_id=c.page_id');
        $this->CI->db->where($condition);
        $this->CI->db->order_by('menu_id','ASC');
        $result['main_menus']=$this->CI->db->get()->result_array();
        
        //echo $this->CI->db->last_query();
        
        //Sub menus
         $condition=array('c.ulbid'=>$params['ulbid'],'c.langId'=>$params['langId']);
       
        $select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.meta_photo');
        $this->CI->db->select($select_array);
        $this->CI->db->from('site_sub_menus s');
        $this->CI->db->join('custom_menus c','s.page_id=c.page_id');
       // $this->CI->db->where('c.ulbid',$params['ulbid']);
	    $this->CI->db->where($condition);
        $this->CI->db->order_by('sub_menu_id','ASC');
        $result['sub_menus']=$this->CI->db->get()->result_array();
        
        // sub sub menus
        
        $select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','s.sub_sub_menu_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.meta_photo');
        $this->CI->db->select($select_array);
        $this->CI->db->from('site_sub_sub_menus s');
        $this->CI->db->join('custom_menus c','s.page_id=c.page_id');
       // $this->CI->db->where('c.ulbid',$params['ulbid']);
	    $this->CI->db->where($condition);
        $this->CI->db->order_by('sub_menu_id','ASC');
        $result['sub_sub_menus']=$this->CI->db->get()->result_array();
        
        
        // MENUS STOTING INTO ARRAYS
        
         $pages['mainmenu']=array();
         $pages['submenu']=array();
         $pages['chilemenu']=array();
	    
	    foreach($result['sub_menus'] as $key=>$submenuarray)
	    {
	        
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['page_name']=$submenuarray['page_name'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['controller']=$submenuarray['controller'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_custumlink']=$submenuarray['is_custumlink'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_target_blank']=$submenuarray['is_target_blank'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['meta_photo']=$submenuarray['meta_photo'];
	        
	        
	    }
	    
	    array_push($pages['submenu'],$data2);
	    
	    
	    
	    foreach($result['sub_sub_menus'] as $key=>$submenuarray)
	    {
	       	        
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['page_name']=$submenuarray['page_name'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['controller']=$submenuarray['controller'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_custumlink']=$submenuarray['is_custumlink'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_target_blank']=$submenuarray['is_target_blank'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['meta_photo']=$submenuarray['meta_photo'];
	        
	    }
	    
	    array_push($pages['chilemenu'],$data3);
	    
	    foreach($result['main_menus'] as $key=>$mainmenuarray)
	    {
	        
	       
	        
	        $data1[$mainmenuarray['menu_id']]['page_name']=$mainmenuarray['page_name'];
	        $data1[$mainmenuarray['menu_id']]['controller']=$mainmenuarray['controller'];
	        $data1[$mainmenuarray['menu_id']]['is_custumlink']=$mainmenuarray['is_custumlink'];
	        $data1[$mainmenuarray['menu_id']]['is_target_blank']=$mainmenuarray['is_target_blank'];
	        $data1[$mainmenuarray['menu_id']]['site_controller']=$mainmenuarray['site_controller'];
	        $data1[$mainmenuarray['menu_id']]['child']=array();
	        
	        
	        
	   }
	   
	   if(isset($data1))
	   {
	       array_push($pages['mainmenu'],$data1);
	   }
        
        
        return $pages;
        
    }
}
?>