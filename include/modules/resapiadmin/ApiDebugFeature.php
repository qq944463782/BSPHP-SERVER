<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class ApiDebugFeature
{
public $admin_array;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
}
function call_bootstrap()
{
Plug_Admin_Assert_Qx('yy_7');
Plug_Admin_Ok('ok', array(
'soft_list'=> $this->soft_list(),
'catalog'=> $this->scan_catalog(),
'fallback_common'=> $this->fallback_common(),
));
}
function call_api_alias()
{
Plug_Admin_Assert_Qx('yy_7');
$daihao=trim((string) Plug_Set_Get('daihao'));
if ($daihao==='') {
$daihao=trim((string) Plug_Set_Post('daihao'));
}
$api=trim((string) Plug_Set_Get('api'));
if ($api==='') {
$api=trim((string) Plug_Set_Post('api'));
}
if ($daihao==='' || $api==='') {
Plug_Admin_Fail(Plug_Lang('参数不完整'));
}
$pwd=$this->get_api_pwd($daihao);
if ($pwd==='') {
Plug_Admin_Ok('ok', array('api'=> $api, 'alias'=> $api, 'anonymous'=> 0));
}
Plug_Admin_Ok('ok', array(
'api'=> $api,
'alias'=> $this->encrypt_api_alias($api, $pwd),
'anonymous'=> 1,
));
}
function call_send()
{
Plug_Admin_Assert_Qx('yy_7');
$daihao=trim((string) Plug_Set_Post('daihao'));
$api=trim((string) Plug_Set_Post('api'));
if ($api==='') {
Plug_Admin_Fail(Plug_Lang('请选择接口'));
}
$output=strtolower(trim((string) Plug_Set_Post('output_type')));
if ($output !=='xml' && $output !=='json') {
$output='json';
}
$soft=$this->soft_by_daihao($daihao);
if (!$soft) {
Plug_Admin_Fail(Plug_Lang('请选择软件'));
}
$base_url=$this->post_plain_or_b64('base_url');
$mutual=$this->post_plain_or_b64('mutual_key');
$server_key=$this->post_plain_or_b64('server_private_key');
$client_pem=$this->post_plain_or_b64('client_public_key');
if ($base_url==='') {
$base_url=$soft['base_url'];
}
if ($mutual==='') {
$mutual=$soft['mutual_key'];
}
if ($server_key==='') {
$server_key=$soft['server_private_key'];
}
if ($client_pem==='') {
$client_pem=$soft['client_public_key'];
}
if ($base_url==='' || $mutual==='' || $server_key==='' || $client_pem==='') {
Plug_Admin_Fail(Plug_Lang('基础配置不完整（地址/密钥）'));
}
$common=$this->json_obj($this->post_plain_or_b64('common_json'));
$priv=$this->json_obj($this->post_plain_or_b64('private_json'));
$common['api']=$api;
$common['mutualkey']=$mutual;
if (!isset($common['date']) || $common['date']==='') {
$common['date']=date('YmdHis');
}
if (!isset($common['appsafecode']) || $common['appsafecode']==='') {
$common['appsafecode']=$this->rand_alnum(8);
}
$param=array_merge($common, $priv);
$param['api']=$api;
$param['mutualkey']=$mutual;
$plain=$this->build_param_string($param);
$appsafecode=(string) $param['appsafecode'];
$aes_key=substr(md5($server_key . $appsafecode), 0, 16);
$enc_b64=$this->aes_encrypt_b64($plain, $aes_key);
$sig_md5=md5($enc_b64);
$signature='0|AES-128-CBC|' . $aes_key . '|' . $sig_md5 . '|' . $output;
$rsa_b64=$this->rsa_encrypt_public($signature, $client_pem);
if ($rsa_b64==='') {
Plug_Admin_Fail(Plug_Lang('RSA 公钥加密失败，请检查 client_public_key'));
}
$payload=$enc_b64 . '|' . $rsa_b64;
$body='parameter=' . rawurlencode($payload);
$http=$this->http_post($base_url, $body);
$raw=isset($http['body']) ? (string) $http['body'] : '';
$status=isset($http['status']) ? (int) $http['status'] : 0;
if ($status <=0) {
Plug_Admin_Fail(Plug_Lang('请求失败') . ': ' . (isset($http['error']) ? $http['error'] : 'network'));
}
$decoded=array(
'ok'=> 0,
'biz'=> '',
'biz_pretty'=> '',
'sig_plain'=> '',
'sessl'=> '',
'error'=> '',
);
try {
$decoded=$this->decode_response($raw, $server_key, $output);
$decoded['ok']=1;
} catch (Exception $e) {
$decoded['error']=$e->getMessage();
}
Plug_Admin_Ok('ok', array(
'http_status'=> $status,
'plain'=> $plain,
'signature'=> $signature,
'payload'=> $payload,
'raw'=> $raw,
'appsafecode'=> $appsafecode,
'decode'=> $decoded,
'auto_sessl'=> ($api==='BSphpSeSsL.in' && !empty($decoded['sessl'])) ? $decoded['sessl'] : '',
));
}
private function post_plain_or_b64($key)
{
$b64='';
if (isset($_POST[$key . '_b64'])) {
$b64=trim((string) $_POST[$key . '_b64']);
}
if ($b64==='') {
$b64=trim((string) Plug_Set_Post($key . '_b64'));
}
if ($b64 !=='') {
$b64=str_replace(' ', '+', $b64);
$raw=base64_decode($b64, true);
if ($raw===false) {
$raw=base64_decode($b64);
}
if ($raw !==false && $raw !=='') {
return $raw;
}
}
if (isset($_POST[$key]) && !is_array($_POST[$key])) {
return (string) $_POST[$key];
}
return (string) Plug_Set_Post($key);
}
private function fallback_common()
{
return array(
array('key'=> 'api', 'required'=> true, 'desc'=> 'API接口名称'),
array('key'=> 'BSphpSeSsL', 'required'=> false, 'desc'=> 'BSphpSeSsL连接Cookies'),
array('key'=> 'date', 'required'=> false, 'desc'=> '服务器时间超时验证；可空'),
array('key'=> 'mutualkey', 'required'=> true, 'desc'=> '通信认证Key'),
array('key'=> 'appsafecode', 'required'=> false, 'desc'=> '封包劫持检测；可空'),
array('key'=> 'md5', 'required'=> false, 'desc'=> '程序MD5；可空'),
);
}
private function soft_list()
{
$rows=array();
$rs=Plug_Query("SELECT `app_daihao`,`app_name`,`app_server_key`,`app_client_pem`,`app_api_pwd` FROM `bs_php_appinfo` ORDER BY `app_daihao` ASC");
while ($r=Plug_Pdo_Fetch_Assoc($rs)) {
$appid=(string) ($r['app_daihao'] ?? '');
if ($appid==='') {
continue;
}
$pwd=isset($r['app_api_pwd']) ? (string) $r['app_api_pwd'] : '';
$has_api_pwd=($pwd !=='' && $pwd !=='0') ? 1 : 0;
$rows[]=array(
'daihao'=> $appid,
'name'=> (string) ($r['app_name'] ?? $appid),
'base_url'=> $this->build_base_url($appid),
'mutual_key'=> $this->build_mutual_key($appid),
'server_private_key'=> (string) ($r['app_server_key'] ?? ''),
'client_public_key'=> (string) ($r['app_client_pem'] ?? ''),
'has_api_pwd'=> $has_api_pwd,
'has_keys'=> (!empty($r['app_server_key']) && !empty($r['app_client_pem'])) ? 1 : 0,
'captcha_url'=> rtrim(getSiteUrl(), '/') . '/index.php?m=coode&sessl=',
);
}
return $rows;
}
private function soft_by_daihao($daihao)
{
foreach ($this->soft_list() as $s) {
if ((string) $s['daihao']===(string) $daihao) {
return $s;
}
}
return null;
}
private function encrypt_api_alias($name, $pwd)
{
$enc=des_mencrypt($name, $pwd);
$enc=str_replace('=', '|MH171C', $enc);
$enc=str_replace('+', '|H370J', $enc);
$enc=str_replace('/', '|TJS7E', $enc);
return $enc;
}
private function get_api_pwd($daihao)
{
$daihao_sql=addslashes((string) $daihao);
$row=Plug_Query_Array("SELECT `app_api_pwd` FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao_sql}' LIMIT 1");
if (!$row) {
return '';
}
$pwd=isset($row['app_api_pwd']) ? (string) $row['app_api_pwd'] : '';
if ($pwd==='' || $pwd==='0') {
return '';
}
return $pwd;
}
private function build_mutual_key($appid)
{
return ��������������������������������������������������������������������������������('xiaozhou' . ����������������������������������������������������������������::������������������������������������������������������������������������������������('sys', 'cook_key') . $appid . ����������������������������������������������������������������::������������������������������������������������������������������������������������('sys', 'cook_key') . '2019QQ944463782');
}
private function build_base_url($appid)
{
$m=��������������������������������������������������������������������������������(����������������������������������������������������������������::������������������������������������������������������������������������������������('sys', 'cook_key') . $appid . ����������������������������������������������������������������::������������������������������������������������������������������������������������('sys', 'cook_key') . 'Bsphp-Rsa');
return rtrim(getSiteUrl(), '/') . '/AppEn.php?appid=' . urlencode($appid) . '&m=' . urlencode($m) . '&lang=0';
}
private function json_obj($raw)
{
if (is_array($raw)) {
return $raw;
}
$raw=trim((string) $raw);
if ($raw==='') {
return array();
}
$j=json_decode($raw, true);
return is_array($j) ? $j : array();
}
private function encode_parameter($s)
{
$str=$s===null ? '' : (string) $s;
$out='';
$len=strlen($str);
for ($i=0; $i < $len; $i++) {
$ch=$str[$i];
$o=ord($ch);
if (
($o >=65 && $o <=90) ||
($o >=97 && $o <=122) ||
($o >=48 && $o <=57) ||
$ch==='-' || $ch==='.' || $ch==='_' || $ch==='~'
) {
$out .=$ch;
} else {
$out .=strtoupper(rawurlencode($ch));
}
}
return $out;
}
private function build_param_string($param)
{
$keys=array_keys($param);
sort($keys, SORT_STRING);
$parts=array();
foreach ($keys as $k) {
$parts[]=$k . '=' . $this->encode_parameter(isset($param[$k]) ? $param[$k] : '');
}
return implode('&', $parts);
}
private function aes_encrypt_b64($plain, $key16)
{
$key=substr((string) $key16, 0, 16);
$raw=openssl_encrypt($plain, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $key);
return base64_encode($raw===false ? '' : $raw);
}
private function aes_decrypt_b64($b64, $key16)
{
$key=substr((string) $key16, 0, 16);
$bin=base64_decode((string) $b64, true);
if ($bin===false) {
return '';
}
$out=openssl_decrypt($bin, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $key);
return $out===false ? '' : $out;
}
private function rsa_encrypt_public($message, $public_raw)
{
$pem=fix_key_format($public_raw, 'public');
$ok=openssl_public_encrypt($message, $encrypted, $pem);
if (!$ok) {
return '';
}
return base64_encode($encrypted);
}
private function rsa_decrypt_private($cipher_b64, $private_raw)
{
$pem=fix_key_format($private_raw, 'private');
$bin=base64_decode((string) $cipher_b64, true);
if ($bin===false) {
throw new Exception(Plug_Lang('响应RSA段无效'));
}
$ok=openssl_private_decrypt($bin, $plain, $pem);
if (!$ok) {
throw new Exception(Plug_Lang('RSA 私钥解密失败，请检查 server_private_key'));
}
return (string) $plain;
}
private function decode_response($raw, $server_private_key, $fallback_output)
{
$text=trim((string) $raw);
if ($text==='') {
throw new Exception(Plug_Lang('服务端返回为空'));
}
if (strpos($text, '%') !==false) {
$try=rawurldecode(str_replace('+', ' ', $text));
if ($try !=='') {
$text=$try;
}
}
$parts=explode('|', $text);
if (count($parts) >=3) {
$resp_enc=$parts[1];
$resp_rsa=$parts[2];
} elseif (count($parts)===2) {
$resp_enc=$parts[0];
$resp_rsa=$parts[1];
} else {
throw new Exception(Plug_Lang('返回格式异常，无法拆分加密段'));
}
$sig_plain=$this->rsa_decrypt_private($resp_rsa, $server_private_key);
$sig_arr=explode('|', $sig_plain);
if (count($sig_arr) < 3) {
throw new Exception(Plug_Lang('响应签名结构异常'));
}
$resp_aes=substr((string) $sig_arr[2], 0, 16);
$resp_type=isset($sig_arr[4]) ? strtolower(trim($sig_arr[4])) : $fallback_output;
if ($resp_type !=='json' && $resp_type !=='xml') {
$resp_type=$fallback_output;
}
$biz=$this->aes_decrypt_b64($resp_enc, $resp_aes);
$pretty=$biz;
$sessl='';
if ($resp_type==='json') {
$obj=json_decode($biz, true);
if (is_array($obj)) {
$pretty=json_encode($obj, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
if (isset($obj['response']['data'])) {
$sessl=(string) $obj['response']['data'];
} elseif (isset($obj['data'])) {
$sessl=(string) $obj['data'];
}
}
} elseif ($resp_type==='xml') {
if (preg_match('/<data[^>]*>([\s\S]*?)<\/data>/i', $biz, $m)) {
$sessl=trim($m[1]);
}
}
return array(
'ok'=> 1,
'biz'=> $biz,
'biz_pretty'=> $pretty,
'sig_plain'=> $sig_plain,
'output_type'=> $resp_type,
'sessl'=> $sessl,
'error'=> '',
);
}
private function http_post($url, $body)
{
if (function_exists('curl_init')) {
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$resp=curl_exec($ch);
$err=curl_error($ch);
$code=(int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($resp===false) {
return array('status'=> 0, 'body'=> '', 'error'=> $err);
}
return array('status'=> $code > 0 ? $code : 200, 'body'=> $resp, 'error'=> '');
}
$ctx=stream_context_create(array(
'http'=> array(
'method'=> 'POST',
'header'=> "Content-Type: application/x-www-form-urlencoded;charset=UTF-8\r\n",
'content'=> $body,
'timeout'=> 30,
'ignore_errors'=> true,
),
));
$resp=@file_get_contents($url, false, $ctx);
return array(
'status'=> $resp===false ? 0 : 200,
'body'=> $resp===false ? '' : $resp,
'error'=> $resp===false ? 'file_get_contents failed' : '',
);
}
private function rand_alnum($len)
{
$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$out='';
for ($i=0; $i < $len; $i++) {
$out .=$chars[mt_rand(0, strlen($chars) - 1)];
}
return $out;
}
private function scan_catalog()
{
$root=����������������������������������������4�������������������� . 'include/applibapi/api';
if (!is_dir($root)) {
return array();
}
$files=new RecursiveIteratorIterator(
new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
);
$rows=array();
foreach ($files as $f) {
if (!$f->isFile() || strtolower($f->getExtension()) !=='php') {
continue;
}
$filename=$f->getFilename();
if (!preg_match('/^AppEn\.(.+)\.php$/', $filename, $m)) {
continue;
}
$api_name=(string) $m[1];
$title=$api_name;
$common=array();
$private=array();
$content=@file_get_contents($f->getPathname());
if ($content !==false && preg_match('/\/\*\s*(<api>[\s\S]*?<\/api>)\s*\*\//', $content, $xm)) {
$parsed=$this->parse_api_xml(trim($xm[1]));
if (is_array($parsed)) {
if (!empty($parsed['title'])) {
$title=$parsed['title'];
}
$common=$parsed['common_params'];
$private=$parsed['params'];
}
}
$group='other';
if (preg_match('/\.(in|lg|ic)$/i', $api_name, $gm)) {
$group=strtolower($gm[1]);
}
$rows[]=array(
'id'=> strtolower(basename(dirname($f->getPathname())) . '::' . $api_name),
'folder'=> basename(dirname($f->getPathname())),
'group'=> $group,
'name'=> $api_name,
'title'=> $title,
'commonParams'=> $common,
'privateParams'=> $private,
);
}
usort($rows, function ($a, $b) {
$c=strcmp($a['folder'], $b['folder']);
return $c !==0 ? $c : strcmp($a['name'], $b['name']);
});
return $rows;
}
private function parse_api_xml($xmlstr)
{
libxml_use_internal_errors(true);
$sx=@simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $xmlstr);
libxml_clear_errors();
if ($sx===false) {
return null;
}
$row=array('title'=> trim((string) $sx->title), 'common_params'=> array(), 'params'=> array());
if (isset($sx->common_params)) {
foreach ($sx->common_params->param as $p) {
$r=$this->param_row($p);
if ($r['key'] !=='') {
$row['common_params'][]=$r;
}
}
}
if (isset($sx->params)) {
foreach ($sx->params->param as $p) {
$r=$this->param_row($p);
if ($r['key'] !=='') {
$row['params'][]=$r;
}
}
}
return $row;
}
private function param_row($p)
{
$attrs=$p->attributes();
$name=trim((string) $attrs['name']);
if ($name==='' && isset($attrs['key'])) {
$name=trim((string) $attrs['key']);
}
$required=strtolower(trim((string) $attrs['required']));
return array(
'key'=> $name,
'required'=> ($required==='true' || $required==='1' || $required==='yes'),
'desc'=> trim((string) $attrs['desc']),
);
}
}
