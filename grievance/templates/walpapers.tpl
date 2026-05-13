{include file='header.tpl'}
{literal}
<script>
function delete_rec(id)
{
	if(confirm('Do You really want to delete this reecord'))
	{
	$.post('ajax_delete_media_coverage_image.php',{id:id},function(data)
	{
	alert(data);
	window.location="media_coverage.php";
	});
	}
}
 
</script>
{/literal}





 



 
<div class="row" id="div_print">
		<div class="col-lg-12">
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>EXISTING IMAGES</h4>
                  
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
		<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
				<thead>
					
					<tr style="background-color:#2c3e50; color:#FFF;">
					  	<th>S.No</th>
					  	<th>IMAGE</th>
					  	<th >UPDATE</th>
					  	<th >DELETE</th>
					  	  	
					  </tr>
				</thead>
				
				<tbody>
					
					{assign var="i" value=1}
				 {foreach from=$data item=row key=id}
				  <tr>
				   	<td>{counter} </td>
					 <td>
					 <img src="{$row.images}" width="200px" height="200px">
					 
					 </td>
					 
					 <td>
					 <form action="walpapers.php" method="post" enctype="multipart/form-data">
					 <input type="file" name="f1" id="f1">
					 <input type="hidden" name="imageid" id="imageid" value="{$id}">
					 <input type="hidden" name="content_no" id="content_no" value="{$content_no}">
					 <input type="hidden" name="previous_image" id="previous_image" value="{$row.images}">
					 <input type="submit" name="update" value="UPDATE" class="btn btn-success">
					 </form>
					 </td>
					 <td><input type="button" onclick="delete_rec('{$id}')" value="Delete" class="btn btn-danger"> </td>
					 
				 </tr>
				 {assign var="i" value=$i+1}
				  {/foreach}
						
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
{literal}
<script src='../js/jquery.min.js'></script>
<script>
$(document).ready(function() {

$(".num").keypress(function (e) {
     
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
         }
    });



             

}); 
</script>
{/literal}

<br>



{include file='footer.tpl'}

