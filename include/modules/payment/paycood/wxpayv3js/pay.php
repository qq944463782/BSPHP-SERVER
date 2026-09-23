<?php
/**
 * 微信支付 V3 JSAPI（微信内支付）入口
 *
 * 流程：
 *  1. 检查是否在微信内打开。
 *  2. 无 code 时，跳转到微信 OAuth2 获取 code（静默 snsapi_base）。
 *  3. 用 code 换取 openid。
 *  4. 调用 V3 JSAPI 下单接口，获取 prepay_id。
 *  5. 生成前端 WeixinJSBridge 所需参数，直接输出一个页面，点击按钮拉起微信支付。
 *  6. 支付成功后，微信会回调 wxpayv3 的 notify.php，系统通过 intelligence_PayInfp 完成续费。
 */

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

if (empty($__GLOBAL__PAY__) || count($__GLOBAL__PAY__) < 3) {
    exit('WxPay JSAPI: 缺少支付参数');
}

list($pay_id, $pay_beizhu, $pay_amount) = $__GLOBAL__PAY__;

// 必须在微信内
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
if (strpos($ua, 'MicroMessenger') === false) {
    exit('请在微信内打开使用微信内支付(JSAPI)。');
}

// 本通道独立参数（与 wxpayv3 无关，可配置不同商户/公众号）
$appid_js   = bs_lib::get_configs_value('pay_wxpayv3js', 'pay_wxpayv3js_appid');
$secret_js  = bs_lib::get_configs_value('pay_wxpayv3js', 'pay_wxpayv3js_appsecret');
$mchid      = bs_lib::get_configs_value('pay_wxpayv3js', 'pay_wxpayv3js_mchid');
$serial_no  = bs_lib::get_configs_value('pay_wxpayv3js', 'pay_wxpayv3js_serial');
$key_conf   = bs_lib::get_configs_value('pay_wxpayv3js', 'pay_wxpayv3js_key_path');

if (!$appid_js || !$secret_js || !$mchid || !$serial_no || !$key_conf) {
    exit('WxPay JSAPI: 请在本通道(微信支付·V3(JSAPI))中完整配置所有参数');
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
    exit('WxPay JSAPI: 未能获取商户私钥，请检查配置');
}

// 统一金额单位：分
$total_fee = (int)round($pay_amount * 100);
if ($total_fee <= 0) {
    exit('WxPay JSAPI: 金额错误');
}

// 当前 URL，用于 OAuth 回调
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
$uri    = $_SERVER['REQUEST_URI'] ?? '';
$current_url = $scheme . '://' . $host . $uri;

/**
 * 获取 openid：如果没有 code，则跳转到微信 OAuth 获取
 */
if (empty($_GET['code'])) {
    $redirect_uri = urlencode($current_url);
    $state = 'wxjs';
    $oauth_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid_js}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state={$state}#wechat_redirect";
    header('Location: ' . $oauth_url);
    exit;
}

$code = $_GET['code'];
$token_api = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid_js}&secret={$secret_js}&code={$code}&grant_type=authorization_code";
$token_resp = @file_get_contents($token_api);
$token_arr = $token_resp ? json_decode($token_resp, true) : null;

if (!$token_arr || empty($token_arr['openid'])) {
    exit('WxPay JSAPI: 获取 openid 失败');
}

$openid = $token_arr['openid'];

/**
 * 签名工具：V3 HTTP 签名 & JSAPI paySign
 */
function wxv3_sign_http($method, $url_path, $body, $mchid, $serial_no, $merchant_private_key)
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

    return array($authorization);
}

function wxv3_build_jsapi_params($appid, $prepay_id, $merchant_private_key)
{
    $timeStamp = (string)time();
    $nonceStr  = bin2hex(random_bytes(16));
    $package   = 'prepay_id=' . $prepay_id;

    $message = $appid . "\n" .
               $timeStamp . "\n" .
               $nonceStr . "\n" .
               $package . "\n";

    $pkeyid = openssl_get_privatekey($merchant_private_key);
    if (!$pkeyid) {
        throw new Exception('加载私钥失败');
    }
    $signature = '';
    openssl_sign($message, $signature, $pkeyid, 'sha256WithRSAEncryption');
   // openssl_free_key($pkeyid);

    $paySign = base64_encode($signature);

    return array(
        'appId'     => $appid,
        'timeStamp' => $timeStamp,
        'nonceStr'  => $nonceStr,
        'package'   => $package,
        'signType'  => 'RSA',
        'paySign'   => $paySign,
    );
}

