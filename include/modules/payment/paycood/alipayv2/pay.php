<?php
/**
 * 支付宝开放平台 v2 扫码支付（alipay.trade.precreate）
 *
 * 由业务层通过 $__GLOBAL__PAY__ 传入：
 * [$pay_id, $pay_beizhu, $pay_amount]
 */

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

if (empty($__GLOBAL__PAY__) || count($__GLOBAL__PAY__) < 3) {
    exit('Alipay v2: 缺少支付参数');
}

list($pay_id, $pay_beizhu, $pay_amount) = $__GLOBAL__PAY__;

$total_amount = sprintf('%.2f', (float)$pay_amount);
if ((float)$total_amount <= 0) {
    exit('Alipay v2: 金额错误');
}

$app_id   = bs_lib::get_configs_value('pay_alipayv2', 'pay_alipayv2_appid');
$key_conf = bs_lib::get_configs_value('pay_alipayv2', 'pay_alipayv2_private_key');

if (!$app_id || !$key_conf) {
    exit('Alipay v2: 请先配置 AppID 与应用私钥');
}

// 私钥：支持文件路径或 PEM 内容
$private_key = $key_conf;
if (is_string($key_conf) && $key_conf !== '' && file_exists(trim($key_conf))) {
    $private_key = file_get_contents(trim($key_conf));
}
if (!$private_key) {
    exit('Alipay v2: 未能获取应用私钥');
}

$sys_url = bs_lib::get_configs_value('sys', 'url');
$notify_url = $sys_url . 'Plug/payment/alipayv2/notify.php';

$biz_content = json_encode(array(
    'out_trade_no' => $pay_id,
    'total_amount' => $total_amount,
    'subject'      => $pay_beizhu,
), JSON_UNESCAPED_UNICODE);

$params = array(
    'app_id'      => $app_id,
    'method'      => 'alipay.trade.precreate',
    'format'      => 'JSON',
    'charset'     => 'utf-8',
    'sign_type'   => 'RSA2',
    'timestamp'   => date('Y-m-d H:i:s'),
    'version'     => '1.0',
    'notify_url'  => $notify_url,
    'biz_content' => $biz_content,
);

/**
 * 支付宝 RSA2 签名字符串：参数按 key 排序，key=value&，空值不参与
 */
function alipayv2_sign_string($params) {
    ksort($params);
    $parts = array();
    foreach ($params as $k => $v) {
        if ($k === 'sign' || $v === '' || $v === null) continue;
        $parts[] = $k . '=' . $v;
    }
    return implode('&', $parts);
}

/**
 * RSA2 签名
 */
function alipayv2_sign($params, $private_key_pem) {
    $str = alipayv2_sign_string($params);
    $key = openssl_get_privatekey($private_key_pem);
    if (!$key) return null;
    $sign = '';
    openssl_sign($str, $sign, $key, OPENSSL_ALGO_SHA256);
    openssl_free_key($key);
    return base64_encode($sign);
}

$params['sign'] = alipayv2_sign($params, $private_key);
if (!$params['sign']) {
    exit('Alipay v2: 签名失败，请检查私钥格式');
}

$gateway = 'https://openapi.alipay.com/gateway.do';
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL            => $gateway,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $params,
));
$resp = curl_exec($ch);
$err = curl_error($ch);
//curl_close($ch);

if ($err) {
    exit('Alipay v2: 请求失败 - ' . $err);
}

$json = json_decode($resp, true);
$response = isset($json['alipay_trade_precreate_response']) ? $json['alipay_trade_precreate_response'] : array();
$code = isset($response['code']) ? $response['code'] : '';
$qr_code = isset($response['qr_code']) ? $response['qr_code'] : '';

if ($code !== '10000' || $qr_code === '') {
    $sub_msg = isset($response['sub_msg']) ? $response['sub_msg'] : '';
    exit('Alipay v2: 下单失败 ' . $code . ' ' . $sub_msg);
}

$pay_title = htmlspecialchars($pay_beizhu, ENT_QUOTES, 'UTF-8');
$amount_yuan = number_format($pay_amount, 2);

$qrcode_lib = dirname(__DIR__) . '/wxpayv3/phpqrcode.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>支付宝扫码支付</title>
    <style>
    body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"PingFang SC","Microsoft YaHei",sans-serif;background:#f3f4f6;color:#111827;}
    .wrap{max-width:420px;margin:40px auto;background:#fff;border-radius:16px;padding:24px;box-shadow:0 10px 30px rgba(15,23,42,.1);}
    .title{font-size:18px;font-weight:600;margin-bottom:8px;}
    .desc{font-size:14px;color:#6b7280;margin-bottom:6px;}
    .amount{font-size:26px;font-weight:700;color:#1677ff;margin:10px 0 14px;}
    .qrcode{margin-top:10px;text-align:center;}
    .tips{font-size:13px;color:#6b7280;margin-top:16px;line-height:1.6;}
    </style>
</head>
<body>
<div class="wrap">
    <div class="title">支付宝扫码支付</div>
    <div class="desc"><?php echo $pay_title; ?></div>
    <div class="amount">¥<?php echo $amount_yuan; ?></div>
    <div class="qrcode">
        <?php
        if (file_exists($qrcode_lib)) {
            require_once $qrcode_lib;
            QRcode::png($qr_code, false, QR_ECLEVEL_M, 6, 1);
        } else {
            echo '<p>请使用支付宝扫一扫完成支付：</p>';
            echo '<div style="word-break:break-all;font-size:12px;">' . htmlspecialchars($qr_code, ENT_QUOTES, 'UTF-8') . '</div>';
        }
        ?>
    </div>
    <div class="tips">
        请使用支付宝扫一扫完成支付。<br>
        支付完成后系统会自动为当前账号续费。
    </div>
</div>
</body>
</html>
