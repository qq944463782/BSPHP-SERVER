<?php
/**
 * 微信支付 V3 JSAPI 异步通知处理
 *
 * 使用本通道独立配置 pay_wxpayv3js_apiv3_key 解密，与 wxpayv3 扫码通道完全独立。
 */

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$raw = file_get_contents('php://input');
if (!$raw) {
    http_response_code(400);
    exit('bad request');
}

$body = json_decode($raw, true);
if (!is_array($body) || empty($body['resource'])) {
    http_response_code(400);
    exit('bad resource');
}

$resource = $body['resource'];

// 本通道独立 APIv3 密钥
$apiv3_key = bs_lib::get_configs_value('pay_wxpayv3js', 'pay_wxpayv3js_apiv3_key');
if (!$apiv3_key) {
    http_response_code(500);
    exit('config error');
}

$ciphertext_base64 = $resource['ciphertext'];
$nonce_str         = $resource['nonce'];
$associated_data   = $resource['associated_data'];

$ciphertext = base64_decode($ciphertext_base64);
if ($ciphertext === false || strlen($ciphertext) < 16) {
    http_response_code(400);
    exit('cipher error');
}

$ct_len = strlen($ciphertext) - 16;
$ct     = substr($ciphertext, 0, $ct_len);
$tag    = substr($ciphertext, $ct_len);

$plaintext = openssl_decrypt(
    $ct,
    'aes-256-gcm',
    $apiv3_key,
    OPENSSL_RAW_DATA,
    $nonce_str,
    $tag,
    $associated_data
);

if ($plaintext === false) {
    http_response_code(500);
    echo json_encode(array('code' => 'FAIL', 'message' => 'DECRYPT_FAIL'));
    exit;
}

$pay = json_decode($plaintext, true);
if (!is_array($pay) || empty($pay['out_trade_no'])) {
    http_response_code(400);
    echo json_encode(array('code' => 'FAIL', 'message' => 'DATA_ERROR'));
    exit;
}

if ($pay['trade_state'] !== 'SUCCESS') {
    http_response_code(200);
    echo json_encode(array('code' => 'SUCCESS', 'message' => 'OK'));
    exit;
}

$out_trade_no = $pay['out_trade_no'];
$total        = isset($pay['amount']['total']) ? ($pay['amount']['total'] / 100) : -1;

$user_class = bs_lib::intelligence_load_modules_class('user','user');
$user_class->intelligence_PayInfp($out_trade_no, $total);

http_response_code(200);
echo json_encode(array('code' => 'SUCCESS', 'message' => 'OK'));
