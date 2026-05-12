<?php header('Access-Control-Allow-Origin: *'); //for all ?>
<?php echo base_url()."assets/editors2/";?>
<!DOCTYPE html>

<html lang="en">
<head>
<script src="<?php echo base_url()?>assets/editors/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/editors/jquery-1.11.3.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/editors2/jquery.tinymce.min.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
 <script type = "text/javascript" src = "<?php echo base_url() ?>assets/editors2/js/jquery.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
<script type = "text/javascript">
$(document).ready(function(){
   tinymce.init({
              selector: 'textarea#default',
              plugins: [
               'advlist autolink lists link image charmap print preview hr anchor pagebreak',
               'tinymcespellchecker code table'],
              toolbar: "code",
              menubar: "file edit insert view format table tools help"
 
           }); 
});
 


    var BASE_URL = "<?php echo base_url(); ?>assets/editors2/"; // use your own base url

</script>

</head>

<body>
    <h2>PHP Image Upload using TinyMCE Editor</h2>
    <textarea id="richTextArea"></textarea>
</body>
</html>