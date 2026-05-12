<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class WidgetLayoutMapModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    // read widgest from widget master
    
    public function publishedPages($params)
    {
       
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('widget_mst');
        return $result;
       
    }
    public function ulbList()
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->order_by('ulbname','ASC');
        $result=$this->db->get('ulbmst');
        return $result;
    }
    
    /// constant page layouts
    
    public function getPageLayouts($params)
    {
        /*$select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('custom_page_layouts');
        return $result;*/
        
        $select_array=array('*');
        $this->db->select($select_array);
        //$this->db->where($params);
        $result=$this->db->get('page_layouts');
        return $result;
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
    
    public function updatePages($jsonobject,$menu_type,$ulbid)
    {
        
        $params_del=array('page_layout_id'=>$menu_type,'ulbid'=>$ulbid,'langId'=>$this->session->userdata('langId'));
        
       
		    
		    if(count($jsonobject) >= 1)
		    {
		    
		    $this->db->where($params_del);
		    $this->db->delete('layout_widget_map',$params_del);
		    
		    }
		    
		    //return $this->db->last_query();
		    
		    
        
        $i=1;
        foreach($jsonobject as $key=>$mainval)
	{
		if($key >= 0 && $mainval['deleted']==0)
		{
		    
		    
		    
		    $params=array('page_layout_id'=>$menu_type,'ulbid'=>$ulbid,'widget_id '=>$mainval['slug'],'menu_name'=>$mainval['name'],'author'=>$this->session->userdata('username'),'flag'=>1,'langId'=>$this->session->userdata('langId'),'sort_order'=>$i);
		    
			
			
			if($this->db->insert('layout_widget_map',$params))
			{
			    
			}
	$i++;	}
		
		
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
        
        $select_array=array('sm.*','c.*');
        $this->db->select($select_array);
        $this->db->from('layout_widget_map sm');
        $this->db->join('widget_mst c','sm.widget_id=c.widget_id');
        $this->db->where($params);
        $this->db->order_by('sno','ASC');
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
    
    public function ajax_page_search($ulbid,$flag,$langId,$keyword)
    {
        //echo $ulbid;
        $keyword1=strtoupper($keyword);
        $keyword2=strtolower($keyword);
        $keyword3=ucfirst($keyword);
        
       $sql="select * from widget_mst where ulbid='".$ulbid."' and flag='1' and langId='".$langId."' and (widget_name LIKE '%$keyword1%' or widget_name LIKE '%$keyword2%' or widget_name LIKE '%$keyword3%')";
     
       $result = $this->db->query($sql);
       return $result;
    }
}
?>