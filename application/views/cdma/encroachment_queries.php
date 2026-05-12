 

<?php $colors=[
0=>'lightblue',
1=>'lightgreen',
2=>'lightgrey',
3=>'lightorange',
4=>'lightpink',
];

$flag=0;
?>
 <div style="background-color:#f2f2f2;">

<?php foreach($mainmenus as $mkey=>$mvalue) { 
			$pagename=str_replace(" ",'',$mainmenus[$mkey]['page_name']);
	?>
	
	<?php $tabcontents=$submenus[$mkey]; ?>
<?php if(!empty($tabcontents)){?>	
<div id="<?php echo $pagename;?>" class="tabcontent">

	<?php include('menu-card.php')?>
</div>
<?php } ?>

<?php } ?>



</div>
 <section>
  
<style>
  table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
  }
  th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
    vertical-align: middle;
    word-wrap: break-word;
  }
  th {
    background-color: #4CAF50;
    color: white;
  }
  .zone-header {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
    text-align: center;
    padding: 10px;
  }
  
   .col-sno {
    width: 5%;
  }
  .col-date {
    width: 15%;
  }
  .col-desc {
    width: 56%;
  }
  .col-file {
    width: 8%;
  }
  
  
</style>
<?php ini_set('display_errors',0); ?>

<?php
if($this->session->flashdata('message'))
{
    echo $this->session->flashdata('message');
}
?>

   

<!---- top navigation-->
<div class="clearfix"></div>
	<div class="main-content py-4"  onmouseout="openPage('',this , '')">
		<div class="container" style="text-align:justify">
			
			
			<?php foreach($encroachment_queries as $key=>$enc_query){

				if(count($encroachment_queries[$key]['queries'])>0){
				?>
				
				<div class="table table-responsive">
				<table class="table table-striped table-bordered">
					<tr>
						<th colspan="6" class="text-center"><?php echo $encroachment_queries[$key]['dept_desc']; ?></th>
					</tr>
					<tr>
						<th style="text-align: center; vertical-align: middle;" class="text-center col-sno" rowspan="2">S.No</th>
						<th style="text-align: center; vertical-align: middle;" class="text-center col-date" rowspan="2">Date</th>
						<th style="text-align: center; vertical-align: middle;" rowspan="2" class="col-desc" >Description</th>
						<th class="text-center" colspan="3">Download File</th>
					</tr>	
					<tr>						
						<th class="text-center" class="col-file" >Show Cause Notice</th>
						<th class="text-center" class="col-file" >Applicant Reply</th>
						<th class="text-center" class="col-file" >Answer</th>
					</tr>
					<?php $sno=1;
					foreach($encroachment_queries[$key]['queries'] as $ekey=>$edata){ ?>
						<tr>
							<td class="text-center"><?php echo $sno++; ?></td>
							<td class="text-center"><?php echo $encroachment_queries[$key]['queries'][$ekey]['created_at']; ?></td>
							<td><?php echo $encroachment_queries[$key]['queries'][$ekey]['description']; ?></td>
							<td class="text-center"> 							
								<?php  
									$show_cause_notice_path = explode(".", $encroachment_queries[$key]['queries'][$ekey]['show_cause_notice']);
									if(in_array($show_cause_notice_path[3],['jpg','jpeg','png'])){ ?>							
										<a href="<?php echo base_url().$encroachment_queries[$key]['queries'][$ekey]['show_cause_notice'];?>" download>
											<img src="<?php echo base_url().'assets/nmc/images/icon6.png';?>" style="width:50px;height:50px;"> 
										</a>
									<?php }else{ ?>
										<a href="<?php echo base_url().$encroachment_queries[$key]['queries'][$ekey]['show_cause_notice'];?>" download="showcausenotice">
											<img src="<?php echo base_url().'assets/nmc/images/pdf_image.png';?>" style="width:50px;height:50px;"> 
										</a>
								<?php } ?>								
							</td>
							<td class="text-center"> 
								<?php  
									$applicant_reply_path = explode(".", $encroachment_queries[$key]['queries'][$ekey]['applicant_reply']);
									if(in_array($applicant_reply_path[3],['jpg','jpeg','png'])){ ?>							
										<a href="<?php echo base_url().$encroachment_queries[$key]['queries'][$ekey]['applicant_reply'];?>" download="applicantreply">
											<img src="<?php echo base_url().'assets/nmc/images/icon6.png';?>" style="width:50px;height:50px;"> 
										</a>
									<?php }else{ ?>
										<a href="<?php echo base_url().$encroachment_queries[$key]['queries'][$ekey]['applicant_reply'];?>" download="applicantreply">
											<img src="<?php echo base_url().'assets/nmc/images/pdf_image.png';?>" style="width:50px;height:50px;"> 
										</a>
								<?php } ?>	
							</td>
							<td class="text-center"> 
								<?php  
									$answer_path = explode(".", $encroachment_queries[$key]['queries'][$ekey]['answer']);
									if(in_array($answer_path[3],['jpg','jpeg','png'])){ ?>							
										<a href="<?php echo base_url().$encroachment_queries[$key]['queries'][$ekey]['answer'];?>" download="applicantreply">
											<img src="<?php echo base_url().'assets/nmc/images/icon6.png';?>" style="width:50px;height:50px;"> 
										</a>
									<?php }else{ ?>
										<a href="<?php echo base_url().$encroachment_queries[$key]['queries'][$ekey]['answer'];?>" download="applicantreply">
											<img src="<?php echo base_url().'assets/nmc/images/pdf_image.png';?>" style="width:50px;height:50px;"> 
										</a>
								<?php } ?>	
							</td>
						</tr>
					<?php  } ?>
				</table>
				</div>
				
			<?php }} ?>
			
			

		</div>
	</div>

