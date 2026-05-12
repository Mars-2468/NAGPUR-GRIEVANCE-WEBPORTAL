<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class RightserviceController extends CI_Controller {

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
	 * 
	 */
	 public function __construct()
	 {
	     Parent::__construct();
	     //$this->load->library('breadcrumbcomponent');
	           $this->load->library('form_validation');
	           $this->load->library('session');
	           $this->load->helper('url');
	 }
	public function index()
	{
	    
	     if($this->session->userdata('session_id')==session_id())
	    {
	    $submenudata=array();
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
	    $subMenus=$this->MenuModel->getSubMenu();
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    
	    $data['sub_menus']=$submenudata;
	    
	   
        $id1=1;
        $id2=2;
        $id3=3;
        $id4=4;
	    $getservice['report1']=$this->MenuModel->select1($id1);
	    $getservice['report2']=$this->MenuModel->select2($id2);
	    $getservice['report3']=$this->MenuModel->select3($id3);
	    $getservice['report4']=$this->MenuModel->select4($id4);
	   
	    $getservice['report']=$this->MenuModel->select();
	    $getservice['window']=$this->MenuModel->select_window();
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $this->load->view('header',$data);
		$this->load->view('rightservice',$getservice);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	public function insert()
	{
	 if($this->session->userdata('session_id')==session_id())
	    {
	
	        $this->form_validation->set_rules('service_title', 'service_title', 'required');
	        $this->form_validation->set_rules('page_link', 'page_link', 'required');
	        $this->form_validation->set_rules('img_title', 'img_title', 'required');
	        $this->form_validation->set_rules('window', 'window', 'required');
	        $this->form_validation->set_rules('img_text', 'img_text', 'required'); 
	      
	    if(isset($_POST['submit1'])){
           $id1=$this->security->xss_clean(trim($this->input->post('id1')));
           if($id1!='')
           {
             
            
	        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            redirect('right-services');
            }
            else
            {
           if(!empty($_FILES['picture']['name'])){
               
               
               
               
               
                $config['upload_path'] = 'assets/uploads/'.$this->session->userdata('ulbid');
                if (!file_exists($config['upload_path'])) {
                   mkdir($config['upload_path'], 0777, true);
                }
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);               
                if($this->upload->do_upload('picture'))
				{
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $full_path=base_url()."assets/uploads/'.$this->session->userdata('ulbid')/".$picture;
                }
				else
				{
                    $picture = '';
                }
            }
			else
			{
            $picture = '';
            }
	    if($picture!='')
	    {
	       
	    $data = array(  
	                    'picture' => $picture,
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
                        'file_type'=>$uploadData['file_name'],
            		    'file_path'=>$uploadData['file_path'],
            		    'full_path'=>$full_path,
            		    'raw_name'=>$uploadData['raw_name'],
            		    'orig_name'=>$uploadData['orig_name'],
            		    'client_name'=>$uploadData['client_name'],
            		    'file_ext'=>$uploadData['file_ext'],
            		    'file_size'=>$uploadData['file_size'],
            		    'is_image'=>$uploadData['is_image'],
            		    'image_width'=>$uploadData['image_width'],
            		    'image_height'=>$uploadData['image_height'],
            		    'image_type'=>$uploadData['image_type'],
            		    'image_size_str'=>$uploadData['image_size_str'],
            		    'wid_id'=>1
                        ); 
                        
                     
                        
            $this->db->set('date', 'NOW()', FALSE);
            $this->db->where('id',$id1);
            $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
            $this->db->update('add_services',$data); 
           // $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'image_path'=>$picture,
		    'file_type'=>$uploadData['file_name'],
		    'file_path'=>$uploadData['file_path'],
		    'full_path'=>$full_path,
		    'raw_name'=>$uploadData['raw_name'],
		    'orig_name'=>$uploadData['orig_name'],
		    'client_name'=>$uploadData['client_name'],
		    'file_ext'=>$uploadData['file_ext'],
		    'file_size'=>$uploadData['file_size'],
		    'is_image'=>$uploadData['is_image'],
		    'image_width'=>$uploadData['image_width'],
		    'image_height'=>$uploadData['image_height'],
		    'image_type'=>$uploadData['image_type'],
		    'image_size_str'=>$uploadData['image_size_str']
		    
		    );   
		    $this->db->where('service_id',$id1);
            $res=$this->db->update('medialibrary',$params2);
            redirect('right-services');
	    }
	    else
	    {
	         $data = array(  
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text')))
                        ); 
            $this->db->set('date', 'NOW()', FALSE);
            $this->db->where('id',$id1);
            $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
            $this->db->update('add_services',$data); 
             redirect('right-services');
	    }
        }
    
               
           }
           else
           {
               $ulbid=$this->session->userdata('ulbid');
	        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            redirect('right-services');
            }
           else
            {
           if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'assets/uploads/'.$this->session->userdata('ulbid');
                 if (!file_exists($config['upload_path'])) {
                   mkdir($config['upload_path'], 0777, true);
                }
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);               
                if($this->upload->do_upload('picture'))
				{
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $full_path=base_url()."assets/uploads/".$this->session->userdata('ulbid').$picture;
                }
				else
				{
                    $picture = '';
                }
            }
			else
			{
            $picture = '';
            }
	    
	    if($picture!='')
	    {
	    $data = array(  
	                    
	                    'ulbid' => $this->session->userdata('ulbid'),  
	                    'picture' => $picture,
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
                        'file_type'=>$uploadData['file_name'],
            		    'file_path'=>$uploadData['file_path'],
            		    'full_path'=>$full_path,
            		    'raw_name'=>$uploadData['raw_name'],
            		    'orig_name'=>$uploadData['orig_name'],
            		    'client_name'=>$uploadData['client_name'],
            		    'file_ext'=>$uploadData['file_ext'],
            		    'file_size'=>$uploadData['file_size'],
            		    'is_image'=>$uploadData['is_image'],
            		    'image_width'=>$uploadData['image_width'],
            		    'image_height'=>$uploadData['image_height'],
            		    'image_type'=>$uploadData['image_type'],
            		    'image_size_str'=>$uploadData['image_size_str'],
            		    'wid_id'=>1
                        ); 
                        
                     
                        
             $this->db->set('date', 'NOW()', FALSE);
             $this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully");
            $this->db->insert('add_services',$data); 
            $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'image_path'=>$picture,
		    'file_type'=>$uploadData['file_name'],
		    'file_path'=>$uploadData['file_path'],
		    'full_path'=>$full_path,
		    'raw_name'=>$uploadData['raw_name'],
		    'orig_name'=>$uploadData['orig_name'],
		    'client_name'=>$uploadData['client_name'],
		    'file_ext'=>$uploadData['file_ext'],
		    'file_size'=>$uploadData['file_size'],
		    'is_image'=>$uploadData['is_image'],
		    'image_width'=>$uploadData['image_width'],
		    'image_height'=>$uploadData['image_height'],
		    'image_type'=>$uploadData['image_type'],
		    'image_size_str'=>$uploadData['image_size_str'],
		    'service_id'=>$lastins_id
		    );  
		     //$this->db->where('id',$id1);
            $res=$this->db->insert('medialibrary',$params2);
            redirect('right-services');
           }
           else
           {
             
	    $data = array(  
	                    
	                    'ulbid' => $this->session->userdata('ulbid'),  
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
            		    'wid_id'=>1
                        ); 
                        
                     
                        
             $this->db->set('date', 'NOW()', FALSE);
             $this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully");
            $this->db->insert('add_services',$data); 
            $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'service_id'=>$lastins_id
		    );  
		     //$this->db->where('id',$id1);
            $res=$this->db->insert('medialibrary',$params2);
            redirect('right-services');
             
           }
	      }
           }
	    }
	   
	    /*       first id1  ending            */
	    
	   if(isset($_POST['submit2'])){
           $id2=$this->security->xss_clean(trim($this->input->post('id2')));
           if($id2!='')
           {
             
            
	        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            redirect('right-services');
            }
            else
            {
           if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'assets/uploads/'.$this->session->userdata('ulbid');
                 if (!file_exists($config['upload_path'])) {
                   mkdir($config['upload_path'], 0777, true);
                }
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);               
                if($this->upload->do_upload('picture'))
				{
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $full_path=base_url()."assets/uploads/".$this->session->userdata('ulbid').$picture;
                }
				else
				{
                    $picture = '';
                }
            }
			else
			{
            $picture = '';
            }
	    if($picture!='')
	    {
	       
	    $data = array(  
	                    'picture' => $picture,
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
                        'file_type'=>$uploadData['file_name'],
            		    'file_path'=>$uploadData['file_path'],
            		    'full_path'=>$full_path,
            		    'raw_name'=>$uploadData['raw_name'],
            		    'orig_name'=>$uploadData['orig_name'],
            		    'client_name'=>$uploadData['client_name'],
            		    'file_ext'=>$uploadData['file_ext'],
            		    'file_size'=>$uploadData['file_size'],
            		    'is_image'=>$uploadData['is_image'],
            		    'image_width'=>$uploadData['image_width'],
            		    'image_height'=>$uploadData['image_height'],
            		    'image_type'=>$uploadData['image_type'],
            		    'image_size_str'=>$uploadData['image_size_str'],
            		    'wid_id'=>2
                        ); 
                        
                     
                        
            $this->db->set('date', 'NOW()', FALSE);
            $this->db->where('id',$id2);
            $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
            $this->db->update('add_services',$data); 
           // $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'image_path'=>$picture,
		    'file_type'=>$uploadData['file_name'],
		    'file_path'=>$uploadData['file_path'],
		    'full_path'=>$full_path,
		    'raw_name'=>$uploadData['raw_name'],
		    'orig_name'=>$uploadData['orig_name'],
		    'client_name'=>$uploadData['client_name'],
		    'file_ext'=>$uploadData['file_ext'],
		    'file_size'=>$uploadData['file_size'],
		    'is_image'=>$uploadData['is_image'],
		    'image_width'=>$uploadData['image_width'],
		    'image_height'=>$uploadData['image_height'],
		    'image_type'=>$uploadData['image_type'],
		    'image_size_str'=>$uploadData['image_size_str']
		    
		    );   
		    $this->db->where('service_id',$id2);
            $res=$this->db->update('medialibrary',$params2);
            redirect('right-services');
	    }
	    else
	    {
	         $data = array(  
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text')))
                        ); 
            $this->db->set('date', 'NOW()', FALSE);
            $this->db->where('id',$id2);
            $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
            $this->db->update('add_services',$data); 
             redirect('right-services');
	    }
        }
    
               
           }
           else
           {
               $ulbid=$this->session->userdata('ulbid');
	        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            redirect('right-services');
            }
           else
            {
           if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'assets/uploads/'.$this->session->userdata('ulbid');
                 if (!file_exists($config['upload_path'])) {
                   mkdir($config['upload_path'], 0777, true);
                }
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);               
                if($this->upload->do_upload('picture'))
				{
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $full_path=base_url()."uploads/".$this->session->userdata('ulbid').$picture;
                }
				else
				{
                    $picture = '';
                }
            }
			else
			{
            $picture = '';
            }
	    
	     if($picture!='')
	     {
	    $data = array(  
	                    
	                    'ulbid' => $this->session->userdata('ulbid'),  
	                    'picture' => $picture,
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
                        'file_type'=>$uploadData['file_name'],
            		    'file_path'=>$uploadData['file_path'],
            		    'full_path'=>$full_path,
            		    'raw_name'=>$uploadData['raw_name'],
            		    'orig_name'=>$uploadData['orig_name'],
            		    'client_name'=>$uploadData['client_name'],
            		    'file_ext'=>$uploadData['file_ext'],
            		    'file_size'=>$uploadData['file_size'],
            		    'is_image'=>$uploadData['is_image'],
            		    'image_width'=>$uploadData['image_width'],
            		    'image_height'=>$uploadData['image_height'],
            		    'image_type'=>$uploadData['image_type'],
            		    'image_size_str'=>$uploadData['image_size_str'],
            		    'wid_id'=>2
                        ); 
                        
                     
                        
             $this->db->set('date', 'NOW()', FALSE);
             $this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully");
            $this->db->insert('add_services',$data); 
            $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'image_path'=>$picture,
		    'file_type'=>$uploadData['file_name'],
		    'file_path'=>$uploadData['file_path'],
		    'full_path'=>$full_path,
		    'raw_name'=>$uploadData['raw_name'],
		    'orig_name'=>$uploadData['orig_name'],
		    'client_name'=>$uploadData['client_name'],
		    'file_ext'=>$uploadData['file_ext'],
		    'file_size'=>$uploadData['file_size'],
		    'is_image'=>$uploadData['is_image'],
		    'image_width'=>$uploadData['image_width'],
		    'image_height'=>$uploadData['image_height'],
		    'image_type'=>$uploadData['image_type'],
		    'image_size_str'=>$uploadData['image_size_str'],
		    'service_id'=>$lastins_id
		    );  
		     //$this->db->where('id',$id1);
            $res=$this->db->insert('medialibrary',$params2);
            redirect('right-services');
             }
             else
             {
                
	    $data = array(  
	                    
	                    'ulbid' => $this->session->userdata('ulbid'),  
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
            		    'wid_id'=>2
                        ); 
                        
                     
                        
             $this->db->set('date', 'NOW()', FALSE);
             $this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully");
            $this->db->insert('add_services',$data); 
            $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'service_id'=>$lastins_id
		    );  
		     //$this->db->where('id',$id1);
            $res=$this->db->insert('medialibrary',$params2);
            redirect('right-services');
              
             }
            }
	      }
	    }
	    
	     /*    second id ending.........       */
	     
	     if(isset($_POST['submit3'])){
           $id3=$this->security->xss_clean(trim($this->input->post('id3')));
           if($id3!='')
           {
             
            
	        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            redirect('right-services');
            }
            else
            {
           if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'assets/uploads/'.$this->session->userdata('ulbid');
                 if (!file_exists($config['upload_path'])) {
                   mkdir($config['upload_path'], 0777, true);
                }
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);               
                if($this->upload->do_upload('picture'))
				{
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $full_path=base_url()."assets/uploads/".$this->session->userdata('ulbid').$picture;
                }
				else
				{
                    $picture = '';
                }
            }
			else
			{
            $picture = '';
            }
	    if($picture!='')
	    {
	       
	    $data = array(  
	                    'picture' => $picture,
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
                        'file_type'=>$uploadData['file_name'],
            		    'file_path'=>$uploadData['file_path'],
            		    'full_path'=>$full_path,
            		    'raw_name'=>$uploadData['raw_name'],
            		    'orig_name'=>$uploadData['orig_name'],
            		    'client_name'=>$uploadData['client_name'],
            		    'file_ext'=>$uploadData['file_ext'],
            		    'file_size'=>$uploadData['file_size'],
            		    'is_image'=>$uploadData['is_image'],
            		    'image_width'=>$uploadData['image_width'],
            		    'image_height'=>$uploadData['image_height'],
            		    'image_type'=>$uploadData['image_type'],
            		    'image_size_str'=>$uploadData['image_size_str'],
            		    'wid_id'=>3
                        ); 
                        
                     
                        
            $this->db->set('date', 'NOW()', FALSE);
            $this->db->where('id',$id3);
            $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
            $this->db->update('add_services',$data); 
           // $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'image_path'=>$picture,
		    'file_type'=>$uploadData['file_name'],
		    'file_path'=>$uploadData['file_path'],
		    'full_path'=>$full_path,
		    'raw_name'=>$uploadData['raw_name'],
		    'orig_name'=>$uploadData['orig_name'],
		    'client_name'=>$uploadData['client_name'],
		    'file_ext'=>$uploadData['file_ext'],
		    'file_size'=>$uploadData['file_size'],
		    'is_image'=>$uploadData['is_image'],
		    'image_width'=>$uploadData['image_width'],
		    'image_height'=>$uploadData['image_height'],
		    'image_type'=>$uploadData['image_type'],
		    'image_size_str'=>$uploadData['image_size_str']
		    
		    );   
		    $this->db->where('service_id',$id3);
            $res=$this->db->update('medialibrary',$params2);
            redirect('right-services');
	    }
	    else
	    {
	         $data = array(  
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text')))
                        ); 
            $this->db->set('date', 'NOW()', FALSE);
            $this->db->where('id',$id3);
            $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
            $this->db->update('add_services',$data); 
             redirect('right-services');
	    }
        }
    
               
           }
           else
           {
               $ulbid=$this->session->userdata('ulbid');
	        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            redirect('right-services');
            }
           else
            {
           if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'assets/uploads/'.$this->session->userdata('ulbid');
                 if (!file_exists($config['upload_path'])) {
                   mkdir($config['upload_path'], 0777, true);
                }
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);               
                if($this->upload->do_upload('picture'))
				{
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $full_path=base_url()."assets/uploads/".$this->session->userdata('ulbid').$picture;
                }
				else
				{
                    $picture = '';
                }
            }
			else
			{
            $picture = '';
            }
	    if($picture!='')
	    {
	    $data = array(  
	                    
	                    'ulbid' => $this->session->userdata('ulbid'),  
	                    'picture' => $picture,
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
                        'file_type'=>$uploadData['file_name'],
            		    'file_path'=>$uploadData['file_path'],
            		    'full_path'=>$full_path,
            		    'raw_name'=>$uploadData['raw_name'],
            		    'orig_name'=>$uploadData['orig_name'],
            		    'client_name'=>$uploadData['client_name'],
            		    'file_ext'=>$uploadData['file_ext'],
            		    'file_size'=>$uploadData['file_size'],
            		    'is_image'=>$uploadData['is_image'],
            		    'image_width'=>$uploadData['image_width'],
            		    'image_height'=>$uploadData['image_height'],
            		    'image_type'=>$uploadData['image_type'],
            		    'image_size_str'=>$uploadData['image_size_str'],
            		    'wid_id'=>3
                        ); 
                        
                     
                        
             $this->db->set('date', 'NOW()', FALSE);
             $this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully");
            $this->db->insert('add_services',$data); 
            $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'image_path'=>$picture,
		    'file_type'=>$uploadData['file_name'],
		    'file_path'=>$uploadData['file_path'],
		    'full_path'=>$full_path,
		    'raw_name'=>$uploadData['raw_name'],
		    'orig_name'=>$uploadData['orig_name'],
		    'client_name'=>$uploadData['client_name'],
		    'file_ext'=>$uploadData['file_ext'],
		    'file_size'=>$uploadData['file_size'],
		    'is_image'=>$uploadData['is_image'],
		    'image_width'=>$uploadData['image_width'],
		    'image_height'=>$uploadData['image_height'],
		    'image_type'=>$uploadData['image_type'],
		    'image_size_str'=>$uploadData['image_size_str'],
		    'service_id'=>$lastins_id
		    );  
		     //$this->db->where('id',$id3);
            $res=$this->db->insert('medialibrary',$params2);
            redirect('right-services');
           }
           else
           {
              
	    $data = array(  
	                    
	                    'ulbid' => $this->session->userdata('ulbid'),  
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
            		    'wid_id'=>3
                        ); 
                        
                     
                        
            $this->db->set('date', 'NOW()', FALSE);
            $this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully");
            $this->db->insert('add_services',$data); 
            $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'service_id'=>$lastins_id
		    );  
		     //$this->db->where('id',$id3);
            $res=$this->db->insert('medialibrary',$params2);
            redirect('right-services');
           } 
           }
           }
	      }
	    

	    /* thir id ending .........         */
	    
	       if(isset($_POST['submit4'])){
           $id4=$this->security->xss_clean(trim($this->input->post('id4')));
           if($id4!='')
           {
	        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            redirect('right-services');
            }
            else
            {
           if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'assets/uploads/'.$this->session->userdata('ulbid');
                 if (!file_exists($config['upload_path'])) {
                   mkdir($config['upload_path'], 0777, true);
                }
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);               
                if($this->upload->do_upload('picture'))
				{
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $full_path=base_url()."assets/uploads/".$this->session->userdata('ulbid').$picture;
                }
				else
				{
                    $picture = '';
                }
            }
			else
			{
            $picture = '';
            }
	    if($picture!='')
	    {
	       
	    $data = array(  
	                    'picture' => $picture,
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
                        'file_type'=>$uploadData['file_name'],
            		    'file_path'=>$uploadData['file_path'],
            		    'full_path'=>$full_path,
            		    'raw_name'=>$uploadData['raw_name'],
            		    'orig_name'=>$uploadData['orig_name'],
            		    'client_name'=>$uploadData['client_name'],
            		    'file_ext'=>$uploadData['file_ext'],
            		    'file_size'=>$uploadData['file_size'],
            		    'is_image'=>$uploadData['is_image'],
            		    'image_width'=>$uploadData['image_width'],
            		    'image_height'=>$uploadData['image_height'],
            		    'image_type'=>$uploadData['image_type'],
            		    'image_size_str'=>$uploadData['image_size_str'],
            		    'wid_id'=>4
                        ); 
            $this->db->set('date', 'NOW()', FALSE);
            $this->db->where('id',$id4);
            $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
            $this->db->update('add_services',$data); 
             $params2=array(
		    'image_path'=>$picture,
		    'file_type'=>$uploadData['file_name'],
		    'file_path'=>$uploadData['file_path'],
		    'full_path'=>$full_path,
		    'raw_name'=>$uploadData['raw_name'],
		    'orig_name'=>$uploadData['orig_name'],
		    'client_name'=>$uploadData['client_name'],
		    'file_ext'=>$uploadData['file_ext'],
		    'file_size'=>$uploadData['file_size'],
		    'is_image'=>$uploadData['is_image'],
		    'image_width'=>$uploadData['image_width'],
		    'image_height'=>$uploadData['image_height'],
		    'image_type'=>$uploadData['image_type'],
		    'image_size_str'=>$uploadData['image_size_str']
		    );   
		    $this->db->where('service_id',$id4);
            $res=$this->db->update('medialibrary',$params2);
            redirect('right-services');
	    }
	    else
	    {
	         $data = array(  
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text')))
                        ); 
            $this->db->set('date', 'NOW()', FALSE);
            $this->db->where('id',$id4);
            $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
            $this->db->update('add_services',$data); 
             redirect('right-services');
	    }
        }
    
               
           }
           else
           {
               $ulbid=$this->session->userdata('ulbid');
	        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            redirect('right-services');
            }
           else
            {
           if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'assets/uploads/'.$this->session->userdata('ulbid');
                 if (!file_exists($config['upload_path'])) {
                   mkdir($config['upload_path'], 0777, true);
                }
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);               
                if($this->upload->do_upload('picture'))
				{
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $full_path=base_url()."assets/uploads/".$this->session->userdata('ulbid').$picture;
                }
				else
				{
                    $picture = '';
                }
            }
			else
			{
            $picture = '';
            }
	    if($picture!='')
	    {
	    $data = array(  
	                    
	                    'ulbid' => $this->session->userdata('ulbid'),  
	                    'picture' => $picture,
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
                        'file_type'=>$uploadData['file_name'],
            		    'file_path'=>$uploadData['file_path'],
            		    'full_path'=>$full_path,
            		    'raw_name'=>$uploadData['raw_name'],
            		    'orig_name'=>$uploadData['orig_name'],
            		    'client_name'=>$uploadData['client_name'],
            		    'file_ext'=>$uploadData['file_ext'],
            		    'file_size'=>$uploadData['file_size'],
            		    'is_image'=>$uploadData['is_image'],
            		    'image_width'=>$uploadData['image_width'],
            		    'image_height'=>$uploadData['image_height'],
            		    'image_type'=>$uploadData['image_type'],
            		    'image_size_str'=>$uploadData['image_size_str'],
            		    'wid_id'=>4
                        ); 
                        
                     
                        
            $this->db->set('date', 'NOW()', FALSE);
            $this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully");
            $this->db->insert('add_services',$data); 
            $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'image_path'=>$picture,
		    'file_type'=>$uploadData['file_name'],
		    'file_path'=>$uploadData['file_path'],
		    'full_path'=>$full_path,
		    'raw_name'=>$uploadData['raw_name'],
		    'orig_name'=>$uploadData['orig_name'],
		    'client_name'=>$uploadData['client_name'],
		    'file_ext'=>$uploadData['file_ext'],
		    'file_size'=>$uploadData['file_size'],
		    'is_image'=>$uploadData['is_image'],
		    'image_width'=>$uploadData['image_width'],
		    'image_height'=>$uploadData['image_height'],
		    'image_type'=>$uploadData['image_type'],
		    'image_size_str'=>$uploadData['image_size_str'],
		    'service_id'=>$lastins_id
		    );  
		     //$this->db->where('id',$id4);
            $res=$this->db->insert('medialibrary',$params2);
            redirect('right-services');
           }
           else
           {
               $data = array(  
	                    
	                    'ulbid' => $this->session->userdata('ulbid'),  
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
            		    'wid_id'=>4
                        ); 
                        
                     
                        
            $this->db->set('date', 'NOW()', FALSE);
            $this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully");
            $this->db->insert('add_services',$data); 
            $lastins_id=$this->db->insert_id();
            
             $params2=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'service_id'=>$lastins_id
		    );  
		     //$this->db->where('id',$id4);
            $res=$this->db->insert('medialibrary',$params2);
            redirect('right-services');
           }
           }
	      }
	    }
	    }
	    else
	    {
	        redirect('login');
	    }
	    
	    
	}
	
	public function edit_service($id)
	{
	    
	    
	      if($this->session->userdata('session_id')==session_id())
	    {
	    $submenudata=array();
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
	    $subMenus=$this->MenuModel->getSubMenu();
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    
	    $data['sub_menus']=$submenudata;
	    
	    $customMenus=$this->MenuModel->getCustomMenu();
	    
	    if(count($customMenus) > 0)
	    {
    	    foreach($customMenus as $key=>$val)
    	    {
    	        //$customemenudata[$val['main_menu_id']][$val['page_id']]['page_name']=$val['page_name'];
    	        //$customemenudata[$val['main_menu_id']][$val['page_id']]['controller']=$val['controller'];
    	    }
	    
	   
	        //$data['custom_menus']=$customemenudata;
	    }
	    
	   // $this->breadcrumbcomponent->add('Home', base_url());
        //$this->breadcrumbcomponent->add('Tutorials', base_url().'tutorials');  
        //$this->breadcrumbcomponent->add('Spring Tutorial', base_url().'tutorials/spring-tutorials');
	    
	    
	      if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'assets/uploads/'.$this->session->userdata('ulbid');
                 if (!file_exists($config['upload_path'])) {
                   mkdir($config['upload_path'], 0777, true);
                }
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);               
                if($this->upload->do_upload('picture'))
				{
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $full_path=base_url()."assets/uploads/".$this->session->userdata('ulbid').$picture;
                    
                    
                    
                }
				else
				{
                    $picture = '';
                }
            }
			else
			{
            $picture = '';
            }
	     $id=$this->security->xss_clean(trim($this->input->post('menuid')));
      
	    $getservice['edit_ser']=$this->MenuModel->edit_service($id);
	    //print_r($getservice);
	    //exit;
	    $this->load->view('header',$data);
		$this->load->view('edit_rightservice',$getservice);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	    
	    
	    
	}

