<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function add_csp_header()
{
    $CI =& get_instance();

    $csp = "default-src 'self'; "
         . "script-src 'self' https://cdn.jsdelivr.net https://apis.google.com; "
         . "style-src 'self' 'https:' 'unsafe-inline'; "
         . "img-src 'self' data: https:; "
         . "font-src 'self' https:; "
         . "connect-src 'self' https:; "
         . "frame-src 'self' https://www.youtube.com https://player.vimeo.com; "
         . "object-src 'none'; "
         . "base-uri 'self'; "
         . "form-action 'self'; "
         . "frame-ancestors 'none'; "
         . "upgrade-insecure-requests;";

    $CI->output->set_header("Content-Security-Policy: $csp");
}
