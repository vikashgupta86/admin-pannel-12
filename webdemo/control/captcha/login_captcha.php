<?php
    require_once '../../appcode/globals.inc.php';

$image = imagecreatetruecolor(120, 40);
$background_color = imagecolorallocate($image, 240, 240, 240);
imagefilledrectangle($image, 0, 0, 120, 40, $background_color);

$text_color = imagecolorallocate($image, 0, 0, 0);
$noise_color = imagecolorallocate($image, 100, 100, 100);

// Add some noise
for ($i = 0; $i < 100; $i++) {
    imagesetpixel($image, rand(0, 120), rand(0, 40), $noise_color);
}

// Generate random code
$code = '';
$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
for ($i = 0; $i < 6; $i++) {
    $code .= $chars[rand(0, strlen($chars) - 1)];
}

$_SESSION['captcha_val'] = $code;

// Draw code
$font = 5; // Internal font
imagestring($image, $font, 30, 12, $code, $text_color);

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
