<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'salecard_gencard',
    'name'  => '销售卡2-WEB页面制卡卖卡(购买即生成卡密)',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'salecard_gencard', 'a' => 'index'),
    'params'=> array(
        array('name' => 'daihao', 'label' => '软件代号', 'required' => true),
        array('name' => 'carid', 'label' => '卡类ID', 'required' => false),
        array('name' => 'type', 'label' => '支付方式', 'required' => false),
        array('name' => 'order', 'label' => '订单号', 'tip' => '支付成功后查询卡密'),
        array('name' => 'u', 'label' => '邀请码', 'tip' => '推荐人账号/UID，用于提成', 'required' => false),
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 销售卡2 - WEB页面制卡卖卡(购买即生成卡密)
 */
class salecard_gencard
{
    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
    }

    /**
     * 全部软件列表页 - 销售卡2 制卡卖卡入口聚合
     * 访问: index.php?m=webapi&c=salecard_gencard&a=list
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
        $carid = Plug_Set_Get('carid') ?: Plug_Set_Post('carid');
        $type = Plug_Set_Get('type') ?: Plug_Set_Post('type');
        $order_no = trim(Plug_Set_Get('order') ?: Plug_Set_Post('order'));

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
                $sql = "SELECT `news_id`,`news_table`,`news_unix` FROM `bs_php_news` WHERE `news_daihao`='{$daihao}' ORDER BY `news_id` DESC LIMIT 50";
                $res = Plug_Query($sql);
                while ($row = Plug_Pdo_Fetch_Assoc($res)) {
                    $news_list[] = $row;
                }
            }
        }

        $order_result = null;
        if ($order_no && $daihao > 0) {
            $order_result = $this->_query_order($order_no, $daihao);
        }

        include Plug_Load_Default_Path();
    }

    /**
     * 支付入口：创建订单并跳转支付
     */
    function call_do_pay()
    {
        $daihao = (int)Plug_Get_Url_Param('daihao');
        $carid = Plug_Get_Url_Param('carid');
        $lei_dir = Plug_Get_Url_Param('type');
        $shuliang = (int)Plug_Get_Url_Param('shuliang');
        $is_ok = Plug_Get_Url_Param('is_ok');
        // 邀请码/推荐人：URL 优先，其次 cookie
        $u = Plug_Get_Url_Param('u'); // 邀请码/推荐人
        if ($u === '' && !empty($_COOKIE['cookie_uid'])) {
            $u = $_COOKIE['cookie_uid'];
        }
        if ($shuliang < 1) $shuliang = 1;
        if ($shuliang > 99) $shuliang = 99;

        if ($daihao <= 0) {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('软件代号无效')));
            return;
        }
        $sql = "SELECT * FROM `bs_php_kalei` WHERE `lei_id`='{$carid}' AND `lei_daihao`='{$daihao}' LIMIT 1";
        $arr = Plug_Query_Assoc($sql);
        if (!$arr) {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('卡类不存在') . '(' . $carid . ')'));
            return;
        }
        if ($arr['lei_jiage'] < 0) {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('当前卡类已下架')));
            return;
        }
        $sql = "SELECT * FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1";
        $appinfo = Plug_Query_Assoc($sql);
        if (!$appinfo) {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('软件不存在')));
            return;
        }
        $app_name = $appinfo['app_name'];
        $shijia = $arr['lei_jiage'];
        $zongjia = $shijia * $shuliang;

        if ($is_ok == 9999) {
            plug_print_json(array('code' => 9999, 'msg' => Plug_Lang('验证成功')));
            return;
        }

        $pay_beizhu = Plug_Lang("{$app_name}") . Plug_Lang(" - 购买卡类 ") . Plug_Lang("{$arr['lei_name']}");
        if ($shuliang > 1) {
            $pay_beizhu .= ' x' . $shuliang;
        }
        $ail_id = 'SALEGEN' . date('YmdHis', PLUG_UNIX()) . rand(1000, 99999);
        $ka_kate = PLUG_DATE();

        $lei_dir = ($lei_dir === 'weixin') ? 'wxpay' : $lei_dir;
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
                VALUES('$ail_id','0','$ka_kate','-1','-1','$shuliang','0','$zongjia','0','$pay_beizhu','{$arr['lei_jiage']}','0','{$arr['lei_date']}','$daihao','$app_name','{$arr['lei_id']}','{$pay_yao_uid}')";
        $res = Plug_Query($sql);
        if (!$res) {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('插入支付记录失败')));
            return;
        }

        $__GLOBAL__PAY__ = array($ail_id, $pay_beizhu, $zongjia);
        $config_array = include($cfg_file);
        $pay_file = Plug_Get_Bsphp_Dir() . 'include/modules/payment/paycood/' . $lei_dir . '/' . $config_array['pay_config']['OpenFile'];
        if (file_exists($pay_file)) {
            include($pay_file);
        } else {
            echo Plug_Lang('支付接口不存在');
        }
    }

    /**
     * AJAX: 查询订单状态（是否已支付、是否已发卡）
     */
    function call_order_status()
    {
        $pay_id = Plug_Set_Data_Post_Get('pay_id');
        $daihao = (int)Plug_Set_Data_Post_Get('daihao');
        if ($daihao <= 0) {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('软件代号无效')));
            return;
        }
        if ($pay_id === '') {
            plug_print_json(array('code' => -1, 'msg' => Plug_Lang('请输入订单号')));
            return;
        }

        $info = $this->_query_order($pay_id, $daihao);
        if (!$info['ok']) {
            plug_print_json(array('code' => -1, 'msg' => $info['msg']));
            return;
        }

        $cards = $this->_get_cards_by_order($pay_id);
        $first = !empty($cards) ? $cards[0] : null;
        plug_print_json(array(
            'code'       => 0,
            'pay_id'     => $info['pay_id'],
            'status'     => (int)$info['pay_zhuangtai'],
            'amount'     => (float)$info['ka_shijia'],
            'quantity'   => isset($info['pay_ka_shuliang']) ? (int)$info['pay_ka_shuliang'] : 1,
            'time'       => $info['pay_date'],
            'title'      => $info['ali_ka_name'],
            'has_card'   => !empty($cards),
            'card'       => $first,
            'cards'      => $cards,
        ));
    }

    /**
     * 根据订单号查询已生成的卡密列表（支持多张）
     */
    function _get_cards_by_order($order)
    {
        $order = preg_replace('/[^a-zA-Z0-9]/', '', $order);
        if (strlen($order) < 10) return array();
        $sql = "SELECT c.`car_name`,c.`car_pwd`,c.`car_reDATE`,c.`car_TianShu`,k.`lei_name` 
                FROM `bs_php_cardseries` c 
                LEFT JOIN `bs_php_kalei` k ON c.`car_Lei`=k.`lei_id` 
                WHERE c.`car_admin`='{$order}' ORDER BY c.`car_id` ASC";
        $list = array();
        $res = Plug_Query($sql);
        if ($res) {
            while ($row = Plug_Pdo_Fetch_Assoc($res)) {
                $list[] = $row;
            }
        }
        return $list;
    }

    /**
     * 根据订单号查询已生成的卡密（单张，兼容旧逻辑）
     */
    function _get_card_by_order($order)
    {
        $cards = $this->_get_cards_by_order($order);
        return !empty($cards) ? $cards[0] : null;
    }

    /**
     * 单独页面：仅展示卡密（订单号正确且已支付时）
     */
    function call_show_card()
    {
        $order = trim(Plug_Set_Get('order') ?: Plug_Set_Post('order'));
        if (!$order) {
            echo Plug_Lang('请提供订单号');
            exit;
        }
        $this->_query_card($order);
    }

    function _query_card($order)
    {
        $order = preg_replace('/[^a-zA-Z0-9]/', '', $order);
        if (strlen($order) < 10 || substr($order, 0, 7) !== 'SALEGEN') {
            echo Plug_Lang('订单号格式错误，请使用SALEGEN开头订单号');
            exit;
        }
        $cards = $this->_get_cards_by_order($order);
        if (empty($cards)) {
            $sql = "SELECT * FROM `bs_php_pay_log` WHERE `pay_id`='{$order}' AND `pay_zhuangtai`=1 LIMIT 1";
            $pl = Plug_Query_Assoc($sql);
            if ($pl) {
                echo Plug_Lang('订单已支付完成，卡密生成中或已发放。若未收到请联系客服，订单号：') . htmlspecialchars($order);
            } else {
                echo Plug_Lang('订单不存在或未支付');
            }
            exit;
        }
        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>' . Plug_Lang('卡密查询') . '</title></head><body>';
        echo '<h3>' . Plug_Lang('卡密信息') . '</h3>';
        if (count($cards) > 1) {
            echo '<p>' . Plug_Lang('共') . count($cards) . Plug_Lang('张卡') . '</p>';
        }
        foreach ($cards as $i => $row) {
            if (count($cards) > 1) {
                echo '<hr><p><strong>' . Plug_Lang('第') . ($i + 1) . Plug_Lang('张') . '</strong></p>';
            }
            echo '<p><strong>' . Plug_Lang('卡号') . ':</strong> ' . htmlspecialchars($row['car_name']) . '</p>';
            echo '<p><strong>' . Plug_Lang('卡密') . ':</strong> ' . htmlspecialchars($row['car_pwd']) . '</p>';
            echo '<p><strong>' . Plug_Lang('套餐') . ':</strong> ' . htmlspecialchars($row['lei_name'] ?? '') . '</p>';
            echo '<p><strong>' . Plug_Lang('到期') . ':</strong> ' . htmlspecialchars($row['car_reDATE']) . '</p>';
        }
        echo '</body></html>';
    }

    function _query_order($pay_id, $daihao)
    {
        $pay_id = preg_replace('/[^a-zA-Z0-9]/', '', $pay_id);
        if (strlen($pay_id) < 10) return array('ok' => false, 'msg' => Plug_Lang('订单号格式错误'));
        $sql = "SELECT pay_id,pay_date,pay_zhuangtai,ka_shijia,ali_ka_name,pay_daihao,pay_ka_shuliang FROM `bs_php_pay_log` WHERE `pay_id`='{$pay_id}' AND `pay_daihao`='{$daihao}' LIMIT 1";
        $row = Plug_Query_Assoc($sql);
        if (!$row) return array('ok' => false, 'msg' => Plug_Lang('订单不存在'));
        return array(
            'ok' => true,
            'pay_id' => $row['pay_id'],
            'pay_date' => $row['pay_date'],
            'pay_zhuangtai' => (int)$row['pay_zhuangtai'],
            'ka_shijia' => $row['ka_shijia'],
            'ali_ka_name' => $row['ali_ka_name'],
            'pay_ka_shuliang' => isset($row['pay_ka_shuliang']) ? (int)$row['pay_ka_shuliang'] : 1,
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
            $nice = (!empty($cfg_arr['pay_config']['show_name'])) ? $cfg_arr['pay_config']['show_name'] : $dir_name;
            $item = array('dir' => $dir_name, 'name' => $nice);
            if (!empty($cfg_arr['pay_config']['url'])) {
                $item['url'] = $cfg_arr['pay_config']['url'];
            }
            $list[] = $item;
        }
        return $list;
    }
}
