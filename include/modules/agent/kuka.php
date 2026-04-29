<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT')
    die('Not,This File Not Can in Ie Modules');


/*
 * Feature: 库存卡管理(旧控制器)
 * Menu ID: legacy_kuka
 * 说明: 历史库存卡控制器，包含库存制卡与库存明细等旧入口逻辑。
 */
class kuka 
{

    public $db,$user_array,$Grade, $purconfig, $session,$user,$GLOBALS_LANGS,$user_str_log;
    function __construct()
    {





      

        //开启session
        plug_session_open();
        $this->GLOBALS_LANGS = Plug_Load_Langs_Array('user', 'user_str_log');


        if (Plug_Get_Configs_Value('sys', 'stop_agent') == 0) {


            bs_lib::Alerts($this->GLOBALS_LANGS['sys'], Plug_Get_Configs_Value('sys', 'stop_agent_info'));

            exit;
        }


        $USER_UID = Plug_Get_Session_Value('USER_UID'); //登陆UID
      
        $this->user_array = Plug_Query_Array("SELECT * FROM bs_php_user WHERE user_uid = '{$USER_UID}'");
  
        if(!$this->user_array){
            Plug_Alert(Plug_Lang('你没有权限,请先登录。没有权限请授权使用.'));
            Plug_Location('index.php');
            exit;
        }
      





        //代理权限验证
        if ($this->user_array['user_daili'] == 0) {
            Plug_Alert(Plug_Lang('你没有权限,请先登录。没有权限请授权使用.'));
            Plug_Location('index.php');
            exit;
        }

        /**
         * @登陆状态验证
         * 
         * 不等于登陆状态跳转到登陆页面
         */
        $login_log = Plug_User_Is_Login_Seesion();
        if ($login_log != 1047) {
            Plug_Alert(Plug_Lang('你没有权限,请先登录。'));
            Plug_Location('index.php');

            exit;
        }
       

        if (Plug_Get_Session_Value('USER_UID_IS') == 0) {
            bs_lib::ShowMsg(Plug_Lang("代理中心未授权,请授权在使用."), '');

            Plug_Set_Session_Value('USER_UID', 'Not'); //登陆UID
            exit;
        }


        if ($this->user_array['user_daili'] == 1) {
            $this->Grade = 1;
        } else if ($this->user_array['user_daili'] == 2) {
            $this->Grade = 2;
        } else {
            $this->Grade = 3;
        }
    }


    /**
     * @控制面板-登录面板
     * 
     */
    function call_kuka_add()
    {

        /**
         * 查询软件名称
         * 
         */

        $app_name = Plug_GetAppInfoNameArray();


        /**
         * 提交信息
         */
  
        $select = Plug_Set_Post('select');

        $shu = Plug_Set_Post('shu');
        $beizhu = Plug_Set_Post('beizhu');
        $Submit = Plug_Set_Post('appenconfig');
        if ($Submit) {


            $bin_time =  Plug_Get_Session_Value('bin_time');
            $ok = time() - $bin_time;
            if ($ok < 5) {
                Plug_Set_Session_Value('bin_time', time());

               Plug_Add_AppenLog('od_po_log', Plug_Lang("用户频繁制卡异常:你制卡太频繁,请10秒后再试!"), $this->user_array['user_user']);
                Plug_Print_Json(array("code" => -11, 'msg' => Plug_Lang("你制卡太频繁,请10秒后再试!")));
            }

            /**
             * 判断输入信息是否合理
             */
            if ($shu <= 0)
                //alert('请输入制作的数量。');
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请输入制作的数量!")));
            if ($shu > 100)
                //alert('超出范围,每次制卡最大数量100张');
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("超出范围,每次制卡最大数量100张!")));
            if ($select == 0)
                //alert('请选择你要制作的软件的充值卡类型');
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请选择你要制作的软件的充值卡类型!")));



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

            /**
             * 获取充值卡类型信息
             */
            $leixing_array = Plug_Query_One('bs_php_kalei', 'lei_id', $kuka_array['kuka_kalei'], ' * ');



            Plug_Set_Session_Value('bin_time', time());
            //引入文件
            //bs_lib::load_modules_common('applib', 'makecard');
            Plug_Load_Modules_Common('applib', 'makecard');
            $zhi_date = Plug_ZhiZuoC($shu, $kuka_array['kuka_kalei'], $this->user_array['user_uid'], '', -10, '', $beizhu);

