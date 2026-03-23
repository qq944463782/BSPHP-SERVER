<?php
/**
 * 微信支付 V3 Native 扫码支付入口
 *
 * 由业务层通过 $__GLOBAL__PAY__ 传入：
 * [$pay_id, $pay_beizhu, $pay_amount]
 */

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

if (empty($__GLOBAL__PAY__) || count($__GLOBAL__PAY__) < 3) {
    exit('WxPay V3: 缺少支付参数');
}

list($pay_id, $pay_beizhu, $pay_amount) = $__GLOBAL__PAY__;

// 微信金额单位：分
$total_fee = (int)round($pay_amount * 100);
if ($total_fee <= 0) {
    exit('WxPay V3: 金额错误');
}

// 从系统配置读取微信参数
$mchid     = bs_lib::get_configs_value('pay_wxpayv3', 'pay_wxpayv3_mchid');
$appid     = bs_lib::get_configs_value('pay_wxpayv3', 'pay_wxpayv3_appid');
$apiv3_key = bs_lib::get_configs_value('pay_wxpayv3', 'pay_wxpayv3_apiv3_key');
$serial_no = bs_lib::get_configs_value('pay_wxpayv3', 'pay_wxpayv3_serial');
$key_conf  = bs_lib::get_configs_value('pay_wxpayv3', 'pay_wxpayv3_key_path');

if (!$mchid || !$appid || !$serial_no || !$key_conf || !$apiv3_key) {
    exit('WxPay V3: 参数未完整配置');
}

// 支持两种方式：
// 1) key_conf 为文件路径：存在则从文件读取
// 2) key_conf 为 PEM 内容：直接作为私钥使用
$merchant_private_key = '';
if (is_string($key_conf) && $key_conf !== '' && file_exists($key_conf)) {
    $merchant_private_key = file_get_contents($key_conf);
} else {
    $merchant_private_key = $key_conf;
}

if (!$merchant_private_key) {
    exit('WxPay V3: 未能获取商户私钥，请检查配置');
}

/**
 * 生成 V3 签名
 */
function wxv3_sign($method, $url_path, $body, $mchid, $serial_no, $merchant_private_key)
{
    $timestamp = time();
    $nonce_str = bin2hex(random_bytes(16));
    $body_str  = $body === '' ? '' : $body;
    $message   = strtoupper($method) . "\n" .
                 $url_path . "\n" .
                 $timestamp . "\n" .
                 $nonce_str . "\n" .
                 $body_str . "\n";

    $pkeyid = openssl_get_privatekey($merchant_private_key);
    if (!$pkeyid) {
        throw new Exception('加载私钥失败');
    }
    $signature = '';
    openssl_sign($message, $signature, $pkeyid, 'sha256WithRSAEncryption');
   // openssl_free_key($pkeyid);

    $signature_base64 = base64_encode($signature);

    $authorization = sprintf(
        'WECHATPAY2-SHA256-RSA2048 mchid=\"%s\",nonce_str=\"%s\",timestamp=\"%d\",serial_no=\"%s\",signature=\"%s\"',
        $mchid,
        $nonce_str,
        $timestamp,
        $serial_no,
        $signature_base64
    );

    return array($authorization, $timestamp, $nonce_str);
}

// 统一下单 Native
$notify_url = bs_lib::get_configs_value('sys', 'url') . 'Plug/payment/wxpayv3/notify.php';

$req_body_arr = array(
    'mchid'       => $mchid,
    'appid'       => $appid,
    'description' => $pay_beizhu,
    'out_trade_no'=> $pay_id,
    'notify_url'  => $notify_url,
    'amount'      => array(
        'total'    => $total_fee,
        'currency' => 'CNY',
    ),
);
$req_body = json_encode($req_body_arr, JSON_UNESCAPED_UNICODE);

$url_path = '/v3/pay/transactions/native';
try {
    list($authorization,) = wxv3_sign('POST', $url_path, $req_body, $mchid, $serial_no, $merchant_private_key);
} catch (Exception $e) {
    exit('WxPay V3: 签名失败 - ' . $e->getMessage());
}

$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL            => 'https://api.mch.weixin.qq.com' . $url_path,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => array(
        'Content-Type: application/json; charset=utf-8',
        'Accept: application/json',
        'User-Agent: bsphp-wechatpay-v3',
        'Authorization: ' . $authorization,
    ),
    CURLOPT_POSTFIELDS     => $req_body,
));
$resp = curl_exec($ch);
$curl_err = curl_error($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
////curl_close($ch);

if ($curl_err) {
    exit('WxPay V3: 请求失败 - ' . $curl_err);
}

$body = json_decode($resp, true);
if ($http_code !== 200 || empty($body['code_url'])) {
    exit('WxPay V3: 下单失败 - ' . htmlspecialchars($resp, ENT_QUOTES, 'UTF-8'));
}

$code_url = $body['code_url'];
$pay_title = htmlspecialchars($pay_beizhu, ENT_QUOTES, 'UTF-8');
$amount_yuan = number_format($pay_amount, 2);

// 输出简单扫码页面（可按需要美化）
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>微信支付</title>
    <style>
    body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"PingFang SC","Microsoft YaHei",sans-serif;background:#f3f4f6;color:#111827;}
    .wrap{max-width:420px;margin:40px auto;background:#fff;border-radius:16px;padding:24px;box-shadow:0 10px 30px rgba(15,23,42,.1);}
    .title{font-size:18px;font-weight:600;margin-bottom:8px;}
    .desc{font-size:14px;color:#6b7280;margin-bottom:6px;}
    .amount{font-size:26px;font-weight:700;color:#16a34a;margin:10px 0 14px;}
    .qrcode{margin-top:10px;text-align:center;}
    .tips{font-size:13px;color:#6b7280;margin-top:16px;line-height:1.6;}
    </style>
</head>
<body>
<div class="wrap">
    <div class="title">微信扫码支付</div>
    <div class="desc"><?= $pay_title ?></div>
    <div class="amount">¥<?= $amount_yuan ?></div>
    <div class="qrcode">
        <?php
        // 使用现有 phpqrcode 
        $qrcode_lib = __DIR__ . './phpqrcode.php';
        if (file_exists($qrcode_lib)) {
            require_once $qrcode_lib;
            QRcode::png($code_url, false, QR_ECLEVEL_M, 6, 1);
        } else {
            echo '<p>请使用微信扫描以下链接完成支付：</p>';
            echo '<div style="word-break:break-all;font-size:12px;">'.htmlspecialchars($code_url,ENT_QUOTES,'UTF-8').'</div>';
        }
        ?>
    </div>
    <div class="tips">
        请使用微信扫一扫完成支付。<br>
        支付完成后系统会自动为当前账号续费。
    </div>
</div>
</body>
</html>

