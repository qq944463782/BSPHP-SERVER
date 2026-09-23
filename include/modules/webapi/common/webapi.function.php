<?php

defined('BSPHP_SET') or die();

/**
 * 扫描 webapi 目录下的接口文件，收集 WEBAPI_META 元数据
 * 供后台 API 列表页自动列举，用户新增接口文件后会自动显示
 *
 * @return array 接口列表
 */
function webapi_scan_apis()
{
    $dir = Plug_Get_Bsphp_Dir() . 'include/modules/webapi/';
    $list = array();
    if (!is_dir($dir)) return $list;

    $files = glob($dir . '*.php');
    if (!defined('WEBAPI_SCAN')) define('WEBAPI_SCAN', true);
    foreach ($files as $file) {
        $GLOBALS['WEBAPI_META'] = null;
        include $file;
        $meta = isset($GLOBALS['WEBAPI_META']) ? $GLOBALS['WEBAPI_META'] : null;
        if ($meta && is_array($meta) && !empty($meta['id'])) {
            // 附带来源文件名，供列表展示；文件名不保证等于 id（大小写等），所以这里直接给
            $meta['file'] = basename($file);
            $list[] = $meta;
        }
    }
    return $list;
}
