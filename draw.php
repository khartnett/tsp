<?php
header ('Content-Type: image/png');
$im = @imagecreatetruecolor(200, 200)
      or die('Cannot Initialize new GD image stream');
$text_color = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 1, 5, 5,  'A Simple Text String', $text_color);
$color = imagecolorallocate($im, 255, 255, 255);
imageline($im, 20 , 30, 140, 170, $color);
imagepng($im);
imagedestroy($im);
?>
