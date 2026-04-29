<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT')
    die('Not,This File Not Can in Ie Modules');


/*
 * Feature: 代理登录与入口(旧控制器)
 * Menu ID: legacy_index
 * 说明: 历史入口控制器，处理代理登录、退出与基础入口跳转。
 */
class index 
{

    public $db, $purconfig, $session,$user,$user_str_log;
    function __construct()
    {

        plug_session_open();
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');


        if (Plug_Get_Configs_Value( 'sys', 'stop') == 1) {


            Plug_alerts(Plug_Lang('系统维护'), Plug_Get_Configs_Value( 'sys', 'stop_info'));
        }





    }


    /**
     * @控制面板-登录面板
     * 
     */
    function call_index()
    {


        /**
         * 获取登录信息
         */
        $appenconfig = Plug_Set_Post( 'appenconfig');
        if ($appenconfig) {




            $amdin_name = Plug_Set_Post( 'amdin_name');
            $admin_password = Plug_Set_Post( 'admin_password');
            $imga_yan = Plug_Set_Post( 'code');
            $lang = (int)Plug_Set_Post( 'lang');


            //判断验证对错

            if (Plug_Get_Configs_Value( 'code', 'coode_login') == true) {
                $log = Plug_Push_Cood_Imges($imga_yan);
                if ($log != 1037) Plug_Print_Json(array( 'code' =>  '1',  'msg' => $this->user_str_log[$log]));
            }

            /**
             * @用户登陆
             * 
             * 直接调用类登陆
             * 1011 = 登陆成功
             */
            $log = Plug_User_Web_Login($amdin_name, $admin_password);
            if ($log == 1011) {



                if (Plug_Get_Configs_Value( 'sys', 'stop_agent') == 0) {


                    Plug_Set_Session_Value('USER_UID', 'Not'); //登陆UID
                    Plug_Print_Json(array( 'code' =>  '1',  'msg' => Plug_Get_Configs_Value( 'sys', 'stop_agent_info')));
                    exit;
                }



                //验证是否代理商
                $user_array = Plug_Query_One( 'bs_php_user', 'user_user', $amdin_name, ' * ');
                if ($user_array[ 'user_daili'] == 0) {
                    Plug_Set_Session_Value('USER_UID', 'Not'); //登陆UID
                    // alert('需要代理商才可登录,你没有权限。');
                    Plug_Print_Json(array( 'code' =>  '1',  'msg' => Plug_Lang('需要代理商才可登录,你没有权限。')));
                    exit;
                }

                $i = 0;



                $BS_val_agent_ok = 0;

                $BS_val_agent_array = Plug_Query_One( 'bs_php_user', 'user_user', $amdin_name, ' `user_uid`,`user_user`,`user_IsLock`,`user_yao_User` ');
                while ($i < 100) {
                    $i++;
                    if (!$BS_val_agent_array) {
                        break;
                    }
                    if ($BS_val_agent_array['user_IsLock'] == 1) {
                        $BS_val_agent_ok = 1;
                        break;
                    }
                    $BS_val_agent_array = Plug_Query_One( 'bs_php_user', 'user_user', $BS_val_agent_array['user_yao_User'], ' `user_uid`,`user_user`,`user_IsLock`,`user_yao_User` ');
                }

                if ($BS_val_agent_ok == 1) {
                    Plug_Print_Json(array( 'code' =>  '1',  'msg' => Plug_Lang('上级代理账号被冻结无法登录uid:') . $BS_val_agent_array['user_uid']));
                    Plug_Set_Session_Value('USER_UID', 'Not'); //登陆UID
                    exit;
                }

                if (Plug_Get_Session_Value( 'USER_UID_IS') == 0) {
                    Plug_Print_Json(array( 'code' =>  '1',  'msg' => call_my_base64_decode("W" . "+" . "e" . "z" . "u" . "+" . "e" . "7" . "n" . "+" . "S" . "9" . "v" . "+" . "e" . "U" . "q" . "O" . "a" . "O" . "i" . "O" . "a" . "d" . "g" . "1" . "3" . "m" . "g" . "q" . "j" . "l" . "v" . "Z" . "P" . "l" . "i" . "Y" . "3" . "m" . "j" . "o" . "j" . "m" . "n" . "Y" . "P" . "m" . "n" . "I" . "n" . "p" . "g" . "6" . "j" . "l" . "i" . "I" . "b" . "o" . "v" . "o" . "X" . "l" . "i" . "q" . "n" . "l" . "i" . "p" . "/" . "o" . "g" . "7" . "3" . "k" . "v" . "b" . "/" . "n" . "l" . "K" . "j" . "l" . "j" . "5" . "f" . "p" . "m" . "Z" . "A" . "u" . "5" . "a" . "a" . "C" . "5" . "p" . "6" . "c" . "5" . "o" . "K" . "o" . "5" . "L" . "i" . "A" . "5" . "a" . "6" . "a" . "6" . "K" . "a" . "B" . "5" . "L" . "2" . "/" . "5" . "5" . "S" . "o" . "6" . "K" . "+" . "l" . "5" . "Y" . "q" . "f" . "6" . "I" . "O" . "9" . "6" . "K" . "+" . "3" . "6" . "L" . "S" . "t" . "5" . "L" . "m" . "w" . "5" . "Y" . "W" . "o" . "5" . "Y" . "q" . "f" . "6" . "I" . "O" . "9" . "5" . "o" . "6" . "I" . "5" . "p" . "2" . "D" . "5" . "a" . "W" . "X" . "6" . "a" . "S" . "Q" . "")));
                    Plug_Set_Session_Value('USER_UID', 'Not'); //登陆UID
                    exit;
                }


                //系统日志记录
               Plug_Add_AppenLog('user_login_log', Plug_Lang('登录代理平台'), $user_array[ 'user_user']);
                //session 在线设置
                Plug_Links_Add_Info(0, $user_array[ 'user_user']);



                if ($lang < 0 or $lang > 15) {
                    $lang = 0;
                }

             
                Plug_Set_Session_Value('AGENT_LANG', $lang); //登陆UID


                Plug_Print_Json(array( 'code' => 8,  'msg' => Plug_Lang('登录成功'), 'url' => 'index.php?m=agent&c=main'));
            }

            // die(alert($this->user_str_log[$log]));
            Plug_Print_Json(array( 'code' =>  '1',  'msg' => $this->user_str_log[$log]));
        }


        include Plug_Load_Default_Path();
    }


    /**
     * @控制面板-登录面板
     * 
     */
    function call_loginout()
    {
        //等于用户前台和代理登录时候设置cookie
        Plug_Set_Session_Value('USER_UID', ''); //登陆UID
        Plug_Set_Session_Value('USER_YSE', ''); //登陆MD7加密 , 密码
        Plug_Set_Session_Value('USER_DATE', ''); //上一次登陆时间
        Plug_Set_Session_Value('USER_IP', ''); //上一次登陆IP
        Plug_Set_Session_Value('USER_MD7', ''); //OOKIE MD7验证串

        header("Location: index.php");
    }
}
