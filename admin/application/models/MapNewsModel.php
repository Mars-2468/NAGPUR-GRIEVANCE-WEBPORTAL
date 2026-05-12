<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class MapNewsModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    // functio for updating page title attribute and navigation label for map page boostrap modal
    
    public function updatePageInfo($params)
    {
        $set_array=array('page_title'=>$params['page_title'],'page_name'=>$params['page_name'],'is_target_blank'=>$params['is_targetblank']);
        $condition=array('page_id'=>$params['page_id']);
        $this->db->set($set_array);
        $this->db->where($condition);
        $result=$this->db->update('custom_menus');
        return $result;
    }
    
    // function for getting page title attribute and navigation label for map page boostrap modal
    
    public function getPageInfo($params)
    {
        $select_array=array('page_title','page_name','is_target_blank');
        $result=$this->db->select($select_array)->where($params)->get('custom_menus')->result_array();
        return $result;
    }
    
    // function for creating custom link in map page 
    
    public function createCustomLink($params,$menu_type_id)
    {
        if($this->db->insert('custom_menus',$params))
        {
            $page_id=$this->db->insert_id();
            $params=array('ulbid'=>$this->session->userdata('ulbid'),'page_id'=>$page_id,'menu_name'=>$params['page_name'],'author'=>$this->session->userdata('username'),'flag'=>1,'langId'=>$this->session->userdata('langId'));
            if($this->db->insert('news_mst',$params))
			{
			    return TRUE;
			}
			else
			{
			    return FALSE;
			}
        }
        
    }
    
    public function updatePages($jsonobject,$menu_type)
    {
        
        $params_del=array('ulbid'=>$this->session->userdata('ulbid'),'langId'=>$this->session->userdata('langId'));
        
       
		    
		    if(count($jsonobject) >= 1)
		    {
		    
		    $this->db->where($params_del);
		    $this->db->delete('news_mst',$params_del);
		    
		    }
		    
		    
        $i=1;
        
        foreach($jsonobject as $key=>$mainval)
	{
		if($key >= 0 && $mainval['deleted']==0)
		{
		    
		    
		    
		    $params=array('ulbid'=>$this->session->userdata('ulbid'),'page_id'=>$mainval['slug'],'menu_name'=>$mainval['name'],'author'=>$this->session->userdata('username'),'flag'=>1,'langId'=>$this->session->userdata('langId'),'sort_order'=>$i);
		    
			
			
			if($this->db->insert('news_mst',$params))
			{
			
			}
			$i++;
		}
		
		
	}
    }
    
  
     public function deleteContent($params)
    {
        $this->db->where($params);
        $result=$this->db->delete('album_mst');
        return $result;
    }
    
   
    
     public function getDragDropMainMenuData($params)
    {
        $select_array=array('sm.*','c.page_name','c.controller','c.is_custumlink');
        $this->db->select($select_array);
        $this->db->from('news_mst sm');
        $this->db->join('custom_menus c','sm.page_id=c.page_id');
        $this->db->where($params);
        $this->db->order_by('sort_order','ASC');
        $result=$this->db->get();
        
        return $result;
    }
    
     public function getDragDropSubMenuData($params)
    {
       
        
        
        $select_array=array('sm.*','c.page_name','c.controller','c.is_custumlink');
        $this->db->select($select_array);
        $this->db->from('site_sub_menus sm');
        $this->db->join('custom_menus c','sm.page_id=c.page_id');
        $this->db->where($params);
        $this->db->order_by('sub_menu_id','ASC');
        $result=$this->db->get();
        
        return $result;
        
        
    }
     public function getDragDropSubSubMenuData($params)
    {
       
        
        $select_array=array('sm.*','c.page_name','c.controller','c.is_custumlink');
        $this->db->select($select_array);
        $this->db->from('site_sub_sub_menus sm');
        $this->db->join('custom_menus c','sm.page_id=c.page_id');
        $this->db->where($params);
        $this->db->order_by('sub_sub_menu_id','ASC');
        $result=$this->db->get();
        
        
        return $result;
    }
}
?>