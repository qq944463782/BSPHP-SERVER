<?php
/*
 * Feature: 卡管理
 * Menu ID: card_manage
 * 说明: 卡列表页、批量操作与 JSON 数据接口，统一执行菜单权限校验。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') die('Not,This File Not Can in Ie Modules');

class CardManageFeature
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
        //判断用户是否有权限使用卡管理功能

        //判断用户是否有权限使用卡管理功能
        Plug_Agent_Assert_Menu('card_manage', $this->Grade, false);
    }

    function call_table()
    {
        Plug_Agent_Assert_Menu('card_manage', $this->Grade, false);

        $get_agent_appinfo_array = Plug_Get_Agent_Appinfo_Array($this->user_array['user_uid']);
        $sql = "SELECT  `app_daihao` ,  `app_name` ,  `app_MoShi` FROM  `bs_php_appinfo` WHERE `bs_php_appinfo`.`app_daihao` {$get_agent_appinfo_array}  LIMIT 0 , 30";
        $db_array_value_app = Plug_Query($sql);

        $act = Plug_Set_Get('act');
        $daihao = Plug_Set_Get('daihao');
        $app_name = Plug_GetAppInfoNameArray();

        $Submit_class = Plug_Set_Post('Submit_class');
        $all = Plug_Set_Post('all');
        $ids = $all;
        $select_class = Plug_Set_Post('select_class');
        if ($Submit_class) {
            if ($select_class == 1) {
                if (Plug_Get_Configs_Value('agents', "car_sdate_{$this->Grade}") == 1) {
                    $BS_val_IN = Plug_get_agent_info_in($this->user_array['user_user']);
                    $sql = "SELECT *  FROM  `bs_php_cardseries`  WHERE  `car_id` = {$ids} AND `car_admin`in({$BS_val_IN});";
                    $array = Plug_Query_Array($sql);
                    if (!$array) Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("不存在")));

                    if ($array['car_IsLock'] == 1) {
                        $car_pur_date = strtotime($array['car_pur_date']);
                        $car_on_time = Plug_Get_Configs_Value('agents', "car_on_time_{$this->Grade}");
                        $car_pur_date = HOST_UNIX - $car_pur_date;
                        if ($car_pur_date > $car_on_time) {
                            Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("激活时间超") . $car_on_time . Plug_Lang('秒,无法冻结')));
                        }
                    }

                    if (Plug_Get_Configs_Value('agents', "car_off_{$this->Grade}") == 0) {
                        Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("未激活使用的卡不能冻结!")));
                    }

                    $sql = "UPDATE  `bs_php_cardseries` SET  `car_zhuangtai` =  '1' WHERE  `bs_php_cardseries`.`car_id` = {$array['car_id']} AND `car_admin`IN({$BS_val_IN});";
                    Plug_Query($sql);

                    if (Plug_Get_Configs_Value('agents', "car_on_{$this->Grade}") == 1) {
                        if ($array['car_cong_user'] == 'cardid') {
                            $sql = "UPDATE  `bs_php_pattern_login` SET   `L_IsLock` =  '1' WHERE `L_daihao`='{$array['car_DaiHao']}' AND(`L_User_uid` ='{$array['car_name']}' OR `L_ic_pwd`='{$array['car_name']}');";
                            Plug_Query($sql);
                        } else {
                            $sql = "UPDATE  `bs_php_pattern_login` SET   `L_IsLock` =  '1' WHERE `L_daihao`='{$array['car_DaiHao']}' AND `L_User_uid` ='{$array['car_chong_uid']}' ;";
                            Plug_Query($sql);
                        }
                    }

                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("冻结成功!")));
                } else {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("你没有权限冻结!")));
                }
            } elseif ($select_class == 2) {
                if (Plug_Get_Configs_Value('agents', "car_sdate_no_{$this->Grade}") == 1) {
                    $BS_val_IN = Plug_get_agent_info_in($this->user_array['user_user']);
                    $sql = "SELECT *  FROM  `bs_php_cardseries`  WHERE  `car_id` = {$ids} AND `car_admin`in({$BS_val_IN});";
                    $array = Plug_Query_Array($sql);
                    if (!$array) Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("选择卡不存在!")));

                    $sql = "UPDATE  `bs_php_cardseries` SET  `car_zhuangtai` =  '0' WHERE  `bs_php_cardseries`.`car_id` ='{$array['car_id']}' AND `car_admin`IN({$BS_val_IN});";
                    Plug_Query($sql);
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("解结成功!")));
                } else {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("没有权限解冻!")));
                }
            } elseif ($select_class == 3) {
                if (Plug_Get_Configs_Value('agents', "pay_chong_{$this->Grade}") == 1 or Plug_Get_Configs_Value('agents', "car_delete_{$this->Grade}") == 1) {
                    $BS_val_IN = Plug_get_agent_info_in($this->user_array['user_user']);
                    $sql = "SELECT *  FROM  `bs_php_cardseries`  WHERE  `car_id` = {$ids} AND `car_admin`IN({$BS_val_IN});";
                    $array = Plug_Query_Array($sql);
                    if (!$array) Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("不存在!")));

                    if ($array['car_IsLock'] == 1) {
                        if (Plug_Get_Configs_Value('agents', "pay_chong_{$this->Grade}") == 0) {
                            Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("删除失败，已经激活没有权限!")));
                        }
                        $car_pur_date = strtotime($array['car_pur_date']);
                        $car_on_time = Plug_Get_Configs_Value('agents', "car_delete_time_{$this->Grade}");
                        $car_pur_date = HOST_UNIX - $car_pur_date;
                        if ($car_pur_date > $car_on_time) {
                            Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("激活时间超") . $car_on_time . Plug_Lang('秒,无法删除')));
                        }
                    } else {
                        if (Plug_Get_Configs_Value('agents', "car_delete_{$this->Grade}") == 0) {
                            Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("删除失败，未激活没有权限!")));
                        }
                    }

                    $sql = "DELETE FROM `bs_php_cardseries`  WHERE  `bs_php_cardseries`.`car_id` = {$array['car_id']} AND `car_admin`in({$BS_val_IN});";
                    Plug_Query($sql);
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("删除已经执行!")));
                } else {
                    Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("没有权限删除!")));
                }
            } elseif ($select_class == 12) {
                $txt = Plug_Set_Post('txt');
                $sql = "UPDATE `bs_php_cardseries` SET  `car_agnet_beizhu` =  '{$txt}' WHERE  `car_id` = '{$all}' AND `car_admin` =  '{$this->user_array['user_uid']}';";
                Plug_Query($sql);
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("备注设置成功!")));
            } else {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("你没有选择操作项目!")));
            }
        }

        $sql = "SELECT  `lei_id` ,  `lei_name` ,  `lei_daihao` FROM  `bs_php_kalei` WHERE `lei_daihao`{$get_agent_appinfo_array} ";
        $db_array_value_lei = Plug_Query($sql);

        include Plug_Load_Default_Path();
    }

    function call_show()
    {
        Plug_Agent_Assert_Menu('card_manage', $this->Grade, false);

        $date = Plug_Set_Get('date');
        $param_sql = "SELECT*FROM`bs_php_cardseries`WHERE`car_reDATE`='{$date}'AND`car_admin`='{$this->user_array['user_uid']}'";
        $param_db_array_value = Plug_Query($param_sql);
        $tset = '';
        if ($param_db_array_value) {
            while ($param_array_value = Plug_Pdo_Fetch_Assoc($param_db_array_value)) {
                if ($param_array_value['car_pwd'] == '') {
                    $tset .= $param_array_value['car_name'] . "\n";
                } else {
                    $tset .= Plug_Lang('卡:', 'card') . $param_array_value['car_name'] . Plug_Lang('  密:', 'card') . $param_array_value['car_pwd'] . Plug_Lang('  时间', 'carrd') . $param_array_value['car_TianShu'] . Plug_Lang('天', 'card') . "\n";
                }
            }
        }

        include Plug_Load_Default_Path();
    }

    function call_table_json()
    {
        Plug_Agent_Assert_Menu('card_manage', $this->Grade, true);

        $carsys_arr = Plug_Load_Langs_Array('applib', 'admin_card');
        $daihao = Plug_Set_Get('daihao');
        $BS_val_kalei = Plug_Set_Get('kalei');
        $zhuangtai = Plug_Set_Get('zhuangtai');
        $on = Plug_Set_Get('on');
        $date_type = Plug_Set_Get('date_type');
        $date1 = Plug_Set_Get('date1');
        $date2 = Plug_Set_Get('date2');

        $zhuangtai_sql = '';
        if ($zhuangtai == 1) $zhuangtai_sql = " AND `car_zhuangtai`='0'  ";
        if ($zhuangtai == 2) $zhuangtai_sql = " AND  `car_zhuangtai`='1'  ";

        $BS_val_kalei_sql = '';
        if ($BS_val_kalei > 0) $BS_val_kalei_sql = " AND `car_Lei`='$BS_val_kalei'  ";

        $on_sql = '';
        if ($on == 1) $on_sql = " AND `car_IsLock`='1'  ";
        if ($on == 2) $on_sql = " AND `car_IsLock`='0'  ";

        if ($date_type == 1) {
            $date1_sql = ($date1 != '') ? "AND `car_reDATE` > '{$date1} 00:00:00' " : '';
            $date2_sql = ($date2 != '') ? " AND `car_reDATE` < '{$date2} 23:59:59' " : '';
        } elseif ($date_type == -1) {
            $date1_sql = '';
            $date2_sql = '';
        } else {
            $date1_sql = ($date1 != '') ? "AND `car_pur_date` > '{$date1} 00:00:00' " : '';
            $date2_sql = ($date2 != '') ? " AND `car_pur_date` < '{$date2} 23:59:59' " : '';
        }

        $FANYE = (int)Plug_Set_Get('page');
        if ($FANYE > 0) {
            $db_ID = $FANYE - 1;
        } else {
            $db_ID = 0;
        }
        $shu = (int)Plug_Set_Get('limit');
        if ($shu == 0) $shu = 10;
        $db_ID = $db_ID * $shu;

        $soso = Plug_Set_Get('soso');
        $soso_id = Plug_Set_Get('soso_id');
        $DESC_id = (int)Plug_Set_Get('DESC');
        $DESC_id == 1 ? $DESC = 'ASC' : $DESC = 'DESC';

        if ($soso_id == 2) {
            $soso_db_table = 'car_agnet_beizhu';
        } elseif ($soso_id == 3) {
            $soso_db_table = 'car_cong_user';
        } elseif ($soso_id == 4) {
            $soso_db_table = 'car_reDATE';
        } elseif ($soso_id == 5) {
            $BS_val_agent_ok = 0;
            $i = 0;
            if ($soso == '') $soso = $this->user_array['user_user'];
            if ($soso == $this->user_array['user_user']) {
                $BS_val_agent_ok = 1;
            } else {
                $BS_val_agent_array = Plug_Query_One('bs_php_user', 'user_user', $soso, ' `user_uid`,`user_user`,`user_IsLock`,`user_yao_User` ');
                while ($i < 100) {
                    $i++;
                    if (!$BS_val_agent_array) break;
                    if ($BS_val_agent_array['user_yao_User'] == $this->user_array['user_user'] or $BS_val_agent_array['user_user'] == $this->user_array['user_user']) {
                        $BS_val_agent_ok = 1;
                        break;
                    }
                    $BS_val_agent_array = Plug_Query_One('bs_php_user', 'user_user', $BS_val_agent_array['user_yao_User'], ' `user_uid`,`user_user`,`user_IsLock`,`user_yao_User` ');
                }
            }
            if ($BS_val_agent_ok == 0) {
                echo 'cuowu';
                exit;
            }
            $user_user = Plug_Query_Array("SELECT `user_uid`,`user_user` FROM  `bs_php_user` WHERE  `user_user` = '{$soso}' LIMIT 1");
            if ($user_user) $soso = $user_user['user_uid'];
            $soso_db_table = 'car_admin';
        } elseif ($soso_id == 6) {
            $BS_val_agent_ok = 0;
            $i = 0;
            if ($soso == '') $soso = $this->user_array['user_user'];
            if ($soso == $this->user_array['user_user']) {
                $BS_val_agent_ok = 1;
            } else {
                $BS_val_agent_array = Plug_Query_One('bs_php_user', 'user_user', $soso, ' `user_uid`,`user_user`,`user_IsLock`,`user_yao_User` ');
                while ($i < 100) {
                    $i++;
                    if (!$BS_val_agent_array) break;
                    if ($BS_val_agent_array['user_yao_User'] == $this->user_array['user_user'] or $BS_val_agent_array['user_user'] == $this->user_array['user_user']) {
                        $BS_val_agent_ok = 1;
                        break;
                    }
                    $BS_val_agent_array = Plug_Query_One('bs_php_user', 'user_user', $BS_val_agent_array['user_yao_User'], ' `user_uid`,`user_user`,`user_IsLock`,`user_yao_User` ');
                }
            }
            if ($BS_val_agent_ok == 0) {
                echo 'cuowu';
                exit;
            }
            $int = Plug_get_agent_info_in($soso);
            $soso_db_table = 'car_reDATE';
        } else {
            $soso_db_table = 'car_name';
        }

        $daihao_sql = "";
        if ($daihao > 0) $daihao_sql = " `car_DaiHao`='$daihao' AND ";

        if ($soso_id == 6) {
            $sql = "SELECT*FROM`bs_php_cardseries`WHERE {$daihao_sql} `car_admin`in({$int})   {$date1_sql} {$date2_sql} {$zhuangtai_sql} {$on_sql} {$BS_val_kalei_sql} ORDER BY`car_id` {$DESC} LIMIT {$db_ID},{$shu} ";
            $db_array_value = Plug_Query($sql);
            $sql = "select count(*)as'hangshu'from`bs_php_cardseries`WHERE {$daihao_sql} `car_admin`in({$int})    {$date1_sql} {$date2_sql} {$zhuangtai_sql} {$on_sql} {$BS_val_kalei_sql} ";
            $tmp_arr = Plug_Query_Array($sql);
            $zongshu = (int)$tmp_arr['hangshu'];
        } else if ($soso_id == 4) {
            $sql = "SELECT*FROM`bs_php_cardseries`WHERE {$daihao_sql} `car_admin`='{$this->user_array['user_uid']}'AND`{$soso_db_table}`LIKE '{$soso}'  {$date1_sql} {$date2_sql} {$zhuangtai_sql} {$on_sql} {$BS_val_kalei_sql} ORDER BY`car_id` {$DESC} LIMIT {$db_ID},{$shu} ";
            $db_array_value = Plug_Query($sql);
            $sql = "select count(*)as'hangshu'from`bs_php_cardseries`WHERE {$daihao_sql} `car_admin`='{$this->user_array['user_uid']}' AND`{$soso_db_table}` LIKE '{$soso}'   {$date1_sql} {$date2_sql} {$zhuangtai_sql} {$on_sql} {$BS_val_kalei_sql} ";
            $tmp_arr = Plug_Query_Array($sql);
            $zongshu = (int)$tmp_arr['hangshu'];
        } else {
            $sql = "SELECT*FROM`bs_php_cardseries`WHERE {$daihao_sql} `car_admin`='{$this->user_array['user_uid']}'AND`{$soso_db_table}`LIKE '%{$soso}%'  {$date1_sql} {$date2_sql} {$zhuangtai_sql} {$on_sql} {$BS_val_kalei_sql} ORDER BY`car_id` {$DESC} LIMIT {$db_ID},{$shu} ";
            $db_array_value = Plug_Query($sql);
            $sql = "select count(*)as'hangshu'from`bs_php_cardseries`WHERE {$daihao_sql} `car_admin`='{$this->user_array['user_uid']}' AND`{$soso_db_table}`LIKE '%{$soso}%'   {$date1_sql} {$date2_sql} {$zhuangtai_sql} {$on_sql} {$BS_val_kalei_sql} ";
            $tmp_arr = Plug_Query_Array($sql);
            $zongshu = (int)$tmp_arr['hangshu'];
        }

        $sql = "SELECT*FROM`bs_php_appinfo`";
        $dbs_array_value = Plug_Query($sql);
        $app_array = array();
        $app_array[0] = Plug_Lang('未分组');
        if ($dbs_array_value) {
            while ($array_value = Plug_Pdo_Fetch_Assoc($dbs_array_value)) {
                $app_array[$array_value['app_daihao']] = $array_value['app_name'];
            }
        }

        $sql = "SELECT*FROM`bs_php_kalei`";
        $dbs_array_value = Plug_Query($sql);
        $class_array = array();
        $class_array[0] = Plug_Lang('未分组');
        if ($dbs_array_value) {
            while ($array_value = Plug_Pdo_Fetch_Assoc($dbs_array_value)) {
                $class_array[$array_value['lei_id']] = $array_value['lei_name'];
            }
        }

        $while_array_list_all = array();
        $users = array();
        while ($array_value = Plug_Pdo_Fetch_Assoc($db_array_value)) {
            $zhuangtai = $array_value['car_IsLock'];
            $zhuangtai == 1 ? $test = '<span  style="color: #FF9900">' . Plug_Lang('已使用') . '</span>' : $test = Plug_Lang('未使用');

            if ($array_value['car_pur_date'] == '0000-00-00 00:00:00' or  $array_value['car_pur_date'] == '1000-12-31 00:00:00') {
                $array_value['car_pur_date'] = '--';
            }

            $array_value['car_zhuangtai'] == 1 ? $array_value['car_zhuangtai'] = '<span  style="color: #FF9900">' . Plug_Lang('冻结') . '</span>' : $array_value['car_zhuangtai'] = Plug_Lang('正常');
            (int)$array_value['car_chong_uid'] != 0 ? $array_value['car_chong_uid'] = '(uid:' . $array_value['car_chong_uid'] . ')' : $array_value['car_chong_uid'] = '';

            if ($array_value['car_admin'] > 0) {
                if (!isset($users[$array_value['car_admin']])) {
                    $sql = "SELECT `user_uid`,`user_user` FROM  `bs_php_user` WHERE  `user_uid` = '{$array_value['car_admin']}' LIMIT 1";
                    $user_user = Plug_Query_Array($sql);
                    if ($user_user) {
                        $users[$array_value['car_admin']] = $user_user['user_user'] . ' (uid:' . $array_value['car_admin'] . ')';
                    } else {
                        $users[$array_value['car_admin']] = '[' . Plug_Lang('已删除') . '](uid:' . $array_value['car_admin'] . ')';
                    }
                }
                $array_value['car_admin'] = $users[$array_value['car_admin']];
            }

            $while_array_list = array();
            $while_array_list['key'] = $array_value['car_id'];
            $while_array_list['car_name'] = $array_value['car_name'];
            $while_array_list['car_pwd'] = $array_value['car_pwd'];
            $while_array_list['zhuangtai'] = $array_value['car_zhuangtai'];
            $while_array_list['IsLock'] = $test;
            $while_array_list['DaoLi_Rmb'] = $array_value['car_DaoLi_Rmb'];
            $while_array_list['car_reDATE'] = $array_value['car_reDATE'];
            $while_array_list['car_pur_date'] = $array_value['car_pur_date'];
            $while_array_list['car_agnet_beizhu'] = $array_value['car_agnet_beizhu'];
            $while_array_list['car_cong_user'] = $array_value['car_cong_user'];
            $while_array_list['car_admin'] = $array_value['car_admin'];
            $while_array_list['app_name'] = isset($app_array[$array_value['car_DaiHao']]) ? $app_array[$array_value['car_DaiHao']] : '';
            $while_array_list['app_leiname'] = isset($class_array[$array_value['car_Lei']]) ? $class_array[$array_value['car_Lei']] : Plug_Lang('[已删除]');
            $while_array_list['app_date'] = $array_value['car_TianShu'] . $carsys_arr[$array_value['car_type']];
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
