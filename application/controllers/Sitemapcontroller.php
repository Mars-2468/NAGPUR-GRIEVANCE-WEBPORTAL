<?php

defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',1);

class Sitemapcontroller extends CI_Controller {

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
	    $this->load->model('CustomModel');
	    $this->load->library('BreadcrumbComponent');
	    $this->breadcrumbs=new BreadcrumbComponent();
	   
	     $this->load->library('Mylibrary');
	     $this->load->library('Themeonelayoutwidgets');
	     $this->load->library('Staticpagefunctionstesting');
	     $this->Mylibrary=new Mylibrary();
	     $this->Themeonelayoutwidgets=new Themeonelayoutwidgets();
	     $this->Staticpagefunctionstesting=new Staticpagefunctionstesting();
	 }
	 
	  public function angularhomepagecontent()
	 {
	     $postdata = file_get_contents("php://input");
	     $request = json_decode($postdata);
	     
	   $params=array('ulbid'=>$request->ulbid,'langId'=>$this->session->userdata('lang_Id'),'is_homepage_content'=>1);
	   
	   $result=$this->MenuModel->angularhomepagecontent($params);
	   echo json_encode($result);
	 }
	 
	 public function angularSliderData()
	 {
	     $postdata = file_get_contents("php://input");
	     $request = json_decode($postdata);
	     
	   $params=array('ulbid'=>$request->ulbid,'langId'=>$this->session->userdata('lang_Id'));
	   
	  
	   $result=$this->MenuModel->anggetsliderdata($params);
	   echo json_encode($result);
	 }
	 public function changLanguage()
	 {
	     
	     if($this->session->userdata('lang_Id')=='1')
	     {
	         $this->session->unset_userdata('lang_Id');
	         $this->session->unset_userdata('langtext');
	         $this->session->set_userdata('lang_Id','2');
	         $this->session->set_userdata('langtext','English');
	         
	     }
	     else
	     {
	         $this->session->unset_userdata('lang_Id');
	         $this->session->unset_userdata('langtext');
	         $this->session->set_userdata('lang_Id','1');
	         $this->session->set_userdata('langtext','తెలుగు');
	     }
	     
	    
	     
	      
	     
	  
	 }
	 
	/**** Library functions ****/
	
		public function widget_desc($widget_id)
	{
	    $params=array('widget_id'=>$widget_id);
        $result=$this->MenuModel->widget_desc($params);
	    return $result;
	}
	
    public function getMenuTypeId($params)
    {
       $params=array('widget_id'=>$params);
        $result=$this->MenuModel->getMenuTypeId($params);
	    return $result;
    }
    
    public function footerWebsitePolicies()
    {
        $result=$this->Themeonelayoutwidgets->footerWebsitePoliciess();
        return $result;
    }
    
    public function getGovtLinkstData($gove_widgets)
    {
        $result=$this->Themeonelayoutwidgets->getGovtLinkstData($gove_widgets);
        return $result;
    }
	
	public function getWidgetData($widget_id)
	{
	    
	    $params=array('widget_id'=>$widget_id);
	    $result=$this->MenuModel->getWidgetData($params);
	    $widget_type=$result[0]['widget_type'];
	    $params=array('widget_id'=>$widget_id,'widget_type'=>$widget_type,'ulbid'=>$this->session->userdata('ulb_id'),'langId'=>$this->session->userdata('lang_Id'));
	   
	    $result=$this->Themeonelayoutwidgets->getIndwidgetdata($params);
	    
	    return $result;
	    
	    
	    
	}
	 
	 public function updatePageContent()
	 {
	     
	     if($this->session->userdata('username'))
        	    {
                    	     if($this->input->post('save'))
                    	    {
                    	        $content=str_replace("'", "\'", $this->input->post('content'));
                                $pageid=$this->input->post('pageid');
                                
                                
                                
                    	        $params=array(
                    	            'pageid'=>$pageid,
                    	            'content'=>$content
                    	            );
                    	        $result=$this->CustomModel->updatePageContent($params);
                            	        if($result=='1')
                            	        {
                            	           
                            	            
                            	            
                            	            $this->session->set_flashdata('message','Page Updated successfully');
                            	        }
                            	        else
                            	        {
                            	            $this->session->set_flashdata('message','Unable to update page , Please try again');
                            	            
                            	        }
                            	        
                            	        redirect($this->input->post('page'));
        	        
        	                }
        	    }
	    else
	    {
	        redirect('login');
	    }
	     
	 }
	public function index()
	{
	    $ulbid = $this->uri->segment('1');
	    $this->session->set_userdata('ulb_id',$ulbid);
	    if(!$this->session->userdata('lang_Id'))
	    {
	        
	        $this->session->set_userdata('lang_Id',1);
	        $this->session->set_userdata('langtext','Telugu');
	        
	    }
	   $page=$this->uri->segment(2);
	   
	    $params=array('ulbid'=>$ulbid);
	    $data['ulbinfo']=$this->MenuModel->getULBInfo($params);
	    $data['description']=$data['ulbinfo'][0]->website_meta_desc;
	    $data['keywords']=$data['ulbinfo'][0]->website_meta_ky;
	    $data['subject']=$data['ulbinfo'][0]->website_meta_sub;
	    $arr=explode(",",$data['ulbinfo'][0]->title);
	    $title=$arr[0];
	    $data['title']=str_replace("-"," ",$page).",".$title;
	    $data['ulbnametelutu']=$data['ulbinfo'][0]->ulbtelugu." ".$data['ulbinfo'][0]->ulb_type_desctelugu;
	    $data['ulbnameenglish']=$data['ulbinfo'][0]->ulbname." ".$data['ulbinfo'][0]->ulb_type_desc;
	    $data['generalsettings']=$this->MenuModel->getULBgeneralsettings($params);
	    
	    
	    $data['logo']=$data['generalsettings'][0]['file_path'];
	    $data['logo_alt']=$data['generalsettings'][0]['alt'];
	    $data['logo_title']=$data['generalsettings'][0]['title'];
	    if($data['generalsettings'][0]['file_path'] =='')
	    {
	        $data['feviicon']="assets/cdma/img/logo1.png";
	    }
	    else
	    {
	        $data['generalsettings'][0]['file_path'];
	        $data['feviicon']=$data['generalsettings'][0]['file_path'];
	    }
	    $data['ulbid']=$ulbid;
	    
	   $params=array('ulbid'=>$ulbid,'langId'=>$this->session->userdata('lang_Id'),'menu_type_id'=>1);
	    $result=$this->Mylibrary->getMenus($params);
	    $data['mainmenus']=$result['mainmenu'][0];
	    $data['submenus']=$result['submenu'][0];
	    $data['subsubmenus']=$result['chilemenu'][0];
	    
	    /*** left menus **/
	    
	    $params=array('ulbid'=>$ulbid,'langId'=>$this->session->userdata('lang_Id'),'menu_type_id'=>2);
	    $result=$this->Mylibrary->getMenus($params);
	    $data['leftmainmenus']['leftmainmenus']=$result['mainmenu'][0];
	    $data['leftsubmenus']['leftsubmenus']=$result['submenu'][0];
	    $data['leftsubsubmenus']['leftsubsubmenus']=$result['chilemenu'][0];
	    
	    
	    //print_r($data['leftsubmenus']['leftsubmenus']);
	    
	    
	    
	    
	    /** footer menus **/
	    
	    $params=array('ulbid'=>$ulbid,'langId'=>$this->session->userdata('lang_Id'),'menu_type_id'=>3);
	    $result=$this->Mylibrary->getMenus($params);
	    $data['footermainmenus']['footermainmenus']=$result['mainmenu'][0];
	    $data['footerleftsubmenus']['footerleftsubmenus']=$result['submenu'][0];
	    $data['footerleftsubsubmenus']['footerleftsubsubmenus']=$result['chilemenu'][0];
	    
	    
	    
	    
	   
	   $params=array('ulbid'=>$ulbid,'controller'=>'sitemap');
	   if($page=='search')
	   {
	       
	       if($this->input->post('search_keyword')!=='')
	       {
    	       $params=array('ulbid'=>$ulbid,'keyword'=>$this->input->post('search_keyword'));
    	       $where=array('ulbid'=>$ulbid);
    	       $searchContent=$this->CustomModel->getsearchData($params,$where);
    	       $content="";
    	       
    	       
    	       foreach($searchContent as $key=>$val)
    	       {
    	           if($val['is_custumlink']==1)
    	           {
    	               $url=$val['site_controller'];
    	           }
    	           else
    	           {
    	               $url=$val['permalink'];
    	           }
    	           $content.="<div>";
    
                        $content.="<div><a href='".$url."' class='ser_link_tex' target='_blank'> ".$val['page_name']." </a></div>";
                        $content.="<div class='ser_url'> <a href='".$url."' class='ser_url' target='_blank'>".$url."</a></div>";
                        $content.="<div class='ser_dectex'>".substr(strip_tags($val['content']),0,200)."</div>";
                    $content.="</div>";
                    
                    $content.="<hr style='margin-top:10px; margin-bottom:10px;'>";
                    
                        	       
    	       
    	       }
	       }
	       else
	       {
	           $content="<div class='alert alert-warning'>Result not found with this keyword</div>";
	       }
	       
	       
	       $sidebarid=$data['content'][0]['page_sidebars_id']=4;
	       $data['content'][0]['content']=$content;
	       
	       
	       
	   }
	  
	   else
	   {
	       
	   
	   $data['content']=$this->CustomModel->getpageData($params);
	     
    	   if($data['content']['is_code_page'])
    	   {
    	     
    	     $params=array('ulbid'=>$ulbid,'langId'=>$this->session->userdata('lang_Id'),'menu_type_id'=>1);
    	   
    	       //$data['content'][0]['content']=$this->Staticpagefunctionstesting->getSitemap($params);
    	       $data['content'][0]['content']=$this->Staticpagefunctionstesting->getSitemap($params);
 /*************************************************************************************************************************************/   	       
    	       $sidebarid=$data['content']['page_sidebars_id'];
    	   }
    	   else
    	   {
    	   
    	   
    	    $sidebarid=$data['content'][0]['page_sidebars_id'];
    	   }
	   }
	   
	   
	   
	   $params_sidebar=array('layout_id'=>$sidebarid);
	   
	   $data['sidebar_list']=$this->CustomModel->sidebar_list($params_sidebar);
	   
	   
	   
	   
	   
	   
	   
	   
	   $params=array('ulbid'=>$ulbid,'langId'=>$this->session->userdata('lang_Id'));
	   $data['headerNews']=$this->MenuModel->getHeaderNews($params);
	   
	   $params=array('ulbid'=>$ulbid);
	   $themefolder=$this->MenuModel->getthemefolder($params); // selecting ulb mapped theme
	   $theme=$themefolder[0]['folder'];
	   $data['theme']=$themefolder[0]['folder'];
	   $themeLayoutId=$themefolder[0]['theme_id'];
	   
	   //$params=array('lwm.ulbid'=>$ulbid,'lwm.theme_id'=>$themeLayoutId,'lwm.langId'=>$this->session->userdata('langId'));
	   
	   //$data['widgeLayouts']=$this->MenuModel->getLayoutWidgets($params);
	   
	   //foreach($data['widgeLayouts'] as $key=>$val)
	   //{
	   //    $data['widgeLayouts1'][$val['page_layout_id']][$val['widget_id']]['image_path']=$val['image_path'];
	       
	       
	   //}
	   
	   $params=array('ulbid'=>$ulbid,'theme_layout_id'=>$themeLayoutId);
	   $layoutwidgets=$this->MenuModel->getLayout_innerpage($params);
	   $layouts=array();
	   foreach($layoutwidgets->result() as $key=>$val)
	   {
	       $layouts[$val->page_layout_id]=$val->page_layout_desc;
	   }
	   
	   $data['layoutwidgets']=$this->Themeonelayoutwidgets->getLayoutwidgets($layouts,$ulbid,$langId=$this->session->userdata('lang_Id'));
	   
	   //print_r($data['layoutwidgets']);
	   
	   
	    $page_content=str_replace('{municipality}',$data['ulbnameenglish'],$data['content'][0]['content']);
	   
	   
	   $i=1;
	   foreach($data['sidebar_list'] as $key=>$val)
	   {
	       
	       if($themeLayoutId==1)
	       {
    	       if($val['layout_id']=='4')
    	       {
    	           $data['layout_list'][$i]['content']="<div id='print_divv'>".$page_content."</div>";
    	           $data['layout_list'][$i]['code']=$val->code;
    	       }
    	       else
    	       {
    	           if($val['layout_id']=='1')
            	       {
            	           if($i==1)
            	           {
            	           $data['layout_list'][$i]['content']=$data['layoutwidgets'][1][0];
            	           $data['layout_list'][$i]['code']=$val['code'];
            	           }
            	           else
            	           {
            	              $data['layout_list'][$i]['content']="<div id='print_divv'>".$page_content."</div>"; 
            	              $data['layout_list'][$i]['code']=$val['code'];
            	           }
            	           
            	           
            	           
    	                   
            	       }
            	       else if($val['layout_id']=='2')
            	       {
            	          
            	           if($i==1)
            	           {
            	           $data['layout_list'][$i]['content']=$data['layoutwidgets'][3][0];
            	           $data['layout_list'][$i]['code']=$val['code'];
            	           }
            	           else
            	           {
            	              $data['layout_list'][$i]['content']="<div id='print_divv'>".$page_content."</div>"; 
            	              $data['layout_list'][$i]['code']=$val['code'];
            	           }
            	       }
            	       else if($val['layout_id']=='3')
            	       {
            	           
            	           if($i==1)
            	           {
            	           //$data['layout_list'][$i]['content']=$data['layoutwidgets'][1][0];
            	           $content1="";
            	           foreach($data['layoutwidgets'][1] as $key=>$val2)
            	           {
            	               $content1.=$val2;
            	           }
            	           $data['layout_list'][$i]['content']=$content1;
            	           $data['layout_list'][$i]['code']=$val['code'];
            	           }
            	           else if($i==2)
            	           {
            	              $data['layout_list'][$i]['content']="<div id='print_divv'>".$page_content."</div>"; 
            	              $data['layout_list'][$i]['code']=$val['code'];
            	           }
            	           else
            	           {
            	               
            	          
            	           $content3="";
            	           foreach($data['layoutwidgets'][3] as $key=>$val2)
            	           {
            	               $content3.=$val2;
            	           }
            	           
            	           
            	           $data['layout_list'][$i]['content']=$content3;
            	           $data['layout_list'][$i]['code']=$val['code'];
            	           }
            	       }
    	       }
	       }
	   $i++; }
	   
	   //echo "<pre>";
	   //print_r($data['layout_list']);
	   //echo "</pre>";
	   
	   
	   
	   $params=array('ulbid'=>$ulbid,'theme_layout_id'=>$themeLayoutId);
	   $data['customepagelayouts']=$this->MenuModel->getLayout($params);
	   $data['pagesidebarid']=1;
	   $params=array('ulbid'=>$ulbid,'controller'=>$page);
	   $page_name=$this->MenuModel->getPagename($params);
	   $params=array('ulbid'=>$ulbid,'page_id'=>$page_name['page_id']);
	   $breadcrumbs_submenus=$this->MenuModel->getBreadcrumbsSubmenus($params);
	  
	   $breadCrumbcount= count($breadcrumbs_submenus);
	  
	   
	   
	   
	   
	   
	   $this->breadcrumbs->add('Home', base_url().$ulbid."/home-page");
       
       //$this->breadcrumbs->add('Spring Tutorial', base_url().'tutorials/spring-tutorials');
       if($page=='search')
       {
           
       }
       else
       {
           
           for($i=$breadCrumbcount; $i>0; $i--)
           {
              
               
               if($breadcrumbs_submenus[$i]['is_custumlink']=='1')
               {
                   $controller=$breadcrumbs_submenus[$i]['site_controller'];
               }
               else
               {
                  $controller=base_url().$breadcrumbs_submenus[$i]['site_controller']; 
               }
                if($breadcrumbs_submenus[$i]['site_controller']==='' || $breadcrumbs_submenus[$i]['site_controller']==='#')
               {
                   $controller=base_url().$ulbid."/home-page";
               }
               $target="''";
               if($breadcrumbs_submenus[$i]['is_target_blank']=='2')
               {
                  $target="_blank"; 
               }
               $class="''";
               if($breadcrumbs_submenus[$i]['is_alert']=='1')
               {
                  $class="confirmation"; 
               }
               
              
               
               $this->breadcrumbs->add($breadcrumbs_submenus[$i]['page_name'], $controller,$target,$class);  
           }
           
           
           
       $data['breadcrumbs'] = $this->breadcrumbs->render();
       }
       
       
	   
	   
		
		$this->load->view($theme.'/header',$data);
 	//	$this->load->view($theme.'/mainmenu',$data);
 	
 		$this->load->view($theme.'/custompage',$data);
	   
 		//$this->load->view($theme.'/footer');
		$this->load->view($theme.'/footerjs',$data['theme']);
	    
	    
	    
	}
	
public function max_update_date()
	 {
	    if($this->session->userdata('username'))
        	    {
        	        $data['max_date']=$this->CustomModel->maximum_updated_date();
        	       
        	        	$this->load->view('cdma/custompage',$data);
        	    }
        	    else{
        	         redirect('login');
        	    }
	     
	 }
}
