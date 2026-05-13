<?php
require "config.php";
echo (isset($_SESSION['captcha'])) ? $_SESSION['captcha'] : '' ;
?>