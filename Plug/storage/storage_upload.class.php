<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
class storage_upload
{
private function getStorageConfig()
{
$config=����������������������������������������������������������������::������������������������������������������������������������������������������������('StorageConfig');
return is_array($config) ? $config : array();
}
private function getDefaultProvider()
{
$config=$this->getStorageConfig();
return $config['default_provider'] ?? 'local';
}
private function isConfigComplete($provider)
{
$config=$this->getStorageConfig();
switch ($provider) {
case 'aliyun':
return !empty($config['aliyun_access_key_id']) && !empty($config['aliyun_access_key_secret']) && !empty($config['aliyun_endpoint']) && !empty($config['aliyun_bucket']) && !empty($config['aliyun_region']);
case 'baidu':
return !empty($config['baidu_access_key_id']) && (!empty($config['baidu_secret_access_key']) || !empty($config['baidu_access_key_secret'])) && !empty($config['baidu_endpoint']) && !empty($config['baidu_bucket']);
case 'tencent':
return !empty($config['tencent_secret_id']) && !empty($config['tencent_secret_key']) && !empty($config['tencent_app_id']) && !empty($config['tencent_bucket']) && !empty($config['tencent_region']);
case 'local':
$root=trim($config['local_root_folder'] ?? 'upfiles') ?: 'upfiles';
return defined('����������������������������������������4��������������������') && !empty($root);
default:
return false;
}
}
public function uploadFile($file_path, $upload_path, $provider='')
{
if (empty($provider)) $provider=$this->getDefaultProvider();
if (!$this->isConfigComplete($provider)) {
return array('success'=> false, 'message'=> '云存储配置不完整');
}
if (!file_exists($file_path)) {
return array('success'=> false, 'message'=> '文件不存在');
}
try {
switch ($provider) {
case 'aliyun':
require_once dirname(__FILE__) . '/storage_aliyun_oss.class.php';
$cls=new storage_aliyun_oss();
return $cls->uploadFile($file_path, $upload_path);
case 'baidu':
require_once dirname(__FILE__) . '/storage_baidu_bos.class.php';
$cls=new storage_baidu_bos();
return $cls->uploadFile($file_path, $upload_path);
case 'tencent':
require_once dirname(__FILE__) . '/storage_tencent_cos.class.php';
$cls=new storage_tencent_cos();
return $cls->uploadFile($file_path, $upload_path);
case 'local':
return $this->uploadToLocal($file_path, $upload_path);
default:
return array('success'=> false, 'message'=> '不支持的存储类型');
}
} catch (Exception $e) {
return array('success'=> false, 'message'=> '上传失败：' . $e->getMessage());
}
}
private function uploadToLocal($file_path, $upload_path)
{
$config=$this->getStorageConfig();
$rootFolder=trim($config['local_root_folder'] ?? 'upfiles') ?: 'upfiles';
$base=defined('����������������������������������������4��������������������') ? rtrim(����������������������������������������4��������������������, '/') . '/' . $rootFolder : dirname(dirname(dirname(__FILE__))) . '/' . $rootFolder;
$target_dir=$base . '/' . dirname($upload_path);
$target_file=$target_dir . '/' . basename($upload_path);
if (!is_dir($target_dir)) {
if (!@mkdir($target_dir, 0755, true)) {
return array('success'=> false, 'message'=> '创建目录失败');
}
}
if (!@copy($file_path, $target_file)) {
return array('success'=> false, 'message'=> '文件复制失败');
}
$url_path=$rootFolder . '/' . $upload_path;
$url=function_exists('��������������������Q����������������������������������������������������') ? ��������������������Q����������������������������������������������������($url_path) : $url_path;
return array('success'=> true, 'url'=> $url);
}
public function generateUploadPath($category, $fileName)
{
return $category . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $fileName;
}
}
