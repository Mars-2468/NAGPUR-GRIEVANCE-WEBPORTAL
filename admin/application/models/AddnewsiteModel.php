<?php
ini_set('display_errors',0);
defined('BASEPATH') OR  die('direct scripts are not allowed');

class AddnewsiteModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
        //$this->csmsdb=$this->load->database('csmsdb',true);
    }
    
    public function getDistricts()
    {
        $select_array=array('distid','distname');
        $this->db->select($select_array);
        $this->db->order_by('distname','ASC');
        $result=$this->db->get('Districtmst');
        return $result;
    }
    
    
    public function editPagePermissions($check_list,$user_id)
    {
        $condition=array('user_id'=>$user_id);
        $this->db->where($condition);
        $this->db->delete('users_services');
        
       
            foreach($check_list as $val)
            {
                
                $arr=explode("_",$val);
                $array=array(
                    'user_id'=>$user_id,
                    'main_menu_id'=>$arr[0],
                    'sub_menu_id'=>$arr[1],
                    'status'=>1
                    );
                    $this->db->insert('users_services',$array);
                    
            }
            
            return 1;
        
    }
    
     public function getallsubmenus()
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $result=$this->db->get('sub_menu');
        return $result;
        
    }
    
    
    public function getallmainmenus()
    {
        $condition=array('menu_level'=>'U');
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($condition);
        $result=$this->db->get('main_menu');
        return $result;
        
    }
    
    public function getexistedsiteAdminlist()
    {
        $select_array=array('user_id','ulbid');
        $result=$this->db->get('users');
        return $result;
        
    }
    
    public function getexistedsitelist()
    {
        
        $select_array=array('ur.ulbid','u.ulbname','u.site_name','u.base_url');
        $this->db->select($select_array);
        $this->db->from('users ur');
        $this->db->join('ulbmst u','ur.ulbid=u.ulbid','inner');
        $this->db->where('theme_id > 0');
        $this->db->group_by('ur.ulbid');
        $result=$this->db->get();
        
        return $result;
        
    }
   
    public function getulblist()
    {
         $select_array=array('ulbid','ulbname');
         $this->db->select($select_array);
         $result=$this->db->get('ulbmst');
         return $result;
    }
    
     public function themelist()
    {
         $select_array=array('theme_id','theme_description');
         $this->db->select($select_array);
         $this->db->group_by('theme_id');
         $result=$this->db->get('themes_mst');
        
         return $result;
    }
    
    public function themeLayouts($thmeid)
    {
        $condition=array('theme_id'=>$thmeid);
        $select_array=array('page_layout_id','page_layout_desc','source');
         $this->db->select($select_array);
         $this->db->where($condition);
         $result=$this->db->get('themes_mst');
         
         return $result;
    }
    
    public function insertcustomlayouts($themelayouts)
    {
      $this->db->insert('custom_page_layouts',$themelayouts);  
      
    }
    
    public function configureSite($params,$userdetails)
    {
        // adding site details 
        //print_r($userdetails);
        $query="insert into ulbmst (
        distid,
        ulbname,
        theme_id,
        ulbid,
        base_url,
        concerned_person,
        designation,
        mobile,
        tech_concerned_person_name,
        tech_concerned_person_designation,
        tech_concerned_person_mobile,
        tech_concerned_person_email,
        keywords,
        description,
        subject
        ) values (
        '".$params['distid']."',
        '".$params['ulbname']."',
        '".$params['theme_id']."',
        '".$params['ulbid']."',
        '".$params['base_url']."',
        '".$params['concerned_person']."',
        '".$params['designation']."',
        '".$params['mobile']."',
        '".$params['tech_concerned_person_name']."',
        '".$params['tech_concerned_person_designation']."',
        '".$params['tech_concerned_person_mobile']."',
        '".$params['tech_concerned_person_email']."',
        '".$params['keywords']."',
        '".$params['description']."',
        '".$params['subject']."'
            
                ) ON DUPLICATE KEY UPDATE 
                distid='".$params['distid']."',
                ulbname='".$params['ulbname']."',
                theme_id='".$params['theme_id']."',
                base_url='".$params['base_url']."',
                concerned_person='".$params['concerned_person']."',
                designation='".$params['designation']."',
                mobile='".$params['mobile']."',
                tech_concerned_person_name='".$params['tech_concerned_person_name']."',
                tech_concerned_person_designation='".$params['tech_concerned_person_designation']."',
                tech_concerned_person_mobile='".$params['tech_concerned_person_mobile']."',
                tech_concerned_person_email='".$params['tech_concerned_person_email']."',
                keywords='".$params['keywords']."',
                description='".$params['description']."',
                subject='".$params['subject']."'
                ";
       
        if($this->db->query($query))
        {
            
            // adding user details
            $query="insert into users (
                user_id,
                user_pwd,
                show_pwd,
                user_category,
                user_type,
                user_name,
                author,
                is_custom_user,
                user_mobile,
                user_email,
                ulbid,
                flag
                ) 
                values(
                    '".$userdetails['user_id']."',
                    PASSWORD('".$userdetails['password']."'),
                    '".$userdetails['password']."',
                    '2',
                    'U',
                    '".$params['tech_concerned_person_name']."',
                    '".$userdetails['author']."',
                    'No',
                    '".$params['tech_concerned_person_mobile']."',
                    '".$params['tech_concerned_person_email']."',
                    '".$params['ulbid']."',
                    '1'
                    )";
            if($this->db->query($query))
            {
                $select_array=array('*');
                $result = $this->db->get('page_layouts');
                foreach($result->result() as $key=>$val)
                {
                    // adding sections
                    
                    
                    $fields=array(
                        'page_layout_id'=>$val->page_layout_id,
                        'theme_layout_id'=>$val->theme_layout_id,
                        'page_layout_desc'=>$val->page_layout_desc,
                        'sort_order'=>$val->sort_order,
                        'ulbid'=>$params['ulbid'],
                        'author'=>$userdetails['author'],
                        'flag'=>1,
                        'source'=>$val->source,
                        'is_in_loop_section'=>$val->is_in_loop_section
                        );
                        // print_r($fields);
                        // exit;
                        $this->db->insert('custom_page_layouts',$fields);
                }
                        
                       
                            
                            // adding pages
                            
                             $select_array=array(
                                'page_id as standard_page_id'=>$page_details->standard_page_id,
                                'langId'=>$page_details->langId,
                                'page_sidebars_id'=>$page_details->page_sidebars_id,
                                'page_title'=>$page_details->page_title,
                                'page_name'=>$page_details->page_name,
                                'site_controller'=>$site_controller,
                                'pageheading'=>$page_details->pageheading,
                                'pagekeywords'=>'',
                                'meta_desc'=>'',
                                'is_draft'=>$page_details->is_draft,
                                'is_custumlink'=>$page_details->is_custumlink,
                                'is_target_blank'=>$page_details->is_target_blank,
                                'is_alert'=>$page_details->is_alert,
                                'is_homepage_content'=>$page_details->is_homepage_content,
                                'permalink'=>$link,
                                'fromDate'=>'',
                                'datetime'=>$page_details->datetime,
                                'author'=>$userdetails['author'],
                                'is_common_page'=>$page_details->is_common_page,
                                'is_code_page'=>$page_details->is_code_page,
                                'funcname'=>$page_details->funcname,
                                'user_level'=>$page_details->user_level,
                                'hover_title'=>$page_details->hover_title,
                          
                                'meta_subject'=>'',
                                'controller'=>$page_details->controller,
                                'content'=>$page_details->content
                                );
                                $condition=array('ulbid'=>'056');
                           // $this->db->select($select_array);
                                $this->db->select('*');
                               // $this->db->where($condition);
                                $result=$this->db->get('standard_custom_menus');
                                
                                
                                if($result)
                                {
                                    foreach($result->result() as $key2=>$page_details)
                                    {
                                        
                                        $page_details->site_controller;
                                        $arr=explode('/',$page_details->site_controller);
                                        if($page_details->is_custumlink !='1')
                                        {
                                        $site_controller=$params['ulbid']."/".$arr[1];
                                        }
                                        else
                                        {
                                            $site_controller=$page_details->site_controller;
                                        }
                                        $permalink=$params['base_url'].$params['ulbid']."/About-Municipality";
                                        $perm=explode('/',$page_details->permalink);
                                        $link=$perm[0]."//".$perm[2]."/".$perm[3]."/".$params['ulbid']."/".$perm[5];
                                        
                                        
                                        $params_array=array(
                                            
                                            'langId'=>$page_details->langId,
                                            'page_sidebars_id'=>$page_details->page_sidebars_id,
                                            'page_title'=>$page_details->page_title,
                                            'page_name'=>$page_details->page_name,
                                            'ulbid'=>$params['ulbid'],
                                            'controller'=>$page_details->controller,
                                            'site_controller'=>$site_controller,
                                            'pageheading'=>$page_details->pageheading,
                                            'pagekeywords'=>'',
                                            'meta_desc'=>'',
                                            'is_draft'=>$page_details->is_draft,
                                            'is_custumlink'=>$page_details->is_custumlink,
                                            'is_target_blank'=>$page_details->is_target_blank,
                                            'is_alert'=>$page_details->is_alert,
                                            'is_homepage_content'=>$page_details->is_homepage_content,
                                            'permalink'=>$link,
                                            'author'=>$userdetails['author'],
                                            'is_common_page'=>$page_details->is_common_page,
                                            'is_code_page'=>$page_details->is_code_page,
                                            'funcname'=>$page_details->funcname,
                                            'user_level'=>$page_details->user_level,
                                            'hover_title'=>$page_details->hover_title,
                                            'datetime'=>$page_details->datetime,
                                             'standard_page_id'=>$page_details->page_id
                                            );
                                            
                                            if($page_details->is_common_page=='1')
                                            {
                                                $params_array['content']=$page_details->content;
                                            }
                                            
                                            if($this->db->insert('custom_menus',$params_array))
                                            {
                                               
                                            }
                                    }
                              
                              
                              
                                
                        
                        }
                        
                }
                
                  // adding menu types
                          
                          $select_array=array('*');
                          $this->db->select($select_array);
                          $result=$this->db->get('standard_menu_types');
                          foreach($result->result() as $key=>$val)
                          {
                              $parameters=array(
                                  'menu_type_id'=>$val->menu_type_id,
                                  'menu_type_desc'=>$val->menu_type_desc,
                                  'ulbid'=>$params['ulbid'],
                                  'flag'=>1,
                                  'menu_type_sitemap_desc'=>$val->menu_type_sitemap_desc
                                  );
                                  $this->db->insert('menu_type_mst',$parameters);
                          }
                   // adding standard widgets
                
                $select_array=array('w.widget_id','w.widget_name','w.widget_type','w.flag','w.langId','t.*');
                $this->db->select($select_array);
                $this->db->from('standard_widget_mst w');;
                $this->db->join('widget_tables t','w.widget_type=t.widget_type');
                $result=$this->db->get();
				//echo $this->db->last_query();
                foreach($result->result() as $key=>$val)
                {
					$widget_mst_insert=array(
					
					'widget_name'=>$val->widget_name,
					'author'=>$this->session->userdata('userid'),
					'widget_type'=>$val->widget_type,
					'flag'=>$val->flag,
					'langId'=>$val->langId,
					'user_level'=>'A',
					'widget_admin_code'=>$val->widget_id,
					'ulbid'=>$parameters['ulbid']
					);
                    $this->db->insert('widget_mst',$widget_mst_insert);
					$insertid=$this->db->insert_id();
					
				
                    // getting all field from the table
                    $condition=array('widget_id'=>$val->widget_id);
                    $this->db->select($val->select_fields);
                    $this->db->where($condition);
                    $result=$this->db->get($val->table_name);
                    //echo $this->db->last_query();
                    //print_r($result->result_array());
                    //echo "<br >";
                    foreach($result->result_array() as $row)
                    {
                        $fieldsarray=array();
                        foreach($row as $key=>$val2)
						{
							
							$fieldsarray[$key]=$val2;
							
						}
						unset($fieldsarray['widget_id']);
						$fieldsarray['widget_id']=$insertid;
						
						$this->db->insert($val->table_name,$fieldsarray);
						
                    }
                
				 
		}
                
                // adding to widget_layout_map
                
                      $condition=array('langId'=>1);
                    $select_array=array('widget_id','page_layout_id','langId','menu_name','flag');
                    $this->db->select($select_array);
                    $this->db->where($condition);
                    $result=$this->db->get('standard_layout_widget_map');
                    
                    foreach($result->result_array() as $row)
                    {
						
						$condition=array('widget_admin_code'=>$row['widget_id'],'ulbid'=>$parameters['ulbid']);
						$this->db->select('widget_id');
						$this->db->where($condition);
						$widgetdet=$this->db->get('widget_mst')->row_array();
						
						if($widgetdet['widget_id'] !='')
						{
						     
						
    						$widget_layout_array=array(
    						
    						'widget_id'=>$widgetdet['widget_id'],
    						'page_layout_id'=>$row['page_layout_id'],
    						'langId'=>$row['langId'],
    						'menu_name'=>$row['menu_name'],
    						'flag'=>$row['flag'],
    						'ulbid'=>$parameters['ulbid'],
    						'author'=>$this->session->userdata('userid')
    						);
    						$this->db->insert('layout_widget_map',$widget_layout_array);
    						
						}
						
                    }
                    
                    // adding slider 
                  /*  $select=array('u.ulbname','ut.ulb_type_desc');
                    $this->db->select($select);
                    $this->db->from('ulbmst u');
                    $this->db->join('ulb_type ut','u.u');
                    $this->db->where('');
                    
                    $ulbtype=$this-
                    
                    $sliderparams=array(
                        
                        'langId'=>'1',
                        'page_sidebars_id'=>1,
                        'page_title'=>
                        
                        );*/
						
						
						
						
						
						
						
						
						
						
					// adding main menus and left menus	
					
					
					$select_array=array('menu_type_id','page_id','langId','menu_name','flag');
					$condition=array('ulbid'=>'056','langId'=>'1');
					$this->db->select($select_array);
					$this->db->where($condition);
					$result=$this->db->get('site_main_menu');
					//echo '<br>';
					//print_r($result);
					
					foreach($result->result_array() as $key=>$value)
					{
					    $this->db->select('page_id');
					    $condition=array('standard_page_id'=>$value['page_id'],'ulbid'=>$parameters['ulbid']);
					    $this->db->where($condition);
					    $rowarray=$this->db->get('custom_menus')->row_array();
					    if($rowarray['page_id'] !='')
						{
    					   $mainmenuparams=array(
    					       'menu_type_id'=>$value['menu_type_id'],
    					       'ulbid'=>$parameters['ulbid'],
    					       'page_id'=>$rowarray['page_id'],
    					       'langId'=>$value['langId'],
    					       'menu_name'=>$value['menu_name'],
    					       'author'=>$this->session->userdata('userid'),
    					       'flag'=>1
    					       );
    					       $this->db->insert('site_main_menu',$mainmenuparams);
						}
					}
					
						
						
                    /*$condition=array('langId'=>1,'ulbid'=>$params['ulbid']);
                    $select_array=array('page_id','page_name');
                    $this->db->select($select_array);
                    $this->db->where($condition);
					$this->db->limit(1,0);
                    $ulbpage=$this->db->get('custom_menus')->row_array();
                    $page_id=$ulbpage['page_id'];
                    $page_name=$ulbpage['page_name'];
                    $mainmenuparams=array(
                        'menu_type_id'=>1,
                        'ulbid'=>$params['ulbid'],
                        'page_id'=>$page_id,
                        'langId'=>'1',
                        'menu_name'=>$page_name,
                        'author'=>$this->session->userdata('userid'),
                        'flag'=>1
                        );
                        $this->db->insert('site_main_menu',$mainmenuparams);
                        
                        $leftmenuparams=array(
                        'menu_type_id'=>2,
                        'ulbid'=>$params['ulbid'],
                        'page_id'=>$page_id,
                        'langId'=>'1',
                        'menu_name'=>$page_name,
                        'author'=>$this->session->userdata('userid'),
                        'flag'=>1
                        );
                       $this->db->insert('site_main_menu',$leftmenuparams);
                    
                    /// adding main menus
                    
                   /* $select_array=array('menu_type_id','page_id','langId','menu_name','flag');
                    $condition=array('ulbid'=>'056','langId'=>1);
                    $this->db->select($select_array);
                    $this->db->where($condition);
                    $result=$this->db->get('site_main_menu');
                    foreach($result->result_array() as $row)
                    {
                        $fieldsarray=array();
                        foreach($row as $key=>$val2)
						{
							
							$fieldsarray[$key]=$val2;
							
						}
						$fieldsarray['ulbid']=$params['ulbid'];
						$fieldsarray['flag']=1;
						$fieldsarray['author']=$this->session->userdata('userid');
						$this->db->insert('site_main_menu',$fieldsarray);
						
                    }
                    
                // adding submenus
                
                  /*  $select_array=array('menu_type_id','main_menu_id','page_id','langId','flag','sub_menu_desc','sub_menu_id');
                    $condition=array('ulbid'=>'056','langId'=>1);
                    $this->db->select($select_array);
                    $this->db->where($condition);
                    $result=$this->db->get('site_sub_menus');
                    foreach($result->result_array() as $row)
                    {
                        $fieldsarray=array();
                        foreach($row as $key=>$val2)
						{
							
							$fieldsarray[$key]=$val2;
							
						}
						$fieldsarray['ulbid']=$params['ulbid'];
						$fieldsarray['flag']=1;
						//$fieldsarray['author']=$this->session->userdata('userid');
						$this->db->insert('site_sub_menus',$fieldsarray);
						
                    }*/
                    // adding submenus in submenus
                    
                   /* $select_array=array('menu_type_id','main_menu_id','sub_menu_id','page_id','langId','subsubdesc','sub_sub_menu_id');
                    $condition=array('ulbid'=>'056','langId'=>1);
                    $this->db->select($select_array);
                    $this->db->where($condition);
                    $result=$this->db->get('site_sub_sub_menus');
                    foreach($result->result_array() as $row)
                    {
                        $fieldsarray=array();
                        foreach($row as $key=>$val2)
						{
							
							$fieldsarray[$key]=$val2;
							
						}
						$fieldsarray['ulbid']=$params['ulbid'];
						$fieldsarray['flag']=1;
						//$fieldsarray['author']=$this->session->userdata('userid');
						$this->db->insert('site_sub_sub_menus',$fieldsarray);
						
                    }*/
                
                
                
                
                
            }
        }
        
        
            
      public function edit_site($ulbid){
          
           $condition=array('ulbid'=>$ulbid);
           $select_array=array('*');
           $this->db->select($select_array);
           $this->db->where($condition);
           $result=$this->db->get('ulbmst');
          //echo $this->db->last_query();
          return $result;
         
        }
           
      public function update_site_configure($params,$ulb){
         
         $this->db->set($params);
         $this->db->where('ulbid', $ulb);
         $result=$this->db->update('ulbmst');
         //echo $this->db->last_query();
        // exit;
         return $result;
      }
   
}
?>