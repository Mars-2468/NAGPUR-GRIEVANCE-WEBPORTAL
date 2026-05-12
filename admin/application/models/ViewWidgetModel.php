<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class ViewWidgetModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
     /** edit tabs **/
    
    
    public function editsliderWidget($params)
    {
       
        $set_array = array('widget_name'=>$params['widget_name'],'author'=>$params['author']);
        $widgetAdminIdA = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId']);
        
        
        //print_r($set_array);
        //print_r($widgetAdminIdA);
        
        
        if($params['user_level'] == 'A'){
            //print_r($params['user_level']);
        
            if($params['radio'] == 'edit'){
               
                //print_r($params['radio']);
                
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst){
                    
                    $check_list = $params['check_list'];
                    //print_r($check_list);
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author1 = $params['author'];
                    //print_r($params['ulb_check_list']);
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$params['langId']);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author1,'user_level'=>$userLevel);
                         //print_r($widgetAdminIdArray);
                         //print_r($set_array);
        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                             
                                //echo "okk";
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    
                                    $wid = $val['widget_id'];
                                    $this->db->where('widget_id',$wid);
                                    if($this->db->delete('slider_widgets')){
                                   
                                        foreach($check_list as $key=>$val){
                                            
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'page_id'=>$val
                                                );
                                            $this->db->insert('slider_widgets',$params2);
                                          // print_r($params2);   
                                        }
                                    }else{
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'page_id'=>$val
                                                );
                                            $this->db->insert('slider_widgets',$params2);
                                        }
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            //echo "author name is ".$author1;
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author1
                            );
                            
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                
                                foreach($check_list as $key=>$val){
                                    $params2=array(
                                        'widget_id'=>$widget_id,
                                        'page_id'=>$val
                                        );
                                    $this->db->insert('slider_widgets',$params2);
                                    //print_r($params2);    
                                }
                                $result =1;
                            }
                        }
                    }
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
            }else if($params['radio'] == 'editexcept'){
                //echo "okk";
                
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst){
                   
                    
                    $check_list = $params['check_list'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author1 = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                       //  echo "ulb_check_list";
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$params['langId']);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author1,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    $wid = $val['widget_id'];
                                    $this->db->where('widget_id',$wid);
                                    if($this->db->delete('slider_widgets')){
                                    
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'page_id'=>$val
                                                );
                                            $this->db->insert('slider_widgets',$params2);
                                            //print_r($params2);    
                                        }
                                    }else{
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'page_id'=>$val
                                                );
                                            $this->db->insert('slider_widgets',$params2);
                                            //print_r($params2);    
                                        }
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            //echo "author name is ".$author1;
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author1
                            );
                            
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                
                                foreach($check_list as $key=>$val){
                                    $params2=array(
                                        'widget_id'=>$widget_id,
                                        'page_id'=>$val
                                        );
                                    $this->db->insert('slider_widgets',$params2);
                                    //print_r($params2);    
                                }
                                $result =1;
                            }
                        }
                    }
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
            }else if($params['radio'] == 'delete'){
                //print_r($params['radio']);
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val,'langId'=>$params['langId']);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id']);
                        $this->db->where($condition);
                        if($this->db->delete('slider_widgets')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }else if($params['radio'] == 'deleteexcept'){
                //print_r($params['radio']);
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val,'langId'=>$params['langId']);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id']);
                        $this->db->where($condition);
                        if($this->db->delete('slider_widgets')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }
        }else{
            //print_r($params['user_level']);
           
            $check_list = $params['check_list'];
            $widgetAdminId = $params['widget_id'];
            $widgetName = $params['widget_name'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            $ulbid = $params['ulbid'];
            
           /* $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$ulbid);
            
            $this->db->select('widget_id');
            $this->db->from('widget_mst');
            $this->db->where($widgetAdminIdArray);
            $result1 = $this->db->get()->result_array();
            
            foreach($result1 as $val){*/
                
                $this->db->where('widget_id',$widgetAdminId);
                if($this->db->delete('slider_widgets')){
                
                    foreach($check_list as $key=>$val){
                        $params2=array(
                            'widget_id'=>$widgetAdminId,
                            'page_id'=>$val
                            );
                        $this->db->insert('slider_widgets',$params2);
                        //print_r($params2);    
                    }
                }else{
                    foreach($check_list as $key=>$val){
                        $params2=array(
                            'widget_id'=>$widgetAdminId,
                            'page_id'=>$val
                            );
                        $this->db->insert('slider_widgets',$params2);
                        //print_r($params2);    
                    }
                }
                
                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                $result =1;
            //}
            return $result; 
        }
}
    public function editpostWidget($params)
    {
        $set_array = array('widget_name'=>$params['widget_name'],'author'=>$params['author']);
        $widgetAdminIdA = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId'],'widget_type_style'=>$params['widget_type_style']);
        
        //print_r($params['check_list']);
        //print_r($params['ulbid']);
        
        if($params['user_level'] == 'A'){
            //print_r($params['user_level']);
        
            if($params['radio'] == 'edit'){
                //print_r($params['radio']);
                
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst){
                    
                    $check_list = $params['check_list'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $widget_type_style = $params['widget_type_style'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author1 = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$params['langId'],'widget_type_style'=>$widget_type_style);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author1,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    $wid = $val['widget_id'];
                                    $this->db->where('widget_id',$wid);
                                    if($this->db->delete('postwidget')){
                                    
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'category_id'=>$val
                                                );
                                            $this->db->insert('postwidget',$params2);
                                            //print_r($params2);    
                                        }
                                    }else{
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'category_id'=>$val
                                                );
                                            $this->db->insert('postwidget',$params2);
                                        }
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            //echo "author name is ".$author1;
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author1
                            );
                            
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                
                                foreach($check_list as $key=>$val){
                                    $params2=array(
                                        'widget_id'=>$widget_id,
                                        'category_id'=>$val
                                        );
                                    $this->db->insert('postwidget',$params2);
                                    //print_r($params2);    
                                }
                                $result =1;
                            }
                        }
                    }
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
            }else if($params['radio'] == 'editexcept'){
                
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst){
                    
                    $check_list = $params['check_list'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author1 = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$params['langId']);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author1,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    $wid = $val['widget_id'];
                                    $this->db->where('widget_id',$wid);
                                    if($this->db->delete('postwidget')){
                                    
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'category_id'=>$val
                                                );
                                            $this->db->insert('postwidget',$params2);
                                            //print_r($params2);    
                                        }
                                    }else{
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'category_id'=>$val
                                                );
                                            $this->db->insert('postwidget',$params2);
                                            //print_r($params2);    
                                        }
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            //echo "author name is ".$author1;
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author1
                            );
                            
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                
                                foreach($check_list as $key=>$val){
                                    $params2=array(
                                        'widget_id'=>$widget_id,
                                        'category_id'=>$val
                                        );
                                    $this->db->insert('postwidget',$params2);
                                    //print_r($params2);    
                                }
                                $result =1;
                            }
                        }
                    }
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
            }else if($params['radio'] == 'delete'){
                //print_r($params['radio']);
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val,'langId'=>$params['langId']);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id']);
                        $this->db->where($condition);
                        if($this->db->delete('postwidget')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }else if($params['radio'] == 'deleteexcept'){
                //print_r($params['radio']);
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val,'langId'=>$params['langId']);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id']);
                        $this->db->where($condition);
                        if($this->db->delete('postwidget')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }
        }else{
            //print_r($params['user_level']);
           
            $check_list = $params['check_list'];
            $widgetAdminId = $params['widget_id'];
            $widgetName = $params['widget_name'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            $ulbid = $params['ulbid'];
            
           /* $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$ulbid);
            
            $this->db->select('widget_id');
            $this->db->from('widget_mst');
            $this->db->where($widgetAdminIdArray);
            $result1 = $this->db->get()->result_array();
            
            foreach($result1 as $val){*/
                
                $this->db->where('widget_id',$widgetAdminId);
                if($this->db->delete('postwidget')){
                
                    foreach($check_list as $key=>$val){
                        $params2=array(
                            'widget_id'=>$widgetAdminId,
                            'category_id'=>$val
                            );
                        $this->db->insert('postwidget',$params2);
                        //print_r($params2);    
                    }
                }else{
                    foreach($check_list as $key=>$val){
                        $params2=array(
                            'widget_id'=>$widgetAdminId,
                            'category_id'=>$val
                            );
                        $this->db->insert('postwidget',$params2);
                        //print_r($params2);    
                    }
                }
                
                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                $result =1;
            //}
            return $result; 
        }
    }
    
    /**  **/
    
    /** edit page code **/ 
    public function editpageWidget($params){
        
        $set_array = array('widget_name'=>$params['widget_name'],'author'=>$params['author']);
        $widgetAdminIdA = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId']);
        
        if($params['user_level'] == 'A'){
           
            if($params['radio'] == 'edit'){
                
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst){
                    
                    $check_list = $params['check_list'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author1 = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$params['langId']);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author1,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    $wid = $val['widget_id'];
                                    $this->db->where('widget_id',$wid);
                                    if($this->db->delete('pagewidget')){
                                    
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'page_id'=>$val,
                                                'user_level'=>$userLevel
                                                );
                                            $this->db->insert('pagewidget',$params2);
                                            //print_r($params2);    
                                        }
                                    }else{
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'page_id'=>$val,
                                                'user_level'=>$userLevel
                                                );
                                            $this->db->insert('pagewidget',$params2);
                                        }
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            //echo "author name is ".$author1;
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author1
                            );
                            
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                
                                foreach($check_list as $key=>$val){
                                    $params2=array(
                                        'widget_id'=>$widget_id,
                                        'page_id'=>$val,
                                        'user_level'=>$userLevel
                                        );
                                    $this->db->insert('pagewidget',$params2);
                                    //print_r($params2);    
                                }
                                $result =1;
                            }
                        }
                    }
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
            }else if($params['radio'] == 'editexcept'){
                
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst){
                    
                    $check_list = $params['check_list'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author1 = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$params['langId']);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author1,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    $wid = $val['widget_id'];
                                    $this->db->where('widget_id',$wid);
                                    if($this->db->delete('pagewidget')){
                                    
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'page_id'=>$val,
                                                'user_level'=>$userLevel
                                                );
                                            $this->db->insert('pagewidget',$params2);
                                            //print_r($params2);    
                                        }
                                    }else{
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'page_id'=>$val,
                                                'user_level'=>$userLevel
                                                );
                                            $this->db->insert('pagewidget',$params2);
                                        }
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            //echo "author name is ".$author1;
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author1
                            );
                            
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                
                                foreach($check_list as $key=>$val){
                                    $params2=array(
                                        'widget_id'=>$widget_id,
                                        'page_id'=>$val,
                                        'user_level'=>$userLevel
                                        );
                                    $this->db->insert('pagewidget',$params2);
                                    //print_r($params2);    
                                }
                                $result =1;
                            }
                        }
                    }
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
            }else if($params['radio'] == 'delete'){
                //print_r($params['radio']);
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val,'langId'=>$params['langId']);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id']);
                        $this->db->where($condition);
                        if($this->db->delete('pagewidget')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }else if($params['radio'] == 'deleteexcept'){
                //print_r($params['radio']);
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val,'langId'=>$params['langId']);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id']);
                        $this->db->where($condition);
                        if($this->db->delete('pagewidget')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }
        }else{
            //print_r($params['user_level']);
           
            $check_list = $params['check_list'];
            $widgetAdminId = $params['widget_id'];
            $widgetName = $params['widget_name'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            $ulbid = $params['ulbid'];
            
           /* $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$ulbid);
            
            $this->db->select('widget_id');
            $this->db->from('widget_mst');
            $this->db->where($widgetAdminIdArray);
            $result1 = $this->db->get()->result_array();
            
            foreach($result1 as $val){*/
                
                $this->db->where('widget_id',$widgetAdminId);
                if($this->db->delete('pagewidget')){
                
                    foreach($check_list as $key=>$val){
                        $params2=array(
                            'widget_id'=>$widgetAdminId,
                            'page_id'=>$val,
                            'user_level'=>$userLevel
                            );
                        $this->db->insert('pagewidget',$params2);
                        //print_r($params2);    
                    }
                }else{
                    foreach($check_list as $key=>$val){
                        $params2=array(
                            'widget_id'=>$widgetAdminId,
                            'page_id'=>$val,
                            'user_level'=>$userLevel
                            );
                        $this->db->insert('pagewidget',$params2);
                        //print_r($params2);    
                    }
                }
                
                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                $result =1;
            //}
            return $result; 
        }
        
    }
    
    /** edit tabs **/
    
    public function editTabWidget($params)
    {
        $set_array = array('widget_name'=>$params['widget_name'],'author'=>$params['author']);
        $widgetAdminIdA = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId']);
        
        
        if($params['user_level'] == 'A'){
           
            if($params['radio'] == 'edit'){
                
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst){
                    
                    $check_list = $params['check_list'];
                    $tab_type_id = $params['tab_type_id'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author1 = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$params['langId']);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author1,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    $wid = $val['widget_id'];
                                    $this->db->where('widget_id',$wid);
                                    if($this->db->delete('tabswidget')){
                                    
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'category_id'=>$val,
                                                'tab_type_id'=>$tab_type_id
                                                );
                                            $this->db->insert('tabswidget',$params2);
                                            //print_r($params2);    
                                        }
                                    }else{
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'category_id'=>$val,
                                                'tab_type_id'=>$tab_type_id
                                                );
                                            $this->db->insert('tabswidget',$params2);
                                        }
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            //echo "author name is ".$author1;
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author1
                            );
                            
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                
                                foreach($check_list as $key=>$val){
                                    $params2=array(
                                        'widget_id'=>$widget_id,
                                        'category_id'=>$val,
                                        'tab_type_id'=>$tab_type_id
                                        );
                                    $this->db->insert('tabswidget',$params2);
                                    //print_r($params2);    
                                }
                                $result =1;
                            }
                        }
                    }
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
            }else if($params['radio'] == 'editexcept'){
                
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst){
                    
                    $check_list = $params['check_list'];
                    $tab_type_id = $params['tab_type_id'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author1 = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$params['langId']);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author1,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    $wid = $val['widget_id'];
                                    $this->db->where('widget_id',$wid);
                                    if($this->db->delete('tabswidget')){
                                    
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'category_id'=>$val,
                                                'tab_type_id'=>$tab_type_id
                                                );
                                            $this->db->insert('tabswidget',$params2);
                                            //print_r($params2);    
                                        }
                                    }else{
                                        foreach($check_list as $key=>$val){
                                            $params2=array(
                                                'widget_id'=>$wid,
                                                'category_id'=>$val,
                                                'tab_type_id'=>$tab_type_id
                                                );
                                            $this->db->insert('tabswidget',$params2);
                                            //print_r($params2);    
                                        }
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            //echo "author name is ".$author1;
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author1
                            );
                            
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                
                                foreach($check_list as $key=>$val){
                                    $params2=array(
                                        'widget_id'=>$widget_id,
                                        'category_id'=>$val,
                                        'tab_type_id'=>$tab_type_id
                                        );
                                    $this->db->insert('tabswidget',$params2);
                                    //print_r($params2);    
                                }
                                $result =1;
                            }
                        }
                    }
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
                    return $result;
                }
            }else if($params['radio'] == 'delete'){
                //print_r($params['radio']);
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val,'langId'=>$params['langId']);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id']);
                        $this->db->where($condition);
                        if($this->db->delete('tabswidget')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }else if($params['radio'] == 'deleteexcept'){
                //print_r($params['radio']);
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val,'langId'=>$params['langId']);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id']);
                        $this->db->where($condition);
                        if($this->db->delete('tabswidget')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }
        }else{
            //print_r($params['user_level']);
           
            $check_list = $params['check_list'];
            $tab_type_id = $params['tab_type_id'];
            $widgetAdminId = $params['widget_id'];
            $widgetName = $params['widget_name'];
            $widgetType = $params['widget_type'];
            $flag = $params['flag'];
            $langId = $params['langId'];
            $userLevel = $params['user_level'];
            $author = $params['author'];
            $ulbid = $params['ulbid'];
            
           /* $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$ulbid);
            
            $this->db->select('widget_id');
            $this->db->from('widget_mst');
            $this->db->where($widgetAdminIdArray);
            $result1 = $this->db->get()->result_array();
            
            foreach($result1 as $val){*/
                
                $this->db->where('widget_id',$widgetAdminId);
                if($this->db->delete('tabswidget')){
                
                    foreach($check_list as $key=>$val){
                        $params2=array(
                            'widget_id'=>$widgetAdminId,
                            'category_id'=>$val,
                            'tab_type_id'=>$tab_type_id
                            );
                        $this->db->insert('tabswidget',$params2);
                        //print_r($params2);    
                    }
                }else{
                    foreach($check_list as $key=>$val){
                        $params2=array(
                            'widget_id'=>$widgetAdminId,
                            'category_id'=>$val,
                            'tab_type_id'=>$tab_type_id
                            );
                        $this->db->insert('tabswidget',$params2);
                        //print_r($params2);    
                    }
                }
                
                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                $result =1;
            //}
            return $result; 
        }
    }
    
    /** /
    /** tabs  **/
    public function gettabwidgetContent($params)
    {
        $results=array();  
        $userType = $params['user_type'];
        if($userType == 'A'){
            $widgetIdArray = array('widget_id'=>$params['widget_id']);
            $this->db->select('*');
            $this->db->from('standard_widget_mst');
            $this->db->where($widgetIdArray);
            $ress = $this->db->get()->result_array();
            
            $results['widgetName'] = $ress; 
            //print_r($ress[0]['widget_id']);
            foreach($ress as $val){
                $widgetid = array('widget_admin_code'=>$val['widget_id'],'langId'=>$params['langId']);
                $this->db->select('*');
                $this->db->from('widget_mst');
                $this->db->where($widgetid);
                $resul = $this->db->get()->result_array();
                $results['widgetDetails'] = $resul;
                
                foreach($resul as $val){
                    if($val['ulbid'] == $params['ulbid']){
                        $select_array=array('t.category_id','c.page_name','t.tab_type_id');
                        $condition=array('t.widget_id'=>$val['widget_id']);
                        $this->db->select($select_array);
                        $this->db->from('tabswidget t');
                        $this->db->join('custom_menus c','t.category_id=c.page_id');
                        $this->db->where($condition);
                        $results['selectedCategories']=$this->db->get()->result_array();
                    }
                }
            }
            
            $array = array();
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>3,'ulbid'=>$params['ulbid'],'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>3,'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $result = [];
    	    foreach ($array as $value) {
                $result = array_merge($result, $value);
            }
            
            $results['allcategories'] = $result;
            
        }else{
            $widgetIdArray = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($widgetIdArray);
            $ress = $this->db->get()->result_array();
            
            $results['widgetName'] = $ress; 
            //print_r($ress[0]['widget_id']);
            foreach($ress as $val){
                $widgetid = array('widget_id'=>$val['widget_id']);
                $this->db->select('*');
                $this->db->from('widget_mst');
                $this->db->where($widgetid);
                $resul = $this->db->get()->result_array();
                $results['widgetDetails'] = $resul;
                
                foreach($resul as $val){
                    $select_array=array('t.category_id','c.page_name','t.tab_type_id');
                    $condition=array('t.widget_id'=>$val['widget_id']);
                    $this->db->select($select_array);
                    $this->db->from('tabswidget t');
                    $this->db->join('custom_menus c','t.category_id=c.page_id');
                    $this->db->where($condition);
                    $results['selectedCategories']=$this->db->get()->result_array();
                }
            }
            
            $array = array();
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>3,'ulbid'=>$params['ulbid'],'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>3,'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $result = [];
    	    foreach ($array as $value) {
                $result = array_merge($result, $value);
            }
            
            $results['allcategories'] = $result;
        }
        return $results;
    }
    /**/
    /** posts **/
     public function getpostwidgetContent($params){
        $results=array();  
        $userType = $params['user_type'];
        if($userType == 'A'){
            $widgetIdArray = array('widget_id'=>$params['widget_id']);
            $this->db->select('*');
            $this->db->from('standard_widget_mst');
            $this->db->where($widgetIdArray);
            $ress = $this->db->get()->result_array();
            
            $results['widgetName'] = $ress; 
            //print_r($ress[0]['widget_id']);
            foreach($ress as $val){
                $widgetid = array('widget_admin_code'=>$val['widget_id'],'langId'=>$params['langId']);
                $this->db->select('*');
                $this->db->from('widget_mst');
                $this->db->where($widgetid);
                $resul = $this->db->get()->result_array();
                $results['widgetDetails'] = $resul;
                
                foreach($resul as $val){
                    
                    if($val['ulbid'] == $params['ulbid']){
                        //echo "okkkk.....";
                        $select_array=array('t.category_id','c.page_name');
                        $condition=array('t.widget_id'=>$val['widget_id']);
                        $this->db->select($select_array);
                        $this->db->from('postwidget t');
                        $this->db->join('custom_menus c','t.category_id=c.page_id');
                        $this->db->where($condition);
                        $results['selectedCategories']=$this->db->get()->result_array();
                    }
                }
            }
            
            $array = array();
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>3,'ulbid'=>$params['ulbid'],'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>3,'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $result = [];
    	    foreach ($array as $value) {
                $result = array_merge($result, $value);
            }
            
            $results['allcategories'] = $result;
            
        }else{
            $widgetIdArray = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($widgetIdArray);
            $ress = $this->db->get()->result_array();
            
            $results['widgetName'] = $ress; 
            //print_r($ress[0]['widget_id']);
            foreach($ress as $val){
                $widgetid = array('widget_id'=>$val['widget_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
                $this->db->select('*');
                $this->db->from('widget_mst');
                $this->db->where($widgetid);
                $resul = $this->db->get()->result_array();
                $results['widgetDetails'] = $resul;
                
                foreach($resul as $val){
                    $select_array=array('t.category_id','c.page_name');
                    $condition=array('t.widget_id'=>$val['widget_id']);
                    $this->db->select($select_array);
                    $this->db->from('postwidget t');
                    $this->db->join('custom_menus c','t.category_id=c.page_id');
                    $this->db->where($condition);
                    $results['selectedCategories']=$this->db->get()->result_array();
                }
            }
            
            $array = array();
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>3,'ulbid'=>$params['ulbid'],'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>3,'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $result = [];
    	    foreach ($array as $value) {
                $result = array_merge($result, $value);
            }
            
            $results['allcategories'] = $result;
        }
        return $results;
    }
    
    /* post close */
    
    /** page open **/
    public function getpagewidgetContent($params){
        
        $results=array();  
        $userType = $params['user_type'];
        if($userType == 'A'){
            $widgetIdArray = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId']);
            $this->db->select('*');
            $this->db->from('standard_widget_mst');
            $this->db->where($widgetIdArray);
            $ress = $this->db->get()->result_array();
            
            $results['widgetName'] = $ress; 
            //print_r($ress[0]['widget_id']);
            foreach($ress as $val){
                $widgetid = array('widget_admin_code'=>$val['widget_id'],'langId'=>$params['langId']);
                $this->db->select('*');
                $this->db->from('widget_mst');
                $this->db->where($widgetid);
                $resul = $this->db->get()->result_array();
                $results['widgetDetails'] = $resul;
                
                foreach($resul as $val){
                    if($val['ulbid'] == $params['ulbid']){
                        //echo "okkk......";
                        
                        $select_array=array('t.page_id','c.page_name');
                        $condition=array('t.widget_id'=>$val['widget_id'],'t.user_level'=>$params['user_type']);
                        $this->db->select($select_array);
                        $this->db->from('pagewidget t');
                        $this->db->join('standard_custom_menus c','t.page_id=c.page_id');
                        $this->db->where($condition);
                        
                        $results['selectedCategories']=$this->db->get()->result_array();
                        //echo $this->db->last_query();
                        //print_r($results['selectedCategories']);
                        
                    }
                }
            }
            
            $array = array();
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>0,'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('standard_custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $result = [];
    	    foreach ($array as $value) {
                $result = array_merge($result, $value);
            }
            
            $results['allcategories'] = $result;
            
        }else{
            //echo $params['ulbid'];
            $widgetIdArray = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($widgetIdArray);
            $ress = $this->db->get()->result_array();
            
            $results['widgetName'] = $ress; 
            //print_r($ress[0]['widget_id']);
            foreach($ress as $val){
                $widgetid = array('widget_id'=>$val['widget_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
                $this->db->select('*');
                $this->db->from('widget_mst');
                $this->db->where($widgetid);
                $resul = $this->db->get()->result_array();
                $results['widgetDetails'] = $resul;
                
                foreach($resul as $val){
                    
                    $this->db->select('*');
                    $this->db->from('pagewidget');
                    $this->db->where('widget_id',$val['widget_id']);
                    $res = $this->db->get()->result_array();
                    //print_r($res);
                   
                    if($res[0]['user_level'] == 'A'){
                        $select_array=array('page_id','page_name');
                        $condition=array('standard_page_id'=>$res[0]['page_id'],'ulbid'=>$params['ulbid']);
                        $this->db->select($select_array);
                        $this->db->from('custom_menus');
                        $this->db->where($condition);
                        $results['selectedCategories']=$this->db->get()->result_array();
                    }else{
                        $select_array=array('t.page_id','c.page_name','t.user_level');
                        $condition=array('t.widget_id'=>$val['widget_id']);
                        $this->db->select($select_array);
                        $this->db->from('pagewidget t');
                        $this->db->join('custom_menus c','t.page_id=c.page_id');
                        $this->db->where($condition);
                        $results['selectedCategories']=$this->db->get()->result_array();
                    }
                    
                }
            }
            
            $array = array();
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>0,'ulbid'=>$params['ulbid'],'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $result = [];
    	    foreach ($array as $value) {
                $result = array_merge($result, $value);
            }
            
            $results['allcategories'] = $result;
        }
        return $results;
    }
    
    /** page close **/
    
    /** get target types**/
    
    public function getTargetTypes()
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $result=$this->db->get('window_mst');
        return $result;
    }
    
    /** photo gallery widget content ***/
    
    public function getphotogallerywidgetContent($params)
    {
        $results = array();
        $userType = $params['user_type'];
        if($userType == 'A'){
            //print_r($params['user_type']);
            $condition=array('widget_id'=>$params['widget_id'],'langId'=>$params['langId']);
            $adminWidgetId = array('widget_admin_code'=>$params['widget_id'],'langId'=>$params['langId']);
            //print_r($condition);
             //print_r($adminWidgetId);
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($adminWidgetId);
            $resul = $this->db->get()->result_array();
            $results['widgetDetails'] = $resul;
            
            $this->db->select('*');
            $this->db->from('standard_widget_mst');
            $this->db->where($condition);
            $res = $this->db->get()->result_array();
            $results['widgetName'] = $res;
            
            foreach($resul as $key =>$val){
                $widgetId = array('widget_id'=>$val['widget_id']);
                if($val['ulbid'] == $params['ulbid']){
                    $this->db->select('*');
                    $this->db->from('photogallery_widgets');
                    $this->db->where($widgetId);
                    $selected_menuid=$this->db->get()->result_array();
                    $results['widgetContent']=$selected_menuid;
                }
            }
            
        }else{
            //print_r($params['user_type']);
            $condition=array('widget_id'=>$params['widget_id'],'ulbid' => $params['ulbid'],'langId'=>$params['langId']);
            
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($condition);
            $res = $this->db->get()->result_array();
            $results['widgetName'] = $res;
            
            foreach($res as $key =>$val){
                $widgetIdA = array('widget_id' => $val['widget_id'],'ulbid' => $params['ulbid'],'langId'=>$params['langId']);
                $this->db->select('*');
                $this->db->from('widget_mst');
                $this->db->where($widgetIdA);
                $resul = $this->db->get()->result_array();
                $results['widgetDetails'] = $resul;
            
                foreach($resul as $key =>$val){
                    $widgetId = array('widget_id'=>$val['widget_id']);
                    
                    $this->db->select('*');
                    $this->db->from('photogallery_widgets');
                    $this->db->where($widgetId);
                    $selected_menuid=$this->db->get()->result_array();
                    $results['widgetContent']=$selected_menuid;
                }
            }  
        }
        //print_r($results);
        return $results;
    }
    
    /** close **/
    
    /** Single Image Link edit Code **/
   /* public function singleImageLinkWidget($params){
        
        $set_array=array('widget_name'=>$params['widget_name']);
        $condition=array('widget_id'=>$params['widget_id']);
        
        $this->db->set($set_array);
        $this->db->where($condition);
        $result=$this->db->update('widget_mst');
    }*/
    
    /** close Single Image Link code **/
    
    /** text image widget ***/
    
    public function editImageTextwidget($params)
    {
       
        $set_array = array('widget_name'=>$params['widget_name'],'author'=>$params['author']);
        $widgetAdminIdA = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId'],'widget_type_style'=>$params['widget_type_style']);
        
        if($params['user_level'] == 'A')
        {
           
            if($params['radio'] == 'edit')
            {
                  
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
               
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst)
                {
                 
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $widget_type_style = $params['widget_type_style'];
                    $file_name = $params['file_name'];
                    $thumbnail_path = $params['thumbnail_path'];
                    $source_path = $params['source_path'];
                    $title = $params['title'];
                    $url_link = $params['url_link'];
                    $target = $params['target'];
                    $imgx = $params['imgx'];
                    $imgy = $params['imgy'];
                    $width = $params['width'];
                    $height = $params['height'];
                    $alt = $params['alt'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $description = $params['description'];
                    $eventDate = $params['eventDate'];
                    $eventTime = $params['eventTime'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$langId,'widget_type_style'=>$widget_type_style);
                        
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        
                        
                    
                        if($result_check){
                          
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                           // echo $this->db->last_query();
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    $condition=array('widget_id'=>$val['widget_id']);
                                    $set_array=array(
                                            'file_name'=>$file_name,
                                            'thumbnail_path'=>$thumbnail_path,
                                            'source_path'=>$source_path,
                                            'title'=>$title,
                                            'url_link'=>$url_link,
                                            'flag'=>$flag,
                                            'target'=>$target,
                                            'imgx'=>$imgx,
                                            'imgy'=>$imgy,
                                            'width'=>$width,
                                            'height'=>$height,
                                            'description'=>$description,
                                            'eventDate'=>$eventDate,
                                            'eventTime'=>$eventTime
                                        );
                                    $this->db->select('widget_id');
                                    $this->db->from('image_text_widgets');
                                    $this->db->where($condition);
                                    $res1 = $this->db->get()->result_array();
                                    if($res1){
                                        $this->db->set($set_array);
                                        $this->db->where($condition);
                                        $result=$this->db->update('image_text_widgets');
                                    }else{
                                        $params=array(
                                            'widget_id'=>$val['widget_id'],
                                            'file_name'=>$file_name,
                                            'thumbnail_path'=>$thumbnail_path,
                                            'source_path'=>$source_path,
                                            'title'=>$title,
                                            'url_link'=>$url_link,
                                            'flag'=>$flag,
                                            'target'=>$target,
                                            'imgx'=>$imgx,
                                            'imgy'=>$imgy,
                                            'width'=>$width,
                                            'height'=>$height,
                                            'alt'=>$alt
                                        );
                                        //print_r($params);    
                                        $this->db->insert('image_text_widgets',$params);
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author
                            );
                            $this->db->insert('widget_mst1',$param);
                            $insert_id = $this->db->insert_id();
                            print_r($insert_id);die;
                           
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                $params=array(
                                    'widget_id'=>$widget_id,
                                    'file_name'=>$file_name,
                                    'thumbnail_path'=>$thumbnail_path,
                                    'source_path'=>$source_path,
                                    'title'=>$title,
                                    'url_link'=>$url_link,
                                    'flag'=>$flag,
                                    'target'=>$target,
                                    'imgx'=>$imgx,
                                    'imgy'=>$imgy,
                                    'width'=>$width,
                                    'height'=>$height,
                                    'alt'=>$alt
                                    );
                                //print_r($params);    
                                $this->db->insert('image_text_widgets',$params);
                                $result =1;
                            }
                        }
                    }
                    
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
                    return $result;
                }    
            }
        }
    }
    
    /**** close ****/
    /*** edit menu widget ***/
    
    public function editMenuwidget($params)
    {
        $set_array = array('widget_name'=>$params['widget_name'],'author'=>$params['author']);
        $widgetAdminIdA = array('widget_id'=>$params['widget_id']);
        
        if($params['user_level'] == 'A'){
            
            if($params['radio'] == 'edit'){
                
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                if($result_standard_widget_mst){
                    
                    $menu_id=$params['menu_type_id'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$langId);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    
                                    $set_array=array('menu_type_id'=>$menu_id);
                                    $condition=array('widget_id'=>$val['widget_id']);
                                    
                                    $this->db->select('*');
                                    $this->db->from('menuwidgets');
                                    $this->db->where($condition);
                                    $menVal = $this->db->get()->result_array();
                                    
                                    if($menVal){
                                        $this->db->set($set_array);
                                        $this->db->where($condition);
                                        $result=$this->db->update('menuwidgets');
                                    }else{
                                        $params=array(
                                            'menu_type_id'=>$menu_id,
                                            'widget_id'=>$val['widget_id'],
                                            'flag'=>1
                                        );
                                        //print_r($params);    
                                        $this->db->insert('menuwidgets',$params);
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author
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
                                
                                $result =1;
                            }
                        }
                    }
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
                                
                    return $result;
                }    
            }else if($params['radio'] == 'editexcept'){
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                if($result_standard_widget_mst){
                    
                    $menu_id=$params['menu_type_id'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$langId);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    
                                    $set_array=array('menu_type_id'=>$menu_id);
                                    $condition=array('widget_id'=>$val['widget_id']);
                                    
                                    $this->db->select('*');
                                    $this->db->from('menuwidgets');
                                    $this->db->where($condition);
                                    $menVal = $this->db->get()->result_array();
                                    
                                    if($menVal){
                                        $this->db->set($set_array);
                                        $this->db->where($condition);
                                        $result=$this->db->update('menuwidgets');
                                    }else{
                                        $params=array(
                                            'menu_type_id'=>$menu_id,
                                            'widget_id'=>$val['widget_id'],
                                            'flag'=>1
                                        );
                                        //print_r($params);    
                                        $this->db->insert('menuwidgets',$params);
                                    }
                                    
                                    $result =1;
                                }
                            }
                        }else{
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author
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
                                
                                $result =1;
                            }
                        }
                    }
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
            }else if($params['radio'] == 'delete'){
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val,'langId'=>$params['langId']);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id']);
                        $this->db->where($condition);
                        if($this->db->delete('menuwidgets')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }else if($params['radio'] == 'deleteexcept'){
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val,'langId'=>$params['langId']);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id']);
                        $this->db->where($condition);
                        if($this->db->delete('menuwidgets')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }
        }else{
            //print_r($params['user_level']);
            
            $menu_id=$params['menu_type_id'];
            $widgetAdminId = $params['widget_id'];
            $ulbid = $params['ulbid'];
            //echo $menu_id.','.$widgetAdminId;
            /*$widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$ulbid);
            
            $this->db->select('widget_id');
            $this->db->from('widget_mst');
            $this->db->where($widgetAdminIdArray);
            $result1 = $this->db->get()->result_array();
            
            foreach($result1 as $val){
                
            */  
                $set = array('author'=>$params['author']);
                $cond = array('widget_id'=>$widgetAdminId);
                $this->db->set($set);
                $this->db->where($cond);
                if($this->db->update('widget_mst')){
                
                    $set_array=array('menu_type_id'=>$menu_id);
                    $condition=array('widget_id'=>$widgetAdminId);
                    $this->db->select('*');
                    $this->db->from('menuwidgets');
                    $this->db->where($condition);
                    $result1 = $this->db->get()->result_array();
                    if($result1){
                        $this->db->set($set_array);
                        $this->db->where($condition);
                        $result=$this->db->update('menuwidgets');
                    }else{
                        $params=array(
                                'menu_type_id'=>$menu_id,
                                'widget_id'=>$widgetAdminId,
                                'flag'=>1
                            );
                        //print_r($params);    
                        $this->db->insert('menuwidgets',$params);
                    }    
                    
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                    $result =1;
                }
            //}
            return $result; 
        }
    }
    
    /*** close ***/
    
    /*** text widget functions ***/
    public function editTextwidget($params)
    {
        $set_array = array('widget_name'=>$params['widget_name'],'author'=>$params['author']);
        $widgetAdminIdA = array('widget_id'=>$params['widget_id'],'widget_type_style'=>$params['widget_type_style']);
        
        if($params['user_level'] == 'A'){
           
            if($params['radio'] == 'edit'){
                 
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst){
                    
                    $content = $params['content'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $widget_type_style = $params['widget_type_style'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$langId);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    
                                    $set_array=array('content'=>$content);
                                    $condition=array('widget_id'=>$val['widget_id']);
                                    
                                    $this->db->select('widget_id');
                                    $this->db->from('textwidgets');
                                    $this->db->where($condition);
                                    $result1 = $this->db->get()->result_array();
                                    if($result1){
                                        $this->db->set($set_array);
                                        $this->db->where($condition);
                                        $result=$this->db->update('textwidgets');
                                    }else{
                                        $params=array(
                                            'content'=>$content,
                                            'widget_id'=>$val['widget_id'],
                                            'flag'=>1
                                            );
                                        //print_r($params);    
                                        $this->db->insert('textwidgets',$params);
                                    }
                                    
                                    $result =1;
                                }
                            }
                        }else{
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author
                            );
                            
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                $params=array(
                                    'content'=>$content,
                                    'widget_id'=>$widget_id,
                                    'flag'=>1
                                    );
                                //print_r($params);    
                                $this->db->insert('textwidgets',$params);
                                
                                $result =1;
                            }
                        }
                    }
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
            }if($params['radio'] == 'editexcept'){
                 
                $this->db->set($set_array);
                $this->db->where($widgetAdminIdA);
                $result_standard_widget_mst = $this->db->update('standard_widget_mst');
                //print_r($result_standard_widget_mst);
                if($result_standard_widget_mst){
                    
                    $content = $params['content'];
                    $widgetAdminId = $params['widget_id'];
                    $widgetName = $params['widget_name'];
                    $widgetType = $params['widget_type'];
                    $flag = $params['flag'];
                    $langId = $params['langId'];
                    $userLevel = $params['user_level'];
                    $author = $params['author'];
                    
                    foreach($params['ulb_check_list'] as $key => $val){
                        
                        $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$val,'langId'=>$langId);
                        $set_array = array('widget_name'=>$widgetName,'author'=>$author,'user_level'=>$userLevel);
                        
                        $this->db->select('*');
                        $this->db->from('widget_mst');
                        $this->db->where($widgetAdminIdArray);
                        $result_check = $this->db->get()->result_array();
                        
                        if($result_check){
                            $this->db->set($set_array);
                            $this->db->where($widgetAdminIdArray);
                            $result_widget_mst = $this->db->update('widget_mst');
                            
                            if($result_widget_mst){
                                
                                $this->db->select('widget_id');
                                $this->db->from('widget_mst');
                                $this->db->where($widgetAdminIdArray);
                                $result1 = $this->db->get()->result_array();
                                
                                foreach($result1 as $val){
                                    
                                    $set_array=array('content'=>$content);
                                    $condition=array('widget_id'=>$val['widget_id']);
                                    
                                    $this->db->select('widget_id');
                                    $this->db->from('textwidgets');
                                    $this->db->where($condition);
                                    $result1 = $this->db->get()->result_array();
                                    if($result1){
                                        $this->db->set($set_array);
                                        $this->db->where($condition);
                                        $result=$this->db->update('textwidgets');
                                    }else{
                                        $params=array(
                                            'content'=>$content,
                                            'widget_id'=>$val['widget_id'],
                                            'flag'=>1
                                            );
                                        //print_r($params);    
                                        $this->db->insert('textwidgets',$params);
                                    }
                                    $result =1;
                                }
                            }
                        }else{
                            $param=array(
                                'widget_name'=>$widgetName,
                                'widget_type'=>$widgetType,
                                'flag'=>$flag,
                                'langId'=>$langId,
                                'ulbid'=>$val,
                                'user_level'=>$userLevel,
                                'widget_admin_code'=>$widgetAdminId,
                                'author'=>$author
                            );
                            
                            if($this->db->insert('widget_mst',$param)){
                                $widget_id=$this->db->insert_id();
                                $params=array(
                                    'content'=>$content,
                                    'widget_id'=>$widget_id,
                                    'flag'=>1
                                    );
                                //print_r($params);    
                                $this->db->insert('textwidgets',$params);
                                
                                $result =1;
                            }
                        }
                    }
                    $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
            }else if($params['radio'] == 'delete'){
                //print_r($params['radio']);
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id'],'content'=>$params['content']);
                        $this->db->where($condition);
                        if($this->db->delete('textwidgets')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }else if($params['radio'] == 'deleteexcept'){
                //print_r($params['radio']);
                foreach($params['ulb_check_list'] as $key => $val){
                    
                    $widgetAdminId = array('widget_admin_code'=>$params['widget_id'],'ulbid'=>$val);
                    
                    $this->db->select('widget_id');
                    $this->db->from('widget_mst');
                    $this->db->where($widgetAdminId);
                    $result1 = $this->db->get()->result_array();
                        
                    foreach($result1 as $val){
                        
                        $condition=array('widget_id'=>$val['widget_id'],'content'=>$params['content']);
                        $this->db->where($condition);
                        if($this->db->delete('textwidgets')){
                        
                            $widget_id = array('widget_id'=>$val['widget_id']);
                            $this->db->where($widget_id);
                            if($this->db->delete('widget_mst')){
                                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                                $result = 1;
                            }
                        }
                    }
                    
                }
                return $result;
            }
        }else{
            //print_r($params['user_level']);
            
            $content = $params['content'];
            $widgetAdminId = $params['widget_id'];
            $ulbid = $params['ulbid'];
            
           /* $widgetAdminIdArray = array('widget_admin_code'=>$widgetAdminId,'ulbid'=>$ulbid);
            
            $this->db->select('widget_id');
            $this->db->from('widget_mst');
            $this->db->where($widgetAdminIdArray);
            $result1 = $this->db->get()->result_array();
            
            foreach($result1 as $val){*/
                
                $set_array=array('content'=>$content);
                $condition=array('widget_id'=>$widgetAdminId);
                
                $this->db->select('widget_id');
                $this->db->from('textwidgets');
                $this->db->where($condition);
                $result1 = $this->db->get()->result_array();
                if($result1){
                    $this->db->set($set_array);
                    $this->db->where($condition);
                    $result=$this->db->update('textwidgets');
                }else{
                    $params=array(
                        'content'=>$content,
                        'widget_id'=>$widgetAdminId,
                        'flag'=>1
                        );
                    //print_r($params);    
                    $this->db->insert('textwidgets',$params);
                }
                
                $query = $this->db->query("select * from  widget_mst where widget_id='".$val['widget_id']."';");
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
                $result =1;
            //}
            return $result; 
        }    
    }
    public function getImageTextwidgetContent($params)
    {
        $results = array();  
        $userType = $params['user_type'];
        if($userType == 'A'){
           
            $condition=array('widget_id'=>$params['widget_id']);
            $adminWidgetId = array('widget_admin_code'=>$params['widget_id'],'langId'=>$params['langId']);
            
            $this->db->select('*');
            $this->db->from('standard_widget_mst');
            $this->db->where($condition);
            $res = $this->db->get()->result_array();
            $results['widgetName'] = $res;
            
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($adminWidgetId);
            $resul = $this->db->get()->result_array();
            $results['widgetDetails'] = $resul;
            
            //echo '<pre>';print_r($resul);
            
            foreach($resul as $key =>$val){
                $widgetId = array('widget_id'=>$val['widget_id']);
                
                $this->db->select('*');
                $this->db->from('image_text_widgets');
                $this->db->where($widgetId);
                $selected_menuid=$this->db->get()->result_array();
                $results['widgetContent']=$selected_menuid;
            }
            //print_r($results['widgetContent']);exit;
          
        }else{
            $condition=array('widget_id'=>$params['widget_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
            
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($condition);
            $res = $this->db->get()->result_array();
            $results['widgetName'] = $res;
            
            foreach($res as $key =>$val){
                $widgetId = array('widget_id'=>$val['widget_id']);
                
                $this->db->select('*');
                $this->db->from('image_text_widgets');
                $this->db->where($widgetId);
                $selected_menuid=$this->db->get()->result_array();
                $results['widgetContent']=$selected_menuid;
            }
                
        }
       return $results;
    }
    
    public function getMenuwidgetContent($params)
    {
        $results=array();  
        $userType = $params['user_type'];
        if($userType == 'A'){
            $select_array=array('menu_type_id','menu_type_desc'); 
            
            $this->db->select($select_array);
            $this->db->from('standard_menu_types');
            $result=$this->db->get()->result_array();
            $results['standMenuType']=$result;
        
            $condition=array('widget_id'=>$params['widget_id'],'langId'=>$params['langId']);
            $adminWidgetId = array('widget_admin_code'=>$params['widget_id'],'langId'=>$params['langId']);
            
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($adminWidgetId);
            $resul = $this->db->get()->result_array();
            
            foreach($resul as $key =>$val){
                if($val['ulbid'] == $params['ulbid']){
                    $widgetId = array('widget_id'=>$val['widget_id']);
                    $this->db->select('*');
                    $this->db->from('menuwidgets');
                    $this->db->where($widgetId);
                    $selected_menuid=$this->db->get()->row_array();
                    $results['selectedMenuType']=$selected_menuid;
                }
                
            }
            
            $results['widgetDetails'] = $resul;
            
            $this->db->select('widget_name');
            $this->db->from('standard_widget_mst');
            $this->db->where($condition);
            $res = $this->db->get()->result_array();
            $results['widgetName'] = $res;
        }else{
            $select_array=array('menu_type_id','menu_type_desc'); 
            $cond1 = array('ulbid' => $params['ulbid']);
            $this->db->select($select_array);
            $this->db->from('menu_type_mst');
            $this->db->where($cond1);
            $result=$this->db->get()->result_array();
            $results['standMenuType']=$result;
        
            $condition=array('widget_id'=>$params['widget_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
            
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($condition);
            $res = $this->db->get()->result_array();
            $results['widgetName'] = $res;
            
            foreach($res as $key => $value){
                $widgetId = array('widget_id' => $value['widget_id']);
                $select_array=array('*');
                $this->db->select($select_array);
                $this->db->from('menuwidgets');
                $this->db->where($widgetId);
                $selected_menuid=$this->db->get()->row_array();
                $results['selectedMenuType']=$selected_menuid;
                
            }
        }
        return $results;
    }
    
    public function getwidget_edit($widget_id)
   {
     //$condition=array('widget_id'=>$params['widget_id']);
     
     $sql = "Select * from widget_mst where widget_id='".$widget_id."'";
     $query = $this->db->query($sql);
     return $query->result();
   }
    
    
    public function getMenuwidgetname($params)
    {
       
       
       $condition=array('widget_id'=>$params['widget_id']);
       $select_array=array('widget_name');
       $this->db->select($select_array);
       $this->db->from('widget_mst');
       $this->db->where($condition);
       $selected_menuid=$this->db->get()->row_array();
       $results=$selected_menuid;
       
       //print_r($results);
       
       return $results;
    }
    
    
    public function getTextwidgetContent($params)
    {
        $results = array();  
        $userType = $params['user_type'];
        if($userType == 'A'){
           
            $condition=array('widget_id'=>$params['widget_id'],'langId'=>$params['langId']);
            $adminWidgetId = array('widget_admin_code'=>$params['widget_id'],'langId'=>$params['langId']);
            
            $this->db->select('*');
            $this->db->from('standard_widget_mst');
            $this->db->where($condition);
            $res = $this->db->get()->result_array();
            $results['widgetName'] = $res;
            
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($adminWidgetId);
            $resul = $this->db->get()->result_array();
            $results['widgetDetails'] = $resul;
            
            foreach($resul as $key =>$val){
                if($val['ulbid'] == $params['ulbid']){
                    $widgetId = array('widget_id'=>$val['widget_id']); 
                    
                    $this->db->select('*');
                    $this->db->from('textwidgets');
                    $this->db->where($widgetId);
                    $selected_menuid=$this->db->get()->row_array();
                    $results['widgetContent']=$selected_menuid;
                }
            }
        }else{
            $condition=array('widget_id'=>$params['widget_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
            
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($condition);
            $res = $this->db->get()->result_array();
            $results['widgetName'] = $res;
            
            foreach($res as $key =>$val){
                $widgetId = array('widget_id'=>$val['widget_id']);
                
                $this->db->select('*');
                $this->db->from('textwidgets');
                $this->db->where($widgetId);
                $selected_menuid=$this->db->get()->row_array();
                $results['widgetContent']=$selected_menuid;
            }
                
        }
       return $results;
    }
    
    public function deleteContent($params)
    {
        
        $this->db->where($params);
        $this->db->delete('widget_mst');
        $this->db->delete('textwidgets');
        $this->db->delete('image_text_widgets');
        $this->db->delete('photogallery_widgets');
        return 1;
   }
    /**** close text widget functions ***/
    
    public function getWidgets($params)
    {
        
        if($params['user_type']!='A')
        {
            if($this->session->userdata('is_custom_user')=='Yes'){
                $where=array('langId'=>$this->session->userdata('langId'),'user_id'=>$this->session->userdata('userid'),'ulbid'=>$params['ulbid']);
            }else{
                $where=array('langId'=>$this->session->userdata('langId'),'user_category'=>$this->session->userdata('user_category'),'ulbid'=>$params['ulbid']);
            }
        
            $select_array=array('user_id','user_category','is_edit_permission','is_delete_permission','wm.*');
            
            $this->db->select($select_array);
            $this->db->from('widget_permissions w');
            $this->db->join('widget_mst wm','w.widget_id=wm.widget_admin_code');
            $this->db->where($where);
            $this->db->order_by('wm.ts','DESC');
            $result['widgetData']=$this->db->get()->result_array();
            //echo $this->db->last_query();
           
        }else{
        
            if($this->session->userdata('is_custom_user')=='Yes'){
            
            $where=array('langId'=>$this->session->userdata('langId'));
            }
            else
            {
            $where=array('langId'=>$this->session->userdata('langId'));
            
            }
        
            
            $this->db->select('*');
            $this->db->from('standard_widget_mst');
            $this->db->where($where);
            $this->db->order_by('ts','DESC');
            
            $result['widgetData']=$this->db->get()->result_array();
            //echo $this->db->last_query();
        }
        
        
        $this->db->select('*');
        $this->db->from('widget_type_mst');
        $result['widgetType'] = $this->db->get()->result_array();
        
        return $result;
     
        
    }
    
     public function getWidgetsbackup($params)
    {
        
       $select_array=array('*'); 
       $this->db->select($select_array);
       $this->db->where($params);
       $this->db->order_by('ts','DESC');
       $result['widgetData'] = $this->db->get('widget_mst')->result_array();
       
       $this->db->select('*');
       $this->db->from('widget_type_mst');
       $result['widgetType'] = $this->db->get()->result_array();
       
       return $result;
     
        
    }
    
   
    public function selectDeleteWidgetData($check_list){
        //$result = array();
        foreach($check_list as $key=>$val){
            $split = explode('_',$val);
            $this->db->where('widget_id',$split[0]);
            
            if($this->db->delete('standard_widget_mst')){
                $this->db->select('*');
                $this->db->from('widget_mst');
                $this->db->where('widget_admin_code',$split[0]);
                $result = $this->db->get()->result_array();
                
                $this->db->where('widget_admin_code',$split[0]);
                if($this->db->delete('widget_mst')){
                    
                    $this->db->select('*');
                    $this->db->from('widget_type_mst');
                    $this->db->where('widget_type_id',$split[1]);
                    $res = $this->db->get()->result_array();
                    
                    foreach($result as $k=>$v){
                        foreach($res as $key=>$val){
                            $tableName = $val['widget_table_name'];
                            if($split[1] == '4' || $split[1] == '5' || $split[1] == '7'){
                                $this->db->select('*');
                                $this->db->from($tableName);
                                $this->db->where('widget_id',$v['widget_id']);
                                $widdet = $this->db->get()->result_array();
                                foreach($widdet as $k1 => $v1){
                                    $thumbnail_path = "..".$v1['thumbnail_path'];
                                    $folder_path = "..".$v1['folder_path'];
                                    $full_path = "..".$v1['full_path'];
                                    $source_path = "..".$v1['source_path'];
                                    if(file_exists($full_path)){
                                        unlink($full_path);
                                    }
                                    if(file_exists($thumbnail_path)){
                                        unlink($thumbnail_path);
                                    }
                                    if(file_exists($folder_path)){
                                        unlink($folder_path);
                                    }
                                    if(file_exists($source_path)){
                                        unlink($source_path);
                                    }
                                }
                            }
                            $this->db->where('widget_id',$v['widget_id']);
                            $this->db->delete($tableName);
                        }
                    }
                    $this->db->where('widget_id',$split[0]);
                    $this->db->delete('widget_permissions');
                }
            }
        }
        return 1;
    }
    
    public function updateImageCropContent($params){
        $widgetType = $params['widget_type'];
        if($widgetType == '4'){
            $update = array(
                    'thumbnail_path'=>$params['dest_path'],
                    'imgx'=>$params['x'],
                    'imgy'=>$params['y'],
                    'width'=>$params['w'],
                    'height'=>$params['h']
                );
            $where = array('id'=>$params['id'],'widget_id'=>$params['widget_id']); 
            $this->db->set($update);
            $this->db->where($where);
            $result = $this->db->update('photogallery_widgets');
            return $result;   
        }else if($widgetType == '5'){
            $update = array(
                    'thumbnail_path'=>$params['dest_path'],
                    'imgx'=>$params['x'],
                    'imgy'=>$params['y'],
                    'width'=>$params['w'],
                    'height'=>$params['h']
                );
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where('widget_admin_code',$params['widget_id']);
            $rr = $this->db->get()->result_array();
            foreach($rr as $k => $v){
                $where = array('widget_id'=>$v['widget_id']); 
                $this->db->set($update);
                $this->db->where($where);
                $this->db->update('image_text_widgets');
            }
            
            return 1;
        }
    }
    
    
        public function getsliderwidgetContent($params){
        //echo "okk";
        $results=array();  
        $userType = $params['user_type'];
        //print_r($userType);
        if($userType == 'A'){
            $widgetIdArray = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId']);
            //print_r($widgetIdArray);
            $this->db->select('*');
            $this->db->from('standard_widget_mst');
            $this->db->where($widgetIdArray);
            $ress = $this->db->get()->result_array();
            
            $results['widgetName'] = $ress; 
            //print_r($ress[0]['widget_id']);
            foreach($ress as $val){
                $widgetid = array('widget_admin_code'=>$val['widget_id'],'langId'=>$params['langId']);
                //print_r($widgetid);
                $this->db->select('*');
                $this->db->from('widget_mst');
                $this->db->where($widgetid);
                $resul = $this->db->get()->result_array();
                $results['widgetDetails'] = $resul;
                //print_r($resul);
                foreach($resul as $val){
                    if($val['ulbid'] == $params['ulbid']){
                        //echo "okkk......";
                        
                        $select_array=array('t.page_id','c.page_name');
                        $condition=array('t.widget_id'=>$val['widget_id']);
                        $this->db->select($select_array);
                        $this->db->from('slider_widgets t');
                        $this->db->join('custom_menus c','t.page_id=c.page_id');
                        $this->db->where($condition);
                        
                        $results['selectedCategories']=$this->db->get()->result_array();
                        //echo $this->db->last_query();
                        //print_r($results['selectedCategories']);
                       
                    }
                }
            }
            
            $array = array();
          
            $select_array=array('p.page_id','p.category_id','c.page_id','c.page_name');
 			$condition=array('p.category_id'=>542,'c.is_custumlink'=>2);
 			$this->db->select($select_array);
 			$this->db->from('post_category_map p');
		    $this->db->join('custom_menus c','p.page_id=c.page_id');			 
 			$this->db->where($condition);
			$array[] = $this->db->get()->result_array();
			
            $result = [];
    	    foreach ($array as $value) {
                $result = array_merge($result, $value);
            }
            
            $results['allcategories'] = $result;
            
        }else{
            //echo $params['ulbid'];
            $widgetIdArray = array('widget_id'=>$params['widget_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
            $this->db->select('*');
            $this->db->from('widget_mst');
            $this->db->where($widgetIdArray);
            $ress = $this->db->get()->result_array();
            
            $results['widgetName'] = $ress; 
            //print_r($ress[0]['widget_id']);
            foreach($ress as $val){
                $widgetid = array('widget_id'=>$val['widget_id'],'langId'=>$params['langId'],'ulbid'=>$params['ulbid']);
                
                $this->db->select('*');
                $this->db->from('widget_mst');
                $this->db->where($widgetid);
                $resul = $this->db->get()->result_array();
                $results['widgetDetails'] = $resul;
                
                 foreach($resul as $val){
                    $select_array=array('t.page_id','c.page_name');
                    $condition=array('t.widget_id'=>$val['widget_id']);
                    $this->db->select($select_array);
                    $this->db->from('slider_widgets t');
                    $this->db->join('custom_menus c','t.page_id=c.page_id');
                    $this->db->where($condition);
                    $results['selectedCategories']=$this->db->get()->result_array();
                }
                
            }
            
            $array = array();
            
             $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>2,'ulbid'=>$params['ulbid'],'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
            $select_array=array('page_id','page_name');
            $condition=array('is_custumlink'=>2,'langId'=>$params['langId']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
           
            $this->db->where($condition);
            $array[] = $this->db->get()->result_array();
            
         
            $result = [];
    	    foreach ($array as $value) {
                $result = array_merge($result, $value);
            }
            
            $results['allcategories'] = $result;
        }
        return $results;
    }

    
    
}
?>