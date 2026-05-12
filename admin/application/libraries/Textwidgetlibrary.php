<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Textwidgetlibrary
{
    function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }
    
    function getForm()
    {
        $content="<div class=''>";
         $content.="<textarea id='richTextArea' name='content' style='width:100%; height:400px;'></textarea>";
        $content.="</div>";
        
        return $content;
    }
}
?>