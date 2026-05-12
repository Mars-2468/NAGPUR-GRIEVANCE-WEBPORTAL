<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	ini_set('display_errors',0);
	class Themeonelayoutwidgets
	{
		function __construct() 
		{
			$this->CI =& get_instance();
			$this->CI->load->database();
		}
		
		
		public function getIndwidgetdata($parameters,$widget_type,$is_common_page,$left_menu_id)
		{
			if($parameters['widget_type']==12)
			{
				$condition = array('widget_id'=>$parameters['widget_id']);
				$this->CI->db->select('s2.*,c.page_title,c.page_name,c.content');
				$this->CI->db->from('slider_widgets s');
				$this->CI->db->join('slider_mst2 s2','s.page_id=s2.page_id');
				$this->CI->db->join('custom_menus c','s.page_id=c.page_id');
				$this->CI->db->where($condition);
				$result = $this->CI->db->get();
				$this->CI->db->last_query();
				
				$content='<div class="banner">
				<div class="slider">';
				
				foreach($result->result() as $key=>$val)
				{
					$content.='
					<figure><img src="'.$val->thumbnail_path.'" alt="'.$val->alttext.'" width="1366" height="454">
					</figure>';
					
				}
				$content.="</div></div>"; 
				return $content;
				
			}
			
			
			if($parameters['widget_type']==1)
			{
				$params1 = array('m.widget_id'=>$parameters['widget_id']);
				
				$widget_id_array=$this->CI->getMenuTypeId($params1);
				
				if($is_common_page==1)
				{
					$widget_id_array[0]['menu_type_id']=$left_menu_id;
				}
				
				
				$condition=array('c.ulbid'=>$parameters['ulbid'],'c.langId'=>$parameters['langId'],'s.menu_type_id'=>$widget_id_array[0]['menu_type_id']);
				$select_array=array('s.page_id','s.menu_id','c.page_name','c.hover_title','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
				$this->CI->db->select($select_array);
				$this->CI->db->from('site_main_menu s');
				$this->CI->db->join('custom_menus c','s.page_id=c.page_id');
				$this->CI->db->where($condition);
				$this->CI->db->order_by('menu_id','ASC');
				$result['main_menus']=$this->CI->db->get()->result_array();
				//echo $this->CI->db->last_query();
				
				
				
				
				//Sub menus
				$select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','c.page_name','c.hover_title','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
				$this->CI->db->select($select_array);
				$this->CI->db->from('site_sub_menus s');
				$this->CI->db->join('custom_menus c','s.page_id=c.page_id');
				$this->CI->db->where('c.ulbid',$parameters['ulbid']);
				$this->CI->db->order_by('sub_menu_id','ASC');
				$result['sub_menus']=$this->CI->db->get()->result_array();
				
				// sub sub menus
				$select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','s.sub_sub_menu_id','c.page_name','c.hover_title','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
				$this->CI->db->select($select_array);
				$this->CI->db->from('site_sub_sub_menus s');
				$this->CI->db->join('custom_menus c','s.page_id=c.page_id');
				$this->CI->db->where('c.ulbid',$parameters['ulbid']);
				$this->CI->db->order_by('sub_sub_menu_id','ASC');
				$result['sub_sub_menus']=$this->CI->db->get()->result_array();
				
				
				// MENUS STOTING INTO ARRAYS
				
				$pages['mainmenu']=array();
				$pages['submenu']=array();
				$pages['chilemenu']=array();
				
				foreach($result['sub_menus'] as $key=>$submenuarray)
				{
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['page_name']=$submenuarray['page_name'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['hover_title']=$submenuarray['hover_title'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['controller']=$submenuarray['controller'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_custumlink']=$submenuarray['is_custumlink'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_target_blank']=$submenuarray['is_target_blank'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_alert']=$submenuarray['is_alert'];
				}
				
				
				
				
				
				foreach($result['sub_sub_menus'] as $key=>$submenuarray)
				{
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['page_name']=$submenuarray['page_name'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['hover_title']=$submenuarray['hover_title'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['controller']=$submenuarray['controller'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_custumlink']=$submenuarray['is_custumlink'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_target_blank']=$submenuarray['is_target_blank'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_alert']=$submenuarray['is_alert'];
				}
				
				array_push($pages['chilemenu'],$data3);
				
				foreach($result['main_menus'] as $key=>$mainmenuarray)
				{
					$data1[$mainmenuarray['menu_id']]['page_name']=$mainmenuarray['page_name'];
					$data1[$mainmenuarray['menu_id']]['hover_title']=$mainmenuarray['hover_title'];
					$data1[$mainmenuarray['menu_id']]['controller']=$mainmenuarray['controller'];
					$data1[$mainmenuarray['menu_id']]['is_custumlink']=$mainmenuarray['is_custumlink'];
					$data1[$mainmenuarray['menu_id']]['is_target_blank']=$mainmenuarray['is_target_blank'];
					$data1[$mainmenuarray['menu_id']]['site_controller']=$mainmenuarray['site_controller'];
					$data1[$mainmenuarray['menu_id']]['is_alert']=$mainmenuarray['is_alert'];
					$data1[$mainmenuarray['menu_id']]['child']=array();
				}
				
				
				if($widget_id_array[0]['widget_type_style']==1)
				{
					$content.='<div class="panel panel-info">
					<div class="panel-heading">'.$widget_id_array[0]['widget_name'].'</div>
					<div class="panel-body panel_pad">
					<ul class="general_info">';
					
					
					foreach($data1 as $menuid=>$mainmenudetails){
						
						if($mainmenudetails['is_custumlink']==1)
						{
							$base_url='';
						}
						else
						{
							$base_url=base_url();
						}
						
						if($mainmenudetails['is_target_blank']==0 || $mainmenudetails['is_target_blank']==1)
						{
							$target='';
						}
						else
						{
							$target="target='_blank'";
						}
						if($mainmenudetails['is_alert']==1)
						{
							$alertClass=" "."confirmation";
							$target='target="_blank"';
						}
						else
						{
							$alertClass="";
							$target="";
						}
						$content.='<li> <a href="'.$base_url.$mainmenudetails['site_controller'].'" title="'.$mainmenudetails['hover_title'].'" '.$target.' class="'.$alertClass.'">'.$mainmenudetails['page_name'].'</a></li>';
					}
					
					$content.='</ul>'; 
					$content.='</div>';  
					$content.='</div>';
				}
				else
				{
					$widget_id_array=$this->CI->getMenuTypeId($params1);
					$widget_nam=$this->CI->widget_desc($parameters['widget_id']);
					$group_by=array('s.ulbid','s.page_id');
					
					$condition=array('s.ulbid'=>$parameters['ulbid'],'s.langId'=>$parameters['langId'],'s.menu_type_id'=>$widget_id_array[0]['menu_type_id']);
					
					$select_array=array('s.page_id','s.menu_id','c.page_name','c.hover_title','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
					$this->CI->db->select($select_array);
					$this->CI->db->from('custom_menus c');
					$this->CI->db->join('site_main_menu s','s.page_id=c.page_id','inner');
					$this->CI->db->where($condition);
					//$this->CI->db->group_by($group_by);
					$this->CI->db->order_by('menu_id','ASC');
					$main_menus=$this->CI->db->get()->result_array();
					//echo $this->CI->db->last_query();
					
					$content="";
					$content.=" <div class='col-md-2 '><h4>".$widget_nam['widget_name']."</h4>";
					$content.="<ul class='footer-li'>";
					foreach($main_menus as $key=>$val)
					{
						if($val['is_custumlink']=='1'){$base_url="";}else{$base_url=base_url(); }
						if($val['is_target_blank']=='2'){$target="target='_blank'";}else{$target="target='_self'"; }
						if($val['is_alert']=='1'){$class="class='confirmation'";}else{$class="class=''"; }
						
						$content.="<li><a href='".$base_url.$val['site_controller']."' ".$target." ".$class." title='".$val['page_name']."'><i class='fa-solid fa-angles-right me-2'></i>".$val['page_name']."</a></li>";
					}
					$content.="</ul></div>";
					return $content;
				}
				return $content;
			}
			else if($parameters['widget_type']==2)
			{
				$condition=array('c.langId'=>$parameters['langId'],'s.widget_id'=>$parameters['widget_id']);
				$select_array=array('s.*');
				$this->CI->db->select($select_array);
                $this->CI->db->from('textwidgets s');
                $this->CI->db->join('widget_mst c','s.widget_id=c.widget_id');
                $this->CI->db->where($condition);
                $content=$this->CI->db->get()->result_array();
                //print_r($content);exit;
                if($content[0]['widget_type_style']==2)
				{
				$content1.='<div class="">
                '.$content[0]['content'].'
                  
                </div>';
				}else{
				    $content1.=$content[0]['content'];
				}
                
                
				return $content1;
			}
			else if($parameters['widget_type']==5)
			{
				$condition=array('i.widget_id'=>$parameters['widget_id']);
				$select_array=array('i.*','w.widget_name');
				$this->CI->db->select($select_array);
                $this->CI->db->from('image_text_widgets i');
                $this->CI->db->join('widget_mst w','i.widget_id=w.widget_id');
                $this->CI->db->where($condition);
                $result=$this->CI->db->get()->result_array();
                //echo '<pre>'; print_r($result);
                
                if($result[0]['target']==1)
                {
                    $target="";
				}
                else
                {
                    $target="target='_blank'";
				}
                
				if($subsubmenudetails['is_alert']==1)
				{
					$alertClass=" "."confirmation";
					$target="target='_blank'";
				}
				else
				{
					$alertClass="";
				}
				$date = $time = '';
				if($result[0]['eventDate'] != '0000-00-00' && $result[0]['eventDate'] != '1970-01-01')
				{
				    $date = date('d-m-Y', strtotime($result[0]['eventDate']));
				}
				if($result[0]['eventTime'] != '0000-00-00' && $result[0]['eventTime'] != '1970-01-01')
				{
				    $time = date('h:i A', strtotime($result[0]['eventTime']));
				}
				
				$readMore = '';
				if(!empty($result[0]['url_link']) && $result[0]['url_link'] != '#')
				{
				    $readMore = '<a title="" href="'.$result[0]['url_link'].'" rel="noopener" '.$target.'><button class="btn btn-secondary ReadMore" type="button">Read More <span><i
                                                class="las la-arrow-right Read-i"></i> |</span></button></a>';
				}
				  
					if($result[0]['widget_type_style']==1)
					{
					// print_r($result); exit;
					// if($this->CI->session->userdata('color')){
					// 	$color= $this->CI->session->userdata('color')+"1";
					// 	$this->CI->session->set_userdata('color', $color);
						
						
					// }else{
					// 	$color = 1;
					// 	$this->CI->session->set_userdata('color', $color);
					// 	//$content .=' <ul class="quick-links">';
						
					// }
				
				 
		            $content.='
		           
					
					<div class=" img'. rand(1,5).'">
				

					<div class="card-body p-2">
					<a href="'.$result[0]['url_link'].'" class="d-flex align-items-center" >
							<div>
								<img src="'.$result[0]['source_path'].'" class="card-item-img" alt="'.$result[0]['title'].'" />
							</div>
							<div class=" text-white" style="margin-left:35px;">
								<h6>'.$result[0]['title'].'</h6>
								<p class="m-0">'.$result[0]['description'].'</p>
								
							</div>
							
					
						</a>   
					</div>
					</div>
				
				
				
		            ';
		            
                                                  ;
				}
				
				// <a href='".$result[0]['url_link']."' ".$target.">".$result[0]['title']."</a>
				else if($result[0]['widget_type_style']==2)
				{
				   
                  //  echo $this->session->set_userdata('color','1')
                   
                    $content .='
			
					</div>
					</div>
					<div class="col-md-3 text-center">
					<div class="com-img img-fluid">
					<a href="'.$result[0]['url_link'].'" >
						<img src="'.$result[0]['source_path'].'" class="img-fluid" alt="'.$result[0]['title'].'">
						<p style="" class="">'.$result[0]['title'].'</p>
						</a>
					</div>
					</div> ';

                  
				}
				else if($result[0]['widget_type_style']==3)
				{
				
                    if($result[0]['target']==1)
                    {
                        $target="";
    				}
                    else
                    {
                        $target="target='_blank'";
    				}
    				$content .=' 
					
					<div class="col-md-4">
					<div class="card card-icon">
					  <div class="card-body ">
					  <a href="'.$result[0]['url_link'].'" >
						<img src="'.$result[0]['source_path'].'" class="img-fluid" '.$target.' alt="'.$result[0]['file_name'].'">
						<p><b> '.$result[0]['title'].'</b></p>
						</a>
					  </div>
					</div>
				  </div>
                         ';
				
				}
				else if($result[0]['widget_type_style']==4)
				{
				
                    if($result[0]['target']==1)
                    {
                        $target="";
    				}
                    else
                    {
                        $target="target='_blank'";
    				}
    				$content .='
					<div class="col-md-4 mt-5 pt-1">
					<div class="card card-icon">
					  <div class="card-body ">
					  <a href="'.$result[0]['url_link'].'" >
						<img src="'.$result[0]['source_path'].'" class="img-fluid" '.$target.' alt="'.$result[0]['file_name'].'" width="50" height="50" >
						<p><b> '.$result[0]['title'].'</b></p>
						</a>
					  </div>
					</div>
				  </div>
                         ';
				
				}
				
				else if($result[0]['widget_type_style']==6)
				{
				
                    if($result[0]['target']==1)
                    {
                        $target="";
    				}
                    else
                    {
                        $target="target='_blank'";
    				}
    				$content .='
        			
					<div>
					<a href="'.$result[0]['url_link'].'"><img src="'.$result[0]['source_path'].'" '.$target.' class="img-fluid" alt=" '.$result[0]['title'].'"></a>
					</div>
                         ';
				
				}else if($result[0]['widget_type_style']==8)
				{
				
                    if($result[0]['target']==1)
                    {
                        $target="";
    				}
                    else
                    {
                        $target="target='_blank'";
    				}
    				$content .='
        			
						<a href="'.$result[0]['url_link'].'" ><img src="'.$result[0]['source_path'].'"  '.$target.' class="img-fluid" alt=" '.$result[0]['title'].'"></a>
                         ';
				
				}
				else if($result[0]['widget_type_style']==9)
				{
				
                    if($result[0]['target']==1)
                    {
                        $target="";
    				}
                    else
                    {
                        $target="target='_blank'";
    				}
    				$content .='
        			
					<span><a href="'.$result[0]['url_link'].'" ><img src="'.$result[0]['source_path'].'"  '.$target.' class="fa-brands fa-square-facebook" alt=" '.$result[0]['title'].'" ><a></span>
                         ';
				
				}
				else if($result[0]['widget_type_style']==4)
				{
					if(!$this->CI->session->userdata('onlineservice_widget_count'))
					{
						$this->CI->session->set_userdata('onlineservice_widget_count','1');
						$count=$this->CI->session->userdata('onlineservice_widget_count');
					}
					else
					{
						$count=$this->CI->session->userdata('onlineservice_widget_count');
						$count++;
						$this->CI->session->set_userdata('onlineservice_widget_count',$count);
						
					}
					
			
                
                $content .='<div class="container mt-2">
                                <div class="row justify-content-center align-items-center ">
                                    <div class="col-md-9">
                                        <div class="row justify-content-center align-items-center complaint">
                                            <div class="col-md-2 text-center " style="">
                                            <img src="'.$result[0]['source_path'].'" class="img-responsive" alt="'.$result[0]['title'].'">
                                        </div>
                                        <div class="col-md-10">
                                        <span class="clr-orange">'.$result[0]['widget_name'].'</span>
                                        <p class="com_txt">'.$result[0]['description'].'</p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                    
                                        <a class="complaint-form" href="'.$result[0]['url_link'].'"  '.$target.'><i class="fas fa-envelope-open mr-1"></i> Compliant Form</a>
                                    </div>
                                </div>
                            </div>';
					
				}
				else
				{
					$content="<div class='services'>";
					$content.="<img src='".$result[0]['thumbnail_path']."' alt='".$result[0]['file_name']."' title='".$result[0]['title']."'>";
					$content.="<div class='services_footer'>";
					$content.="<div class='content8'><a href='".$result[0]['url_link']."' ".$target.">".$result[0]['title']."</a></div>";
					$content.="</div>";
					$content.="</div>";
				}
			return $content;
				
				
			}
			else if($parameters['widget_type']==4)
			{
				$condition=array('widget_id'=>$parameters['widget_id']);
				$select_array=array('*');
				$this->CI->db->select($select_array);
                $this->CI->db->from('photogallery_widgets');
                $this->CI->db->where($condition);
                $result=$this->CI->db->get();
                //print_r($result);exit;
                $content="<div class='space'>";
				$content.="<div class='heading1'>";
				$content.="PHOTO GALLERIES";
				$content.="<div class='pull-right'>";
				$content.="<button class='btn  btn-sm expand_button'>";
				$content.="<img src='/assets/cdma/img/external_link.png' alt='View Photo Gallery' title='View Photo Gallery'>";
				$content.="</button>";
				$content.="<button class='btn  btn-sm share_button'>";
				$content.="<img src='/assets/cdma/img/forward.png' alt='Share Photo Gallery' title='Share Photo Gallery'>";
				$content.="</button>";
				$content.="</div>";
				$content.="</div>";
				
				
				
				$content.="<div id='myCarousel' class='carousel slide' data-ride='carousel'>";
				// Indicators
				
				$content.="<ol class='carousel-indicators'>";
				foreach($result->result() as $key=>$val)
				{
				    $content.="<li data-target='#myCarousel' data-slide-to='".$key."' class='active'></li>";
				}
				
				$content.="</ol>";
				
				// Wrapper for slides 
				$content.="<div class='carousel-inner' role='listbox'>";
				
				foreach($result->result() as $key=>$val)
				{
				    if($key==0)
				    {
						$content.="<div class='item active'>";
						$content.="<img src='".$val->full_path."' class='img_width'  alt='".$val->title."' title='".$val->title."'>";  
						$content.="</div>";
					}
				    else
				    {
				        $content.="<div class='item'>";
						$content.="<img src='".$val->full_path."' class='img_width'  alt='".$val->title."' title='".$val->title."'>";  
						$content.="</div>";
					}
				}
				 
				
			
				
				return $content;
                
			}
			else if($parameters['widget_type']==6)
			{
				$params = array('m.widget_id'=>$parameters['widget_id']);
				$widget_id_array=$this->CI->getMenuTypeId($params);
				
				$condition=array('s.ulbid'=>$parameters['ulbid'],'s.langId'=>$parameters['langId'],'s.menu_type_id'=>$widget_id_array[0]['menu_type_id']);
				
				$select_array=array('s.page_id','s.menu_id','c.page_name','c.hover_title','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
				$this->CI->db->select($select_array);
				$this->CI->db->from('custom_menus c');
				$this->CI->db->join('site_main_menu s','s.page_id=c.page_id');
				$this->CI->db->where($condition);
				$this->CI->db->order_by('menu_id','ASC');
				$result['main_menus']=$this->CI->db->get()->result_array();
				//echo $this->CI->db->last_query();
				
				
				//Sub menus
				$select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','c.page_name','c.hover_title','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
				$this->CI->db->select($select_array);
				$this->CI->db->from('site_sub_menus s');
				$this->CI->db->join('custom_menus c','s.page_id=c.page_id');
				$this->CI->db->where('c.ulbid',$parameters['ulbid']);
				$this->CI->db->order_by('sub_menu_id','ASC');
				$result['sub_menus']=$this->CI->db->get()->result_array();
				
				// sub sub menus
				$select_array=array('s.page_id','s.main_menu_id','s.sub_menu_id','s.sub_sub_menu_id','c.page_name','c.hover_title','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
				$this->CI->db->select($select_array);
				$this->CI->db->from('site_sub_sub_menus s');
				$this->CI->db->join('custom_menus c','s.page_id=c.page_id');
				$this->CI->db->where('c.ulbid',$parameters['ulbid']);
				$this->CI->db->order_by('sub_sub_menu_id','ASC');
				$result['sub_sub_menus']=$this->CI->db->get()->result_array();
				
				
				// MENUS STOTING INTO ARRAYS
				
				$pages['mainmenu']=array();
				$pages['submenu']=array();
				$pages['chilemenu']=array();
				
				foreach($result['sub_menus'] as $key=>$submenuarray)
				{
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['page_name']=$submenuarray['page_name'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['hover_title']=$submenuarray['hover_title'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['controller']=$submenuarray['controller'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_custumlink']=$submenuarray['is_custumlink'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_target_blank']=$submenuarray['is_target_blank'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
					$data2[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']]['is_alert']=$submenuarray['is_alert'];
				}
				
				
				foreach($result['sub_sub_menus'] as $key=>$submenuarray)
				{
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['page_name']=$submenuarray['page_name'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['hover_title']=$submenuarray['hover_title'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['controller']=$submenuarray['controller'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_custumlink']=$submenuarray['is_custumlink'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_target_blank']=$submenuarray['is_target_blank'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['site_controller']=$submenuarray['site_controller'];
					$data3[$submenuarray['main_menu_id']][$submenuarray['sub_menu_id']][$submenuarray['sub_sub_menu_id']]['is_alert']=$submenuarray['is_alert'];
				}
				
				array_push($pages['chilemenu'],$data3);
				
				foreach($result['main_menus'] as $key=>$mainmenuarray)
				{
					$data1[$mainmenuarray['menu_id']]['page_name']=$mainmenuarray['page_name'];
					$data1[$mainmenuarray['menu_id']]['hover_title']=$mainmenuarray['hover_title'];
					$data1[$mainmenuarray['menu_id']]['controller']=$mainmenuarray['controller'];
					$data1[$mainmenuarray['menu_id']]['is_custumlink']=$mainmenuarray['is_custumlink'];
					$data1[$mainmenuarray['menu_id']]['is_target_blank']=$mainmenuarray['is_target_blank'];
					$data1[$mainmenuarray['menu_id']]['site_controller']=$mainmenuarray['site_controller'];
					$data1[$mainmenuarray['menu_id']]['is_alert']=$mainmenuarray['is_alert'];
					$data1[$mainmenuarray['menu_id']]['page_id']=$mainmenuarray['page_id'];
					$data1[$mainmenuarray['menu_id']]['child']=array();
				}
				
				// print_r($data1);
				
				
				$this->CI->db->select('page_id,menu_style');
				$this->CI->db->from('mega_menu_mapping');
				$megamenus=$this->CI->db->get()->result_array();
				
				foreach($megamenus as $key=>$value)
				{
					$megamenupages[$value['page_id']]=$value['page_id'];
					$megamenustyles[$value['page_id']]['style']=$value['menu_style'];
				}
				
				$mainmenus=$data1;
				$submenus=$data2;
				$subsubmenus=$data3;
				
				$uri = $parameters['uri'];
				$content.='
				<div class="d-flex justify-content-center nav-bg">
				<nav class="navbar navbar-expand-lg navbar-light p-0">
				  <div class="container-fluid">
					<a class="navbar-brand" href="#"></a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
					  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					  <span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse " id="navbarNav">
					  <ul class="navbar-nav">
						<li class="nav-item">
						  <a class="nav-link active" aria-current="page" href="'.base_url().'"><i class="fa-solid fa-house"></i></a>
						</li>

				';
                $count=count($mainmenus);
                $i=1;
                foreach($mainmenus as $key=>$mainmenu_det)
                {
            		if($i >= $count-1)
            		    $subclass="submenu-button";
            		else
            		    $subclass="submenu-button";
            		
            		if($mainmenu_det['site_controller']=="#" || $mainmenu_det['site_controller']==='')
            		    $base_url=base_url();
            		else
            		    $base_url=base_url();
            		
                        		
                        		
            		if($mainmenu_det['is_alert']=="1")
            		{
            			$alertClass=" "."confirmation";
            			$target='target="_blank"';
            		}
            		else
            		{
            			$alertClass="";
            			$target="";
            		}
                        		
            		if($mainmenu_det['is_custumlink']=="1")
            		{
            			$base_url='';
            			$target='target="_blank"';
            		}
                    
                    if(in_array($mainmenu_det['page_id'],$megamenupages))
                    {
                        //echo 'okk';exit;
                        if($megamenustyles[$mainmenu_det['page_id']]['style']=='2')
                        {
                            if(count($submenus[$key])> 0)
                            {
                        		$innerloop=ceil(count($submenus[$key])/4);
                        		$content.='	 <li class="nav-item dropdown"> <a href="'.$base_url.$mainmenu_det['site_controller'].'" class="'.$alertClass.'" '.$target.' title="'.$mainmenu_det['hover_title'].'"> '.$mainmenu_det['page_name'].'</a> '; 
                        					
            					if(count($submenus[$key])> 0)
            					{
            						$content.='<ul class="dropdown-menu dropdown-submenu" >';
            						foreach($submenus[$key] as $key2=>$submenu_det)
            						{
                        			    $content.='<li ><a href="'.$submenu_det['site_controller'].'"  class="dropdown-item '.$alertClass.'" '.$target.'>'.$submenu_det['page_name'].'</a> <';
                        				if(count($subsubmenus[$key])> 0)
                        				{
                        				    $content.='<ul class="dropdown-menu dropdown-submenu" >';
                        					foreach($subsubmenus[$key][$key2] as $key3=>$subsubdet)
                        					{ 
                        						$content.='<li> <a href="'.$subsubdet['site_controller'].'" class=" dropdown-item '.$alertClass.'" '.$target.'>'.$subsubdet['page_name'].'</a> </li>';
                        					}
                        					$content.='</ul>';
                        				}
                        				$content.='</li>';
                        			}
                        		}
                        		$content.='</ul></li>'; 
                            }
                        }
                        else
                        {
                        	if(count($submenus[$key])> 0)
                        	{
                        	    $innerloop=ceil(count($submenus[$key])/4);
                        		$ulcount=1;
                        		$content.='<li class="mega-menu"> <a href="'.$base_url.$mainmenu_det['site_controller'].'" class="dropdown-item'.$alertClass.'" '.$target.' title="'.$mainmenu_det['hover_title'].'"> '.$mainmenu_det['page_name'].'</a> <span class="arrow"></span>'; 
                        		$content.='<ul>';
                        		$i=1;
                        		foreach($submenus[$key] as $key2=>$submenu_det)
                        		{
                        			if($submenu_det['is_custumlink']==1)
                        			{
                        				if(strpos($submenu_det['site_controller'],'http'))
                        					$string="";
                        				else
                        					$string="";
                        			}
                        			else
                        			{
                        			    $string=base_url();
                        			}
                        			
                        			if($submenu_det['is_alert']=="1")
                        			{
                        			    $alertClass=" "."confirmation";
                        				$target='target="_blank"';
                        			}
                        			else
                        			{
                        				$alertClass="";
                        				$target="";
                        			}
                        						
                        			$content.='<li > <a href="'.$submenu_det['site_controller'].'" title="'.$submenu_det['hover_title'].'" class="dropdown-item'.$alertClass.'" '.$target.'><i class="fa fa-angle-right"></i> &nbsp; '.$submenu_det['page_name'].'</a></li>';
                        			$i++;
                        		}
                        		$content.='</ul></li>';
                        	}
                        }
                    }
                    else
                    {
                        
                        if(count($submenus[$key])> 0)
                        {
                            // echo $key;
                            
                                $DynamicClass = "auranga".$i;
                           
                            
                            $content.='
                                <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
								data-bs-toggle="dropdown" aria-expanded="false">
                                        '.$mainmenu_det['page_name'].'
                                    </a>
									
                                    <ul class="dropdown-menu dropdown-submenu"  >';
                            
                        	foreach($submenus[$key] as $key2=>$submenu_det)
                        	{
                        	    if(count($subsubmenus[$key][$key2]) <= 0)
                        	    {
                        			$string="";
                        			if($submenu_det['is_custumlink']==1)
                        			{
                        			    if(strpos($submenu_det['site_controller'],'http'))
                        				    $string="";
                        				else
                        				    $string=base_url();
                        			}
                        			else
                        			{
                        			    $string=base_url();
                        		    }
                        			if($submenu_det['is_alert']=="1")
                        			{
            							$alertClass=" "."confirmation";
            							$target="target='_blank'";
            							$string="";
                        			}
                        			else
                        			{
            							$alertClass="";
            							$target="";
            							$string=base_url();
            						}
                        			
                        			$content .='<li class="nav-item"><a class="dropdown-item"  href="'.$string.$submenu_det['site_controller'].'"  '.$target.' title="'.$submenu_det['hover_title'].'">'.$submenu_det['page_name'].'</a></li>';
                        			
                        			
                        		}
                        		else
                        		{
                        		    $content.="<li class='nav-item'><a href='".$submenu_det['site_controller']."' class='dropdown-item' title='".$submenu_det['hover_title']."' >".$submenu_det['page_name']." <span class='sub-arrow  pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></span> </a><span class='arrow'></span>";
                        			$subsubcount=ceil(count($subsubmenus[$key][$key2]));
                        			
                        			if($subsubcount > 6)
                        			{
                        			    $style="overflow-y: scroll;height: 250px;";
                        			}
                        			else
                        			    $style="";
                        					
                        			$content.="<ul class='dropdown-menu dropdown-submenu' style='".$style."'>";
                        			foreach($subsubmenus[$key][$key2] as $key3=>$subsubdet)
                        			{
                        			    if($subsubdet['is_custumlink']==1)
                        				{
                        				    if(strpos($subsubdet['site_controller'],'http'))
                        					    $string="";
                        					else
                        					    $string=base_url();
                						}
                        				else
                        				    $string=base_url();
                        				
                        				if($subsubdet['is_alert']=="1")
            							{
            								$alertClass=" "."confirmation";
            								$target="target='_blank'";
            							}
            							else
            							{
            								$alertClass="";
            								$target="";
            							}
                        				
                        				$content.="<li ><a href='".$string.$subsubdet['site_controller']."' class='dropdown-item".$alertClass."' ".$target." title='".$subsubdet['hover_title']."'>".$subsubdet['page_name']."</a></li>";
                        			}
                        						
            						$content.="</ul>";
            				// 		$content.="</li>";
            					}
                        	} 
                        				
            				$content.=" </ul>
            				    </li>";
            				
            			}
            			else
            			{ 
            				//if($mainmenu_det['is_custumlink']==0){$string=base_url();}else{$string="";}
            				$uriClass = '';
            				//echo $uri;exit;
            				if(($uri == '' || $uri == '#') && $uri == $mainmenu_det['site_controller'])
            				    $uriClass= 'home_style';
            				    
            				$content.='
            				    <li class="nav-item">
                            		<a class="nav-link" href="'.$base_url.$mainmenu_det['site_controller'].'" title="'.$mainmenu_det['hover_title'].'" '.$target.' >
                            		    '.$mainmenu_det['page_name'].'
                            		</a>
                                </li>';
            			}
            		}
            	$i++;
            	}
                $content.="</ul></div></div></nav></div> ";
			 
            
                return $content;
				
			}
			else if($parameters['widget_type']==7)
			{
				$condition=array('widget_id'=>$parameters['widget_id']);
				$select_array=array('*');
				$this->CI->db->select($select_array);
                $this->CI->db->from('image_text_widgets');
                $this->CI->db->where($condition);
                $result=$this->CI->db->get();
                
				/* if($result[0]['target']==1)
					{
                    $target="";
					}
					else
					{
                    $target="_blank";
				}*/
                $content="";
                foreach($result->result() as $key=>$val)
                {
				// 	$content.="<div class='owl-carousel owl-theme'>";
					//$content.="<div><img class='bod' src=".$val->full_path." alt=".$val->title." title=".$val->title."></div>";
            	   // $content.="</div>"; 
            	    
            	    
				}
                return $content;
			}
			else if($parameters['widget_type']==8)
			{
				$condition=array('t.widget_id'=>$parameters['widget_id']);
				$select_array=array('t.category_id','c.page_name','t.tab_type_id');
				$this->CI->db->select($select_array);
				$this->CI->db->from('tabswidget t');
				$this->CI->db->join('custom_menus c','t.category_id=c.page_id');
				$this->CI->db->where($condition);
				$result=$this->CI->db->get();
				//echo $this->CI->db->last_query();
				
				foreach($result->result() as $key=>$val)
				{
					$categories[$val->category_id]['category_name']=$val->page_name;
					$cat_id[$val->category_id]=$val->category_id;
					$tab_type_id=$val->tab_type_id;
				}
				
				// print_r($categories);
				
				$condition=array('ulbid'=>$parameters['ulbid']);
				$select_array=array('c.page_id','category_id');
				$this->CI->db->select($select_array);
				$this->CI->db->from('post_category_map pcm');
				$this->CI->db->join('custom_menus c','pcm.page_id=c.page_id');
				$this->CI->db->where($condition);
				$this->CI->db->where_in('category_id',$cat_id);
				$result=$this->CI->db->get();
				//echo $this->CI->db->last_query();
				
				
				foreach($result->result() as $key=>$val)
				{
					$posts[$val->category_id][$val->page_id]['page_id']=$val->page_id;
					$page_id[$val->page_id]=$val->page_id;
				}
				
				//print_r($page_id);
				
				$select_array=array('page_id','page_name','site_controller','is_custumlink');
				$this->CI->db->select($select_array);
				$this->CI->db->from('custom_menus');
				$this->CI->db->where_in('page_id',$page_id);
				$result=$this->CI->db->get();
				//echo $this->CI->db->last_query();
				foreach($result->result() as $key=>$val)
				{
					$post_list[$val->page_id]['page_name']=$val->page_name;
					$post_list[$val->page_id]['site_controller']=$val->site_controller;
					$post_list[$val->page_id]['is_custumlink']=$val->is_custumlink;
				}
				
				if($tab_type_id==='1')
				{
					$content="<section class='tab_style1'>";
					$content.="<div class='tabs tabs-style-bar'>";
					$content.="<nav>";
					$content.="<ul>";
					foreach($categories as $cat_id=>$cat_name)
					{
						$content.="<li><a href='#".$cat_id."' class=''><span>".$cat_name['category_name']."</span></a></li>";
					}
					
					$content.="</ul>";
					$content.="</nav>";
					$content.="<div class='content-wrap 111'>";
					foreach($categories as $cat_id=>$cat_name)
					{
						
						$content.="<section id='".$cat_id."'>";
						
						foreach($posts[$cat_id] as $page_id=>$page_id2)
						{
							$content.="<a href='".base_url().$post_list[$page_id2['page_id']]['site_controller']."' title='".$post_list[$page_id2['page_id']]['page_name']."'><p>".$post_list[$page_id2['page_id']]['page_name']."</p></a>";
						}
						$content.="</section>";
						
						
					}
					
					$content.="</div>";
					$content.="</div>";
					$content.="</section>";
					return $content;
				}
				else
				{
					$content.="<div class='col-lg-12 bhoechie-tab-container'>";
					$content.="<div class='col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu'>";
					
					$content.="<div class='list-group'>";
					foreach($categories as $cat_id=>$cat_name)
					{
						
						
						$content.="<a href='#' class='list-group-item active text-center'>";
						$content.="<div>".$cat_name['category_name']."</div>";
						$content.="</a>";
						
					}
					$content.="</div>";
					
					$content.="</div>";
					$content.="<div class='col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab'>";
					
					
					$i=1;
					foreach($categories as $cat_id=>$cat_name)
					{
						if($i==1)
						{
							$string="active";
						}
						else
						{
							$string="";
						}
						$i++;
						
						$content.="<div class='bhoechie-tab-content ".$string."'>";
						$content.="<center>";
						foreach($posts[$cat_id] as $page_id=>$page_id2)
						{
							
							$content.="<h2 style='margin-top: 0;color:#55518a'><a href='".base_url().$post_list[$page_id2['page_id']]['site_controller']."' title='".$post_list[$page_id2['page_id']]['page_name']."'><p>".$post_list[$page_id2['page_id']]['page_name']."</p></a></h2>";
						}
						
						$content.="</center>";
						$content.="</div>"; 
					}
					
					$content.="</div>";
					$content.="</div>";
					return $content;
				}
			}
			else if($parameters['widget_type']==9)
			{
				//echo 1;exit;
				$condition=array('t.widget_id'=>$parameters['widget_id']);
				$select_array=array('t.category_id','c.page_name','w.widget_name');
				$this->CI->db->select($select_array);
				$this->CI->db->from('postwidget t');
				$this->CI->db->join('custom_menus c','t.category_id=c.page_id');
				$this->CI->db->join('widget_mst w','t.widget_id=w.widget_id');
				$this->CI->db->where($condition);
				$result=$this->CI->db->get();
				foreach($result->result() as $key=>$val)
				{
					$categories[$val->category_id]['category_name']=$val->page_name;
					$cat_id[$val->category_id]=$val->category_id;
					$tab_type_id=$val->tab_type_id;
					$widget_name = $val->widget_name;
				}
				
				// print_r($categories);
				
				$condition=array('');
				$select_array=array('page_id','category_id');
				$this->CI->db->select($select_array);
				$this->CI->db->from('post_category_map');
				$this->CI->db->where_in('category_id',$cat_id);
				$result=$this->CI->db->get();
				
				foreach($result->result() as $key=>$val)
				{
					$posts[$val->category_id][$val->page_id]['page_id']=$val->page_id;
					$page_id[$val->page_id]=$val->page_id;
					
				}
				//print_r($page_id);
				$select_array=array('page_id','page_name','site_controller','is_custumlink','content','ts');
				$this->CI->db->select($select_array);
				$this->CI->db->from('custom_menus');
				$this->CI->db->where_in('page_id',$page_id);
				$this->CI->db->order_by('ts','DESC');
				$result=$this->CI->db->get();
				//echo $this->CI->db->last_query(); exit;
			/*	foreach($result->result() as $key=>$val)
				{
					$post_list[$val->page_id]['page_name']=$val->page_name;
					$post_list[$val->page_id]['site_controller']=$val->site_controller;
					$post_list[$val->page_id]['is_custumlink']=$val->is_custumlink;
					$post_list[$val->page_id]['content']=$val->content;
					$post_list[$val->page_id]['ts']=$val->ts;
				}*/
				
				
				$select_array = array('site_controller','last_updated','custom_menus.content','category_id','page_title','post_category_map.page_id','departments_data.image_path','departments_data.date','departments_data.sliderLinkText');
        $condition = array('user_type'=>'D');
        $this->CI->db->select($select_array);
        $this->CI->db->where($condition);
        $this->CI->db->from('post_category_map');
        $this->CI->db->join('custom_menus','post_category_map.page_id=custom_menus.page_id');
        $this->CI->db->join('departments_data','custom_menus.page_id=departments_data.page_id');
        $this->CI->db->order_by('departments_data.last_updated','DESC');
        $this->CI->db->limit(2);
        $result=$this->CI->db->get()->result_array();
       // echo $this->CI->db->last_query();
       
        
        foreach($result as $key=>$val){
            
            $post_list[$val['page_id']]['page_id'] = $val['page_id'];
            $post_list[$val['page_id']]['page_title'] = $val['page_title'];
            $post_list[$val['page_id']]['image_path'] = $val['image_path'];
            $post_list[$val['page_id']]['date'] = $val['date'];
            //$post_list[$val['page_id']]['sliderLinkText'] = $val['sliderLinkText'];
            $post_list[$val['page_id']]['content'] = $val['content'];
            $post_list[$val['page_id']]['last_updated'] = $val['last_updated'];
            $post_list[$val['page_id']]['site_controller'] = $val['site_controller'];
            $post_list[$val['page_id']]['sliderLinkText'] = "https://192.168.10.243/public-notices";
        }
        
        $select_array = array('site_controller','last_updated','custom_menus.content','category_id','page_title','post_category_map.page_id','work_oder_data.image_path','work_oder_data.date','work_oder_data.sliderLinkText');
        $condition = array('user_type'=>'D');
        $this->CI->db->select($select_array);
        $this->CI->db->where($condition);
        $this->CI->db->from('post_category_map');
        $this->CI->db->join('custom_menus','post_category_map.page_id=custom_menus.page_id');
        $this->CI->db->join('work_oder_data','custom_menus.page_id=work_oder_data.page_id');
        $this->CI->db->order_by('work_oder_data.last_updated','DESC');
        $this->CI->db->limit(2);
        $result=$this->CI->db->get()->result_array();
        //echo $this->CI->db->last_query();
        
        //exit;
       
        
        foreach($result as $key=>$val){
            $categories[$val['category_id']] = $val['category_id'];
            $post_list[$val['page_id']]['page_id'] = $val['page_id'];
            $post_list[$val['page_id']]['page_title'] = $val['page_title'];
            $post_list[$val['page_id']]['image_path'] = $val['image_path'];
            $post_list[$val['page_id']]['date'] = $val['date'];
            $post_list[$val['page_id']]['sliderLinkText'] = $val['sliderLinkText'];
            $post_list[$val['page_id']]['content'] = $val['content'];
            $post_list[$val['page_id']]['last_updated'] = $val['last_updated'];
            $post_list[$val['page_id']]['site_controller'] = $val['site_controller'];
            $post_list[$val['page_id']]['sliderLinkText'] = "https://192.168.10.243/work-orders";
        }
			
		$select_array = array('site_controller','last_updated','custom_menus.content','category_id','page_title','post_category_map.page_id','quotations_data.image_path','quotations_data.date','quotations_data.sliderLinkText');
        $condition = array('user_type'=>'D');
        $this->CI->db->select($select_array);
        $this->CI->db->where($condition);
        $this->CI->db->from('post_category_map');
        $this->CI->db->join('custom_menus','post_category_map.page_id=custom_menus.page_id');
        $this->CI->db->join('quotations_data','custom_menus.page_id=quotations_data.page_id');
        $this->CI->db->order_by('quotations_data.last_updated','DESC');
         $this->CI->db->limit(2);
        $result=$this->CI->db->get()->result_array();
        //echo $this->CI->db->last_query();
        
        //exit;
       
        
        foreach($result as $key=>$val){
            $categories[$val['category_id']] = $val['category_id'];
            $post_list[$val['page_id']]['page_id'] = $val['page_id'];
            $post_list[$val['page_id']]['page_title'] = $val['page_title'];
            $post_list[$val['page_id']]['image_path'] = $val['image_path'];
            $post_list[$val['page_id']]['date'] = $val['date'];
            $post_list[$val['page_id']]['sliderLinkText'] = $val['sliderLinkText'];
            $post_list[$val['page_id']]['content'] = $val['content'];
            $post_list[$val['page_id']]['last_updated'] = $val['last_updated'];
            $post_list[$val['page_id']]['site_controller'] = $val['site_controller'];
            $post_list[$val['page_id']]['sliderLinkText'] = "https://192.168.10.243/quotations";
        }
        
         $select_array = array('site_controller','last_updated','custom_menus.content','category_id','page_title','post_category_map.page_id','faq.image_path','faq.date','faq.sliderLinkText');
        $condition = array('user_type'=>'D');
        $this->CI->db->select($select_array);
        $this->CI->db->where($condition);
        $this->CI->db->from('post_category_map');
        $this->CI->db->join('custom_menus','post_category_map.page_id=custom_menus.page_id');
        $this->CI->db->join('faq','custom_menus.page_id=faq.page_id');
        $this->CI->db->order_by('faq.last_updated','DESC');
        $this->CI->db->limit(2);
        $result=$this->CI->db->get()->result_array();
        //echo $this->CI->db->last_query();
        
        //exit;
       
        
        foreach($result as $key=>$val){
            $categories[$val['category_id']] = $val['category_id'];
            $post_list[$val['page_id']]['page_id'] = $val['page_id'];
            $post_list[$val['page_id']]['page_title'] = $val['page_title'];
            $post_list[$val['page_id']]['image_path'] = $val['image_path'];
            $post_list[$val['page_id']]['date'] = $val['date'];
            $post_list[$val['page_id']]['sliderLinkText'] = $val['sliderLinkText'];
            $post_list[$val['page_id']]['content'] = $val['content'];
            $post_list[$val['page_id']]['last_updated'] = $val['last_updated'];
            $post_list[$val['page_id']]['site_controller'] = $val['site_controller'];
            $post_list[$val['page_id']]['sliderLinkText'] = "https://192.168.10.243/faq";
        }
				
				
				
				
				$content="";
				$content.='<div class="col-md-4 news-update">
				<h6 class="">News & Updates</h6>
				<div class="card">
				  <div class="card-body news-update-img">
				  <marquee direction="up" scrollamount=3 onmouseover= stop() onmouseout= start()>  ';
				//print_R(); exit;
				foreach($post_list as $page_id=>$val)
				{

					

					$content.=' <p class="mb-2"> '.substr(strip_tags($val['page_title']),0,200).'</p>
					<p class=""><small class="read-post"><a href='.$val['sliderLinkText'].'>Read Post </a> </small> &nbsp; | &nbsp;
					  <small class="text-muted">Published on : '.date('d-m-Y H:i:s',strtotime($val['last_updated'])).' </small>
					</p>
					<div class="border-bottom mb-2"></div>';
				}
				$content.='  </marquee>
							 </div>
							</div>';
				
				return $content;
				
				
			$this->CI->db->select('*');
			$this->CI->db->where(array('section_id' => '9', 'category' => '1','status' => 'Enable'));
			$this->CI->db->order_by('id', 'desc');
            $this->CI->db->from('testimonials');
			$videoResult =$this->CI->db->get()->result();
			//echo '<pre';print_r($videoResult);exit;
			
			$this->CI->db->select('*');
			$this->CI->db->where(array('id' => '1'));
            $this->CI->db->from('tbl_map');
			$mapDTL =$this->CI->db->get()->result();
			//print_r($mapDTL);
			if($mapDTL[0]->open == 1)
			{
			    $target = "";
			}else
			{
			    $target = "_blank";
			}
			$content2.="
			<div class='row' style='padding: 0px;background: #fff;'>
              <div class='col-md-5 bg-aur'>
                <p class='a-map'>".$mapDTL[0]->title."</p>
                <img src='assets/cdma/css/aurangabad/images/".$mapDTL[0]->img."' class='img-fluid'>
                <a href='".$mapDTL[0]->link."' target='".$target."' class='btn btn-map'><i class='fas fa-street-view'></i>View Map</a>
            </div>";
            $content2.="<div class='col-md-7 bg-aur-right'>
                <span><img src='assets/cdma/css/aurangabad/images/news.png' class='img-fluid'></span> <span class='recent'>Recent
                    Announcements</span>
                <div class='pt20'>";
            $content2 .= "";
             
            $this->CI->db->select('*');
			$this->CI->db->where(array('cat' => '1', 'status' => 'Enable'));
			$this->CI->db->order_by('id', 'desc');
            $this->CI->db->from('apply_now_menu');
			$AnnunResult =$this->CI->db->get()->result();
			//echo '<pre>';print_r($AnnunResult);
			
			$this->CI->db->select('*');
			$this->CI->db->where(array('cat' => '2','status' => 'Enable'));
			$this->CI->db->order_by('id', 'desc');
            $this->CI->db->from('apply_now_menu');
			$textResult =$this->CI->db->get()->result();
			
			
            $i = 1;
            foreach($AnnunResult as $row)
			{
			    $target = ($row->open = 2) ? "_blank": "";
			        $content2.="
        				<div class='card-recent border-".$i."'>
                       <div class='row border-last'>
                            <div class='col-md-1 col-2 col-sm-1 text-center'>
                                <img src='assets/cdma/css/aurangabad/images/recent.png' class='img-fluid'>
                            </div>
                             <div class='col-md-10 col-10 col-sm-11 announcements'>
                              <a target= '".$target."' href='".$row->link."'> ".$row->title."<a>
                            </div>
                        </div>
                    </div>
        				";
			    
				
        	$i++;
			}  
			
            $content2.='
                     </div>
                    </div>
                  </div>
                 </div>';  
               $content2.='
               <div class="video_photo_main row">
               
                   <div class="photo_div col-md-6">
                      <div class="d-flex justify-content-end"> 
                        <div class="photo_txt pt-3"> Photo Gallery 
                        <div class="photo_txt_sml"><a href="#"> Click here to view Photo Gallery </a></div>
                        </div>
                        
                         <img src="/assets/300/2021/11/mediafiles/photo_gal.png">
                      </div> 
                   </div>
                   
                   <div class="video_div col-md-6">
                    <div class="d-flex justify-content-start"> 
                      <img src="/assets/300/2021/11/mediafiles/video_gal.png">
                        <div class="video_txt pt-3"> Video Gallery 
                        <div class="video_txt_sml"><a href="#"> Click here to view Video Gallery </a></div>
                        </div>
                        
                        
                      </div> 
                   
                   </div>
                   
               </div>
               
               ';
               
             $content2.='
             
             <section>
             
             <div class="row">
             <div class="col-md-4 handle1 pl-2 pr-3">
             <div style="height:580px; overflow:auto;">
             <a class="twitter-timeline" href="https://twitter.com/majhi_smart_bus?ref_src=twsrc%5Etfw">Tweets by majhi_smart_bus</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
             </div>
             
             </div>
             <div class="col-md-4 handle2 pr-3">
                <div  >
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FSmarterAurangabad%2F&tabs=timeline&width=440&height=590&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="570" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>
             </div>
             <div class="col-md-4 handle3 p-0">
                <div>
                   <iframe width="100%" height="180" src="https://www.youtube.com/embed/ld_TkFGxkcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
                </div>
                
                <div>
                   <iframe width="100%" height="180" src="https://www.youtube.com/embed/k58mTlh--TA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                
                <div>
                   <iframe width="100%" height="180" src="https://www.youtube.com/embed/_cmNvTPwq7M" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                
             </div>
             </div>
              
             </section>
             
             
             ';  
               
               
               
               
               $content2.='<div class="p0">
            <div class="row bg_img"  >';
            
            $i = 1;
            $x = 1;
            //echo '<pre>';var_dump($textResult);exit;
             $content2.='<div class="col-md-3 mt20 foot-ipad-pad "><ul class="right-li">';
            foreach($textResult as $txt)
            
            {
                
                if($txt->open == 1)
                {
                    $target = "_blank";
                }
                else
                {
                    $target = "";
                }
                     
                    if(($i % 5) == 0){
                          $content2.=' </ul></div><div class="col-md-3 mt20 foot-ipad-pad "> <ul class="right-li">';
                          $content2.='<a href="'.$txt->link.'" target="'.$target.'"> <li class="mt30"><i class="fas fa-angle-double-right bg-'.$x.' ml5"></i> '.$txt->title.' </li> </a>';
                    } else {
                         $content2.='<a href="'.$txt->link.'" target="'.$target.'"> <li class="mt30"><i class="fas fa-angle-double-right bg-'.$x.' ml5"></i> '.$txt->title.' </li> </a>';
                    }
                    // var_dump(($i % 5));
                   
                    
               $i++;
               $x++;
            }    
                 $content2.= "</ul></div>";
                // exit;
            $content2.='</div>
                        </div>';  
 
			return $content2;
			
			}
			else if($parameters['widget_type']==10)
			{
				$select_array=array('c.page_id','c.page_name','c.site_controller','c.is_custumlink','c.content','c.ts');
				$condition=array('p.widget_id'=>$parameters['widget_id']);
				$this->CI->db->select($select_array);
				$this->CI->db->from('custom_menus c');
				$this->CI->db->join('pagewidget p','p.page_id=c.page_id');
				$this->CI->db->where($condition);
				
				$result=$this->CI->db->get()->row_array();
				
				$content=substr($result['content'],-5000);
				$content.="<a class='btn btn-default btn-xs pull-right' href='".base_url().$result['site_controller']."'>Read More</a><br>";
				return $content;
			}
			else if($parameters['widget_type']==11)
			{
				$params = array('m.widget_id'=>$parameters['widget_id']);
				$widget_id_array=$this->CI->getMenuTypeId($params);
				$widget_nam=$this->CI->widget_desc($parameters['widget_id']);
				$group_by=array('s.ulbid','s.page_id');
				
				$condition=array('s.ulbid'=>$parameters['ulbid'],'s.langId'=>$parameters['langId'],'s.menu_type_id'=>$widget_id_array[0]['menu_type_id']);
				
				$select_array=array('s.page_id','s.menu_id','c.page_name','c.hover_title','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
				$this->CI->db->select($select_array);
				$this->CI->db->from('custom_menus c');
				$this->CI->db->join('site_main_menu s','s.page_id=c.page_id','inner');
				$this->CI->db->where($condition);
				//$this->CI->db->group_by($group_by);
				$this->CI->db->order_by('menu_id','ASC');
				$main_menus=$this->CI->db->get()->result_array();
				//echo $this->CI->db->last_query();
				
				
				
    			$this->CI->db->select('*');
    			$this->CI->db->where(array('section_id' => '11', 'id' => '1'));
                $this->CI->db->from('contact_dtl');
    			$contactResult =$this->CI->db->get()->row();
				//print_r($contactResult);exit;
				
				
				// $content='<div class="col-md-2 pt-4 footee">';
				// $content.="<h5>".$widget_nam['widget_name']."</h5>";
				 $content.="<ul>";
				foreach($main_menus as $key=>$val)
				{
					if($val['is_custumlink']=='1'){$base_url="";}else{$base_url=base_url(); }
					if($val['is_target_blank']=='2'){$target="target='_blank'";}else{$target="target='_self'"; }
					if($val['is_alert']=='1'){$class="class='confirmation'";}else{$class="class=''"; }
					
				

					$content.="  <li><a href='".$base_url.$val['site_controller']."'  ".$target." title='".$val['hover_title']."'>".$val['page_name']."</a></li>";
				}
				 $content.=" </ul>";
				
			
				
				// $content.="</div>";
				
				return $content;
				
				
			}
			
			else if($parameters['widget_type']==15)
			{
				$params = array('m.widget_id'=>$parameters['widget_id']);
				$widget_id_array=$this->CI->getMenuTypeId($params);
				$widget_nam=$this->CI->widget_desc($parameters['widget_id']);
				$group_by=array('s.ulbid','s.page_id');
				
				$condition=array('s.ulbid'=>$parameters['ulbid'],'s.langId'=>$parameters['langId'],'s.menu_type_id'=>$widget_id_array[0]['menu_type_id']);
				
				$select_array=array('s.page_id','s.menu_id','c.page_name','c.hover_title','c.controller','c.is_custumlink','c.is_target_blank','c.site_controller','c.is_alert');
				$this->CI->db->select($select_array);
				$this->CI->db->from('custom_menus c');
				$this->CI->db->join('site_main_menu s','s.page_id=c.page_id','inner');
				$this->CI->db->where($condition);
				//$this->CI->db->group_by($group_by);
				$this->CI->db->order_by('menu_id','ASC');
				$main_menus=$this->CI->db->get()->result_array();
				//echo $this->CI->db->last_query();
				
				
				
    			$this->CI->db->select('*');
    			$this->CI->db->where(array('section_id' => '15', 'id' => '1'));
                $this->CI->db->from('contact_dtl');
    			$contactResult =$this->CI->db->get()->row();
				//print_r($contactResult);exit;
				
				
			
    			$this->CI->db->select('*');
                $this->CI->db->from('tbl_visitors_counter');
    			$visitorsCounterCount =$this->CI->db->get()->num_rows();
				
				$content.='<div class="col-md-3 b-foot" style="">
                    <div class="row pl20 pr20 btm-c">
                        <div class="col-md-3 col-3 col-sm-1 pt20 pl0 pr0">
                            <img src="assets/cdma/css/aurangabad/images/btm-logo.png" class="img-fluid">
                        </div>
                        <div class="col-md-9 col-9 col-sm-11 aur-munc">
                            <p class="aur-text">AURANGABAD <span class="mun-text">MUNICIPAL CORPORATION</span></p>
                        </div>
                    </div>
                    <div class="socia">
                        <span>Follow Us on :</span>
                        <ul class="socia-li">
                            <li class="face"><a href="https://www.facebook.com/commr.abdmahapalika/" target="_blank"><i class="fab fa-facebook-f"></i> </a> </li>
                            <li class="twite"><a href="https://twitter.com/AurangabadSmart" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li class="google"><a href="https://www.youtube.com/channel/UCfty7aRYvcL3evtdIVytYUg" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            <li class="linkd"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>

                    </div>
                    <div class="border-top-foot">
                        <p class="vist">Visitors Counter</p>
                        <ul class="count">';
                        for($i = 0; $i<$visitorsCounterCount; $i++)
                        {
                            $array = str_split($visitorsCounterCount);
                            $content.='
                            <a href="#">
                                <li>'.$array[$i].'</li>
                            </a> ';
                        }
                        
                            
                         $content .='
                        </ul>
                    </div>
                </div>';
				
				$content.="</div>";
				
				return $content;
				
				
			}
			else if($parameters['widget_type']==13)
			{
				$content='<div class="panel panel-default">
				<div class="panel-heading">Telangana State Districts Under Municipalities</div>
				<div class="panel-body map_pad">
				
				<div id="info-box"></div>
				
				
				</div></div>
				';
				return $content;
			}else if($parameters['widget_type']==16)
			{
				$content='<div class="card card-form animate__animated animate__fadeIn form-fade">
					<div class="card-body ">
						<div class="form-login">
							<div>
								<h4>Login</h4>
							</div>
							<div><img src="/assets/jsb/images/login.svg" class="" alt="Login"></div>
						</div>
						<form class="mt-3">
							<div class="mb-2">
								<label  class="form-label">Select login Role</label>
								<select class="form-select">
									<option> -Select- </option>
								</select>
							</div>
							<div class="mb-2 user-input">
								<label  class="form-label">User Name</label>
								<img src="/assets/jsb/images/person.svg" class="img-fluid" alt="person">
								<input type="text" class="form-control">
							</div>
							<div class="mb-2 user-input">
								<label for="exampleInputPassword1" class="form-label">Password</label>
								<img src="/assets/jsb/images/lock.svg" class="img-fluid" alt="lock">
								<input type="password" class="form-control" id="exampleInputPassword1">
							</div>
							<div class="btn-submit">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
							<div class="form-img">
								<img src="/assets/jsb/images/threemans.svg" class="img-fluid" alt="threeman">
							</div>
						</form>
					</div>
				</div>
				';
				return $content;
			}else if($parameters['widget_type']==17)
			{
				$content='<img src="/assets/jsb/images/ap-map.svg" class="img-fluid ap-map" alt="ap-map" >
				';
				return $content;
			}
		}
		
		public function getGovtLinkstData($gove_widgets)
		{
 	 
			
			$this->CI->db->select('*');
			$this->CI->db->where(array('status' => 'Enable'));
            $this->CI->db->from('tbl_agenda_category_mst');
			$mstResult =$this->CI->db->get()->result();
			
			
			$this->CI->db->select('*');
			$this->CI->db->where(array('section_id' => '7', 'category' => '2','status' => 'Enable'));
            $this->CI->db->from('tbl_startups_partners');
			$PartnersResult =$this->CI->db->get()->result();
         
		 


			
			$content2.='  <div class="bg-footer">
                            <div class="container pt-3" style="color:#0d2958;">
                                <p class="schemes"><i class="fas fa-file-alt"></i><b> Schemes</b></p>
                                <div class="row pt-2 footer-btm">';
                                        foreach($mstResult as $keyval => $row)
                                        {
                                            if($keyval == 2)
                                            {
                                                $colmdval = '3';
                                            }
                                            else
                                            {
                                                $colmdval = '2';
                                            }
                                      	$content2.='  <div class="col-md-'.$colmdval.' footee">
                                                <p>'.$row->category.'</p>
                                                <ul>';
                                                
                                                $this->CI->db->select('*');
                                    			$this->CI->db->where(array('status' => 'Enable', 'category_id' => $row->id ));
                                                $this->CI->db->from('tbl_agenda_mst');
                                    			$childResult =$this->CI->db->get()->result();
                                    			echo $row->category_id;//exit;
                                    			foreach($childResult as $kval => $rowval)
                                                   {
                                                    if($rowval->open == 2)
                                                    {
                                                        $target = '_blank';
                                                    }
                                                    else
                                                    {
                                                        $target = '';
                                                    }
                                                        $content2.='<li class="pt-2"><a href="'.$rowval->link.'" target="'.$target.'">'.$rowval->text.'</a></li> ';
                                                   }
                                                
                                              $content2.= '</ul>
                                                
                                        </div>';
                                        }
                                   $content2.=' </div>
                                </div>
                                
                                
                        </div>
               ';
			// echo $content1;
			return $content2;  
		}
		
		public function footerWebsitePoliciess($ulbid)
		{
			$params=array('s.menu_type_id'=>11,'s.ulbid'=>$ulbid);
			$select_array=array('c.*','s.*');
			$group_by=array('s.ulbid','s.page_id');
			$this->CI->db->select($select_array);
			$this->CI->db->from('site_main_menu s');
			$this->CI->db->join('custom_menus c','c.page_id=s.page_id');
			$this->CI->db->where($params);
			//$this->CI->db->group_by($group_by);
			$result=$this->CI->db->get();
			//echo $this->CI->db->last_query();
			$content="";
			
			$content.="<p class='footer-links' style='text-align:center;'>";
			foreach($result->result() as $key=>$val)
			{
				$content.="<a href='".base_url().$val->controller."' title='".$val->hover_title."'>".$val->page_name."</a>";
			}
			$content.="</p>"; 
			//return $content;
			
		}
		
		public function getLayoutwidgets($params,$ulbid,$langId,$is_common_page,$left_menu_id)
		{
			//echo $left_menu_id;
			//echo $is_common_page;
			foreach($params as $page_layout_id=>$val)
			{
				$select_array=array('lwm.widget_id','wm.widget_type');
				$condition=array('lwm.page_layout_id'=>$page_layout_id,'lwm.ulbid'=>$ulbid,'wm.langId'=>$langId);
				$this->CI->db->select($select_array);
				$this->CI->db->from('layout_widget_map lwm');
				$this->CI->db->join('widget_mst wm','wm.widget_id=lwm.widget_id');
				$this->CI->db->where($condition);
				$this->CI->db->order_by('sort_order','ASC');
				$result=$this->CI->db->get();
				// echo $this->CI->db->last_query();
				
				if($page_layout_id =='100') // in case section is website policies
				{
					$widgetdata[$page_layout_id][]=$this->CI->footerWebsitePolicies($ulbid);
				}
				else
				{
					foreach($result->result() as $key=>$val2)
					{
						if($val2->widget_type==7)
						{
							$gove_widgets[$page_layout_id][$val2->widget_id]=$val2->widget_id;
							$layoutid[$page_layout_id]=$page_layout_id;
							
						}
						else
						{
							$widgetdata[$page_layout_id][]=$this->CI->getWidgetData($val2->widget_id,$is_common_page,$left_menu_id);
						}
					}
				}
			}
			
			foreach($layoutid as $key=>$val)
			{
				$widgetdata[$key][]=$this->CI->getGovtLinkstData($gove_widgets);
			}
			//print_r($gove_widgets);
			return $widgetdata;
		}
	}
?>