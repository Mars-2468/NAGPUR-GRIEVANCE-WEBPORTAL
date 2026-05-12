<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',1);
class SocialMediaController extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 public function __construct()
	 { 
	    Parent::__construct();
	    $this->load->model('CreatePostModel');
	    $this->load->model('CreatepageModel');
	    $this->load->model('ViewAlbumModel');
	    $this->load->model('SocialMediaModel');
	    $this->load->model('FaqModel');
	    $this->load->library('form_validation');
	    $this->load->library('CategoryFunctions');
	    $this->load->helper('captcha');
	    $this->CategoryFunctions=new CategoryFunctions();
	    
	 }
	 
	
	 
	public function index()
	{
		if (!in_array($this->session->userdata('userid'),['superadmin'])) {
			$this->session->set_flashdata('error_message','Sorry you dont have permissions');
			//echo "Error: Sorry you don't have permissions!" ;
			redirect ('dashboard');
			exit;
		}
		//echo '<pre>';print_r('test');exit;
	   if($this->session->userdata('session_id')==session_id())
	    {
		    
	    $submenudata=array();
	    
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
	    $subMenus=$this->MenuModel->getSubMenu();
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'),'is_custumlink'=>3,'langId'=>$this->session->userdata('langId'));
	    
	  
	   
	    
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
		
	    $data['sub_menus']=$submenudata;
		
		//$assignedDepartments=$this->CreatePostModel->getAssignedCategories();
				
		//print_r($assignedDepartments);die();
		
	    //$data['categories']=$this->CreatePostModel->getPostCategories($params);
		$assignedDepartments=array();
	    $categories=$this->CreatePostModel->getPostCategories($params,$assignedDepartments);
		
	   
	   
	    foreach($categories['ulbcategories']->result() as $key=>$val)
	    {
	        $data['categories'][$val->category_id]=$val->category_desc;
	        $data['tbls'][$val->category_id]=$val->table_name;
	    }
	    
		//echo '<pre>';print_r($categories['admincategories']->num_rows());exit; 
	    
		if($categories['admincategories']->num_rows()){
			foreach($categories['admincategories']->result() as $key=>$val)
			{
				$data['categories'][$val->category_id]=$val->category_desc;
				$data['tbls'][$val->category_id]=$val->table_name;
			}
		}
	    	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	 
	    // category form data
	    $params=array('user_level'=>'A','is_custumlink'=>3);
	    $formdata=$this->MenuModel->getformsdata($params);
				
			foreach($formdata as $key=>$val)
			{
				$forms[$val->category_id][$val->sno]['label']=$val->label;
				$forms[$val->category_id][$val->sno]['type']=$val->type;
				$forms[$val->category_id][$val->sno]['name']=$val->name;
				$forms[$val->category_id][$val->sno]['id']=$val->id;
				$forms[$val->category_id][$val->sno]['class']=$val->class;
				$forms[$val->category_id][$val->sno]['data_type']=$val->data_type;
				$forms[$val->category_id][$val->sno]['min_date_after']=$val->min_date_after;
				
			}
		
	    
	    
	    $data['forms']=$forms;
		
	   // print_r($forms);
	    // getting select options from the table ' select_options_map'
	    
	    $getselectoptionsdata=$this->MenuModel->getselectoptionsdata();
		
		
		
	    foreach($getselectoptionsdata->result() as $key=>$val)
	    {
	        $select_options[$val->select_id][$val->option_id]['option_id']=$val->option_id;
	        $select_options[$val->select_id][$val->option_id]['option_desc']=$val->option_desc;
	     
	    } 
		
	    $data['select_options']=$select_options;
	    // close 
	     $config = array(
            'img_path'      => 'assets/captcha_images/',
            'img_url'       => base_url().'assets/captcha_images/',
            'font_path'     => base_url().'system/fonts/texb.ttf',
            'img_width'     => '180',
            'img_height'    => 50,
            'expiration'    => 3600,
            'word_length'   => 6,
            'font_size'     => 18,
            'colors'        => array(
                        'background' => array(255, 255, 227),
                        'border' => array(33, 23, 96),
                        'text' => array(57, 44, 112),
                        'grid' => array(174, 222, 252)
                )
        );
		
		
			//echo '<pre>';print_r( $data);exit;
			
        $captcha = create_captcha($config);
        
		//echo '<pre>';print_r($captcha);exit;
        
		// Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
      
        // Pass captcha image to view
        // $data_cap['captchaImg'] = $captcha['image'];
        $data['captchaImg'] = $captcha['image'];
	    
	    // getting all dependent fields from the table 'category_form_dependent_mst'
	    
	
		
	    $dependent_field_data=$this->MenuModel->getDependentFielddata();
	    
		//echo '<pre>';print_r($dependent_field_data);exit;
		
	    foreach($dependent_field_data->result() as $key=>$val)
	    {
	        $dependentParentFields[$val->field_id]=$val->field_id; // dependent parent fields
	        $hiddenfields[$val->dependent_field_id]=$val->dependent_field_id; // dependent child fields
	        $setFunctionValues[$val->field_id]=$val->dependent_field_id; // in view we are setting 'dependentFunction' for that purpose we are setting this array values 
	       
	    }
		//echo '<pre>';print_r($dependentParentFields);exit;
	    //$data['dependentfieldslist']=$dependentfieldslist;
	    $data['hiddenfields']=$hiddenfields;
	    $data['dependentParentFields']=$dependentParentFields;
	    $data['setFunctionValues']=$setFunctionValues;	    
	    	    
	    // close 
	    	    
	    $params = array('ulbid'=>$this->session->userdata('ulbid'),'status'=>1);
	    $data['create_media_data']=$this->ViewAlbumModel->createMediaData($params,$dependentParentFields);
		$id = $this->uri->segment(2);
	    $data['faqs']= $this->FaqModel->get_all_faqs();
	    $data['edit_social_media']= $this->SocialMediaModel->get_link_data();
		
		if (!$this->session->userdata('form_nonce')) {
            $nonce = bin2hex(random_bytes(16));
            $this->session->set_userdata('form_nonce', $nonce);
        } else {
            $nonce = $this->session->userdata('form_nonce');
        }

        $data['form_nonce'] = $nonce;
		
	// echo '<pre>';print_r($data['edit_social_media']);exit;
	
	
	    $this->load->view('header',$data);
		$this->load->view('social_media/social_media',$data);
		$this->load->view('divdata',$data);
		$this->load->view('footer');
	    
	    }
	    else
	    {
	        redirect('login');
	    }
	    
	
	}
	
	public function delete()
	{
	    $delid = $this->uri->segment('2');
	    $del = $this->FaqModel->faq_delete($delid);
	    if ($del) 
	     {
	   	  $this->session->set_flashdata('success', 'Deleted Successfully !! ');
	      redirect('faq-details');
	     }
	}
	
	public function updateLinks(){
		
		//print_r($this->input->post()); exit();  
		 
		 $this->_verify_nonce();
		 
		if($this->input->post('id'))
		{

		  $this->form_validation->set_rules('facebook_link','facebook_link','trim|required');
		  $this->form_validation->set_rules('twitter_link','twitter_link','trim|required');
  		  $this->form_validation->set_rules('instagram_link','instagram_link','trim|required');
		
		  $this->form_validation->set_rules('id','id','trim|required');
		  
		  if($this->form_validation->run() == false)
		  {
			//echo "error" ; exit;
			$this->session->set_flashdata('error', 'All Fields are Mandatory!');
			redirect ('social-media-links');
		  }    
		  
			$facebook_link = $this->security->xss_clean(trim($this->input->post('facebook_link')));
			$twitter_link = $this->security->xss_clean(trim($this->input->post('twitter_link')));
			$instagram_link = $this->security->xss_clean(trim($this->input->post('instagram_link')));
		
			$id = $this->input->post('id');
			//var_dump($id);die();	
			$data = array(
				'facebook_link' => $facebook_link, 
				'twitter_link' => $twitter_link,
				'instagram_link' => $instagram_link
			
				);

			foreach($data as $param){			
				if (preg_match('/<[^<]+>/', $param)) {
					echo "Error: HTML or script tag detected in ".$param." field!" ;
					redirect ('social-media-links-page');
					exit;
				}
			}

			$run = $this->SocialMediaModel->update_data($data,$id);
			//echo $this->db->last_query(); exit;
			 if ($run) 
			   {
				 $this->session->set_flashdata('success', ' Updated Successfully !!');
				 redirect ('social-media-links-page');
			   }
		
		}
	
	
	}
	
	
			  /** 🔒 Central nonce verification method */
    private function _verify_nonce()
    {
        $nonce_post    = $this->input->post('form_nonce');
        $nonce_session = $this->session->userdata('form_nonce');

        if (empty($nonce_post) || $nonce_post !== $nonce_session) {
            $this->session->set_flashdata('error', 'Invalid or reused submission!');
            redirect($_SERVER['HTTP_REFERER'] ?? 'imp-links');
            exit;
        }

        // destroy nonce to prevent reuse
        $this->session->unset_userdata('form_nonce');
    }
}