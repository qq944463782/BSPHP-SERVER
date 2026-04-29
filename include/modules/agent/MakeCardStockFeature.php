<?php
/*
 * Feature: 库存制卡
 * Menu ID: make_card_stock
 * 说明: 库卡库存制卡入口页，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') die('Not,This File Not Can in Ie Modules');

class MakeCardStockFeature
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
        //判断用户是否有权限使用库存制卡功能
        Plug_Agent_Assert_Menu('make_card_stock', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('make_card_stock', $this->Grade, false);

        $app_name = Plug_GetAppInfoNameArray();
        $select = Plug_Set_Post('select');
        $shu = Plug_Set_Post('shu');
        $beizhu = Plug_Set_Post('beizhu');
        $Submit = Plug_Set_Post('appenconfig');
        if ($Submit) {
            $bin_time = Plug_Get_Session_Value('bin_time');
            $ok = time() - $bin_time;
            if ($ok < 5) {
                Plug_Set_Session_Value('bin_time', time());
                Plug_Add_AppenLog('od_po_log', Plug_Lang("用户频繁制卡异常:你制卡太频繁,请10秒后再试!"), $this->user_array['user_user']);
                Plug_Print_Json(array("code" => -11, 'msg' => Plug_Lang("你制卡太频繁,请10秒后再试!")));
            }

            if ($shu <= 0) Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请输入制作的数量!")));
            if ($shu > 100) Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("超出范围,每次制卡最大数量100张!")));
            if ($select == 0) Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请选择你要制作的软件的充值卡类型!")));

            $kuka_array = Plug_Query_One('bs_php_kuka', 'kuka_id', $select, ' * ');
            if ($kuka_array['kuka_uid'] != $this->user_array['user_uid']) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请不要恶意串权!")));
            }
            if ($kuka_array['kuka_val'] <= 0) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("当前剩余卡已经为0!")));
            }
            if ($kuka_array['kuka_val'] < $shu) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("当前卡类库存不足已制作你需要的量!")));
            }

            Plug_Set_Session_Value('bin_time', time());
            Plug_Load_Modules_Common('applib', 'makecard');
            $zhi_date = Plug_ZhiZuoC($shu, $kuka_array['kuka_kalei'], $this->user_array['user_uid'], '', -10, '', $beizhu);
            Plug_Add_AppenLog('agent_ka_log', "UID:{$this->user_array['user_uid']}," . Plug_Lang("库存制作数量") . ":$shu," . Plug_Lang("制作时间") . ":$zhi_date", $this->user_array['user_user']);
            $sql = "UPDATE`bs_php_kuka`SET `kuka_val`=`kuka_val`-'{$shu}' WHERE  `bs_php_kuka`.`kuka_id`='{$kuka_array['kuka_id']}';";
            Plug_Query($sql);
            Plug_Print_Json(array('code' => 8, 'msg' => Plug_Lang("库卡制作成功!"), 'url' => 'index.php?m=agent&c=sp&a=show&date=' . $zhi_date . '&id=' . $select));
        }

        $sql = "SELECT*FROM`bs_php_kalei` ";
        $dbs_array_value = Plug_Query($sql);
        $class_array[0] = Plug_Lang('类型已经删除');
        if ($dbs_array_value) {
            while ($array_value = Plug_Pdo_Fetch_Assoc($dbs_array_value)) {
                $class_array[$array_value["lei_id"]] = $array_value["lei_name"];
            }
        }
        $sql = "SELECT `kuka_id`,`app_name`,`kuka_val`,`kuka_kalei` FROM `bs_php_kuka`,`bs_php_appinfo` WHERE  `bs_php_appinfo`.`app_daihao` = `bs_php_kuka`.`kuka_daihao`  AND `kuka_uid` = '{$this->user_array['user_uid']}' ";
        $tmp = Plug_Query($sql);

        include Plug_Load_Default_Path();
    }
}
