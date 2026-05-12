<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class ImageTextCropController extends CI_Controller {

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
	     $this->load->model('ViewWidgetModel');
	     
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
	    
	    if($this->security->xss_clean(trim($this->input->post('save'))))
	    {
	        //echo "o0k";exit;
	        $dest_path = $this->security->xss_clean(trim($this->input->post('destination_path')));
	        $file_name = $this->security->xss_clean(trim($this->input->post('file_name')));
	        $widgetType = $this->security->xss_clean(trim($this->input->post('widgetType')));
            $widgetId = $this->security->xss_clean(trim($this->input->post('widgetId')));
            $widgetIdAdmin = $this->security->xss_clean(trim($this->input->post('widgetIdAdmin')));
            $id = $this->security->xss_clean(trim($this->input->post('id')));
            
            if($widgetType == '4'){
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
                            $upload_path.="gallery/";
                            if (!file_exists($upload_path)) 
                            {
                                mkdir($upload_path, 0777, true);
                                $upload_path.=$this->security->xss_clean(trim($this->input->post('widgetname')))."/";
                                $thumbspath=$upload_path;
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
                            mkdir($upload_path, 0777, true);
                            $upload_path.="gallery/";
                            if (!file_exists($upload_path)) 
                            {
                                mkdir($upload_path, 0777, true);
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
                            $upload_path.="gallery/";
                            if (!file_exists($upload_path)) 
                            {
                                mkdir($upload_path, 0777, true);
                            }
                        }
                        else
                        {
                            $upload_path.="gallery/";
                            if (!file_exists($upload_path)) 
                            {
                                mkdir($upload_path, 0777, true);
                                $upload_path.=$this->security->xss_clean(trim($this->input->post('widgetname')))."/";
                                $thumbspath=$upload_path;
                                if (!file_exists($upload_path)) 
                                {
                                    mkdir($upload_path, 0777, true);
                                }
                            }
                            else
                            {
                                $upload_path.=$this->security->xss_clean(trim($this->input->post('widgetname')))."/";
                                $thumbspath=$upload_path;
                                if (!file_exists($upload_path)) 
                                {
                                    mkdir($upload_path, 0777, true);
                                }
                            }
                        }
                    }
                }
            }else if($widgetType == '5'){
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
                            $upload_path.="widgets/";
                            $thumbspath=$upload_path;
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
                            $upload_path.="widgets/";
                            $thumbspath=$upload_path;
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
                            $upload_path.="widgets/";
                            $thumbspath=$upload_path;
                            if (!file_exists($upload_path)) 
                            {
                                mkdir($upload_path, 0777, true);
                            }
                        }
                        else
                        {
                            $upload_path.="widgets/";
                            $thumbspath=$upload_path;
                            if (!file_exists($upload_path)) 
                            {
                                mkdir($upload_path, 0777, true);
                            }
                        }
                    }
                }
            }
            $thumbspath .= "thumbs/";
            if(!file_exists($thumbspath)){
                mkdir($thumbspath, 0777, true);
            }
	        
	        $thumbspath .= $file_name;
	        //echo $thumbspath;exit;
	        
	        
            $destinationWidth  = $this->security->xss_clean(trim($this->input->post('destinationWidth')));
            $destinationHeight = $this->security->xss_clean(trim($this->input->post('destinationHeight')));
            $x=$this->security->xss_clean(trim($this->input->post('imgx')));
            $y=$this->security->xss_clean(trim($this->input->post('imgy')));
            $w=$this->input->post('width');
            $h=$this->input->post('height');
            $resource=$this->security->xss_clean(trim($this->input->post('resource')));
            $resource    = imagecreatefromjpeg($resource);
            $destination = imagecreatetruecolor($destinationWidth, $destinationHeight);
            //echo "x ".$x.",y ".$y.",w ".$w.",h ".$h;exit;
            imagecopyresized($destination, $resource, 0, 0, -$x, -$y, $destinationWidth, $destinationHeight, $w, $h);
            header('Content-Type: image/jpg');
            imagepng($destination, $thumbspath);
           
            
            
            if($widgetType == '4'){
                $params = array(
                    'id'=>$id,
                    'widget_id'=>$widgetId,
                    'widget_type'=>$widgetType,
                    'x'=>$x,
                    'y'=>$y,
                    'w'=>$w,
                    'h'=>$h,
                    'dest_path'=>substr($thumbspath,2)
                );
                if(($this->session->userdata('user_type')) == 'A'){
                    $reDir = 'edite-widget/'.$widgetIdAdmin.'/'.$widgetType;
                }else{
                    $reDir = 'edite-widget/'.$widgetId.'/'.$widgetType;
                }
                $result = $this->ViewWidgetModel->updateImageCropContent($params);
                redirect($reDir); 
            }else if($widgetType == '5'){
                $params = array(
                    'widget_id'=>$widgetIdAdmin,
                    'widget_type'=>$widgetType,
                    'x'=>$x,
                    'y'=>$y,
                    'w'=>$w,
                    'h'=>$h,
                    'dest_path'=>substr($thumbspath,2)
                );
                $result = $this->ViewWidgetModel->updateImageCropContent($params);
                
                $this->session->set_flashdata('message',"<div class='alert alert-success'>Widget saved successfully</div>");
                redirect('creage-widget');
            }
                                
                               
	    }
	 
	    
	    
	    $this->load->view('header',$data);
		$this->load->view('imagetextcrop');
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
}
