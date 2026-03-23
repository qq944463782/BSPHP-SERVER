<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'salecard_renew',
    'name'  => '销售卡1-WEB页面直接充值续费',
    'path'  => '/index.php',
    'method' => 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'salecard_renew', 'a' => 'index'),
    'params' => array(
        array('name' => 'daihao', 'label' => '软件代号', 'required' => true),
        array('name' => 'user', 'label' => '充值帐户', 'tip' => '账号/卡号/机器码，用于预填充值对象', 'required' => false),
        array('name' => 'u', 'label' => '邀请码', 'tip' => '推荐人账号/UID，用于提成', 'required' => false)
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 销售卡1 - WEB页面直接充值续费
 */
class salecard_renew
{
    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
    }

    /**
     * 全部软件列表页 - 销售卡1 续费入口聚合
     * 访问: index.php?m=webapi&c=salecard_renew&a=list
     */
    function call_list()
    {
        $sql = "SELECT `app_daihao`,`app_name`,`app_sale_title`,`app_sale_img`,`app_sale_desc`,`app_sale_kefu`
                FROM `bs_php_appinfo`
                WHERE `app_sale_title` IS NOT NULL AND TRIM(`app_sale_title`)!=''
                ORDER BY `app_sort` ASC, `app_daihao` ASC";
        $res = Plug_Query($sql);
        $app_list = array();
        while ($row = Plug_Pdo_Fetch_Assoc($res)) {
            $app_list[] = $row;
        }

        $sys_url = Plug_Get_Configs_Value('sys', 'url');
        if (function_exists('call_my_storage_file_url') && !empty($app_list)) {
            foreach ($app_list as &$a) {
                if (!empty($a['app_sale_img'])) {
                    $a['app_sale_img'] = call_my_storage_file_url($a['app_sale_img']);
                }
            }
            unset($a);
        }

        include Plug_Load_Default_Path();
    }

    function call_index()
    {
        $daihao = (int)Plug_Set_Get('daihao');
        $carid = Plug_Set_Post('carid');
        $uid = Plug_Set_Post('uid');
        $type = Plug_Set_Post('type');

        // 充值帐户 user：URL 预填，用于分享链接时指定充值对象
        $renew_user = trim((string)(Plug_Set_Get('user') ?: Plug_Set_Post('user')));

        // 邀请码 u：优先本次传参，其次 cookie
        $u = Plug_Set_Get('u') ?: Plug_Set_Post('u');
        if ($u !== '') {
            setcookie('cookie_uid', $u, time() + 86400, '/');
        } elseif (!empty($_COOKIE['cookie_uid'])) {
            $u = $_COOKIE['cookie_uid'];
        }

        $err = '';
        $appinfo = null;
        $card_list = array();
        $news_list = array();
        $pay_channels = $this->_get_pay_channels();

        if ($daihao <= 0) {
            $err = Plug_Lang('软件代号无效');
        } else {
            $sql = "SELECT * FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1";
            $appinfo = Plug_Query_Assoc($sql);
            if (!$appinfo || empty(trim($appinfo['app_sale_title'] ?? ''))) {
                $err = Plug_Lang('软件不存在或未参与销售');
            } else {
                if (function_exists('call_my_storage_file_url') && !empty($appinfo['app_sale_img'])) {
                    $appinfo['app_sale_img'] = call_my_storage_file_url($appinfo['app_sale_img']);
                }
                $sql = "SELECT `lei_id`,`lei_name`,`lei_jiage`,`lei_date`,`lei_img` FROM `bs_php_kalei` 
                        WHERE `lei_daihao`='{$daihao}' AND `lei_jiage`>=0 ORDER BY `lei_sort` ASC, `lei_id` ASC";
                $res = Plug_Query($sql);
                while ($row = Plug_Pdo_Fetch_Assoc($res)) {
                    if (!empty($row['lei_img']) && function_exists('call_my_storage_file_url')) {
                        $row['lei_img'] = call_my_storage_file_url($row['lei_img']);
                    }
                    $card_list[] = $row;
                }
                // 所属软件相关文章（news_daihao 关联）
                $sql = "SELECT `news_id`,`news_table`,`news_unix` FROM `bs_php_news` WHERE `news_daihao`='{$daihao}' ORDER BY `news_id` DESC LIMIT 50";
                $res = Plug_Query($sql);
                while ($row = Plug_Pdo_Fetch_Assoc($res)) {
                    $news_list[] = $row;
                }
            }
        }

     

        $order_result = null;
        $order_no = trim(Plug_Set_Get('order') ?: Plug_Set_Post('order'));
        if ($order_no && $daihao > 0) {
            $order_result = $this->_query_order($order_no, $daihao);
        }

        include Plug_Load_Default_Path();
    }

    function call_do_pay()
    {


        $daihao = (int)Plug_Get_Url_Param('daihao');
        $carid = Plug_Get_Url_Param('carid');
        $uid = Plug_Get_Url_Param('uid');
        $carid = Plug_Get_Url_Param('carid');
        $is_ok = Plug_Get_Url_Param('is_ok'); //用验证前半部分的代码是否正常
        $lei_dir = Plug_Get_Url_Param('type'); //支付方式
        // 邀请码/推荐人：URL 优先，其次 cookie
        $u = Plug_Get_Url_Param('u'); // 邀请码/推荐人
        if ($u === '' && !empty($_COOKIE['cookie_uid'])) {
            $u = $_COOKIE['cookie_uid'];
        }



        $congid = $uid;
        $sql = "SELECT * FROM `bs_php_kalei` WHERE `lei_id`='{$carid}' AND `lei_daihao`='{$daihao}' LIMIT 1";
        $arr = Plug_Query_Assoc($sql);
        if (!$arr) {
            //echo Plug_Lang('卡类不存在');
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('卡类不存在') . '(' . $carid . ')'));
            //exit;
        }
        if ($arr['lei_jiage'] < 0) {
            //echo Plug_Lang('当前套餐禁止续费');
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('当前套餐禁止续费')));
            //exit;
        }
        $sql = "SELECT * FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1";
        $appinfo = Plug_Query_Assoc($sql);
        if (!$appinfo) {
            //echo Plug_Lang('软件不存在');
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('软件不存在')));
            //exit;
        }
        $app_name = $appinfo['app_name'];
        $pay_zhe = 0;
        $sql = "SELECT `user_uid`,`user_user`,`user_Zhe` FROM `bs_php_user` WHERE `user_user`='{$uid}' LIMIT 1";
        $arraySS = Plug_Query_Assoc($sql);
        if ($arraySS) {
            $uid = $arraySS['user_uid'];
            $zhe = $arraySS['user_Zhe'];
            if ($zhe > 0 && $zhe < 10) {
                $pay_zhe = $zhe;
                $jiazhe = ($zhe / 10) * $arr['lei_jiage'];
                $shijia = $jiazhe;
            } else {
                $shijia = $arr['lei_jiage'];
            }
        } else {
            $shijia = $arr['lei_jiage'];
        }
        $sql = "SELECT * FROM `bs_php_pattern_login` WHERE `L_User_uid`='{$uid}' AND `L_daihao`='{$daihao}' LIMIT 1";
        $arrlogin = Plug_Query_Assoc($sql);
        if (!$arrlogin) {
            //echo Plug_Lang('充值对象错误,当前用户没有使用过软件无法充值续费');
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('充值对象错误,当前用户没有使用过软件无法充值续费')));
            //exit;
        }

        if ($is_ok == 9999) {
            plug_print_json(array('code' => 9999, 'msg' => Plug_Lang('验证成功')));
            exit;
        }


        $pay_beizhu = Plug_Lang("{$app_name}") . Plug_Lang(" - 续费/开通服务") . Plug_Lang("{$arr['lei_name']}") . Plug_Lang("ID:") . $congid;
        if ($u !== '') {
            $pay_beizhu .= ' [U:' . preg_replace('/[^a-zA-Z0-9_@.]/', '', $u) . ']';
        }
        $ail_id = 'BUYVIP' . date('YmdHis', PLUG_UNIX()) . rand(1000, 99999);
        $ka_kate = PLUG_DATE();
        $pay_qian_rmb = -1;
        $pay_rmb = -1;
        $ka_jiage = $arr['lei_jiage'];
        $ka_date = $arr['lei_date'];
        $jia = isset($jiazhe) ? ($ka_jiage - $jiazhe) : 0;
        if (!isset($shijia)) $shijia = $arr['lei_jiage'];
        if (!isset($pay_zhe)) $pay_zhe = 0;


        $cfg_file = Plug_Get_Bsphp_Dir() . 'include/modules/payment/paycood/' . $lei_dir . '/form_config.php';
        if (!file_exists($cfg_file)) $lei_dir = 'alipay';

        // 解析推荐人 uid（pay_yao_uid），并将原始 u 附加到备注末尾 [U:xxx]
        $pay_yao_uid = 0;
        if ($u !== '') {
            $u_raw = trim((string)$u);
            $u_safe = addslashes($u_raw);
            if (ctype_digit($u_raw) && (int)$u_raw > 0) {
                $row_u = Plug_Query_Assoc("SELECT `user_uid` FROM `bs_php_user` WHERE `user_uid`='{$u_safe}' LIMIT 1");
            } else {
                $row_u = Plug_Query_Assoc("SELECT `user_uid` FROM `bs_php_user` WHERE `user_user`='{$u_safe}' LIMIT 1");
            }
            if ($row_u && isset($row_u['user_uid'])) {
                $pay_yao_uid = (int)$row_u['user_uid'];
            }
            $pay_beizhu .= ' [U:' . preg_replace('/[^a-zA-Z0-9_@.]/', '', $u_raw) . ']';
        }

        $sql = "INSERT INTO `bs_php_pay_log` (`pay_id`,`pay_uid`,`pay_date`,`pay_qian_rmb`,`pay_rmb`,`pay_ka_shuliang`,`pay_zhuangtai`,`ka_shijia`,`ka_zhe_jia`,`ali_ka_name`,`ali_ka_jiage`,`ali_ka_zhe`,`ali_ka_date`,`pay_daihao`,`pay_app_name`,`pay_type`,`pay_yao_uid`) 
                VALUES('$ail_id','$uid','$ka_kate','$pay_qian_rmb','$pay_rmb','1','0','$shijia','$jia','$pay_beizhu','$ka_jiage','$pay_zhe','$ka_date','$daihao','$app_name','{$arr['lei_id']}','{$pay_yao_uid}')";
        $res = Plug_Query($sql);
        if (!$res) {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('插入支付记录失败')));
        }

        $__GLOBAL__PAY__ = array($ail_id, $pay_beizhu, $shijia);
        $config_array = include($cfg_file);
        $pay_file = Plug_Get_Bsphp_Dir() . 'include/modules/payment/paycood/' . $lei_dir . '/' . $config_array['pay_config']['OpenFile'];
        if (file_exists($pay_file)) {
            include($pay_file);
        } else {
            echo Plug_Lang('支付接口不存在');
        }
    }

    /**
     * AJAX: 查询订单状态
     * 访问: index.php?m=webapi&c=salecard_renew&a=order_status
     * 参数: pay_id, daihao
     */
    function call_order_status()
    {
        $pay_id = Plug_Set_Data_Post_Get('pay_id');
        $daihao = (int)Plug_Set_Data_Post_Get('daihao');
        if ($daihao <= 0) {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('软件代号无效')));
        }
        if ($pay_id === '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入订单号')));
        }

        $info = $this->_query_order($pay_id, $daihao);
        if (!$info['ok']) {
            plug_print_json(array('code' => -1, 'msg' => $info['msg']));
        }

        plug_print_json(array(
            'code'   => 0,
            'pay_id' => $info['pay_id'],
            'status' => (int)$info['pay_zhuangtai'],
            'amount' => (float)$info['ka_shijia'],
            'time'   => $info['pay_date'],
            'title'  => $info['ali_ka_name'],
        ));
    }

    function _query_order($pay_id, $daihao)
    {
        $pay_id = preg_replace('/[^a-zA-Z0-9]/', '', $pay_id);
        if (strlen($pay_id) < 10) return array('ok' => false, 'msg' => Plug_Lang('订单号格式错误'));
        $sql = "SELECT pay_id,pay_date,pay_zhuangtai,ka_shijia,ali_ka_name,pay_daihao FROM `bs_php_pay_log` WHERE `pay_id`='{$pay_id}' AND `pay_daihao`='{$daihao}' LIMIT 1";
        $row = Plug_Query_Assoc($sql);
        if (!$row) return array('ok' => false, 'msg' => Plug_Lang('订单不存在'));
        return array(
            'ok' => true,
            'pay_id' => $row['pay_id'],
            'pay_date' => $row['pay_date'],
            'pay_zhuangtai' => (int)$row['pay_zhuangtai'],
            'ka_shijia' => $row['ka_shijia'],
            'ali_ka_name' => $row['ali_ka_name'],
        );
    }

    function _get_pay_channels()
    {
        $list = array();
        $path = defined('BSPHP_DIR_SYS') ? BSPHP_DIR_SYS : dirname(dirname(dirname(__DIR__))) . '/';
        $pay_path = $path . 'include/modules/payment/paycood';
        if (!is_dir($pay_path)) return $list;
        foreach (@scandir($pay_path) as $d) {
            if ($d === '.' || $d === '..') continue;
            $cfg = $pay_path . '/' . $d . '/form_config.php';
            if (!is_file($cfg)) continue;
            $cfg_arr = @include($cfg);
            if (empty($cfg_arr['pay_config']['dir'])) continue;
            $dir_name = $cfg_arr['pay_config']['dir'];
            if (Plug_Get_Configs_Value('pay_' . $dir_name, 'pay_' . $dir_name . '_set') === '1') continue;

            // 显示名称：优先用配置的 show_name，否则用内置友好名
            $nice = $dir_name;
            if (!empty($cfg_arr['pay_config']['show_name'])) {
                $nice = $cfg_arr['pay_config']['show_name'];
            }

            $item = array('dir' => $dir_name, 'name' => $nice);
            if (!empty($cfg_arr['pay_config']['url'])) {
                $item['url'] = $cfg_arr['pay_config']['url'];
            }
            $list[] = $item;
        }
        return $list;
    }
}
