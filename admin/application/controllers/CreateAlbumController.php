<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateAlbumController extends CI_Controller {

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
	    $this->load->model('CreateAlbumModel');
	    $this->load->library('form_validation');
	    
	 }
	 
	 public function updateContent()
	 {
	     
	     if($this->session->userdata('session_id')==session_id())
	     {
	         
	     $params=array(
	         'album_id'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('id'))))),
	         'album_desc'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('value'))))),
	         'album_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('title')))))
	         );
	    
	    $result=$this->CreateAlbumModel->updateContent($params);
	    return $result;
	     }
	     else
	     {
	         redirect('Login');
	     }
	 }
	 
	 public function deleteContent()
	 {
	     if($this->session->userdata('session_id')==session_id())
	     {
	       
	     
	     $params=array('album_id'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('album_id'))))));
	     $result=$this->CreateAlbumModel->deleteContent($params);
	     echo $result;
	     
	     }
	     else
	     {
	         redirect('Login');
	     }
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
	    
	    
	    $data['albumdata']=$this->CreateAlbumModel->getalbumData($params);
	    
	    if($this->input->post('save'))
	        {
	            
	            
	             $this->form_validation->set_rules('album_name', 'Enter Album Name', 'trim|required|min_length[1]|max_length[20]');
            
             $this->form_validation->set_rules('album_desc', 'Enter Album Description', 'trim|required|min_length[1]|max_length[500]');
            
             
             if ($this->form_validation->run() == FALSE)
                {
                    
                        $this->session->set_flashdata('message','Please fill all required fields');
	                   redirect('create-photo-gallery');
                }
                else
                {
                        
	            $params=array(
	                'album_desc'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('album_name'))))),
	                'ulbid'=>$this->security->xss_clean(trim($this->session->userdata('ulbid'))),
	                'album_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('album_desc')))))
	                );
	            $result=$this->CreateAlbumModel->albumDataInsert($params);
	            if($result)
	            {
	                $this->session->set_flashdata('message','Album created successfully');
	                redirect('create-photo-gallery');
	            }
	            else
	            {
	                $this->session->set_flashdata('message','Unable to create , Please try again');
	            }
	            redirect('create-photo-gallery');
                }
	            
	        }
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    
	    $this->load->view('header',$data);
		$this->load->view('createalbum',$data['albumdata']);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	function editalbam()
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
	    
	    
	    $data['albumdata']=$this->CreateAlbumModel->getalbumData($params);
	    
	    if($this->input->post('save'))
	        {
	           
	           
	             $this->form_validation->set_rules('album_name', 'Enter Album Name', 'trim|required|min_length[1]|max_length[20]');
            
             $this->form_validation->set_rules('album_desc', 'Enter Album Description', 'trim|required|min_length[1]|max_length[500]');
            
             
             if ($this->form_validation->run() == FALSE)
                {
                        //$this->load->view('myform');
                }
                else
                {
                        
	            $params=array(
	                'album_desc'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('album_name'))))),
	                'ulbid'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('ulbid'))))),
	                'album_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('album_desc')))))
	                );
	            $result=$this->CreateAlbumModel->albumDataInsert($params);
	            if($result)
	            {
	                $this->session->set_flashdata('message','Album created successfully');
	            }
	            else
	            {
	                $this->session->set_flashdata('message','Unable to create , Please try again');
	            }
	            redirect('Edit-albam');
                }
	            
	        }
	    
	    $data['edit_albam']=$this->CreateAlbumModel->getalbumData($params);
	    
	    $this->load->view('header',$data);
		$this->load->view('edit_albam',$data['edit_albam']);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	 function updatealbam(){
	     
	     if($this->session->userdata('session_id')==session_id())
	     {
	    
	     if($this->input->post('update'))
	     
	        {
	            
	             $this->form_validation->set_rules('album_name','Album Name','required');
        	     $this->form_validation->set_rules('album_desc','Album Description','required|maxlenght[20]');
        	     if($this->form_validation->run()==FALSE)
        	     {
        	      $album_id=$this->input->post('album_id');
        	       
        	         $params=array(
        	            
        	             'album_title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('album_name'))))),
        	             'album_desc'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('album_desc')))))
        	             //'author'=>$this->session->userdata('username'),
        	             //'flag'=>1
        	             
        	             );
        	             
        	             $result=$this->CreateAlbumModel->albamdata($params,$album_id);
        	             if($result)
        	             {
        	                 $this->session->set_flashdata('message','Album updated successfuly');
        	                 redirect('create-album');
        	             }
        	             else
        	             {
        	                 $this->session->set_flashdata('message','Unable to add Pls try again');
        	             }
        	             
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
	
	function fech()
	{
	    if($this->session->userdata('session_id')==session_id())
	     {
	         
	         if(strip_tags($this->input->post('id')))
	         {
        	    $id = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->post('id')))));
        	    
        	    
        	    $result=$this->CreateAlbumModel->get_edits($id);
        	    $data=array();
        	    foreach($result as $key=>$value)
        	    {
        	      $data[0]=$value->album_title;
        	      $data[1]=$value->album_desc;
        	       
        
        	       // print_r($data
        	         
        	    }
        	    
        	    $data_view=$data;
        	    $this->load->view('createalbum',$data_view);
        	    //print_r($data_view);
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
