<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class UploadMediaController extends MY_Controller {

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
	     $this->load->model('DashboardModel');
	     $this->load->model('ViewAlbumModel');
	     $this->load->model('CreatePhotoGalleryModel');
		 $this->load->library('form_validation');
	     $this->load->model('CreateMediaModel');
	 }
	 
	 public function calculatePixelsForAlign($imageSize, $cropSize, $align) 
	 {
	      if($this->session->userdata('session_id')==session_id())
	    {
    switch ($align) {
        case 'left':
        case 'top':
            return [0, min($cropSize, $imageSize)];
        case 'right':
        case 'bottom':
            return [max(0, $imageSize - $cropSize), min($cropSize, $imageSize)];
        case 'center':
        case 'middle':
            return [
                max(0, floor(($imageSize / 2) - ($cropSize / 2))),
                min($cropSize, $imageSize),
            ];
        default: return [0, $imageSize];
    }
	    }
	    else
	    {
	        redirect('login');
	    }
}
	 
	 
	 public function cropAlign($image, $cropWidth, $cropHeight, $horizontalAlign = 'center', $verticalAlign = 'middle') 
	 {
	     
	      if($this->session->userdata('session_id')==session_id())
	    {
    $width = imagesx($image);
    $height = imagesy($image);
    $horizontalAlignPixels = $this->calculatePixelsForAlign($width, $cropWidth, $horizontalAlign);
    $verticalAlignPixels = $this->calculatePixelsForAlign($height, $cropHeight, $verticalAlign);
    return imageCrop($image, [
        'x' => $horizontalAlignPixels[0],
        'y' => $verticalAlignPixels[0],
        'width' => $horizontalAlignPixels[1],
        'height' => $verticalAlignPixels[1]
    ]);
	    }
	    else
	    {
	        redirect('login');
	    }
}
	 
	 
	public function setImage($imgWidth,$imgHeight,$sourcePath,$filename,$thumbspath,$type,$raw_name)
	{
	    
	     if($this->session->userdata('session_id')==session_id())
	    {
      
	    $curyear=date("Y");
        $curmonth=date('m');
           
        $thumbspath = $thumbspath."thumbs/";
        if (!file_exists($thumbspath)) 
        {
            mkdir($thumbspath, 0777, true);
            
        }
        
        
         /**** image resize them crop *************/
        
        
        $this->load->library('image_lib');
        
        $new_image=$thumbspath."300".$filename;
        
        $width=300;

            $this->image_lib->initialize(array(
                'image_library' => 'gd2',
                'source_image' => $sourcePath,
                'new_image' => $new_image,
                'maintain_ratio' => true,
                'master_dim' => 'width',
                'width' => $width
            ));
            $this->image_lib->resize();
        
            $this->image_lib->clear();
            header('Content-Type: image/jpg');
            $finalimage=$thumbspath.$raw_name."150X150.png";
            if($type=='jpeg' || $type=='tif')
            {
                $im = imagecreatefromjpeg($new_image);
            }
            else if($type=='png')
            {
                $im = imagecreatefrompng($new_image);
            }
            else if($type=='gif')
            {
                $im = imagecreatefromgif($new_image);
            }
            
           
            imagepng($this->cropAlign($im, 150, 150, 'center', 'middle'),$finalimage);
          
    	    $array1 = array();
            $path = $finalimage;
    	    $str = substr($path, 2);
            $array1[0] = $str;
            $array1[1] = substr($new_image, 2);
    	    return $array1;
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
	    
	   // $this->_verify_nonce();
	    
	    $curyear=date("Y");
        $curmonth=date('m');
                           
        $upload_path = '../assets/'.$this->session->userdata('ulbid').'/';
                            
        if (!file_exists($upload_path)) 
        {
            mkdir($upload_path, 0777, true);
            $upload_path.=$curyear."/";
            if (!file_exists($upload_path)) 
            {
                mkdir($upload_path, 0777, true);
                $upload_path.=$curmonth."/";
                if (!file_exists($upload_path)) 
                {
                    mkdir($upload_path, 0777, true);
                    
                    $upload_path.="mediafiles/";
                    $thumbs=$upload_path;
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
                    }
                }
            }
        }
        else
        {
            $upload_path.=$curyear."/";
            if (!file_exists($upload_path)) 
            {
                mkdir($upload_path, 0777, true);
                $upload_path.=$curmonth."/";
                if (!file_exists($upload_path)) 
                {
                           
                    mkdir($upload_path, 0777, true);
                                        
                    $upload_path.="mediafiles/";
                    $thumbs=$upload_path;
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
                    }
                                                        
                }
            }
            else
            {
                $upload_path.=$curmonth."/";
                if (!file_exists($upload_path)) 
                {
                    mkdir($upload_path, 0777, true);
                    
                    $upload_path.="mediafiles/";
                    $thumbs=$upload_path;
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
                    }
                        
                }
                else
                {
                    $upload_path.="mediafiles/";
                    $thumbs=$upload_path;
                    if (!file_exists($upload_path)) 
                    {
                        mkdir($upload_path, 0777, true);
                    }
                   
                }
            }
        }
        $config['upload_path']   = $upload_path; 

		$config['allowed_types'] = 'gif|jpg|png|jpeg|tif|pdf|doc|docx|xls|zip|csv|mp3|mp4|ppt|xml|rar|mpeg|wmv|avi|fla|3gp'; 

		$config['max_size']      = '1228800';
		


      	$this->load->library('upload', $config);
      	
      	if(!is_dir($config['upload_path']))
        {
            mkdir($config['upload_path'], 0755, TRUE);
        }
        
        $this->upload->do_upload('file');
	    $upload_data = $this->upload->data(); 
	    
	    file_put_contents('fieluploaderror.txt',$this->upload->display_errors());
	    
        $file_name = substr($upload_path,2).$upload_data['file_name'];
        $file_ext = $upload_data['file_ext'];
        //$imageextensions=array('jpg','png','gif','jpeg','PDF');

