<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
class storage_aliyun_oss
{
private $access_key_id;
private $access_key_secret;
private $endpoint;
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
$this->access_key_id=trim($cfg['aliyun_access_key_id'] ?? '');
$this->access_key_secret=trim($cfg['aliyun_access_key_secret'] ?? '');
$this->endpoint=trim($cfg['aliyun_endpoint'] ?? '');
$this->bucket=trim($cfg['aliyun_bucket'] ?? '');
$this->region=trim($cfg['aliyun_region'] ?? '');
$this->custom_domain=trim($cfg['aliyun_custom_domain'] ?? '');
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
$url='https://' . $this->bucket . '.' . $this->endpoint . '/' . $object_key;
$date=gmdate('D, d M Y H:i:s \G\M\T');
$content_type=$this->getContentType($object_key);
$content_length=strlen($file_content);
$string_to_sign="PUT\n\n" . $content_type . "\n" . $date . "\n/" . $this->bucket . '/' . $object_key;
$signature=base64_encode(hash_hmac('sha1', $string_to_sign, $this->access_key_secret, true));
$headers=array(
'Date: ' . $date,
'Content-Type: ' . $content_type,
'Content-Length: ' . $content_length,
'Authorization: OSS ' . $this->access_key_id . ':' . $signature
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
return 'https://' . $this->bucket . '.' . $this->endpoint . '/' . $object_key;
}
}
