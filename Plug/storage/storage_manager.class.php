<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
class storage_manager
{
private $storage_upload;
public function __construct()
{
require_once dirname(__FILE__) . '/storage_upload.class.php';
$this->storage_upload=new storage_upload();
}
public function uploadFile($file, $upload_path='')
{
if (empty($upload_path)) {
$upload_path=$this->storage_upload->generateUploadPath('default', $file['name']);
}
$result=$this->storage_upload->uploadFile($file['tmp_name'], $upload_path);
if ($result['success']) {
return array('success'=> true, 'url'=> $result['url'], 'path'=> $upload_path, 'message'=> '上传成功');
}
return array('success'=> false, 'message'=> isset($result['message']) ? $result['message'] : '上传失败', 'data'=> isset($result['data']) ? $result['data'] : null);
}
}
