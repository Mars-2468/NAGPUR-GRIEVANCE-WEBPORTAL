<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
class GeneralSettingsController extends CI_Controller {

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
	     $this->load->model('GeneralSettingsModel');
	 }

    public function deleteLogoImg()
    {
        if($this->session->userdata('session_id')==session_id())
	    { 
        $params = array('ulbid'=>$this->session->userdata('ulbid'));
        //echo json_encode($params);
        $result = $this->GeneralSettingsModel->deleteLogoImg($params);
        echo json_encode($result);
	    }
	    else
	    {
	        redirect('logout');
	    }

    }
    
    public function deleteLogoImgAdmin($ulbid)
    {
         if($this->session->userdata('session_id')==session_id())
	    {
        $params = array('ulbid'=>$ulbid);
        //echo json_encode($params);
        $result = $this->GeneralSettingsModel->deleteLogoImg($params);
        return json_encode($result);
	    }
	    else
	    {
	        redirect('logout');
	    }

    }
    
    public function getFilepath()
    {
        
        if($this->session->userdata('session_id')==session_id())
	    { 
        
        $curyear=date("Y");
        $curmonth=date('m');
        $upload_path='../assets/'.$this->session->userdata('ulbid').'/';
        
        if (!file_exists($upload_path)){
            mkdir($upload_path, 0777, true);
            $upload_path.=$curyear."/";
            if (!file_exists($upload_path)){
                mkdir($upload_path, 0777, true);
                $upload_path.=$curmonth."/";
                if (!file_exists($upload_path)){
                    mkdir($upload_path, 0777, true);
                    $upload_path.="logo/";
                    $thumbspath=$upload_path;
                    if (!file_exists($upload_path)){
                        mkdir($upload_path, 0777, true);
                    }
                }
            }
        }else{
            $upload_path.=$curyear."/";
            if (!file_exists($upload_path)){
                mkdir($upload_path, 0777, true);
                $upload_path.=$curmonth."/";
                if (!file_exists($upload_path)){
                    mkdir($upload_path, 0777, true);
                    $upload_path.="logo/";
                    $thumbspath=$upload_path;
                    if (!file_exists($upload_path)){
                        mkdir($upload_path, 0777, true);
                    }
                }
            }else{
                $upload_path.=$curmonth."/";
                
                if (!file_exists($upload_path)){
                    mkdir($upload_path, 0777, true);
                    $upload_path.="logo/";
                    $thumbspath=$upload_path;
                    if (!file_exists($upload_path)){
                        mkdir($upload_path, 0777, true);
                    }
                }else{
                    $upload_path.="logo/";
                    $thumbspath=$upload_path;
                    if (!file_exists($upload_path)){
                        mkdir($upload_path, 0777, true);
                    }
                }
            }
        }
        $data['upload_path']=$upload_path;
        $data['thumbspath']=$thumbspath;
        return $data;
	    }
	    else
	    {
	        redirect('logout');
	    }
    }
    public function set_upload_options($upload_path)
    { 
         if($this->session->userdata('session_id')==session_id())
	    {
        $config = array();
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = '20480';
        $config['overwrite']     = FALSE;
    
        return $config;
	    }
	    else
	    {
	        redirect('logout');
	    }
    }
    public function uploadfile()
    {
         if($this->session->userdata('session_id')==session_id())
	    {
        
        
        $data=$this->getFilepath();
        $upload_path=$data['upload_path'];
        $thumbs_path=$data['thumbspath'];
        $files = $_FILES;
        $i = $this->security->xss_clean(trim($this->input->post('randomValue')));
        $ulbid = $this->security->xss_clean(trim($this->input->post('ulbid')));
        $this->load->library('upload');
        //echo "ok ".$i;
        //print_r($files);    
        $this->deleteLogoImgAdmin($ulbid);
        
            $_FILES['userfile']['name']= $files['userfile_'.$i]['name'];
            $_FILES['userfile']['type']= $files['userfile_'.$i]['type'];
            $_FILES['userfile']['tmp_name']= $files['userfile_'.$i]['tmp_name'];
            $_FILES['userfile']['error']= $files['userfile_'.$i]['error'];
            $_FILES['userfile']['size']= $files['userfile_'.$i]['size'];    
            //echo "ok";
            //echo $_FILES['userfile']['name'].','.$_FILES['userfile']['type'].','.$_FILES['userfile']['tmp_name'].','.$_FILES['userfile']['size'];
            //exit;
                
            $this->upload->initialize($this->set_upload_options($upload_path));
            if(!$this->upload->do_upload())
            {
                //print_r($this->upload->display_errors());
            }
                        
            $upload_data = $this->upload->data();
            
            $upload_path=$upload_path.$upload_data['file_name'];
            $thumbs_path=$thumbs_path.$upload_data['file_name'];
            $this->session->set_flashdata('resource',$upload_path);
            $this->session->set_flashdata('thumbs',$thumbs_path);
            $this->session->set_flashdata('filename',$upload_data['file_name']);
            $this->session->set_flashdata('randomValueId',$i);
            
            redirect('general-settings');
	    }
	    else
	    {
	        redirect('logout');
	    }
        
    }
    public function do_upload()
    {
        
         if($this->session->userdata('session_id')==session_id())
	    {
        
        $formid=$_POST['form_id']; 

          if($formid != '')
          {

        $filename='userfile_'.$formid;
        $path_parts = pathinfo(strip_tags($_FILES[$filename]["name"]));
        $extension = $path_parts['extension'];
        echo $path_parts;exit;
        $Random_file_name=$filename.".".$extension;
        //move_uploaded_file($_FILES[$filename]['tmp_name'], "http://localhost/dummy/uploads/".$Random_file_name);
        
        
        $config = array();
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = '20480';
        $config['overwrite']     = FALSE;
        
        
        $this->load->library('upload',$config);
        if(!$this->upload->do_upload())
        {
            //$file_path=$this->input->post('logo');
        }
        else
        {
            $upload_data = $this->upload->data();
        
            $file_path=substr($upload_path, 2).$upload_data['file_name'];
        }
	    }
	    }
	    else
	    {
	        redirect('logout');
	    }
        
        
    }
    
    public function ulbLogoUpdate()
    {
        
       if($this->session->userdata('session_id')==session_id())
	    {  
        
        $params=array(
            'ulbid'=>$this->security->xss_clean(trim($this->input->post('ulbid'))),
            'file_path'=>$this->security->xss_clean(trim($this->input->post('file_path'))),
            'setting_name'=>'logo',
            'title'=>$this->security->xss_clean(trim($this->input->post('title'))),
            'alt'=>$this->security->xss_clean(trim($this->input->post('alt')))
        );
        //print_r($params);
        //exit;
        $result=$this->GeneralSettingsModel->ulbLogoUpdate($params);
        //echo $result;exit;
        if($result == 1){
            $this->session->set_flashdata('message',"<div class='alert alert-success'> Uploaded successfully </div>");
        }else{
            $this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to upload , try again </div>");
        }
        redirect('general-settings');
	    }
	    else
	    {
	        redirect('logout');
	    }
    }
    
	public function index()
	{
	    
	     if($this->session->userdata('userid'))
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
	   
	   if($this->input->post('save'))
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
                                                    $upload_path.="logo/";
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
                                                    $upload_path.="logo/";
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
                                                    $upload_path.="logo/";
                                                    $thumbspath=$upload_path;
                                                    if (!file_exists($upload_path)) 
                                                        {
                                                            mkdir($upload_path, 0777, true);
                                                        }
                                                }
                                                else
                                                {
                                                    $upload_path.="logo/";
                                                    $thumbspath=$upload_path;
                                                    if (!file_exists($upload_path)) 
                                                        {
                                                            mkdir($upload_path, 0777, true);
                                                        }
                                                }
                                        }
                            }
                            
                            
                            $config = array();
                            $config['upload_path'] = $upload_path;
                            $config['allowed_types'] = 'gif|jpg|png|jpeg';
                            $config['max_size']      = '20480';
                            $config['overwrite']     = FALSE;
                        
                        
                            $this->load->library('upload',$config);
                            
                            if(!$this->upload->do_upload())
                            {
                                $file_path=$this->input->post('logo');
                            }
                            else
                            {
                                $upload_data = $this->upload->data();
                                $file_path=substr($upload_path, 2).$upload_data['file_name'];
                            }
                        
                        $this->deleteLogoImg();
                        //echo $this->upload->data();exit;
                        $params=array(
                            'ulbid'=>$this->session->userdata('ulbid'),
                            'file_path'=>$file_path,
                            'setting_name'=>'logo',
                            'title'=>$this->security->xss_clean(trim($this->input->post('title'))),
                            'alt'=>$this->security->xss_clean(trim($this->input->post('alt')))
                            );
                            $result=$this->GeneralSettingsModel->insertLogoDetails($params);
                            if($result)
                            {
                                $this->session->set_flashdata('message',"<div class='alert alert-success'> Uploaded successfully </div>");
                            }
                            else
                            {
                                $this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to upload , try again </div>");
                            }
                            
                            
                            
                            
	   }
	    $params=array('ulbid'=>$this->session->userdata('ulbid'));
	    $data['logodet']=$this->GeneralSettingsModel->getLogoDetails($params);
        
        /** open getting ulb list **/
        
        //$data['ulbGeneralSetting'] = $this->GeneralSettingsModel->getUlbGeneralSetting();    
        $data['ulbList'] = $this->GeneralSettingsModel->getUlbList();
        
        /** close getting ulb list **/
	    $this->load->view('header',$data);
		$this->load->view('generalsettings',$data);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('logout');
	    }
	}
}