           Plug_Add_AppenLog('agent_ka_log', "UID:{$this->user_array['user_uid']}," . Plug_Lang("库存制作数量") . ":$shu,".Plug_Lang("制作时间").":$zhi_date", $this->user_array['user_user']);

            /**
             * 在这里写金额扣除SQL
             */
            $sql = "UPDATE`bs_php_kuka`SET `kuka_val`=`kuka_val`-'{$shu}' WHERE  `bs_php_kuka`.`kuka_id`='{$kuka_array['kuka_id']}';";
            $tmp = Plug_Query($sql);
            if ($tmp) {
            }


            Plug_Print_Json(array('code' => 8, 'msg' => Plug_Lang("库卡制作成功!"), 'url' => 'index.php?m=agent&c=CardManageFeature&a=table'));

            // location('index.php?m=agent_new&c=sp&a=show&date=' . $zhi_date . '&id=' . $select);
            //print_R($leixing_array);

        }





        /*******获取用户分组*****/
        $sql = "SELECT*FROM`bs_php_kalei` ";
        $dbs_array_value = Plug_Query($sql);


        $class_array[0] = Plug_Lang('类型已经删除');

        if ($dbs_array_value) {
            while ($array_value = Plug_Pdo_Fetch_Assoc($dbs_array_value)) {
                $class_array[$array_value["lei_id"]] = $array_value["lei_name"];
            }
        }
        /**
         * 查询所有充值卡类型and `bs_php_kalei`.`lei_daihao`=`bs_php_appinfo`.`app_daihao`  WHERE `lei_daili` !='-1'  ORDER BY `lei_daihao `ASC
         */
        $sql = "SELECT `kuka_id`,`app_name`,`kuka_val`,`kuka_kalei` FROM `bs_php_kuka`,`bs_php_appinfo` WHERE  `bs_php_appinfo`.`app_daihao` = `bs_php_kuka`.`kuka_daihao`  AND `kuka_uid` = '{$this->user_array['user_uid']}' ";
        // echo $sql;
        $tmp = Plug_Query($sql);


        include Plug_Load_Default_Path();
    }
    



    function call_kuka_transaction_add()
    {
        /**
         * 查询软件名称
         * 
         */


        $uid = (int)Plug_Set_Get('ids');
        $sql = "SELECT * FROM `bs_php_user` WHERE `user_yao_User` = '{$this->user_array['user_user']}' and `user_uid` = '{$uid}' ";
        $user_array_agent = Plug_Query_Array($sql);
        if (!$user_array_agent) {
            call_my_alert(Plug_Lang('账号不存在.'));
        }
        $app_name = Plug_GetAppInfoNameArray();
        /*******获取用户分组*****/
        $sql = "SELECT*FROM`bs_php_kalei` ";
        $dbs_array_value = Plug_Query($sql);


        $class_array[0] = Plug_Lang('类型已经删除');

        if ($dbs_array_value) {
            while ($array_value = Plug_Pdo_Fetch_Assoc($dbs_array_value)) {
                $class_array[$array_value["lei_id"]] = $array_value["lei_name"];
            }
        }

        /**
         * 提交信息
         */
       
        $select = Plug_Set_Post('select');
        $shu = Plug_Set_Post('shu');
        $beizhu = Plug_Set_Post('beizhu');
        $Submit = Plug_Set_Post('appenconfig');
        if ($Submit) {

            /**
             * 判断输入信息是否合理
             */
            if ($shu <= 0)
                //alert('请输入制作的数量。');
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请输入数量!")));
            if ($shu > 100)
                //alert('超出范围,每次制卡最大数量100张');
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("超出范围,每次制卡最大数量100张!")));
            if ($select == 0)
                //alert('请选择你要制作的软件的充值卡类型');
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请选择你要软件的充值卡类型!")));



            $kuka_array = Plug_Query_One('bs_php_kuka', 'kuka_id', $select, ' * ');
            if (!$kuka_array) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("卡类不存在A!")));
            }
            if ($kuka_array['kuka_uid'] != $this->user_array['user_uid']) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请不要恶意串权!")));
            }


            if ($kuka_array['kuka_val'] <= 0) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("当前剩余卡已经为0!")));
            }

            if ($kuka_array['kuka_val'] < $shu) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("当前卡类库存不足已你需要的量!")));
            }

            /**
             * 获取充值卡类型信息
             */
            $leixing_array = Plug_Query_One('bs_php_kalei', 'lei_id', $kuka_array['kuka_kalei'], ' * ');
            if (!$leixing_array) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("卡类不存在!")));
            }






            /**
             * 在这里写金额扣除SQL
             */
            $sql = "UPDATE `bs_php_kuka` SET `kuka_val`=`kuka_val`-'{$shu}' WHERE `kuka_id`='{$kuka_array['kuka_id']}';";
            $TOP = Plug_Query($sql);
            if (!$TOP) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("转出失败!")));
            }

            $addid = "{$user_array_agent['user_uid']}_{$leixing_array['lei_daihao']}_{$leixing_array['lei_id']}";

            $sql = "SELECT * FROM  `bs_php_kuka` WHERE  `kuka_biaoji` ='{$addid}';";
            $keka_array_2 = Plug_Query_Array($sql);
            if (!$keka_array_2) {



                $sql = "INSERT INTO `bs_php_kuka` (`kuka_id`, `kuka_uid`, `kuka_daihao`, `kuka_kalei`, `kuka_biaoji`, `kuka_val`, `kuka_user`) VALUES (NULL, '{$user_array_agent['user_uid']}', '{$leixing_array['lei_daihao']}', '{$leixing_array['lei_id']}', '{$addid}', '0', '{$user_array_agent['user_user']}');";
                Plug_Query($sql);

                $sql = "SELECT * FROM  `bs_php_kuka` WHERE  `kuka_biaoji` ='{$addid}';";
                $keka_array_2 = Plug_Query_Array($sql);
            }


            $sql = "UPDATE`bs_php_kuka`SET `kuka_val`=`kuka_val`+'{$shu}'WHERE `kuka_id`='{$keka_array_2['kuka_id']}';";
            Plug_Query($sql);
           Plug_Add_AppenLog('agent_ka_log', Plug_Lang("转出库卡成功").",{$app_name[$leixing_array['lei_daihao']]}-{$class_array[$leixing_array['lei_id']]} ".Plug_Lang("代理账号").":{$user_array_agent['user_user']},".Plug_Lang("数量").":-$shu", $this->user_array['user_user']);
           Plug_Add_AppenLog('agent_ka_log', Plug_Lang("库卡入卡成功").",{$app_name[$leixing_array['lei_daihao']]}-{$class_array[$leixing_array['lei_id']]} ".Plug_Lang("上级账号转给数量").":+$shu", $user_array_agent['user_user']);


            Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("转出成功!")));
        }






        /**
         * 查询所有充值卡类型and `bs_php_kalei`.`lei_daihao`=`bs_php_appinfo`.`app_daihao`  WHERE `lei_daili` !='-1'  ORDER BY `lei_daihao `ASC
         */
        $sql = "SELECT `kuka_id`,`app_name`,`kuka_val`,`kuka_kalei` FROM `bs_php_kuka`,`bs_php_appinfo` WHERE  `bs_php_appinfo`.`app_daihao` = `bs_php_kuka`.`kuka_daihao`  AND kuka_uid = '{$this->user_array['user_uid']}' ";

        $tmp = Plug_Query($sql);

        include Plug_Load_Default_Path();
    }

    function call_kuka_transaction_reduce()
    {
        /**
         * 查询软件名称
         * 
         */


        $uid = (int)Plug_Set_Get('ids');
        $sql = "SELECT * FROM `bs_php_user` WHERE `user_yao_User` = '{$this->user_array['user_user']}' and `user_uid` = '{$uid}' ";
        $user_array_agent = Plug_Query_Array($sql);
        if (!$user_array_agent) {
            call_my_alert(Plug_Lang('账号不存在.'));
        }
        $app_name = Plug_GetAppInfoNameArray();
        /*******获取用户分组*****/
        $sql = "SELECT*FROM`bs_php_kalei` ";
        $dbs_array_value = Plug_Query($sql);


        $class_array[0] = Plug_Lang('类型已经删除');

        if ($dbs_array_value) {
            while ($array_value = Plug_Pdo_Fetch_Assoc($dbs_array_value)) {
                $class_array[$array_value["lei_id"]] = $array_value["lei_name"];
            }
        }

        /**
         * 提交信息
         */
    
        $select = Plug_Set_Post('select');
        $shu = Plug_Set_Post('shu');
        $beizhu = Plug_Set_Post('beizhu');
        $Submit = Plug_Set_Post('appenconfig');
        if ($Submit) {

            /**
             * 判断输入信息是否合理
             */
            if ($shu <= 0)
                //alert('请输入制作的数量。');
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请输入数量!")));
            if ($shu > 100)
                //alert('超出范围,每次制卡最大数量100张');
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("超出范围,每次制卡最大数量100张!")));
            if ($select == 0)
                //alert('请选择你要制作的软件的充值卡类型');
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请选择你要软件的充值卡类型!")));



            $kuka_array = Plug_Query_One('bs_php_kuka', 'kuka_id', $select, ' * ');
            if (!$kuka_array) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("卡类不存在A!")));
            }
            if ($kuka_array['kuka_uid'] != $user_array_agent['user_uid']) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("请不要恶意串权!")));
            }


            if ($kuka_array['kuka_val'] <= 0) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("当前剩余卡已经为0!")));
            }

            if ($kuka_array['kuka_val'] < $shu) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("当前卡类库存不足已你需要的量!")));
            }

            /**
             * 获取充值卡类型信息
             */
            $leixing_array = Plug_Query_One('bs_php_kalei', 'lei_id', $kuka_array['kuka_kalei'], ' * ');
            if (!$leixing_array) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("卡类不存在!")));
            }






            /**
             * 在这里写金额扣除SQL
             */
            $sql = "UPDATE `bs_php_kuka` SET `kuka_val`=`kuka_val`-'{$shu}' WHERE `kuka_id`='{$kuka_array['kuka_id']}';";
            $TOP = Plug_Query($sql);
            if (!$TOP) {
                Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("收回失败!")));
            }

            $addid = "{$this->user_array['user_uid']}_{$leixing_array['lei_daihao']}_{$leixing_array['lei_id']}";

            $sql = "SELECT * FROM  `bs_php_kuka` WHERE  `kuka_biaoji` ='{$addid}';";
            $keka_array_2 = Plug_Query_Array($sql);
            if (!$keka_array_2) {



                $sql = "INSERT INTO `bs_php_kuka` (`kuka_id`, `kuka_uid`, `kuka_daihao`, `kuka_kalei`, `kuka_biaoji`, `kuka_val`, `kuka_user`) VALUES (NULL, '{$this->user_array['user_uid']}', '{$leixing_array['lei_daihao']}', '{$leixing_array['lei_id']}', '{$addid}', '0', '{$this->user_array['user_user']}');";
                Plug_Query($sql);

                $sql = "SELECT * FROM  `bs_php_kuka` WHERE  `kuka_biaoji` ='{$addid}';";
                $keka_array_2 = Plug_Query_Array($sql);
            }


            $sql = "UPDATE`bs_php_kuka`SET `kuka_val`=`kuka_val`+'{$shu}'WHERE `kuka_id`='{$keka_array_2['kuka_id']}';";
            Plug_Query($sql);
           Plug_Add_AppenLog('agent_ka_log', Plug_Lang("库卡收回成功").",{$app_name[$leixing_array['lei_daihao']]}-{$class_array[$leixing_array['lei_id']]} ".Plug_Lang("代理账号").":{$user_array_agent['user_user']},".Plug_Lang("数量").":+$shu", $this->user_array['user_user']);
           Plug_Add_AppenLog('agent_ka_log', Plug_Lang("库卡上级收回").",{$app_name[$leixing_array['lei_daihao']]}-{$class_array[$leixing_array['lei_id']]} ".Plug_Lang("上级账号转给数量").":-$shu", $user_array_agent['user_user']);


            Plug_Print_Json(array('code' => '1', 'msg' => Plug_Lang("收回成功!")));
        }






        /**
         * 查询所有充值卡类型and `bs_php_kalei`.`lei_daihao`=`bs_php_appinfo`.`app_daihao`  WHERE `lei_daili` !='-1'  ORDER BY `lei_daihao `ASC
         */
        $sql = "SELECT `kuka_id`,`app_name`,`kuka_val`,`kuka_kalei` FROM `bs_php_kuka`,`bs_php_appinfo` WHERE  `bs_php_appinfo`.`app_daihao` = `bs_php_kuka`.`kuka_daihao` AND kuka_uid = '{$user_array_agent['user_uid']}'";
        //  echo $sql;
        $tmp = Plug_Query($sql);

        include Plug_Load_Default_Path();
    }

}
