<?php
/*
 * Feature: 批量查询授权码
 * Menu ID: batch_query
 * 说明: 批量查询卡密状态入口页，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT')
    die('Not,This File Not Can in Ie Modules');

class BatchQueryFeature
{
    public $Grade, $GLOBALS_LANGS, $user_array, $user_str_log;

    function __construct()
    {
        //开启会话 seesion
        plug_session_open();
        //加载用户语言包
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');

        //判断是否开启代理,不是代理就禁止使用
        if (Plug_Get_Configs_Value('sys', 'stop_agent') == 0) {
            Plug_alerts(Plug_Lang('系统维护中'), Plug_Get_Configs_Value('sys', 'stop_agent_info'));
            exit;
        }

        //获取会话中的用户UID
        $USER_UID = Plug_Get_Session_Value('USER_UID');
        //根据用户UID查询用户信息
        $this->user_array = Plug_Query_Array("SELECT * FROM bs_php_user WHERE user_uid = '{$USER_UID}'");
        if (!$this->user_array) {
            Plug_Alert(Plug_Lang('你没有权限,请先登录。没有权限请授权使用.'));
            Plug_Location('index.php');
            exit;
        }

        //如果用户是代理,则提示没有权限,请先登录。
        if ($this->user_array['user_daili'] == 0) {
            Plug_Alert(Plug_Lang('你没有权限,请先登录。'));
            Plug_Location('index.php');
            exit;
        }

        //判断用户是否登录
        $login_log = Plug_User_Is_Login_Seesion();
        //如果用户未登录,则提示没有权限,请先登录。
        if ($login_log != 1047) {
            Plug_Alert(Plug_Lang('你没有权限,请先登录。'));
            Plug_Location('index.php');
            exit;
        }

        //判断用户等级
        if ($this->user_array['user_daili'] == 1) {
            $this->Grade = 1;
        } else if ($this->user_array['user_daili'] == 2) {
            $this->Grade = 2;
        } else {
            $this->Grade = 3;
        }

        //判断用户是否有权限使用批量查询功能
        Plug_Agent_Assert_Menu('batch_query', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('batch_query', $this->Grade, false);

        $jieguo = '';
        $baocun = Plug_Set_Post('soso_ok');
        if ($baocun) {
            $textarea = Plug_Set_Post('sosotxt');
            $arr = explode("\n", $textarea);

            $ka_txt = '';
            $ka_txt1 = '';
            $ka_txt2 = '';
            $ka_txt3 = '';
            $ka_txt4 = '';
            foreach ($arr as $v) {
                $v = trim($v);
                if ($v == '') break;

                $info = Plug_Query_One('bs_php_cardseries', 'car_name', $v, ' `car_admin`,`car_id`,`car_zhuangtai`,`car_IsLock`,`car_pur_date`,`car_cong_user` ');
                if (!$info) {
                    $ka_txt .= $v . Plug_Lang(" >>>激活码不存在") . "\n";
                    $ka_txt4 .= $v . "\n";
                } else {
                    $user_login = Plug_Query_One('bs_php_user', 'user_uid', $info['car_admin'], ' * ');
                    if (!$user_login) {
                        $info['car_admin'] = Plug_Lang('无法查阅制卡人') . ' UID:[' . $info['car_admin'] . Plug_Lang(']');
                    } else {
                        $info['car_admin'] = $user_login['user_user'];
                    }

                    if ($info['car_zhuangtai'] == 1) {
                        $ka_txt .= $v . Plug_Lang(" >>>您查询的授权码被冻结,制卡人：") . "{$info['car_admin']} \n";
                        $ka_txt3 .= $v . "\n";
                    } else {
                        if ($info['car_IsLock'] == 1) {
                            if ($info['car_cong_user'] == 'cardid') {
                                $bsphp_pattern_login = Plug_Query_One('bs_php_pattern_login', 'L_User_uid', $v, ' `L_id`, `L_vip_unix`');
                                $login_name = Plug_Lang('卡号');
                            } else {
                                $bsphp_pattern_login = Plug_Query_One('bs_php_pattern_login', 'L_ic_pwd', $v, ' `L_id`, `L_vip_unix`');
                                $login_name = $info['car_cong_user'];
                            }

                            $ka_txt .= $v . Plug_Lang(" >>>授权码已激活,制卡人：") . "{$info['car_admin']}  " . Plug_Lang("激活时间:") . "{$info['car_pur_date']} " . Plug_Lang("到期时间:") . date('Y-m-d H:i:s', $bsphp_pattern_login['L_vip_unix']) . Plug_Lang(" 充值账号:") . "$login_name \n\r";
                            $ka_txt2 .= $v . "\n";
                        } else {
                            $ka_txt .= $v . Plug_Lang(" >>>您查询的授权码未激活,制卡人：") . "{$info['car_admin']} \n";
                            $ka_txt1  .= $v . "\n";
                        }
                    }
                }

                $jieguo = "" .
                    Plug_Lang("-------------" . Plug_Lang("全部激活码") . "-------------") . PHP_EOL .
                    "$ka_txt" .
                    Plug_Lang("-------------" . Plug_Lang("全部未激活") . "-------------") . PHP_EOL .
                    "$ka_txt1" .
                    Plug_Lang("-------------" . Plug_Lang("全部已激活") . "-------------") . PHP_EOL .
                    "$ka_txt2" .
                    Plug_Lang("-------------" . Plug_Lang("全部已冻结") . "-------------") . PHP_EOL .
                    "$ka_txt3" .
                    Plug_Lang("-------------" . Plug_Lang("全部不存在") . "-------------") . PHP_EOL .
                    $ka_txt4;
            }
        }

        include Plug_Load_Default_Path();
    }
}
