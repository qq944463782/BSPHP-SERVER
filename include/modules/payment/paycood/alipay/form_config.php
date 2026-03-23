<?php
return array(
  //基础配置
  //label=名称
  //OpenFile=入口文件
  //dir目录名称
  //name=英文别名与目录名称一致
  //type=pay_config内-1
  //url=图片LOGO位置
  //info=注释说明
  'pay_config' => array('label' => '支付宝:', 'show_name' => '支付宝', 'OpenFile' => 'alipayapi.php', 'dir' => 'alipay', 'name' => 'alipay', 'type' => '-1', 'url' => Plug_Get_Configs_Value("" . 'sys', 'url') . 'statics/payment/imges/alipay.jpg', 'info' => '到支付宝官网申请,www.zhifubao.com '),  //固定值

  //智能表单 第三方开发参考 字段名称格式:'pay_英文别名_set  'pay_英文别名_key
  'pay_alipay_set' => array('label' => '是否启用:', 'type' => 'radio', 'values' => array('0' => '开启', '1' => '关闭'), 'info' => '是否开启支付宝交易'),
  'pay_alipay_list' => array('label' => '接口类型:', 'type' => 'radio', 'values' => array('1' => '即时到帐'), 'info' => '根据自己申请支付宝接口选择,如有不明白可咨询支付宝客服。 '),
  'pay_alipay_id' => array('label' => '商户ID:', 'type' => 'text', 'values' => '', 'size' => '30', 'info' => '支付宝商户平台提供的商户ID'),
  'pay_alipay_key' => array('label' => 'key:', 'type' => 'text', 'values' => '', 'size' => '30', 'info' => '支付宝商户提供的密钥key'),
  'pay_alipay_user' => array('label' => '收款支付宝:', 'type' => 'text', 'values' => '', 'size' => '30', 'info' => '支付宝收款账号,申请的账号'),

  'pay_alipay_payurl' => array('label' => '支付跳转:', 'type' => 'text', 'values' => '', 'size' => '30', 'info' => '充值支付成功跳转地址'),
  'pay_alipay_webapiurl' => array('label' => '续费跳转:', 'type' => 'text', 'values' => '', 'size' => '30', 'info' => '直接续费指定软件WEBAPI跳转'),
  'pay_post_config' => array('label' => '保存修改:', 'type' => 'submit', 'values' => '保存修改'), //记得按钮放最后
);
