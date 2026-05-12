<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreaUlbUserModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
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
    
    public function getDesignations($params)
    {
        $select_array=array('desg_id','desg_desc');
        $this->db->select($select_array);
       // $this->db->where($params);
        $result=$this->db->get('desg_mst');
        
        return $result;
    }
    
    public function getuser_categories($user,$ulbid)
    {
          $sql="select * from user_categories where id='".$user."' or ulbid='".$ulbid."'";
       
        $result=$this->db->query($sql);
        return $result;
    }
    
    public function createUser($userdetails)
    {
        $query="insert into users(
            user_id,
            user_pwd,
            user_name,
            user_mobile,
            user_email,
            user_type,
            ulbid,
            show_pwd,
            designation_id,
            user_category,
            is_custom_user,
            author,
            flag
            )values(
                '".$userdetails['user_id']."',
                PASSWORD('".$userdetails['user_pwd']."'),
                '".$userdetails['user_name']."',
                '".$userdetails['user_mobile']."',
                '".$userdetails['user_email']."',
                '".$userdetails['user_type']."',
                '".$userdetails['ulbid']."',
                '".$userdetails['user_pwd']."',
                '".$userdetails['designation_id']."',
                '".$userdetails['user_category']."',
                '".$userdetails['is_custom_user']."',
                '".$userdetails['author']."',
                '1'
                )";
                $result=$this->db->query($query);
                return $result;
    }
    
    public function addCommonpages($user_id)
    {
            $select_array=array('*');
            $condition=array('is_common_page'=>1);
            $this->db->select($select_array);
            $this->db->where($condition);
            $result=$this->db->get('sub_menu')->result_array();
            foreach($result as $key=>$val)
            {
                $params=array(
                    'user_id'=>$user_id,
                    'main_menu_id'=>$val['main_menu_id'],
                    'sub_menu_id'=>$val['sub_menu_id'],
                    'sub_sub_menu_id'=>0,
                    'status'=>1
                    );
                    $this->db->insert('users_services',$params);
                    
            } 
            return 1;
    }
    
    public function addCommonpages_user_category($user_id)
    
    {
        
            $select_array=array('*');
            $condition=array('is_common_page'=>1);
            $this->db->select($select_array);
            $this->db->where($condition);
            $result=$this->db->get('sub_menu')->result_array();
            foreach($result as $key=>$val)
            {
                $params=array(
                    'user_category'=>$user_id,
                    'main_menu_id'=>$val['main_menu_id'],
                    'sub_menu_id'=>$val['sub_menu_id'],
                    'sub_sub_menu_id'=>0,
                    'status'=>1
                    );
                    $this->db->insert('users_services',$params);
                   //echo $this->db->last_query(); 
            }
            return 1;
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
    
   public function getMainMenupages()
   {
      $sql="select * from main_menu where is_common_page='2'";
      $result=$this->db->query($sql);
       return $result;
   }
   
    public function getSubMenupages()
   {
     $sql="select * from sub_menu where is_common_page='2'";
      $result=$this->db->query($sql);
       return $result;
   }
   
   public function getUlbList(){
        $this->db->select('*');
        $this->db->from('ulbmst');
        $this->db->where('theme_id !=',0,FALSE);
        $result = $this->db->get()->result_array();
        return $result;
    }
   public function getUserLevelList($params){
       if($params['user_type'] == 'A'){
           $this->db->select('*');
           $this->db->from('user_level');
           $result = $this->db->get()->result_array();
           return $result;
       }else{
           $this->db->select('sort_order');
           $this->db->from('user_level');
           $this->db->where('user_level_id',$params['user_type']);
           $result = $this->db->get()->result_array();
           //print_r($result);
          
           foreach($result as $val){
               $orderNum =  $val['sort_order'];
               $this->db->select('*');
               $this->db->from('user_level');
               $this->db->where('sort_order >=',$orderNum);
               $this->db->order_by('sort_order','ASC');
               $result = $this->db->get()->result_array();
               //echo $this->db->last_query();
           }
            return $result;
        }
   }
   public function getwidgetpages($params)
   {
     $sql="select * from standard_widget_mst where langId='".$params['langId']."'";
      $result=$this->db->query($sql);
       return $result;
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
      //echo $this->db->last_query();
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
   
   public function createcategory($userdetails){
       $query="insert into user_categories(user_category_name,
       ulbid,
       author,flag,user_level) values('".$userdetails['user_category_name']."',
       '".$userdetails['ulbid']."',
       '".$userdetails['author']."','".$userdetails['flag']."','".$userdetails['user_level']."')";
       $result=$this->db->query($query);
       return $result;
       
   }
   
    public function check_userid_avalibility($user_id) {
        
        $sql="select user_id from users where user_id='".$user_id."'";
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
    
    
    public function supergetDesignations()
    {
        $query="select * from desg_mst";
        $result=$this->db->query($query);
        return $result;
    }
    
    public function supergetuser_categories($user_level)
    {
        $query="select * from user_categories where user_level='".$user_level."'";
        $result=$this->db->query($query);
        return $result;
    }
   public function edituserprofile($user_id)
   {
    $this->db->select('*');
    $this->db->from('users');
    $this->db->where('user_id', $user_id);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
   }
   function update_userprofile($user_id,$userdetails)
   {
       
       $query="update users set user_id='".$userdetails['user_id']."',user_name='".$userdetails['user_name']."',user_mobile='".$userdetails['user_mobile']."',user_email='".$userdetails['user_email']."',designation_id='".$userdetails['designation_id']."' where user_id='".$user_id."'";
        $result=$this->db->query($query);
        return $result;
   }
   public function check_userid_avalibility_profile($user_id) {
        
        $sql="select user_id from users where user_id='".$user_id."' and user_id!='".$this->session->userdata('userid')."'";
       
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
}
?>