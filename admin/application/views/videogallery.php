<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>

<head>

     <link href="<?php echo base_url()?>assets/css/fontawesome/css/all.css" rel="stylesheet">
  
  <style>
      .text-block {
		position: absolute;
		bottom: 14px;
		right: 44px;
		background-color: #ff0000a8;
		color: white;
		padding: 9px;
}

.nothumnail{
    width:230px;
    height:160px;
    padding:15px;
    border:1px solid #ccc;
}
.bot{
    margin-bottom:10px;
}
  </style>
 


</head>

<body>
   

<div class="sh-pagebody">
    
    <div class="card bd-primary ">
         <div class="card-header bg-primary tx-white">Create Video Gallery</div>
         <div class="card-body ">
    
    
    <?php if($this->session->flashdata('message')){ ?>
    <div class="alert alert-success text-center"> 
    <?php echo $this->session->flashdata('message');?>
    </div>
    <?php } ?>

<input type="hidden" id="cnt" value='1'>

 <?php echo form_open('videos')?>
              
             <div id="advance_div" >
              <div class="row" >
              
              <div class="col-md-9">
                  <label> Embedded Code : </label>
                  <textarea style="margin-bottom:15px;" class="form-control" name='videono[]' id="album_desc" required="required" rows="5"></textarea>
                  <span class="error"></span>
                  
                  <label>Video Title </label>
                  <textarea style="margin-bottom:15px;" class="form-control" id="desc" name='desc[]'  required="required"  data-type="text" onkeyup="funInputFielTypes(this)" rows="5"></textarea>
                 <div id="descX" style="font-size:10px;color:red;"></div>
                  
              </div>
              
              <div class="col-md-3">
                  <label> &nbsp; </label>
                  <button type="button"  class="btn btn-success btn-sm" style="margin-top:62px;" onclick="addAdvance()";><i class="fa fa-plus"></i></button>
              </div>
              
              </div>
             </div>
             
             
             <center><input type="submit" name="save" class="btn btn-success btn-sm" value="Update"></center>
             <?php echo form_close(); ?>
             
             <br>
             <div class="card card-sm">
             <div class="mypagetitile" style="padding:5px;background-color:#e4eddb; margin-right: 0px;">Videos</div>
             
             
             
             <div class="row" style="padding:20px;">
                 
                 <?php foreach($videos->result_array() as $key=>$val){ ?>
                 
                 <div class="col-md-3 bot">
                   <div class="" style="text-align:center;">
                       
                    <?php 
                    if($val['is_iframe'] =='0')
                    {
                        ?>
                        
                        <img src="<?php echo $val['thumbnail_url']?>" width="230" height="160">
                        
                        <?php
                    }
                    else if($val['is_iframe'] =='1')
                    {
                        ?>
                        
                        <iframe width="230" height="160" src="<?php echo $val['thumbnail_url'];?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        
                        <?php
                    
                    }
                    else
                    {
                        echo "<div class='nothumnail' style='margin: auto;'><a href='".$val['thumbnail_url']."' target='_blank'>".$val['thumbnail_url']."</a></div>";
                    }
                    ?>
                  </div>
                  <div class="text-block" onclick="delete_rec(<?php echo $val['video_id']; ?>)"> 
        			<i class="fa fa-trash"></i>
        		  </div>
                 </div>
            <?php }?>
                 
                
                 
             </div>
           
              
             </div>   
           
</div>

	
	
</div>

	

</div>
</div>
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              	
              
              
             

<script>
    
    function delete_rec(slide_id)
    {
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        if(confirm('Are sure you want to delete this record'))
        {
            
            $.post('VideosController/deleteContent',{slide_id:slide_id,'csrf_test_name': csrf_value},function(data)
            {
                if(data=='1')
                {
                    alert('Successfully deleted');
                    window.location='<?php echo base_url(); ?>/videos';
                }
                else
                {
                    alert('Unable deleted');
                }
            });
        }
    }
    
function addAdvance()
{

 var divcontent;
    var i = document.getElementById('cnt').value;
   
	
    var j = i-1;
	
     var newdiv = document.createElement('div');
     newdiv.setAttribute('id', i);
	 newdiv.setAttribute('class', '');
     divcontent="";
	var tagid = 'desc' + j;
	var tagid2 = 'desc' + j + 'X';

	divcontent += "<div class='row'>";

	divcontent += "<div class='col-md-9'>";
	divcontent += "<label>Embedded Code : </label>";
	divcontent += "<textarea style='margin-bottom:15px;' rows='5' class='form-control' name='videono[]' id='album_desc' required></textarea>";
	divcontent += "<span class='error'></span>";

	divcontent += "<label>Video Title </label>";
	divcontent += "<textarea style='margin-bottom:15px;' class='form-control' id='" + tagid + "' name='desc[]' required='required' rows='5' data-type='text' onkeyup='funInputFielTypes(this)'></textarea>";
	divcontent += "<div id='" + tagid2 + "' style='font-size:10px;color:red;'></div>";             
					   
                   
               divcontent=divcontent + "</div>";
              
               divcontent=divcontent + "<div class='col-md-3'>";
                   divcontent=divcontent + "<label> &nbsp; </label>";
                   divcontent=divcontent + "<button type='button'  class='btn btn-success btn-sm' style='margin-top:62px;' onclick='addAdvance()'><i class='fa fa-plus'></i></button>";
                   divcontent=divcontent + "<button type='button'  class='btn btn-danger btn-sm' style='margin-top:62px;margin-left:5px;' onclick='fnRemove("+i+")'><i class='fa fa-minus'></i></button>";
                   divcontent=divcontent + "</div>";
                 divcontent=divcontent + "</div>";
            newdiv.innerHTML = divcontent;                                  
			document.getElementById('advance_div').appendChild(newdiv);
   
			document.getElementById('cnt').value = eval (document.getElementById('cnt').value) + 1 ;
			
    
  }
  
  function fnRemove(arg)
{
	
	
var d1=document.getElementById(arg).parentNode;
    var d2=document.getElementById(arg);
    d1.removeChild(d2); 
    var arg=arg-1;
  // document.getElementById('cnt').value=eval (document.getElementById('cnt').value) - 1 ;
   
   }

</script>
