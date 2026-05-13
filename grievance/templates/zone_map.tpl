{include file='header.tpl'}
{literal}
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script><!-- DATATABLE JS -->
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script><!-- BOOTSTRAP DATATABLE JS -->
<script>
function validateForm()
{
	var errors=0;
	
	var doc_desc=document.add_document.doc_desc.value;
	
	
	if(doc_desc == '')
    	{
		alert('Enter description');
		return false;
	}
		
	
}

function delete_rec(doc_id)
{
// var del=confirm("Are you sure you want to delete this record?");
//         if (del==true){
        
//           $.post("delete_doc.php",{doc_id:id},function(data)
// 	{
// 	$("#"+id).hide();
	
// 	$("#msg1").html(data);
// 	});
// 	} else {
//             return false;
//         }

if(confirm('Do You really want to delete this record'))
	    {
	    var csrf_token=$("#csrf_token").val();
		$.post('delete_doc.php',{doc_id:doc_id,csrf_token:csrf_token},function(data)
		{
			//alert(data);
			if(data==1)
			{
			alert('document deleted successfully');
			window.location='add_document.php';
			}
			else if(data==0)
		    {
		    alert('Unable to delete , Try again');
		    }
		    else if(data==3)
		    {
		    alert('Invalid token');
		    }
		    else if(data==4)
		    {
		    alert('csrf error');
		    }
		});
	}
}

</script>

<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#buss').click(function(){
       //alert();
      $('#ref').load('http://municipalservices.in/add_document.php #ref', function() {
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>



{/literal}




 <div class="row ">
	<div >
		<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar success">
                  <h4>Add Document</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
              
			<form  name='add_document' method='POST' action='add_document.php' class="form-horizontal" onSubmit="return validateForm()">
			    
			    <input type="hidden" name="token" value="{$token_id}"/>
			    <input type="hidden" name="csrf_token" value="{$csrf_token}" id="csrf_token"/>
			<input type='hidden' name='doc_id' value='0'>
				<div class="form-body">
					
					{if isset($msg)}
				<div class="{$class}">
					<button class="close" data-close="alert"></button>
					{$msg}
				</div>
				{/if}
					<div class="form-group">
						<label class="control-label col-md-3">Document Name :<span class="required">* </span></label>
							<div class="col-md-8">
								<input name='doc_desc' id='doc_desc' type="text" data-required="1" class="form-control"/ required="required">
							</div>
					</div>
					
						<div class="form-group">
						<label class="control-label col-md-3">Document Marathi :<span class="required">* </span></label>
							<div class="col-md-8">
								<input name='doc_desc_marathi' id='doc_desc_marathi' type="text" data-required="1" class="form-control"/ required="required">
							</div>
					</div>
					
					
				<!--	<div class="form-group" id="ref">
						<label class="control-label col-md-3">
						    <div style="border:1px solid #ccc;position: relative;left: 116px;top: -14px;background-image: url('/images/download.jpg');border-radius: 4px;width: 127px;text-align: center;color: red;
font-weight: bold;letter-spacing: 10px;font-size: 16px;" >
						        <p id="captImg" style="margin-top: 10px;">{$code}</p>
						    </div>
						</label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="captcha" placeholder="Enter Captcha" required="required" style="width: 385px;
border-radius: 3px;" onpaste="return false;" >
                    <input type="hidden" name="code" value="{$code}">
							</div>
							
					</div>
					
					<div class="col-md-6 col-md-offset-3">
                     <p>Can't read the image? click <a  id="buss" class="refreshCaptcha" style="cursor:pointer;">here</a> to refresh.</p>
					</div>-->
					
					
					
					
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info" name='save'>Submit</button>
						<!--<button type="button" class="btn btn-danger" onclick="this.form.reset();">Cancel</button>-->
						</div>
					</div>
				</div>
				
			</form>
		</div>
		</div>
	</div>
</div>




<div class="row" id="div_print">
		<div>
			<div class="boxed">
                <!-- Title Bart Start -->
                <div class="title-bar white">
                  <h4>Documents</h4>
                 
                </div>
                <!-- Title Bart End -->
                <div class="inner no-radius">
					<table class="table table-striped table-bordered table-hover table-full-width" id="data-table">
									
									<thead>
										<tr style="background-color:#2c3e50; color:#FFF;">
											<th>S.No</th>
											<th>Document</th>
											<th>Document Marathi</th>
											<th>Delete</th>
										
										</tr>
									</thead>
									
									<tbody>
									
									{foreach from=$doc_list item=row key=doc_id}
										<tr id="{$row.doc_id}">
											<td>{counter}</td>
											<td>{$row.doc_desc}</td>
											<td>{$row.doc_desc_marathi}</td>
											<td align="center">
					
		<button class="btn btn-danger" name='delete_rec' id='doc_id'  onclick="delete_rec('{$doc_id}')">  <span class="fa fa-trash"></span> Delete  </button>
									
											</td>
											
										</tr>
										{/foreach}
										
										
									</tbody>
								</table>
				</div>
			</div>
		</div>


{include file='footer_print.tpl'}
<br>

{include file='footer.tpl'}

