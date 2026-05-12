<?php
defined('BASEPATH') or die('direct scripts are not allowed');
class MenuModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        
    }

    public function updateVisitCountDB($vcountinc){

        $params = array('id' => 1);
        $set = array('count'=>$vcountinc);

        $this->db->set($set);
        $this->db->where($params);
        $this->db->update('visitor_count_view');
        //echo $this->db->last_query();
    }


    public function getVisitCountDB(){

        $this->db->select('*');
        $query = $this->db->get('visitor_count');
		//$query->->result_array();
//echo "<pre>";print_r($query->num_rows());echo "</pre>";die();

     
       
        return $query->num_rows();

    }
    
    /** visitors ***/
    
    public function all_by_array($table, $array)
    {
        $this->db->select('*');
        $this->db->where($array);
        $query = $this->db->get($table);
        // echo $this->db->last_query();
        // exit;
        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function insertPetetionForm($params)
    {
        $db2 = $this->load->database('database2', TRUE);
        $result = $db2->insert('petition_det',$params);
        $insertid = $db2->insert_id();
        
        $db2->select_max('refno');
        $db2->where('site_id',$params['site_id']);
        $db2->from('petition_det');
        $val = $db2->get()->result_array();;
       
        $newrefno = $val[0]['refno']+1;
        $set = array('refno' =>$newrefno);
        $condition = array('petitiondet_id' =>$insertid);
        $db2->where($condition)->update('petition_det',$set);
       
        return $result;
    }
    
    public function getSubcast($params)
    {
         $db2 = $this->load->database('database2', TRUE);
        
        $db2->select('*');
        $db2->where($params);
        $q = $db2->get('subcast_mst');
        return $villages = $q->result_array();
    }
    
    public function insertDonationForm($params)
    {
        $db2 = $this->load->database('database2', TRUE);
        $result = $db2->insert('blood_donations',$params);
        return $result;
    }
    	public function getMandals($params)
	{
	    
	    
	    $db2 = $this->load->database('database2', TRUE);
        
        $db2->select('*');
        $db2->where($params);
        $q = $db2->get('mandal_mst');
        return $villages = $q->result_array();
	}
	public function getVillages($params)
	{
	    
	    
	    $db2 = $this->load->database('database2', TRUE);
        
        $db2->select('*');
        $db2->where($params);
        $q = $db2->get('village_mst');
        return $villages = $q->result_array();
	}
	public function insertVisitor($params)
	{
		 $sql ="insert into visitor_count (
		ip_address,
		url,
		ts,
		date
		) values (
		'".$params['ip_address']."',
		'".$params['url']."',
		'".$params['ts']."',
		'".$params['date']."'
		) ON DUPLICATE KEY UPDATE 
		
		ip_address='".$params['ip_address']."',
		url='".$params['url']."',
		ts='".$params['ts']."',
		date='".$params['date']."'";
		$this->db->query($sql);
		
	}
	
	public function getVisitorCount()
	{
		$condition=array('date'=>date('Y-m-d'));
		$this->db->select('ip_address');
		$this->db->where($condition);
		$this->db->group_by('ip_address');
		$result=$this->db->get('visitor_count');
		$today_count=0;
		foreach($result->result_array() as $key=>$val)
		{
			$today_count++;
		}
		
		$sql ="SELECT ip_address FROM visitor_count WHERE MONTH(date) = MONTH(CURRENT_DATE()) group by ip_address";
		$result=$this->db->query($sql);
		$month_count=0;
		foreach($result->result_array() as $key=>$val)
		{
			$month_count++;
		}
		
		$sql ="SELECT ip_address,start_from FROM visitor_count group by ip_address,date";
		$result=$this->db->query($sql);
		$all_count=0;
		$start = 0;
		foreach($result->result_array() as $key=>$val)
		{
			$all_count++;
			$start += $val['start_from'];
		}
		$all_count += $start;
		
		
			
		/*	$sql ="
		SELECT MAX(ts) AS MaxDate FROM custom_menus
		UNION
		SELECT MAX(ts) AS MaxDate FROM widget_mst";
		$result=$this->db->query($sql);
		$max_dates=array();

		foreach($result->result_array() as $key=>$val)
			{
				$max_dates[]=$val['MaxDate'];
			}
			
			$maxdate = max(array_map('strtotime', $max_dates));
			
			$items = (string)$all_count;
			$len = strlen($items);
			$str = '';
			$ll = 9-$len;
			for($j=0; $j<$ll; $j++){
				$str .= "0 ";
			}
			for($i=0; $i<$len; $i++){
				$str .= $items[$i]." ";
			}
			
			
		/*	$content='Today - '.$today_count.' </a></li>
		 This Month - '.$month_count.' </a></li>
		All Days - '.$all_count.' </a></li>';*/



		return $all_count;
			
		
	
	}
    
     public function checkUlbid($params)
        {
            $select_array=array('ulbid');
            $result = $this->db->select($select_array)->where($params)->get('ulbid')->row_array();
            return $result;
        }
    
    /** Townprofile data **/
    public function getTownProfiledata($params)
    {
        $select_array=array('weblink','fbink','twitlink','mobile_social','social_email','app_link','citizenbuddy_app');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('townprofile')->result_array();
        return $result;
    }
    
    /** close **/
    
    /** slider posts **/