<?php 
/*  foreach($customepagelayouts->result() as $key=>$val){
			if($val->is_in_loop_section=='1')
			{
				
				$content1.= $val->open_tags;
				foreach($layoutwidgets[$val->page_layout_id] as $key2=>$val2){
					$content1.=$val2;
				}
				$content1.= $val->closing_tags;
				
			}
		}
    
     echo str_replace("/assets",base_url()."assets",$content1); */
?>
	
<!--
<div class="container-fluid1 bg-footer">
	<div class="row">
		<div class="text-center">
			<p class=" mb-0 p-2">© All Copyrights reserved - 2023 </p>
		</div>
	</div>
</div>
   <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>-->
   
   
   <script>
   
   document.querySelector(".myfooter").classList.remove("myfooter");
    //$(".myfooter").style.pointerEvents = "none";
   
   function getSubcaste(cast_id)
   {
        $.get('get-subcast',{cast_id:cast_id},function(data)
           {
               
               $("#subcast").html(data);
           });
   }
   
   function chkotherdistrict()
   {
        if (document.getElementById('checkbox1').checked) {
            $("#autoUpdate").show();
            $("#mandal_id").removeAttr('required');
            $("#village_id").removeAttr('required');
            $("#other_district_remarks").attr('required',true);
        } else {
             $("#autoUpdate").hide();
              $("#mandal_id").attr('required',true);
            $("#village_id").attr('required',true);
            $("#other_district_remarks").removeAttr('required');
        }
   }
       function getVillages(mandal_id)
       {
          
           $.get('get-villages',{mandal_id:mandal_id},function(data)
           {
               
               $("#village_id").html(data);
           });
       }
       
       function getMandal(district_id)
       {
           alert(district_id);
            $.get('get-mandals',{district_id:district_id},function(data)
           {
               $("#mandal_id").html(data);
           });
       }
   </script>
   
   <input type="hidden" id="teval" value="">
<input type="hidden" id="url" value='<?php echo base_url(); ?>'>

<a id="scroll-top"></a>
 
 
<script>
		 $(document).ready(function(){
	   $('.slider').slick({
	dots: false,
	arrows:true,
	autoplay: true,
    autoplaySpeed: 2000,

    slidesToShow: 1,
  slidesToScroll: 1
});

			 });
			 
			
	   </script>
   
   

</section>

