<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <a href="https://adminpmay.aurangabadmahapalika.org/<?php echo $this->session->userdata('userid')?>" class="btn-btn-primary" target="_blank">Pradhan Mantri Awas Yojana(Urban) Application form</a> -->
   
           <?php if($this->session->flashdata('error_message')){ ?> 
         <div class="container p-1 bg-warning" style="text-align:center;color:white;"><h1><?php echo $this->session->flashdata('error_message'); ?></h1></div>
              
          <?php } ?>
   
