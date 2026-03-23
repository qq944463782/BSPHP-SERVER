<?php
function bsphp_mdecrypt($encrypted, $key)
{
$encrypted=base64_decode($encrypted);
$key=substr(md5($key), 0, 8);
$td=mcrypt_module_open('tripledes', '', MCRYPT_MODE_ECB, '');
$iv=mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
$ks=mcrypt_enc_get_key_size($td);
mcrypt_generic_init($td, $key, $key);
$decrypted=mdecrypt_generic($td, $encrypted);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);
$y=pkcs5_unpad($decrypted);
return $y;
}
function bsphp_mencrypt($text, $key)
{
$key=substr(md5($key), 0, 8);
$y=pkcs5_pad($text);
$td=mcrypt_module_open('tripledes', '', MCRYPT_MODE_ECB, '');
$ks=mcrypt_enc_get_key_size($td);
mcrypt_generic_init($td, $key, $key);
$encrypted=mcrypt_generic($td, $y);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);
return base64_encode($encrypted);
}
?>