<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UploadController extends CI_Controller {

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
	 }
	 
	 
	 
	public function uploadEditorFile()
	{
	    
	    
	   if($this->session->userdata('session_id')==session_id())
	    {  
	    
		//$url = array("http://municipalservices.in/sites/admin/");

            reset($_FILES);
            $temp = current($_FILES);
            
            if(is_uploaded_file($temp['tmp_name']))
            {
                if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
                    header("HTTP/1.1 400 Invalid file name,Bad request");
                    return;
                }
              
                // Validating Image file type by extensions
                if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png","pdf","doc","docx","xls"))){
                    header("HTTP/1.1 400 Invalid extension,Bad request");
                    return;
                }
                  
                $fileName = "../../sites/assets/editors/uploads/" . $temp['name'];
                move_uploaded_file($temp['tmp_name'], $fileName);
                //$fileName="http://municipalservices.in/sites/assets/editors/uploads".$temp['name'];
              
                echo json_encode(array('file_path' => "http://municipalservices.in/sites/assets/editors/uploads/".$temp['name']));
            }
    }
	
	else
	{
	    redirect('login');
	}
	
	}
	
}
