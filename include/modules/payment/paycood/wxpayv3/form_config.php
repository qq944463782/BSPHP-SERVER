<?php
/**
 * 微信支付 V3（Native 扫码）配置
 */
return array(
    // 基础配置（固定字段）
    'pay_config' => array(
        'label'   => '微信扫码支付:',
        'OpenFile'=> 'pay.php',  // 入口文件
        'dir'     => 'wxpayv3',  // 目录名 & 英文别名
        'name'    => 'wxpayv3',
        'type'    => '-1',
        'show_name' => '微信扫码支付',
        'url'     => Plug_Get_Configs_Value('sys', 'url') . 'statics/payment/imges/wx.png',
        'info'    => '微信支付 APIv3，Native 扫码支付',
    ),

    // 是否启用
    'pay_wxpayv3_set' => array(
        'label'  => '是否启用:',
        'type'   => 'radio',
        'values' => array('0' => '开启', '1' => '关闭'),
        'info'   => '是否开启微信支付 V3',
    ),

    // 支付模式
    'pay_wxpayv3_mode' => array(
        'label'  => '支付模式:',
        'type'   => 'radio',
        'values' => array(
            'native' => '扫码(Native)',
        ),
        'info'   => '当前仅实现 Native 扫码',
    ),

    // 必填参数
    'pay_wxpayv3_mchid' => array(
        'label'  => '商户号 MchID:',
        'type'   => 'text',
        'values' => '',
        'size'   => '40',
        'info'   => '微信支付商户号（MchID），商户平台可查看',
    ),

    'pay_wxpayv3_appid' => array(
        'label'  => 'AppID:',
        'type'   => 'text',
        'values' => '',
        'size'   => '40',
        'info'   => '公众号或小程序的 AppID',
    ),

    'pay_wxpayv3_apiv3_key' => array(
        'label'  => 'APIv3 密钥:',
        'type'   => 'text',
        'values' => '',
        'size'   => '60',
        'info'   => '商户平台设置的 APIv3 密钥，用于通知解密',
    ),

    'pay_wxpayv3_serial' => array(
        'label'  => '证书序列号:',
        'type'   => 'text',
        'values' => '',
        'size'   => '40',
        'info'   => '商户 API 证书的序列号（cert 详情页可见）',
    ),

    'pay_wxpayv3_key_path' => array(
        'label'  => '商户私钥(PEM):',
        'type'   => 'textarea',
        'values' => '',
        'info'   => "建议直接粘贴私钥 PEM 内容（以 -----BEGIN PRIVATE KEY----- 开头）\n如需使用文件，可填写绝对路径，系统会优先判断路径是否存在",
    ),

    // 保存按钮
    'pay_post_config' => array(
        'label'  => '保存修改:',
        'type'   => 'submit',
        'values' => '保存修改',
    ),
);

