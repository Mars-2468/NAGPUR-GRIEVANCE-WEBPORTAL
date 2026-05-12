<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class ViewUlbUserModel extends CI_Model
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
        $this->db->where($params);
        $result=$this->db->delete('users');
        return $result;
    }
    
     public function getulbusers($userid)
    {
        $sql="select * from users where author='".$userid."' order by ts desc";
        $this->db->select('*');
        $this->db->where(author,$userid);
        $result=$this->db->get('users');
        
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
       // $this->db->where($params);
        $result=$this->db->get('desg_mst');
        return $result;
    }
    
     public function getwidgetList($params)
    {
        if($params['user_type']=='A')
        {
          $condition=array('langId'=>$params['langId'],'flag'=>1);
          $select_array=array('*'); 
          $this->db->select($select_array);
          $this->db->where($condition);
          $result = $this->db->get('standard_widget_mst');
          return $result;
          
          
        }else{
          
            if($this->session->userdata('is_custom_user')=='Yes'){
                $where=array('w.langId'=>$params['langId'],'wp.user_id'=>$params['userid']);
            }else{
                $where=array('w.langId'=>$params['langId'],'wp.user_category'=>$params['user_category']);
            }  
            
            
        $select_array=array('wp.*','w.widget_name');
       // $condition=array('wp.user_id'=>$params['user_id'],'w.langId'=>$params['langId']);
        $this->db->select($select_array);
        $this->db->from('widget_permissions wp');
        $this->db->join('widget_mst w','wp.widget_id=w.widget_admin_code');
        $this->db->where($where);
        $this->db->group_by('wp.widget_id');
        $result=$this->db->get('widget_permissions');
        //echo $this->db->last_query();
        return $result;
        }
    }
     
    public function getUserPermissionPages($params)
   {
       if($this->session->userdata('is_custom_user')=='Yes'){
            
            $where=array('us.status'=>'1','m.is_common_page'=>'2','us.user_id'=>$this->session->userdata('userid'));
        }
        else
            {
                $where=array('us.status'=>'1','m.is_common_page'=>'2','us.user_category'=>$this->session->userdata('user_category'));
                
            }
       $select_array=array('us.*','m.*');
       $this->db->select($select_array);
       $this->db->from('users_services us');
       $this->db->join('main_menu m','us.main_menu_id=m.main_menu_id');
       $this->db->where($where);
       $this->db->group_by('us.main_menu_id');
       $result=$this->db->get('users_services');
       
       return $result;
   }
    public function getUserPermissionSubPages($params)
    {
        if($this->session->userdata('is_custom_user')=='Yes'){
            
            $where=array('us.status'=>'1','m.is_common_page'=>'2','us.user_id'=>$this->session->userdata('userid'));
        }
        else
            {
                $where=array('us.status'=>'1','m.is_common_page'=>'2','us.user_category'=>$this->session->userdata('user_category'));
                
            }
       
       $select_array=array('us.*','m.*');
       
       $this->db->select($select_array);
       $this->db->from('users_services us');
       $this->db->join('sub_menu m','us.sub_menu_id=m.sub_menu_id');
       $this->db->where($where);
       //$this->db->group_by('us.main_menu_id');
       $result=$this->db->get('users_services');
      
       return $result;
   }
     
     
     
    public function get_edit_ulbusers($userid)
    {
        $sql="select * from users where user_id='".$userid."'";
        $result=$this->db->query($sql);
        
        return $result;
        
        
    }
     
    public function edit_getwidgetList($userid)
    {
          $sql="select * from widget_permissions where user_category='".$userid."' and is_edit_permission='1'";
      
        $result=$this->db->query($sql);
        
        return $result;
        
        
    }
     
    public function edit_getmain_menuList($userid)
    
    {
         $sql="select * from users_services where user_category='".$userid."' and status='1'";
    
        $result=$this->db->query($sql);
        
        return $result;
        
        
    }
     
     
     
    public function edit_getsub_menuList($userid)
    
    {
        $sql="select * from users_services where user_category='".$userid."' and status='1'";
    
        $result=$this->db->query($sql);
        
        return $result;
        
    }
    
    
    public function user_edit_getwidgetList($userid)
    
    {
        $sql="select * from widget_permissions where user_id='".$userid."' and is_edit_permission='1'";
      
        $result=$this->db->query($sql);
        
        return $result;
        
    }
     
    public function user_edit_getmain_menuList($userid)
    
    {
         $sql="select * from users_services where user_id='".$userid."' and status='1'";
    
         $result=$this->db->query($sql);
        
         return $result;
        
    }
     
     
     
    public function user_edit_getsub_menuList($userid)
    
    {
        $sql="select * from users_services where user_id='".$userid."' and status='1'";
    
        $result=$this->db->query($sql);
        
        return $result;
        
    }
     
    public function deletewidget_permission($user_id)
    {
        
     $sql1="delete from widget_permissions where user_category='".$user_id."'";
     $result2=$this->db->query($sql1);
     return $result2;
    
    }
      
    public function delete_user_services($user_id)
    
    {
        
     $sql1="delete from users_services where user_category='".$user_id."'";
     $result2=$this->db->query($sql1);
     return $result2;
    }
    
    
    public function user_deletewidget_permission($user_id)
    {
        
     $sql1="delete from widget_permissions where user_id='".$user_id."'";
     $result2=$this->db->query($sql1);
     return $result2;
    
    }
      
    public function user_delete_user_services($user_id)
    
    {
        
     $sql1="delete from users_services where user_id='".$user_id."'";
     $result2=$this->db->query($sql1);
     return $result2;
   
     
    }
     
    public function update_user($userdetails,$user_id)
    {
         
        
        
        $set_array=array(
            'user_id'=>$userdetails['user_id'],
            'user_name'=>$userdetails['user_name'],
            'user_mobile'=>$userdetails['user_mobile'],
            'user_email'=>$userdetails['user_email'],
            'designation_id'=>$userdetails['designation_id'],
            'user_category'=>$userdetails['user_category'],
            'is_custom_user'=>$userdetails['is_custom_user']);
            $condition=array('user_id'=>$user_id);
        $this->db->set($set_array);
        $this->db->where($condition);
        $result=$this->db->update('users');
        
         return $result;
         
    }
     public function users_count()
    {
        return $this->db->count_all("users");
    }

    public function get_userslist($limit, $start)
    {
        $this->db->limit($limit, $start);
        if($this->session->userdata('user_type') == 'A'){
            $this->db->where(author,$this->session->userdata('userid'));
            $query = $this->db->get("users");
        }else{
            $this->db->where(author,$this->session->userdata('userid'));
            $query = $this->db->get("users");
        }
        if($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data[] = $row;
            } 
            return $data;
        }
        return false;
    }
     
    public function pageprevilizes($params)
    {
        $this->db->insert('users_services',$params);
        //echo $this->db->last_query();
        //exit;
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
    
    public function last_login_time_users(){
        
         $sql="select max(logout_time) as datetime,ip,user_id from login_logs where log_type='1' group by user_id";
        
        $result=$this->db->query($sql);
        return $result;
    }
    
    
}
?>