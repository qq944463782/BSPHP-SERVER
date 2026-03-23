<?php
/**
 * 支付宝开放平台 v2 异步通知处理
 *
 * 验签通过且 trade_status=TRADE_SUCCESS 时调用 intelligence_PayInfp 完成续费
 */

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$params = $_POST;
if (empty($params)) {
    $params = $_GET;
}
if (empty($params) || empty($params['sign']) || empty($params['sign_type'])) {
    exit('fail');
}

$sign = $params['sign'];
$sign_type = $params['sign_type'];
$trade_status = isset($params['trade_status']) ? $params['trade_status'] : '';
$out_trade_no = isset($params['out_trade_no']) ? $params['out_trade_no'] : '';
$total_amount = isset($params['total_amount']) ? (float)$params['total_amount'] : -1;

if (strtoupper($sign_type) !== 'RSA2') {
    exit('fail');
}

$alipay_public_key = bs_lib::get_configs_value('pay_alipayv2', 'pay_alipayv2_public_key');
if (!$alipay_public_key) {
    exit('fail');
}

// 支持公钥为文件路径
if (is_string($alipay_public_key) && file_exists(trim($alipay_public_key))) {
    $alipay_public_key = file_get_contents(trim($alipay_public_key));
}

// 验签：除去 sign、sign_type，其余参数按 key 排序后拼接
unset($params['sign'], $params['sign_type']);
ksort($params);
$parts = array();
foreach ($params as $k => $v) {
    if ($v === '' || $v === null) continue;
    $parts[] = $k . '=' . $v;
}
$sign_str = implode('&', $parts);

$pub_key = openssl_get_publickey($alipay_public_key);
if (!$pub_key) {
    exit('fail');
}
$ok = openssl_verify($sign_str, base64_decode($sign), $pub_key, OPENSSL_ALGO_SHA256);
openssl_free_key($pub_key);

if ($ok !== 1) {
    exit('fail');
}

if ($trade_status !== 'TRADE_SUCCESS' && $trade_status !== 'TRADE_FINISHED') {
    echo 'success';
    exit;
}

if ($out_trade_no === '') {
    echo 'success';
    exit;
}

$user_class = bs_lib::intelligence_load_modules_class('user', 'user');
$user_class->intelligence_PayInfp($out_trade_no, $total_amount);

echo 'success';
