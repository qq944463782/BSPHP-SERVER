<?php
return array(
'name'=> 'BsphpCms',    //名称
'url'=> 'http://127.0.0.2/',   //域名
'stop'=> true,  //是否开放
'stop_info'=> '系统维护中,升级后正常开放！', //维护提示
'pass_key'=> '', //密码加密key
'cook_key'=> '',  //cookies 加密key
'time_add'=> '',  //系统时间差
'admin_maill'=> '', //系统管理员联系邮箱
'cnzz_id'=> '',  //站长统计
'timezone'=> 'PRC',  //站长统计
'cms_templates_change'=> true, //默认模板是否用户可以修改
'cms_templates_pc'=> 'default',  //在电脑PC端模板
'cms_templates_phone'=> 'default',  //在移动phone 模板
'home_templates_change'=> true, //默认模板是否用户可以修改
'home_templates_ie'=> 'default',  //在电脑PC端模板
'home_templates_phone'=> 'default',  //在移动phone 模板
'main_templates_change'=> true, //默认模板是否用户可以修改
'main_templates_ie'=> 'default',  //在电脑PC端模板
'main_templates_phone'=> 'default',  //在移动phone 模板
'langs_change'=> true, //语言是否可更改
'langs'=> 'zh-cn', //默认语言
'session_time'=> '',//有效期 0浏览器进程
'cookie_pre'=> 'bsphp_', //Cookie 前缀，同一域名下安装多套系统时，请修改Cookie前缀
'debug'=>false,
'session_storage'=> 'mysql',
'session_ttl'=> 1800,
'session_savepath'=> 'sessions/',
'session_n'=> 0,
'cookie_domain'=> '', //Cookie 作用域
'cookie_path'=> '', //Cookie 作用路径
'cookie_pre'=> 'Bsphp_', //Cookie 前缀，同一域名下安装多套系统时，请修改Cookie前缀
'cookie_ttl'=> 0, //Cookie 生命周期，0 表示随浏览器进程
);
?>