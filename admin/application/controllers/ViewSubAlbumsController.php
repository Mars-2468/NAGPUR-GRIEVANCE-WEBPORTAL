<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);


class ViewSubAlbumsController extends CI_Controller {

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
	     
	     $params=array(
	         'ulbid'=>$this->session->userdata('ulbid'),
	         'album_desc'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9_]/', ' ', $this->input->get('albumname')))),
	         'author'=>$this->session->userdata('username'),
	         'lastUpdatedBy'=>$this->session->userdata('username')
	         );
	         $result=$this->ViewAlbumModel->addAlbum($params);
	         echo $result;
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
	     $albumId = $this->security->xss_clean(trim(strip_tags($this->input->get('album_id'))));
	     $subalbumName = $this->security->xss_clean(trim(strip_tags($this->input->get('subalbumname'))));
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
	    $albums_photos_count = $this->ViewAlbumModel->getAlbumsPhotosCount($params);
	    
	   foreach($albums_photos_count->result() as $key=>$val)
	   {
	       $data['album_photos_count'][$val->album_id][$val->sub_album_id]['count'] = $val->count;
	   }
	    
	    
	    $sub_albums_list_obj = $this->ViewAlbumModel->getSubAlbums($params);
	    foreach($sub_albums_list_obj->result() as $key=>$val)
	    {
	        $data['sub_album_list'][$val->album_id][$val->sub_album_id]['sub_album_name'] = $val->album_desc;
	        $data['sub_album_list'][$val->album_id][$val->sub_album_id]['lastUpdatedBy'] = $val->lastUpdatedBy;
	        $data['sub_album_list'][$val->album_id][$val->sub_album_id]['lastUpdatedTS'] = date('d-m-Y H:i:s',strtotime($val->lastUpdatedTS));
	    }
	    
	    
	    /** albums list close ****/
	    
	  
	  
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('viewsubalbums');
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
            'album_desc'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9_]/', ' ', $this->input->get('album_desc'))))
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
	        'album_id'=>$this->security->xss_clean(trim($this->input->post('album_id'))),
            'ulbid'=>$this->security->xss_clean(trim($this->session->userdata('ulbid'))),
            'album_desc'=>$this->security->xss_clean(trim(preg_replace('/[^A-Za-z0-9_]/', ' ', $this->input->post('album_desc')))),
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
	        'album_id'=>$this->security->xss_clean(trim($this->input->post('album_id'))),
            'ulbid'=>$this->security->xss_clean(trim($this->session->userdata('ulbid')))
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
	        'album_id'=>$this->security->xss_clean(trim($this->input->post('album_id'))),
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
