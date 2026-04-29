<?php
/*
 * Feature: 余额制卡
 * Menu ID: make_card_balance
 * 说明: 余额购卡入口页，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') die('Not,This File Not Can in Ie Modules');

class MakeCardBalanceFeature
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
        $user_UID = Plug_Get_Session_Value('USER_UID');
        //根据用户UID查询用户信息
        $this->user_array = Plug_Query_Array("SELECT * FROM bs_php_user WHERE user_uid = '{$user_UID}'");
        if (!$this->user_array) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。没有权限请授权使用.'), 'index.php?m=agent');
            Plug_Location('index.php?m=agent');
            exit;
        }

        //如果用户是代理,则提示没有权限,请先登录。
        if ($this->user_array['user_daili'] == 0) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。c'), 'index.php?m=agent');
            Plug_Location('index.php');
            exit;
        }

        //判断用户是否登录
        $login_log = Plug_User_Is_Login_Seesion();
        //如果用户未登录,则提示没有权限,请先登录。
        if ($login_log != 1047) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录a。'), 'index.php?m=agent');
            Plug_Location('index.php');
            exit;
        }

        //判断用户是否授权
        if (Plug_Get_Session_Value('USER_UID_IS') == 0) {
            Plug_ShowMsg(Plug_Lang("代理中心未授权,请授权在使用b."), '');
            Plug_Set_Session_Value('USER_UID', 'Not');
            exit;
        }

        //判断用户等级
        $this->Grade = Plug_Agent_Detect_Grade($this->user_array);
        //判断用户是否有权限使用余额制卡功能
        Plug_Agent_Assert_Menu('make_card_balance', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('make_card_balance', $this->Grade, false);

        $app_name = Plug_GetAppInfoNameArray();
        $Submit = Plug_Set_Post('appenconfig');
        $select = Plug_Set_Post('select');
        $shu = Plug_Set_Post('shu');
        $beizhu = Plug_Set_Post('beizhu');
        $make_mode = Plug_Set_Post('make_mode');
        if ($make_mode != 'stock') {
            $make_mode = 'direct';
        }
        if ($Submit) {
            $bin_time = Plug_Get_Session_Value('bin_time');
            $ok = time() - $bin_time;
            if ($ok < 5) {
                Plug_Set_Session_Value('bin_time', time());
                Plug_Add_AppenLog('od_po_log', Plug_Lang("用户频繁制卡异常:你制卡太频繁,请10秒后再试!"), $this->user_array['user_user']);
                Plug_Print_Json(array("code" => -11, 'msg' => Plug_Lang("你制卡太频繁,请10秒后再试!")));
            }

            if ($shu <= 0) Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请输入制作的数量。!")));
            $make_card_mun = (int)Plug_Get_Configs_Value('agents', 'make_card_mun');
            if ($make_card_mun == 0) $make_card_mun = 100;
            if ($shu > $make_card_mun) Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("超出范围,每次制卡最大数量") . " {$make_card_mun} 张!"));
            if ($select == 0) Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请选择你要制作的软件的充值卡类型!")));

            $leixing_array = Plug_Query_One('bs_php_kalei', 'lei_id', $select, ' * ');
            if ((int)$leixing_array['lei_daili'] == -1) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("代理价格-1,不能制卡哦!")));
            }

            $jiage = $leixing_array['lei_daili'];
            $uesr_zhe = $this->user_array['user_Zhe'];
            $zheinfo = null;
            if ($uesr_zhe > 0) {
                $jiage = $jiage / 100 * $uesr_zhe * 10;
                $zheinfo = $uesr_zhe . Plug_Lang("折后,");
            }
            $zong = $jiage * $shu;
            $cha = $this->user_array['user_rmb'] - $zong;
            if ($zong > $this->user_array['user_rmb']) {
                Plug_Print_Json(array('code' => '1', 'msg' => "{$zheinfo}" . Plug_Lang("你当前价格还不够制作") . "{$shu}" . Plug_Lang("张卡,还差") . "{$cha}" . Plug_Lang("元!")));
                exit;
            }

            Plug_Set_Session_Value('bin_time', time());
            Plug_Load_Modules_Common('applib', 'makecard');
            $zhi_date = Plug_ZhiZuoC($shu, $select, $this->user_array['user_uid'], '', -10, '', $beizhu);
            Plug_Add_AppenLog('agent_ka_log', "UID:{$this->user_array['user_uid']}," . Plug_Lang("制作数量") . ":{$shu}," . Plug_Lang("金额") . ":{$zong}," . Plug_Lang("购卡折扣") . ":{$uesr_zhe}," . Plug_Lang("制作时间") . ":{$zhi_date}", $this->user_array['user_user']);

            $rmb_before = (float)$this->user_array['user_rmb'];
            $rmb_after = max(0, $rmb_before - $zong);
            $sql = "UPDATE`bs_php_user`SET`user_rmb`=`user_rmb`-'{$zong}'WHERE`bs_php_user`.`user_uid`='{$this->user_array['user_uid']}';";
            $tmp = Plug_Query($sql);
            if (!$tmp) $tmp = Plug_Query($sql);
            if ($tmp) {
                Plug_Add_Rmb_Log($this->user_array['user_uid'], $rmb_before, $rmb_after, Plug_Lang('代理制卡扣款'));
            }

            if ($make_mode == 'stock') {
                $addid = "{$this->user_array['user_uid']}_{$leixing_array['lei_daihao']}_{$leixing_array['lei_id']}";
                $sql = "SELECT * FROM `bs_php_kuka` WHERE `kuka_biaoji`='{$addid}'";
                $keka_array = Plug_Query_Array($sql);
                if (!$keka_array) {
                    $sql = "INSERT INTO `bs_php_kuka` (`kuka_id`, `kuka_uid`, `kuka_daihao`, `kuka_kalei`, `kuka_biaoji`, `kuka_val`, `kuka_user`) VALUES (NULL, '{$this->user_array['user_uid']}', '{$leixing_array['lei_daihao']}', '{$leixing_array['lei_id']}', '{$addid}', '0', '{$this->user_array['user_user']}');";
                    Plug_Query($sql);
                    $sql = "SELECT * FROM `bs_php_kuka` WHERE `kuka_biaoji`='{$addid}'";
                    $keka_array = Plug_Query_Array($sql);
                }
                if ($keka_array) {
                    $sql = "UPDATE `bs_php_kuka` SET `kuka_val`=`kuka_val`+'{$shu}' WHERE `kuka_id`='{$keka_array['kuka_id']}';";
                    Plug_Query($sql);
                    Plug_Add_AppenLog('agent_ka_log', Plug_Lang("代理制卡入库成功") . ",{$app_name[$leixing_array['lei_daihao']]}-{$leixing_array['lei_name']}," . Plug_Lang("数量") . ":{$shu}", $this->user_array['user_user']);
                }
                Plug_Print_Json(array('code' => 8, 'msg' => Plug_Lang("制卡成功,已存到库存卡!"), 'url' => 'index.php?m=agent&c=kuka&a=kuka_add'));
            }

            Plug_Print_Json(array('code' => 8, 'msg' => Plug_Lang("制卡成功!"), 'url' => 'index.php?m=agent&c=sp&a=show&date=' . $zhi_date . '&id=' . $select));
        }

        $sql = "SELECT `bs_php_kalei`.* FROM `bs_php_kalei`,`bs_php_appinfo` WHERE `lei_daili`> -1 and `bs_php_appinfo`.`app_daihao`=`bs_php_kalei`.`lei_daihao`   ORDER BY `lei_sort` ASC,`lei_ktzf` ASC";
        $tmp = Plug_Query($sql);
        include Plug_Load_Default_Path();
    }
}
