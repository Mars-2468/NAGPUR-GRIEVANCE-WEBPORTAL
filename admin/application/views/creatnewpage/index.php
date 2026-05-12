<?php echo base_url()."application/views/creatnewpage";?>
<!DOCTYPE html>

<html lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
<script type="text/javascript" src="jquery.tinymce.min.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
 <script type = "text/javascript" src = "<?php echo base_url() ?>assets/editors2/js/jquery.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url() ?>assets/editors2/tinymce/tinymce.min.js"></script>
<script type = "text/javascript">

    var BASE_URL = <?php echo base_url()."application/views/creatnewpage";?>; // use your own base url


    tinymce.init({
      selector: "textarea",theme: "modern",width: 680,height: 300,
        theme: "modern",
        // width: 680,
        height: 200,
        relative_urls: false,
        remove_script_host: false,
        // document_base_url: BASE_URL,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        image_advtab: true,

        external_filemanager_path: BASE_URL + "filemanager/",
        filemanager_title: "Media Gallery",
        external_plugins: {"filemanager": BASE_URL + "filemanager/plugin.min.js"}
    });
</script>
</head>

<body>
    <h2>PHP Image Upload using TinyMCE Editor</h2>
    <textarea id="richTextArea"></textarea>
</body>
</html>