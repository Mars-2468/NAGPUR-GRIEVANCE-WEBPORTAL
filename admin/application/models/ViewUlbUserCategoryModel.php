<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class ViewUlbUserCategoryModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    public function customePageDataInsert($params)
    {
        
        
      //$query="insert into custom_menus (main_menu_id,page_title,page_name,content,ulbid,controller) values ('".$params['main_menu_id']."','".$params['page_title']."','".$params['page_name']."','".$params['content']."','".$params['ulbid']."','".$params['controller']."') ON DUPLICATE KEY UPDATE content='".$params['content']."'";
      
      
       $result=$this->db->insert('custom_menus',$params);
       $data['result']=$result;
       $data['pageId']=$this->db->insert_id();
       
       //$result=$this->db->insert('about_mst',$string);
      
       return $data;
        
    }
    
    public function updateStatus($params)
    {
        $this->db->set('flag',$params['flag']);
        $this->db->where('user_id',$params['user_id']);
        $result=$this->db->update('users');
        return $result;
    }
    
    public function deleteContent($params)
    {
       $result =$this->db->delete('user_categories', array('id' =>$params['id'])); 
       $result= $this->db->delete('users_services', array('user_category' =>$params['id'])); 
       $result=$this->db->delete('widget_permissions', array('user_category' =>$params['id'])); 
        
        //$result=$this->db->query($sql);
        return $result;
    }
    
     public function getulbusercategories($userid,$ulbid)
    {
         $sql="select * from user_categories where user_level='".$userid."' and ulbid='".$ulbid."' order by ts desc";
        
        $result=$this->db->query($sql);
        
        return $result;
        
        
     }
     
     public function countofactive($userid){
         $sql="select count(user_id) as count from users where flag='1' and author='".$userid."'";
          $result=$this->db->query($sql);
        
        return $result;
         
     }
     public function countofInactive($userid){
         $sql="select count(user_id) as count from users where flag='0' and author='".$userid."'";
          $result=$this->db->query($sql);
        
        return $result;
         
     }
     
     public function getDesignations($params)
    {
        $select_array=array('desg_id','desg_desc');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('desg_mst');
        return $result;
    }
    
     public function getwidgetList($params)
    {
        $select_array=array('wp.*','w.widget_name');
        $condition=array('wp.user_id'=>$params['user_id'],'w.langId'=>$params['langId']);
        $this->db->select($select_array);
        $this->db->from('widget_permissions wp');
        $this->db->join('widget_mst w','wp.widget_id=w.widget_id');
        $this->db->where($condition);
        $this->db->group_by('wp.widget_id');
        $result=$this->db->get('widget_permissions');
      
        return $result;
    }
     
    public function getUserPermissionPages($params)
   {
       $select_array=array('us.*','m.*');
       $this->db->select($select_array);
       $this->db->from('users_services us');
       $this->db->join('main_menu m','us.main_menu_id=m.main_menu_id');
       $this->db->where($params);
       $this->db->group_by('us.main_menu_id');
       $result=$this->db->get('users_services');
       
       return $result;
   }
    public function getUserPermissionSubPages($params)
   {
       $select_array=array('us.*','m.*');
       
       $this->db->select($select_array);
       $this->db->from('users_services us');
       $this->db->join('sub_menu m','us.sub_menu_id=m.sub_menu_id');
       $this->db->where($params);
       //$this->db->group_by('us.main_menu_id');
       $result=$this->db->get('users_services');
      
       return $result;
   }
     
     
     
    public function get_edit_ulbusers_category($userid)
    {
        echo $sql="select * from user_categories where id='".$userid."'";
        
        $result=$this->db->query($sql);
        
        return $result;
        
        
    }
     
    public function edit_getwidgetList($userid)
    {
         $sql="select * from widget_permissions where user_id='".$userid."' and is_edit_permission='1'";
      
        $result=$this->db->query($sql);
        
        return $result;
        
        
    }
     
    public function edit_getmain_menuList($userid)
    {
        $sql="select * from users_services where user_id='".$userid."' and status='1'";
    
        $result=$this->db->query($sql);
        
        return $result;
        
        
    }
     
     
     
    public function edit_getsub_menuList($userid)
    {
         $sql="select * from users_services where user_id='".$userid."' and status='1'";
    
        $result=$this->db->query($sql);
        
        return $result;
        
    }
     
    public function deletewidget_permission($user_id)
    {
        
    $sql1="delete from widget_permissions where user_id='".$user_id."'";
     $result2=$this->db->query($sql1);
     return $result2;
     //exit;
    }
      
    public function delete_user_services($user_id)
    {
        
    $sql1="delete from users_services where user_id='".$user_id."'";
     $result2=$this->db->query($sql1);
     return $result2;
     //exit;
     
    }
     
    public function update_user_category($userdetails,$user_id)
    {
         
        $sql="update user_categories set user_category_name='".$userdetails['user_category_name']."' where id='".$user_id."'";
       
         $result=$this->db->query($sql);
         return $result;
         
    }
     
     
    public function pageprevilizes($params)
    {
        $this->db->insert('users_services',$params);
        //echo $this->db->last_query();
        
    }
    public function widgetprevilizes($params)
    {
        $this->db->insert('widget_permissions',$params);
    }
    
    public function check_userid_avalibility($user_id,$exist_user) {
        
        $sql="select user_id from users where user_id='".$user_id."' and user_id!='".$exist_user."'";
         $result=$this->db->query($sql);
         if($result->num_rows() > 0)  
          {
               return 1;  
          }  
          else  
          {
               return 0;  
          }
    }
    
    public function getuser_categories($params)
    {
        $select_array=array('id','user_category_name');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('user_categories');
        return $result;
    }
    
    
}
?>