<?php
function des_mdecrypt($encrypted,$key)
{
$encrypted=base64_decode($encrypted);
$key=substr(md5($key), 0, 8);
$td=mcrypt_module_open('tripledes','',MCRYPT_MODE_ECB,'');
$iv=mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
$ks=mcrypt_enc_get_key_size($td);
mcrypt_generic_init($td, $key, $key);
$decrypted=mdecrypt_generic($td, $encrypted);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);
$y=pkcs5_unpad($decrypted);
return $y;
}
function des_mencrypt($text,$key)
{
$key=substr(md5($key), 0, 8);
$y=pkcs5_pad($text);
$td=mcrypt_module_open('tripledes','',MCRYPT_MODE_ECB,'');
$ks=mcrypt_enc_get_key_size($td);
mcrypt_generic_init($td, $key, $key);
$encrypted=mcrypt_generic($td, $y);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);
return base64_encode($encrypted);
}
function pkcs5_pad($text,$block=8)
{
$pad=$block - (strlen($text) % $block);
return $text . str_repeat(chr($pad), $pad);
}
function pkcs5_unpad($text)
{
$pad=ord($text{strlen($text)-1});
if ($pad > strlen($text)) return $text;
if (strspn($text, chr($pad), strlen($text) - $pad) !=$pad) return $text;
return substr($text, 0, -1 * $pad);
}
function   strToHex($string)
{
$hex="";
for   ($i=0;$i<strlen($string);$i++)
$hex.=dechex(ord($string[$i]));
$hex=strtoupper($hex);
return   $hex;
}
function   hexToStr($hex)
{
$string="";
for   ($i=0;$i<strlen($hex)-1;$i+=2)
$string.=chr(hexdec($hex[$i].$hex[$i+1]));
return   $string;
}
?>