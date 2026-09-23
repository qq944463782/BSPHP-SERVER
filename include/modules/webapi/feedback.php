<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'feedback',
    'name'  => '添加网页接口反馈',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'feedback', 'a' => 'index'),
    'params'=> array(
        array('name' => 'daihao', 'label' => '软件代号', 'required' => true),
        array('name' => 'uid', 'label' => '用户UID', 'tip' => '自定义'),
        array('name' => 'table', 'label' => '名称标题', 'tip' => '反馈标题' ,'labelNote' => '反馈标题','required' => true),
        array('name' => 'leix', 'label' => '类型', 'tip' => '类型','labelNote' => '类型','required' => true)
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 添加网页接口反馈 - 访问: index.php?m=webapi&c=feedback&a=index
 */
class feedback
{
    private $user_str_log;

    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');
    }

    function call_index()
    {
        Plug_Session_Open();

        $daihao = Plug_Set_Get('daihao');
        $uid = Plug_Set_Get('uid');
        $table = Plug_Set_Get('table');
        $leix = Plug_Set_Get('leix');

        $qq = Plug_Set_Post('qq');
        $txt = Plug_Set_Post('txt');
        $code = Plug_Set_Post('code');

        if (Plug_Get_Configs_Value('code', 'coode_say') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ($log != 1037) {
                $log_name = $this->user_str_log[$log];
                include Plug_Load_Default_Path();
                exit;
            }
        }

        $log = Plug_UserAddLiuYan($leix, $table, $qq, $uid, $daihao, $txt);
        $log_name = $this->user_str_log[$log];

        include Plug_Load_Default_Path();
    }
}
