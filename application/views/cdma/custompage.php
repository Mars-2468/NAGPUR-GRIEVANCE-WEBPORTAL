 

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
        .gallery-cnt img{
            height: 450px;
            width: 100%;
            object-fit: cover;
            /*margin-bottom: 10px;*/
        }
        .gallery-cnt .col-md-3{
            padding: 10px;
        }
    
		p{
			margin-bottom:0rem !important;		
		}

		table tbody tr:first-child td,
		table thead tr:first-child td {
			background: #58ab43;  /* Green background for the first row */
			text-align: center;    /* Center-align the text */
		}
		
</style>
<style>
.menu-list li{list-style:none;margin-bottom:12px}
.menu-list li::before{content:"▶";margin-right:8px;color:#000;font-size:12px}
.menu-list a{color:#0d6efd;font-size:20px;text-decoration:none}
.menu-title{font-size:22px;font-weight:700;margin:20px 0 10px}
.menu-box{border:0px solid red;padding:20px}
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
			
			<!--<div class="breadcrumb_style">
				<?php //echo $breadcrumbs; ?>
			</div>-->
			
			<?php
		   
			$content="";
			
			foreach($layout_list as $key=>$val)
			{
				
			   
				$content.="<div class='".$val['code']."'>";
				$content.=$val['content'];
				$content.="</div>";
			}
		   
		   // echo str_replace("/assets",base_url()."assets",$content);
			$con =  str_replace("/assets",base_url()."assets",$content);
			echo  str_replace("..","",$con);

			?>
			

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
<script>
/*  $(document).ready(function() {
    $('table tbody a[href^="mailto:"]').each(function() {
      let originalHref = $(this).attr('href'); // mailto:srk.kumar@gmail.com
      let email = originalHref.replace('mailto:', '');

      // Replace . with "dot" and @ with "at"
      let replacedEmail = email.replace(/\./g, '[dot]').replace(/@/g, '[at]');

      // Update the href attribute to match replaced format (optional)
      // Usually mailto won't work with replaced characters, so better keep original href
      // But if you want to disable mailto, you can update href too

     $(this).attr('href', 'mailto:' + replacedEmail); // uncomment if you want to change href too
	$(this).attr('href', 'javascript:void(0);').css('text-decoration', 'none');
      // Replace the visible text
      $(this).text(replacedEmail);
	  
	 let textEmail = $('strong:contains("Email")').text();  // "Email : nmcegov@gmail.com"
let email2 = textEmail.split(':')[1].trim();            // "nmcegov@gmail.com"

// Replace '.' with 'dot' and '@' with 'at'
let obfuscated = email2.replace(/\./g, '[dot]').replace(/@/g, '[at]');
	  $('strong:contains("Email")').text('Email : ' + obfuscated);
    });
	
  });
  	
document.querySelectorAll("td").forEach(td => {
  let text = td.textContent.trim();
  // Check if it looks like an email address
  if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(text)) {
    let replacedEmail = text
      .replace(/\./g, "[dot]")
      .replace(/@/g, "[at]");
    td.textContent = replacedEmail;
  }
});  	
document.querySelectorAll("td p").forEach(td => {
  let text = td.textContent.trim();
  // Check if it looks like an email address
  if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(text)) {
    let replacedEmail = text
      .replace(/\./g, "[dot]")
      .replace(/@/g, "[at]");
    td.textContent = replacedEmail;
  }
});

document.querySelectorAll("p").forEach(td => {
  let text = td.textContent.trim();
  // Check if it looks like an email address
  if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(text)) {
    let replacedEmail = text
      .replace(/\./g, "[dot]")
      .replace(/@/g, "[at]");
    td.textContent = replacedEmail;
  }
});

 document.querySelectorAll("td").forEach(td => {
  // Get the HTML content, not just text — to preserve tags like <p>
  let html = td.innerHTML;

  // Match any email address pattern inside the text
  html = html.replace(
    /([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/g,
    function(match, user, domain) {
      return user.replace(/\./g, "[dot]") + "[at]" + domain.replace(/\./g, "[dot]");
    }
  );

  // Put the modified HTML back into the cell
  td.innerHTML = html;
});  */




function getVisibleText(node) {
  let s = '';
  for (const child of node.childNodes) {
    if (child.nodeType === Node.TEXT_NODE) s += child.textContent;
    else if (child.nodeType === Node.ELEMENT_NODE) s += getVisibleText(child);
  }
  return s;
}

/* const tdElements = Array.from(document.querySelectorAll('table tbody tr td'));
const updatedTexts = tdElements.map(td => {
  const visible = getVisibleText(td).trim();
  const obfuscated = visible
    .replace(/\[dot\]/gi, '[dot]')
    .replace(/\[at\]/gi, '[at]')
    .replace(/\./g, '[dot]')
    .replace(/@/g, '[at]');
  td.textContent = obfuscated; // replace content with plain obfuscated text
  return obfuscated;
}); */

</script>
   
   

</section>

