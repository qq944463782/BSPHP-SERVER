<?php
/**
 * 微信支付 V3 JSAPI（微信内支付）配置
 *
 * 与 wxpayv3（扫码）完全独立：本通道使用 pay_wxpayv3js_* 全部参数，
 * 便于与扫码渠道使用不同商户号/公众号时分别配置。
 */
return array(
    // 基础配置
    'pay_config' => array(
        'label'   => '微信内支付:',
        'OpenFile'=> 'pay.php',   // 入口文件（同目录）
        'dir'     => 'wxpayv3js', // 目录名 & 英文别名
        'name'    => 'wxpayv3js',
        'type'    => '-1',
        'show_name' => '微信内支付',
        'url'     => Plug_Get_Configs_Value('sys','url') . 'statics/payment/imges/wx.png',
        'info'    => '微信内 JSAPI 支付，仅在微信环境内显示',
    ),

    // 是否启用
    'pay_wxpayv3js_set' => array(
        'label'  => '是否启用:',
        'type'   => 'radio',
        'values' => array('0' => '开启', '1' => '关闭'),
        'info'   => '是否开启微信内 JSAPI 支付',
    ),

    // 本通道独立参数（与 wxpayv3 扫码通道无关，可配置不同商户/公众号）
    'pay_wxpayv3js_mchid' => array(
        'label'  => '商户号 MchID:',
        'type'   => 'text',
        'values' => '',
        'size'   => '40',
        'info'   => '本通道使用的微信支付商户号',
    ),

    'pay_wxpayv3js_appid' => array(
        'label'  => 'AppID:',
        'type'   => 'text',
        'values' => '',
        'size'   => '40',
        'info'   => '本通道公众号/小程序 AppID（用于 OAuth 获取 openid）',
    ),

    'pay_wxpayv3js_appsecret' => array(
        'label'  => 'AppSecret:',
        'type'   => 'text',
        'values' => '',
        'size'   => '50',
        'info'   => '本通道公众号/小程序 AppSecret，用于 JSAPI 授权',
    ),

    'pay_wxpayv3js_apiv3_key' => array(
        'label'  => 'APIv3 密钥:',
        'type'   => 'text',
        'values' => '',
        'size'   => '60',
        'info'   => '本通道商户平台 APIv3 密钥，用于支付结果通知解密',
    ),

    'pay_wxpayv3js_serial' => array(
        'label'  => '证书序列号:',
        'type'   => 'text',
        'values' => '',
        'size'   => '40',
        'info'   => '本通道商户 API 证书序列号',
    ),

    'pay_wxpayv3js_key_path' => array(
        'label'  => '商户私钥(PEM):',
        'type'   => 'textarea',
        'values' => '',
        'info'   => "建议直接粘贴私钥 PEM 内容（以 -----BEGIN PRIVATE KEY----- 开头）\n如需使用文件，可填写绝对路径，系统会优先判断路径是否存在",
    ),

    'pay_post_config' => array(
        'label'  => '保存修改:',
        'type'   => 'submit',
        'values' => '保存修改',
    ),
);

