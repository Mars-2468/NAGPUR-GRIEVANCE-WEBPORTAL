<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);
?>

<script src="<?php echo base_url()?>assets/editors/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/editors/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/editors/jquery.tinymce.min.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>assets/editors/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/editors/tinymce.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/editors/jquery.tinymce.js"></script>

<script>
	tinymce.init({
		selector : '#richTextArea',
		plugins : 'image,table,code',
		toolbar:'code',
		language: 'zh_CN',
		
		

		images_upload_url : 'UploadController/uploadEditorFile',
		automatic_uploads : false,

		images_upload_handler : function(blobInfo, success, failure) {
			var xhr, formData;

			xhr = new XMLHttpRequest();
			xhr.withCredentials = false;
			xhr.open('POST', 'UploadController/uploadEditorFile');

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

<body>
    
    <div class="sh-pagebody">
          
  
              
    
    <!--<h2>About Municipality</h2>-->
    <?php echo form_open_multipart('about')?>
	
    <textarea id="richTextArea" name="content" style="width:100%; height:500px;"><?php if($aboutData[0]['content'] !=''){echo $aboutData[0]['content'];} ?></textarea>
	
	<div style="text-align:center;margin-top:10px;">
	<input type="submit" name="save" value="save" class="btn btn-success btn-sm">
	</div>
	
	</div>
	</div>
	
	</div>
	
    <?php echo form_close();?>
    
    <!--
    <link href="<?php echo base_url()?>assets/ckeditor/theme/css/fonts.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/ckeditor/theme/css/sdk.css" rel="stylesheet">
	<script src="<?php echo base_url()?>assets/ckeditor/vendor/ckeditor/4.9.2/ckeditor.js"></script>
	<script src="<?php echo base_url()?>assets/ckeditor/samples/assets/picoModal-2.0.1.min.js"></script>
	<script src="<?php echo base_url()?>assets/ckeditor/samples/assets/contentloaded.js"></script>
	<script src="<?php echo base_url()?>assets/ckeditor/samples/assets/simplesample.js"></script>
	<script src="<?php echo base_url()?>assets/ckeditor/samples/assets/beautify-html.js"></script>
	
	<script>
		if ( location.hostname == 'sdk.ckeditor.com' ) {
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-271067-15', 'auto');
			ga('send', 'pageview');
		}
	</script>



	
	
	<textarea cols="80" id="editor1" name="editor1" rows="10" data-sample="1" data-sample-short="">
				
			</textarea>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<script data-sample="1">
				CKEDITOR.config.devtools_styles =
					'#cke_tooltip { line-height: 20px; font-size: 12px; padding: 5px; border: 2px solid #333; background: #ffffff }' +
					'#cke_tooltip h2 { font-size: 14px; border-bottom: 1px solid; margin: 0; padding: 1px; }' +
					'#cke_tooltip ul { padding: 0pt; list-style-type: none; }';

				CKEDITOR.replace( 'editor1', {
					height: 250,
					extraPlugins: 'devtools,imagebrowser',
				} );
			</script>

