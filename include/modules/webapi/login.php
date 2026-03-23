<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

/**
 * WEBAPI 接口元数据 - 供后台 API 列表页自动列举
 */
$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'login',
    'name'  => '登录',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'login', 'a' => 'index'),
    'params'=> array(
        array('name' => 'BSphpSeSsL', 'label' => 'BSphpSeSsL', 'labelNote' => '验证串,长度64位', 'optional' => true),
        array('name' => 'user', 'label' => '用户帐户', 'required' => true),
        array('name' => 'pwd', 'label' => '用户密码', 'required' => true),
        array('name' => 'login', 'label' => 'login', 'defaultValue' => '1', 'tip' => '表单提交时传1')
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * @登录
 * 访问: index.php?m=webapi&c=login&a=index
 */
class login
{

    private $rc, $param_db, $GLOBALS_LANGS, $user_str_log, $intelligence_appen_str_log, $user, $session;

    function __construct()
    {

        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');


        //$this->intelligence_GLOBALS_LANGS = Plug_Load_Langs_Array('','');
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');
        //$this->intelligence_intelligence_appen_str_log = Plug_Load_Langs_Array('applib', 'intelligence_appen_str_log');

        //开启session
        //Plug_Session_Open();
    }


    /**
     * @登录
     * http://127.0.0.5/index.php?m=webapi&c=login&a=index&BSphpSeSsL=[验证串:可空]&user=[用户帐户]
     */
    function call_index()
    {
        $log_name = '';
        $BSphpSeSsL = Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Session_Open();
        } else {
            Plug_Session_Open($BSphpSeSsL);
        }


        $show = Plug_Set_Get('show');

        //验证成功
        $param_login_sate = Plug_Set_Get('login_sate');
        if ($param_login_sate == 'YES') {
            echo 'YES';
            exit;
        }


        //判断是否已经登陆
        if (Plug_User_Is_Login_Seesion() == 1047) {
            $seesid = session_id();
            bs_call_location("index.php?m=webapi&c=login&a=index&BSphpSeSsL={$seesid}&login_sate=YES");
        }

        //接收参数
        $param_imga_yan = Plug_Set_Post('code');
        $user = Plug_Set_Post('user');
        $pwd = Plug_Set_Post('pwd');
        $login = Plug_Set_Post('login');


        if ($login) {
            //判断验证对错
            if (Plug_Get_Configs_Value('code', 'coode_login') == 1) {


                $log = Plug_Push_Cood_Imges($param_imga_yan);
                if ((int)$log !== 1037)
                    $log_name = $this->user_str_log[$log];
                include Plug_Load_Default_Path();
                exit;
            }

            //转换真实user信息,顺序账户,邮箱,手机 uid+密码
            $user = Plug_UserTageToUser($user, $pwd);


            //用户登陆
            $log = Plug_User_Web_Login($user, $pwd);


            if ($log == 1011) {


                $sql = "SELECT * FROM  `bs_php_user` WHERE  `user_user` =  '{$user}'   LIMIT 1;";
                $ser_array = Plug_Query_Assoc($sql);
                //代理权限验证
                if ($ser_array['user_daili'] > 0) {
                    $log_name = '代理商没有权限登录用户中心';
                    Plug_Links_Out_Session_Id(session_id());
                    include Plug_Load_Default_Path();
                    exit;
                }


                //系统日志记录
                Plug_Add_AppenLog('user_login_log', 'APP网页登录', $user);
                //session 在线设置

                Plug_Links_Add_Info(0, $user);

                $log_name = '登录成功！';

                $session_id = session_id();
                header("Location: index.php?m=webapi&c=login&a=index&BSphpSeSsL={$session_id}&login_sate=YES");
                exit;
            }


            $log_name = $this->user_str_log[$log];
        } else {
            $user = Plug_Set_Get('user');
            $pwd = Plug_Set_Get('pwd');
        }


        include Plug_Load_Default_Path();
    }


}
