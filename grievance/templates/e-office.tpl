{include file='header.tpl'}
{literal}
<link rel="stylesheet" type="text/css" href="css/styles.css"><!-- Tempalet Skeleton CSS -->
	<link rel="stylesheet" type="text/css" href="assets/editors/wysihtml5/bootstrap-wysihtml5.css"/><!-- wysihtml5 css -->
	<link rel="stylesheet" type="text/css" href="assets/editors/summernote/summernote.css"/><!-- summernote css -->
<script>



function validateForm()
{
	

	description=$("#description").val();
				
    	if(description =='')
    	{
		alert("Please Enter Description");
		return false;    	
    	}
    	else
    	{
    	return true;
    	}
    	
   	
	
}


function fill(cat_id,descriptin,dept_id)
{
	
	document.add_category.cat_id.value=cat_id;
	document.add_category.description.value=descriptin;
	document.add_category.type.value=1;
	$("#dept_id").val(dept_id);
	
} 
</script>
{/literal}





 <div class="row ">
	<div class="col-lg-12">
		
		{if $uid eq 'Warangal'}
		<iframe src="https://gwmc.eoffice.telangana.gov.in/acl_users/credentials_cookie_auth/require_login?came_from=https%3A//gwmc.eoffice.telangana.gov.in/" frameborder="0" width="100%" height="800"></iframe>
		{else}
        <iframe src="https://eoffice.telangana.gov.in" frameborder="0" width="100%" height="800"></iframe>
        {/if}
        
        
		</div>
	</div>
</div>









{include file='footer.tpl'}

{literal}
<script  src="assets/editors/wysihtml5/wysihtml5-0.3.0.js"></script><!-- wysihtml5 JS -->
	<script  src="assets/editors/wysihtml5/bootstrap-wysihtml5.js"></script><!-- wysihtml5 JS -->
	<script  src="assets/editors/summernote/summernote.js"></script><!-- summernote JS -->
	 <script src="assets/editors/ckeditor/ckeditor.js" ></script><!-- Summernote js -->
	<script src="js/page/editors.js"></script><!-- EDITOR PAGE JS -->
{/literal}