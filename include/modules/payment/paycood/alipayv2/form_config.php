<?php
/**
 * 支付宝开放平台 v2（统一收单·扫码）配置
 * 使用 alipay.trade.precreate 生成付款二维码
 */
return array(
    'pay_config' => array(
        'label'     => '支付宝扫码(v2):',
        'OpenFile'  => 'pay.php',
        'dir'       => 'alipayv2',
        'name'      => 'alipayv2',
        'type'      => '-1',
        'show_name' => '支付宝扫码支付',
        'url'       => Plug_Get_Configs_Value('sys', 'url') . 'statics/payment/imges/alipay.jpg',
        'info'      => '支付宝开放平台 v2 接口，扫码支付（alipay.trade.precreate）',
    ),

    'pay_alipayv2_set' => array(
        'label'  => '是否启用:',
        'type'   => 'radio',
        'values' => array('0' => '开启', '1' => '关闭'),
        'info'   => '是否开启支付宝 v2 扫码支付',
    ),

    'pay_alipayv2_appid' => array(
        'label'  => '应用 AppID:',
        'type'   => 'text',
        'values' => '',
        'size'   => '40',
        'info'   => '支付宝开放平台创建应用后获得的 AppID',
    ),

    'pay_alipayv2_private_key' => array(
        'label'  => '应用私钥(PEM):',
        'type'   => 'textarea',
        'values' => '',
        'info'   => "应用私钥 PEM 内容（-----BEGIN RSA PRIVATE KEY----- 或 -----BEGIN PRIVATE KEY----- 开头）\n可粘贴内容或填写证书文件绝对路径",
    ),

    'pay_alipayv2_public_key' => array(
        'label'  => '支付宝公钥:',
        'type'   => 'textarea',
        'values' => '',
        'info'   => '支付宝公钥（用于异步通知验签），开放平台「开发信息」中获取',
    ),

    'pay_post_config' => array(
        'label'  => '保存修改:',
        'type'   => 'submit',
        'values' => '保存修改',
    ),
);
