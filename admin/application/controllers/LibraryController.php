<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class LibraryController extends CI_Controller {

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
	    $this->load->model('LibraryModel');
	    $this->load->model('CreatePhotoGalleryModel');
	    
	 }
	 
	 public function getAllLibraryFiles()
	 {
	     echo "obj";
	 }
	 
	 public function getFileInfo()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    {
	         if($this->security->xss_clean(trim($this->input->post('slide_id'))))
	         {
	             
	             $result=$this->LibraryModel->getFileInfo($this->security->xss_clean(trim($this->input->post('slide_id'))));
	             
	             $result=$result->result_array();
	             
	             echo json_encode($result[0]);
	             //print_r($result->result_array());*/
	         }
	     }
	 }
	 
	 public function getTableName($table)
	 {
	     if($table == 1)
	     $table="photo_gallery_mst";
	     
	     
	     return $table;
	 }
	 
	 
	 
	 public function insertMediaFilestowidget()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    {
	         if($this->security->xss_clean(trim($this->input->post('checkList'))))
	         {
	             $albumId=$this->security->xss_clean(trim($this->input->post('albumid')));
	             $table=$this->security->xss_clean(trim($this->input->post('table')));
	             $table=$this->getTableName($table);
	             $images=array();
	             if(!empty($this->security->xss_clean(trim($this->input->post('checkList')))))
	             {
	                 foreach($this->security->xss_clean(trim($this->input->post('checkList'))) as $val)
	                 {
	                     
	                     $data=$this->LibraryModel->getFileInfo($val);
	                     
	                     foreach($data->result() as $key=>$val)
	                     {
	                         
	                         $params=array(
                		    'ulbid'=>$this->session->userdata('ulbid'),
                		    'image_path'=>$val->image_path,
                		    'album_id'=>$albumId,
                		    'folder_path'=>$val->folder_path,
                		    'file_type'=>$val->file_type,
                		    'file_path'=>$val->file_path,
                		    'full_path'=>$val->full_path,
                		    'raw_name'=>$val->raw_name,
                		    'orig_name'=>$val->orig_name,
                		    'client_name'=>$val->client_name,
                		    'file_ext'=>$val->file_ext,
                		    'file_size'=>$val->file_size,
                		    'is_image'=>$val->is_image,
                		    'image_width'=>$val->image_width,
                		    'image_height'=>$val->image_height,
                		    'image_type'=>$val->image_type,
                		    'image_size_str'=>$val->image_size_str
                		    );
                		    
                		    $this->LibraryModel->insertMediaFilestowidget($params,$table);
	                         
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
	 
	 public function setImage($sourceImagePath,$thumnailWidth,$thumbimgpath)
	 {
	     
	   if($this->session->userdata('session_id')==session_id())
	    {  
	     
	        $width=125;
	        $size = getimagesize($sourceImagePath);
	        $height=($size[1]*$width)/$size[0];
	        $this->load->library('image_lib');
			$config = array(
			'source_image' => $sourceImagePath,
			'maintain_ratio' => TRUE,
			'new_image' => $thumbimgpath,
			'width' => $width,
			'height' => $height
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 
	 
	 
	 public function imageUploadPost()
	{

if($this->session->userdata('session_id')==session_id())
	    {


		$config['upload_path']   = 'assets/Libraryfiles/2019/'.$this->session->userdata('username')."/";
		$config['allowed_types'] = '*';
        $config['max_size']      = '20480';
		
			if(!is_dir($config['upload_path']))
            {
            mkdir($config['upload_path'], 0755, TRUE);
            }
		


      	$this->load->library('upload', $config);
      	
      
            
            $this->upload->do_upload('file');
		    $upload_data = $this->upload->data(); 
	        $file_name = $upload_data['file_name'];
	        
	        /*** thumbnail code ****/
	        
	        $sourceImagePath='assets/Libraryfiles/2019/'.$this->session->userdata('username')."/".$file_name;
	        $width=125;
	        $size = getimagesize($sourceImagePath);
	        $height=($size[1]*$width)/$size[0];
	        
            $thumbnailpath=$config['upload_path']."thumbnails/";
            
                if(!is_dir($thumbnailpath))
                {
                mkdir($thumbnailpath, 0755, TRUE);
                
                }
             $thumbnailpath=$config['upload_path']."thumbnails/".$file_name;  
             /**/    

		
		$full_path=base_url()."assets/Libraryfiles/2019/".$this->session->userdata('username')."/".$file_name;
		
		$params=array(
		    'ulbid'=>$this->session->userdata('ulbid'),
		    'folder_path'=>$config['upload_path'].$file_name,
		    'image_path'=>$file_name,
		    'file_type'=>$upload_data['file_name'],
		    'file_path'=>$upload_data['file_path'],
		    'full_path'=>$upload_data['full_path'],
		    'raw_name'=>$upload_data['raw_name'],
		    'orig_name'=>$upload_data['orig_name'],
		    'client_name'=>$upload_data['client_name'],
		    'file_ext'=>$upload_data['file_ext'],
		    'file_size'=>$upload_data['file_size'],
		    'is_image'=>$upload_data['is_image'],
		    'image_width'=>$upload_data['image_width'],
		    'image_height'=>$upload_data['image_height'],
		    'image_type'=>$upload_data['image_type'],
		    'image_size_str'=>$upload_data['image_size_str'],
		    'thumbnail_path'=>$thumbnailpath
		    );
		    
		    
		    $uploadData=$this->setImage($sourceImagePath,$thumnailWidth=200,$thumbnailpath);
            $result=$this->LibraryModel->addLibraryFiles($params);
            
            echo json_encode($params);
	    }
	    else
	    {
	        redirect('login');
	    }
		
	
	}
	 
	 
	 
	 
	 public function uploadMediaFiles()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    {
	         if($this->security->xss_clean(trim($this->input->post('save'))))
	         {
	             if($this->session->userdata('albumid'))
	             {
	             
	             if(!empty($this->security->xss_clean(trim($this->input->post('image[]')))))
	             {
	                 foreach($this->security->xss_clean(trim($this->input->post('image[]'))) as $val)
	                 {
	                    
	                     $result=$this->LibraryModel->getFileInfo($val);
	                     
	                     foreach($result->result() as $key=>$value)
	                     {
	                         $params=array(
	                         'image_path'=>$value->image_path,
	                         'file_type'=>$value->file_type,
	                         'file_path'=>$value->file_path,
	                         'full_path'=>$value->full_path,
	                         'raw_name'=>$value->raw_name,
	                         'orig_name'=>$value->orig_name,
	                         'client_name'=>$value->client_name,
	                         'file_ext'=>$value->file_ext,
	                         'file_size'=>$value->file_size,
	                         'is_image'=>$value->is_image,
	                         'image_width'=>$value->image_width,
	                         'image_height'=>$value->image_height,
	                         'image_type'=>$value->image_type,
	                         'image_size_str'=>$value->image_size_str,
	                         'album_id'=>$this->session->userdata('albumid'),
	                         'ulbid'=>$this->session->userdata('ulbid')
	                             );
	                             
	                             //print_r($params);
	                             
	                             $result= $this->LibraryModel->insertMediaFiles($params);
	                         
	                     }
	                     
	                 }
	                 
	                 
	                 
	                 
	                 if($result)
	                 {
	                     $this->session->set_flashdata('message','Uploaded successfully');
	                     redirect('create-photo-gallery');
	                 }
	                 else
	                 {
	                     $this->session->set_flashdata('message','Unable to Uploaded');
	                     redirect('create-photo-gallery');
	                 }
	             }
	         }
	         else
	         {
	                   $this->session->set_flashdata('message','select album');
	                     redirect('create-photo-gallery');
	         }
	         }
	     }
	     else
	     {
	         redirect('login');
	     }
	 }
	 
	 public function deleteMultiple()
	 {
	     
	    if($this->session->userdata('session_id')==session_id())
	    { 
	     
	     $fList=$this->security->xss_clean(trim($this->input->post('fList')));
	     foreach($fList as $key=>$val)
	     {
	         $params=array(
	             'slide_id'=>$val
	             );
	             $result= $this->LibraryModel->deleteMediaFiles($params);
	     }
	     
	     echo 1;
	    }
	    else
	    {
	        redirect('login');
	    }
	     
	     
	 }
	 
	 
	
	 
	
	
}
