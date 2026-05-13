{include file='header.tpl'}
{literal}
<script>
function check_availability()
{
	var user_id=document.add_user.user_id.value;
	var patt1= /^[a-zA-Z][a-zA-Z0-9]{4,}$/;
	if(!patt1.test(user_id))
    	{
		alert("User ID must Start with letter and can contain letters/numbers, 6-10 characters");
		return false;    	
	}
	else
	{
		if (window.XMLHttpRequest)
			xmlhttp=new XMLHttpRequest();
		else
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var str=xmlhttp.responseText;
				if(str==0)
				{
					$('#user_id').attr('readonly', true);
					$("#area").show();
				}
				else
				{
					alert("Already In use, Please select another ID");
					$("#area").hide();
				}
			}
		}
		xmlhttp.open("GET","check_availability.php?user_id="+user_id,true);
		xmlhttp.send();
	}
	    
}


function fun1()
{
	
	
	$("#add_council").submit();
	
}


function fill(cat_id,descriptin,dept_id)
{
	
	document.add_category.cat_id.value=cat_id;
	document.add_category.description.value=descriptin;
	document.add_category.type.value=1;
	$("#dept_id").val(dept_id);
	
} 
</script>


<!--

<script>

function check()
{
	var mobile=$("#mobile").val();
	var user_id=$("#user_id").val();
	$.post("check_mobile.php",{mobile:mobile,user_id:user_id},function(data)
	{
	alert(data);
	});
}

</script>

-->


{/literal}





 <div class="row ">
	<div class="">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Special Officers</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                

               
			
					
					
					<div class="form-body">
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}



<input type="hidden" name="cid" value="3">
<input type="hidden" name="previous_image" value="{$data.img_url}">

					
					
					
					

						<div class="">
                        <div class="col-md-6">
                        
                       
                            
                            <a href="add_council.php" >
                            	<div class="the-box bg-dark" style="border-radius: 6px; background-color:#00bff3; display: table; width: 100%;">
                            	    <div class="col-md-10">
                            	    
                                  	<h4 class="small-title" style="color:#000 !important;">
                                 	 <span><i class="fa fa-plus-circle" style="color:#FFF;"></i></span> <strong>Add Councillor</strong>
                                 	 </h4>
                                	  <p class="text-justify" style="color:#fff;">
                                 	  Click here to Add Councillor
                                 	 </p>
                                 	 </div>
                                 	 
                                 	 <div class="col-md-2"><i class="fa fa-user" style="font-size: 47px; padding-top: 11px; color: #FFF;"></i></div>
                                 	 
                           		 </div>
                       		 </a>
                       		 
                   		
                   		 <div class="col-md-2">
                   		     
                   		 </div>
                   		 
                   		 
                   		 </div>
                         
                         <div class="col-md-6">
                         <a href="special_officers.php" >
                    	<div class="the-box bg-danger" style="border-radius: 6px; display: table; width:100%;">
                    	    <div class="col-md-10">
                      	<h4 class="small-title" style="color:#000 !important;">
                     	   <span><i class="fa fa-pencil-square" style="color:#FFF;"></i></span><strong>  Add Special Offecers </strong>
                     	 </h4>
                    	  <p class="text-justify">
                     	  Click here to Add Special Offecers
                     	 </p>
                     	 </div>
                     	 
                     	 <div class="col-md-2"><i class="fa fa-users" style="font-size: 47px; padding-top: 11px; color: #FFF;"></i></div>
                     	 
                     	 
                   		 </div>
                   		 </a>
                   		 </div>
                         
                    <!-- /.the-box -->
                 		 </div>		
					
					
				</div>
				
			
		</div>
		</div>
	</div>
</div>









{include file='footer.tpl'}

