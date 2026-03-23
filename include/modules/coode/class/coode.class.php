<?php
class coode
{
public $__charset='';
public $charset_1=true;
public $charset_a=false;
public $charset_A=true;
public $code;
public $codelen=4;
public $width=130;
public $height=45;
public $__img;
public $font='';
public $fontsize=20;
public $fontcolor;
public $createLine_a=1;
public $createLine_b=1;
public $text_r=1;
public $back_color='#E4EDF7';
public $fontcolor_text='-1';
public function __construct()
{
$this->font=����������������������������������������4�������������������� . 'include/modules/coode/font/elephant.ttf';
}
private function createCode()
{
if ($this->charset_1==false and $this->charset_a==false and $this->charset_A==false) {
$this->__charset='1234567890abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ';
} else {
if ($this->charset_1==true)  $this->__charset .='23456789';
if ($this->charset_a==true)  $this->__charset .='abcdefghkmnprstuvwxyz';
if ($this->charset_A==true)  $this->__charset .='ABCDEFGHKMNPRSTUVWXYZ';
}
$_len=strlen($this->__charset) - 1;
for ($i=0; $i < $this->codelen; $i++) {
$this->code .=$this->__charset[mt_rand(0, $_len)];
}
}
private function createBg()
{
$this->__img=imagecreatetruecolor($this->width, $this->height);
if ($this->back_color !=-1) {
$b=$this->hex2rgb($this->back_color);
$color=imagecolorallocate($this->__img, $b['red'], $b['green'], $b['blue']);
} else {
$color=imagecolorallocate($this->__img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
}
imagefilledrectangle($this->__img, 0, $this->height, $this->width, 0, $color);
}
private function createFont()
{
$_x=$this->width / $this->codelen;
for ($i=0; $i < $this->codelen; $i++) {
if ($this->fontcolor_text !=-1) {
$b=$this->hex2rgb($this->fontcolor_text);
$this->fontcolor=imagecolorallocate($this->__img, $b['red'], $b['green'], $b['blue']);
} else {
$this->fontcolor=imagecolorallocate($this->__img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
}
$font_file=$this->font;
#imagefttext($this->__img,$this->fontsize, mt_rand(-30, 30) , $_x * $i + 3, $this->height / 1.5, $this->fontcolor, $font_file, $this->code[$i]);
if(PHP_VERSION < 7){
if ($this->text_r==1) {
imagettftext($this->__img, $this->fontsize, mt_rand(-30, 30), (int)$_x * $i + mt_rand(1, 5), (int)$this->height / 1.4, $this->fontcolor, $this->font, $this->code[$i]);
} else {
imagettftext(
$this->__img,
(int)$this->fontsize, 0, $_x * $i + 3,
(int)$this->height / 1.4,
$this->fontcolor,
$this->font,
$this->code[$i]);
}
}else{
if ($this->text_r==1) {
imagefttext($this->__img,$this->fontsize, mt_rand(-30, 30) , (int)$_x * $i + 3, (int)$this->height / 1.5, $this->fontcolor, $font_file, $this->code[$i]);
} else {
imagefttext($this->__img,$this->fontsize, 0 , (int)$_x * $i + 3, (int)$this->height / 1.5, $this->fontcolor, $font_file, $this->code[$i]);
}
}
}
}
private function createLine()
{
if ($this->createLine_a==TRUE) {
for ($i=0; $i < 6; $i++) {
$color=imagecolorallocate($this->__img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
imageline($this->__img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
}
}
if ($this->createLine_b==TRUE) {
for ($i=0; $i < 100; $i++) {
$color=imagecolorallocate($this->__img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
imagestring($this->__img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), '*', $color);
}
}
}
private function outPut()
{
Header("Content-type: image/jpeg");
imagejpeg($this->__img);
}
public function doimg()
{
$this->createBg();
$this->createCode();
$this->createLine();
$this->createFont();
$this->outPut();
}
public function getCode()
{
return strtolower($this->code);
}
function hex2rgb($colour)
{
if ($colour[0]=='#') {
$colour=substr($colour, 1);
}
if (strlen($colour)==6) {
list($r, $g, $b)=array(
$colour[0] . $colour[1],
$colour[2] . $colour[3],
$colour[4] . $colour[5]
);
} elseif (strlen($colour)==3) {
list($r, $g, $b)=array(
$colour[0] . $colour[0],
$colour[1] . $colour[1],
$colour[2] . $colour[2]
);
} else {
return false;
}
$r=hexdec($r);
$g=hexdec($g);
$b=hexdec($b);
return array(
'red'=> $r,
'green'=> $g,
'blue'=> $b
);
}
}
