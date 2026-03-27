<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'pc',
    'name'  => 'PC账号登陆模式一体页（公告+登陆/注册/解绑/充值/改密/找回密码/反馈）',
    'path'  => '/index.php',
    'method' => 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'pc', 'a' => 'index'),
    'params' => array(
        array('name' => 'daihao', 'label' => '软件代号', 'labelNote' => '软件代号', 'required' => true),
        array('name' => 'BSphpSeSsL', 'label' => 'BSphpSeSsL', 'labelNote' => '验证串,长度64位', 'required' => true),
    )
);

if (defined('WEBAPI_SCAN')) return;



/**
 * PC 软件加载用一体页 - 公告头部 + 登陆/注册/解绑定/充值/改密码/找回密码/反馈问题
 * 访问: index.php?m=webapi&c=pc&a=index
 */
class pc
{


    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
    }

    function call_index()
    {
        $BSphpSeSsL = Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            plug_print_json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        }

        Plug_Session_Open($BSphpSeSsL);
        $daihao = Plug_Set_Get('daihao');
        if ($daihao == '') plug_print_json(array('code' => -1, 'msg' => 'daihao必须传入'));
        $announce_list = $announce_list ?? array();
        // 验证码开关：后台 配置 -> 验证码设置 (m=admin&c=config&a=code)
        $code_login = (int)Plug_Get_Configs_Value('code', 'coode_login');
        $code_registration = (int)Plug_Get_Configs_Value('code', 'coode_registration');
        $code_backpwd = (int)Plug_Get_Configs_Value('code', 'coode_backpwd');
        $code_say = (int)Plug_Get_Configs_Value('code', 'coode_say');
        include Plug_Load_Default_Path();
    }

    /**
     * 登录接口 - JS 请求，返回 JSON
     * POST: user, pwd, code(可选), BSphpSeSsL(可选)
     */
    function call_login()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            plug_print_json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        }

        Plug_Session_Open($BSphpSeSsL);

        $daihao = Plug_Set_Data_Post_Get('daihao');
        if ($daihao == '') plug_print_json(array('code' => -1, 'msg' => 'daihao必须传入'));
        $user_str_log = plug_load_langs_array('user', 'user_str_log');
        $user = Plug_Set_Data_Post_Get('user');
        $pwd = Plug_Set_Data_Post_Get('pwd');
        $code = Plug_Set_Data_Post_Get('code');




        if ($user == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入账号.')));
            return;
        }
        if ($pwd == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入密码.')));
            return;
        }

        if (Plug_Get_Configs_Value('code', 'coode_login') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                $msg =  Plug_Lang('验证码错误');
                plug_print_json(array('code' => -11111, 'msg' => $msg));
                return;
            }
        }

        $user = Plug_UserTageToUser($user, $pwd);
        $log = Plug_User_Web_Login($user, $pwd);

        if ($log == 1011) {
            $sql = "SELECT * FROM `bs_php_user` WHERE `user_user`='{$user}' LIMIT 1;";
            $ser_array = Plug_Query_Assoc($sql);
            if ($ser_array && (int)($ser_array['user_daili'] ?? 0) > 0) {
                Plug_Links_Out_Session_Id(session_id());
                plug_print_json(array('code' => -1, 'msg' => '代理商没有权限登录用户中心'));
                return;
            }
            Plug_Add_AppenLog('user_login_log', 'APP网页登录', $user);
            Plug_Links_Add_Info(0, $user);
            plug_print_json(array('code' => 1011, 'msg' => '验证成功'));
        } else {
            $msg = $user_str_log[$log] ?? Plug_Lang('登录失败');
            plug_print_json(array('code' => $log, 'msg' => $msg));
            return;
        }
    }

    /**
     * 注册接口 - 参考 AppEn.registration.lg.php
     * POST: user, pwd, pwdb, qq, mail, extension, mobile, question, answer, code(可选)
     */
    function call_register()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') plug_print_json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        Plug_Session_Open($BSphpSeSsL);
        $daihao = Plug_Set_Data_Post_Get('daihao');

        $user_str_log = plug_load_langs_array('user', 'user_str_log');
        $user = Plug_Set_Post('user');
        $pwd = Plug_Set_Post('pwd');
        $pwdb = Plug_Set_Post('pwdb');
        $qq = Plug_Set_Post('qq');
        $mail = strtolower(trim((string)Plug_Set_Post('mail')));
        $extension = Plug_Set_Post('extension') ?: '';
        $Mobile = Plug_Set_Post('mobile');
        $mibao_wenti = Plug_Set_Post('question');
        $mibao_daan = Plug_Set_Post('answer');
        $code = Plug_Set_Post('code');
        if ($user == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入账号.')));
        }
        if ($pwd == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入密码.')));
        }
        if ($pwdb == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请再次输入密码.')));
        }
        if ($daihao == '') plug_print_json(array('code' => -1, 'msg' => 'daihao必须传入'));
        if (Plug_Get_Configs_Value('code', 'coode_registration') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                plug_print_json(array('code' => -11111, 'msg' =>  Plug_Lang('验证码错误')));
                return;
            }
        }


        $param_sql = "SELECT * FROM `bs_php_appinfo` WHERE `app_daihao` = '{$daihao}' LIMIT 1";
        $param_daihao_info = Plug_Query_Array($param_sql);
        if(empty($param_daihao_info)) {
            plug_print_json(array('code' => -1, 'msg' => 'daihao不存在'));
            return;
        }



        $log = Plug_User_Re_Add($user, $pwd, $pwdb, $qq, $mail, $extension, $Mobile, $mibao_wenti, $mibao_daan);
        if ($log == 1005) {
            $uid = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`');
            $date = (int)$param_daihao_info['app_re_date'];

           
   

            $date = $date > 0 ? PLUG_UNIX() + $date : 0;
            Plug_App_Login_Add_Key($uid, $daihao, $date, '', $user, $user);


            plug_print_json(array('code' => 1005, 'msg' => Plug_Lang('注册成功')));
        } else {
            $msg = $user_str_log[$log];
            plug_print_json(array('code' => $log, 'msg' => $msg));
        }
    }

    /**
     * 解绑定接口 - 参考 AppEn.jiekey.lg.php
     * POST: user, pwd, daihao
     */
    function call_unbind()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') plug_print_json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        Plug_Session_Open($BSphpSeSsL);
        $daihao = Plug_Set_Data_Post_Get('daihao');
        if ($daihao == '') plug_print_json(array('code' => -1, 'msg' => 'daihao必须传入'));
        $user_str_log = plug_load_langs_array('user', 'user_str_log');
        $user = Plug_Set_Data_Post_Get('user');
        $pwd = Plug_Set_Data_Post_Get('pwd');
        if ($user == '' || $pwd == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入账号和密码.')));
        }
        if ($daihao == '') plug_print_json(array('code' => -1, 'msg' => 'daihao必须传入'));
        $user = Plug_UserTageToUser($user, $pwd);
        $log = Plug_Is_User_Account($user, $pwd);
        if ($log != 1011) {
            plug_print_json(array('code' => $log, 'msg' => $user_str_log[$log]));
        }


        $User_Info = Plug_Query_One('bs_php_user', 'user_user', $user, ' * ');
      
        if(empty($User_Info)) {
            plug_print_json(array('code' => -1, 'msg' => '账号不存在'));
        }


        $uid = $User_Info['user_uid'];


        $arr = Plug_Get_App_User_Info($uid, $daihao);
        if (empty($arr) || $arr['L_key_info'] == '') {
            plug_print_json(array('code' => 200, 'msg' => '已经是解除绑定了'));
        }
        if ($arr['L_vip_unix'] > PLUG_UNIX()) {
            $param_sql = "SELECT * FROM `bs_php_appinfo` WHERE `app_daihao` = '{$daihao}' LIMIT 1";
            $param_daihao_info = Plug_Query_Array($param_sql);
            if(empty($param_daihao_info)) {
                plug_print_json(array('code' => -1, 'msg' => 'daihao不存在'));
                return;
            }
            $app_date = $param_daihao_info['app_zhuang_date'];
            $date = $arr['L_vip_unix'] - $app_date;
            if ($date < PLUG_UNIX()) {
                plug_print_json(array('code' => -1, 'msg' => '解除绑定后将到期,解除绑定拒绝!'));
            }
            $sql = "UPDATE`bs_php_pattern_login`SET`L_key_info`='',`L_vip_unix`='$date' WHERE`L_id`='{$arr['L_id']}'";
            $tmp = Plug_Query($sql);
            if ($tmp) {
                Plug_Add_AppenLog('user_login_log', '操作解除绑定成功 新到期时间:' . date('Y-m-d H:i:s', $date), $user);
                plug_print_json(array('code' => 200, 'msg' => '解除绑定成功!,新到期时间:' . date('Y-m-d H:i:s', $date)));
            }
            plug_print_json(array('code' => -1, 'msg' => '解除绑定失败,请重试!'));
        }
        $sql = "UPDATE`bs_php_pattern_login`SET`L_key_info`='' WHERE`L_id`='{$arr['L_id']}' AND `L_daihao`='{$daihao}'";
        Plug_Query($sql);
        plug_print_json(array('code' => 200, 'msg' => '使用期到了被强制解绑了'));
    }

    /**
     * 充值接口 - 参考 AppEn.chong.lg.php
     * POST: user, userpwd, ka, pwd, daihao
     */
    function call_recharge()
    {
        $BSphpSeSsL = Plug_Set_Post('BSphpSeSsL') ?: Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') plug_print_json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        $daihao = Plug_Set_Post('daihao') ?: Plug_Set_Get('daihao');
        if ($daihao == '') plug_print_json(array('code' => -1, 'msg' => 'daihao必须传入'));
        $user_str_log = plug_load_langs_array('user', 'user_str_log');
        $user = Plug_Set_Post('user');
        $userpwd = Plug_Set_Post('userpwd');
        $ka = Plug_Set_Post('ka');
        $pwd = Plug_Set_Post('pwd');
        if ($user == '' || $userpwd == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入账号和密码.')));
        }
        if ($ka == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入充值卡号.')));
        }
        $user = Plug_UserTageToUser($user, $userpwd);
        $log = Plug_User_Chong($user, $ka, $pwd);
        if ($log == 1033) {
            plug_print_json(array('code' => 1033, 'msg' => Plug_Lang('充值成功')));
        } else {
            $msg = $user_str_log[$log];
            plug_print_json(array('code' => $log, 'msg' => $msg));
        }
    }

    /**
     * 改密码接口 - 参考 AppEn.password.lg.php
     * POST: user, pwd(旧), pwda(新), pwdb(确认), code(可选)
     */
    function call_changepwd()
    {
        $BSphpSeSsL = Plug_Set_Post('BSphpSeSsL') ?: Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') plug_print_json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        Plug_Session_Open($BSphpSeSsL);
        $daihao = Plug_Set_Post('daihao') ?: Plug_Set_Get('daihao');
        if ($daihao == '') plug_print_json(array('code' => -1, 'msg' => 'daihao必须传入'));
        $user_str_log = plug_load_langs_array('user', 'user_str_log');
        $user = Plug_Set_Post('user');
        $pwd = Plug_Set_Post('pwd');
        $pwda = Plug_Set_Post('pwda');
        $pwdb = Plug_Set_Post('pwdb');
        $code = Plug_Set_Post('code');
        if ($user == '' || $pwd == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入账号和旧密码.')));
        }
        if ($pwda == '' || $pwdb == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入新密码和确认密码.')));
        }
        if (Plug_Get_Configs_Value('code', 'coode_backpwd') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                plug_print_json(array('code' => -11111, 'msg' =>  Plug_Lang('验证码错误')));
            }
        }
        $user = Plug_UserTageToUser($user, $pwd);
        $log = Plug_Is_User_Account($user, $pwd);
        if ($log != 1011 && $log != 1047) {
            plug_print_json(array('code' => $log, 'msg' => $user_str_log[$log]));
        }



        $User_Info = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`');
        $uid = $User_Info['user_uid'];
        $log = Plug_User_Modify_PassWord($uid, $pwd, $pwda, $pwdb);
        if ($log == 1033) {
            plug_print_json(array('code' => 1033, 'msg' => Plug_Lang('修改成功')));
        } else {
            $msg = $user_str_log[$log];
            plug_print_json(array('code' => $log, 'msg' => $msg));
        }
    }

    /**
     * 找回密码接口 - 参考 AppEn.backto.lg.php (密保找回)
     * POST: user, pwd(新), pwdb(确认), mibao(问题), daan(答案), code(可选)
     */
    function call_findpwd()
    {
        $BSphpSeSsL = Plug_Set_Post('BSphpSeSsL') ?: Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') plug_print_json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        Plug_Session_Open($BSphpSeSsL);
        $daihao = Plug_Set_Post('daihao') ?: Plug_Set_Get('daihao');
        if ($daihao == '') plug_print_json(array('code' => -1, 'msg' => 'daihao必须传入'));
        $user_str_log = plug_load_langs_array('user', 'user_str_log');
        $user = Plug_Set_Post('user');
        $pwd = Plug_Set_Post('pwd');
        $pwdb = Plug_Set_Post('pwdb');
        $mibao = Plug_Set_Post('mibao');
        $daan = Plug_Set_Post('daan');
        $code = Plug_Set_Post('code');
        if ($user == '') {
            plug_print_json(array('code' => -1, 'msg' => '请输入账号.'));
        }
        if ($pwd == '') {
            plug_print_json(array('code' => -1, 'msg' => '请输入密码.'));
        }
        if ($pwdb == '') {
            plug_print_json(array('code' => -1, 'msg' => '请再次输入密码.'));
        }
        if ($mibao == '') {
            plug_print_json(array('code' => -1, 'msg' => '请输入密保.'));
        }
        if ($daan == '') {
            plug_print_json(array('code' => -1, 'msg' => '请输入答案.'));
        }
        if (Plug_Get_Configs_Value('code', 'coode_backpwd') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                plug_print_json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }
        $user = Plug_UserTageToUser($user, $pwdb);
        $log = Plug_User_MiBao_Pwd($user, $pwd, $pwdb, $mibao, $daan);
        if ($log == 1033) {
            plug_print_json(array('code' => 1033, 'msg' => Plug_Lang('密码已成功找回')));
        } else {
            $msg = $user_str_log[$log];
            plug_print_json(array('code' => $log, 'msg' => $msg));
        }
    }

    /**
     * 反馈问题接口 - 参考 AppEn.liuyan.in.php
     * POST: user, pwd, table(标题), leix(类型), qq(联系方式), txt(内容), code(可选), daihao
     */
    function call_feedback()
    {
        $BSphpSeSsL = Plug_Set_Post('BSphpSeSsL') ?: Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') plug_print_json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        Plug_Session_Open($BSphpSeSsL);
        $daihao = Plug_Set_Post('daihao') ?: Plug_Set_Get('daihao');
        if ($daihao == '') plug_print_json(array('code' => -1, 'msg' => 'daihao必须传入'));
        $user_str_log = plug_load_langs_array('user', 'user_str_log');
        $user = Plug_Set_Post('user');
        $pwd = Plug_Set_Post('pwd');
        $table = Plug_Set_Post('table');
        $leix = Plug_Set_Post('leix');
        $qq = Plug_Set_Post('qq');
        $txt = Plug_Set_Post('txt');
        $code = Plug_Set_Post('code');
        if ( $txt == '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入标题和内容.')));
        }
        if (Plug_Get_Configs_Value('code', 'coode_say') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                plug_print_json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }
        $uid = 0;
        if ($user != '' && $pwd != '') {
            $user = Plug_UserTageToUser($user, $pwd);
            $log = Plug_Is_User_Account($user, $pwd);
            if ($log == 1011) {
                $User_Info = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`');
                $uid = $User_Info['user_uid'];
            } else {
                plug_print_json(array('code' => $log, 'msg' => $user_str_log[$log]));
            }
        } else {
            $log = Plug_User_Is_Login_Seesion();
            if ($log == 1047) $uid = Plug_Get_Session_Value('USER_UID');
        }
        $log = Plug_UserAddLiuYan($leix, $table, $qq, $uid, $daihao, $txt);
        if ($log == 1) {
            plug_print_json(array('code' => 1, 'msg' => Plug_Lang('提交成功')));
        } else {
            $msg = $user_str_log[$log];
            plug_print_json(array('code' => $log, 'msg' => $msg));
        }
    }
}
