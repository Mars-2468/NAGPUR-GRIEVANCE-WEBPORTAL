<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class PageLayoutModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
     public function getDragDropMainMenuData($params)
    {
        $this->session->set_userdata('activethemeid',1);
        $select_array=array('page_layout_desc','sort_order','page_layout_id','page_layout_id as page_id');
       // $condition=array('theme_layout_id'=>$this->session->userdata('activethemeid'));
        $this->db->select($select_array);
        $this->db->from('custom_page_layouts');
        $this->db->where($params);
        $this->db->order_by('sort_order','ASC');
        $result=$this->db->get();
        
        
        return $result;
    }
    
    public function updatePages($jsonobject)
    {
        
        $params_del=array('ulbid'=>$this->session->userdata('ulbid'),'langId'=>$this->session->userdata('langId'),'theme_layout_id'=>$this->session->userdata('activethemeid'));
        $select_array=array('page_layout_id','source');
        
        $this->db->select($select_array);
        $this->db->where($params_del);
        $source_list=$this->db->get('custom_page_layouts');
        foreach($source_list->result() as $key=>$val)
        {
            $source_list2[$val->page_layout_id]=$val->source;
        }
        
        
       
		    
		    if(count($jsonobject) >= 1)
		    {
		    
		    $this->db->where($params_del);
		    $this->db->delete('custom_page_layouts',$params_del);
		    
		    }
		    
		    
        $i=1;
        
        foreach($jsonobject as $key=>$mainval)
	{
		if($key >= 0 && $mainval['deleted']==0)
		{
		    
		    
		    
		    $params=array('ulbid'=>$this->session->userdata('ulbid'),'page_layout_id'=>$mainval['slug'],'page_layout_desc'=>$mainval['name'],'author'=>$this->session->userdata('username'),'flag'=>1,'langId'=>$this->session->userdata('langId'),'sort_order'=>$i,'theme_layout_id'=>$this->session->userdata('activethemeid'),'source'=>$source_list2[$mainval['slug']]);
		    
			
			
			if($this->db->insert('custom_page_layouts',$params))
			{
			
			}
			$i++;
		}
		
		
	}
    }
    
}
?>