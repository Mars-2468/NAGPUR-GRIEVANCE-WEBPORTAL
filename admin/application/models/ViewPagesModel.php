<?php
defined('BASEPATH') or  die('direct scripts are not allowed');

class ViewPagesModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }

    public function getPageIds()
    {
        $select_array=array('page_id');
        $this->db->select($select_array);
        $this->db->where_in('category_id',[542,24002,24815,24816,24817,24818]);
        $this->db->from('post_category_map');
        $result=$this->db->get()->result_array();
		$pageIds = array_column($result, 'page_id');
		return $pageIds;
    } 
	
    public function customePageDataInsert($params)
    {


        //$query="insert into custom_menus (main_menu_id,page_title,page_name,content,ulbid,controller) values ('".$params['main_menu_id']."','".$params['page_title']."','".$params['page_name']."','".$params['content']."','".$params['ulbid']."','".$params['controller']."') ON DUPLICATE KEY UPDATE content='".$params['content']."'";


        $result = $this->db->insert('custom_menus', $params);
        $data['result'] = $result;
        $data['pageId'] = $this->db->insert_id();

        //$result=$this->db->insert('about_mst',$string);

        return $data;
    }

    public function updateStatus($params)
    {
        $this->db->set('is_draft', $params['is_draft']);
        $this->db->where('page_id', $params['page_id']);
        $result = $this->db->update('custom_menus');
        return $result;
    }

    public function deleteContent($params)
    {
        $this->db->where($params);
        $result = $this->db->delete('custom_menus');
        return $result;
    }

    public function getulb_baseurl($ulb)
    {

        $sql = "select ulbid,base_url from ulbmst where ulbid='" . $ulb . "'";

        $result = $this->db->query($sql);        
	return $result;
    }
}
