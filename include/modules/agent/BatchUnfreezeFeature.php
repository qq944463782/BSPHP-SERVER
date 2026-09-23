<?php
/*
 * Feature: 批量解冻
 * Menu ID: batch_unfreeze
 * 说明: 批量解冻充值卡入口页，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT')
    die('Not,This File Not Can in Ie Modules');

class BatchUnfreezeFeature
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
        $this->Grade = Plug_Agent_Detect_Grade($this->user_array);
        //判断用户是否有权限使用批量解冻功能
        Plug_Agent_Assert_Menu('batch_unfreeze', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('batch_unfreeze', $this->Grade, false);

        $jieguo = '';
        $baocun = Plug_Set_Post('soso_ok');
        if ($baocun) {
            $textarea = Plug_Set_Post('sosotxt');
            $arr = explode("\n", $textarea);

            $ka_txt = '';
            $ka_txt1 = '';
            $ka_txt4 = '';
            foreach ($arr as $v) {
                $v = trim($v);
                if ($v == '') break;

                $BS_val_IN = Plug_get_agent_info_in($this->user_array['user_user']);
                $ids = $v;

                if (Plug_Get_Configs_Value('agents', "car_sdate_no_{$this->Grade}") == 1) {
                    $sql = "SELECT *  FROM  `bs_php_cardseries`  WHERE  `car_name` = '{$ids}' AND `car_admin`in({$BS_val_IN});";
                    $array = Plug_Query_Array($sql);
                    if (!$array) {
                        $ka_txt .= $v . Plug_Lang(" >>>激活码不存在") . "\n";
                        $ka_txt4 .= $v . "\n";
                        continue;
                    }

                    $sql = "UPDATE  `bs_php_cardseries` SET  `car_zhuangtai` =  '0' WHERE  `bs_php_cardseries`.`car_id` ='{$array['car_id']}' AND `car_admin`='{$this->user_array['user_uid']}';";
                    Plug_Query($sql);

                    if (Plug_Get_Configs_Value('agents', "car_on_{$this->Grade}") == 1) {
                        if ($array['car_cong_user'] == 'cardid') {
                            $sql = "UPDATE  `bs_php_pattern_login` SET   `L_IsLock` =  '0' WHERE `L_daihao`='{$array['car_DaiHao']}' AND   `L_User_uid` ='{$array['car_name']}';";
                            Plug_Query($sql);
                        } else {
                            $sql = "UPDATE  `bs_php_pattern_login` SET   `L_IsLock` =  '0' WHERE `L_daihao`='{$array['car_DaiHao']}' AND `L_User_uid` ='{$array['car_chong_uid']}' AND `L_ic_pwd` ='{$array['car_chong_uid']}';";
                            Plug_Query($sql);
                        }
                    }

                    $ka_txt .= $v . Plug_Lang(" >>>解结成功") . "\n";
                    $ka_txt1 .= $v . "\n";
                    continue;
                } else {
                    $ka_txt .= $v . Plug_Lang(" >>>没有权限解冻\n");
                    continue;
                }
            }

            $jieguo = "" .
                Plug_Lang("-------------" . Plug_Lang("全部激活码") . "-------------") . PHP_EOL .
                "$ka_txt" .
                Plug_Lang("-------------" . Plug_Lang("解结成功") . "-------------") . PHP_EOL .
                "$ka_txt1" .
                Plug_Lang("-------------" . Plug_Lang("激活码不存在") . "-------------") . PHP_EOL .
                "$ka_txt4";
        }
        include Plug_Load_Default_Path();
    }
}
