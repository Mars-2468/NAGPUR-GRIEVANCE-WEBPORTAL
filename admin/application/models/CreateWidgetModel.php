<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CreateWidgetModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    // to get all posts for mapping post with slider widgets
    public function getSliderPosts()
    {
       $select_array=array('c.*','p.page_id','p.category_id'); 
       $params=array(
           'c.ulbid'=>$this->session->userdata('ulbid'),
           'c.langId'=>$this->session->userdata('langId'),
           'c.is_custumlink'=>2,
           'p.category_id'=>542
           );
        $this->db->select($select_array);
        $this->db->from('custom_menus c');
        $this->db->join('post_category_map p','c.page_id=p.page_id');
        $this->db->where($params);
        $result = $this->db->get();
        return $result;
        
        
        
        // $this->db->select('*');
        // $this->db->from('custom_menus');
        // $this->db->where($params);
        // $result = $this->db->get();
        // //echo $this->db->last_query();
        // return $result;
        
    }
    
    public function getCategories($params)
    {
        $array = array();
        $this->db->select('*');
        $this->db->where($params);
        $this->db->from('custom_menus');
        $result = $this->db->get()->result_array();
        $array[] = $result;
        
        $param=array('langId'=>$this->session->userdata('langId'),'is_custumlink'=>3);
        $this->db->select('*');
        $this->db->from('custom_menus');
        $this->db->where($param);
        $result1 = $this->db->get()->result_array();
        $array[] = $result1;
        
        return $array;
    }
    
    
    public function getUlbList(){
        $this->db->select('*');
        $this->db->from('ulbmst');
        $this->db->where('theme_id !=',0,FALSE);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function widgetNameValidation($params){
        
        $this->db->select('*');
        $this->db->from('standard_widget_mst');
        $this->db->where($params);
        $result = $this->db->get();
        if($result->num_rows()>0)
            return TRUE;
        else
            return FALSE;
    }
    
    public function getwidgettypes()
    {
        $select_array=array('*');
        $this->db->select($select_array);
        //$ids = array(2, 5, 11);
        //$this->db->where_in('widget_type_id', $ids);
        $result=$this->db->get('widget_type_mst');
        return $result;
        
    }
    //Get Gallery Widget Details function
    public function getGalleryWidgetIdDetails($params){
        $this->db->select('*');
        $this->db->from('photogallery_widgets');
        $this->db->where($params);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function create_widget($params)
    {
        
        $param = array(
            'widget_name'=>$params['widget_name'],
            'widget_type'=>$params['widget_type'],
            'flag'=>$params['flag'],
            'langId'=>$params['langId'],
            'is_edit_permission'=>'1',
            'is_delete_permission'=>'1',
            'author'=>$params['author']
            );
            
        $ulb_check_list = $params['ulb_check_list'];
        //print_r($check_list);
        //exit;
        if($this->db->insert('standard_widget_mst',$param)){
            
            $widgetName = $params['widget_name'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            
            $widget_idd=$this->db->insert_id();
            
            $widgetIdArray = array();
            
            foreach($ulb_check_list as $key => $val){
                $param=array(
                'widget_name'=>$widgetName,
                'widget_type'=>$widgetType,
                'flag'=>$flag,
                'langId'=>$langId,
                'ulbid'=>$val,
                'user_level'=>$userLevel,
                'widget_admin_code'=>$widget_idd,
                'author'=>$author
                );
                //print_r($param);
        
                $res=$this->db->insert('widget_mst',$param);
                $widget_id=$this->db->insert_id();
                if($res!='')
                {
                   $query = $this->db->query("select * from  widget_mst where widget_id='".$widget_id."';");
                   foreach ($query->result_array()  as $user)
                   $widget_id1= $user['widget_id'];
                   $widget_type= $user['widget_type'];
                   $query1 = $this->db->query("select * from widget_type_mst where widget_type_id='".$widget_type."';");
                   foreach ($query1->result_array()  as $page)
                   $widget_type_desc= $page['widget_type_desc'];
                   $widget_name= $user['widget_name'];
                   $ts= $user['ts'];
                   $author= $user['author'];
               
                   $sql="insert into logs(content_id,content_type,modified_content,datetime,author) values('".$widget_id1."','".$widget_type_desc."','".$widget_name."','".$ts."','".$author."')";
                   $this->db->query($sql);
                }
                
                //echo $widget_id;
                $widgetIdArray[] = $widget_id;
                //array_push( $widgetIdArray,$widget_id);
                //print_r($widgetIdArray);
            }
            $params=array(
                'user_category'=>2,
                'is_edit_permission'=>1,
                'is_delete_permission'=>0,
                'widget_id'=>$widget_idd,
                'author'=>$author
            );
            $this->db->insert('widget_permissions',$params);
            return $widgetIdArray;
        }    
    }
    
    public function saveMediaGallerywidget($params1){
        
        $this->db->insert('photogallery_widgets',$params1);
        return 1;
    }
    public function updatecreate_widget($params)
    {
       $update_array=array('widget_name'=>$params['widget_name']);
        $condition=array('widget_id'=>$params['widget_id']);
        $this->db->set($update_array);
        $this->db->where($condition);
        $result=$this->db->update('widget_mst');
        $query = $this->db->query("select * from  widget_mst where widget_id='".$params['widget_id']."';");
       foreach ($query->result_array()  as $user)
       $widget_id= $user['widget_id'];
       $widget_type= $user['widget_type'];
        $query1 = $this->db->query("select * from widget_type_mst where widget_type_id='".$widget_type."';");
       foreach ($query1->result_array()  as $page)
       $widget_type_desc= $page['widget_type_desc'];
       $widget_name= $user['widget_name'];
       $ts= $user['ts'];
       $author= $user['author'];
       
       $sql="insert into logs(content_id,content_type,modified_content,datetime,author) values('".$widget_id."','".$widget_type_desc."','".$widget_name."','".$ts."','".$author."')";
       $this->db->query($sql);
        return $result;
    }
    
    public function updateMediaGallerywidget($params)
    {
     // print_r($params);
        $set_array = array('widget_name'=>$params['widget_name'],'author'=>$params['author']);
        $widgetAdminIdA = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId']);
        
        if($params['user_level'] == 'A'){
           
             $this->db->set($set_array);
             $this->db->where($widgetAdminIdA);
             $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                    if($result_standard_widget_mst){
                       
                        $update = array(
                           
                            //'id'=>$params['id'],
                            'file_name'=>$params['file_name'],
                            'folder_path'=>$params['folder_path'],
                            'full_path'=>$params['full_path'],
                            'thumbnail_path'=>$params['thumbnail_path'],
                            'title'=>$params['title'],
                            'url_link'=>$params['url_link'],
                            'target'=>$params['target']
                        );
                        
           
             $where = array('id'=>$params['id']); 
          // print_r($where);
            $this->db->select('*');
            $this->db->from('photogallery_widgets');
            $this->db->where($where);
            $rr = $this->db->get()->result_array();
                    if($rr){
                        
                        $this->db->set($update);
                        $this->db->where($where);
                        $result = $this->db->update('photogallery_widgets');
                            }else{
                                
                        $params1=array(
                                    //'id'=>$params['id'],
                                    'widget_id'=>$params['widget_id'],
                                    'file_name'=>$params['file_name'],
                                    'folder_path'=>$params['folder_path'],
                                    'full_path'=>$params['folder_path'],
                                    'thumbnail_path'=>$params['thumbnail_path'],
                                    'title'=>$params['title'],
                                    'url_link'=>$params['url_link'],
                                    'flag'=>1,
                                    'target'=>$params['target']
                                );
                        $result = $this->db->insert('photogallery_widgets',$params1);  
                        //echo $this->db->last_query();
                    }
                 return $result;
                 }
        }
       
    }
    
    
    public function deletePhotoGallerySingleImage($params){
        
        $this->db->select('*');
        $this->db->from('photogallery_widgets');
        $this->db->where($params);
        $rr = $this->db->get();
        foreach($rr->result() as $record){
            $thumbnail_path = "..".$record->thumbnail_path;
            $folder_path = "..".$record->folder_path;
            $full_path = "..".$record->full_path;
            
            if(file_exists($full_path)){
                unlink($full_path);
            }
            if(file_exists($thumbnail_path)){
                unlink($thumbnail_path);
            }
            if(file_exists($folder_path)){
                unlink($folder_path);
            }
            
            $this->db->where($params);
            $result = $this->db->delete('photogallery_widgets');
            return $result;
        }
    }
    
    public function deleteMediaGallerywidget($widg)
    {
        $sql1="delete from photogallery_widgets where widget_id='".$widg."'";
        $result2=$this->db->query($sql1);
        return $result2;
        //exit;
    }
    
    public function savepageWidget($params)
    {
        $param = array(
            'widget_name'=>$params['widget_name'],
            'widget_type'=>$params['widget_type'],
            'flag'=>$params['flag'],
            'langId'=>$params['langId'],
            'is_edit_permission'=>'1',
            'is_delete_permission'=>'1',
            'author'=>$params['author']
        );
        $check_list = $params['check_list'];
        $ulb_check_list = $params['ulb_check_list'];
        //print_r($check_list);
        //exit;
        if($this->db->insert('standard_widget_mst',$param)){
        
            $widgetName = $params['widget_name'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            
            $widget_idd=$this->db->insert_id();
            
            $widgetIdArray = array();
            
            foreach($ulb_check_list as $key => $val){
                $param=array(
                    'widget_name'=>$widgetName,
                    'widget_type'=>$widgetType,
                    'flag'=>$flag,
                    'langId'=>$langId,
                    'ulbid'=>$val,
                    'user_level'=>$userLevel,
                    'widget_admin_code'=>$widget_idd,
                    'author'=>$author
                );
                //print_r($param); 
                
                if($this->db->insert('widget_mst',$param))
                {
                    $widget_id=$this->db->insert_id();
                    
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$widget_id."';");
                    foreach ($query->result_array()  as $user)
                    $widget_id= $user['widget_id'];
                    $widget_type= $user['widget_type'];
                    $query1 = $this->db->query("select * from widget_type_mst where widget_type_id='".$widget_type."';");
                    foreach ($query1->result_array()  as $page)
                    $widget_type_desc= $page['widget_type_desc'];
                    $widget_name= $user['widget_name'];
                    $ts= $user['ts'];
                    $author= $user['author'];
                    
                    $sql="insert into logs(content_id,content_type,modified_content,datetime,author) values('".$widget_id."','".$widget_type_desc."','".$widget_name."','".$ts."','".$author."')";
                    $this->db->query($sql);
                
                    foreach($check_list as $key=>$val)
                    {
                        $params2=array(
                            'widget_id'=>$widget_id,
                            'page_id'=>$val
                        );
                        $this->db->insert('pagewidget',$params2);
                    }
                }
            }
            $params=array(
                'user_category'=>2,
                'is_edit_permission'=>1,
                'is_delete_permission'=>0,
                'widget_id'=>$widget_idd,
                'author'=>$author
            );
           $this->db->insert('widget_permissions',$params);
            return 1;
        }else{
            return 0;
        }
    } 
    
    
    
    public function saveSliderpostWidget($params)
    {
      
        $param = array(
            'widget_name'=>$params['widget_name'],
            'widget_type'=>$params['widget_type'],
            'flag'=>$params['flag'],
            'langId'=>$params['langId'],
            'is_edit_permission'=>'1',
            'is_delete_permission'=>'1',
            'author'=>$params['author']
        );
        $check_list = $params['check_list'];
        $ulb_check_list = $params['ulb_check_list'];
        //print_r($param);
      
        if($this->db->insert('standard_widget_mst',$param)){
          // echo "okk";
          
            $widgetName = $params['widget_name'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            
            $widget_idd=$this->db->insert_id();
             // echo $widget_idd;
            //exit;
             $i=1;
            
            foreach($ulb_check_list as $key => $val){
                $param=array(
                    'widget_name'=>$widgetName,
                    'widget_type'=>$widgetType,
                    'flag'=>$flag,
                    'langId'=>$langId,
                    'ulbid'=>$val,
                    'user_level'=>$userLevel,
                    'widget_admin_code'=>$widget_idd,
                    'author'=>$author
                );
                //print_r($param); 
                
                if($i==1)
                {
               
                if($this->db->insert('widget_mst',$param))
                {
                    $widget_id=$this->db->insert_id();
                    
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$widget_id."';");
                    foreach ($query->result_array()  as $user)
                    $widget_id= $user['widget_id'];
                    $widget_type= $user['widget_type'];
                    $query1 = $this->db->query("select * from widget_type_mst where widget_type_id='".$widget_type."';");
                    foreach ($query1->result_array()  as $page)
                    $widget_type_desc= $page['widget_type_desc'];
                    $widget_name= $user['widget_name'];
                    $ts= $user['ts'];
                    $author= $user['author'];
                    
                    $sql="insert into logs(content_id,content_type,modified_content,datetime,author) values('".$widget_id."','".$widget_type_desc."','".$widget_name."','".$ts."','".$author."')";
                    $this->db->query($sql);
                    
                    foreach($check_list as $key=>$val)
                    {
                        $params2=array(
                            'widget_id'=>$widget_id,
                            'page_id'=>$val
                        );
                        $this->db->insert('slider_widgets',$params2);
                    }
                }
                $i++;
                }
            }
            $params=array(
                'user_category'=>2,
                'is_edit_permission'=>1,
                'is_delete_permission'=>0,
                'widget_id'=>$widget_idd,
                'author'=>$author
            );
            $this->db->insert('widget_permissions',$params);
            return 1;
        }else{
            return 0;
        }
    }
    
    
    
    
    
    
    
    public function savepostWidget($params)
    {
        $param = array(
            'widget_name'=>$params['widget_name'],
            'widget_type'=>$params['widget_type'],
            'flag'=>$params['flag'],
            'langId'=>$params['langId'],
            'is_edit_permission'=>'1',
            'is_delete_permission'=>'1',
            'author'=>$params['author']
        );
        $check_list = $params['check_list'];
        $ulb_check_list = $params['ulb_check_list'];
       // print_r($ulb_check_list);
        //exit;
        // $this->db->insert('standard_widget_mst',$param);
        //         echo $this->db->last_query(); exit;
        $i=1;
        if($this->db->insert('standard_widget_mst',$param)){
       // echo "gghfg"; //exit;
            $widgetName = $params['widget_name'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            
            $widget_idd=$this->db->insert_id();
            if($i==1)
                {
            
            foreach($ulb_check_list as $key => $val){
                $param=array(
                    'widget_name'=>$widgetName,
                    'widget_type'=>$widgetType,
                    'flag'=>$flag,
                    'langId'=>$langId,
                    'ulbid'=>$val,
                    'user_level'=>$userLevel,
                    'widget_admin_code'=>$widget_idd,
                    'author'=>$author
                );
               // print_r($param); 
                $this->db->insert('widget_mst',$param);
             //   echo $this->db->last_query(); exit;
                if($this->db->insert('widget_mst',$param))
                {
                    $widget_id=$this->db->insert_id();
                    
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$widget_id."';");
                    foreach ($query->result_array()  as $user)
                    $widget_id= $user['widget_id'];
                    $widget_type= $user['widget_type'];
                    $query1 = $this->db->query("select * from widget_type_mst where widget_type_id='".$widget_type."';");
                    foreach ($query1->result_array()  as $page)
                    $widget_type_desc= $page['widget_type_desc'];
                    $widget_name= $user['widget_name'];
                    $ts= $user['ts'];
                    $author= $user['author'];
                    
                    $sql="insert into logs(content_id,content_type,modified_content,datetime,author) values('".$widget_id."','".$widget_type_desc."','".$widget_name."','".$ts."','".$author."')";
                    $this->db->query($sql);
                    
                    foreach($check_list as $key=>$val)
                    {
                        $params2=array(
                            'widget_id'=>$widget_id,
                            'category_id'=>$val
                        );
                        $this->db->insert('postwidget',$params2);
                    }
                }
            }
                $i++; }
            $params=array(
                'user_category'=>2,
                'is_edit_permission'=>1,
                'is_delete_permission'=>0,
                'widget_id'=>$widget_idd,
                'author'=>$author
            );
            $this->db->insert('widget_permissions',$params);
            return 1;
        }else{
            return 0;
        }
    }
    
    public function saveTabWidget($params)
    {
        $tab_type_id = $params['tab_type_id'];
        $check_list = $params['check_list'];
        $ulb_check_list = $params['ulb_check_list'];
        $param = array(
            'widget_name'=>$params['widget_name'],
            'widget_type'=>$params['widget_type'],
            'flag'=>$params['flag'],
            'langId'=>$params['langId'],
            'is_edit_permission'=>'1',
            'is_delete_permission'=>'1',
            'author'=>$params['author']
        );
            
        //print_r($check_list);
        //exit;
        if($this->db->insert('standard_widget_mst',$param)){
            
            $widgetName = $params['widget_name'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            
            $widget_idd=$this->db->insert_id();
            
            foreach($ulb_check_list as $key => $val){
                $param=array(
                'widget_name'=>$widgetName,
                'widget_type'=>$widgetType,
                'flag'=>$flag,
                'langId'=>$langId,
                'ulbid'=>$val,
                'user_level'=>$userLevel,
                'widget_admin_code'=>$widget_idd,
                'author'=>$author
                );
                //print_r($param); 
         
                if($this->db->insert('widget_mst',$param))
                {
                    $widget_id=$this->db->insert_id();
                    
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$widget_id."';");
                    foreach ($query->result_array()  as $user)
                    $widget_id= $user['widget_id'];
                    $widget_type= $user['widget_type'];
                    $query1 = $this->db->query("select * from widget_type_mst where widget_type_id='".$widget_type."';");
                    foreach ($query1->result_array()  as $page)
                    $widget_type_desc= $page['widget_type_desc'];
                    $widget_name= $user['widget_name'];
                    $ts= $user['ts'];
                    $author= $user['author'];
                    
                    $sql="insert into logs(content_id,content_type,modified_content,datetime,author) values('".$widget_id."','".$widget_type_desc."','".$widget_name."','".$ts."','".$author."')";
                    $this->db->query($sql);
                    
                    foreach($check_list as $key=>$val)
                    {
                        $params2=array(
                            'widget_id'=>$widget_id,
                            'category_id'=>$val,
                            'tab_type_id'=>$tab_type_id
                        );
                        $this->db->insert('tabswidget',$params2);
                    }
                }
            }
            $params=array(
                'user_category'=>2,
                'is_edit_permission'=>1,
                'is_delete_permission'=>0,
                'widget_id'=>$widget_idd,
                'author'=>$author
            );
           $this->db->insert('widget_permissions',$params);
            return 1;
        }else{
            return 0;
        }
    }
    
    
    public function saveImageTextwidget($params1,$params2,$ulb_check_list)
    {
       
        $param = array(
            'widget_name'=>$params2['widget_name'],
            'widget_type'=>$params2['widget_type'],
            'flag'=>$params2['flag'],
            'langId'=>$params2['langId'],
            'is_edit_permission'=>'1',
            'is_delete_permission'=>'1',
            'author'=>$params2['author'],
            'widget_type_style'=>$params2['widget_type_style']
        );
            
        //$check_list = $params2['check_list'];
        //print_r($check_list);
        //exit;
        if($this->db->insert('standard_widget_mst',$param)){
            $widgetName = $params2['widget_name'];
            $widgetType = $params2['widget_type'];
            $widgetTypeStyle = $params2['widget_type_style'];
            $flag = $params2['flag'];
            $langId = $params2['langId'];
            $userLevel = $params2['user_level'];
            $author = $params2['author'];
            
            $widget_idd=$this->db->insert_id();
            
            $i=1;
            
            
            foreach($ulb_check_list as $key => $val){
              
                $param=array(
                    'widget_name'=>$widgetName,
                    'widget_type'=>$widgetType,
                    'flag'=>$flag,
                    'langId'=>$langId,
                    'ulbid'=>$val,
                    'user_level'=>$userLevel,
                    'widget_admin_code'=>$widget_idd,
                    'author'=>$author,
                    'widget_type_style'=>$widgetTypeStyle,
                );
                    // print_r($param);
                if($i==1)
                {
                if($this->db->insert('widget_mst',$param))
                {
                      
                    $widget_id=$this->db->insert_id();
                    
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$widget_id."';");
                    foreach ($query->result_array()  as $user)
                    $widget_id= $user['widget_id'];
                    $widget_type= $user['widget_type'];
                    $query1 = $this->db->query("select * from widget_type_mst where widget_type_id='".$widget_type."';");
                    foreach ($query1->result_array()  as $page)
                    $widget_type_desc= $page['widget_type_desc'];
                    $widget_name= $user['widget_name'];
                    $ts= $user['ts'];
                    $author= $user['author'];
                    
                   /* $sql="insert into logs(content_id,content_type,modified_content,datetime,author) values('".$widget_id."','".$widget_type_desc."','".$widget_name."','".$ts."','".$author."')";
                    $this->db->query($sql);*/
                    
                    $params1['widget_id']=$widget_id;
                    $this->db->insert('image_text_widgets',$params1);
                    
                }}
            $i++;}
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where('widget_admin_code',$widget_idd);
            $rr = $this->db->get()->result_array();
            
            $params=array(
                'user_category'=>2,
                'is_edit_permission'=>1,
                'is_delete_permission'=>0,
                'widget_id'=>$widget_idd,
                'author'=>$author
            );
            $this->db->insert('widget_permissions',$params);
            if($params2['widget_type'] == '5'){
                return $rr;
            }else{
                return 1;    
            }
            
        }else{
            return 0;
        }

    }
    
    public function saveTextwidget($params)
    {
        $content=$params['content'];
        
        $param = array(
            'widget_name'=>$params['widgetname'],
            'widget_type'=>$params['widget_type'],
            'flag'=>$params['flag'],
            'langId'=>$params['langId'],
            'is_edit_permission'=>'1',
            'is_delete_permission'=>'1',
            'author'=>$params['author']
            );
            
        $ulb_check_list = $params['ulb_check_list'];
        // print_r($ulb_check_list);
        // exit;
        if($this->db->insert('standard_widget_mst',$param)){
            
            $widgetName = $params['widgetname'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            
            $widget_idd=$this->db->insert_id();
            foreach($ulb_check_list as $key => $val){
                //echo "hi";
                //$params = $params;
                $param=array(
                'widget_name'=>$widgetName,
                'widget_type'=>$widgetType,
                'flag'=>$flag,
                'langId'=>$langId,
                'ulbid'=>$val,
                'user_level'=>$userLevel,
                'widget_admin_code'=>$widget_idd,
                'author'=>$author
                );
           //print_r($param);
                if($this->db->insert('widget_mst',$param)){
                 // echo "hi";
                    $widget_id=$this->db->insert_id();
                    
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$widget_id."';");
                    foreach ($query->result_array()  as $user)
                    $widget_id= $user['widget_id'];
                    $widget_type= $user['widget_type'];
                    $query1 = $this->db->query("select * from widget_type_mst where widget_type_id='".$widget_type."';");
                    foreach ($query1->result_array()  as $page)
                    $widget_type_desc= $page['widget_type_desc'];
                    $widget_name= $user['widget_name'];
                    $ts= $user['ts'];
                    $author= $user['author'];
                    
                    $sql="insert into logs(content_id,content_type,modified_content,datetime,author) values('".$widget_id."','".$widget_type_desc."','".$widget_name."','".$ts."','".$author."')";
                    $this->db->query($sql);
                    
                    $params=array(
                        'content'=>$content,
                        'widget_id'=>$widget_id,
                        'flag'=>1
                    );
                    $this->db->insert('textwidgets',$params);
                }
            }
            $params=array(
                'user_category'=>2,
                'is_edit_permission'=>1,
                'is_delete_permission'=>0,
                'widget_id'=>$widget_idd,
                'author'=>$author
            );
            $this->db->insert('widget_permissions',$params); 
            return true;
        }else{
            return false;
        }    
    }
    
    public function saveMenuwidget($params)
    {
        
        $param = array(
            'widget_name'=>$params['widgetname'],
            'widget_type'=>$params['widget_type'],
            'flag'=>$params['flag'],
            'langId'=>$params['langId'],
            'is_edit_permission'=>'1',
            'is_delete_permission'=>'1',
            'author'=>$params['author'],
            'widget_type_style'=>$params['menu_type_style']
        );
            
        $ulb_check_list = $params['ulb_check_list'];
        //print_r($check_list);
        //exit;
        $i=1;
        if($this->db->insert('standard_widget_mst',$param)){
            
            
            $widget_style_type = $params['menu_type_style'];
            $menu_id=$params['menu_type_id'];
            $widgetName = $params['widgetname'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            $widget_idd=$this->db->insert_id();
            
            
            foreach($ulb_check_list as $key => $val){
                
                if($i==1)
                {
                $param=array(
                    'widget_name'=>$widgetName,
                    'widget_type'=>$widgetType,
                    'flag'=>$flag,
                    'langId'=>$langId,
                    'ulbid'=>$val,
                    'user_level'=>$userLevel,
                    'widget_admin_code'=>$widget_idd,
                    'author'=>$author,
                    'widget_type_style'=>$widget_style_type
                    
                );
                
                
                 
                
                
                if($this->db->insert('widget_mst',$param)){
                   
                    $widget_id=$this->db->insert_id();
                    $params=array(
                        'menu_type_id'=>$menu_id,
                        'widget_id'=>$widget_id,
                        'flag'=>1
                        );
                    //print_r($params);    
                    $this->db->insert('menuwidgets',$params);
                }
            
            $params=array(
                'user_category'=>2,
                'is_edit_permission'=>1,
                'is_delete_permission'=>0,
                'widget_id'=>$widget_idd,
                'author'=>$author
            );
            $this->db->insert('widget_permissions',$params);
            return true;
        $i++;}} }else{
            return false;
        }
    }
    
   
}
?>