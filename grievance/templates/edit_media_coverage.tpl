{include file='header.tpl'}
{literal}
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script>

function delete_rec(content_no)
{
	if(confirm('Do You really want to delete this reecord'))
	{
	$.post('ajax_delete_media_coverage.php',{content_no:content_no},function(data)
	{
	alert(data);
	window.location="media_coverage.php";
	});
	}
}
 
</script>
<script>

function addAdvance()
{
	
	
	var divcontent;
    var i = document.getElementById('cnt').value;
    var j = i-1;
	
     var newdiv = document.createElement('tr');
     newdiv.setAttribute('id', i);
	 newdiv.setAttribute('class', 'addrow');
     divcontent="";
     
		    divcontent=divcontent + "<td >";
            divcontent=divcontent + "Image:<input type='file' name='file[]' id='file[]'  class='validate[required]'>";
            divcontent=divcontent + "</td>";
			
			divcontent=divcontent + "<td style='padding:5px;'><input type='button' value='Remove' class='btn btn-default' onclick='fnRemove(" + i +");' /></td>";
			divcontent=divcontent + "</tr>";
			
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
{/literal}





 <div class="row ">
	<div class="col-lg-12">
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Update Media Coverage</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
                <form method="post" name='manage_desg_del'  action="manage_desg_del.php">
		<input type='hidden' name='desg_id' vlaue=''>
		</form>

               
			<form   method="post" action="edit_media_coverage.php" name="manage_desg"  class="form-horizontal" enctype="multipart/form-data" onSubmit="return validateForm()">
		    <input type="hidden" name="token" value="{$token_id}" />
			<input type='hidden' name='desg_id' value='0'>
			<input type='hidden' name='content_no' value="{$content_no}">
			<input type="hidden" name="cnt" id="cnt" value="1" />
				<div class="form-body">
				
				{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Date <span class="required">* </span></label>
							<div class="col-md-5">
							<input name='edition_date' id="datepicker" type="text" data-required="1" value="{$data.edition_date}" class="form-control datepicker" required/>
									
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Title: <span class="required">* </span></label>
							<div class="col-md-5">
							<textarea name="title" id="title" class="form-control char" required>{$data.title}</textarea>
							</div>
					</div>
					
						<div class="form-group">
						<label class="control-label col-md-3">Title Marathi: <span class="required">* </span></label>
							<div class="col-md-5">
							<textarea name="title_marathi" id="title_marathi" class="form-control char" required>{$data.title_marathi}</textarea>
							</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3">Description: <span class="required">* </span></label>
							<div class="col-md-5">
					<textarea name="description" id="description" class="form-control char" style="width:600px;height:300px;" required>{$data.description}</textarea>
							</div>
					</div>
					
						<div class="form-group">
						<label class="control-label col-md-3">Description Marathi: <span class="required">* </span></label>
							<div class="col-md-5">
					<textarea name="desciption_marathi" id="desciption_marathi" class="form-control char" style="width:600px;height:300px;" required>{$data.desciption_marathi}</textarea>
							</div>
					</div>
					
					<!--<div class="form-group input_fields_wrap">
						<label class="control-label col-md-3">Image: <span class="required">* </span></label>
							<div class="col-md-5">
						<input type="file" name="file[]" multiple="multiple" >
						
						</div>
							<div class="col-md-2"><input type="button" onclick="addAdvance()" value="Add More"></div>
							
					</div>
					<table class="table" id="advance_div">

					</table>-->
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save' value='Add / Update Ward'>Submit</button>
						
						<a href="media_coverage.php"><button type="button" class="btn btn-danger">Back</button></a>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>







{include file='footer.tpl'}
{literal}
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.js"></script>
<script>
$(function() {
    $( "#datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true,maxDate:0});
});
</script>
{/literal}

