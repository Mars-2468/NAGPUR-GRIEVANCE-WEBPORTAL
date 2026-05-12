<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CategoryFunctions
{
    function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->helper('captcha');
    }
    
    function getTenderform()
    {
        
                        $vals = array(
                        'word'          => '',
                        'img_path'      => "assets/captcha/",
                        'img_url'       => base_url()."assets/captcha/",
                        'font_path'     => 'system/fonts/texb.ttf',
                        'img_width'     => '150',
                        'img_height'    => 30,
                        'expiration'    => 7200,
                        'word_length'   => 8,
                        'font_size'     => 16,
                        'img_id'        => 'Imageid',
                        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                
                        // White background and border, black text and red grid
                        'colors'        => array(
                                'background' => array(255, 255, 255),
                                'border' => array(255, 255, 255),
                                'text' => array(0, 0, 0),
                                'grid' => array(255, 40, 40)
                        )
                );
                
                 $cap = create_captcha($vals);
                 $data = array(
                'captcha_time'  => $cap['time'],
                'ip_address'    => $this->CI->input->ip_address(),
                'word'          => $cap['word']
                    );

                $query = $this->CI->db->insert_string('captcha', $data);
                $this->CI->db->query($query);
                 
                 // reference link https://www.codexworld.com/implement-captcha-codeigniter-captcha-helper/
                 
                 
                 
                
        
        
        
      $content="<div class='form-horizontal'>";
     
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'>Date of Release of Tender</label>";  
              $content.="<div class='col-md-5'>";
              $content.="<input id='textinput' name='textinput' placeholder='Enter Date of Release of Tender' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";
            	
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'>Last Date for Submission of Tender</label>";   
              $content.="<div class='col-md-5'>";
              $content.="<input   placeholder='Enter Last Date for Submission' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";
            
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'>Date for Opening of Technical Bid</label>";  
              $content.="<div class='col-md-5'>";
              $content.="<input  placeholder='Enter Date for Opening of Technical Bid' class='form-control input-md' type='text' id='datepickerfrom'>";  
              $content.="</div>";		
            $content.="</div>";
            	
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'>Date for Opening of Financial Bid</label>";  
              $content.="<div class='col-md-5'>";
               $content.="<input  placeholder='Enter Date for Opening of Financial Bid' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";
            		
            	
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'>Tender website address</label>";  
              $content.="<div class='col-md-5'>";
               $content.="<input  placeholder='Enter Tender website address' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";	
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'>Tender ID or Number</label>";  
              $content.="<div class='col-md-5'>";
                $content.="<input  placeholder='Enter ID or Number' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";	
            		
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'> Tender EMD Fees</label>";  
              $content.="<div class='col-md-5'>";
                $content.="<input  placeholder='Enter Tender EMD Fees' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";	
            	
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'> Tender Processing Fee</label>";  
              $content.="<div class='col-md-5'>";
                $content.="<input  placeholder='Enter Tender Processing Fee' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";	
            		
            	
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'> Type of tender</label>";  
              $content.="<div class='col-md-5'>";
            	  $content.="<select  class='form-control'>";
            		$content.="<option value='0'>- Select - </option>";
                  $content.="<option value='1'>Bid</option>";
                  $content.="<option value='2'>EOI</option>";
                  $content.="<option value='2'>RFP</option>";
                  
                $content.="</select>";
              $content.="</div>";		
            $content.="</div>";		
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'> Contact person name</label>";  
              $content.="<div class='col-md-5'>";
                $content.="<input  placeholder='Enter Contact person name' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";	
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'> Designation</label>";  
              $content.="<div class='col-md-5'>";
                $content.="<input  placeholder='Enter Designation' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'> Mobile Number</label>";  
              $content.="<div class='col-md-5'>";
                $content.="<input  placeholder='Enter Valid Mobile Number' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'>  Email id</label>";  
              $content.="<div class='col-md-5'>";
                $content.="<input  placeholder='Enter Contact person name' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'> Tender Documents upload</label>";  
              $content.="<div class='col-md-5'>";
                $content.="<input  placeholder='Enter Contact person name' class='form-control input-md' type='file'>";  
              $content.="</div>";		
            $content.="</div>";
            
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'>  Add Corrigendum</label>";  
              $content.="<div class='col-md-5'>";
               $content.="<select  class='form-control'>";
            		$content.="<option value='0'>- Select - </option>";
                  $content.="<option value='1'>1</option>";
                  $content.="<option value='2'>2</option>";
                  $content.="<option value='3'>3</option>";  
            	     $content.="<option value='23'>23</option>"; 
                $content.="</select>";
              $content.="</div>";		
            $content.="</div>";	
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'> Upload document</label>";  
              $content.="<div class='col-md-5'>";
                $content.="<input  placeholder='Enter Contact person name' class='form-control input-md' type='file'>";  
              $content.="</div>";		
            $content.="</div>";
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'> any date extended?</label>";  
              $content.="<div class='col-md-5'>";
               $content.="<select  class='form-control'>";
            	  $content.="<option value='0'>- Select - </option>";
                  $content.="<option value='1'>Yes</option>";
                  $content.="<option value='2'>On</option>";
                  
                $content.="</select>";
              $content.="</div>";		
            $content.="</div>";
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'> New final date for submission</label>";  
              $content.="<div class='col-md-5'>";
                $content.="<input  placeholder='Enter Contact person name' class='form-control input-md' type='text'>";  
              $content.="</div>";		
            $content.="</div>";
            		
            		
            		
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'>Captcha</label>";  
              $content.="<div class='col-md-5'>";
              $content.=$cap['image'];
              $content.="</div>";		
            $content.="</div>";
            $content.="<div class='form-group'>";
              $content.="<label class='col-md-5 control-label' for='textinput'></label>";  
              $content.="<div class='col-md-5'>";
              $content.="<input class='btn btn-success btn-xs' value='Submit' type='submit'>";
            	  $content.="<input class='btn btn-info btn-xs' value='Reset' type='reset'>";
              $content.="</div>";		
            $content.="</div>";
            		
            	
            	$content.="</div>";
        
        echo $content;
    }
    
    public function postform()
    {
        echo "default form";
    }
}
?>