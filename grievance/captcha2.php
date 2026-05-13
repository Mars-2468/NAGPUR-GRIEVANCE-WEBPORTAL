<?php
require_once  "config.php";

// Generate random code
$captcha_code = substr(str_shuffle("abcdefghjklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 6);
$_SESSION['captcha_code'] = $captcha_code;

// Step 1: Create image
$width = 200;
$height = 50;
$image = imagecreate($width, $height);

// Colors
$bg_color = imagecolorallocate($image, 119, 175, 95); // white
$text_color = imagecolorallocate($image, 255, 0, 0);     // black
$line_color = imagecolorallocate($image, 164, 214, 64);  // grey
$dot_color  = imagecolorallocate($image, 20, 30, 215);   // blue

// Add background noise (lines)
for ($i = 0; $i < 5; $i++) {
    imageline($image, 0, rand()%$height, $width, rand()%$height, $line_color);
}

// Add background noise (dots)
for ($i = 0; $i < 500; $i++) {
    imagesetpixel($image, rand()%$width, rand()%$height, $dot_color);
}

// Step 3: Font
$font_size = 20;
$angle = 0;
$text = implode(' ', str_split($captcha_code));
$font_path = __DIR__ . '/fonts/static/Archivo-Italic.ttf'; // Use a valid .ttf file

// Step 4: Calculate bounding box
$bbox = imagettfbbox($font_size, $angle, $font_path, $text);

// Get text width and height
$text_width  = $bbox[2] - $bbox[0];
$text_height = $bbox[1] - $bbox[7];

// Step 5: Calculate coordinates to center the text
$x = ($width - $text_width) / 2;
$y = ($height + $text_height) / 2;  // Remember: Y is the **baseline** of the text

// Step 6: Render text
imagettftext($image, $font_size, $angle, $x, $y, $text_color, $font_path, $text);

// Output the image
header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);
?>
