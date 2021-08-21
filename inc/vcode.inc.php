<?php 
function vcode($width=120,$height=40,$countElement=4){
header('Content-Type:image/jpeg');
$element=array('a','b','c','d','e');
$string='';
for($i=0;$i<$countElement;$i++){
	$string.=$element[rand(0,count($element)-1)];
}
$img=imagecreatetruecolor($width, $height);
$colorBg=imagecolorallocate($img,rand(200,255),rand(200,255),rand(200,255));
// $colorBorder=imagecolorallocate($img,rand(200,255),rand(200,255),rand(200,255));
$colorString=imagecolorallocate($img,rand(10,100),rand(10,100),rand(10,100));
imagefill($img,0,0,$colorBg);
// imagerectangle($img,0, 0,$width-1,$height-1,$colorBorder);
for($i=0;$i<100;$i++){
	imagesetpixel($img,rand(0,$width-1),rand(0,$height-1),imagecolorallocate($img, rand(100,200),rand(100,200),rand(100,200)));
}
for($i=0;$i<3;$i++){
	imageline($img, rand(0,$width / 2),rand(0,$height),rand($width/2,$width),rand(0,$height),imagecolorallocate($img,rand(100,200),rand(100,200),rand(100,200)));
}
// imagestring($img, 5, 0, 0, 'aaaa', $colorString);
imagettftext($img, 16, rand(-5,5), rand(10,15), rand(30,35), $colorString, 'font/Roboto-Black.ttf', $string);
imagejpeg($img);
imagedestroy($img);
return $string;
}
?>