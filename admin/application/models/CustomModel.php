<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CustomModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function getPortalUrl($ulbid)
    {
        $select_array=array('base_url');
        $condition=array('ulbid'=>$ulbid);
        $this->db->select($select_array);
        $this->db->where($condition);
        $result=$this->db->get('ulbmst')->row_array();
        return $result;        
    }
   
	public function getInnerpageLayouts($theme_id)
	{
       $params=array('theme_id'=>$theme_id);
       $select_array=array('sidebars_id','sidebars_desc');
       $this->db->select($select_array);
       $this->db->where($params);
       $result=$this->db->get('innerpage_layout_master');
       return $result;       
	}
   
	public function getThemeId($params)
	{
       $select_array=array('theme_id');
       $this->db->select($select_array);
       $this->db->where($params);
       $result=$this->db->get('ulbmst')->row_array();
       return $result;
	}
   
    public function getpageData($params)
    {
        $select_array=array('*');
        $result=$this->db->select($select_array)->where($params)->get('custom_menus')->result_array();
        return $result;
    }
	
    public function getSliderData($pageId)
    {
        $select_array=array('*');
		$params=array('page_id'=>$pageId);
        $result=$this->db->select($select_array)->where($params)->get('slider_mst2')->result_array();
        return $result;
    }
	
    public function updatePageContent($params,$pageid)
    {
       
	   
		// print_r($params);
        $condition=array('page_id'=>$pageid);
        $this->db->set($params);
        $this->db->where($condition);
		$result=$this->db->update('custom_menus');
		$test=$this->db->last_query();
       
      //  echo "<pre>";print_r($test);echo "</pre>";die('111');
        if($result!='')
		{
			$query = $this->db->query("select * from custom_menus where page_id='".$pageid."';");
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
        
        return $result;
        
        
        /*$db = get_instance()->db->conn_id;
        $query="update custom_menus set content='".mysqli_real_escape_string($db,$params['content'])."',page_name='".$params['page_name']."',hover_title='".$params['hover_title']."',page_sidebars_id='".$params['page_sidebars_id']."',pagekeywords='".$params['ptags']."',meta_desc='".$params['meta_desc']."',meta_subject='".$params['meta_subject']."'  where page_id='".$params['pageid']."'";
        if($this->db->query($query))
        {
            return 1;
        }
        else
        {
            return 0;
        }*/
    }
	
    public function updatePagename($params)
    {
        $update_array=array('controller'=>$params['controller'],'permalink'=>$params['permalink'],'site_controller'=>$params['site_controller']);
        $condition=array('page_id'=>$params['page_id']);
        $this->db->set($update_array);
        $this->db->where($condition);
        $result=$this->db->update('custom_menus');
       
    }
    
    public function is_existingPagename($params)
	{
        $select_array=array('COUNT(page_id) as count ');
        $this->db->select($select_array);
        $this->db->where($params);
        $result = $this->db->get('custom_menus')->row_array();
		return $result;       
	}
    
}
?>