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
      'pay_config'=>array('label'=>'微信支付:', 'show_name' => '微信支付', 'OpenFile'=>'alipayapi.php','dir'=>'wxpay','name'=>'wxpay','type'=>'-1','url'=>Plug_Get_Configs_Value("" . 'sys','url').'statics/payment/imges/wx.png','info'=>'到微信官网申请,pay.weixin.qq.com '),  //固定值
      
      //智能表单 第三方开发参考 字段名称格式:'pay_英文别名_set  'pay_英文别名_key
      'pay_wxpay_set'=>array('label'=>'是否启用:','type'=>'radio','values'=>array('0'=>'开启','1'=>'关闭'),'info'=>'是否开启微信交易'),
      'pay_wxpay_list'=>array('label'=>'接口类型:','type'=>'radio','values'=>array('1'=>'二维码','2'=>'JSAPI','3'=>'自动调用'),'info'=>'没特殊必要选自动就可以'),
      'pay_wxpay_appid'=>array('label'=>'APPID:','type'=>'text','values'=>'','size'=>'30','info'=>'绑定支付的APPID（必须配置，开户邮件中可查看）'),
      'pay_wxpay_key'=>array('label'=>'KEY:','type'=>'text','values'=>'','size'=>'30','info'=>'商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）, 请妥善保管， 避免密钥泄露 * 设置地址：https://pay.weixin.qq.com/index.php/account/api_cert'),
      'pay_wxpay_appsecret'=>array('label'=>'APPSECRET:','type'=>'text','values'=>'','size'=>'30','info'=>'公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置）， 请妥善保管， 避免密钥泄露'),
      
      
      'pay_wxpay_mcid'=>array('label'=>'MCHID:','type'=>'text','values'=>'','size'=>'30','info'=>'商户号（必须配置，开户邮件中可查看）'),
      'pay_post_config'=>array('label'=>'保存修改:','type'=>'submit','values'=>'保存修改'),//记得按钮放最后
    );
?>