$imageextensions=array('jpg','png','gif','jpeg');

        if(in_array($upload_data['image_type'],$imageextensions))
        {
        
        $width=$upload_data['image_width'];
        $height=$upload_data['image_height'];
        $size = getimagesize($file_name);
        $resize_height=($size[1]*$width)/$size[0];
        $dest = FALSE;
       
        $raw_name = $upload_data['raw_name'];
       
        
        
            if($width > 300)
            {
                $data=$this->setImage(300,300,$imgPath=$upload_path.$upload_data['file_name'],$filename=$upload_data['file_name'],$thumbimgpath=$thumbs,$upload_data['image_type'],$upload_data['raw_name']); 
                $path = $data[0];
                $path300 = $data[1];
            }
            else
            {
               $path =$file_name;
               $path300 = '';
            }
        }
        else
        {
            if($upload_data['file_ext'] == '.pdf')
            {
                $path="/adhikari/assets/img/pdf.png";
                
            }
             else if($upload_data['file_ext'] == '.doc')
            {
                $path="/adhikari/assets/img/doc.png";
                
            }
             else if($upload_data['file_ext'] == '.docx')
            {
                $path="/adhikari/assets/img/wod.png";
                
            }
             else if($upload_data['file_ext'] == '.csv')
            {
                $path="/adhikari/assets/img/csv.png";
                
            }
            else if($upload_data['file_ext'] == '.zip')
            {
                $path="/adhikari/assets/img/zip.png";
                
            }
             else if($upload_data['file_ext'] == '.rar')
            {
                $path="/adhikari/assets/img/rar.png";
                
            }
             else if($upload_data['file_ext'] == '.tif')
            {
                $path="/adhikari/assets/img/jpg.png";
                
            }
            else if($upload_data['file_ext'] == '.mp3')
            {
                $path="/adhikari/assets/img/mp3.png";
                
            }
            else if($upload_data['file_ext'] == '.mp4' || $upload_data['file_ext'] == '.mpeg' || $upload_data['file_ext'] == '.wmv' || $upload_data['file_ext'] == '.avi' || $upload_data['file_ext'] == '.fla' || $upload_data['file_ext'] == '.3gp')
            {
                $path="/adhikari/assets/img/mp4.png";
                
            }
            else
            {
                $path="/adhikari/assets/img/files.png";
            }
            
            $upload_data['image_width']=0;
            $upload_data['image_height']=0;
            $upload_data['image_size_str']=0;
            $upload_data['is_image']=0;
            $path300='No data';
            
        }
        
	    
	    $params=array(
	    'updatedBy'=>$this->session->userdata('userid'),
	    'ulbid'=>$this->session->userdata('ulbid'),
	    'folder_path'=>$file_name,
	    'image_path'=>$file_name,
	    'status'=>0,
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
	    'thumbnail_path'=>$path,
	    'thumbnail_path300'=>$path300
	    );
	    
		    
		$result=$this->CreateMediaModel->addImageInfo_temp($params);
		echo $result;
		//$this->session->set_flashdata('message','Images uploaded successfully');

}
else
{
    redirect('login');
}


	}

	public function getContent()
	{
	     if($this->session->userdata('session_id')==session_id())
	    {
	    
	    
	    $params = array('slide_id'=>$this->input->post('slide_id'));
	    
	     $result=$this->CreateMediaModel->getContentimg($params);
	     echo json_encode($result);
	    }
	    else
	    {
	        redirect('login');
	    }
	} 
	
	
	
	public function deleteContent()
	 {
	      if($this->session->userdata('session_id')==session_id())
	    {
	    
	     $params=array('slide_id'=>$this->input->post('slide_id'));
	     
	     $result=$this->ViewAlbumModel->deleteContentimg($params);
	     if($result == '1')
	     {
	         //$result1=$this->CreatePhotoGalleryModel->deleteContentMediaImg($params);
	         echo $result;
	     }
	    }
	    else
	    {
	        redirect('login');
	    }
	 } 
	 
	 
	 
	 public function updateImgInfo()
	 {
	     
	      if($this->session->userdata('session_id')==session_id())
	    {
	     
	     $params=array(
	         'slide_id'=>$this->input->post('slide_id'),
	         'heading'=>$this->input->post('heading'),
	         'description'=>$this->input->post('description'),
	         'title'=>$this->input->post('title'),
	         'alttext'=>$this->input->post('alttext'),
	         'status'=>$this->input->post('status'),
	         'updatedby'=>$this->session->userdata('userid')
	         );
	         
	         $result=$this->CreateMediaModel->updateImgInfo($params);
	         echo json_encode($result);
	    }
	    else
	    {
	        redirect('login');
	    }
	 }
	 
	 
	 public function updateImgInfoPhotoGallery()
	 {
	     if($this->session->userdata('session_id')==session_id())
	    {
	     
	    $params = array('val'=>$this->input->post('check_val'),'album_id'=>$this->input->post('album_id'),'ulbid'=>$this->session->userdata('ulbid'));    
	    $result = $this->CreateMediaModel->updateImgInfoPhotoGallery($params);
	    //echo $result;
	    if($result == '1'){
             $params1 = array(
                	        'lastUpdatedBy'=>$this->session->userdata('userid'),
                		    'ulbid'=>$this->session->userdata('ulbid'),
                		    'album_id'=>$this->input->post('album_id')
                	       );
             $result1 = $this->ViewAlbumModel->lastUpdatedTS($params1);
             if($result1 == '1'){
                echo json_encode($result); 
             }  
         }
         
	    }
	    else
	    {
	        redirect('login');
	    }
         
         
	 }
	 
	 public function getImageDet($slide_id)
	 {
	     $result=$this->ViewAlbumModel->getImageDet($slide_id);
	     return $result;
	 }
	 
	 public function exportDatatomedialibrary()
	 {
	    
	     if($this->session->userdata('session_id')==session_id())
	    {
	    
	     if($this->input->post('exportdata'))
	     {
	         $count=$this->input->post('count');
	        $filecont=1;
	        $slideid=array();
	         for($i=1;$i<$count;$i++)
	         {
	             $slide_id="slide_id".$i;
	             $title="title".$i;
	             $alt="alt".$i;
	             $desc="desc".$i;
	             $image_det=$this->getImageDet($this->input->post($slide_id));
	             
	             $params=array(
	                 'ulbid'=>$image_det['ulbid'],
	                 'image_path'=>$image_det['image_path'],
	                 'title'=>$this->input->post($title),
	                 'alttext'=>$this->input->post($alt),
	                 'description'=>$this->input->post($desc),
	                 'status'=>1,
	                 'file_type'=>$image_det['file_type'],
	                 'file_path'=>$image_det['file_path'],
	                 'full_path'=>$image_det['full_path'],
	                 'raw_name'=>$image_det['raw_name'],
	                 'orig_name'=>$image_det['orig_name'],
	                 'client_name'=>$image_det['client_name'],
	                 'file_ext'=>$image_det['file_ext'],
	                 'file_size'=>$image_det['file_size'],
	                 'is_image'=>$image_det['is_image'],
	                 'image_width'=>$image_det['image_width'],
	                 'image_height'=>$image_det['image_height'],
	                 'image_type'=>$image_det['image_type'],
	                 'image_size_str'=>$image_det['image_size_str'],
	                 'service_id'=>$image_det['service_id'],
	                 'folder_path'=>$image_det['folder_path'],
	                 'thumbnail_path'=>$image_det['thumbnail_path'],
	                 'thumbnail_path300'=>$image_det['thumbnail_path300'],
	                 'updatedBy'=>$this->session->userdata('userid')
	                 );
	                
	                 
	                 if($this->ViewAlbumModel->insertImageDet($params))
	                 {
	                     
	                     $slideid[]=$image_det['slide_id'];
	                     $filecont++;
	                 }
	            
	         }
	         
	         $filecont=$filecont-1;
	         
	         $this->ViewAlbumModel->deleteMediaTempfiles($slideid);
	         
	         $this->session->set_flashdata('message',"<div class='alert alert-success'> $filecont files uploaded </div>");
	         redirect('upload-media');
	         
	         
	     }
	    }
	    else
	    {
	        redirect('login');
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
	    
	    $album_id=$this->uri->segment(2);
	    
	    if($this->session->userdata('username'))
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
	    
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	   // $params=array('album_id'=>$album_id);
	   // $data['album_det1']=$this->ViewAlbumModel->getAlbumdet1($params);
	   // $params=array('aim.album_id'=>$album_id);
	   // $data['album_det']=$this->ViewAlbumModel->getAlbumdet($params);
	    $params = array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['media_data']=$this->ViewAlbumModel->getMediaData_temp($params);
	    
	    if (!$this->session->userdata('form_nonce')) {
            $nonce = bin2hex(random_bytes(16));
            $this->session->set_userdata('form_nonce', $nonce);
        } else {
            $nonce = $this->session->userdata('form_nonce');
        }

        $data['form_nonce'] = $nonce;	    
	    
	    $this->load->view('header',$data);
		$this->load->view('uploadmedia',$data);
		//$this->load->view('createpage',$data);
		$this->load->view('footer');
	    }
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	public function mediaOnStatus()
	{
	     if($this->session->userdata('session_id')==session_id())
	    {
	    
	    $params = array('m.slide_id'=>$this->input->post('slide_id'),'m.ulbid'=>$this->session->userdata('ulbid'),'m.status'=>$this->input->post('status'));
	    
        $result=$this->CreateMediaModel->getContentimg($params);
        echo json_encode($result);
        //echo json_encode($params);
	}
	else
	{
	    redirect('login');
	}
	}
	
	/** 🔒 Central nonce verification method */
    private function _verify_nonce()
    {
        $nonce_post    = $this->input->post('form_nonce');
        $nonce_session = $this->session->userdata('form_nonce');

        if (empty($nonce_post) || $nonce_post !== $nonce_session) {
            $this->session->set_flashdata('error', 'Invalid or reused submission!');
            redirect($_SERVER['HTTP_REFERER'] ?? 'upload-media');
            exit;
        }

        // destroy nonce to prevent reuse
        $this->session->unset_userdata('form_nonce');
    }		
	
}
