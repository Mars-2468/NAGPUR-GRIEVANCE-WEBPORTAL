<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class VideosController extends MY_Controller {

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
	    //
	    $this->load->model('VideosModel');
	 }
	 
	 
	 
	 public function deleteContent()
	 {
	     
	     $params=array('video_id'=>$this->input->post('slide_id'));
	     $result=$this->VideosModel->deleteContent($params);
	     echo $result;
	 }
	 
	
	 
	public function index()
	{
	   
		if (!in_array($this->session->userdata('userid'),['superadmin'])) {
			$this->session->set_flashdata('error_message','Sorry you dont have permissions');
			//echo "Error: Sorry you don't have permissions!" ;
			redirect ('dashboard');
			exit;
		}
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	        
	        if($this->input->post('save'))
	        {
	            
	            if(!empty($this->input->post('videono')))
	            {
	                
	                $params=array();
	                $errors=array();
	                $i=1;
	                $j=0;
	                
	                
	                
	                foreach($this->input->post('videono') as $value)
	                {
	                   $videoTitle = htmlspecialchars(strip_tags($this->input->post('desc')[$j]));
	                    if($value=='')
	                    {
	                        $errors[]=$i;
	                        
	                    }
	                    
	                    //$embedCode = $this->security->xss_clean(trim(strip_tags($value)));
	                    $embedCode = $value;
                        preg_match('/src="([^"]+)"/', $embedCode, $match);

                        // Extract video url from embed code
                        $videoURL = $match[1];
	                    
	                    
	                    
	                    $url = $value;
                        $value2 = explode("v=", $url);
                        $videoId = strip_tags($value2[1]);
                        
                        if(!empty($videoId))
                        {
                        $thumbnail="https://img.youtube.com/vi/$videoId/hqdefault.jpg";
                        $is_iframe=0;
                        }
                        else
                        {
                            $thumbnail=strip_tags($videoURL);
                            $is_iframe=1;
                        }
                        
                        if($thumbnail =='')
                        {
                            $thumbnail=strip_tags($value);
                            $is_iframe=2;
                        }
                            
                            
                            
	                    
	                    
	                    
	                    
	                    $data=array(
	                        
	                        'ulbid'=>$this->session->userdata('ulbid'),
	                        'link_url'=>htmlspecialchars(strip_tags($value)),
	                        'posted_by'=>$this->session->userdata('username'),
	                        'thumbnail_url'=>htmlspecialchars(strip_tags($thumbnail)),
	                        'is_iframe'=>$is_iframe,
	                        'videoTitel'=>$videoTitle
	                        );
	                        if($value !='')
	                        {
	                        array_push($params,$data);
	                        }
	                        $i++;
	                        $j++;
	                }
	                
	                
	                
	                
	                if(count($params) > 0)
	                {
	                $result=$this->VideosModel->insertVideos($params);
	                }
	                if($result)
	                {
	                    $this->session->set_flashdata('message','Videos added successfully');
	                }
	                else
	                {
	                    $this->session->set_flashdata('message','Unable to add. Please try again');
	                }
	            }
	          
	        }
	        
	        
	        
	        
	        
	        
	        
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
	   // $customMenus=$this->MenuModel->getCustomMenu();
	    
	   // if(count($customMenus) > 0)
	   // {
    // 	    foreach($customMenus as $key=>$val)
    // 	    {
    // 	        $customemenudata[$val['main_menu_id']][$val['page_id']]['page_name']=$val['page_name'];
    // 	        $customemenudata[$val['main_menu_id']][$val['page_id']]['controller']=$val['controller'];
    // 	    }
	    
	   
	   //     $data['custom_menus']=$customemenudata;
	   // }
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $data['videos']=$this->VideosModel->getVideos($params);
	    
	    
	   
	    
	    
	    
	    
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('videogallery',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
