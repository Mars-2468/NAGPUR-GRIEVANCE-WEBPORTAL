<?php 
require('Smarty.class.php'); 

class Smarty_cti extends Smarty 
{ 
    
      function __construct() 
         { 
            parent::__construct(); 
            
           $this->setTemplateDir( 'home/municipalservce/public_html/templates'); 
           $this->setCompileDir( 'home/municipalservce/public_html/templates_c'); 
           $this->setConfigDir( 'home/municipalservce/public_html/configs'); 
           $this->setCacheDir('home/municipalservce/public_html/cache'); 
          
           //$this->caching = true; 
           $this->assign('app_name', 'cti'); 
         } 
} 
?>