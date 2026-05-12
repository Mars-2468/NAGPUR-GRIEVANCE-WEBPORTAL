<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class EditImageCropController extends MY_Controller {

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
	     $this->load->model('ImageCropModel');
		 $this->load->model('CustomModel');
		  $this->load->model('CreatePostModel');
		 
	 }
	 

public function imageCrop123()
	{
		
		
		if($this->session->userdata('session_id')==session_id())
	    {	        
	        
	        $thumbnail =$this->input->post('thumb_image');
	        $imgPath=$this->input->post('source_image');
	        
	        $filename=$this->input->post('source_image');
                                    
			if(!empty($thumbnail) &&  !empty($imgPath) && !empty($filename))
			{                 
		   
				$destinationWidth  = 1210;
				$destinationHeight = 400;
				$x=$this->security->xss_clean(trim($this->input->post('imgx')));
				$y=$this->security->xss_clean(trim($this->input->post('imgy')));
				$w=$this->security->xss_clean(trim($this->input->post('width')));
				$h=$this->security->xss_clean(trim($this->input->post('height')));
				
			/* 	$newimg='';
				$newimg.='DestWidth='.$destinationWidth;
				$newimg.=' DestHeight='.$destinationHeight;
				$newimg.=' x='.$x;
				$newimg.=' y='.$y;
				$newimg.=' w='.$w;
				$newimg.=' h='.$h;
				
				echo $newimg; */
				
				// Create source resource image (crop from)
				$resource    = imagecreatefromjpeg($imgPath);
				
				// Destination resource of sizes defined above.
				$destination = imagecreatetruecolor($destinationWidth, $destinationHeight);
				//imagefill($destination, 0, 0, imagecolorallocate($destination, 255, 255, 255));
				
				// Copy part of image, resize it and paste into destination.
				// Remember add minus to X and Y coordinates delivered from plugin!
				imagecopyresized($destination, $resource, 0, 0, -$x, -$y, $destinationWidth, $destinationHeight, $w, $h);
				
				// Showing image
				header('Content-Type: image/jpg');
				// imagepng($destination);
				//$save = "../sigs/". strtolower($name) .".png";
				imagepng($destination, $thumbnail);
				echo "Image cropped successfully";
				
				/* 	$this->load->library('image_lib');
					$config = array(
					'source_image' => $imgPath,
					'maintain_ratio' => FALSE,
					'new_image' => $upload_path.$filename,
					'width' => '1210',
					'height' => '311',
					'x_axis' => '-406',
					'y_axis' => '-986'
				);
								
				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				if(!$this->image_lib->crop())
				{
					echo $this->image_lib->display_errors();
				}
				$upload_path='assets/sliderimages/'.$this->session->userdata('ulbid')."/thumbs/";*/
				
				/*  $params=array(
					'thumbnail_path'=>$upload_path.$filename,
					'slide_id'=>$this->input->post('slide_id')
					);
					$result = $this->ImageCropModel->updateCroppedThumbnailPath($params);
					if($result)
					{
						echo "Your image cropped successfully";
					}
					else
					{
						echo "Unable to update . try again";
					}
				*/
			
			}else{
			   die('Invalid Details');
			}
	    }
	    else
	    {
	        redirect('login');
	    }
  
	}

public function imageCrop123Test()
{

	if($this->session->userdata('session_id')==session_id())
	{
		$thumbnail = $this->input->post('thumb_image');
		$imgPath = $this->input->post('source_image');
		$filename = $this->input->post('source_image');

		if (!empty($thumbnail) && !empty($imgPath) && !empty($filename)) {

			$destinationWidth  = 1210;
			$destinationHeight = 400;

			$x = $this->security->xss_clean(trim($this->input->post('imgx')));
			$y = $this->security->xss_clean(trim($this->input->post('imgy')));
			$w = $this->security->xss_clean(trim($this->input->post('width')));
			$h = $this->security->xss_clean(trim($this->input->post('height')));

			// Make sure the file exists
			if (!file_exists($imgPath)) {
				echo "Source image not found.";
				return;
			}

			// Detect image type (jpeg, png, etc.)
			$imageInfo = getimagesize($imgPath);
			$mime = $imageInfo['mime'];

			// Create image resource based on type
			switch ($mime) {
				case 'image/jpeg':
					$resource = imagecreatefromjpeg($imgPath);
					break;
				case 'image/png':
					$resource = imagecreatefrompng($imgPath);
					break;
				case 'image/gif':
					$resource = imagecreatefromgif($imgPath);
					break;
				default:
					echo "Unsupported image type.";
					return;
			}

			$destination = imagecreatetruecolor($destinationWidth, $destinationHeight);

			// Resize and crop
			imagecopyresized(
				$destination,
				$resource,
				0,
				0,
				-$x,
				-$y,
				$destinationWidth,
				$destinationHeight,
				$w,
				$h
			);

			// Save output image
			$saveSuccess = imagejpeg($destination, $thumbnail, 90); // 90 = quality

			// Cleanup
			imagedestroy($resource);
			imagedestroy($destination);

			if ($saveSuccess) {
				echo "Image cropped successfully";
			} else {
				echo "Failed to save cropped image.";
			}

		} else {
			echo "Missing required data.";
		}
		
	}else{
	
		redirect('login');
		
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
			$params=array('ulbid'=>$this->session->userdata('ulbid'));
			$data['languageList']=$this->MenuModel->getLanguages($params);
			$slide_id=$this->uri->segment('2');
			$srcImgPath=$this->session->userdata('source_image');
			$this->session->set_userdata('slide_id',$slide_id);
			$data['slider_data'] = $this->CustomModel->getSliderData($slide_id);	
			
		 	//echo "<pre>";print_r($data['slider_data']);echo "</pre>";die('qqq');
			//$params=array('slide_id'=>$slide_id);
			// $data['image_path']=$this->ImageCropModel->getSourceImage($params);
			
			$params=array('page_id'=>$slide_id);
			
			//$this->ImageCropModel->getSourceImage2($params);
						
			 $this->session->set_userdata('source_image',$data['slider_data']);			
			
			$this->load->view('header',$data);
			$this->load->view('editimagecrop',$data);
			$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
