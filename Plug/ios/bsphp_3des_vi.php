<?php
if(PHP_VERSION > 7.1){
echo 'php 版本不能大于7.0 建议使用5.4 5.6 7.0 当前版本'.PHP_VERSION;
exit;
}
function bsphp_3des_vi_bsphp_mdecrypt($encrypted, $key)
{
$key=md5($key);
$des=new des_vi();
$ret=$des->decrypt($encrypted,$key);
return $ret;
}
function bsphp_3des_vi_bsphp_mencrypt($text, $key)
{
$key=md5($key);
$des=new des_vi();
$ret=$des->encrypt($text,$key);
return $ret;
}
class des_vi {
var $_des_vi_iv="bsphp666";
function encrypt($input,$key){
$size=mcrypt_get_block_size(MCRYPT_3DES,MCRYPT_MODE_CBC);
$input=$this->pkcs5_pad($input, $size);
$key=str_pad($key,24,'0');
$td=mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
if( $this->_des_vi_iv=='' )
{
$iv=@mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
}
else
{
$iv=$this->_des_vi_iv;
}
@mcrypt_generic_init($td, $key, $iv);
$data=mcrypt_generic($td, $input);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);
$data=base64_encode($data);
return $data;
}
function decrypt($encrypted,$key){
$encrypted=base64_decode($encrypted);
$key=str_pad($key,24,'0');
$td=mcrypt_module_open(MCRYPT_3DES,'',MCRYPT_MODE_CBC,'');
if( $this->_des_vi_iv=='' )
{
$iv=@mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
}
else
{
$iv=$this->_des_vi_iv;
}
$ks=mcrypt_enc_get_key_size($td);
@mcrypt_generic_init($td, $key, $iv);
$decrypted=mdecrypt_generic($td, $encrypted);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);
$y=$this->pkcs5_unpad($decrypted);
return $y;
}
function pkcs5_pad ($text, $blocksize) {
$pad=$blocksize - (strlen($text) % $blocksize);
return $text . str_repeat(chr($pad), $pad);
}
function pkcs5_unpad($text){
$pad=ord($text{strlen($text)-1});
if ($pad > strlen($text)) {
return false;
}
if (strspn($text, chr($pad), strlen($text) - $pad) !=$pad){
return false;
}
return substr($text, 0, -1 * $pad);
}
function PaddingPKCS7($data) {
$block_size=mcrypt_get_block_size(MCRYPT_3DES, MCRYPT_MODE_CBC);
$padding_char=$block_size - (strlen($data) % $block_size);
$data .=str_repeat(chr($padding_char),$padding_char);
return $data;
}
}
