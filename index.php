<?php
//Ширина изображения
$imgw = 266;
//Ник скина
$nick = "houtou";
//Размер аватарки
$skin_w = 140;
//Опустить вниз на проценты
$p = 10;
//Размер шрифта
$fs = 13;

//Title
$title = "Level 2";
//Subtitle
$subtitle = "and 890 xp";

header ("Content-type: image/png");
function hex2rgb($hex) {
    $rgb[0] = hexdec(substr($hex, 0, 2));
    $rgb[1] = hexdec(substr($hex, 2, 2));
    $rgb[2] = hexdec(substr($hex, 4, 2));
    return $rgb;
}

$image = imagecreatetruecolor($imgw, 380) or die ("Cannot Create image");

$b = hex2rgb("7da8ff");
$background_color = imagecolorallocate($image, $b[0], $b[1], $b[2]);
imagefill($image, 0, 0, $background_color);

$zc = hex2rgb("477ab1");
$dl = 220;
for ($x=0; $x < $dl; ++$x){
    $alpha = $x <= 0 ? 0 : round(min(($x - 0)/$dl, 1)*127);
    $new_color = imagecolorallocatealpha($image, $zc[0], $zc[1], $zc[2], $alpha);
    imageline($image, 0, $x, $imgw, $x, $new_color);
}

$con = file_get_contents('1.png');
$imgurl = imagecreatefromstring($con);
list($width, $height) = getimagesize('1.png');
$new_width = ($imgw*100)/$width;
imagecopyresized($image, $imgurl, 0, 231, 0, 0, $imgw, ($height*$new_width)/100, $width, $height);

$left = ($imgw/2)-($skin_w/2);
$bottom = 380-$skin_w+(380*$p/100);
$imgface = imagecreatefromstring(file_get_contents('https://minotar.net/armor/bust/'.$nick.'/'.$skin_w.'.png'));
imagecopyresized($image, $imgface, $left, $bottom, 0, 0, $skin_w, $skin_w, $skin_w, $skin_w);

$backnick = imagecolorallocatealpha($image,0,0,0,100);

//Nick
$fs = 13;
$font = './1.ttf';
$box = imagettfbbox($fs, 0, $font, $nick);
$left = ($imgw/2)-round(($box[2]-$box[0])/2);
imagefilledrectangle ($image , $left-5 , 252+5 , $imgw-$left+5 , 230 , $backnick );
$nick_color = ImageColorAllocate ($image, 84, 254, 254);
imagettftext($image, $fs, 0, $left, 252, $nick_color, $font, $nick);

//Title and subtitle
$boxtitle = imagettfbbox(20, 0, $font, $title);
$left_title = ($imgw/2)-round(($boxtitle[2]-$boxtitle[0])/2);
$title_color = ImageColorAllocate ($image, 255, 255, 255);
$title_shadow_color = ImageColorAllocate ($image, 64, 64, 64);
imagettftext($image, 20, 0, $left_title+3, 120+3, $title_shadow_color, $font, $title);
imagettftext($image, 20, 0, $left_title, 120, $title_color, $font, $title);

$boxsubtitle = imagettfbbox(12, 0, $font, $subtitle);
$left_subtitle = ($imgw/2)-round(($boxsubtitle[2]-$boxsubtitle[0])/2);
$subtitle_color = ImageColorAllocate ($image, 91, 82, 229);
$subtitle_shadow_color = ImageColorAllocate ($image, 24, 24, 58);
imagettftext($image, 12, 0, $left_subtitle+2, 155+2, $subtitle_shadow_color, $font, $subtitle);
imagettftext($image, 12, 0, $left_subtitle, 155, $subtitle_color, $font, $subtitle);

ImagePng ($image);
imagedestroy($image);
imagedestroy($imgurl);
?>