<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateNewsController extends MY_Controller {

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
	    $this->load->library('form_validation');
	    
	 }
	public function index()
	{
	    
	   
	    
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	    
	    
	     if($this->input->post('save') || $this->input->post('is_draft'))
	    {
	        //$content=str_replace("'", "\'", $this->input->post('content'));
	        $content=$this->security->xss_clean(strip_tags($this->input->post('content')));
	        $pagename=substr($this->security->xss_clean(strip_tags($this->input->post('pagename'))),0,20);
            $pagename=str_replace(" ", "-", $pagename);
            //$permalink=base_url() . "/" .$pagename;
            $permalink="http://municipalservices.in/sites/" .$pagename;
            $this->session->set_flashdata('permalink',$permalink);
            
            $this->form_validation->set_rules('pagename', 'Pagename', 'trim|required');
            $this->form_validation->set_rules('pagetitle', 'pagetitle', 'trim|required');
            $this->form_validation->set_rules('ptags', 'ptags', 'trim|required');
            
            
          
            
            
             if ($this->form_validation->run() == FALSE)
                {
                        
                }
                else
                {
                        
                
            
            
	       
	            
	            $params=array(
	            'ulbid'=>$this->session->userdata('ulbid'),
	            'content'=>$content,
	             'controller'=>$this->security->xss_clean(trim($pagename)),
	             'is_draft'=>$this->security->xss_clean(trim(strip_tags($this->input->post('is_draft')))),
	           'page_name'=>$this->security->xss_clean(trim(strip_tags($this->input->post('pagename')))),
	           'page_title'=>$this->security->xss_clean(trim(strip_tags($this->input->post('pagetitle')))),
	           'pagekeywords'=>$this->security->xss_clean(trim(strip_tags($this->input->post('ptags')))),
	           'is_custumlink'=>$this->security->xss_clean(trim(strip_tags($this->input->post('is_custumlink')))),
	           'fromDate'=>date('Y-m-d',strtotime(strip_tags($this->input->post('fromDate')))),
	           'toDate'=>date('Y-m-d',strtotime(strip_tags($this->input->post('toDate')))),
	           'datetime'=>date('Y-m-d'),
	           'langId'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('langId')))),
	           'permalink'=>$this->security->xss_clean(trim(strip_tags($permalink))),
	           'author'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('username'))))
	           
	           );
	           
	           
	            
	            
	            
	        $data1=$this->CreatePostModel->customePageDataInsert($params);
	        if($data1['result']=='1')
	        {
	            $pagename="'".$pagename."'";
	            $configFilePath=$_SERVER['DOCUMENT_ROOT'].'/sites/admin/application/config/routes.php';
	            $configFilePath2=$_SERVER['DOCUMENT_ROOT'].'/sites/application/config/routes.php';
				$file=fopen($configFilePath,'a') or die('cannot append to file');
			
				$controllerNameNoextension='CustomePageController/getPageContent/'.$data['pageId'];
				$controller='$route['.$pagename.']='."'".$controllerNameNoextension."';";
				fwrite($file,"\n".$controller);
				fclose($file);
				
				$file=fopen($configFilePath2,'a') or die('cannot append to file');
			
				$controllerNameNoextension='CustomePageController/getPageContent/'.$data['pageId'];
				$controller='$route['.$pagename.']='."'".$controllerNameNoextension."';";
				fwrite($file,"\n".$controller);
				fclose($file);
				
				if(!empty($this->input->post('categories')))
				{
				    foreach($this->input->post('categories') as $val)
				    {
				        $params=array(
				            'category_id'=>$val,
				            'page_id'=>$data1['pageId'],
				            'flag'=>1
				            );
				            
				        $this->CreatePostModel->mapCategoryPost($params);    
				        
				    }
				}
	            
	            
	            $this->session->set_flashdata('message','Post created successfully');
	        }
	        else
	        {
	            $this->session->set_flashdata('message','Unable to create post , Please try again');
	            
	        }
	        
	    }
	}
	    
	    
	    
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
	    $data['categories']=$this->CreatePostModel->getPostCategories($params);
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    
	 
	      
	    
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('createnews',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