/*     public function getSliderPosts2025_03_22($params)
    {
        $select_array=array('s.thumbnail_path','s.alttext','s.sliderLinkText','c.*');
        $condition=array('c.ulbid'=>$params['ulbid'],'c.langId'=>$params['langId']);
        $this->db->select($select_array);
        $this->db->from('slider_mst2 s');
        $this->db->join('custom_menus c','s.page_id=c.page_id');
        $this->db->where($condition);
        $result=$this->db->get();
      
        return $result;
    } */
	
	public function getSliderPosts($params)
    {
        $select_array=array('s.thumbnail_path','s.alttext','s.sliderLinkText','c.*');
        $condition=array('c.ulbid'=>$params['ulbid'],'s.visibility'=>1);
        $this->db->select($select_array);
        $this->db->from('slider_mst2 s');
        $this->db->join('custom_menus c','s.page_id=c.page_id');
        $this->db->where($condition);
        $result=$this->db->get();
      
        return $result;
    }
    
    /** close **/
    /** ulb albums **/
    public function getulbalbums($params)
    {
        /*$select_array=array('a.album_id','a.album_desc','a.ts','aim.image_path');
        $this->db->select($select_array);
        $this->db->from('album_mst a');
        $this->db->join('album_image_map aim','a.album_id=aim.album_id');
        $this->db->where($params);
        
        echo $this->db->last_query();
        return $result;*/
    }
     /** close **/
    
    /** general settings **/
    
    public function getULBgeneralsettings($params)
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('genneral_settings')->result_array();
        //echo $this->db->last_query();

        return $result;
        
    }
    /**/
    
    /**** library functions ***/
    
    
	
    public function widget_desc($params)
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('widget_mst')->row_array();
       
        return $result;
    }
    public function getMenuTypeId($params)
    {
      
       
       
        $select_array=array('menu_type_id','widget_name','widget_type_style');
        $this->db->select($select_array);
        $this->db->from('menuwidgets m');
        $this->db->join('widget_mst w','m.widget_id=w.widget_id');
        $this->db->where($params['widget_id']);
        $result=$this->db->get()->result_array();
        $this->db->last_query();
        return $result;
    }
    public function getWidgetData($params)
    {
        $select_array=array('widget_type');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('widget_mst')->result_array();
        return $result;
    }
    
    /*** close ***/
    
    public function getLayout_innerpage($params)
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($params);
        $this->db->order_by('page_layout_id','ASC');
        $result=$this->db->get('page_layouts');
        
        
        return $result;
    }
    
    public function getLayout($params)
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($params);
        $this->db->order_by('sort_order','ASC');
        $result=$this->db->get('custom_page_layouts');
        //echo $this->db->last_query();
        return $result;
    }
    public function getLayout_custom($params)
    {
        $where_in = array('9','10');
       // ECHO "hi"; exit;
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($params);
       
        $this->db->where_in('page_layout_id',$where_in);
        $this->db->order_by('sort_order','ASC');
        $result=$this->db->get('custom_page_layouts');
        //echo $this->db->last_query();
        return $result;
    }
    public function getthemefolder($params)
    {
        $select_array=array('u.*','l.folder');
        $this->db->select($select_array);
        $this->db->from('ulbmst u');
        $this->db->join('themes_mst l','u.theme_id=l.theme_id');
        $this->db->where($params);
        $this->db->group_by('l.theme_id');
        $result=$this->db->get()->result_array();
        
        return $result;
    }
    public function angularhomepagecontent($params)
    {
        $this->db->select('*');
        $this->db->where($params);
        $result=$this->db->get('custom_menus')->result_array();
        return $result;
    }
    public function anggetsliderdata($params)
    {
        $this->db->select('*');
        $this->db->where($params);
        $this->db->order_by('sort_order','ASC');
        $result=$this->db->get('slider_mst')->result_array();
        return $result;
    }
    public function getsliderdata($params)
    {
        $this->db->select('*');
        $this->db->where($params);
        $this->db->order_by('sort_order','ASC');
        $result=$this->db->get('slider_mst');
       
        return $result;
    }
    public function getHeaderNews($params)
    {
        $condition=array('c.ulbid'=>$params['ulbid'],'c.langId'=>$params['langId']);
        $select_array=array('c.*');
        $this->db->from('custom_menus c');
        $this->db->join('news_mst n','n.page_id=c.page_id');
        $this->db->where($condition);
        $this->db->order_by('sort_order','ASC');
        $result=$this->db->get()->result_array();
       
       return $result;
    }
    public function getpageInfo($params)
    {
       /* $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('custom_menus')->result();
        return $result;*/
        
        $select_array=array('c.*','s.*');
        $this->db->select($select_array);
        $this->db->from('custom_menus c');
        $this->db->join('site_main_menu s','c.page_id=s.page_id','inner');
        $this->db->where($params);
        $this->db->group_by('s.ulbid');
        $result=$this->db->get()->result();
       // echo $this->db->last_query();
        return $result;
        
    }
    
     public function getcustomPageInfo($params)
    {
        $select_array=array('meta_desc','pagekeywords','meta_subject');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('custom_menus')->result();
        //echo $this->db->last_query();
       return $result;
    }
    
    
    public function getULBInfo($params)
    {
        $select_array=array('ulbname','ulbtelugu','ulb_type_desc','ulb_type_desctelugu','logo','title','keywords','description','subject','base_url');
        $this->db->select($select_array);
        $this->db->from('ulbmst u');
        $this->db->join('ulb_type ut','u.ulb_type=ut.ulb_type_id');
        $result=$this->db->where('u.ulbid',$params['ulbid'])->get()->result();
        $this->db->last_query();
        //echo $this->db->last_query();
        return $result;
    }
    
    
      public function category_name($page_id)
    {
        $condition=array('pcm.page_id'=>$page_id);
        $select_array=array('pcm.category_id','c.page_name');
        $this->db->select($select_array);
        $this->db->from('post_category_map pcm');
        $this->db->join('custom_menus c','pcm.category_id=c.page_id');
        $this->db->where($condition);
        
        $result=$this->db->get()->row_array();
       
        return $result;
    }
    public function getMenus($params)
    {
        // Main menus 
        $condition=array('c.ulbid'=>$params['ulbid'],'c.langId'=>$params['langId'],'s.menu_type_id'=>$params['menu_type_id']);
        
        $select_array=array('s.page_id','s.menu_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
        $this->db->select($select_array);
        $this->db->from('site_main_menu s');
        $this->db->join('custom_menus c','s.page_id=c.page_id');
        $this->db->where($condition);
        $this->db->order_by('menu_id','ASC');
        $data['main_menus']=$this->db->get()->result_array();
        
        //Sub menus
        
        $select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
        $this->db->select($select_array);
        $this->db->from('site_sub_menus s');
        $this->db->join('custom_menus c','s.page_id=c.page_id');
        $this->db->where('c.ulbid',$params['ulbid']);
        $this->db->order_by('sub_menu_id','ASC');
        $data['sub_menus']=$this->db->get()->result_array();
        
        // sub sub menus
        
        $select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','s.sub_sub_menu_id','c.page_name','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
        $this->db->select($select_array);
        $this->db->from('site_sub_sub_menus s');
        $this->db->join('custom_menus c','s.page_id=c.page_id');
        $this->db->where('c.ulbid',$params['ulbid']);
        $this->db->order_by('sub_menu_id','ASC');
        $data['sub_sub_menus']=$this->db->get()->result_array();
        
        
        
        
        
        //$data['sub_menus']=$this->db->select($select_array)->where($params)->get('custom_menus')->result_array();
        return $data;
        
    }
    
    public function getPagename($params)
    {
        $select_array=array('page_name','page_id');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('custom_menus')->row_array();
        //echo $this->db->last_query();
        return $result;
    }
    
    public function getBreadcrumbsSubmenus($params)
    {
        $i=1;
        /*** page details from custome menus **/
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($params);
        $result= $this->db->get('custom_menus')->result_array();
       
         foreach($result as $key=>$val)
           {
               $links[$i]['page_name']=$val['page_name'];
               $links[$i]['site_controller']=$val['site_controller'];
               
               $links[$i]['is_custumlink']=$val['is_custumlink'];
               $links[$i]['is_target_blank']=$val['is_target_blank'];
               $links[$i]['is_alert']=$val['is_alert'];
               $i++;
           }
        
        
        /*** close ****/
        
        
        /*** found wether given id is  post or page ***/
        
        $select_array=array('is_custumlink','page_id');
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('custom_menus')->row_array();
        if($result['is_custumlink']=='2')
        {
            // if given id is post then finding the category id name of the post
            $select_array=array('category_id','page_id');
            $condition=array('page_id'=>$result['page_id']);
            $this->db->select($select_array);
            $this->db->from('post_category_map');
            $this->db->where($condition);
            $result=$this->db->get()->row_array();
            
            // finding page name of resulted category id
            $select_array=array('page_id','page_name','site_controller','is_custumlink','is_alert','is_custumlink');
            $condition=array('page_id'=>$result['category_id']);
            $this->db->select($select_array);
            $this->db->from('custom_menus');
            $this->db->where($condition);
            $result=$this->db->get()->row_array();
            
            
            
               $links[$i]['page_name']=$result['page_name'];
               $links[$i]['site_controller']=$params['ulbid']."/category-posts/".$result['site_controller'];
               $links[$i]['is_custumlink']=$result['is_custumlink'];
               $links[$i]['is_target_blank']=$result['is_target_blank'];
               $links[$i]['is_alert']=$result['is_alert'];
            
            
        }
        
        
        /** close **/
        
        
        
        
        
        
        /************* if page id found in child table ****/
        //$i=1;
       $select_array=array('main_menu_id','sub_menu_id','page_id');
       $this->db->select($select_array);
       $this->db->where($params);
       $result=$this->db->get('site_sub_sub_menus')->result_array();
       //echo $this->db->last_query();
       if(count($result) > 0)
       {
           
           
           $mainmenu_id=$result[0]['main_menu_id'];
           
           $condition=array('sub_menu_id'=>$result[0]['sub_menu_id'],'c.ulbid'=>$params['ulbid']);
           $select_array=array('c.page_name','c.site_controller','c.is_custumlink','c.is_alert','c.is_custumlink');
           $this->db->select($select_array);
           $this->db->from('custom_menus c');
           $this->db->join('site_sub_menus s','s.page_id=c.page_id');
           $this->db->where($condition);
           $result=$this->db->get()->result_array();
           
           
           foreach($result as $key=>$val)
           {
               $links[$i]['page_name']=$val['page_name'];
               $links[$i]['site_controller']=$val['site_controller'];
               $links[$i]['is_custumlink']=$val['is_custumlink'];
               $links[$i]['is_target_blank']=$val['is_target_blank'];
               $links[$i]['is_alert']=$val['is_alert'];
               
               $i++;
           }
           
           
           $select_array=array('c.page_name','c.site_controller','c.is_custumlink','c.is_alert','c.is_custumlink');
           $condition=array('menu_id'=>$mainmenu_id);
           $this->db->select($select_array);
           $this->db->from('custom_menus c');
           $this->db->join('site_main_menu s','s.page_id=c.page_id');
           $this->db->where($condition);
           $result=$this->db->get()->result_array();
           foreach($result as $key=>$val)
           {
               $links[$i]['page_name']=$val['page_name'];
               $links[$i]['site_controller']=$val['site_controller'];
               $links[$i]['is_custumlink']=$val['is_custumlink'];
               $links[$i]['is_target_blank']=$val['is_target_blank'];
               $links[$i]['is_alert']=$val['is_alert'];
               $i++;
           }
       }
           
    /**** if page id found in submenu table *****/
     $i=1;
        /*** page details from custome menus **/
        $select_array=array('page_id','page_name','site_controller','is_custumlink','is_alert','is_custumlink');
        $this->db->select($select_array);
        $this->db->where($params);
        $result= $this->db->get('custom_menus')->result_array();
       
         foreach($result as $key=>$val)
           {
               $links[$i]['page_name']=$val['page_name'];
               $links[$i]['site_controller']=$val['site_controller'];
               $links[$i]['is_custumlink']=$val['is_custumlink'];
               $links[$i]['is_target_blank']=$val['is_target_blank'];
               $links[$i]['is_alert']=$val['is_alert'];
               $i++;
           }
        
        
        /*** close ****/
    
       $select_array=array('main_menu_id','page_id');
       $this->db->select($select_array);
       $this->db->where($params);
       $result=$this->db->get('site_sub_menus')->result_array();
       
      // echo $this->db->last_query();
       
       if(count($result) > 0)
       {
           
           
           $mainmenu_id=$result[0]['main_menu_id'];
           
           $condition=array('menu_id'=>$result[0]['main_menu_id'],'s.ulbid'=>$params['ulbid']);
           $select_array=array('c.page_name','c.site_controller','c.is_custumlink','c.is_alert','c.is_custumlink');
           $this->db->select($select_array);
           $this->db->from('custom_menus c');
           $this->db->join('site_main_menu s','s.page_id=c.page_id');
           $this->db->where($condition);
           $this->db->group_by('s.ulbid','s.page_id');
           $result=$this->db->get()->result_array();
           //$i=1;
           foreach($result as $key=>$val)
           {
               $links[$i]['page_name']=$val['page_name'];
               $links[$i]['site_controller']=$val['site_controller'];
               $links[$i]['is_custumlink']=$val['is_custumlink'];
               $links[$i]['is_target_blank']=$val['is_target_blank'];
               $links[$i]['is_alert']=$val['is_alert'];
               $i++;
           }
       
           
         }
       
       
       return $links;
       
    }
    
	public function insert($table, $array)
	{	
		$query = $this->db->insert($table, $array);
		$insert_id = $this->db->insert_id();
	    if ($query) 
	    {
	    	return $insert_id;
	    }
	    else
	    {
	    	return 0;
	    }   
	}
	public function count($table, $array)
	{	
		$this->db->where($array);
		$query = $this->db->get($table);
		//echo $this->db->last_query();exit;
	    if ($query) 
	    {
	    	return $query->num_rows();
	    }
	    else
	    {
	    	return 0;
	    }   
	}
	public function all_records($table, $array)
	{	
		$this->db->select('*');
		$this->db->where($array);
	    $query = $this->db->get($table);
	    if ($query) 
	    {
	    	return $query->result();
	    }
	    else
	    {
	    	return 0;
	    }
	  }
    
	public function all_prioritized_records($table, $array)
	{	
		$this->db->select('*');
		$this->db->where($array);
		$this->db->order_by('priority', 'ASC'); // 1,2,3...
	    $query = $this->db->get($table);
	    if ($query) 
	    {
	    	return $query->result();
	    }
	    else
	    {
	    	return 0;
	    }
	}
	  
	public function getImportantLinks($array)
	{	
		
		$this->db->select('*');
		$this->db->where($array);
	    $query = $this->db->get('imp_links');
		
		//echo "<pre>";print_r($query->result());echo "</pre>";die();
		
	    if ($query) 
	    {
	    	return $query->result();
	    }
	    else
	    {
	    	return 0;
	    }
	}
    
    public function delete($table, $array)
	{
		$this->db->where($array);
		$query = $this->db->delete($table);
		if ($query) 
		{
			return true;
		}
		else
		{
			return 0;
		}
	}
	public function get_row($table, $array)
	{	
		$this->db->where($array);
		$query = $this->db->get($table);
		$row = $query->row();
	    if ($query) 
	    {
	    	return $query->row();
	    }
	    else
	    {
	    	return 0;
	    }   
	}
	public function update($table, $array, $where)
	{
		$this->db->where($where);
		$query = $this->db->update($table, $array);
		if ($query) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function getStaticSingleWidget($style){
	    $this->db->select('*');
	    $this->db->from('image_text_widgets');
	    $this->db->where('widget_type_style',$style);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	public function getSocialMediaLinks(){
	    $this->db->select('*');
	    $this->db->from('ulbmst');	  
	    $query = $this->db->get();
	    return $query->result_array();
	}
   
}
?>