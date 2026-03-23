<?php
return array(
'pay_config'=>array('label'=>'用户中心:','OpenFile'=>'xxxx.php','dir'=>'plug_user','name'=>'plug_user','type'=>'-1','url'=>Plug_Get_Configs_Value(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115),'url').'statics/payment/imges/payapi.png','info'=>Plug_Get_Configs_Value(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115),'url')."statics/payment/imges/payapi.png"),  //固定值
'wx_webid'=>array('label'=>'微信网页id','type'=>'text','values'=>'','size'=>'30','info'=>'微信登陆网页id'),
'wx_webkey'=>array('label'=>'微信网页key:','type'=>'text','values'=>'','size'=>'30','info'=>'微信登陆网页key'),
'wx_gongzhonghao_id'=>array('label'=>'公众号登陆id:','type'=>'text','values'=>'','size'=>'30','info'=>'公众号登陆id'),
'wx_gongzhonghao_key'=>array('label'=>'公众号登陆key:','type'=>'text','values'=>'','size'=>'30','info'=>'公众号登陆key'),
're_code'=>array('label'=>'邀请码','type'=>'radio','values'=>array('0'=>'显示邀请码框','1'=>'隐藏邀请码框'),'info'=>'邀请码机制'),
're_moshi'=>array('label'=>'注册方式','type'=>'radio','values'=>array('0'=>'普通','1'=>'短信','2'=>'邮箱'),'info'=>'注册方式'),
'tx_appid'=>array('label'=>'SDK AppID','type'=>'text','values'=>'','size'=>'30','info'=>'腾讯云短信'),
'tx_appkey'=>array('label'=>'App Key','type'=>'text','values'=>'','size'=>'30','info'=>'腾讯云短信'),
'tx_appcode'=>array('label'=>'信模版id','type'=>'text','values'=>'','size'=>'30','info'=>'腾讯云短信'),
'i_cnzz'=>array('label'=>'cnzz统计:','type'=>'textarea','values'=>'','size'=>'30','info'=>'统计代码'),
'i_qqqun'=>array('label'=>'qq群:','type'=>'text','values'=>'','size'=>'30','info'=>'联系QQ群'),
'i_qq'=>array('label'=>'qq:','type'=>'text','values'=>'','size'=>'30','info'=>'联系'),
'i_ipne'=>array('label'=>'手机:','type'=>'text','values'=>'','size'=>'30','info'=>'联系'),
'i_mail'=>array('label'=>'邮箱:','type'=>'text','values'=>'','size'=>'30','info'=>'联系'),
'i_logo'=>array('label'=>'logo链接','type'=>'text','values'=>'','size'=>'30','info'=>'logo URL'),
'i_beian'=>array('label'=>'备案号','type'=>'text','values'=>'','size'=>'30','info'=>'备案号'),
'i_gongan'=>array('label'=>'公安备案号','type'=>'text','values'=>'','size'=>'30','info'=>'公安备案号'),
'i_wx'=>array('label'=>'二维码链接','type'=>'text','values'=>'','size'=>'30','info'=>'微信二维码链接'),
'i_adds'=>array('label'=>'地址','type'=>'text','values'=>'','size'=>'30','info'=>'地址'),
'i_jianjie'=>array('label'=>'公司简介链接','type'=>'text','values'=>'','size'=>'30','info'=>'公司简介链接->可以跳文章链接'),
'i_yinsi'=>array('label'=>'隐私政策链接','type'=>'text','values'=>'','size'=>'30','info'=>'隐私政策链接->可以跳文章链接'),
'i_gengxing'=>array('label'=>'更新日志链接','type'=>'text','values'=>'','size'=>'30','info'=>'更新日志链接->可以跳文章链接'),
'pay_post_config'=>array('label'=>'保存修改:','type'=>'submit','values'=>'保存修改'),//记得按钮放最后
);
?>