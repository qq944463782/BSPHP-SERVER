<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>支付宝确认发货接口接口</title>
</head>
<?php
const BSPHP_SET='NOTMODE';
require_once ('../../LibBsphp/Global.Bsphp.Inc.php');
$id=$_GET['id'];
require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");
$trade_no=$id;
$logistics_name='BsphpCms';
$invoice_no='10010';
$transport_type='EXPRESS';
$parameter=array(
"service"=> "send_goods_confirm_by_platform",
"partner"=> trim($alipay_config['partner']),
"trade_no"	=> $trade_no,
"logistics_name"	=> $logistics_name,
"invoice_no"	=> $invoice_no,
"transport_type"	=> $transport_type,
"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);
$alipaySubmit=new AlipaySubmit($alipay_config);
$html_text=$alipaySubmit->buildRequestHttp($parameter);
$doc=new DOMDocument();
$doc->loadXML($html_text);
if( ! empty($doc->getElementsByTagName( "alipay" )->item(0)->nodeValue) ) {
$alipay=$doc->getElementsByTagName( "alipay" )->item(0)->nodeValue;
ECHO '尊敬用户!你充值金额已经冻结,你还需要到支付宝确当前订单《确认收货》才可以完成本次充值,支付宝地址:www.zhifbao.com <BR/>谢谢你的支持<BR/>';
}else{
echo 'bad not pay <BR/>内容信息:';
print_R($doc);
}
?>
</body>
</html>