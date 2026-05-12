<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class AddMenuModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function changeLanguage($params)
    {
        $result=$this->db->select('language_desc')->where($params)->get('language_mst')->result_array();
        return $result;
    }
    
    
    public function updateContent($params)
    {
        $updateFields=array('slide_desc'=>$params['slide_desc'],'title'=>$params['title']);
        $this->db->set($updateFields);
        $this->db->where('slide_id',$params['slide_id']);
        $result=$this->db->update('slider_mst');
        
        return $result;
    }
    
    public function deleteContent($params)
    {
        $this->db->where($params);
        $result=$this->db->delete('photo_gallery_mst');
        return $result;
    }
    
    public function menuInsert($params)
    {
       
       $result=$this->db->insert('site_main_menu',$params);
       
       return $result;
        
    }
    public function getMenuData($ulbid)
    {
        $select_array=array('menu_type_id','menu_type_desc'); 
        $condition=array('ulbid'=>$ulbid);
        $result=$this->db->select($select_array)->where($condition)->get('menu_type_mst');
      
        return $result;
    }
    
     public function getSiteMenuData($params)
    {
        $select_array=array('s.*','m.menu_type_desc'); 
        $this->db->select($select_array);
        $this->db->from('site_main_menu s');
        $this->db->join('menu_type_mst m','s.menu_type_id=m.menu_type_id','inner');
        $this->db->where('s.ulbid',$params['ulbid']);
        $result=$this->db->get();
        
        
        return $result;
    }
    
    public function geteditSiteMenuData($id)
    {
       $this->db->select('*'); 
       $this->db->from('site_main_menu'); 
       $this->db->where('menu_id', $id); 
       $result=$this->db->get();
        
        
        return $result;
    }
    
    
      public function menuupdate($id,$params)
    {
       $result=$this->db->where('menu_id',$id);
       $result=$this->db->update('site_main_menu',$params);
       
       
       return $result;
        
    }
    
    public function publishedPages($params)
    {
        $select_array=array('*');
        $result=$this->db->select($select_array)->where($params)->get('custom_menus');
        
        return $result;
    }
    
    public function ajax_page_search($ulbid,$is_draft,$is_custumlink,$langId,$keyword,$id)
    {
       
        if($id=='0') {
        $keyword1=strtoupper($keyword);
        $keyword2=strtolower($keyword);
        $keyword3=ucfirst($keyword);
        
        $sql = "Select * from custom_menus where ulbid='".$ulbid."' and is_draft='".$is_draft."' and is_custumlink='".$is_custumlink."' and langId='".$langId."' and (page_title LIKE '%$keyword1%' or page_title LIKE '%$keyword2%' or page_title LIKE '%$keyword3%')";
        
        $result = $this->db->query($sql);
           
        }
        
        else if($id=='2'){
            
        $keyword1=strtoupper($keyword);
        $keyword2=strtolower($keyword);
        $keyword3=ucfirst($keyword);
        
        $sql1 = "Select * from custom_menus where ulbid='".$ulbid."' and is_draft='".$is_draft."' and is_custumlink='".$is_custumlink."' and langId='".$langId."' and (page_title LIKE '%$keyword1%' or page_title LIKE '%$keyword2%' or page_title LIKE '%$keyword3%')";
        $result = $this->db->query($sql1);
         
        }
      
        else if($id=='1'){
            
        $keyword1=strtoupper($keyword);
        $keyword2=strtolower($keyword);
        $keyword3=ucfirst($keyword);
        
        $sql2 = "Select * from custom_menus where ulbid='".$ulbid."' and is_draft='".$is_draft."' and is_custumlink='".$is_custumlink."' and langId='".$langId."' and (page_title LIKE '%$keyword1%' or page_title LIKE '%$keyword2%' or page_title LIKE '%$keyword3%')";
        $result = $this->db->query($sql2);
         
        }
        
        else if($id=='3'){
            
        $keyword1=strtoupper($keyword);
        $keyword2=strtolower($keyword);
        $keyword3=ucfirst($keyword);
        
        $sql3 = "Select * from custom_menus where ulbid='".$ulbid."' and is_draft='".$is_draft."' and is_custumlink='".$is_custumlink."' and langId='".$langId."' and (page_title LIKE '%$keyword1%' or page_title LIKE '%$keyword2%' or page_title LIKE '%$keyword3%')";
        $result = $this->db->query($sql3);
         
        }
        return $result;
        
    }
}
?>