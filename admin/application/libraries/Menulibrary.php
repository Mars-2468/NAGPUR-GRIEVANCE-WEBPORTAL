<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menulibrary
{
    function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }
    
   
   
   public function getMenuNames($param)
   {
       $this->CI->db->select('*');
       
       if($param['user_type']=='A')
       {
           $this->CI->db->from('menu_type_mst');
           
       }
       else
       {
           $params = array('ulbid' => $param['ulbid']);
           $this->CI->db->where($params);
           $this->CI->db->from('menu_type_mst');
           
           
       }
       
        $result=$this->CI->db->get()->result_array();
       return $result;
       
       
       
       
   }
    
    function getForm()
    {
        $content="<label for='menutype'>Select Menus: </label><select name='menu_type_id' id='menu_type_id'>";
        $content.="<option value='0'>---select---</option>";
        $menunames=$this->CI->getMenuNames();
      
       foreach($menunames->result() as $key=>$val)
       {
           $content.="<option value='".$val->menu_type_id."'>".$val->menu_type_desc."</option>";
       }
       $content.="</select><input type='button' value='save' class='btn btn-default' id='savemenuwidget' onclick='savemenuwidget()'>"; // onclick function is in custome folder custome.js
       return $content;
    }
}

?>