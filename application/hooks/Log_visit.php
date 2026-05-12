<?php
function log_page_visit() {
    $CI =& get_instance();
    $CI->load->model('Page_visit_model');
    $uri = uri_string();
    $CI->Page_visit_model->log_visit($uri);
}
