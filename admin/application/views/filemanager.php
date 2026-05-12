<script src="<?php echo base_url()?>assets/editors/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/editors/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/editors2/jquery.tinymce.min.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
 <script type = "text/javascript" src = "<?php echo base_url() ?>assets/editors2/js/jquery.min.js"></script>
    <script type = "text/javascript" src = "<?php echo base_url() ?>assets/editors2/tinymce.min.js"></script>
<script type = "text/javascript">

    var BASE_URL = "<?php echo base_url(); ?>assets/editors2/"; // use your own base url


    tinymce.init({
      selector: "#richTextArea",theme: "modern",width: 0,height:0,
        theme: "modern",
        
        relative_urls: false,
        remove_script_host: false,
        // document_base_url: BASE_URL,
        plugins: ["responsivefilemanager"],
        menubar:"",
        toolbar1: "responsivefilemanager",
        image_advtab: true,

        external_filemanager_path: BASE_URL + "filemanager/",
        filemanager_title: "Media Gallery",
        external_plugins: {"filemanager": BASE_URL + "filemanager/plugin.min.js"}
        
    });
</script>

<style>
    #mceu_34{display:none;}
    #richTextArea_ifr{display:none !important}
    #mceu_8{display:none !important}
    
    
    
    
    
    
    
</style>

</head>



<span id="richTextArea"></span>





















