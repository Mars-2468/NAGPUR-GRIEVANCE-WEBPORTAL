<?php
// Set content-type to image
header('Content-Type: image/png');

// Email address to display
//$email = "contact@example.com";

// Font settings
$font = __DIR__ . '/carservice9594.ttf'; // Make sure this TTF font file exists
$fontSize = 14;

// Calculate image size
$bbox = imagettfbbox($fontSize, 0, $font, $email);
$width = $bbox[2] - $bbox[0] + 10;
$height = $bbox[1] - $bbox[7] + 10;

// Create image
$emailimage = imagecreatetruecolor($width, $height);

// Colors
$white = imagecolorallocate($emailimage, 255, 255, 255);
$black = imagecolorallocate($emailimage, 0, 0, 0);

// Fill background
imagefilledrectangle($emailimage, 0, 0, $width, $height, $white);

// Write text
imagettftext($emailimage, $fontSize, 0, 5, $height - 5, $black, $font, $email);

// Output image
imagepng($emailimage);
imagedestroy($emailimage);
?>
