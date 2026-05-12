<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class CustomModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
   
    
    public function getpageSidebarId()
    {
        $condition=array('sidebars_id'=>5);
        $this->db->select('superadmin_defautl_layout');
        $this->db->where($condition);
        $result=$this->db->get('innerpage_layout_master')->row_array();
        return $result;
    }
	
	/* public function getsearchData($params, $where)
	{
    $keyword = trim(strtolower(str_replace("'", "", $params['keyword'])));
    $escaped = $this->db->escape_like_str($keyword);

    // STEP 1: Initial DB filtering (FAST) 
    $sql = "(
        LOWER(page_name) LIKE '%{$escaped}%'
        OR LOWER(content) LIKE '%{$escaped}%'
    )";

    $this->db->select([
        'page_name',
        'page_id',
        'content',
        'permalink',
        'site_controller',
        'is_custumlink'
    ]);
    $this->db->from('custom_menus');
    $this->db->where($where);
    $this->db->where($sql);

    $rows = $this->db->get()->result_array();

    // STEP 2: PHP fuzzy ranking 
    $results = [];
    $maxDistance = 3; // typo tolerance

    foreach ($rows as $row) {

        $pageName   = strtolower($row['page_name']);
        $content    = strtolower(strip_tags($row['content']));

        // Levenshtein distance (typo handling)
        $dist1 = levenshtein($keyword, $pageName);
        $dist2 = levenshtein($keyword, substr($content, 0, 255));

        // Similarity percentage
        similar_text($keyword, $pageName, $percent1);
        similar_text($keyword, $content, $percent2);

        // Final relevance score (lower = better)
        $score = min($dist1, $dist2) - max($percent1, $percent2) / 10;

        if ($score <= $maxDistance) {
            $row['relevance_score'] = round($score, 2);
            $results[] = $row;
        }
    }

    // STEP 3: Sort by relevance 
    usort($results, function ($a, $b) {
        return $a['relevance_score'] <=> $b['relevance_score'];
    });

    return $results;
} */

    public function getsearchData($params,$where)
    {
        $string  = str_replace("'","",$params['keyword']);
        //$string  =$params['keyword'];
        $sql ="(
        content like '%".strtoupper($string)."%' or 
        content like '%".strtolower($string)."%' or
        content like '%".ucfirst($string)."%' or
        page_name like '%".strtoupper($string)."%' or 
        page_name like '%".strtolower($string)."%' or 
        page_name like '%".ucfirst($string)."%')";
        
        $select_array=array('page_name','page_id','content','permalink','site_controller','is_custumlink');
        $this->db->select($select_array);
        $this->db->from('custom_menus');
        $this->db->where($where);
        $this->db->where($sql);
        $result=$this->db->get()->result_array();
        // echo $this->db->last_query();
        return $result;
    } 
    
    public function sidebar_list($params)
    {
         $select_array=array('*');
        $result=$this->db->select($select_array)->where($params)->order_by('sort_order')->get('innerpage_layout_map')->result_array();
        //echo $this->db->last_query();
        return $result;
    }
    
    public function angularAboutData($params)
    {
        $select_array=array('page_id','page_title','content','controller','page_name','page_sidebars_id');
        $result=$this->db->select($select_array)->where($params)->get('custom_menus')->result_array();
        
       // print_r($result);
       
        return $result;
    }
    
    public function getCategoryName($params)
    {
        /*$select_array=array('c.*','pcm.category_id');
        $condition=array('pcm.category_id'=>$params['category_id']);
        $this->db->select($select_array);
        $this->db->from('post_category_map pcm');
        $this->db->join('custom_menus c','pcm.category_id=c.page_id');
        $this->db->where($condition);
        $result=$this->db->get()->row_array();*/
        
        $select_array=array('*');
       
        $this->db->select($select_array);
        $this->db->where($params);
        $result=$this->db->get('custom_menus')->row_array();
       
        return $result;
    }
    
    public function getCategoryPosts($params)
    {
        $select_array=array('c.*');
        
        $this->db->select($select_array);
        $this->db->from('post_category_map p');
        $this->db->join('custom_menus c','p.page_id=c.page_id');
        $this->db->where($params);
        $this->db->order_by('c.datetime','DESC');
        $result=$this->db->get()->result_array();
        // $this->db->last_query();
        
        return $result;
    }
    
    public function getSidebarid($params)
    {
                $select_array=array('superadmin_defautl_layout');
                $condition=array('sidebars_id'=>$params['page_sidebars_id']);
                $this->db->select($select_array);
                $this->db->where($condition);
                $sidebar=$this->db->get('innerpage_layout_master')->row_array();
               
               
                if($sidebar['superadmin_defautl_layout'] !='')
                {
                    $pagesidebarid=$sidebar['superadmin_defautl_layout'];
                }
                else
                {
                    $pagesidebarid=$params['page_sidebars_id'];
                }
                return $pagesidebarid;
    }
    
    
    public function getpageData($params)
    {
       
        $select_array=array('*');
        $condition=array('controller'=>$params['controller'],'ulbid'=>$params['ulbid']);
        $this->db->select($select_array);
        $this->db->where($condition);
        $result=$this->db->get('custom_menus');
        //print_r($condition);
        $this->db->last_query();
        //echo $this->db->last_query();exit;
        foreach($result->result() as $key=>$val)
        {
            $page_id=$val->page_id;
            $is_common_page=$val->is_common_page;
            $is_code_page=$val->is_code_page;
            $controller=$val->controller;
            $pagesidebarid=$val->page_sidebars_id;
            
            $data['is_code_page']=$val->is_code_page;
            $data['controller']=$val->controller;
            $data['page_id']=$val->page_id;
            $data['page_title']=$val->page_title;
            $data['page_sidebars_id']=$pagesidebarid;
            $data['funcname']=$val->funcname;
            $data['page_name']=$val->page_name;
            ///$data['meta_desc']=$val->meta_desc;
            $data['site_controller']=$val->site_controller;

            // echo "<pre>";
            // print_r($data);
            // exit;
        }
        
        if($is_code_page=='1')
        {
            return $data;
        }
        else
        {
       
                if($is_common_page=='1')
                {
                    
                    $select_array=array('*');
                    $condition=array('page_id'=>$page_id);
                    $result=$this->db->select($select_array)->where($condition)->get('custom_menus')->result_array();
                }
                else
                {
                    $select_array=array('*');
                    $result=$this->db->select($select_array)->where($params)->get('custom_menus')->result_array();
                }
                
               
               
               
                return $result;
        }
    }
    
  
    public function updatePageContent($params)
    {
        echo $query="update custom_menus set content='".$params['content']."' where page_id='".$params['pageid']."'";
        if($this->db->query($query))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    
    public function maximum_updated_date()
   {
          $sql="SELECT MAX(ts) AS MaxDate FROM site_main_menu";
         
         $result=$this->db->query($sql);
            return $result;
       
   }
   
   
    public function add_feedback_from()
    {
                $ulbid=$this->input->post('ulbid');
                $name= $this->input->post('name');
                $mobile=$this->input->post('mobile');
                $emailid=$this->input->post('emailid');
                $address=$this->input->post('address');
                $comment=$this->input->post('comment');
                $feedback_for =$this->input->post('feedback_for');
                $captcha =$this->input->post('captcha');
               
                 $sql="insert into feedback_mst(ulbid,name,mobile,email_id,address,feedback_type,captcha_code,description) VALUES('".$ulbid."','".$name."',
                '".$mobile."',
                '".$emailid."',
                '".$address."',
                '".$feedback_for."',
                '".$captcha."','".$comment."')";
     $res=$this->db->query($sql);
     return $res;
        
    }

	public function getEncQueries(){
		
		$this->db->select('site_sub_menus.page_id, site_sub_menus.sub_menu_desc, encroachment_queries.id as query_id, encroachment_queries.show_cause_notice, encroachment_queries.applicant_reply,encroachment_queries.answer, encroachment_queries.description, encroachment_queries.created_at');
		$this->db->from('site_sub_menus');
		$this->db->join('encroachment_queries', 'encroachment_queries.page_id = site_sub_menus.page_id', 'left');
		$this->db->order_by('site_sub_menus.page_id');
		$query = $this->db->get();

		$results = $query->result_array();  // get as array


		$departments = [];

		foreach ($results as $row) {
			$deptId = $row['page_id'];

			// Initialize if not already set
			if (!isset($departments[$deptId])) {
				$departments[$deptId] = [
					'page_id' => $deptId,
					'dept_desc' => $row['sub_menu_desc'],
					'queries' => [],
				];
			}

			// If query exists, add it
			if (!empty($row['query_id'])) {
				$departments[$deptId]['queries'][] = [
					'query_id' => $row['query_id'],
					'show_cause_notice' => $row['show_cause_notice'],
					'applicant_reply' => $row['applicant_reply'],
					'answer' => $row['answer'],
					'description' => $row['description'],
					'created_at' => $row['created_at'],
				];
			}
		}
		
		$final_list = array_values($departments);
		
		return $final_list;
	}    
}
?>