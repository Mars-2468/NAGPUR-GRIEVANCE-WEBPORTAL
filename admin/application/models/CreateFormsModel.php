<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreateFormsModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function add_user($val)
    {
       // echo $sql ="insert into users ('user_id','user_pwd','user_type','ulbid') values('".$val['user_id']."',PASSWORD('".$val['user_id']."','U','".$val['ulbid']."'))";
        //$this->db->query($sql);
        //echo "<br>";
    }
    
    public function ulb_list()
    {
        $select_array=array('ulbid','ulbname');
        $this->db->select($select_array);
        $result=$this->db->get('ulbmst');
        return $result;
        
    }
    
    public function updatepagename($params)
    {
    $set_array=array('site_controller'=>$params['site_controller']);
      $condition=array('page_id'=>$params['page_id']);
      $this->db->set($set_array);
      $this->db->where($condition);
      echo $this->db->last_query();
      $result=$this->db->update('custom_menus');
    }
    
    public function copysite()
    {
        $condition=array('ulbid'=>'056','theme_layout_id'=>1);
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($condition);
        $result=$this->db->get('custom_page_layouts');
        return $result;
    }
    
    public function addsite($params)
    {
        $this->db->insert('custom_page_layouts',$params);
        $this->db->insert('page_layouts',$params);
    }
    
    public function conf($params)
    {
      
      $select_array=array('site_controller','page_id');
      $condition=array('is_custumlink'=>'0');
      $this->db->select($select_array);
      $this->db->where($condition);
      $result=$this->db->get('custom_menus');
      
      return $result;
      
        
    }
    
     public function custom_menu_list()
    {
        $select_array=array('page_id','page_name','is_custumlink','author');
        $condition=array('is_custumlink'=>'3','author'=>'superadmin');
        $this->db->select($select_array);
        $this->db->where($condition);
        
        $result=$this->db->get('custom_menus');
       
       
        return $result;
        
    }
    
    public function category_forms_types_list(){
        $this->db->select('*');
        $this->db->from('category_forms_types');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function category_forms_datatype_list(){
        $this->db->select('*');
        $this->db->from('category_forms_datatype');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function savecreateform($params1)
    {
       /* $select_array=array('page_name');
        $condition=array('page_id'=>$params1['page_id']);
        $this->db->select($select_array);
        $this->db->where($condition);
        $result=$this->db->get('custom_menus')->row_array();
        $table=strtolower(str_replace(" ","_",$result['page_name']));*/
        
        
        /*$sql ="CREATE TABLE $table (
            ID int NOT NULL AUTO_INCREMENT,
            LastName varchar(255) NOT NULL,
            FirstName varchar(255),
            Age int,
            PRIMARY KEY (ID)
        );";*/
       $sql1=$this->db->insert('category_forms_mst',$params1);
               
      }
      
    public function saveoptionsform($params2)
    {
        
       $sql1=$this->db->insert('select_options_map',$params2);
        return  $sql1;      
      }
      
    public function getSelectOptionContent($params){
        
        $this->db->select('*');
        $this->db->from('category_forms_mst');
        $this->db->where($params);
        $data['pageResult'] = $this->db->get()->result_array();
       
        $this->db->select('*');
        $this->db->from('select_options_map');
        $data['optionResult'] = $this->db->get()->result_array();
        return $data;
        
    }
    
    public function getOptionContent(){
        
        $this->db->select('*');
        $this->db->from('select_options_map');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function deleteSelectValueOption($value){
        $params = array('category_id' => $value);
        $this->db->select('*');
        $this->db->from('category_forms_mst');
        $this->db->where($params);
        $result = $this->db->get()->result_array();
        //return $result;
        foreach($result as $key=>$val){
            //return $val['sno'];
            $deleteValue = array('select_id' => $val['sno']);
            $this->db->where($deleteValue);
            $this->db->delete('select_options_map');
            
        }
        
        $this->db->where($params);
        $this->db->delete('category_forms_mst');
    }
   
}
?>