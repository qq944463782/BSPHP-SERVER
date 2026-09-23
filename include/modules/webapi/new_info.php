<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'new_info',
    'name'  => '新闻详情',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'new_info', 'a' => 'index'),
    'params'=> array(
        array('name' => 'id', 'label' => '新闻ID', 'required' => true)
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 新闻详情 - 访问: index.php?m=webapi&c=new_info&a=index&id=xxx
 */
class new_info
{
    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
    }

    function call_index()
    {
        $id = Plug_Set_Get('id');

        $sql = "SELECT * FROM  `bs_php_news` WHERE  `news_id` =  '{$id}'   LIMIT 1;";
        $news_array = Plug_Query_Assoc($sql);

        $sql = "SELECT * FROM  `bs_php_news_class` WHERE  `class_id` =  '{$news_array['news_class']}'   LIMIT 1;";
        $news_class_array = Plug_Query_Assoc($sql);

        $news_test = base64_decode($news_array['news_test']);
        $news_test = stripslashes($news_test);

        include Plug_Load_Default_Path();
    }
}
