<?php
if(isset($_POST['save']))
{
	echo $_POST['content'];
}
?>


<!DOCTYPE html>

<html lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
<script type="text/javascript" src="jquery.tinymce.min.js"></script>

<script type="text/javascript" src="tinymce.min.js"></script>
<script type="text/javascript" src="tinymcejs"></script>
<script type="text/javascript" src="jquery.tinymce.js"></script>

<script>
	tinymce.init({
		selector : '#richTextArea',
		plugins : 'image,table',
		
		

		images_upload_url : 'upload.php',
		automatic_uploads : false,

		images_upload_handler : function(blobInfo, success, failure) {
			var xhr, formData;

			xhr = new XMLHttpRequest();
			xhr.withCredentials = false;
			xhr.open('POST', 'upload.php');

			xhr.onload = function() {
				var json;

				if (xhr.status != 200) {
					failure('HTTP Error: ' + xhr.status);
					return;
				}

				json = JSON.parse(xhr.responseText);

				if (!json || typeof json.file_path != 'string') {
					failure('Invalid JSON: ' + xhr.responseText);
					return;
				}

				success(json.file_path);
			};

			formData = new FormData();
			formData.append('file', blobInfo.blob(), blobInfo.filename());

			xhr.send(formData);
		},
	});
</script>
</head>

<body>
    <h2>PHP Image Upload using TinyMCE Editor</h2>
	<form action="" method="post" enctype="multipart/form-data">
    <textarea id="richTextArea" name="content"></textarea>
	<input type="submit" name="save">
	</form>
</body>
</html>