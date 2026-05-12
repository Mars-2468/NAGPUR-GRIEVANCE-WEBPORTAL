<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class SeoSettingsModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function updateSeoSettings($params)
    {
        $sql ="insert into seo_mst(
            ulbid,
            google_analytic_script,
            website_meta_ky,
            website_meta_desc,
            website_meta_sub,
            date
            ) values(
                '".$this->session->userdata('ulbid')."',
                '".$params['google_analytic_script']."',
                '".$params['website_meta_ky']."',
                '".$params['website_meta_desc']."',
                '".$params['website_meta_sub']."',
                now()
                ) ON DUPLICATE KEY UPDATE 
                google_analytic_script='".$params['google_analytic_script']."',
                website_meta_ky='".$params['website_meta_ky']."',
                website_meta_desc='".$params['website_meta_desc']."',
                website_meta_sub='".$params['website_meta_sub']."'
                ";
                
                $result=$this->db->query($sql);
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
    
    public function googleanalyticinsert($params)
    {
       
       $result=$this->db->insert('seo_mst',$params);
       
       return $result;
        
    }
    public function getMenuData()
    {
        $select_array=array('menu_type_id','menu_type_desc'); 
        $result=$this->db->select($select_array)->get('menu_type_mst');
        
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
}
?>