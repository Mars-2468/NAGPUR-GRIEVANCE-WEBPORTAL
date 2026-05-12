<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors', 1);
?>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Crop Image Styles and Plugins -->
<link href="<?php echo base_url('assets/imagecropplugins/resource/jquerysctipttop.css'); ?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/imagecropplugins/resource/cropimg.css'); ?>" />
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Remove duplicate jQuery imports -->
<script src="<?php echo base_url('assets/imagecropplugins/resource/jquery.mousewheel.js'); ?>"></script>
<script src="<?php echo base_url('assets/imagecropplugins/resource/cropimg.jquery.js'); ?>"></script>

<div class="sh-pagebody">
    <div class="card bd-primary">
        <div class="card-header bg-primary tx-white">Crop Image</div>
        <div class="card-body">

            <div class="mypagetitile"></div><br>

            <div class="row">
                <div class="col-md-12">

                    <!-- Hidden fields for image paths and IDs -->
                    <input type="hidden" id="image_path" value="<?php echo $slider_data[0]['thumbnail_path']; ?>">
                    <input type="hidden" id="slide_id" value="<?php echo $this->session->userdata('slide_id'); ?>">
                    <input type="hidden" id="thumbspath" value="<?php echo $slider_data[0]['thumbnail_path']; ?>">

                    <!-- Crop Target Image -->
                    <img src="<?php echo base_url($slider_data[0]['thumbnail_path']); ?>" alt="Crop Image" class="cropimg" />


  <!-- Hidden form fields for crop values -->
                    <div class="form-horizontal" style="visibility:hidden;">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="textinput">X</label>
                            <div class="col-md-4">
                                <input type="text" value="0" id="x" class="form-control input-md" />
                            </div>
                            <label class="col-md-2 control-label" for="textinput">Y</label>
                            <div class="col-md-4">
                                <input type="text" value="0" id="y" class="form-control input-md" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="textinput">Width</label>
                            <div class="col-md-4">
                                <input type="text" value="0" id="w" class="form-control input-md" />
                            </div>
                            <label class="col-md-2 control-label" for="textinput">Height</label>
                            <div class="col-md-4">
                                <input type="text" value="0" id="h" class="form-control input-md" />
                            </div>
                        </div>
                    </div>

                    <center>
                        <button class="btn-crop btn btn-success">
                            <i class="fa fa-crop"></i> Crop this image
                        </button>
                    </center>

                    <br><br><br><br><br>



                    <script>
$(document).ready(function () {
    // Initialize crop plugin
    $('img.cropimg').cropimg({
        resultWidth: 1366,
        resultHeight: 400,
        onChange: function () {
            $('#preview-info').hide();
            $('#preview-container').show();
        }
    });

    // Handle crop button click
    $('.btn-crop').click(function (e) {
        e.preventDefault(); // prevent default button behavior if it's inside a form

        // Collect data
        const width = $('#w').val();
        const height = $('#h').val();
        const x = $('#x').val();
        const y = $('#y').val();
        const source_image = $("#image_path").val();
        const thumb_image = $("#thumbspath").val();
        const slide_id = $("#slide_id").val();
        const csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';

        // Make sure required fields are not empty
        if (!source_image || !thumb_image) {
            alert("Missing image path or thumbnail.");
            return;
        }

        // Debug: log data before sending
        console.log({
            width,
            height,
            imgx: x,
            imgy: y,
            source_image,
            slide_id,
            thumb_image,
            csrf_test_name: csrf_value
        });

        // Perform POST using AJAX
        $.ajax({
            url: '<?php echo base_url('EditImageCropController/imageCrop123'); ?>',
            type: 'POST',
            data: {
                width: width,
                height: height,
                imgx: x,
                imgy: y,
                source_image: source_image,
                slide_id: slide_id,
                thumb_image: thumb_image,
                csrf_test_name: csrf_value
            },
            success: function (data) {
                alert('Server says: ' + data);
                window.location.href = '<?php echo base_url('view-posts'); ?>';
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', xhr);
                //alert('POST failed: ' + xhr.responseText);
 		window.location.href = '<?php echo base_url('view-posts'); ?>';

            }
        });
    });
});
</script>

                  

                </div>
            </div>
        </div>
    </div>
</div>
