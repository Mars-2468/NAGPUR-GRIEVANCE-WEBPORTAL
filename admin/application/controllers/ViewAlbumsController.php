<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);


class ViewAlbumsController extends MY_Controller {

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
	     $this->load->model('ViewAlbumModel');
	 }
	 
	 public function addAlbum()
	 {
	     
	     
	      
	    if($this->session->userdata('session_id')==session_id())
	    {
	        //$this->form_validation->set_rules('albumname', 'albumname', 'required');
	        
          
	   
	         
	         $params=array(
    	         'ulbid'=>$this->session->userdata('ulbid'),
    	         'album_desc'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9_]/', ' ', htmlspecialchars(strip_tags($this->input->get('albumname')))))),
    	         'author'=>$this->session->userdata('username'),
    	         'lastUpdatedBy'=>$this->session->userdata('username'),
    	         'Date'=>date('Y-m-d',strtotime(htmlspecialchars(strip_tags($this->input->get('cdate')))))
    	       
    	        
    	         
    	         );
    	         //print_r($params);
    	         $result=$this->ViewAlbumModel->addAlbum($params);
    	         file_put_contents('query.txt',$this->db->last_query()) ;exit;
    	        
	     
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 public function getAlbumList()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    { 
	    
	    $albumList['albumList']=array();
	    $countList=array();
	       
	        $params=array('ulbid'=>$this->session->userdata('ulbid'));
	        
	        $result=$this->ViewAlbumModel->getAlbumList($params);
	        
	      
	        
	         foreach($result['countList'] as $key=>$val)
	            {
	                $counts[$val['album_id']]['count']=$val['photosCount'];
	                //$counts[$val['album_id']]['updatedBy']=$val['updatedBy'];
	            }
	            
	        foreach($result['updatedList'] as $key=>$val){
	            $counts[$val['album_id']]['ts1']=$val['ts1'];
	            $counts[$val['album_id']]['updatedBy1']=$val['updatedBy1'];
	            $counts[$val['album_id']]['album_id1']=$val['album_id'];
	        }  
	        
	        foreach($result['albumList'] as $albumId=>$array1)
	        {
	            
	           $array1['photosCount']=$counts[$array1['album_id']]['count'];
	           //$array1['updatedBy1']=$counts[$array1['album_id']]['updatedBy1'];
	           //$array1['ts1']=$counts[$array1['album_id']]['ts1'];
	           //$array1['album_id1']=$counts[$array1['album_id']]['album_id1'];
	            array_push($albumList['albumList'],$array1);
	       }
	       
	       
	      
	        echo json_encode($albumList);
	        //echo json_encode($result['countList']);
	        
}
else
{
    redirect('login');
}
	    
	 }
	 
	 
	 public function addSubAlbum()
	 {
	     $albumId = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('album_id')))));
	     $subalbumName = $this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('subalbumname')))));
	     if(!empty($albumId) && !empty($subalbumName) )
	     {
	         $params = array(
	             'album_id'=>$albumId,
	             'album_desc'=>$subalbumName,
	             'ulbid'=>$this->session->userdata('ulbid'),
	             'album_title'=>$subalbumName,
	             'langId'=>$this->session->userdata('langId'),
	             'author'=>$this->session->userdata('userid'),
	             'lastUpdatedBy'=>$this->session->userdata('userid'),
	             );
	             
	        $result=$this->ViewAlbumModel->addSubAlbum($params);
	        
	        if($result)
	        {
	            echo "<div class='alert alert-success'>Sub album added successfully</div>";
	        }
	        else
	        {
	            echo "<div class='alert alert-danger'>Error , Try again</div>";
	        }
	     }
	     else
	     {
	         echo "Album id and Sub album name are required";
	     }
	     
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
	    $submenudata=array();
	    $data['main_menu_list']=$this->MenuModel->getMainMenu();
	    $subMenus=$this->MenuModel->getSubMenu();
	    foreach($subMenus as $key=>$val)
	    {
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['submenuname']=$val['sub_menu_desc'];
	        $submenudata[$val['main_menu_id']][$val['sub_menu_id']]['SubcontrollerName']=$val['SubcontrollerName'];
	    }
	    
	    $data['sub_menus']=$submenudata;
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    
	    /** albums list ****/
	    $params = array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['albums_list'] = $this->ViewAlbumModel->getAlbums($params);
	    $data['sub_albums_list'] = $this->ViewAlbumModel->getSubAlbums($params);
	    /** albums list close ****/
	    
	     $params=array('ulbid'=>$this->session->userdata('ulbid'));
	        
	        $result=$this->ViewAlbumModel->getAlbumList($params);
	        
	      
	        
	         foreach($result['countList'] as $key=>$val)
	            {
	                $data['counts'][$val['album_id']]['count']=$val['photosCount'];
	                //$counts[$val['album_id']]['updatedBy']=$val['updatedBy'];
	            }
	    
	 
	  
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('viewalbums');
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	public function checkingAlbumName()
	{
	    
	    if($this->session->userdata('session_id')==session_id())
	    { 
	    $params = array(
            'ulbid'=>$this->session->userdata('ulbid'),
            'album_desc'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9_]/', ' ', htmlspecialchars(strip_tags($this->input->get('album_desc'))))))
        );
        
        $result = $this->ViewAlbumModel->checkingAlbumName($params);
        echo json_encode($result);
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	public function updateAlbumName()
	{
	    
	    if($this->session->userdata('session_id')==session_id())
	    { 
	    $params = array(
	        'album_id'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('album_id'))))),
            'ulbid'=>$this->security->xss_clean(trim($this->session->userdata('ulbid'))),
            'album_desc'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9_]/', ' ', htmlspecialchars(strip_tags($this->input->get('album_desc')))))),
            'updatedBy'=>$this->session->userdata('username')
        );
        
        $result=$this->ViewAlbumModel->updateAlbumName($params);
        echo json_encode($result);
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	
	public function getAlbumName()
	{
	    
	  if($this->session->userdata('session_id')==session_id())
	    {   
	    
	    $params = array(
	        'album_id'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('album_id'))))),
            'ulbid'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('ulbid')))))
	        );
	   $result = $this->ViewAlbumModel->getAlbumName($params);
	   echo Json_encode($result);
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	
	
	public function deleteAlbum()
	{
	    
	    if($this->session->userdata('session_id')==session_id())
	    { 
	    
	    $params = array(
	        'album_id'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('album_id'))))),
            'ulbid'=>$this->session->userdata('ulbid')   
	    );
	    
	    $result=$this->ViewAlbumModel->deleteAlbum($params);
        echo $result;
        if($result > 0)
        {
        echo 1;
        }
        else
        {
            echo 0;
        }
	    }
	    else
	    {
	        redirect('login');
	    }
      
	}
}
