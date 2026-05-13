<?php
require "config.php";

// Generate a random 5-digit number
$captcha = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, $length);
$_SESSION['captcha_code'] = $captcha;

// Set content type as image (optional if rendering as text only)
header("Content-type: image/png");

$img = imagecreate(100, 30);
$bg = imagecolorallocate($img, 255, 255, 255);
$text_color = imagecolorallocate($img, 0, 0, 0);

// Add the text to the image
imagestring($img, 5, 10, 8, $captcha, $text_color);
imagepng($img);
imagedestroy($img);
