<?php
/*
 * Feature: 我的代理列表
 * Menu ID: my_agent_list
 * 说明: 下级代理管理列表与 JSON 接口，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') die('Not,This File Not Can in Ie Modules');

class MyAgentListFeature
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
        //判断用户是否有权限使用我的代理列表功能
        Plug_Agent_Assert_Menu('my_agent_list', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('my_agent_list', $this->Grade, false);

        $Submit_class = Plug_Set_Post('Submit_class');
        $all = Plug_Set_Post('all');
        $select_class = Plug_Set_Post('select_class');
        if ($Submit_class) {
            if ($select_class == 2) {
                $txt = Plug_Set_Post('txt');
                $sql = "UPDATE  `bs_php_user` SET  `user_anget_beizhu` =  '{$txt}' WHERE  `bs_php_user`.`user_uid` ='{$all}' and `user_yao_User`='{$this->user_array['user_user']}';";
                if (Plug_Query($sql)) {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("备注修改成功")));
                } else {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("备注修改失败")));
                }
            } elseif ($select_class == 3) {
                $sql = "UPDATE  `bs_php_user` SET  `user_IsLock` =  '1' WHERE  `bs_php_user`.`user_uid` in ({$all}) and `user_yao_User`='{$this->user_array['user_user']}';";
                if (Plug_Query($sql)) {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("冻结成功")));
                } else {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("冻结失败")));
                }
            } elseif ($select_class == 4) {
                $sql = "UPDATE  `bs_php_user` SET  `user_IsLock` =  '0' WHERE  `bs_php_user`.`user_uid` in ({$all}) and `user_yao_User`='{$this->user_array['user_user']}';";
                if (Plug_Query($sql)) {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("解封成功")));
                } else {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("解封失败")));
                }
            } else {
                call_my_alert(Plug_Lang('你没有选择操作项目'));
            }
        }

        include Plug_Load_Default_Path();
    }

    function call_table_json()
    {
        Plug_Agent_Assert_Menu('my_agent_list', $this->Grade, true);

        $FANYE = (int)Plug_Set_Get('page');
        if ($FANYE > 0) {
            $db_ID = $FANYE - 1;
        } else {
            $db_ID = 0;
            $FANYE = 1;
        }
        $shu = Plug_Set_Get('limit');
        if ($shu == 0) $shu = 10;
        $db_ID = $db_ID * $shu;

        $soso = Plug_Set_Get('soso');
        $soso_id = (int)Plug_Set_Get('soso_id');
        $DESC_id = (int)Plug_Set_Get('DESC');
        $DESC_id == 1 ? $DESC = 'ASC' : $DESC = 'DESC';

        if ($soso_id == 2) {
            $soso_db_table = 'user_uid';
        } elseif ($soso_id == 3) {
            $soso_db_table = 'user_daili';
            $soso = '1';
        } elseif ($soso_id == 4) {
            $soso_db_table = 'user_Mobile';
        } elseif ($soso_id == 5) {
            $soso_db_table = 'user_Zhe';
        } elseif ($soso_id == 6) {
            $soso_db_table = 'user_yao_User';
        } elseif ($soso_id == 7) {
            $soso_db_table = 'user_IsLock';
            $soso = '1';
        } elseif ($soso_id == 8) {
            $soso_db_table = 'user_IsLock';
            $soso = '0';
        } elseif ($soso_id == 9) {
            $soso_db_table = 'user_qq';
        } elseif ($soso_id == 10) {
            $soso_db_table = 'user_email';
        } elseif ($soso_id == 11) {
            $soso_db_table = 'user_mibao_wenti';
        } elseif ($soso_id == 12) {
            $soso_db_table = 'user_mibao_daan';
        } elseif ($soso_id == 13) {
            $soso_db_table = 'user_Login_ip';
        } elseif ($soso_id == 14) {
            $soso_db_table = 'user_re_ip';
        } elseif ($soso_id == 15) {
            $soso_db_table = 'user_rmb';
        } elseif ($soso_id == 16) {
            $soso_db_table = 'user_LoGinNum';
        } elseif ($soso_id == 17) {
            $soso_db_table = 'user_jifen';
        } elseif ($soso_id == 18) {
            $soso_db_table = 'user_anget_beizhu';
        } else {
            $soso_db_table = 'user_user';
        }

        if ($soso_id == 15 || $soso_id == 16 || $soso_id == 17) {
            $sql = "SELECT*FROM`bs_php_user`WHERE `user_yao_User`='{$this->user_array['user_uid']}' and user_daili > 0 AND `{$soso_db_table}`>='{$soso}' ORDER BY`user_uid`{$DESC} LIMIT {$db_ID},{$shu} ;";
            $sql_rows = "SELECT count(*)as'hangshu'FROM`bs_php_user`WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND user_daili > 0 AND `{$soso_db_table}`>='{$soso}' ORDER BY`user_uid`{$DESC} ;";
        } else {
            $sql = "SELECT*FROM`bs_php_user`WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND user_daili > 0 AND `{$soso_db_table}`LIKE '%{$soso}%'  ORDER BY`user_uid`{$DESC} LIMIT {$db_ID},{$shu} ";
            $sql_rows = "SELECT   count(*)as'hangshu' FROM`bs_php_user`WHERE `user_yao_User`='{$this->user_array['user_uid']}' AND user_daili > 0 AND `{$soso_db_table}`LIKE '%{$soso}%'  ORDER BY`user_uid`{$DESC} ;";
        }

        $db_array_value = Plug_Query($sql);
        $my_rows_array = Plug_Query_Array($sql_rows);
        $zongshu = $my_rows_array['hangshu'];

        $while_array_list_all = array();
        $array_s = array('0', Plug_Lang('一'), Plug_Lang('二'), Plug_Lang('三'), Plug_Lang('四'));
        while ($value = Plug_Pdo_Fetch_Assoc($db_array_value)) {
            $zhuangtai = $value['user_IsLock'];
            if ($zhuangtai == 1) {
                $test = Plug_Lang('冻结');
            } elseif ($zhuangtai == -2) {
                $test = Plug_Lang('等待管理审核');
            } elseif ($zhuangtai == -3) {
                $test = Plug_Lang('等待邮箱验证');
            } else {
                $test = Plug_Lang('正常');
            }

            $zaix = Plug_Show_Time_Day(date('Y-m-d H:i:s', $value['user_CaoShi']));
            if ($value['user_CaoShi'] == 0) $zaix = Plug_Lang('没记录');
            $value['user_re_date'] = Plug_Show_Time_Day($value['user_re_date']);
            if ($value['user_yao_User'] == 0)  $value['user_yao_User'] = '';
            if ($value['user_yao_Shu'] == 0)  $value['user_yao_Shu'] = '';
            if ($value['user_Zhe'] == 0)  $value['user_Zhe'] = '--';

            if ($value['user_daili'] == 0) {
                $value['user_daili'] = Plug_Lang('普通用户');
            } else {
                $value['user_daili'] = $array_s[$value['user_daili']] . Plug_Lang('级代理商');
            }

            $sql = "select count(*)as'hangshu' from`bs_php_cardseries`WHERE  `car_admin`='{$value['user_uid']}'";
            $tmp_arr = Plug_Query_Array($sql);
            $xianka = (int)$tmp_arr['hangshu'];

            $sql = "select SUM(`kuka_val`)as'hangshu' from`bs_php_kuka`WHERE  `kuka_uid`='{$value['user_uid']}'";
            $tmp_arr = Plug_Query_Array($sql);
            $kuka = (int)$tmp_arr['hangshu'];

            $while_array_list = array();
            $while_array_list['key'] = $value['user_uid'];
            $while_array_list['uid'] = $value['user_uid'];
            $while_array_list['user'] = $value['user_user'];
            $while_array_list['daili'] = $value['user_daili'];
            $while_array_list['test'] = $test;
            $while_array_list['LoGinNum'] = $value['user_LoGinNum'];
            $while_array_list['rmb'] = $value['user_rmb'];
            $while_array_list['re_date'] = $value['user_re_date'];
            $while_array_list['zhhd'] = $zaix;
            $while_array_list['yao_User'] = $value['user_yao_User'];
            $while_array_list['Zhe'] = $value['user_Zhe'];
            $while_array_list['agent_beizhu'] = $value['user_anget_beizhu'];
            $while_array_list['xianka'] = $xianka;
            $while_array_list['kuka'] = $kuka;
            $while_array_list_all[] = $while_array_list;
        }

        $json_array = array();
        $json_array['data'] = (array)$while_array_list_all;
        $json_array['code'] = 0;
        $json_array['msg'] = '';
        $json_array['count'] = $zongshu;
        Plug_Print_Json($json_array);
    }
}
