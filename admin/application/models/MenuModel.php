<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class MenuModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
        //$this->load->library('session');
    }
    
    public function getDependentFielddata()
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $result=$this->db->get('category_form_dependent_mst');
        return $result;
    }
    
    public function getinnerpagelayouts($params)
    {
        $select_array=array('theme_id');
        $condition=array('ulbid'=>$params['ulbid']);
        $this->db->select($select_array);
        $this->db->where($condition);
        $theme_id=$this->db->get('ulbmst')->row_array();
        
        $select_array=array('*');
        $condition=array('theme_id'=>$theme_id['theme_id']);
        $this->db->select($select_array);
        $this->db->where($condition);
        $result=$this->db->get('innerpage_layout_master')->result_array();
        
        return $result;
            
    }
    
    public function getCategorydata($tables,$page_id)
    {
       
	 $data = [];
	   
        foreach($tables as $key=>$table_name)
        {
           
            if(strtolower($table_name)!='notifications')
            { 
		
		
            $condition=array('page_id'=>$page_id); // getting only selected page data from dynamic categories table
            $select_array=array('*');
            $this->db->select($select_array);
            $this->db->where($condition);
			
            $data[$key]=$this->db->get($table_name);//->result_array();
            // echo "<pre>"; print_r($data[$key]);echo "</pre>"; die();
           
            }
            
           
        }
        return $data;
    }
    
    public function getTenderdetails($params)
    {
        $select_array=array('c.*','pcm.*');
        $this->db->select($select_array);
        $this->db->from('post_category_map pcm');
        $this->db->join('custom_menus c','pcm.category_id=c.page_id');
        $this->db->where($params);
        $result=$this->db->get()->result_array();
        
        //print_r($params);exit;
        // echo ($this->db->last_query());exit;
        
        
        return $result;
    }
    
    public function getselectoptionsdata()
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $result=$this->db->get('select_options_map');
        //echo ($this->db->last_query());exit;
        return $result;
    }
    public function getformsdata($params)
    {
        $condition=array('flag'=>1);
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($condition);
        $query=$this->db->get('category_forms_mst');
  // print_r ($query->result());exit;
        return $query->result();
    }
    
    public function getLanguages($params)
    {
        $select_array=array('languageId','language_desc');
        $this->db->where('status', 'Enable');
        $result=$this->db->select($select_array)->get('language_mst');
        return $result;
    }
    
    public function getMainMenu()
    {
      
       
        if($this->session->userdata('is_custom_user')=='Yes'){
            $where=array('status'=>'1','user_id'=>$this->session->userdata('userid'));
        }
        else
            {
                $where=array('status'=>'1','user_category'=>$this->session->userdata('user_category'));
                
            }
			
		
		  
        $select=array('*');
        
        $this->db->select($select);
        $this->db->from('users_services s');
        $this->db->join('main_menu m','s.main_menu_id=m.main_menu_id');
        $this->db->where($where);
        $this->db->group_by('s.main_menu_id');
        $this->db->order_by('sort_order','ASC');
        $result=$this->db->get()->result_array();
        
         // echo "<pre>";print_r($result);echo "</pre>";die(); 
        
        //$result=$this->db->select($select)->where($where)->order_by('sort_order','ASC')->get('main_menu')->result_array();
        
        return $result;
        
        
     }
     public function getSubMenu()
    {
         if($this->session->userdata('is_custom_user')=='Yes'){
            $where=array('status'=>'1','user_id'=>$this->session->userdata('userid'));
        }
        else
            {
                $where=array('status'=>'1','user_category'=>$this->session->userdata('user_category'));
                
            }
       
		 
        //$result=$this->db->select($select)->order_by('sort_order','asc')->get('sub_menu')->result_array();
        $select=array('s.*','m.sub_menu_desc','m.SubcontrollerName');
        //$where=array('status'=>'1','user_id'=>$this->session->userdata('userid'));
        $this->db->select($select);
        $this->db->from('users_services s');
        $this->db->join('sub_menu m','s.sub_menu_id=m.sub_menu_id');
        $this->db->where($where);
        $this->db->order_by('sort_order','ASC');
        $result=$this->db->get()->result_array();
       // echo $this->db->last_query();
        
        return $result;
        
        
     }
     
     
    public function getPosts($params)
    {
        $select=array('*');
        
        
        $result=$this->db->select($select)->where($params)->order_by('ts','DESC')->get('custom_menus')->result_array();
        
        return $result;
        
        
     }
     
     
    public function getCustomMenuOLD20250707($params){
		
        $select=array('*');        
        
        $result=$this->db->select($select)->where($params)->order_by('ts','DESC')->get('custom_menus')->result_array();
    
        return $result;
     }

    public function getCustomMenu($params){
		
        $select=array('*');        
        if(in_array($this->session->userdata('userid'),['Zone_01','Zone_02','Zone_03','Zone_04','Zone_05','Zone_06','Zone_07','Zone_08','Zone_09','Zone_10'])){	
			$page_ids = $this->get_zonal_or_dept_page_ids();
			$result=$this->db->select($select)->where($params)->where_in('page_id',$page_ids)->order_by('ts','DESC')->get('custom_menus')->result_array();
			//echo "<pre>";print_r($page_ids);echo "</pre>";die();
		}else{
			$result=$this->db->select($select)->where($params)->order_by('ts','DESC')->get('custom_menus')->result_array();
		}

        return $result;
    }

	public function get_zonal_or_dept_page_ids()
	{	
		// For regular users, fetch all sub menus under selected zonal/department
		$userDeptMap = $this->db
			->select('dept_id')
			->where('user_id', $this->session->userdata('userid'))
			->get('user_department_map')
			->result_array();
		// Extract just the dept_ids into a flat array
		$deptIds = array_column($userDeptMap, 'dept_id');	
		return $deptIds;		
	}     

     public function getCustomMenutest($ulb,$langid,$userid,$user_level)
    {
        $sql="select * from custom_menus where ulbid='".$ulb."' and langId='".$langid."' and is_custumlink='0' and author='".$userid."' and user_level='".$user_level."'";
        
        $result=$this->db->query($sql);
        
        return $result;
        
    }
    
    
   public function getlink()
    {
       $select=array('*');
        
        $result=$this->db->select($select)->where('ulbid',$this->session->userdata('ulbid'))->get('social_link')->result_array();
        
        return $result;
     }
    
     public function update($data)
    {
		 $this->db->select('(SELECT SUM(payments.amount) FROM payments WHERE payments.invoice_id=4) AS amount_paid', FALSE);
		$query = $this->db->get('mytable');
        
     }
    
     public function getseo()
    {
       $select=array('*');
        
        $result=$this->db->select($select)->where('ulbid',$this->session->userdata('ulbid'))->get('seo_mst')->result_array();
        
        return $result;
     }
    
      public function select()  
      {  
		  $this->db->select("*");
		  $this->db->where('ulbid',$this->session->userdata('ulbid'));
		  $this->db->from('add_services');
		  $query = $this->db->get();
		  return $query->result();
      }  
    
     public function select_window()  
      {  
		 $this->db->select("*");
		  $this->db->from('window_mst');
		  $query = $this->db->get();
		  return $query->result();
      }
      
      
     public function edit_service($id)
    {
              $select=array('*');
        
        $result=$this->db->select($select)->where('id',$id)->get('add_services')->result_array();
        
        return $result;
    }  
       public function selt_image($idss)
    {
              $select=array('*');
        
        $result=$this->db->select($select)->where('id',$idss)->get('add_services')->result_array();
        
        return $result;
    }  
     public function select1($id)
    {
              $select=array('*');
        
        $result=$this->db->select($select)->where('wid_id',$id)->get('add_services')->result_array();
        
        return $result;
    }  
        public function select2($id)
    {
              $select=array('*');
        
        $result=$this->db->select($select)->where('wid_id',$id)->get('add_services')->result_array();
        
        return $result;
    } 
       public function select3($id)
    {
              $select=array('*');
        
        $result=$this->db->select($select)->where('wid_id',$id)->get('add_services')->result_array();
        
        return $result;
    } 
        public function select4($id)
    {
              $select=array('*');
        
        $result=$this->db->select($select)->where('wid_id',$id)->get('add_services')->result_array();
        
        return $result;
    } 
    
    public function countofdraft_post($params){
        
          $sql="select count(page_id) as count from custom_menus where is_draft='1' and ulbid='".$params['ulbid']."' and langId='".$params['langId']."' and is_custumlink='2'";
         
          $result=$this->db->query($sql);
        
        return $result;
         
     }
     
     public function countofpublish_post($params){
        
          $sql="select count(page_id) as count from custom_menus where is_draft='0' and ulbid='".$params['ulbid']."' and langId='".$params['langId']."' and is_custumlink='2'";
         
          $result=$this->db->query($sql);
        
        return $result;
         
     }
     
     public function countofdraft_page($params){
        
          $sql="select count(page_id) as count from custom_menus where is_draft='1' and ulbid='".$params['ulbid']."' and langId='".$params['langId']."' and is_custumlink='0'";
         
          $result=$this->db->query($sql);
        
        return $result;
         
     }
     
     public function countofpublish_page($params){
        
          $sql="select count(page_id) as count from custom_menus where is_draft='0' and ulbid='".$params['ulbid']."' and langId='".$params['langId']."' and is_custumlink='0'";
         
          $result=$this->db->query($sql);
        
        return $result;
         
     }
	 
	public function getAllSliderPosts($params)
    {
       $select_array=array('s.*','c.*');
        $condition=array('c.ulbid'=>$params['ulbid']);
        $this->db->select($select_array);
        $this->db->from('slider_mst2 s');
        $this->db->join('custom_menus c','s.page_id=c.page_id');
        $this->db->where($condition);
        $result=$this->db->get(); 
        //echo "<pre>";print_r($result->result_array());echo "</pre>";die();
        return $result->result_array();
    }
	
}
?>