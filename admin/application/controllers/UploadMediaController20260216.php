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
	        redirect('/');
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
	        redirect('/');
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
	        redirect('/');
	    }
	}
	
	 
	public function imageUploadPost()
	{
		if ($this->session->userdata('session_id') != session_id()) {
			redirect('/');
		}
		$this->_verify_nonce();
		
		date_default_timezone_set('Asia/Calcutta');
		$curyear = date("Y");
		$curmonth = date('m');
		$ulbid = $this->session->userdata('ulbid');
		$userid = $this->session->userdata('userid');

		$base_path = str_replace('/admin/',base_url()) . '../assets/' . $ulbid . '/' . $curyear . '/' . $curmonth . '/mediafiles/';
		$relative_path =  str_replace('/admin/',base_url()) .'../assets/' . $ulbid . '/' . $curyear . '/' . $curmonth . '/mediafiles/';
		$thumbs = $base_path;

		// Create directory if it doesn’t exist
		if (!is_dir($base_path)) {
			mkdir($base_path, 0777, true);
		}

		// Allowed types and image extensions
		//$allowed_extensions = ['gif', 'jpg', 'png', 'jpeg', 'tif', 'pdf', 'doc', 'docx', 'xls', 'zip', 'csv', 'mp3', 'mp4', 'ppt', 'xml', 'rar', 'mpeg', 'wmv', 'avi', 'fla', '3gp'];
		
	//	$image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'tif'];
	
		$allowed_extensions = ['pdf'];
	
		$image_extensions = ['pdf'];		
		
		$icon_map = [
			'pdf'  => "/adhikari/assets/img/pdf.png",
			/* 'doc'  => "/adhikari/assets/img/doc.png",
			'docx' => "/adhikari/assets/img/wod.png",
			'csv'  => "/adhikari/assets/img/csv.png",
			'zip'  => "/adhikari/assets/img/zip.png",
			'rar'  => "/adhikari/assets/img/rar.png",
			'tif'  => "/adhikari/assets/img/jpg.png",
			'mp3'  => "/adhikari/assets/img/mp3.png",
			'mp4'  => "/adhikari/assets/img/mp4.png",
			'mpeg' => "/adhikari/assets/img/mp4.png",
			'wmv'  => "/adhikari/assets/img/mp4.png",
			'avi'  => "/adhikari/assets/img/mp4.png",
			'fla'  => "/adhikari/assets/img/mp4.png",
			'3gp'  => "/adhikari/assets/img/mp4.png", */
		];

		// Loop over each uploaded file
		$files = $_FILES['file'];
		$count = count($files['name']);
		$virusInjectedFiles='';
		
		for ($i = 0; $i < $count; $i++) {
			
			if ($files['error'][$i] !== 0) {
				continue;
			}
			
			 // ❌ Reject if file has more than one dot
			if (substr_count($files['name'][$i], '.') > 1) {
				$virusInjectedFiles.=$files['name'][$i]. ',';					
				$this->session->set_flashdata('error_message','Entered pdf file contains error and Other than pdf files not allowed to upload!  '.$virusInjectedFiles);
				unlink($files['name'][$i]); // Delete the uploaded file
				continue;
			}

			$file_tmp = $files['tmp_name'][$i];
			
			$testFile=$this->isMaliciousPdf($file_tmp);
			
			if($testFile){
				
				$virusInjectedFiles .= $files['name'][$i].' , ';
				
				$this->session->set_flashdata('error_message','Entered pdf file contains error!  '.$virusInjectedFiles);
				
				unlink($files['name'][$i]); // Delete the uploaded file
				
				continue;
			}
		
			$file_name = $files['name'][$i];
			$file_type = $files['type'][$i];
			$file_size = $files['size'][$i];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$raw_name = pathinfo($file_name, PATHINFO_FILENAME);

			if (!in_array($file_ext, $allowed_extensions)) {
				$virusInjectedFiles .= $files['name'][$i].' , ';
				$this->session->set_flashdata('error_message','Entered pdf file contains error and Other than pdf files not allowed to upload!  '.$virusInjectedFiles);
				continue;
			}
			
			
			$target_path = $base_path . $file_name;

			if (!move_uploaded_file($file_tmp, $target_path)) {
				continue;
			}

			$is_image = in_array($file_ext, $image_extensions);
			$thumbnail_path = '';
			$thumbnail_path300 = '';
			$image_width = 0;
			$image_height = 0;
			$image_type = '';
			$image_size_str = '';

			if ($is_image && $img_info = getimagesize($target_path)) {
				$image_width = $img_info[0];
				$image_height = $img_info[1];
				$image_size_str = $img_info[3];
				$image_type = $img_info['mime'];

				if ($image_width > 300) {
					// Assume setImage() creates thumbnails and returns [thumb1, thumb2]
					$thumb_data = $this->setImage(300, 300, $target_path, $file_name, $thumbs, $file_ext, $raw_name);
					$thumbnail_path = $thumb_data[0];
					$thumbnail_path300 = $thumb_data[1];
				} else {
					$thumbnail_path = $relative_path . $file_name;
					$thumbnail_path300 = '';
				}
			} else {
				// Not image — assign icon
				$thumbnail_path = isset($icon_map[$file_ext]) ? $icon_map[$file_ext] : "/adhikari/assets/img/files.png";
				$thumbnail_path300 = 'No data';
			}

			$params = [
				'updatedBy'         => $userid,
				'ulbid'             => $ulbid,
				'folder_path'       => $relative_path . $file_name,
				'image_path'        => $relative_path . $file_name,
				'status'            => 0,
				'file_type'         => $file_type,
				'file_path'         => $base_path,
				'full_path'         => $target_path,
				'raw_name'          => $raw_name,
				'orig_name'         => $file_name,
				'client_name'       => $file_name,
				'file_ext'          => '.' . $file_ext,
				'file_size'         => $file_size / 1024, // in KB
				'is_image'          => $is_image ? 1 : 0,
				'image_width'       => $image_width,
				'image_height'      => $image_height,
				'image_type'        => $image_type,
				'image_size_str'    => $image_size_str,
				'thumbnail_path'    => $thumbnail_path,
				'thumbnail_path300' => $thumbnail_path300,
			];

			$this->CreateMediaModel->addImageInfo_temp($params);
	
			
		}
		
		redirect('upload-media');
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
	        redirect('/');
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
	        redirect('/');
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
	        redirect('/');
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
	        redirect('/');
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
	        redirect('/');
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
	        redirect('/');
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
	    redirect('/');
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
	
	public function isMaliciousPdf(string $filePath): bool {
		// Read first few KB (enough to detect /JS or /OpenAction)
		$handle = fopen($filePath, "rb");
		if (!$handle) return true; // treat as bad if unreadable

		$content = fread($handle, 8192); // read 8KB
		fclose($handle);

		// Search for dangerous markers
		$patterns = [
			'/\/JS\b/i',
			'/\/JavaScript\b/i',
			'/\/OpenAction\b/i',
			'/\/AA\b/i',
			'/\/Launch\b/i',
			'/\/RichMedia\b/i'
		];

		foreach ($patterns as $pattern) {
			if (preg_match($pattern, $content)) {
				return true; // found malicious code
			}
		}

		return false;
	}
}
