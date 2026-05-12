<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class MapPageModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    // get menu type id
    public function getMenutypeid($ulbid)
    {
        $select_array=array('MAX(menu_type_id) as menu_type_id');
        $condition=array('ulbid'=>$ulbid);
        $this->db->select($select_array);
        $this->db->where($condition);
        $result=$this->db->get('menu_type_mst')->row_array();
        return $result; 
    }
    // create new menu
    
    public function saveNewMenu($params)
    {
        $result=$this->db->insert('menu_type_mst',$params);
        return $result;
    }
    // functio for updating page title attribute and navigation label for map page boostrap modal
    
    public function updatePageInfo($params)
    {
        $set_array=array('page_title'=>$params['page_title'],'page_name'=>$params['page_name'],'hover_title'=>$params['hover_title'],'is_target_blank'=>$params['is_targetblank'],'is_alert'=>$params['is_alert']);
        if($params['page_url'] !=='')
        {
            $set_array['site_controller']=$params['page_url'];
        }
        $condition=array('page_id'=>$params['page_id']);
        $this->db->set($set_array);
        $this->db->where($condition);
        $result=$this->db->update('custom_menus');
        return $result;
    }
    
    // function for getting page title attribute and navigation label for map page boostrap modal
    
    public function getPageInfo($params)
    {
        $select_array=array('page_title','page_name','hover_title','is_target_blank','is_alert','site_controller');
        $result=$this->db->select($select_array)->where($params)->get('custom_menus')->result_array();
        return $result;
    }
    
    // function for creating custom link in map page 
    
    public function createCustomLink($params,$menu_type_id)
    {
        if($this->db->insert('custom_menus',$params))
        {
            $page_id=$this->db->insert_id();
            $params=array('menu_type_id'=>$menu_type_id,'ulbid'=>$this->session->userdata('ulbid'),'page_id'=>$page_id,'menu_name'=>$params['page_name'],'author'=>$this->session->userdata('username'),'flag'=>1,'langId'=>$params['langId']);
            if($this->db->insert('site_main_menu',$params))
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
        
        $params_del=array('menu_type_id'=>$menu_type,'ulbid'=>$this->session->userdata('ulbid'),'langId'=>$this->session->userdata('langId'));
        
       
		    
		    if(count($jsonobject) >= 1)
		    {
		    
		    $this->db->where($params_del);
		    $this->db->delete('site_main_menu',$params_del);
		    $this->db->delete('site_sub_menus',$params_del);
		    $this->db->delete('site_sub_sub_menus',$params_del);
		    }
		    
		    //return $this->db->last_query();
		    
		    
        
        
        foreach($jsonobject as $key=>$mainval)
	{
		if($key >= 0 && $mainval['deleted']==0)
		{
		    
		    
		    
		    $params=array('menu_type_id'=>$menu_type,'ulbid'=>$this->session->userdata('ulbid'),'page_id'=>$mainval['slug'],'menu_name'=>$mainval['name'],'author'=>$this->session->userdata('username'),'flag'=>1,'langId'=>$this->session->userdata('langId'));
		    
			
			
			if($this->db->insert('site_main_menu',$params))
			{
				if(count($mainval['children']) > 0)
				{
					$parentId=$this->db->insert_id();
					foreach($mainval['children'] as $subkey=>$subval)
					{
					    $params_sub=array('menu_type_id'=>$menu_type,'ulbid'=>$this->session->userdata('ulbid'),'main_menu_id'=>$parentId,'page_id'=>$subval['slug'],'sub_menu_desc'=>$subval['name'],'flag'=>1,'langId'=>$this->session->userdata('langId'));
					
    					if($subval['deleted']==0)
    					{
    					
    						if($this->db->insert('site_sub_menus',$params_sub))
    						{
    							if(count($subval['children']) > 0)
    								{
    									$subId=$this->db->insert_id();
    									
    									foreach($subval['children'] as $subkey=>$subsubval)
    										{
    										    $params_sub_sub=array('menu_type_id'=>$menu_type,'ulbid'=>$this->session->userdata('ulbid'),'main_menu_id'=>$parentId,'sub_menu_id'=>$subId,'page_id'=>$subsubval['slug'],'subsubdesc'=>$subsubval['name'],'flag'=>1,'langId'=>$this->session->userdata('langId'));
    											
    											if($subsubval['deleted']==0)
    											{
    											$this->db->insert('site_sub_sub_menus',$params_sub_sub);
    											}
    										}
    								}
    						}
    						
    						
    					}	
						
						
					}
				}
			}
		}
		
		
	}
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
    
     public function getDragDropMainMenuData($params)
    {
        $select_array=array('sm.*','c.page_name','c.controller','c.is_custumlink');
        $this->db->select($select_array);
        $this->db->from('site_main_menu sm');
        $this->db->join('custom_menus c','sm.page_id=c.page_id','inner');
        $this->db->where($params);
        $this->db->order_by('menu_id','ASC');
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