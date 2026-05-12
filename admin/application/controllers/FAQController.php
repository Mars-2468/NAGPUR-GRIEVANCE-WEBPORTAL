<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class FAQController extends MY_Controller {

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
	 
	public function __construct(){
		
	    Parent::__construct();
	    $this->load->model('CreatePostModel');
	    $this->load->model('CreatepageModel');
	    $this->load->model('ViewAlbumModel');
	    $this->load->model('FaqModel');
	    $this->load->library('form_validation');
	    $this->load->library('CategoryFunctions');
	    $this->load->helper('captcha');
	    $this->load->helper('security');
	    $this->CategoryFunctions=new CategoryFunctions();
	    
	}
	 
	
	 
	public function index()
	{
		
		if($this->session->userdata('session_id')==session_id()){
	    
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
			//$data['categories']=$this->CreatePostModel->getPostCategories($params);
			$assignedDepartments = array();
			$categories=$this->CreatePostModel->getPostCategories($params,$assignedDepartments);
		   
		 
			foreach($categories['ulbcategories']->result() as $key=>$val)
			{
				$data['categories'][$val->category_id]=$val->category_desc;
				$data['tbls'][$val->category_id]=$val->table_name;
			}
			
			foreach($categories['admincategories']->result() as $key=>$val)
			{
				$data['categories'][$val->category_id]=$val->category_desc;
				$data['tbls'][$val->category_id]=$val->table_name;
			}
			
			$params=array('ulbid'=>$this->session->userdata('ulbid'));
			$data['languageList']=$this->MenuModel->getLanguages($params);
			
			// category form data
			$params=array('user_level'=>'A','is_custumlink'=>3);
			$formdata=$this->MenuModel->getformsdata($params);
			
			  //echo "<pre>";print_r($formdata);echo "</pre>";die();
			
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
				'font_path'     => 'system/fonts/texb.ttf',
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
			$captcha = create_captcha($config);
			
			// Unset previous captcha and set new captcha word
			$this->session->unset_userdata('captchaCode');
			$this->session->set_userdata('captchaCode', $captcha['word']);
			
			// Pass captcha image to view
			// $data_cap['captchaImg'] = $captcha['image'];
			$data['captchaImg'] = $captcha['image'];
			
			// getting all dependent fields from the table 'category_form_dependent_mst'
			
			$dependent_field_data=$this->MenuModel->getDependentFielddata();
			foreach($dependent_field_data->result() as $key=>$val)
			{
				$dependentParentFields[$val->field_id]=$val->field_id; // dependent parent fields
				$hiddenfields[$val->dependent_field_id]=$val->dependent_field_id; // dependent child fields
				$setFunctionValues[$val->field_id]=$val->dependent_field_id; 
// in view we are setting 'dependentFunction' for that purpose we are setting this array values 
			   
			}
			$data['dependentfieldslist']=$dependentfieldslist;
			$data['hiddenfields']=$hiddenfields;
			$data['dependentParentFields']=$dependentParentFields;
			$data['setFunctionValues']=$setFunctionValues;
			
			//print_r($data['dependentfieldslist']);
			
			// close 
			$myDepartment = $this->FaqModel->get_my_department($this->session->userdata('userid'));
			
			//print_r($myDepartment->id); exit;
			
			$params = array('ulbid'=>$this->session->userdata('ulbid'),'status'=>1);
			$data['create_media_data']=$this->ViewAlbumModel->createMediaData($params);
			$id = $this->uri->segment(2);
			$data['faqs']= $this->FaqModel->get_all_faqs();
			$data['edit_faqs']= $this->FaqModel->get_single_faqs($id);
		  //  echo '<pre>';print_r($this->session->userdata());exit;


		if (!$this->session->userdata('form_nonce')) {
            $nonce = bin2hex(random_bytes(16));
            $this->session->set_userdata('form_nonce', $nonce);
        } else {
            $nonce = $this->session->userdata('form_nonce');
        }

        $data['form_nonce'] = $nonce;

  //echo "<pre>";print_r($this->session->flashdata('form_nonce'));echo "</pre>";die();

			$this->load->view('header',$data);
			$this->load->view('faq/faq',$data);
			$this->load->view('divdata',$data);
			$this->load->view('footer');
	    
	    }else{
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
	
	public function add_faqs(){
	
	//echo "<pre>";print_r($nonce_session.' = '.$nonce_post);echo "</pre>";die();	
	
	    $nonce_post    = $this->input->post('form_nonce');
        $nonce_session = $this->session->userdata('form_nonce');

        // ✅ 1. Validate custom nonce
        if (empty($nonce_post) || ($nonce_post !== $nonce_session)) {
            $this->session->set_flashdata('error', 'Invalid or reused submission!');
            redirect('faq-details');
        }

        // remove nonce to prevent reuse
        $this->session->unset_userdata('form_nonce');
		
		

		if($this->input->post('id'))
		{

		  $this->form_validation->set_rules('question','question','trim|required');
		  $this->form_validation->set_rules('answer','answer','trim|required');
		  $this->form_validation->set_rules('status','status','trim|required');
		  $this->form_validation->set_rules('id','id','trim|required');
		  
		  if($this->form_validation->run() == false)
		  {
			//echo "error" ; exit;
			$this->session->set_flashdata('error', 'All Fields are Mandatory!');
			redirect ('faq-details');
		  }    
		

 
  	/* 	if(empty($this->input->post('csrf_test_name')) || ($this->security->get_csrf_hash() != $this->input->post('csrf_test_name')))
		  {
			//echo "error" ; exit;
			$this->session->set_flashdata('error', 'CSRF Token value is Missmatch!');
			redirect ('faq-details');
		  } 

		if(empty($this->security->get_csrf_token_name()) || ($this->security->get_csrf_token_name() != 'csrf_test_name'))
		  {
			//echo "error" ; exit;
			$this->session->set_flashdata('error', 'CSRF Token Name is Missmatch!');
			redirect ('faq-details');
		  } */

		  
			$question = $this->input->post('question');
			$answer = $this->input->post('answer');
			$status = $this->input->post('status');
			$id = $this->input->post('id');
				
			date_default_timezone_set('Asia/Kolkata');
			$todat_date_time = date('Y-m-d H:i:s');
			$myDepartment = $this->FaqModel->get_my_department($this->session->userdata('userid'));
			//print_r($myDepartment->id); exit;
			$data = array(
				'question' => $question, 
				'answer' => $answer, 
				'status' => $status,
				'dept_id' => $myDepartment->id,
				'created_at' => $todat_date_time
			
				);
				foreach($data as $Arr){
					if (preg_match('/<[^<]+>/', $Arr)) {
						echo "Error: HTML or script tag detected in ".$Arr." field!" ;
						redirect ('faq-details');
						exit;
					}
				}
			$run = $this->FaqModel->update_data($data,$id);
			//echo $this->db->last_query(); exit;
			 if ($run) 
			   {
				 $this->session->set_flashdata('success', ' Updated Successfully !!');
				 redirect ('faq-details');
			   }
		}else{
			$this->form_validation->set_rules('question','question','trim|required');
			$this->form_validation->set_rules('answer','answer','trim|required');
			$this->form_validation->set_rules('status','status','trim|required');
			
			if($this->form_validation->run() == false)
			{
			  //echo "error" ; exit;
			  $this->session->set_flashdata('error', 'All Fields are Mandatory!');
			  redirect ('faq-details');
			}    
				//echo $this->security->get_csrf_hash(); exit;
	
		/* 	if(empty($this->input->post('csrf_test_name')) || ($this->security->get_csrf_hash() != $this->input->post('csrf_test_name')))
			{
				//echo "error" ; exit;
				$this->session->set_flashdata('error', 'CSRF Token value is Missmatch!');
				redirect ('faq-details');
			} 

			if(empty($this->security->get_csrf_token_name()) || ($this->security->get_csrf_token_name() != 'csrf_test_name'))
			{
				//echo "error" ; exit;
				$this->session->set_flashdata('error', 'CSRF Token Name is Missmatch!');
				redirect ('faq-details');
			} */

			  $question = $this->input->post('question');
			  $answer = $this->input->post('answer');
			  $status = $this->input->post('status');
			  $myDepartment = $this->FaqModel->get_my_department($this->session->userdata('userid'));
  
			  date_default_timezone_set('Asia/Kolkata');
			  $todat_date_time = date('Y-m-d H:i:s');
			  $data = array(
				  'question' => $question, 
				  'answer' => $answer, 
				  'status' => $status,
				  'dept_id' => $myDepartment->id,

				  'created_at' => $todat_date_time
			  
				  );
  				foreach($data as $Arr){
					if (preg_match('/<[^<]+>/', $Arr)) {
						echo "Error: HTML or script tag detected in ".$Arr." field!" ;
						redirect ('faq-details');
						exit;
					}
				}

			  $run = $this->FaqModel->insert_data($data);
			  //echo $this->db->last_query(); exit;
			   if ($run) 
				 {
				   $this->session->set_flashdata('success', ' Inserted Successfully !!');
				   redirect ('faq-details');
				 }
		}

	}
	
	
	
	
	
	
}