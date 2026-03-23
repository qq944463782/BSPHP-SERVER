<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');


/**
 * @管理员 mian 控制面板
 * 后台功能指引面板
 */
class appweb
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
     * http://127.0.0.5/index.php?m=applib&c=appweb&a=login&BSphpSeSsL=[验证串:可空]&user=[用户帐户]
     */
    function call_login()
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
            bs_call_location("index.php?m=applib&c=appweb&a=login&BSphpSeSsL={$seesid}&login_sate=YES");
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
                bs_call_location("index.php?m=applib&c=appweb&a=login&BSphpSeSsL={$session_id}&login_sate=YES");
                exit;
            }


            $log_name = $this->user_str_log[$log];
        } else {
            $user = Plug_Set_Get('user');
            $pwd = Plug_Set_Get('pwd');
        }


        include Plug_Load_Default_Path();
    }


    //反馈 http://127.0.0.5/index.php?m=applib&c=appweb&a=feedback&daihao=[软件代号]&uid=[用户UID:自定义]&table=[名称标题:自定义]&leix=[类型:自定义]&BSphpSeSsL=[接口登录后验证传:必传]
    function call_feedback()
    {
        Plug_Session_Open();
        //echo $this->intelligence_session->intelligence_session_id;
        //ECHO get_session_value("".'coode_imges_md5');


        $daihao = Plug_Set_Get('daihao');
        $uid = Plug_Set_Get('uid');
        $table = Plug_Set_Get('table');
        $leix = Plug_Set_Get('leix');

        $qq = Plug_Set_Post('qq');
        $txt = Plug_Set_Post('txt');
        $code = Plug_Set_Post('code');

        if (Plug_Get_Configs_Value('code', 'coode_say') == 1) {


            $log = Plug_Push_Cood_Imges($code);
            if ($log != 1037) {


                $log_name = $this->user_str_log[$log];
                include Plug_Load_Default_Path();
                exit;
            } else {
            }
        }


        /**
         * 提交留言
         */
        $log = Plug_UserAddLiuYan($leix, $table, $qq, $uid, $daihao, $txt);
        $log_name = $this->user_str_log[$log];


        include Plug_Load_Default_Path();
    }


    //注册 http://127.0.0.5/admin/index.php?m=applib&c=appweb&a=register
    function call_register()
    {


        $u = Plug_Set_Get('u');
        $user = Plug_Set_Post('user');
        $pwda = Plug_Set_Post('pwda');
        $pwdb = Plug_Set_Post('pwdb');
        $qq = Plug_Set_Post('qq');
        $mail = Plug_Set_Post('mail');
        $key = Plug_Set_Post('key');
        $img = Plug_Set_Post('img');
        $code_ka = Plug_Set_Post('code_ka');
        $log_name = '';
        $Submitadd = Plug_Set_Post('Submitadd');
        if ($Submitadd) {

            /**
             * 判断检测账号重复
             */

            #查询激活码是否存在
            $sql = "SELECT * FROM  `bs_php_cardseries` WHERE  `car_name` =  '{$code_ka}'   LIMIT 1;";
            $param_tmp = Plug_Query_Assoc($sql);
            //print_R($param_tmp);
            if (!$param_tmp) {
                $log_name = '激活码/充值卡不存在';
            } else
                if ($param_tmp['car_IsLock'] == 1) {
                $log_name = '激活码/充值卡已经被激活';
            } else {


                $log = Plug_User_Re_Add($user, $pwda, $pwdb, $qq, $mail, $u, '', '', '');
                if ($log == 1005) {


                    $sql = "SELECT * FROM  `bs_php_user` WHERE  `user_user` =  '{$user}'   LIMIT 1;";
                    $arr = Plug_Query_Assoc($sql);

                    $uid = $arr['user_uid'];
                    $date = HOST_UNIX;
                    Plug_App_Login_Add_Key($uid, $param_tmp['car_DaiHao'], 0, '', $user, $user); //添加特征
                    Plug_User_Chong($user, $code_ka, '');
                    $log_name = '注册成功 ';
                }
                $log_name = $this->user_str_log[$log] . $log;
            }
        }


        include Plug_Load_Default_Path();
    }

    //找回密码
    function call_Retrievepassword()
    {


        include Plug_Load_Default_Path();
    }


    //新闻列表
    function call_new_info()
    {


        $id = Plug_Set_Get('id');


        $sql = "SELECT * FROM  `bs_php_news` WHERE  `news_id` =  '{$id}'   LIMIT 1;";
        $news_array = Plug_Query_Assoc($sql);


        $sql = "SELECT * FROM  `bs_php_news_class` WHERE  `class_id` =  '{$news_array['news_class']}'   LIMIT 1;";
        $news_class_array = Plug_Query_Assoc($sql);


        $news_test = base64_decode($news_array['news_test']);
        $news_test = stripslashes($news_test);


        include Plug_Load_Default_Path();
    }


    //新闻列表 http://127.0.0.5/index.php?m=applib&c=appweb&a=new_list&open_new=[是否新窗口打开:_blank]
    function call_new_list()
    {


        $list = (int)Plug_Set_Get('list');
        $p = (int)Plug_Set_Get('p');
        $act = Plug_Set_Get('act');

        $open_new = Plug_Set_Get('open_new');

        $Page_mober = 15;
        //获取读取数量
        $LIMIT_As = $p;
        if ($LIMIT_As > 0)
            $LIMIT_As = $LIMIT_As - 1;
        $LIMIT_A = $LIMIT_As * $Page_mober;

        $date = null;
        $sql_list = null;
        $news_text = null;
        $i = 1;
        if ($list > 0)
            $sql_list = "AND `news_class`='$list'";
        $sql = "SELECT * FROM `bs_php_news`,`bs_php_news_class` WHERE class_id!=91000 AND class_id!=92000 AND `bs_php_news`.`news_class`=`bs_php_news_class`.`class_id` {$sql_list} ORDER BY`news_id`DESC LIMIT {$LIMIT_A},{$Page_mober}";
        $pdb_array_value = Plug_Query($sql);

        $sql_rows = "SELECT count(*)as 'hangshu' FROM`bs_php_news_class`, `bs_php_news` WHERE  class_id!=91000 AND class_id!=92000 AND `bs_php_news`.`news_class`=`bs_php_news_class`.`class_id`  {$sql_list} ORDER BY`news_id`DESC";
        $db_array_value = Plug_Query($sql);


        //-------------------------------------------

        /**
         * @获取条数<a href='news.htm'>1</a>
         */
        $param_tmp = Plug_Query_Assoc($sql_rows);
        $param_zongshu = $param_tmp['hangshu'];

        /**
         * @计算分页
         */
        //$yueshuls=取整数就小于$zongyue不取整数的了
        $zongyue = $param_zongshu / $Page_mober;

        $yueshuls = intval(strval($param_zongshu / $Page_mober));

        if ($zongyue > $yueshuls)
            $zongyue = ++$yueshuls;


        $pg_text = null;
        $i = 1;
        while ($i <= $zongyue) {


            $pg_text .= "<li><a href='index.php?m=applib&c=appweb&a=new_list&open_new=$open_new&list=$list&p=$i'>{$i}</a>";
            $i++;
        }

        if ($list > 0) {



            $sql = "SELECT * FROM  `bs_php_news_class` WHERE  `class_id` =  '{$list}'   LIMIT 1;";
            $list_array = Plug_Query_Assoc($sql);
        } else {

            $list_array['class_name'] = '新闻动态';
            $list_array['class_id'] = '0';
        }


        include Plug_Load_Default_Path();
    }

    /**
     * 获取当前页面完整URL地址
     */
    function getmyurl()
    {
        $param___SERVER__ = call_my_SERVER();
        $param_sys_protocal = isset($param___SERVER__['SERVER_PORT']) && $param___SERVER__['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $param_php_self = $param___SERVER__['PHP_SELF'] ? $param___SERVER__['PHP_SELF'] : $param___SERVER__['SCRIPT_NAME'];
        $param_path_info = isset($param___SERVER__['PATH_INFO']) ? $param___SERVER__['PATH_INFO'] : '';
        $relate_url = isset($param___SERVER__['REQUEST_URI']) ? $param___SERVER__['REQUEST_URI'] : $param_php_self . (isset($param___SERVER__['QUERY_STRING']) ? '?' . $param___SERVER__['QUERY_STRING'] : $param_path_info);


        return $param_sys_protocal . (isset($param___SERVER__['HTTP_HOST']) ? $param___SERVER__['HTTP_HOST'] : '') . $relate_url;
    }
    //充值 http://127.0.0.5/admin/index.php?m=applib&c=appweb&a=Recharge&user=944463782&ka=654&mi=321
    function call_Recharge()
    {


        /**
         * POST内容
         */
        $Submitadd = Plug_Set_Post('Submitadd');
        $user_user = Plug_Set_Post('user_user');
        $ka_name = Plug_Set_Post('ka_name');
        $ka_pwd = Plug_Set_Post('ka_pwd');


        /**
         * 去空格
         */
        $ka_name = trim($ka_name);
        $ka_pwd = trim($ka_pwd);


        /**
         * 判断是否为空
         */
        $log_name = '';
        if ($Submitadd) {
            if (trim($ka_name) == '')
                $log_name = "充值卡号不能为空";
            $log = Plug_User_Chong($user_user, $ka_name, $ka_pwd);

            $log_name = $this->user_str_log[$log];
        } else {
            /**
             * 获取GET账号密码
             */
            $GET_ka_user = Plug_Set_Get('user');
            $GET_ka_name = Plug_Set_Get('ka');
            $GET_ka_pwd = Plug_Set_Get('mi');


            $ka_name = $GET_ka_name;
            $ka_pwd = $GET_ka_pwd;
            $user_user = $GET_ka_user;
        }




        include Plug_Load_Default_Path();
    }

    /**
     * @登录模式
     * http://127.0.0.5/index.php?m=applib&c=appweb&a=links_login&daihao=[软件代号:可空]&BSphpSeSsL=[验证串:可空]&user=[用户帐户]&pwd=[用户密码]&login=YES
     * 
     */
    function call_links_login()
    {
        $log_name = '';
        $BSphpSeSsL = Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Session_Open();
        } else {
            Plug_Session_Open($BSphpSeSsL);
        }


        //接收参数
        $id = Plug_Set_Get('id');

        $user = Plug_Set_Get('user');
        $pwd = Plug_Set_Get('pwd');
        $daihao = Plug_Set_Get('daihao');
        $login = Plug_Set_Get('login');


        //判断是否已经登陆
        if (Plug_User_Is_Login_Seesion() == 1047) {
            $USER_UID = Plug_Get_Session_Value('USER_UID');


            $sql = "SELECT * FROM  `bs_php_user` WHERE  `user_uid` =  '{$USER_UID}'   LIMIT 1;";
            $array = Plug_Query_Assoc($sql);

            $user = $array['user_user'];




            if ($user == '') {
                echo 'CODE:信息读取失败';
                exit;
            }
        } else {


            if ($login) {


                //用户登陆
                $log = Plug_User_Web_Login($user, $pwd);
                $user_str_log = plug_load_langs_array('user', 'user_str_log');
                $appen_str_log = plug_load_langs_array('applib', 'appen_str_log');

                if ($log == 1011) {
                } else {
                    $log_name = $user_str_log[$log];
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                    echo 'CODE:' . $log_name;
                    exit;
                }
            } else {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                echo 'CODE:URL参数错误！';
                exit;
            }
        }


        if ($id > 0) {
            $sql = "UPDATE `bs_php_links_session` SET `links_set` = '-1' WHERE  `links_user_name` = '{$user}' AND `links_id` = '{$id}';";
            Plug_Query($sql);

            $param_tmie = PLUG_UNIX();
            Plug_Query("DELETE FROM `bs_php_links_session` WHERE `links_out_time` < '{$param_tmie}' or `links_set` = -1  LIMIT 10");
        }


        if ($daihao <> 0) {
            $daihao_sql = " AND `links_daihao`= '$daihao'";
        } else {
            $daihao_sql = '';
        }


        $sql = "SELECT * FROM`bs_php_links_session` WHERE `links_user_name`='{$user}' {$daihao_sql} ORDER BY`links_biaoji`DESC";
        //echo $sql;
        $db_array_value = Plug_Query($sql);


        include Plug_Load_Default_Path();
    }

    /**
     * @登录模式
     * http://127.0.0.5/index.php?m=applib&c=appweb&a=links_car&daihao=[软件代号]&BSphpSeSsL=[验证串:可空]&car_id=[卡用户帐户]&car_pwd=[用户密码:可空]&login=YES
     * 
     */
    function call_links_car()
    {
        $log_name = '';
        $BSphpSeSsL = Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Session_Open();
        } else {
            Plug_Session_Open($BSphpSeSsL);
        }


        //接收参数
        $id = Plug_Set_Get('id');

        $car_id = Plug_Set_Get('car_id');
        $car_pwd = Plug_Set_Get('car_pwd');
        $daihao = Plug_Set_Get('daihao');
        $login = Plug_Set_Get('login');
        //判断是否已经登陆
        if ($car_id == '') {
            $car_id = Plug_Get_Session_Value('ic_carid');
            $car_pwd = Plug_Get_Session_Value('ic_pwd');
            $daihao = Plug_Get_Session_Value('daihao');
        }


        $log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);
        if ($log == 1080) {
            Plug_Set_Session_Value('ic_carid', $car_id);
            //登陆UID
            Plug_Set_Session_Value('ic_pwd', $car_pwd);
            //登陆MD7加密
            Plug_Set_Session_Value('daihao', $daihao);
            //登陆MD7加密

        } else {


            if ($login) {


                //用户登陆
                $carinfo = Plug_Get_Card_Info($car_id, $car_pwd, $daihao);
                if (is_array($carinfo)) {


                    Plug_Set_Session_Value('ic_carid', $car_id);
                    //登陆UID
                    Plug_Set_Session_Value('ic_pwd', $car_pwd);
                    //登陆MD7加密
                    Plug_Set_Session_Value('daihao', $daihao);
                    //登陆MD7加密


                } else {
                    $log_name = $this->user_str_log[$log];
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                    echo 'CODES:' . $log_name;
                    exit;
                }
            } else {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                echo 'CODE:URL参数错误！';
                exit;
            }
        }

        if ($id > 0) {
            $sql = "UPDATE `bs_php_links_session` SET `links_set` = '-1' WHERE  `links_user_name` = '{$car_id}' AND `links_id` = '{$id}';";
            Plug_Query($sql);
            //$this->intelligence_session->links_delete_ALL_out();

            $param_tmie = PLUG_UNIX();


            Plug_Query("DELETE FROM `bs_php_links_session` WHERE `links_out_time` < '{$param_tmie}' or `links_set` = -1  LIMIT 10");
        }

        if ($daihao <> 0) {
            $daihao_sql = " AND `links_daihao`= '{$daihao}'";
        } else {
            $daihao_sql = '';
        }

        $sql = "SELECT * FROM`bs_php_links_session` WHERE `links_user_name`='{$car_id}' {$daihao_sql} ORDER BY`links_biaoji`DESC";
        //echo $sql;
        $db_array_value = Plug_Query($sql);


        include Plug_Load_Default_Path();
    }

    /**
     * 充值续费
     * http://127.0.0.5/index.php?m=applib&c=appweb&a=buyvip&id=[卡类ID]&uid=[参数类型/续费卡/以机器码登录机器码]
     */
    function call_buyvip()
    {




        $id = Plug_Set_Get('id');   #充值卡id
        $uid = Plug_Set_Get('uid');   #充值帐户
        $congid = $uid;
        $lei = Plug_Set_Get('type'); #支付类型
        //$typeuid = Plug_Set_Get('typeuid');

        if ($lei == '') {
            echo Plug_Lang('[&type=]充值类型不存在,请输入支付类型,如:alipay|weixin');
            exit;
        }

        if ($uid == '') {
            echo Plug_Lang('[&uid=]充值对象不能空,请输入充值开通帐户/卡模式充值卡号/机器码');
            exit;
        }


        $sql = "SELECT*FROM`bs_php_kalei`WHERE`lei_id`='{$id}'";
        $arr = Plug_Query_Assoc($sql);
        if (!$arr) {
            echo Plug_Lang('[&id=]卡类不存在,请在后台查找充值卡类型id ');
            exit;
        }


        if ($arr['lei_jiage'] == -1) {
            echo Plug_Lang('无权续费,当前套餐禁止续费. 套餐价格小于等于 -1');
            exit;
        }
        $ka_jiage = $arr['lei_jiage'];

        $sql = "SELECT*FROM`bs_php_appinfo`WHERE`app_daihao`='{$arr['lei_daihao']}'";
        $appinfo = Plug_Query_Assoc($sql);



        if (!$appinfo) {
            echo Plug_Lang('软件不存在,套餐软件不存在 软件号:') . $arr['lei_daihao'];
            exit;
        }

        $app_name = $appinfo['app_name'];


        $pay_zhe = 0;
        $sql = "SELECT `user_uid`,`user_user`,`user_Zhe` FROM  `bs_php_user` WHERE  `user_user` =  '{$uid}'";
        $arraySS = Plug_Query_Assoc($sql);
        if ($arraySS) {
            $uid = $arraySS['user_uid'];


            $zhe = $arraySS['user_Zhe'];

            $param_shu = 1;
            /*开始算价格*/

            if ($zhe > 0 and $zhe < 10) {
                //判断该账户有折扣

                $pay_zhe = $zhe;

                $zhe = $zhe / 10;
                //获取百分比
                $jiazhe = $zhe * $ka_jiage;
                //打折后的实价


                $jia = $ka_jiage - $jiazhe;
                //打折后的优惠
                $jia = $jia * $param_shu;
                //优惠金额

                $shijia = $jiazhe * $param_shu;
                //实付款





            } else {
                $shijia = $arr['lei_jiage'];
                $zhe = 0;
                $jia = 0;
                $pay_zhe = 0;
            }


            $ka_date = $arr['lei_date'];
            //类的充值卡的 天数
            $ka_name = $arr['lei_name'];
            $daihao = $arr['lei_daihao'];
        } else {
            //echo 'USER错误';
            // exit;

            $ka_date = $arr['lei_date'];
            //类的充值卡的 天数
            $ka_name = $arr['lei_name'];
            $daihao = $arr['lei_daihao'];
            $shijia = $arr['lei_jiage'];
            $jia = 0;
            $pay_zhe = 0;
        }




        $sql = "SELECT * FROM  `bs_php_pattern_login` WHERE  `L_User_uid` =  '{$uid}' AND  `L_daihao` = {$arr['lei_daihao']} LIMIT 1";
        $arrlogin = Plug_Query_Assoc($sql);
        if (!$arrlogin) {
            echo Plug_Lang('充值对象错误,当前用户没有使用过软件无法充值续费');
            exit;
        }



        //$app_name = 



        //$jia = 0;
        $ka_kate = PLUG_DATE();

        $pay_qian_rmb = -1;
        $pay_rmb = -1;
        $pay_beizhu = Plug_Lang("{$app_name}") . Plug_Lang(" - 续费/开通服务") . Plug_Lang("{$ka_name}") .Plug_Lang("ID:"). $congid;
        $ail_id = 'BUYVIP' . date('YmdHis', PLUG_UNIX()) . rand(1000, 99999);
        $sql = "INSERT INTO `bs_php_pay_log` (`pay_id`,`ali_id`,`pay_uid`,`pay_date`,`pay_qian_rmb`,`pay_rmb`,`pay_ka_shuliang`,`pay_zhuangtai`,`ka_shijia`,`ka_zhe_jia`,`ali_ka_name`,`ali_ka_jiage`,`ali_ka_zhe`,`ali_ka_date`,`pay_daihao`,`pay_app_name`,`pay_type`,`pay_yao_uid`) 
        VALUES('$ail_id',NULL,'$uid','$ka_kate','$pay_qian_rmb','$pay_rmb','1','0','$shijia','$jia','$pay_beizhu','$ka_jiage','$pay_zhe','$ka_date','$daihao','$app_name','{$arr['lei_id']}',0);";

        Plug_Query($sql);

        $pay_id = $ail_id;

        $pay_amount = $shijia;
        //金额


        $pay_leixing = $lei;
        //充值方式


        $__GLOBAL__PAY__ = array(
            $pay_id,
            $pay_beizhu,
            $pay_amount
        );


        $openfileconfig = Plug_Get_Bsphp_Dir() . 'include/modules/payment/paycood/' . $pay_leixing .
            '/form_config.php';


        if (!file_exists($openfileconfig))
            exit(Plug_alerts(Plug_Lang('Error:要引入支付文件不存在'), Plug_Lang('需要引入php脚步文件不存在。<BR/>文件路径:') . $openfileconfig));
        $config_array = include($openfileconfig);

        $openfileconfig = Plug_Get_Bsphp_Dir() . 'include/modules/payment/paycood/' . $pay_leixing .
            '/' . $config_array['pay_config']['OpenFile'];
        if (!file_exists($openfileconfig))
            exit(Plug_alerts(Plug_Lang('Error:要引入支付文件不存在'), Plug_Lang('需要引入php脚步文件不存在。<BR/>文件路径:') . $openfileconfig));



        include($openfileconfig);
    }
}
