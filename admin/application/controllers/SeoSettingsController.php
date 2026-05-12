<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
class SeoSettingsController extends CI_Controller {

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
	     $this->load->model('SeoSettingsModel');
	 }
	public function index()
	{
	    
	    if($this->session->userdata('session_id')==session_id())
	    {
	        if($this->input->post('google_analy'))
	        {
	            $this->form_validation->set_rules('menu_type_id','Menu type','required');
        	     //$this->form_validation->set_rules('google_analytic','Menu Description','required|maxlenght[20]');
        	     if($this->form_validation->run()==FALSE)
        	     {
        	          $params=array(
        	             'ulbid'=>$this->session->userdata('ulbid'),
        	             'google_analytic_script'=>$this->input->post('google_analytic')
        	               );
        	               
        	           $result=$this->SeoSettingModel->googleanalyticinsert($params);
        	             if($result)
        	             {
        	                 $this->session->set_flashdata('message','added successfuly');
        	                 //redirect('add-menu');
        	             }
        	             else
        	             {
        	                 $this->session->set_flashdata('message','Unable to add Pls try again');
        	             }
        	         
        	     }
	            
	        }
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
	    
	   
	    
	    $edit_linl['seo_edit']=$this->MenuModel->getseo();
	    $this->load->view('header',$data);
		$this->load->view('seosettings',$edit_linl);
		$this->load->view('footer');
	    }
	    else
	    {
	        redirect('login');
	    }
	}
	
	function insert()
	{
	          if($this->session->userdata('session_id')==session_id())
	    {   
	             if($this->input->post('seo_meta'))
	             {
	                 $params=array(
	                     
	                     'ulbid'=>$this->input->post(''),
	                     'google_analytic_script'=>str_replace("'", "\'", $this->input->post('google_analytic')),
	                     'website_meta_ky'=>str_replace("'", "\'", $this->input->post('website_meta_ky')),
	                     'website_meta_desc'=>str_replace("'", "\'", $this->input->post('website_meta_desc')),
	                     'website_meta_sub'=>str_replace("'", "\'", $this->input->post('website_meta_sub'))
	                     );
	                     $result=$this->SeoSettingsModel->updateSeoSettings($params);
	                     if($result)
	                     {
	                         $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
	                         redirect('seo-tools');
	                     }
	                     else
	                     {
	                         $this->session->set_flashdata('SUCCESSMSG', "unable to update");
	                         redirect('seo-tools');
	                     }
	                     
	             }
	             
	                 /* if(isset($_POST['google_analy']))
	                  {
	                    $data = array(  
	                    'ulbid' => $this->session->userdata('ulbid'),  
                        'google_analytic_script'=> $this->input->post('google_analytic')
                        ); 
                        $submenudata='';
                        $edit_linl=$this->MenuModel->getseo();
                        
                        
                         foreach($edit_linl as $key=>$value)
                       {
                           $submenudata[$value['id']]=$value['id'];
                           $submenudata[$value['google_analytic_script']]=$value['google_analytic_script'];
                           
                       }
                        $data1['sub_id']=$submenudata;
                       if($data1['sub_id']!='')
                       {
                          $this->db->update('seo_mst',$data);
                        $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
                        redirect('seo-tools'); 
                       }
                       else
                       {
                        $this->db->set('date', 'NOW()', FALSE);
                        $this->db->insert('seo_mst',$data); 
                        
                        $this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully!!");
                        
                        redirect('seo-tools');
                       }
	                  }
                       
                       
                        if(isset($_POST['seo_meta']))
                        {
                           
                        $data2 = array(  
	                    'ulbid' => $this->session->userdata('ulbid'),  
                        'website_meta_ky'=> $this->input->post('website_meta_ky'),
                        'website_meta_desc'=> $this->input->post('website_meta_desc'),
                        'website_meta_sub'=> $this->input->post('website_meta_sub')
                        ); 
                        $submenudata2='';
                         $edit_linl=$this->MenuModel->getseo();
                       foreach($edit_linl as $key2=>$value2)
                       {
                           $submenudata2[$value2['id']]=$value2['id'];
                           $submenudata2[$value2['website_meta_ky']]=$value2['website_meta_ky'];
                           $submenudata2[$value2['website_meta_desc']]=$value2['website_meta_desc'];
                           $submenudata2[$value2['website_meta_sub']]=$value2['website_meta_sub'];
                           
                       }
                       
                       $data4['sub_id2']=$submenudata2;
                       if($data4['sub_id2']!='')
                       {
                         $this->db->update('seo_mst',$data2);
                         $this->session->set_flashdata('SUCCESSMSG', "Data Updated Successfully");
                         redirect('seo-tools'); 
                       }
                       else
                       {
                        $this->db->set('date', 'NOW()', FALSE);
                        $this->db->insert('seo_mst',$data2); 
                        $this->session->set_flashdata('SUCCESSMSG', "Data Inserted Successfully!!");
                        redirect('seo-tools');
                       }
                       
                        }*/
                       
                       
	    }
	    else
	    {
	        redirect('login');
	    }
          
          
          
                       
                       
                       
                      
	}
	
	
	
	
	
	
}
