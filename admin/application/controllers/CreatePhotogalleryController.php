<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class CreatePhotogalleryController extends MY_Controller {

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
	 }
	 
	public function calculatePixelsForAlign($imageSize, $cropSize, $align) {
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	        $imageSize=$this->security->xss_clean($imageSize);
	        $cropSize=$this->security->xss_clean($cropSize);
	        $align=$this->security->xss_clean($align);
	        
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
	        redirect('Login');
	    }
    }
	 
	public function cropAlign($image, $cropWidth, $cropHeight, $horizontalAlign = 'center', $verticalAlign = 'middle') {
	    if($this->session->userdata('session_id')==session_id())
	    {
	        $image=$this->security->xss_clean($image);
	        $cropWidth=$this->security->xss_clean($cropWidth);
	        $cropHeight=$this->security->xss_clean($cropHeight);
	        $horizontalAlign=$this->security->xss_clean($horizontalAlign);
	        $verticalAlign=$this->security->xss_clean($verticalAlign);
	        
	        
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
	        redirect('Login');
	    }
    }
	 public function setImage($imgWidth,$imgHeight,$sourcePath,$filename,$thumbspath,$type,$raw_name)
	{
       if($this->session->userdata('session_id')==session_id())
	    {
	        
	        $imgWidth=$this->security->xss_clean(strip_tags($imgWidth));
	        $imgHeight=$this->security->xss_clean(strip_tags($imgHeight));
	        $sourcePath=$this->security->xss_clean(strip_tags($sourcePath));
	        $filename=$this->security->xss_clean(strip_tags($filename));
	        $thumbspath=$this->security->xss_clean(strip_tags($thumbspath));
	        $type=$this->security->xss_clean(strip_tags($type));
	        $raw_name=$this->security->xss_clean(strip_tags($raw_name));
	        
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
                'source_image' => strip_tags($sourcePath),
                'new_image' => strip_tags($new_image),
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
            $path=$finalimage;
    	    $str = substr($path, 2);
            $array1[0] = $str;
            $array1[1] = substr($new_image, 2);
    	    return $array1;
	    }
	    else
	    {
	        redirect('Login');
	    }
	}
	 
	 
	 
	public function imageUploadPost()
    {
        if($this->session->userdata('session_id')==session_id())
	    {
        
        
	    $curyear=date("Y");
        $curmonth=date('m');
                           
        $upload_path='../assets/'.$this->session->userdata('ulbid').'/';
                            
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
                    $upload_path.="albums/";
                    if(!file_exists($upload_path))
                    {
                        mkdir($upload_path, 0777, true);
                        
                        $albumname=str_replace(" ","-",$this->security->xss_clean(trim(strip_tags($this->input->post('album_desc')))));
                        $upload_path.=$albumname."/";
                        $thumbs=$upload_path;
                        if (!file_exists($upload_path)) 
                        {
                            mkdir($upload_path, 0777, true);
                        }
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
                    $upload_path.="albums/";
                    if(!file_exists($upload_path))
                    {
                        mkdir($upload_path, 0777, true);
                        
                        $albumname=str_replace(" ","-",$this->security->xss_clean(trim(strip_tags($this->input->post('album_desc')))));
                        $upload_path.=$albumname."/";
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
                $upload_path.=$curmonth."/";
                $thumbspath=$upload_path;
                if (!file_exists($upload_path)) 
                {
                    mkdir($upload_path, 0777, true);
                    $upload_path.="albums/";
                    if(!file_exists($upload_path))
                    {
                        mkdir($upload_path, 0777, true);
                        
                        $albumname=str_replace(" ","-",$this->security->xss_clean(trim(strip_tags($this->input->post('album_desc')))));
                        $upload_path.=$albumname."/";
                        $thumbs=$upload_path;
                        if (!file_exists($upload_path)) 
                        {
                            mkdir($upload_path, 0777, true);
                        }
                    }
                }
                else
                {
                    $upload_path.="albums/";
                    if(!file_exists($upload_path))
                    {
                        mkdir($upload_path, 0777, true);
                        
                        $albumname=str_replace(" ","-",$this->security->xss_clean(trim(strip_tags($this->input->post('album_desc')))));
                        $upload_path.=$albumname."/";
                        $thumbs=$upload_path;
                        if (!file_exists($upload_path)) 
                        {
                            mkdir($upload_path, 0777, true);
                        }
                    }
                    else
                    {
                        mkdir($upload_path, 0777, true);
                        
                        $albumname=str_replace(" ","-",$this->security->xss_clean(trim(strip_tags($this->input->post('album_desc')))));
                        $upload_path.=$albumname."/";
                        $thumbs=$upload_path;
                        if (!file_exists($upload_path)) 
                        {
                            mkdir($upload_path, 0777, true);
                        }
                    }
                }
            }
        }
        $config['upload_path']   = $upload_path; 

		$config['allowed_types'] = 'gif|jpg|png|jpeg'; 

		$config['max_size']      = '122880';
		
        $this->load->library('upload', $config);
      	
      	if(!is_dir($config['upload_path']))
        {
            mkdir($config['upload_path'], 0755, TRUE);
        }
            
        $this->upload->do_upload('file');
	    $upload_data = $this->upload->data();
	    
	    
	     /** checking for malicious file upload **/
            $file_info = new finfo(FILEINFO_MIME_TYPE);
            $mime_types_array = array('image/jpg','image/jpeg','image/png');
            $finopath = $target_file;
            $a = getimagesize($upload_data['full_path']);
            
           
            $filename = date('YmdHis').rand(999,100000).".jpg";
            
            $mime_type = $file_info->buffer(file_get_contents($upload_data['full_path']));
           
                if(!in_array($mime_type,$mime_types_array))
                   {
                       unlink($upload_data['full_path']);
                       die('Invalid file type');
                   }
                   else
                   {
                       $src_file = $upload_data['full_path'];
                       $dest_file = $upload_path.$filename;
                        $img_quality = 70;
                         header('Content-Type: image/png');
                        $im = imagecreatefromstring(file_get_contents($src_file));
                        $im_w = imagesx($im);
                        $im_h = imagesy($im);
                        $tn = imagecreatetruecolor($im_w, $im_h);
                        imagecopyresampled ( $tn , $im, 0, 0, 0, 0, $im_w, $im_h, $im_w, $im_h );
                        imagejpeg($tn,$dest_file,$img_quality);
                        
                        array_push($imgg, $filename);
                        unlink($upload_data['full_path']);
                       
                   }
           
            /** close **/
	    
	    $upload_data['file_name'] = $filename;
        $file_name = substr($upload_path,2).$upload_data['file_name'];
        $file_ext = $upload_data['file_ext'];
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
                $data = $this->setImage(300,300,$imgPath=$upload_path.$upload_data['file_name'],$filename=$upload_data['file_name'],$thumbimgpath=$thumbs,$upload_data['image_type'],$upload_data['raw_name']); 
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
                $path=base_url()."assets/img/pdf.png";
            }
             if($upload_data['file_ext'] == '.doc')
            {
                $path=base_url()."assets/img/doc.png";
            }
             if($upload_data['file_ext'] == '.docx')
            {
                $path=base_url()."assets/img/wod.png";
            }
             if($upload_data['file_ext'] == '.csv')
            {
                $path=base_url()."assets/img/csv.png";
            }
            if($upload_data['file_ext'] == '.zip')
            {
                $path=base_url()."assets/img/zip.png";
            }
             if($upload_data['file_ext'] == '.rar')
            {
                $path=base_url()."assets/img/rar.png";
            }
             if($upload_data['file_ext'] == '.tif')
            {
                $path=base_url()."assets/img/jpg.png";
            }
            if($upload_data['file_ext'] == '.mp3')
            {
                $path=base_url()."assets/img/mp3.png";
            }
            if($upload_data['file_ext'] == '.mp4' || $upload_data['file_ext'] == '.mpeg' || $upload_data['file_ext'] == '.wmv' || $upload_data['file_ext'] == '.avi' || $upload_data['file_ext'] == '.fla' || $upload_data['file_ext'] == '.3gp')
            {
                $path=base_url()."assets/img/mp4.png";
            }
            
        }
        
       		    
		$params=array(
	    'updatedBy'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('username')))),
	    'ulbid'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('ulbid')))),
	    'langId'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('langId')))),
	    'album_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('album_id')))),
	    'folder_path'=>$this->security->xss_clean(trim(strip_tags($file_name))),
	    'image_path'=>$this->security->xss_clean(trim(strip_tags($file_name))),
	    'status'=>0,
	    'file_type'=>$upload_data['file_name'],
	    'file_path'=>$upload_data['file_path'],
	    'full_path'=>$upload_data['full_path'],
	    'raw_name'=>$upload_data['raw_name'],
	    'orig_name'=>$filename,
	    'client_name'=>$filename,
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
		    
	   $params1 = array(
	        'lastUpdatedBy'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('username')))),
		    'ulbid'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('ulbid')))),
		    'album_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('album_id'))))
	       );
		
		$this->ViewAlbumModel->addPhotogallery($params);
		
		$this->ViewAlbumModel->lastUpdatedTS($params1);    
		
		
		
		//$this->session->set_flashdata('message','Image uploaded successfully');
	    }
	    else
	    {
	        redirect('Login');
	    }
		
	}
    
  
    
	public function getContent(){
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	        if($this->input->get('id'))
	        {
        	    $params = array('id'=>$this->security->xss_clean(trim(strip_tags($this->input->get('id')))));
        	    $result=$this->CreatePhotoGalleryModel->getContentimg($params);
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
	public function getContentMedia(){
	     if($this->session->userdata('session_id')==session_id())
	    {
	        if($this->input->get('slide_id'))
	        {
        	    $params = array('slide_id'=>$this->security->xss_clean(trim(strip_tags($this->input->get('slide_id')))));
        	    $result = $this->CreatePhotoGalleryModel->getContentMediaImg($params);
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
    public function deleteContent(){
        
         if($this->session->userdata('session_id')==session_id())
	    {
        	        if($this->input->get('id'))
        	        {
            
                            $params=array('id'=>$this->security->xss_clean(trim(strip_tags($this->input->get('id')))));
                            $result=$this->CreatePhotoGalleryModel->deleteContentimg($params);
                            //echo json_encode($result);
                            if($result == '1')
                            {
                                $params1 = array(
                                                'lastUpdatedBy'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('username')))),
                                                'ulbid'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('ulbid')))),
                                                'album_id'=>$this->security->xss_clean(trim(strip_tags($this->input->get('album_id'))))
                                            );
                                $result1 = $this->ViewAlbumModel->lastUpdatedTS($params1);
                                if($result1 == '1')
                                {
                                    echo json_encode($result); 
                                }
                    	        else
                    	        {
                    	            redirect('Login');
                    	        }
                	        }
                    	    else
                    	    {
                    	       echo json_encode($result); 
                    	    }
                    } 
                    else
                    {
                        redirect('Login');
                    }
        }
    } 
	 public function deleteContentMedia(){
	     
	      if($this->session->userdata('session_id')==session_id())
    	    {
            	        if($this->input->get('slide_id'))
            	        {
    	     
                    	     $params = array('slide_id'=>$this->security->xss_clean(trim(strip_tags($this->input->get('slide_id')))),'album_id'=>$this->security->xss_clean(trim(strip_tags($this->input->get('album_id')))));
                    	     $result = $this->CreatePhotoGalleryModel->deleteContentMediaImg($params);
                    	     if($result == '1'){
                                 $params1 = array(
                                    	        'lastUpdatedBy'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('username')))),
                                    		    'ulbid'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('ulbid')))),
                                    		    'album_id'=>$this->security->xss_clean(trim(strip_tags($this->input->get('album_id'))))
                                    	       );
                                 $result1 = $this->ViewAlbumModel->lastUpdatedTS($params1);
                                 if($result1 == '1'){
                                    echo json_encode($result); 
                                 }  
                             }
                             else
                             {
                                 echo json_encode($result);  
                             }
            	        }
            	        else
            	        {
            	            redirect('Login');
            	        }
    	    }else
                    {
                        redirect('Login');
                    }
             
         
         
         
	 }
	 public function updateImgInfo(){
	     
	     if($this->session->userdata('session_id')==session_id())
    	    {
	     
	     
	     
	     
	     
	     $params=array(
	         'id'=>$this->security->xss_clean(trim(strip_tags($this->input->get('id')))),
	         'heading'=>$this->security->xss_clean(trim(strip_tags($this->input->get('heading')))),
	         'description'=>$this->security->xss_clean(trim(strip_tags($this->input->get('description')))),
	         'title'=>$this->security->xss_clean(trim(strip_tags($this->input->get('title')))),
	         'alttext'=>$this->security->xss_clean(trim(strip_tags($this->input->get('alttext')))),
	         'status'=>$this->security->xss_clean(trim(strip_tags($this->input->get('status')))),
	         'updatedby'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('username'))))
	         );
	         
	         $result=$this->CreatePhotoGalleryModel->updateImgInfo($params);
	         //echo $result;
	         if($result == '1'){
	             $params1 = array(
                    	        'lastUpdatedBy'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('username')))),
                    		    'ulbid'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('ulbid')))),
                    		    'album_id'=>$this->security->xss_clean(trim(strip_tags($this->input->get('album_id'))))
                    	       );
	             $result1 = $this->ViewAlbumModel->lastUpdatedTS($params1);
	             if($result1 == '1'){
	                //echo json_encode($result); 
	             }  
	         }
    	    }
    	    else
    	    {
    	        redirect('Login');
    	    }
	         
	 }
	 
	 public function updateMediaImgInfo(){
	     
	     if($this->session->userdata('session_id')==session_id())
    	    {
	     
	     
	     
	     
        	     $params = array(
        	         'slide_id'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('slide_id'))))),
        	         'heading'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('heading'))))),
        	         'description'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('description'))))),
        	         'title'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('title'))))),
        	         'alttext'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('alttext'))))),
        	         'status'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('status'))))),
        	         'updatedby'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('username')))))
        	         );
                $result=$this->CreatePhotoGalleryModel->updateMediaImgInfo($params);
                if($result == '1'){
                    $params1 = array(
                    	        'lastUpdatedBy'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('username'))))),
                    		    'ulbid'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->session->userdata('ulbid'))))),
                    		    'album_id'=>$this->security->xss_clean(trim(htmlspecialchars(strip_tags($this->input->get('album_id')))))
                    	       );
                    $result1 = $this->ViewAlbumModel->lastUpdatedTS($params1);
                    if($result1 == '1'){
                        echo json_encode($result); 
                    }  
                 }
    	    }
    	    else
    	    {
    	        redirect('Login');
    	    }
	 }
	 public function getMediaImgData(){
	     
	     if($this->session->userdata('session_id')==session_id())
    	    {
	     
        	    $params = array('ulbid'=>$this->security->xss_clean(trim(strip_tags($this->session->userdata('ulbid')))),'is_image'=>1);
        	    $result = $this->ViewAlbumModel->getMediaImgData($params);
        	    echo json_encode($result);
    	    }
    	    else
    	    {
    	        redirect('Login');
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
		
	    $album_id=$this->security->xss_clean(trim(strip_tags($this->uri->segment(2))));
	    
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
	    
	    $params=array('ulbid'=>strip_tags($this->session->userdata('ulbid')));
	    $data['languageList']=$this->MenuModel->getLanguages($params);
	    $params=array('album_id'=>$album_id);
	    $data['album_det1']=$this->ViewAlbumModel->getAlbumdet1($params);
	    $params=array('aim.album_id'=>strip_tags($album_id));
	    $array = $this->ViewAlbumModel->getAlbumdet($params);
	    $result = $result1 = [];
	    foreach ($array as $value) {
            $result = array_merge($result, $value);
        }
        /*foreach ($result as $value) {
            $result2 = array_merge($result2, $value);
        }*/
	    $data['album_det']=$result;
	    //$params = array('ulbid'=>$this->session->userdata('ulbid'),'is_photogallery'=>1,'is_photogallery_album_id'=>$album_id);
	    //$data['album_det'] = $this->ViewAlbumModel->getMediaImgDataPG($params);
	    $params = array('ulbid'=>strip_tags($this->session->userdata('ulbid')),'status'=>1);
	    $data['create_media_data'] = $this->ViewAlbumModel->createMediaData($params);
	    
	    
	    
	   
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('createphotogallery',$data);
		$this->load->view('divdata',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
