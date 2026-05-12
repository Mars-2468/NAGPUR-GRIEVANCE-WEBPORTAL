<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class CreatFormController extends CI_Controller {

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
	     $this->load->model('CreateFormsModel');
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
	    $ulb_list=$this->DashboardModel->ulb_list();
	    
	    foreach($ulb_list->result() as $key=>$val)
	    {
	        $this->DashboardModel->add_user($val);
	    }
	    
	    
	    if($this->input->post("formsubmit")){
	        
	        $pageResult['pageResult']=array();
	        $arrayPush = array();
	        $params = array('category_id'=>$this->security->xss_clean(trim(strip_tags($this->input->post('selectedValue')))));
    	    $result = $this->CreateFormsModel->getSelectOptionContent($params);
    	    //$optionResult = $this->CreateFormsModel->getOptionContent();
    	    
    	    
    	    /*foreach($result['optionResult'] as $key => $val){
    	        $options[$val['select_id']]['option_id']=$val['option_id'];
    	        $options[$val['select_id']]['option_desc']=$val['option_desc'];
    	    }
    	    
    	    foreach($result['pageResult'] as $selectId => $array1){
    	        $array1['option_id']=$options[$array1['select_id']]['option_id'];
    	       // $array1['option_desc']=$options[$array1['select_id']]['option_desc'];
    	        array_push($pageResult['pageResult'],$array1);
    	    }*/
    	    $options = array();
    	    for($i=0;$i<count($result['pageResult']);$i++){
    	        unset($options);
    	        array_push($arrayPush,$result['pageResult'][$i]);
    	        
    	        for($j=0;$j<count($result['optionResult']);$j++){
    	            
    	            if($result['pageResult'][$i]['sno'] == $result['optionResult'][$j]['select_id']){
    	                $options[] = $result['optionResult'][$j];
    	           }    
    	        }
    	        array_push($arrayPush[$i],$options);
    	        //array_push($arrayPush[$i],$count);
    	    }
    	    $data['selectedValue'] = $this->security->xss_clean(trim(strip_tags($this->input->post('selectedValue'))));
    	    $data['pageResult'] = $arrayPush;
	    }
	    
	    
	    $data1['page_names']=$this->CreateFormsModel->custom_menu_list();
	    $data1['category_forms_types']=$this->CreateFormsModel->category_forms_types_list();
	    $data1['category_forms_datatype']=$this->CreateFormsModel->category_forms_datatype_list();
	    
	    $this->load->view('header',$data);
		$this->load->view('creatforms',$data1);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	public function test(){
	    
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	    
	    
	    $pageResult['pageResult']=array();
	   $arrayPush = array();     
	        $params = array('category_id'=>346);
    	    $result = $this->CreateFormsModel->getSelectOptionContent($params);
    	    //$optionResult = $this->CreateFormsModel->getOptionContent();
    	    
    	    
    	    /*foreach($result['optionResult'] as $key => $val){
    	        $options[$val['select_id']]['option_id']=$val['option_id'];
    	        $options[$val['select_id']]['option_desc']=$val['option_desc'];
    	    }
    	    
    	    foreach($result['pageResult'] as $selectId => $array1){
    	        $array1['option_id']=$options[$array1['select_id']]['option_id'];
    	        $array1['option_desc']=$options[$array1['select_id']]['option_desc'];
    	        array_push($pageResult['pageResult'],$array1);
    	    }*/
    	    
    	    //$data['pageResult'] = $result['pageResult'];
    	    
    	    
    	    foreach($result['pageResult'] as $key => $value){
    	        $pageResult['pageResult'] = $key[0];
    	        foreach($result['optionResult'] as $key1 => $value1){
    	            if($value['sno'] == $value1['select_id']){
    	                $pageResult['love'] = $value1['select_id'];
    	            } 
    	        }
    	    }
    	    print_r($pageResult);
    	    
    	    for($i=0;$i<count($result['pageResult']);$i++){
    	        
    	        array_push($arrayPush,$result['pageResult'][$i]);
    	        
    	        for($j=0;$j<count($result['optionResult']);$j++){
    	            //echo  ' '.$j;
    	            if($result['pageResult'][$i]['sno'] == $result['optionResult'][$j]['select_id']){
    	                $new_array['options'] = $result['optionResult'][$j];
    	                array_push($arrayPush[$i],$new_array['options']);
    	            }    
    	        }
    	    } 
    	    echo json_encode($arrayPush);
	    }
	    else
	    {
	        redirect('Login');
	    }
	}
	
    public function add_forms(){
    
    if($this->session->userdata('session_id')==session_id())
	    {
    
            $page_id=$this->security->xss_clean(trim(strip_tags($this->input->post('pageIdValue'))));
            if($page_id != ''){
                
                $cnt=$this->security->xss_clean(trim($this->input->post('cnt')));
                
                $result = $this->CreateFormsModel->deleteSelectValueOption($page_id);
                $sDValue = $this->security->xss_clean(trim(strip_tags($this->input->post('staticDyValue'))));
                //echo "Cnt Value is ".$cnt." and sDvalue is ".$sDValue;
                //exit;
                $resultAll = '';
                for($i=0;$i<=$cnt;$i++){
                    //echo $i;
                    //exit;
                    if($this->security->xss_clean(trim($this->input->post("data_type")))[$i]=='date') {
                        $id='datepicker';
                    } else {
                        $id=str_replace(' ','_',$this->security->xss_clean(trim(strip_tags($this->input->post("label")))))[$i]; 
                    }
                
                    if($this->security->xss_clean(trim($this->input->post("type")[$i]=='select'))) {
                    
                        $class='combo dropdown reqclass';
                    
                    } else if($this->security->xss_clean(trim(strip_tags($this->input->post("data_type"))))[$i]=='date') {
                    
                        $class='datepicker reqclass';
                    } else {
                        $class='reqclass';
                    }
                
                
                    if($this->security->xss_clean(trim(strip_tags($this->input->post("label"))))[$i]){
                        $params1=array(
                            'category_id'=>$page_id,
                            'label'=>$this->security->xss_clean(trim(strip_tags($this->input->post("label"))))[$i],
                            'type'=>$this->security->xss_clean(trim(strip_tags($this->input->post("type"))))[$i],
                            'data_type'=>$this->security->xss_clean(trim(strip_tags($this->input->post("data_type"))))[$i],
                            'name'=>str_replace(' ','_',$this->security->xss_clean(trim(strip_tags($this->input->post("label")))))[$i],
                            'id'=>$id,
                            'class'=>$class,
                            'flag'=>1
                        );
                    
                        //print_r($params1);
                        
                        $result=$this->CreateFormsModel->savecreateform($params1);
                        
                        $insert_id=$this->db->insert_id();
                        
                        // taking option count values
                        
                        //$option_count="optioncount".$i;
                        //$optcount=$this->input->post($option_count);
                        
                        $optcount = $this->security->xss_clean(trim(strip_tags($this->input->post('addTypecnt'))))[$i];
                        //echo $optcount."<br />";
                        //exit;
                        if($optcount>0){
                        
                            for($j=1;$j<=$optcount; $j++){
                            
                                $options="options".$i.$j;
                               // echo $options." value  is ";
                               // echo $this->input->post($options)." & ";
                               if($this->security->xss_clean(trim(strip_tags($this->input->post($options))))){ 
                                    $params2=array(
                                        'select_id'=>$insert_id,  
                                        'option_desc'=>$this->security->xss_clean(trim(strip_tags($this->input->post($options))))
                                    );  
                                    $result=$this->CreateFormsModel->saveoptionsform($params2);
                                    $resultAll = $result;
                               }
                            }
                        }
                    }
                }
                //echo $resultAll;
                //exit;
                if($resultAll == 1)
                {
                    
                    $this->session->set_flashdata('message',"<div class='alert alert-success'> Insert Successfully </div>");
                    redirect('creat-forms');
                }else{
                    $this->session->set_flashdata('message',"<div class='alert alert-danger'> Unable to Insert , Try Again </div>");
                    redirect('creat-forms');
                }
            }else{
                $this->session->set_flashdata('message',"<div class='alert alert-danger'> Please Select Option </div>");
                redirect('creat-forms');
            }    
        }
        else {
            redirect('login');
        }
    
    }
	
	/*public function getSelectOptionContent(){
	    $params = array('category_id'=>$this->input->post('selectedValue'));
	    $result = $this->CreateFormsModel->getSelectOptionContent($params);
	    //echo json_encode($result);
	    echo $result;
	}*/
	
}
