<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo $widget_det['widget_type'];
//print_r($result);
?>


<?php

//var_dump($widget_det['widget_type']);die('sss');

switch($widget_det['widget_type'])
{
    case 1:
        $this->load->view('customwidgets/editmenuwidget',$widget_det,$menunames);
        break;
    case 2:
        $this->load->view('customwidgets/edittextwidget',$result);
        break;
     case 4:
        $this->load->view('customwidgets/editgalleryuwidget',$widget_det,$result);
        break;    
    case 5:
        $this->load->view('customwidgets/editimagetextwidget',$result,$widget_det,$target_type);
        break;
    case 6:
        $this->load->view('customwidgets/editmenuwidget',$widget_det,$menunames);
        break;
    case 7:
        $this->load->view('customwidgets/editimagetextwidget',$result,$widget_det,$target_type);
        break;    
    case 8:
        $this->load->view('customwidgets/edittabwidget',$widgetdet);
        break;
    case 9:
        $this->load->view('customwidgets/editpostwidget',$widgetdet);
        break;
    case 10:
        $this->load->view('customwidgets/editpagewidget',$widgetdet);
        break;    
    case 11:
        $this->load->view('customwidgets/editmenuwidget',$widgetdet);
        break;
    case 12:
        $this->load->view('customwidgets/editsliderwidget',$widget_det,$result);
        break;
        
}
?>


        
            
            
          
   
