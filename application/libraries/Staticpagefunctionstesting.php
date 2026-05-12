<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors',0);
class Staticpagefunctionstesting
{
    function __construct() 
    {
    $this->CI =& get_instance();
    $this->CI->load->database();
    }
    
    public function getSitemap($parameters)
    {
        
      $condition1=array('ulbid'=>$parameters['ulbid'],'flag'=>1);
         $this->CI->db->select('*');
         $this->CI->db->from('menu_type_mst');
         $this->CI->db->where($condition1);
         $result['menu_type']=$this->CI->db->get()->result_array();
         
        $content="<div class='container'>";
        $content.="<div class='row'>";
        
        foreach($result['menu_type'] as $key=>$val_menu){
            $data1=array();
            //print_r($result['menu_type']);
        
         
       /* Main Site Menu*/
       
         $condition=array('c.ulbid'=>$parameters['ulbid'],'c.langId'=>$parameters['langId'],'s.menu_type_id'=>$val_menu['menu_type_id']);
         
         //print_r($condition);
        
        $select_array=array('s.page_id','s.menu_id','s.menu_type_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
        $this->CI->db->select($select_array);
        $this->CI->db->from('site_main_menu s');
        $this->CI->db->join('custom_menus c','s.page_id=c.page_id');
        $this->CI->db->where($condition);
        $this->CI->db->order_by('menu_id','ASC');
       //echo $this->CI->db->last_query();
        $result['main_menus']=$this->CI->db->get()->result_array();
        
        
       
        
        //Sub menus
        
        $select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','s.menu_type_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
        $this->CI->db->select($select_array);
        $this->CI->db->from('site_sub_menus s');
        $this->CI->db->join('custom_menus c','s.page_id=c.page_id');
        $this->CI->db->where('c.ulbid',$parameters['ulbid']);
        $this->CI->db->order_by('sub_menu_id','ASC');
        $result['sub_menus']=$this->CI->db->get()->result_array();
        
        // sub sub menus
        
        $select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','s.sub_sub_menu_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
        $this->CI->db->select($select_array);
        $this->CI->db->from('site_sub_sub_menus s');
        $this->CI->db->join('custom_menus c','s.page_id=c.page_id');
        $this->CI->db->where('c.ulbid',$parameters['ulbid']);
        $this->CI->db->order_by('sub_sub_menu_id','ASC');
        $result['sub_sub_menus']=$this->CI->db->get()->result_array();
        
        
        
        
        // MENUS STOTING INTO ARRAYS
        
         $pages['mainmenu']=array();
         $pages['submenu']=array();
         $pages['chilemenu']=array();
	    
	    foreach($result['sub_menus'] as $key=>$submenuarray)
	    {
	        
	      
	        
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['page_name']=$submenuarray['page_name'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['controller']=$submenuarray['controller'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_custumlink']=$submenuarray['is_custumlink'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_target_blank']=$submenuarray['is_target_blank'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_alert']=$submenuarray['is_alert'];
	        
	        
	    }
	    
	    
	    
	    
	    
	    foreach($result['sub_sub_menus'] as $key=>$submenuarray)
	    {
	       
	        
	        
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['page_name']=$submenuarray['page_name'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['controller']=$submenuarray['controller'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_custumlink']=$submenuarray['is_custumlink'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_target_blank']=$submenuarray['is_target_blank'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_alert']=$submenuarray['is_alert'];
	        
	    }
	    
	    array_push($pages['chilemenu'],$data3);
	    
	    foreach($result['main_menus'] as $key=>$mainmenuarray)
	    {
	        
	       
	        
	        $data1[$mainmenuarray['menu_id']]['page_name']=$mainmenuarray['page_name'];
	        $data1[$mainmenuarray['menu_id']]['controller']=$mainmenuarray['controller'];
	        $data1[$mainmenuarray['menu_id']]['is_custumlink']=$mainmenuarray['is_custumlink'];
	        $data1[$mainmenuarray['menu_id']]['is_target_blank']=$mainmenuarray['is_target_blank'];
	        $data1[$mainmenuarray['menu_id']]['site_controller']=$mainmenuarray['site_controller'];
	        $data1[$mainmenuarray['menu_id']]['is_alert']=$mainmenuarray['is_alert'];
	        $data1[$mainmenuarray['menu_id']]['child']=array();
	        
	        
	        
	   }
	   //print_r($data1);
	   /* End Main Site Menu*/
	   
	    $base_url1=base_url();
        
       
       $content.="<div class='col-md-3'>";
       if($val_menu['menu_type_id']=='1'){
       $content.="<div><a href='".$base_url1.$parameters['ulbid']."/home-page' target='_blank'><h6>Main Navigation</h6></a></div>";
       } else {
          $content.="<div><h6>".$val_menu['menu_type_sitemap_desc']."</h6></div>"; 
       }
       
       $content.="<div id='test' class='tree'>";
      
       $content.="<ul>";
        if($val_menu['menu_type_id']=='1'){
            
       $content.="<li class='parent_li'><a href='".$base_url1.$parameters['ulbid']."/home-page' target='_blank'><span title='Home'>Main Navigation</span></a>";
        }
        
       $content.="<ul>";
       
      
       
    foreach($data1 as $menuid=>$mainmenudetails) {
           
          if($mainmenudetails['is_custumlink']==1)
        {
            $base_url='';
        }
        else
        {
            $base_url=base_url();
        }
        if($mainmenudetails['is_target_blank']==0 || $mainmenudetails['is_target_blank']==1)
        {
            $target='';
        }
        else
        {
            $target="target='_blank'";
        }
        if($mainmenudetails['is_alert']==1)
                    {
                        $alertClass="confirmation";
                        $target="target='_blank'";
                        
                    }
                    else
                    {
                        $alertClass="";
                    }
        
        if(count($data2[$menuid]) > 0)
        {
        $content.="<li class='parent_li'><a href='".$base_url.$mainmenudetails['site_controller']."' ".$target." class='myclass ".$alertClass."'><span class='site_color' title='About Municipality'>".$mainmenudetails['page_name']."</span></a>";
        } else {
            
        $content.="<li class='parent_li'><a href='".$base_url.$mainmenudetails['site_controller']."' ".$target." class='myclass ".$alertClass."'><span class='site_color' title='About Municipality'>".$mainmenudetails['page_name']."</span></a>";
        }
        $content.="<ul>";
           
    foreach($data2[$menuid] as $submenuid=>$submenudetails){
        
         if($submenudetails['is_custumlink']==1)
            {
                $base_url='';
            }
            else
            {
                $base_url=base_url();
            }
            
             
           if($submenudetails['is_target_blank']==1)
                {
                    $target='';
                }
                else
                {
                    $target="target='_blank'";
                }
                if($submenudetails['is_alert']==1)
                    {
                        $alertClass="confirmation";
                        $target="target='_blank'";
                        
                    }
                    else
                    {
                        $alertClass="";
                    }
        
        $content.="<li class='parent_li'><a href='".$base_url.$submenudetails['site_controller']."' ".$target." class='".$alertClass."'><span title='Basic Information of Municipality'>".$submenudetails['page_name']."</span></a>";
        
        $content.="<ul>";
                
    foreach($data3[$menuid][$submenuid] as $subsubmenuid=>$subsubmenudetails) {
        
         if($subsubmenudetails['is_custumlink']==1)
                    {
                        $base_url='';
                    }
                    else
                    {
                        $base_url=base_url();
                    }
                    
                    if($subsubmenudetails['is_target_blank']==0 || $subsubmenudetails['is_target_blank']==1)
                    {
                        $target='';
                    }
                    else
                    {
                        $target="target='_blank'";
                    }
                    if($subsubmenudetails['is_alert']==1)
                    {
                        $alertClass="confirmation";
                        $target="target='_blank'";
                        
                    }
                    else
                    {
                        $alertClass="";
                    }
                   
        $content.="<li class='parent_li'><a href='".$base_url.$subsubmenudetails['site_controller']."' ".$target." class='".$alertClass."'><span title='Last two years trade licenses'>".$subsubmenudetails['page_name']."</span></a></li>";
                   
        }
                
        $content.="</ul>";
        
        $content.="</li>";      
        }
           
        $content.="</ul>";
        $content.="</li>";
        }
     
     
       
        $content.="</ul>";
        $content.="</li>";
        $content.="</ul>";
        $content.="</div>";
            
        $content.="</div>";
            }
        $content.="</div>";
        $content.="</div>";
    
      return $content;
     
       
    }

 
    
    public function getMenus($params)
    {
        // Main menus 
        $condition=array('c.ulbid'=>$params['ulbid'],'c.langId'=>$params['langId'],'s.menu_type_id'=>$params['menu_type_id']);
        
        $select_array=array('s.page_id','s.menu_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller');
        $this->CI->db->select($select_array);
        $this->CI->db->from('site_main_menu s');
        $this->CI->db->join('custom_menus c','s.page_id=c.page_id');
        $this->CI->db->where($condition);
        $this->CI->db->order_by('menu_id','ASC');
        $result['main_menus']=$this->CI->db->get()->result_array();
        
        //echo $this->CI->db->last_query();
        
        //Sub menus
        
        $select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller');
        $this->CI->db->select($select_array);
        $this->CI->db->from('site_sub_menus s');
        $this->CI->db->join('custom_menus c','s.page_id=c.page_id');
        $this->CI->db->where('c.ulbid',$params['ulbid']);
        $this->CI->db->order_by('sub_menu_id','ASC');
        $result['sub_menus']=$this->CI->db->get()->result_array();
        
        // sub sub menus
        
        $select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','s.sub_sub_menu_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller');
        $this->CI->db->select($select_array);
        $this->CI->db->from('site_sub_sub_menus s');
        $this->CI->db->join('custom_menus c','s.page_id=c.page_id');
        $this->CI->db->where('c.ulbid',$params['ulbid']);
        $this->CI->db->order_by('sub_menu_id','ASC');
        $result['sub_sub_menus']=$this->CI->db->get()->result_array();
        
        
        // MENUS STOTING INTO ARRAYS
        
         $pages['mainmenu']=array();
         $pages['submenu']=array();
         $pages['chilemenu']=array();
	    
	    foreach($result['sub_menus'] as $key=>$submenuarray)
	    {
	        
	      
	        
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['page_name']=$submenuarray['page_name'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['controller']=$submenuarray['controller'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_custumlink']=$submenuarray['is_custumlink'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_target_blank']=$submenuarray['is_target_blank'];
	        $data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
	        
	        
	    }
	    
	    array_push($pages['submenu'],$data2);
	    
	    
	    
	    foreach($result['sub_sub_menus'] as $key=>$submenuarray)
	    {
	       
	        
	        
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['page_name']=$submenuarray['page_name'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['controller']=$submenuarray['controller'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_custumlink']=$submenuarray['is_custumlink'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_target_blank']=$submenuarray['is_target_blank'];
	        $data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
	        
	    }
	    
	    array_push($pages['chilemenu'],$data3);
	    
	    foreach($result['main_menus'] as $key=>$mainmenuarray)
	    {
	        
	       
	        
	        $data1[$mainmenuarray['menu_id']]['page_name']=$mainmenuarray['page_name'];
	        $data1[$mainmenuarray['menu_id']]['controller']=$mainmenuarray['controller'];
	        $data1[$mainmenuarray['menu_id']]['is_custumlink']=$mainmenuarray['is_custumlink'];
	        $data1[$mainmenuarray['menu_id']]['is_target_blank']=$mainmenuarray['is_target_blank'];
	        $data1[$mainmenuarray['menu_id']]['site_controller']=$mainmenuarray['site_controller'];
	        $data1[$mainmenuarray['menu_id']]['child']=array();
	        
	        
	        
	   }
        
        array_push($pages['mainmenu'],$data1);
        return $pages;
        
    }
}
?>