// JSAPI 统一下单，回调使用本通道独立 notify（便于不同渠道独立解密）
$notify_url = bs_lib::get_configs_value('sys', 'url') . 'Plug/payment/wxpayv3js/notify.php';

$req_body_arr = array(
    'mchid'       => $mchid,
    'appid'       => $appid_js,
    'description' => $pay_beizhu,
    'out_trade_no'=> $pay_id,
    'notify_url'  => $notify_url,
    'amount'      => array(
        'total'    => $total_fee,
        'currency' => 'CNY',
    ),
    'payer'       => array(
        'openid' => $openid,
    ),
);
$req_body = json_encode($req_body_arr, JSON_UNESCAPED_UNICODE);
$url_path = '/v3/pay/transactions/jsapi';

try {
    list($authorization) = wxv3_sign_http('POST', $url_path, $req_body, $mchid, $serial_no, $merchant_private_key);
} catch (Exception $e) {
    exit('WxPay JSAPI: 签名失败 - ' . $e->getMessage());
}

$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL            => 'https://api.mch.weixin.qq.com' . $url_path,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => array(
        'Content-Type: application/json; charset=utf-8',
        'Accept: application/json',
        'User-Agent: bsphp-wechatpay-v3-jsapi',
        'Authorization: ' . $authorization,
    ),
    CURLOPT_POSTFIELDS     => $req_body,
));
$resp = curl_exec($ch);
$curl_err = curl_error($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
////curl_close($ch);

if ($curl_err) {
    exit('WxPay JSAPI: 请求失败 - ' . $curl_err);
}

$body = json_decode($resp, true);
if ($http_code !== 200 || empty($body['prepay_id'])) {
    exit('WxPay JSAPI: 下单失败 - ' . htmlspecialchars($resp, ENT_QUOTES, 'UTF-8'));
}

$prepay_id = $body['prepay_id'];

try {
    $jsapi_params = wxv3_build_jsapi_params($appid_js, $prepay_id, $merchant_private_key);
} catch (Exception $e) {
    exit('WxPay JSAPI: 构造前端参数失败 - ' . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>微信内支付</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <style>
    body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"PingFang SC","Microsoft YaHei",sans-serif;background:#f3f4f6;color:#111827;}
    .wrap{max-width:420px;margin:40px auto;background:#fff;border-radius:16px;padding:24px;box-shadow:0 10px 30px rgba(15,23,42,.1);}
    .title{font-size:18px;font-weight:600;margin-bottom:10px;}
    .desc{font-size:14px;color:#6b7280;margin-bottom:8px;line-height:1.6;}
    .amount{font-size:24px;font-weight:700;color:#16a34a;margin:10px 0 16px;}
    .btn{width:100%;height:46px;border:none;border-radius:999px;background:#22c55e;color:#fff;font-size:16px;font-weight:600;cursor:pointer;}
    .btn:active{opacity:.9;}
    .tips{font-size:12px;color:#9ca3af;margin-top:10px;line-height:1.7;}
    </style>
    <script>
    function onWeixinPay(){
      function jsApiCall(){
        WeixinJSBridge.invoke(
          'getBrandWCPayRequest',
          <?= json_encode($jsapi_params, JSON_UNESCAPED_UNICODE) ?>,
          function(res){
            // 这里不再强依赖返回结果，最终以服务器异步通知为准
            if(res.err_msg === 'get_brand_wcpay_request:ok'){
              alert('支付成功，系统将自动为您续费。');
            }else if(res.err_msg === 'get_brand_wcpay_request:cancel'){
              alert('已取消支付');
            }else{
              alert('支付失败或未完成，请稍后再试。');
            }
          }
        );
      }
      if (typeof WeixinJSBridge === 'undefined'){
        if( document.addEventListener ){
          document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        }else if (document.attachEvent){
          document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
          document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        }
      }else{
        jsApiCall();
      }
    }
    </script>
</head>
<body>
<div class="wrap">
    <div class="title">微信内支付(JSAPI)</div>
    <div class="desc"><?= htmlspecialchars($pay_beizhu ?? '', ENT_QUOTES, 'UTF-8') ?></div>
    <div class="amount">¥<?= number_format($pay_amount ?? 0, 2) ?></div>
    <button class="btn" type="button" onclick="onWeixinPay()">立即支付</button>
    <div class="tips">
        支付完成后，请稍等片刻，系统会根据微信回调自动为您续费。<br>
        若长时间未到账，可在“订单查询”中输入订单号 <?= htmlspecialchars($pay_id, ENT_QUOTES, 'UTF-8') ?> 查看状态。
    </div>
</div>
</body>
</html>

