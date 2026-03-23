<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'buyvip',
    'name'  => '在线开通续费接口',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'buyvip', 'a' => 'index'),
    'params'=> array(
        array('name' => 'carid', 'label' => '卡类ID', 'tip' => '可选，不传则显示表单下拉选择', 'required' => false),
        array('name' => 'uid', 'label' => 'UID', 'tip' => '开通账户/卡模式卡号/机器码', 'required' => true),
        array('name' => 'u', 'label' => '邀请码', 'tip' => '推荐人账号/UID，用于提成', 'required' => false),
        array('name' => 'type', 'label' => '支付方式', 'defaultValue' => 'alipay', 'options' => array(
            array('value' => 'alipay', 'text' => 'alipay'),
            array('value' => 'weixin', 'text' => 'weixin')
        ))
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 在线开通续费接口 - 访问: index.php?m=webapi&c=buyvip&a=index
 */
class buyvip
{
    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
    }

    function call_index()
    {
        $carid = Plug_Set_Get('carid') ?: Plug_Set_Get('id');
        $uid = Plug_Set_Get('uid');
        $congid = $uid;
        $lei = Plug_Set_Get('type');

        // 邀请码 u：优先本次传参，其次 cookie
        $u = Plug_Set_Get('u');
        if ($u !== '') {
            setcookie('cookie_uid', $u, time() + 86400, '/');
        } elseif (!empty($_COOKIE['cookie_uid'])) {
            $u = $_COOKIE['cookie_uid'];
        }

        if ($lei == '') {
            echo Plug_Lang('[&type=]充值类型不存在,请输入支付类型,如:alipay|weixin');
            exit;
        }

        if ($uid == '') {
            echo Plug_Lang('[&uid=]充值对象不能空,请输入充值开通帐户/卡模式充值卡号/机器码');
            exit;
        }

        $sql = "SELECT*FROM`bs_php_kalei`WHERE`lei_id`='{$carid}'";
        $arr = Plug_Query_Assoc($sql);
        if (!$arr) {
            echo Plug_Lang('[&carid=]卡类不存在,请选择卡类或输入正确卡类ID ');
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

            if ($zhe > 0 and $zhe < 10) {
                $pay_zhe = $zhe;
                $zhe = $zhe / 10;
                $jiazhe = $zhe * $ka_jiage;
                $jia = $ka_jiage - $jiazhe;
                $jia = $jia * $param_shu;
                $shijia = $jiazhe * $param_shu;
            } else {
                $shijia = $arr['lei_jiage'];
                $zhe = 0;
                $jia = 0;
                $pay_zhe = 0;
            }

            $ka_date = $arr['lei_date'];
            $ka_name = $arr['lei_name'];
            $daihao = $arr['lei_daihao'];
        } else {
            $ka_date = $arr['lei_date'];
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

        $ka_kate = PLUG_DATE();
        $pay_qian_rmb = -1;
        $pay_rmb = -1;
        $pay_beizhu = Plug_Lang("{$app_name}") . Plug_Lang(" - 续费/开通服务") . Plug_Lang("{$ka_name}") . Plug_Lang("ID:") . $congid;

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

        $ail_id = 'BUYVIP' . date('YmdHis', PLUG_UNIX()) . rand(1000, 99999);  
        $sql = "INSERT INTO `bs_php_pay_log` (`pay_id`,`ali_id`,`pay_uid`,`pay_date`,`pay_qian_rmb`,`pay_rmb`,`pay_ka_shuliang`,`pay_zhuangtai`,`ka_shijia`,`ka_zhe_jia`,`ali_ka_name`,`ali_ka_jiage`,`ali_ka_zhe`,`ali_ka_date`,`pay_daihao`,`pay_app_name`,`pay_type`,`pay_yao_uid`) 
                VALUES('$ail_id',NULL,'$uid','$ka_kate','$pay_qian_rmb','$pay_rmb','1','0','$shijia','$jia','$pay_beizhu','$ka_jiage','$pay_zhe','$ka_date','$daihao','$app_name','{$arr['lei_id']}','{$pay_yao_uid}');";

        Plug_Query($sql);

        $pay_id = $ail_id;
        $pay_amount = $shijia;
        $pay_leixing = $lei;

        $__GLOBAL__PAY__ = array(
            $pay_id,
            $pay_beizhu,
            $pay_amount
        );

        $openfileconfig = Plug_Get_Bsphp_Dir() . 'include/modules/payment/paycood/' . $pay_leixing . '/form_config.php';

        if (!file_exists($openfileconfig))
            exit(Plug_alerts(Plug_Lang('Error:要引入支付文件不存在'), Plug_Lang('需要引入php脚步文件不存在。<BR/>文件路径:') . $openfileconfig));
        $config_array = include($openfileconfig);

        $openfileconfig = Plug_Get_Bsphp_Dir() . 'include/modules/payment/paycood/' . $pay_leixing . '/' . $config_array['pay_config']['OpenFile'];
        if (!file_exists($openfileconfig))
            exit(Plug_alerts(Plug_Lang('Error:要引入支付文件不存在'), Plug_Lang('需要引入php脚步文件不存在。<BR/>文件路径:') . $openfileconfig));

        include($openfileconfig);
    }
}
