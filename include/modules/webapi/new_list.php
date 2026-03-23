<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'new_list',
    'name'  => '添加网页接口新闻/公告',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'new_list', 'a' => 'index'),
    'params'=> array(
        array('name' => 'open_new', 'label' => 'open_new', 'defaultValue' => '_blank', 'tip' => '是否新窗口打开，如:_blank')
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 添加网页接口新闻/公告 - 访问: index.php?m=webapi&c=new_list&a=index
 */
class new_list
{
    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
    }

    function call_index()
    {
        $list = (int)Plug_Set_Get('list');
        $p = (int)Plug_Set_Get('p');
        $act = Plug_Set_Get('act');
        $open_new = Plug_Set_Get('open_new');

        $Page_mober = 15;
        $LIMIT_As = $p;
        if ($LIMIT_As > 0)
            $LIMIT_As = $LIMIT_As - 1;
        $LIMIT_A = $LIMIT_As * $Page_mober;

        $date = null;
        $sql_list = null;
        $news_text = null;
        $i = 1;
        if ($list > 0)
            $sql_list = "AND `news_class`='$list'";
        $sql = "SELECT * FROM `bs_php_news`,`bs_php_news_class` WHERE class_id!=91000 AND class_id!=92000 AND `bs_php_news`.`news_class`=`bs_php_news_class`.`class_id` {$sql_list} ORDER BY`news_id`DESC LIMIT {$LIMIT_A},{$Page_mober}";
        $pdb_array_value = Plug_Query($sql);

        $sql_rows = "SELECT count(*)as 'hangshu' FROM`bs_php_news_class`, `bs_php_news` WHERE  class_id!=91000 AND class_id!=92000 AND `bs_php_news`.`news_class`=`bs_php_news_class`.`class_id`  {$sql_list} ORDER BY`news_id`DESC";
        $db_array_value = Plug_Query($sql);

        $param_tmp = Plug_Query_Assoc($sql_rows);
        $param_zongshu = $param_tmp['hangshu'];
        $zongyue = $param_zongshu / $Page_mober;
        $yueshuls = intval(strval($param_zongshu / $Page_mober));
        if ($zongyue > $yueshuls)
            $zongyue = ++$yueshuls;

        $pg_text = null;
        $wrap_q = isset($_GET['wrap']) ? '&wrap='.(int)$_GET['wrap'] : '';
        $i = 1;
        while ($i <= $zongyue) {
            $pg_text .= "<li><a href='index.php?m=webapi&c=new_list&a=index&open_new=$open_new&list=$list&p=$i{$wrap_q}'>{$i}</a></li>";
            $i++;
        }

        if ($list > 0) {
            $sql = "SELECT * FROM  `bs_php_news_class` WHERE  `class_id` =  '{$list}'   LIMIT 1;";
            $list_array = Plug_Query_Assoc($sql);
        } else {
            $list_array['class_name'] = '新闻动态';
            $list_array['class_id'] = '0';
        }

        include Plug_Load_Default_Path();
    }
}