public function update()
{
     if($this->session->userdata('session_id')==session_id())
	    {
    
    
          $idss=$this->security->xss_clean(trim($this->input->post('ids')));
          
          if(!empty($idss))
          {
          
        $img=$this->MenuModel->selt_image($idss);
 if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'assets/uploads/'.$this->session->userdata('ulbid');
                 if (!file_exists($config['upload_path'])) {
                   mkdir($config['upload_path'], 0777, true);
                }
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);               
                if($this->upload->do_upload('picture'))
				{
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $full_path=base_url()."assets/uploads/".$this->session->userdata('ulbid').$picture;
                }
				else
				{
                    $picture = '';
                }
            }
			else
			{
            $picture = '';
            }
            if($picture!='')
            {
	    $data = array(  
	                    'picture' => $picture,
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text'))),
                        'file_type'=>$uploadData['file_name'],
            		    'file_path'=>$uploadData['file_path'],
            		    'full_path'=>$full_path,
            		    'raw_name'=>$uploadData['raw_name'],
            		    'orig_name'=>$uploadData['orig_name'],
            		    'client_name'=>$uploadData['client_name'],
            		    'file_ext'=>$uploadData['file_ext'],
            		    'file_size'=>$uploadData['file_size'],
            		    'is_image'=>$uploadData['is_image'],
            		    'image_width'=>$uploadData['image_width'],
            		    'image_height'=>$uploadData['image_height'],
            		    'image_type'=>$uploadData['image_type'],
            		    'image_size_str'=>$uploadData['image_size_str']
                        ); 
                        
                     $params2=array(
		    'image_path'=>$picture,
		    'file_type'=>$uploadData['file_name'],
		    'file_path'=>$uploadData['file_path'],
		    'full_path'=>$full_path,
		    'raw_name'=>$uploadData['raw_name'],
		    'orig_name'=>$uploadData['orig_name'],
		    'client_name'=>$uploadData['client_name'],
		    'file_ext'=>$uploadData['file_ext'],
		    'file_size'=>$uploadData['file_size'],
		    'is_image'=>$uploadData['is_image'],
		    'image_width'=>$uploadData['image_width'],
		    'image_height'=>$uploadData['image_height'],
		    'image_type'=>$uploadData['image_type'],
		    'image_size_str'=>$uploadData['image_size_str']
		    );      
                $this->db->where('id',$idss);
               $res=$this->db->update('add_services',$data);
               $this->db->where('service_id',$idss);
               $this->db->update('medialibrary',$params2);  
               $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
               redirect('right-services');
            }
            else
            {
                  $data = array(  
                        'title'=> $this->security->xss_clean(trim($this->input->post('service_title'))),
                        'page_link'=> $this->security->xss_clean(trim($this->input->post('page_link'))),
                        'image_title'=> $this->security->xss_clean(trim($this->input->post('img_title'))),
                        'window'=> $this->security->xss_clean(trim($this->input->post('window'))),
                        'image_text'=> $this->security->xss_clean(trim($this->input->post('img_text')))
                        );
                          $this->db->where('id',$idss);
               $res=$this->db->update('add_services',$data);
                $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
               redirect('right-services');
            }
                    
                    
          }
          else
          {
              die('Invalid Details');
          }
    
	    }
	    else
	    {
	        redirect('login');
	    }
}


}
