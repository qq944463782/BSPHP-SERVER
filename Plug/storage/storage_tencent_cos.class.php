<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
class storage_tencent_cos
{
private $secret_id;
private $secret_key;
private $app_id;
private $bucket;
private $region;
private $custom_domain;
public function __construct()
{
$this->����������������������������������������������������������������������������();
}
public function ����������������������������������������������������������������������������()
{
$cfg=����������������������������������������������������������������::������������������������������������������������������������������������������������('StorageConfig');
$cfg=is_array($cfg) ? $cfg : array();
$this->secret_id=trim($cfg['tencent_secret_id'] ?? '');
$this->secret_key=trim($cfg['tencent_secret_key'] ?? '');
$this->app_id=trim($cfg['tencent_app_id'] ?? '');
$this->bucket=trim($cfg['tencent_bucket'] ?? '');
$this->region=trim($cfg['tencent_region'] ?? '');
$this->custom_domain=trim($cfg['tencent_custom_domain'] ?? '');
}
public function uploadFile($file_path, $object_key)
{
if (!file_exists($file_path)) {
return array('success'=> false, 'message'=> '文件不存在');
}
$file_content=file_get_contents($file_path);
if ($file_content===false) {
return array('success'=> false, 'message'=> '读取文件失败');
}
$url='https://' . $this->bucket . '-' . $this->app_id . '.cos.' . $this->region . '.myqcloud.com/' . $object_key;
$date=gmdate('D, d M Y H:i:s \G\M\T');
$content_type=$this->getContentType($object_key);
$content_length=strlen($file_content);
$qtime=time() . ';' . (time() + 3600);
$string_to_sign="put\n\n" . $content_type . "\n" . $date . "\n/" . $this->bucket . '-' . $this->app_id . '/' . $object_key;
$signature=base64_encode(hash_hmac('sha1', $string_to_sign, $this->secret_key, true));
$auth='q-sign-algorithm=sha1&q-ak=' . $this->secret_id . '&q-sign-time=' . $qtime . '&q-key-time=' . $qtime . '&q-header-list=content-length;content-type;date;host&q-url-param-list=&q-signature=' . $signature;
$headers=array(
'Date: ' . $date,
'Content-Type: ' . $content_type,
'Content-Length: ' . $content_length,
'Authorization: ' . $auth
);
$response=$this->sendRequest($url, 'PUT', $headers, $file_content);
if ($response['success']) {
return array('success'=> true, 'url'=> $this->getFileUrl($object_key));
}
return array('success'=> false, 'message'=> $response['message'], 'data'=> isset($response['data']) ? $response['data'] : null);
}
private function getContentType($object_key)
{
$ext=strtolower(pathinfo($object_key, PATHINFO_EXTENSION));
$map=array('jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','gif'=>'image/gif','webp'=>'image/webp','pdf'=>'application/pdf','zip'=>'application/zip');
return isset($map[$ext]) ? $map[$ext] : 'application/octet-stream';
}
private function sendRequest($url, $method, $headers, $body='')
{
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
$response=curl_exec($ch);
$http_code=curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error=curl_error($ch);
if ($error) return array('success'=> false, 'message'=> '请求失败：' . $error);
if ($http_code >=200 && $http_code < 300) return array('success'=> true);
return array('success'=> false, 'message'=> 'HTTP ' . $http_code, 'data'=> array('response'=> $response));
}
public function getFileUrl($object_key)
{
if (!empty($this->custom_domain)) {
return rtrim($this->custom_domain, '/') . '/' . $object_key;
}
return 'https://' . $this->bucket . '-' . $this->app_id . '.cos.' . $this->region . '.myqcloud.com/' . $object_key;
}
}
