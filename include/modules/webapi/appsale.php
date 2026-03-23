<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'appsale',
    'name'  => '软件销售-列表与详情',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'appsale', 'a' => 'index'),
    'params'=> array(
        array('name' => 'daihao', 'label' => '软件代号', 'tip' => '详情页必传'),
        array('name' => 'noback', 'label' => '无返回', 'tip' => '1=不显示返回全部软件链接')
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 软件销售 - 访问: index.php?m=webapi&c=appsale&a=list 或 &a=detail&daihao=xxx
 */
class appsale
{
    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
    }

    function call_list()
    {
        $sql = "SELECT `app_daihao`,`app_name`,`app_sale_title`,`app_sale_img`,`app_sale_desc`,`app_sale_kefu` FROM `bs_php_appinfo` 
                WHERE `app_sale_title` IS NOT NULL AND TRIM(`app_sale_title`)!='' 
                ORDER BY `app_sort` ASC, `app_daihao` ASC";
        $res = Plug_Query($sql);
        $app_list = array();
        while ($row = Plug_Pdo_Fetch_Assoc($res)) {
            $app_list[] = $row;
        }
        $sys_url = bs_lib::get_configs_value('sys', 'url');
        if (function_exists('call_my_storage_file_url') && !empty($app_list)) {
            foreach ($app_list as &$a) {
                if (!empty($a['app_sale_img'])) {
                    $a['app_sale_img'] = call_my_storage_file_url($a['app_sale_img']);
                }
            }
            unset($a);
        }
        include Plug_Load_Default_Path();
    }

    function call_detail()
    {
        $daihao = (int)Plug_Set_Get('daihao');
        $noback = (int)Plug_Set_Get('noback');
        if ($daihao <= 0) {
            echo Plug_Lang('软件代号无效');
            exit;
        }
        $sql = "SELECT * FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1";
        $appinfo = Plug_Query_Assoc($sql);
        if (!$appinfo || empty(trim($appinfo['app_sale_title'] ?? ''))) {
            echo Plug_Lang('软件不存在或未参与销售');
            exit;
        }
        if (function_exists('call_my_storage_file_url') && !empty($appinfo['app_sale_img'])) {
            $appinfo['app_sale_img'] = call_my_storage_file_url($appinfo['app_sale_img']);
        }
        $sql = "SELECT `lei_id`,`lei_name`,`lei_jiage`,`lei_date`,`lei_img` FROM `bs_php_kalei` 
                WHERE `lei_daihao`='{$daihao}' AND `lei_jiage`>=0 
                ORDER BY `lei_sort` ASC, `lei_id` ASC";
        $res = Plug_Query($sql);
        $card_list = array();
        while ($row = Plug_Pdo_Fetch_Assoc($res)) {
            if (isset($row['lei_img']) && !empty($row['lei_img']) && function_exists('call_my_storage_file_url')) {
                $row['lei_img'] = call_my_storage_file_url($row['lei_img']);
            }
            $card_list[] = $row;
        }
        $sys_url = bs_lib::get_configs_value('sys', 'url');
        include Plug_Load_Default_Path();
    }
}
