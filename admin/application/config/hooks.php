<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = array(
    'class'    => 'Samesite_cookie',
    'function' => 'set_samesite',
    'filename' => 'Samesite_cookie.php',
    'filepath' => 'hooks'
);

/* $hook['post_controller_constructor'][] = array(
    'class'    => '',
    'function' => 'add_csp_header',
    'filename' => 'csp_hook.php',
    'filepath' => 'hooks'
); */