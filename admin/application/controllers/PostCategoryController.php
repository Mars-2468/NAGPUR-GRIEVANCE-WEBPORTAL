<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class PostCategoryController extends MY_Controller {

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
	     ini_set('display_errors',0);
	     Parent::__construct();
	     $this->load->model('PostsCategoryModel');
	     $this->load->model('CreatePostModel');
	     $this->load->library('form_validation');
	     $this->load->model('HomesliderModel');
	 }
	public function index()
	{
	    
	     if($this->session->userdata('session_id')==session_id())
	    {
	    $submenudata=array();
	    
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
	    $subMenus=$this->MenuModel->getSubMenu();
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    //$data['aboutData']=$aboutData=$this->AboutModel->getaboutData($params);
	   
	    
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    $data['sub_menus']=$submenudata;
	    
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    
	    
	    $data['sliderList']=$this->HomesliderModel->getSliderList($params);
	    $data['languageList']=$this->MenuModel->getLanguages($params);
        $getservice['report']=$this->PostsCategoryModel->select();
	    
	    $this->load->view('header',$data);
		$this->load->view('postscategory',$getservice);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	    
	    
	  
	}
	public function checkingcatInfo(){
	    
	    if($this->session->userdata('session_id')==session_id())
    	    {
    	        if($this->security->xss_clean(trim($this->input->post('id'))))
    	        {
	    
            	    $params = array('page_name'=>$this->security->xss_clean(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('md_cat_name'))))),
            	                    'langId'=>$this->session->userdata('langId'),
                                    'ulbid'=>$this->session->userdata('ulbid')
            	    );
            	    $result = $this->PostsCategoryModel->checkingcatInfo($params);
            	    echo json_encode($result);
    	        }
    	        else
    	        {
    	           redirect('Login'); 
    	        }
    	    }
    	    else
    	    {
    	        redirect('Login');
    	    }
	}
	
	public function updatecatInfo(){
	    
	    if($this->session->userdata('session_id')==session_id())
    	    {
    	        if($this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('id'))))))
    	        {
	    
                        $params = array('page_id'=>$this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id')))),
                                        'page_name'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('md_cat_name')))))),
                	                    'langId'=>$this->session->userdata('langId'),
                                        'ulbid'=>$this->session->userdata('ulbid')
                	    );
                	    $result = $this->PostsCategoryModel->updatecatInfo($params);
                	    echo json_encode($result);
    	        }
    	        else
    	        {
    	           redirect('Login'); 
    	        }
    	    }
    	    else
    	    {
    	        redirect('Login');
    	    }
	}
	
	public function deletecatInfo(){
	    
	    if($this->session->userdata('session_id')==session_id())
    	    {
    	        if($this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('id'))))))
    	        {
	    
            	    $params = array('page_id'=>$this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id')))));
            	    $result = $this->PostsCategoryModel->deletecatInfo($params);
            	    echo json_encode($result);
    	        }
    	        else
    	        {
    	           redirect('Login'); 
    	        }
    	    }
    	    else
    	    {
    	        redirect('Login');
    	    }
	}
	
	public function getcatInfo(){
	    
	    if($this->session->userdata('session_id')==session_id())
    	    {
    	        if($this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('id'))))))
    	        {
	    
                	    $params = array(
                	        'page_id'=>$this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id')))),
                            'ulbid'=>$this->session->userdata('ulbid')
                	        );
                	    $result = $this->PostsCategoryModel->getcatInfo($params);
                	    echo json_encode($result);
    	        }
    	        else
    	        {
    	           redirect('Login'); 
    	        }
    	    }
    	    else
    	    {
    	        redirect('Login');
    	    }
	}
	
	public function gettingcatInfo(){
	    
	     if($this->session->userdata('session_id')==session_id())
    	    {
    	        if($this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('id'))))))
    	        {
    	    
            	    $params = array('page_id'=>$this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id')))));
            	    $result = $this->PostsCategoryModel->gettingcatInfo($params);
            	    echo json_encode($result);
    	        }
    	        else
    	        {
    	           redirect('Login'); 
    	        }
    	    }
    	    else
    	    {
    	        redirect('Login');
    	    }
	}
	function add_cat()
	{
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	    
	    
              if($this->input->post('submit'))
              {
                      $this->form_validation->set_rules('cat_name', 'Category Name', 'required');
                      if ($this->form_validation->run() == FALSE){
                      $this->session->set_flashdata('errors', validation_errors());
                      redirect('create-category'); 
                      }
                      else
                      {
                          
                          
                          if($this->session->userdata('langId')==1)
                	        {
                	            $pagename=substr($this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('cat_name')))),0,20)));
                	        }
                	        else
                	        {
                	            $pagename=rand(1,10000);
                	            $pagename=substr(md5($pagename),0,20);
                	        }
                          
                          $pagename=str_replace(" ", "-", $pagename);
                          $permalink='';
                          
                            $params=array(
                                
                                'ulbid'=>$this->session->userdata('ulbid'),
                                'page_title'=>$this->security->xss_clean(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('cat_name'))))),
                                'page_name'=>$this->security->xss_clean(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('cat_name'))))),
                                'content'=>$this->security->xss_clean(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('cat_name'))))),
                                'controller'=>$pagename,
                                'is_draft'=>0,
                                'is_custumlink'=>3,
                                'datetime'=>date('Y-m-d H:i:s'),
                                'langId'=>$this->session->userdata('langId'),
                                'permalink'=>$permalink,
                                'author'=>$this->session->userdata('username')
                                );
                                
                                $data1=$this->CreatePostModel->customePageDataInsert($params);
                                
                               
            	        if($data1['result']=='1')
            	        {
            	            $pagename="'".$pagename."'";
            	            $configFilePath=$_SERVER['DOCUMENT_ROOT'].'/NMC_NEW/admin/application/config/routes.php';
            				$file=fopen($configFilePath,'a') or die('cannot append to file');
            			
            				$controllerNameNoextension='CustomePageController/getPageContent/'.$data1['pageId'];
            				$controller='$route['.$pagename.']='."'".$controllerNameNoextension."';";
            				fwrite($file,"\n".$controller);
            				fclose($file);
            				$this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully");
            				redirect('create-category');
            				
            	        }
                                
                         
                      }
              }
              else
              {
                  redirect('Login');
              }
          
         }
         else
         {
             redirect('Login');
         }
	}
	function edit_Cat()
	{
	    if($this->session->userdata('session_id')==session_id())
	    {
	        if($this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('catid'))))))
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
        	    
        	    
                $id=$this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('catid'))));
              
        	    $getcat['edit']=$this->PostsCategoryModel->edit_cat($id);
        	    $data['languageList']=$this->MenuModel->getLanguages($params);
        
        	    $this->load->view('header',$data);
        		$this->load->view('edit_categories',$getcat);
        		$this->load->view('footer');
	        }
	        else
	        {
	            redirect('login');
	        }
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
  function update_cat()
	{
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	    
        	      $id = $this->security->xss_clean($this->uri->segment(3));
        	  
                  if(isset($_POST['update']))
                  {
                          $this->form_validation->set_rules('cat_name', 'cat_name', 'required');
                          if ($this->form_validation->run() == FALSE){
                          $this->session->set_flashdata('errors', validation_errors());
                          redirect('create-category'); 
                          }
                          else
                          {
                        $data2 = array(  
                        'page_name'=>$this->security->xss_clean(preg_replace('/[^A-Za-z0-9]/', ' ', htmlspecialchars(strip_tags($this->input->post('cat_name')))))
                        ); 
                      
                         $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
                         $edit_linl=$this->PostsCategoryModel->update_cat($data2,$id);
                         redirect('create-category'); 
                          }
                 }
                 else
                 {
                     redirect('login');
                 }
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	
}
