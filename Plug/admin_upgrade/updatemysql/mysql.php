<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') die('Not,This File Not Can in Ie Modules');
return array (
'generated_at'=> '2026-04-24 19:46:04',
'tables'=>
array (
'bs_php_add'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '自增ID',
),
'add_leix'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '添加类型',
),
'add_table'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '关联表',
),
'add_qq'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> 'QQ号',
),
'add_txt'=>
array (
'type'=> 'text',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '添加内容',
),
'add_uid'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户UID',
),
'add_date'=>
array (
'type'=> 'date',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '添加日期',
),
'add_daihao'=>
array (
'type'=> 'int(8)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '软件代号',
),
),
'indexes'=>
array (
'id'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
'add_daihao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'add_daihao',
),
),
'add_uid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'add_uid',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_add` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'自增ID\',
`add_leix` varchar(255) NOT NULL COMMENT \'添加类型\',
`add_table` varchar(255) NOT NULL COMMENT \'关联表\',
`add_qq` varchar(255) NOT NULL COMMENT \'QQ号\',
`add_txt` text NOT NULL COMMENT \'添加内容\',
`add_uid` varchar(255) NOT NULL COMMENT \'用户UID\',
`add_date` date NOT NULL COMMENT \'添加日期\',
`add_daihao` int(8) DEFAULT \'0\' COMMENT \'软件代号\',
UNIQUE KEY `id` (`id`),
KEY `add_daihao` (`add_daihao`),
KEY `add_uid` (`add_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT=\'添加记录表\'',
),
'bs_php_admin'=>
array (
'columns'=>
array (
'Admin_ID'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '管理员ID',
),
'Admin_AdminUserName'=>
array (
'type'=> 'varchar(15)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '管理员用户名',
),
'Admin_AdminPassWord'=>
array (
'type'=> 'varchar(32)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '管理员密码',
),
'Admin_MiBao'=>
array (
'type'=> 'varchar(15)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '密保',
),
'Admin_CaoShi'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '操作次数',
),
'Admin_LoGinIP'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'Admin_LoGinNum'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '登录次数',
),
'Admin_LoGDaTe'=>
array (
'type'=> 'datetime',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '最后登录时间',
),
'Admin_IsLock'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '是否锁定',
),
'Admin_Permission'=>
array (
'type'=> 'text',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '权限',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'Admin_ID',
),
),
'Admin_AdminUserName'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'Admin_AdminUserName',
),
),
'Admin_AdminPassWord'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'Admin_AdminPassWord',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_admin` (
`Admin_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT \'管理员ID\',
`Admin_AdminUserName` varchar(15) NOT NULL COMMENT \'管理员用户名\',
`Admin_AdminPassWord` varchar(32) NOT NULL COMMENT \'管理员密码\',
`Admin_MiBao` varchar(15) NOT NULL COMMENT \'密保\',
`Admin_CaoShi` int(11) DEFAULT \'0\' COMMENT \'操作次数\',
`Admin_LoGinIP` varchar(255) DEFAULT NULL,
`Admin_LoGinNum` int(11) DEFAULT \'0\' COMMENT \'登录次数\',
`Admin_LoGDaTe` datetime DEFAULT NULL COMMENT \'最后登录时间\',
`Admin_IsLock` tinyint(1) DEFAULT \'0\' COMMENT \'是否锁定\',
`Admin_Permission` text NOT NULL COMMENT \'权限\',
PRIMARY KEY (`Admin_ID`),
UNIQUE KEY `Admin_AdminUserName` (`Admin_AdminUserName`),
KEY `Admin_AdminPassWord` (`Admin_AdminPassWord`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT=\'管理员表\'',
),
'bs_php_admin_quickstat'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'int(11) unsigned',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '自增ID',
),
'path'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '页面路径(含参数简化)',
),
'name'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '页面快捷名称',
),
'hit_count'=>
array (
'type'=> 'int(11) unsigned',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '访问次数',
),
'last_url'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '最近一次完整URL',
),
'last_ip'=>
array (
'type'=> 'varchar(64)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '最近访问IP',
),
'last_user'=>
array (
'type'=> 'varchar(64)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '最近访问后台账号(可选)',
),
'last_time'=>
array (
'type'=> 'datetime',
'nullable'=> false,
'default'=> '2000-01-01 00:00:00',
'extra'=> '',
'comment'=> '最近访问时间',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
'uniq_path_name'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'path',
1=> 'name',
),
),
'idx_last_user_time'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'last_user',
1=> 'last_time',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_admin_quickstat` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT \'自增ID\',
`path` varchar(255) NOT NULL DEFAULT \'\' COMMENT \'页面路径(含参数简化)\',
`name` varchar(255) NOT NULL DEFAULT \'\' COMMENT \'页面快捷名称\',
`hit_count` int(11) unsigned NOT NULL DEFAULT \'0\' COMMENT \'访问次数\',
`last_url` text COMMENT \'最近一次完整URL\',
`last_ip` varchar(64) NOT NULL DEFAULT \'\' COMMENT \'最近访问IP\',
`last_user` varchar(64) NOT NULL DEFAULT \'\' COMMENT \'最近访问后台账号(可选)\',
`last_time` datetime NOT NULL DEFAULT \'2000-01-01 00:00:00\' COMMENT \'最近访问时间\',
PRIMARY KEY (`id`),
UNIQUE KEY `uniq_path_name` (`path`,`name`),
KEY `idx_last_user_time` (`last_user`(32),`last_time`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COMMENT=\'后台页面快捷统计\'',
),
'bs_php_admin_quickstat_pinned'=>
array (
'columns'=>
array (
'last_user'=>
array (
'type'=> 'varchar(64)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'path'=>
array (
'type'=> 'varchar(512)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'last_user',
1=> 'path',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_admin_quickstat_pinned` (
`last_user` varchar(64) NOT NULL,
`path` varchar(512) NOT NULL,
PRIMARY KEY (`last_user`,`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=\'后台快捷统计置顶\'',
),
'bs_php_api_dbug'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '',
),
'uuid'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'time'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '',
),
'user'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'api'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'ip'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'Sessl'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> 'session',
),
'head_data'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '协议头',
),
'get_data'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> 'get链接',
),
'post_data'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> 'post数据包',
),
'decrypt'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '解密类型',
),
'decrypt_data'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'error'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'print_fun'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '输出格式没',
),
'print_fun_data'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '输出格式没加密',
),
'encryption'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '数据加密',
),
'encryption_data'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '加密数据',
),
'print_html'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '最近输出结果拦截，含错误',
),
'parameter'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '接收数据包',
),
'parameter_type'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '接收方式',
),
'in_sigm_key'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'in_sigm_txt'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'in_sigm_md5'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'to_sigm_key'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'to_sigm_txt'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'to_sigm_md5'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
'uuid_2'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'uuid',
),
),
'uuid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'uuid',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_api_dbug` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`uuid` varchar(255) NOT NULL,
`time` int(11) DEFAULT \'0\',
`user` varchar(255) DEFAULT \'\',
`api` varchar(255) DEFAULT \'\',
`ip` varchar(255) DEFAULT \'\',
`Sessl` varchar(255) DEFAULT \'\' COMMENT \'session\',
`head_data` text COMMENT \'协议头\',
`get_data` text COMMENT \'get链接\',
`post_data` text COMMENT \'post数据包\',
`decrypt` varchar(255) DEFAULT \'\' COMMENT \'解密类型\',
`decrypt_data` text,
`error` text,
`print_fun` varchar(255) DEFAULT \'\' COMMENT \'输出格式没\',
`print_fun_data` text COMMENT \'输出格式没加密\',
`encryption` varchar(255) DEFAULT \'\' COMMENT \'数据加密\',
`encryption_data` text COMMENT \'加密数据\',
`print_html` text COMMENT \'最近输出结果拦截，含错误\',
`parameter` text COMMENT \'接收数据包\',
`parameter_type` int(11) DEFAULT \'0\' COMMENT \'接收方式\',
`in_sigm_key` varchar(255) DEFAULT \'\',
`in_sigm_txt` text,
`in_sigm_md5` varchar(255) DEFAULT \'\',
`to_sigm_key` varchar(255) DEFAULT \'\',
`to_sigm_txt` text,
`to_sigm_md5` varchar(255) DEFAULT \'\',
PRIMARY KEY (`id`),
UNIQUE KEY `uuid_2` (`uuid`),
KEY `uuid` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=4514 DEFAULT CHARSET=utf8 COMMENT=\'bsphp调试记录表！\'',
),
'bs_php_app_custom_config'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '',
),
'app_daihao'=>
array (
'type'=> 'int(8)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件代号',
),
'field_key'=>
array (
'type'=> 'varchar(80)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '字段key',
),
'field_type'=>
array (
'type'=> 'varchar(20)',
'nullable'=> false,
'default'=> 'input',
'extra'=> '',
'comment'=> 'input/textarea/select/upload',
),
'field_val'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '值',
),
'field_desc'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '说明',
),
'field_options'=>
array (
'type'=> 'longtext',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> 'select选项JSON',
),
'model_name'=>
array (
'type'=> 'varchar(100)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '类型名称',
),
'remark'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '备注',
),
'login_required'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '登陆后可取 0=无需登录 1=需登录 2=需要登陆切没过期才可取',
),
'expire_allow'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '没到期可取 0=未到期才可取 1=过期也可取',
),
'sort_order'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
'uk_app_field'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'app_daihao',
1=> 'field_key',
),
),
'app_daihao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'app_daihao',
),
),
'idx_app_sort'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'app_daihao',
1=> 'sort_order',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_app_custom_config` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`app_daihao` int(8) NOT NULL COMMENT \'软件代号\',
`field_key` varchar(80) NOT NULL COMMENT \'字段key\',
`field_type` varchar(20) NOT NULL DEFAULT \'input\' COMMENT \'input/textarea/select/upload\',
`field_val` text COMMENT \'值\',
`field_desc` varchar(255) DEFAULT NULL COMMENT \'说明\',
`field_options` longtext COMMENT \'select选项JSON\',
`model_name` varchar(100) DEFAULT NULL COMMENT \'类型名称\',
`remark` varchar(255) DEFAULT NULL COMMENT \'备注\',
`login_required` tinyint(1) NOT NULL DEFAULT \'0\' COMMENT \'登陆后可取 0=无需登录 1=需登录 2=需要登陆切没过期才可取\',
`expire_allow` tinyint(1) NOT NULL DEFAULT \'0\' COMMENT \'没到期可取 0=未到期才可取 1=过期也可取\',
`sort_order` int(11) DEFAULT \'0\',
PRIMARY KEY (`id`),
UNIQUE KEY `uk_app_field` (`app_daihao`,`field_key`),
KEY `app_daihao` (`app_daihao`),
KEY `idx_app_sort` (`app_daihao`,`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT=\'自定义配置\'',
),
'bs_php_appen_log'=>
array (
'columns'=>
array (
'log_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '日志ID',
),
'log_uid'=>
array (
'type'=> 'char(25)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户UID',
),
'log_ip'=>
array (
'type'=> 'char(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> 'IP',
),
'log_date'=>
array (
'type'=> 'datetime',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '时间',
),
'log_md5'=>
array (
'type'=> 'char(32)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> 'MD5',
),
'log_api'=>
array (
'type'=> 'char(50)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> 'API',
),
'log_datd'=>
array (
'type'=> 'text',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '数据',
),
'log_daihao'=>
array (
'type'=> 'int(8)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件代号',
),
'log_url_date'=>
array (
'type'=> 'int(6)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> 'URL日期',
),
'log_leix'=>
array (
'type'=> 'char(100)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '类型',
),
'log_beizhu'=>
array (
'type'=> 'char(200)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '备注',
),
'log_dengji'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '等级',
),
),
'indexes'=>
array (
'log_id'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'log_id',
),
),
'log_uid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_uid',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_appen_log` (
`log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'日志ID\',
`log_uid` char(25) NOT NULL COMMENT \'用户UID\',
`log_ip` char(255) NOT NULL COMMENT \'IP\',
`log_date` datetime NOT NULL COMMENT \'时间\',
`log_md5` char(32) NOT NULL COMMENT \'MD5\',
`log_api` char(50) NOT NULL COMMENT \'API\',
`log_datd` text NOT NULL COMMENT \'数据\',
`log_daihao` int(8) NOT NULL COMMENT \'软件代号\',
`log_url_date` int(6) NOT NULL COMMENT \'URL日期\',
`log_leix` char(100) NOT NULL COMMENT \'类型\',
`log_beizhu` char(200) NOT NULL COMMENT \'备注\',
`log_dengji` tinyint(1) NOT NULL COMMENT \'等级\',
UNIQUE KEY `log_id` (`log_id`),
KEY `log_uid` (`log_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\'应用接口调用日志\'',
),
'bs_php_appinfo'=>
array (
'columns'=>
array (
'app_daihao'=>
array (
'type'=> 'int(8)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件代号',
),
'app_name'=>
array (
'type'=> 'varchar(50)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件名称',
),
'app_off'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '软件开关',
),
'app_off_name'=>
array (
'type'=> 'varchar(180)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '关闭提示',
),
'app_set'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '软件类型',
),
'app_set_date'=>
array (
'type'=> 'varchar(50)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '送时间',
),
'app_WEB_URL'=>
array (
'type'=> 'varchar(300)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> 'web地址',
),
'app_URL'=>
array (
'type'=> 'varchar(300)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> 'app地址',
),
'app_v'=>
array (
'type'=> 'varchar(50)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '版本号',
),
'app_key_zhong'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '是否可重绑定',
),
'app_gg'=>
array (
'type'=> 'varchar(500)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '公告',
),
'app_LogicA'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '逻辑提示A',
),
'app_LogicB'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '逻辑提示B',
),
'app_LogicinfoA'=>
array (
'type'=> 'varchar(500)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '逻辑提示A内容',
),
'app_LogicinfoB'=>
array (
'type'=> 'varchar(500)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '逻辑提示B内容',
),
'app_logininfo'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_md5'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_MoShi'=>
array (
'type'=> 'varchar(100)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '模式',
),
'app_miaoshu'=>
array (
'type'=> 'varchar(500)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件描述',
),
'app_info'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件信息',
),
'app_re_date'=>
array (
'type'=> 'int(10)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '注册送时间',
),
'app_zhuang_date'=>
array (
'type'=> 'int(10)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '转绑定扣时间',
),
'app_links'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_coode'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_chaoshi'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_pwd'=>
array (
'type'=> 'varchar(32)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '加密密码',
),
'app_get'=>
array (
'type'=> 'int(1)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_breaking'=>
array (
'type'=> 'int(1)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_links_chaoshi'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '',
),
'app_chargeset'=>
array (
'type'=> 'int(1)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_links_open'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_point_open'=>
array (
'type'=> 'int(1)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_api_pwd'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_api_dir'=>
array (
'type'=> 'varchar(100)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_get_encryption'=>
array (
'type'=> 'varchar(100)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_show_encryption'=>
array (
'type'=> 'varchar(100)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_output'=>
array (
'type'=> 'varchar(100)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_langs'=>
array (
'type'=> 'varchar(100)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '语言',
),
'app_links_open_off'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '账号到上限操作 0=提示 1=注销最早',
),
'app_links_off'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '机器到上限操作 0=提示 1=注销最早',
),
'app_insgin'=>
array (
'type'=> 'varchar(100)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_tosgin'=>
array (
'type'=> 'varchar(100)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'app_sort'=>
array (
'type'=> 'varchar(100)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'app_sale_kefu'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件销售',
),
'app_sale_desc'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件销售',
),
'app_sale_img'=>
array (
'type'=> 'varchar(500)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件销售',
),
'app_sale_title'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件销售',
),
'app_server_pem'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '服务器公钥',
),
'app_server_key'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '服务器私钥',
),
'app_client_pem'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '客户端公',
),
'app_client_key'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '客户端私',
),
'app_user_extra'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件用户列表拓展字段(JSON)',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'app_daihao',
),
),
'app_daihao'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'app_daihao',
),
),
'app_MoShi'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'app_MoShi',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_appinfo` (
`app_daihao` int(8) NOT NULL COMMENT \'软件代号\',
`app_name` varchar(50) DEFAULT NULL COMMENT \'软件名称\',
`app_off` tinyint(1) DEFAULT \'0\' COMMENT \'软件开关\',
`app_off_name` varchar(180) DEFAULT NULL COMMENT \'关闭提示\',
`app_set` tinyint(1) DEFAULT \'0\' COMMENT \'软件类型\',
`app_set_date` varchar(50) DEFAULT NULL COMMENT \'送时间\',
`app_WEB_URL` varchar(300) DEFAULT NULL COMMENT \'web地址\',
`app_URL` varchar(300) DEFAULT NULL COMMENT \'app地址\',
`app_v` varchar(50) DEFAULT NULL COMMENT \'版本号\',
`app_key_zhong` tinyint(1) DEFAULT NULL COMMENT \'是否可重绑定\',
`app_gg` varchar(500) DEFAULT NULL COMMENT \'公告\',
`app_LogicA` tinyint(1) DEFAULT \'0\' COMMENT \'逻辑提示A\',
`app_LogicB` tinyint(1) DEFAULT \'0\' COMMENT \'逻辑提示B\',
`app_LogicinfoA` varchar(500) DEFAULT NULL COMMENT \'逻辑提示A内容\',
`app_LogicinfoB` varchar(500) DEFAULT NULL COMMENT \'逻辑提示B内容\',
`app_logininfo` text,
`app_md5` text,
`app_MoShi` varchar(100) NOT NULL COMMENT \'模式\',
`app_miaoshu` varchar(500) DEFAULT NULL COMMENT \'软件描述\',
`app_info` varchar(255) DEFAULT NULL COMMENT \'软件信息\',
`app_re_date` int(10) DEFAULT \'0\' COMMENT \'注册送时间\',
`app_zhuang_date` int(10) DEFAULT \'0\' COMMENT \'转绑定扣时间\',
`app_links` int(11) DEFAULT NULL,
`app_coode` text,
`app_chaoshi` int(11) DEFAULT NULL,
`app_pwd` varchar(32) DEFAULT NULL COMMENT \'加密密码\',
`app_get` int(1) DEFAULT NULL,
`app_breaking` int(1) DEFAULT NULL,
`app_links_chaoshi` int(11) DEFAULT \'0\',
`app_chargeset` int(1) DEFAULT NULL,
`app_links_open` int(11) DEFAULT NULL,
`app_point_open` int(1) DEFAULT NULL,
`app_api_pwd` varchar(255) DEFAULT NULL,
`app_api_dir` varchar(100) DEFAULT NULL,
`app_get_encryption` varchar(100) DEFAULT NULL,
`app_show_encryption` varchar(100) DEFAULT NULL,
`app_output` varchar(100) DEFAULT NULL,
`app_langs` varchar(100) NOT NULL COMMENT \'语言\',
`app_links_open_off` int(11) DEFAULT \'0\' COMMENT \'账号到上限操作 0=提示 1=注销最早\',
`app_links_off` int(11) DEFAULT \'0\' COMMENT \'机器到上限操作 0=提示 1=注销最早\',
`app_insgin` varchar(100) DEFAULT NULL,
`app_tosgin` varchar(100) DEFAULT NULL,
`app_sort` varchar(100) DEFAULT \'\',
`app_sale_kefu` text COMMENT \'软件销售\',
`app_sale_desc` text COMMENT \'软件销售\',
`app_sale_img` varchar(500) DEFAULT NULL COMMENT \'软件销售\',
`app_sale_title` varchar(255) DEFAULT NULL COMMENT \'软件销售\',
`app_server_pem` text COMMENT \'服务器公钥\',
`app_server_key` text COMMENT \'服务器私钥\',
`app_client_pem` text COMMENT \'客户端公\',
`app_client_key` text COMMENT \'客户端私\',
`app_user_extra` text COMMENT \'软件用户列表拓展字段(JSON)\',
PRIMARY KEY (`app_daihao`),
UNIQUE KEY `app_daihao` (`app_daihao`),
KEY `app_MoShi` (`app_MoShi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\'软件信息表\'',
),
'bs_php_cardseries'=>
array (
'columns'=>
array (
'car_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '卡ID',
),
'car_name'=>
array (
'type'=> 'varchar(40)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡号',
),
'car_pwd'=>
array (
'type'=> 'varchar(40)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡密',
),
'car_IsLock'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '是否锁定',
),
'car_DaiHao'=>
array (
'type'=> 'int(10)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件代号',
),
'car_reDATE'=>
array (
'type'=> 'datetime',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '到期时间',
),
'car_TianShu'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '天数',
),
'car_Lei'=>
array (
'type'=> 'varchar(60)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '卡类',
),
'car_admin'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '管理员',
),
'car_BaoJi'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '暴击',
),
'car_JiFen'=>
array (
'type'=> 'int(10)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '积分',
),
'car_Rmb'=>
array (
'type'=> 'float(9,2)',
'nullable'=> true,
'default'=> '0.00',
'extra'=> '',
'comment'=> '人民币',
),
'car_DaoLi_Rmb'=>
array (
'type'=> 'float(9,2)',
'nullable'=> true,
'default'=> '0.00',
'extra'=> '',
'comment'=> '道理人民币',
),
'car_RuKu'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '入库',
),
'car_zhuangtai'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '状态',
),
'car_chong_uid'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '充值用户UID',
),
'car_pur_date'=>
array (
'type'=> 'datetime',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '购买日期',
),
'car_cong_user'=>
array (
'type'=> 'varchar(200)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '从属用户',
),
'car_type'=>
array (
'type'=> 'int(1)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '类型',
),
'car_weight'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '权重',
),
'car_class'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '分类',
),
'car_for'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用途',
),
'lei_for_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡类用途ID',
),
'car_for_oid'=>
array (
'type'=> 'text',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用途订单',
),
'car_div'=>
array (
'type'=> 'varchar(250)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '分成',
),
'car_money'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '金额',
),
'car_links_open'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '账号登录数',
),
'car_links'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '机器数量',
),
'car_admin_beizhu'=>
array (
'type'=> 'varchar(100)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '管理员备注',
),
'car_agnet_beizhu'=>
array (
'type'=> 'varchar(100)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '代理备注',
),
'car_buy_by'=>
array (
'type'=> 'varchar(64)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '购买者标识(支付订单号/购买人)',
),
'car_sale_flag'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '0=正常卡 1=用销售现卡 2=已售出现卡',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'car_id',
),
),
'car_agnet_beizhu'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_agnet_beizhu',
),
),
'car_admin_beizhu'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_admin_beizhu',
),
),
'car_name'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_name',
),
),
'car_IsLock'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_IsLock',
),
),
'car_DaiHao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_DaiHao',
),
),
'car_TianShu'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_TianShu',
),
),
'car_zhuangtai'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_zhuangtai',
),
),
'car_type'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_type',
),
),
'lei_for_id'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'lei_for_id',
),
),
'car_class'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_class',
),
),
'car_sale_flag'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_sale_flag',
),
),
'car_buy_by'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_buy_by',
),
),
'idx_car_reDATE'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_reDATE',
),
),
'idx_car_DaiHao_reDATE'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_DaiHao',
1=> 'car_reDATE',
),
),
'idx_car_DaiHao_Lei_sale'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'car_DaiHao',
1=> 'car_Lei',
2=> 'car_sale_flag',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_cardseries` (
`car_id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'卡ID\',
`car_name` varchar(40) NOT NULL COMMENT \'卡号\',
`car_pwd` varchar(40) NOT NULL COMMENT \'卡密\',
`car_IsLock` tinyint(1) DEFAULT \'0\' COMMENT \'是否锁定\',
`car_DaiHao` int(10) NOT NULL COMMENT \'软件代号\',
`car_reDATE` datetime NOT NULL COMMENT \'到期时间\',
`car_TianShu` int(11) NOT NULL COMMENT \'天数\',
`car_Lei` varchar(60) DEFAULT \'0\' COMMENT \'卡类\',
`car_admin` varchar(1000) DEFAULT NULL COMMENT \'管理员\',
`car_BaoJi` tinyint(1) DEFAULT \'0\' COMMENT \'暴击\',
`car_JiFen` int(10) DEFAULT \'0\' COMMENT \'积分\',
`car_Rmb` float(9,2) DEFAULT \'0.00\' COMMENT \'人民币\',
`car_DaoLi_Rmb` float(9,2) DEFAULT \'0.00\' COMMENT \'道理人民币\',
`car_RuKu` tinyint(1) DEFAULT \'0\' COMMENT \'入库\',
`car_zhuangtai` tinyint(1) DEFAULT \'0\' COMMENT \'状态\',
`car_chong_uid` int(11) DEFAULT \'0\' COMMENT \'充值用户UID\',
`car_pur_date` datetime NOT NULL COMMENT \'购买日期\',
`car_cong_user` varchar(200) NOT NULL COMMENT \'从属用户\',
`car_type` int(1) NOT NULL COMMENT \'类型\',
`car_weight` int(11) NOT NULL COMMENT \'权重\',
`car_class` int(11) NOT NULL COMMENT \'分类\',
`car_for` int(11) NOT NULL COMMENT \'用途\',
`lei_for_id` int(11) NOT NULL COMMENT \'卡类用途ID\',
`car_for_oid` text NOT NULL COMMENT \'用途订单\',
`car_div` varchar(250) NOT NULL COMMENT \'分成\',
`car_money` float(9,2) NOT NULL COMMENT \'金额\',
`car_links_open` int(11) DEFAULT \'0\' COMMENT \'账号登录数\',
`car_links` int(11) DEFAULT \'0\' COMMENT \'机器数量\',
`car_admin_beizhu` varchar(100) DEFAULT NULL COMMENT \'管理员备注\',
`car_agnet_beizhu` varchar(100) DEFAULT NULL COMMENT \'代理备注\',
`car_buy_by` varchar(64) DEFAULT \'\' COMMENT \'购买者标识(支付订单号/购买人)\',
`car_sale_flag` tinyint(1) DEFAULT \'0\' COMMENT \'0=正常卡 1=用销售现卡 2=已售出现卡\',
PRIMARY KEY (`car_id`),
KEY `car_agnet_beizhu` (`car_agnet_beizhu`),
KEY `car_admin_beizhu` (`car_admin_beizhu`),
KEY `car_name` (`car_name`),
KEY `car_IsLock` (`car_IsLock`),
KEY `car_DaiHao` (`car_DaiHao`),
KEY `car_TianShu` (`car_TianShu`),
KEY `car_zhuangtai` (`car_zhuangtai`),
KEY `car_type` (`car_type`),
KEY `lei_for_id` (`lei_for_id`),
KEY `car_class` (`car_class`),
KEY `car_sale_flag` (`car_sale_flag`),
KEY `car_buy_by` (`car_buy_by`(32)),
KEY `idx_car_reDATE` (`car_reDATE`),
KEY `idx_car_DaiHao_reDATE` (`car_DaiHao`,`car_reDATE`),
KEY `idx_car_DaiHao_Lei_sale` (`car_DaiHao`,`car_Lei`,`car_sale_flag`)
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=utf8 COMMENT=\'卡密系列表\'',
),
'bs_php_custom_data_info'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'bigint(20) unsigned',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '编号',
),
'created_at'=>
array (
'type'=> 'bigint(13)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '创建时间',
),
'updated_at'=>
array (
'type'=> 'bigint(13)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '更新时间',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_custom_data_info` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT \'编号\',
`created_at` bigint(13) NOT NULL DEFAULT \'0\' COMMENT \'创建时间\',
`updated_at` bigint(13) NOT NULL DEFAULT \'0\' COMMENT \'更新时间\',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=\'用户信息\'',
),
'bs_php_kalei'=>
array (
'columns'=>
array (
'lei_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '卡类ID',
),
'lei_name'=>
array (
'type'=> 'char(150)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡类名称',
),
'lei_date'=>
array (
'type'=> 'int(5)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '天数',
),
'lei_jiage'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '价格',
),
'lei_daili'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '代理价',
),
'lei_daihao'=>
array (
'type'=> 'int(8)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件代号',
),
'lei_ktzf'=>
array (
'type'=> 'varchar(10)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '开头字符',
),
'lei_type'=>
array (
'type'=> 'int(1)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '类型',
),
'lei_weight'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '权重',
),
'lei_class'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '分类',
),
'lei_cardint'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡号长度',
),
'lei_cardset'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡号设置',
),
'lei_pwdint'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '密码长度',
),
'lei_pwdset'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '密码设置',
),
'lei_for'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用途',
),
'lei_for_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用途ID',
),
'lei_for_oid'=>
array (
'type'=> 'text',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用途订单',
),
'lei_money'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '金额',
),
'lei_links_open'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '登录数',
),
'lei_links'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '数量数量',
),
'lei_sort'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '排序',
),
'lei_img'=>
array (
'type'=> 'varchar(500)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡类图片',
),
),
'indexes'=>
array (
'lei_id'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'lei_id',
),
),
'lei_class'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'lei_class',
),
),
'lei_name'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'lei_name',
),
),
'lei_jiage'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'lei_jiage',
),
),
'lei_daihao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'lei_daihao',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_kalei` (
`lei_id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'卡类ID\',
`lei_name` char(150) NOT NULL COMMENT \'卡类名称\',
`lei_date` int(5) NOT NULL COMMENT \'天数\',
`lei_jiage` float(9,2) NOT NULL COMMENT \'价格\',
`lei_daili` float(9,2) NOT NULL COMMENT \'代理价\',
`lei_daihao` int(8) NOT NULL COMMENT \'软件代号\',
`lei_ktzf` varchar(10) DEFAULT NULL COMMENT \'开头字符\',
`lei_type` int(1) DEFAULT NULL COMMENT \'类型\',
`lei_weight` int(11) NOT NULL COMMENT \'权重\',
`lei_class` int(11) NOT NULL COMMENT \'分类\',
`lei_cardint` int(11) NOT NULL COMMENT \'卡号长度\',
`lei_cardset` int(11) NOT NULL COMMENT \'卡号设置\',
`lei_pwdint` int(11) NOT NULL COMMENT \'密码长度\',
`lei_pwdset` int(11) NOT NULL COMMENT \'密码设置\',
`lei_for` int(11) NOT NULL COMMENT \'用途\',
`lei_for_id` int(11) NOT NULL COMMENT \'用途ID\',
`lei_for_oid` text NOT NULL COMMENT \'用途订单\',
`lei_money` float(9,2) NOT NULL COMMENT \'金额\',
`lei_links_open` int(11) DEFAULT \'0\' COMMENT \'登录数\',
`lei_links` int(11) DEFAULT \'0\' COMMENT \'数量数量\',
`lei_sort` int(11) NOT NULL DEFAULT \'0\' COMMENT \'排序\',
`lei_img` varchar(500) DEFAULT NULL COMMENT \'卡类图片\',
UNIQUE KEY `lei_id` (`lei_id`),
KEY `lei_class` (`lei_class`),
KEY `lei_name` (`lei_name`),
KEY `lei_jiage` (`lei_jiage`),
KEY `lei_daihao` (`lei_daihao`)
) ENGINE=MyISAM AUTO_INCREMENT=128 DEFAULT CHARSET=utf8 COMMENT=\'卡类表\'',
),
'bs_php_kuka'=>
array (
'columns'=>
array (
'kuka_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '库存卡ID',
),
'kuka_uid'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户UID',
),
'kuka_daihao'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件代号',
),
'kuka_kalei'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡类ID',
),
'kuka_biaoji'=>
array (
'type'=> 'varchar(32)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '标识 uid_daihao_kalei',
),
'kuka_val'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '数量',
),
'kuka_user'=>
array (
'type'=> 'varchar(32)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'kuka_id',
),
),
'kuka_daihao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'kuka_daihao',
),
),
'kuka_biaoji'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'kuka_biaoji',
),
),
'kuka_kalei'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'kuka_kalei',
),
),
'kuka_uid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'kuka_uid',
),
),
'kuka_kalei_2'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'kuka_kalei',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_kuka` (
`kuka_id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'库存卡ID\',
`kuka_uid` int(11) NOT NULL COMMENT \'用户UID\',
`kuka_daihao` int(11) NOT NULL COMMENT \'软件代号\',
`kuka_kalei` int(11) NOT NULL COMMENT \'卡类ID\',
`kuka_biaoji` varchar(32) NOT NULL COMMENT \'标识 uid_daihao_kalei\',
`kuka_val` int(11) NOT NULL COMMENT \'数量\',
`kuka_user` varchar(32) NOT NULL COMMENT \'用户\',
PRIMARY KEY (`kuka_id`),
KEY `kuka_daihao` (`kuka_daihao`),
KEY `kuka_biaoji` (`kuka_biaoji`),
KEY `kuka_kalei` (`kuka_kalei`),
KEY `kuka_uid` (`kuka_uid`),
KEY `kuka_kalei_2` (`kuka_kalei`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\'库存卡\'',
),
'bs_php_language'=>
array (
'columns'=>
array (
'lang_id'=>
array (
'type'=> 'varchar(32)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'time'=>
array (
'type'=> 'bigint(15)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '',
),
'lang_0'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '默认',
),
'lang_1'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '自定一',
),
'lang_2'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '自定二',
),
'lang_3'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '粤语',
),
'lang_4'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '繁体台湾',
),
'lang_5'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '繁体香港',
),
'lang_6'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '英语',
),
'lang_7'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '俄语',
),
'lang_8'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '日语',
),
'lang_9'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '韩语',
),
'lang_10'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '法语',
),
'lang_11'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '德语',
),
'lang_12'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '越南语',
),
'lang_13'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'lang_14'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'lang_15'=>
array (
'type'=> 'varchar(1000)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'lang_id',
),
),
'lang_0'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'lang_0',
),
),
'idx_time'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'time',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_language` (
`lang_id` varchar(32) NOT NULL,
`time` bigint(15) NOT NULL DEFAULT \'0\',
`lang_0` varchar(1000) DEFAULT \'\' COMMENT \'默认\',
`lang_1` varchar(1000) DEFAULT \'\' COMMENT \'自定一\',
`lang_2` varchar(1000) DEFAULT \'\' COMMENT \'自定二\',
`lang_3` varchar(1000) DEFAULT \'\' COMMENT \'粤语\',
`lang_4` varchar(1000) DEFAULT \'\' COMMENT \'繁体台湾\',
`lang_5` varchar(1000) DEFAULT \'\' COMMENT \'繁体香港\',
`lang_6` varchar(1000) DEFAULT \'\' COMMENT \'英语\',
`lang_7` varchar(1000) DEFAULT \'\' COMMENT \'俄语\',
`lang_8` varchar(1000) DEFAULT \'\' COMMENT \'日语\',
`lang_9` varchar(1000) DEFAULT \'\' COMMENT \'韩语\',
`lang_10` varchar(1000) DEFAULT \'\' COMMENT \'法语\',
`lang_11` varchar(1000) DEFAULT \'\' COMMENT \'德语\',
`lang_12` varchar(1000) DEFAULT \'\' COMMENT \'越南语\',
`lang_13` varchar(1000) DEFAULT \'\',
`lang_14` varchar(1000) DEFAULT \'\',
`lang_15` varchar(1000) DEFAULT \'\',
PRIMARY KEY (`lang_id`),
KEY `lang_0` (`lang_0`),
KEY `idx_time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=\'全球语言库\'',
),
'bs_php_links_session'=>
array (
'columns'=>
array (
'links_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '会话ID',
),
'links_session_id'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '会话标识',
),
'links_bs_set'=>
array (
'type'=> 'varchar(20)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> 'BS设置',
),
'links_user_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户ID',
),
'links_user_name'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户名',
),
'links_daihao'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件代号',
),
'links_key'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '密钥',
),
'links_biaoji'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '标识',
),
'links_session'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '会话',
),
'links_add_time'=>
array (
'type'=> 'bigint(13)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '添加时间',
),
'links_out_time'=>
array (
'type'=> 'bigint(13)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '过期时间',
),
'links_addip'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '添加IP',
),
'links_chaoshi'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '超时',
),
'links_data'=>
array (
'type'=> 'varchar(3000)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '数据',
),
'links_set'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '设置',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'links_id',
),
),
'links_out_time'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_out_time',
),
),
'links_id'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_id',
),
),
'links_set'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_set',
),
),
'links_biaoji'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_biaoji',
),
),
'links_daihao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_daihao',
),
),
'links_user_name'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_user_name',
),
),
'links_user_id'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_user_id',
),
),
'links_bs_set'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_bs_set',
),
),
'links_session_id'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_session_id',
),
),
'idx_links_session'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_session',
),
),
'idx_links_user_daihao_set'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_user_name',
1=> 'links_daihao',
2=> 'links_set',
),
),
'idx_links_userid_daihao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_user_id',
1=> 'links_daihao',
),
),
'idx_links_out_set'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'links_out_time',
1=> 'links_set',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_links_session` (
`links_id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'会话ID\',
`links_session_id` varchar(255) NOT NULL COMMENT \'会话标识\',
`links_bs_set` varchar(20) NOT NULL COMMENT \'BS设置\',
`links_user_id` int(11) NOT NULL COMMENT \'用户ID\',
`links_user_name` varchar(255) NOT NULL COMMENT \'用户名\',
`links_daihao` int(11) NOT NULL COMMENT \'软件代号\',
`links_key` varchar(255) NOT NULL COMMENT \'密钥\',
`links_biaoji` varchar(255) NOT NULL COMMENT \'标识\',
`links_session` varchar(255) NOT NULL COMMENT \'会话\',
`links_add_time` bigint(13) NOT NULL COMMENT \'添加时间\',
`links_out_time` bigint(13) NOT NULL COMMENT \'过期时间\',
`links_addip` varchar(255) NOT NULL COMMENT \'添加IP\',
`links_chaoshi` int(11) NOT NULL COMMENT \'超时\',
`links_data` varchar(3000) NOT NULL COMMENT \'数据\',
`links_set` int(11) NOT NULL COMMENT \'设置\',
PRIMARY KEY (`links_id`),
KEY `links_out_time` (`links_out_time`),
KEY `links_id` (`links_id`),
KEY `links_set` (`links_set`),
KEY `links_biaoji` (`links_biaoji`),
KEY `links_daihao` (`links_daihao`),
KEY `links_user_name` (`links_user_name`),
KEY `links_user_id` (`links_user_id`),
KEY `links_bs_set` (`links_bs_set`),
KEY `links_session_id` (`links_session_id`),
KEY `idx_links_session` (`links_session`(64)),
KEY `idx_links_user_daihao_set` (`links_user_name`(64),`links_daihao`,`links_set`),
KEY `idx_links_userid_daihao` (`links_user_id`,`links_daihao`),
KEY `idx_links_out_set` (`links_out_time`,`links_set`)
) ENGINE=MyISAM AUTO_INCREMENT=981 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT=\'多端登录会话表\'',
),
'bs_php_log'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> 'ID',
),
'leixing'=>
array (
'type'=> 'varchar(50)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '日志类型',
),
'date'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '时间戳',
),
'ip'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> 'ip',
),
'test'=>
array (
'type'=> 'text',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '内容',
),
'user'=>
array (
'type'=> 'varchar(20)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
'leixing'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'leixing',
),
),
'user'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user',
),
),
'ip'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'ip',
),
),
'date'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'date',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_log` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'ID\',
`leixing` varchar(50) NOT NULL COMMENT \'日志类型\',
`date` int(11) NOT NULL COMMENT \'时间戳\',
`ip` varchar(255) NOT NULL COMMENT \'ip\',
`test` text NOT NULL COMMENT \'内容\',
`user` varchar(20) NOT NULL COMMENT \'用户\',
PRIMARY KEY (`id`),
KEY `leixing` (`leixing`),
KEY `user` (`user`),
KEY `ip` (`ip`),
KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=345 DEFAULT CHARSET=utf8 COMMENT=\'系统日志表\'',
),
'bs_php_moshi'=>
array (
'columns'=>
array (
'S_Name'=>
array (
'type'=> 'varchar(150)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '名称',
),
'S_MoShi'=>
array (
'type'=> 'int(4)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '模式',
),
'S_MoShiInfo'=>
array (
'type'=> 'varchar(500)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '模式说明',
),
'S_APIinfo'=>
array (
'type'=> 'varchar(10)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> 'API信息',
),
's_zhi'=>
array (
'type'=> 'varchar(10)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '值',
),
),
'indexes'=>
array (
'S_MoShi'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'S_MoShi',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_moshi` (
`S_Name` varchar(150) NOT NULL COMMENT \'名称\',
`S_MoShi` int(4) NOT NULL COMMENT \'模式\',
`S_MoShiInfo` varchar(500) NOT NULL COMMENT \'模式说明\',
`S_APIinfo` varchar(10) NOT NULL COMMENT \'API信息\',
`s_zhi` varchar(10) NOT NULL COMMENT \'值\',
UNIQUE KEY `S_MoShi` (`S_MoShi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\'模式表\'',
),
'bs_php_news'=>
array (
'columns'=>
array (
'news_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '自动ID',
),
'news_table'=>
array (
'type'=> 'varchar(200)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '标题',
),
'news_test'=>
array (
'type'=> 'text',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '内容',
),
'news_class'=>
array (
'type'=> 'int(8)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '分类id',
),
'news_daihao'=>
array (
'type'=> 'int(8)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '所属软件代号，0表示不关联',
),
'news_unix'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> 'UNIX时间',
),
),
'indexes'=>
array (
'news_id'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'news_id',
),
),
'news_table'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'news_table',
),
),
'news_unix'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'news_unix',
),
),
'news_class'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'news_class',
),
),
'news_daihao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'news_daihao',
),
),
'idx_news_daihao_id'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'news_daihao',
1=> 'news_id',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_news` (
`news_id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'自动ID\',
`news_table` varchar(200) NOT NULL COMMENT \'标题\',
`news_test` text NOT NULL COMMENT \'内容\',
`news_class` int(8) NOT NULL COMMENT \'分类id\',
`news_daihao` int(8) NOT NULL DEFAULT \'0\' COMMENT \'所属软件代号，0表示不关联\',
`news_unix` int(11) NOT NULL COMMENT \'UNIX时间\',
UNIQUE KEY `news_id` (`news_id`),
KEY `news_table` (`news_table`),
KEY `news_unix` (`news_unix`),
KEY `news_class` (`news_class`),
KEY `news_daihao` (`news_daihao`),
KEY `idx_news_daihao_id` (`news_daihao`,`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8',
),
'bs_php_news_class'=>
array (
'columns'=>
array (
'class_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '文章分类ID',
),
'class_name'=>
array (
'type'=> 'varchar(50)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '文章分类名称',
),
),
'indexes'=>
array (
'class_id'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'class_id',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_news_class` (
`class_id` int(11) NOT NULL COMMENT \'文章分类ID\',
`class_name` varchar(50) NOT NULL COMMENT \'文章分类名称\',
UNIQUE KEY `class_id` (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\'文章分类表\'',
),
'bs_php_pattern_login'=>
array (
'columns'=>
array (
'L_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> 'ID',
),
'L_User_uid'=>
array (
'type'=> 'char(150)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户UID',
),
'L_daihao'=>
array (
'type'=> 'int(8)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件代号',
),
'L_re_date'=>
array (
'type'=> 'datetime',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '注册时间',
),
'L_vip_date'=>
array (
'type'=> 'datetime',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> 'VIP到期时间',
),
'L_IsLock'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '1锁定',
),
'L_key_info'=>
array (
'type'=> 'varchar(500)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '绑定特征',
),
'L_links_info'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户信息',
),
'L_login_time'=>
array (
'type'=> 'datetime',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '登陆时间',
),
'L_class'=>
array (
'type'=> 'int(1)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '所属分组',
),
'L_timing'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '时长',
),
'L_vip_unix'=>
array (
'type'=> 'bigint(13)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'L_ic_name'=>
array (
'type'=> 'varchar(150)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡模式卡号',
),
'L_ic_pwd'=>
array (
'type'=> 'varchar(150)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡模式密码',
),
'L_ic_info'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡信息',
),
'L_login_ip'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'L_re_ip'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '',
),
'L_login_run'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '登录次数',
),
'L_links_open'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '账号登录数',
),
'L_links'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '机器登录量',
),
'L_links_open_off'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '上限关闭模式0=直接提示 1=关闭最早的',
),
'L_beizhu'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户备注',
),
'L_user_extra'=>
array (
'type'=> 'text',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件用户拓展字段(JSON)',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'L_id',
),
),
'L_User_uid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_User_uid',
),
),
'L_daihao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_daihao',
),
),
'L_re_date'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_re_date',
),
),
'L_IsLock'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_IsLock',
),
),
'L_key_info'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_key_info',
),
),
'L_login_time'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_login_time',
),
),
'L_class'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_class',
),
),
'L_vip_unix'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_vip_unix',
),
),
'L_ic_name'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_ic_name',
),
),
'L_login_ip'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_login_ip',
),
),
'L_re_ip'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_re_ip',
),
),
'L_beizhu'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_beizhu',
),
),
'idx_L_daihao_User_uid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_daihao',
1=> 'L_User_uid',
),
),
'idx_L_daihao_key_info'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_daihao',
1=> 'L_key_info',
),
),
'idx_L_vip_unix'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'L_vip_unix',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_pattern_login` (
`L_id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'ID\',
`L_User_uid` char(150) NOT NULL COMMENT \'用户UID\',
`L_daihao` int(8) NOT NULL COMMENT \'软件代号\',
`L_re_date` datetime NOT NULL COMMENT \'注册时间\',
`L_vip_date` datetime NOT NULL COMMENT \'VIP到期时间\',
`L_IsLock` tinyint(1) DEFAULT \'0\' COMMENT \'1锁定\',
`L_key_info` varchar(500) DEFAULT NULL COMMENT \'绑定特征\',
`L_links_info` text COMMENT \'用户信息\',
`L_login_time` datetime DEFAULT NULL COMMENT \'登陆时间\',
`L_class` int(1) NOT NULL COMMENT \'所属分组\',
`L_timing` int(11) NOT NULL COMMENT \'时长\',
`L_vip_unix` bigint(13) NOT NULL,
`L_ic_name` varchar(150) DEFAULT NULL COMMENT \'卡模式卡号\',
`L_ic_pwd` varchar(150) DEFAULT NULL COMMENT \'卡模式密码\',
`L_ic_info` int(11) NOT NULL COMMENT \'卡信息\',
`L_login_ip` varchar(255) NOT NULL,
`L_re_ip` varchar(255) NOT NULL,
`L_login_run` int(11) NOT NULL COMMENT \'登录次数\',
`L_links_open` int(11) DEFAULT \'0\' COMMENT \'账号登录数\',
`L_links` int(11) DEFAULT \'0\' COMMENT \'机器登录量\',
`L_links_open_off` int(11) DEFAULT \'0\' COMMENT \'上限关闭模式0=直接提示 1=关闭最早的\',
`L_beizhu` varchar(255) DEFAULT NULL COMMENT \'用户备注\',
`L_user_extra` text COMMENT \'软件用户拓展字段(JSON)\',
PRIMARY KEY (`L_id`),
KEY `L_User_uid` (`L_User_uid`),
KEY `L_daihao` (`L_daihao`),
KEY `L_re_date` (`L_re_date`),
KEY `L_IsLock` (`L_IsLock`),
KEY `L_key_info` (`L_key_info`(333)),
KEY `L_login_time` (`L_login_time`),
KEY `L_class` (`L_class`),
KEY `L_vip_unix` (`L_vip_unix`),
KEY `L_ic_name` (`L_ic_name`),
KEY `L_login_ip` (`L_login_ip`),
KEY `L_re_ip` (`L_re_ip`),
KEY `L_beizhu` (`L_beizhu`),
KEY `idx_L_daihao_User_uid` (`L_daihao`,`L_User_uid`(64)),
KEY `idx_L_daihao_key_info` (`L_daihao`,`L_key_info`(64)),
KEY `idx_L_vip_unix` (`L_vip_unix`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COMMENT=\'卡密/账号模式登录表\'',
),
'bs_php_pay_log'=>
array (
'columns'=>
array (
'pay_id'=>
array (
'type'=> 'varchar(32)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付订单号',
),
'ali_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '自增ID',
),
'pay_uid'=>
array (
'type'=> 'char(15)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户UID',
),
'pay_date'=>
array (
'type'=> 'datetime',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付时间',
),
'pay_qian_rmb'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付前余额',
),
'pay_rmb'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付金额',
),
'pay_ka_shuliang'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡数量',
),
'pay_zhuangtai'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '状态',
),
'ka_shijia'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡市价',
),
'ka_zhe_jia'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡折后价',
),
'ali_ka_name'=>
array (
'type'=> 'char(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡类名称',
),
'ali_ka_jiage'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡价格',
),
'ali_ka_zhe'=>
array (
'type'=> 'float(2,1)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡折扣',
),
'ali_ka_date'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '卡天数',
),
'pay_daihao'=>
array (
'type'=> 'int(8)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件代号',
),
'pay_app_name'=>
array (
'type'=> 'varchar(50)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件名称',
),
'pay_type'=>
array (
'type'=> 'int(1)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付类型',
),
'pay_yao_uid'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '推荐人UID(0=无)',
),
'pay_remark'=>
array (
'type'=> 'varchar(100)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '备注(如:人工手动完成购卡订单)',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'ali_id',
),
),
'pay_uid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'pay_uid',
),
),
'pay_type'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'pay_type',
),
),
'pay_yao_uid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'pay_yao_uid',
),
),
'idx_pay_id'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'pay_id',
),
),
'idx_pay_id_daihao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'pay_id',
1=> 'pay_daihao',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_pay_log` (
`pay_id` varchar(32) NOT NULL COMMENT \'支付订单号\',
`ali_id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'自增ID\',
`pay_uid` char(15) NOT NULL COMMENT \'用户UID\',
`pay_date` datetime NOT NULL COMMENT \'支付时间\',
`pay_qian_rmb` float(9,2) NOT NULL COMMENT \'支付前余额\',
`pay_rmb` float(9,2) NOT NULL COMMENT \'支付金额\',
`pay_ka_shuliang` int(11) NOT NULL COMMENT \'卡数量\',
`pay_zhuangtai` tinyint(1) NOT NULL COMMENT \'状态\',
`ka_shijia` float(9,2) NOT NULL COMMENT \'卡市价\',
`ka_zhe_jia` float(9,2) NOT NULL COMMENT \'卡折后价\',
`ali_ka_name` char(255) NOT NULL COMMENT \'卡类名称\',
`ali_ka_jiage` float(9,2) NOT NULL COMMENT \'卡价格\',
`ali_ka_zhe` float(2,1) NOT NULL COMMENT \'卡折扣\',
`ali_ka_date` int(11) NOT NULL COMMENT \'卡天数\',
`pay_daihao` int(8) NOT NULL COMMENT \'软件代号\',
`pay_app_name` varchar(50) DEFAULT NULL COMMENT \'软件名称\',
`pay_type` int(1) NOT NULL COMMENT \'支付类型\',
`pay_yao_uid` int(11) NOT NULL DEFAULT \'0\' COMMENT \'推荐人UID(0=无)\',
`pay_remark` varchar(100) NOT NULL DEFAULT \'\' COMMENT \'备注(如:人工手动完成购卡订单)\',
PRIMARY KEY (`ali_id`),
KEY `pay_uid` (`pay_uid`),
KEY `pay_type` (`pay_type`),
KEY `pay_yao_uid` (`pay_yao_uid`),
KEY `idx_pay_id` (`pay_id`),
KEY `idx_pay_id_daihao` (`pay_id`,`pay_daihao`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT=\'购卡支付日志\'',
),
'bs_php_paydata'=>
array (
'columns'=>
array (
'pay_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付ID',
),
'pay_date'=>
array (
'type'=> 'double',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付时间',
),
'pay_uid'=>
array (
'type'=> 'varchar(100)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户UID',
),
'pay_rmb'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付金额',
),
'pay_uid_rbm'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户余额',
),
'pay_uid_rmb2'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户余额2',
),
'pay_fanshi'=>
array (
'type'=> 'varchar(10)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付方式',
),
'pay_zhuangtai'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付状态',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'pay_id',
),
),
'pay_uid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'pay_uid',
),
),
'pay_zhuangtai'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'pay_zhuangtai',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_paydata` (
`pay_id` int(11) NOT NULL COMMENT \'支付ID\',
`pay_date` double NOT NULL COMMENT \'支付时间\',
`pay_uid` varchar(100) NOT NULL COMMENT \'用户UID\',
`pay_rmb` float(9,2) NOT NULL COMMENT \'支付金额\',
`pay_uid_rbm` float(9,2) NOT NULL COMMENT \'用户余额\',
`pay_uid_rmb2` float(9,2) NOT NULL COMMENT \'用户余额2\',
`pay_fanshi` varchar(10) NOT NULL COMMENT \'支付方式\',
`pay_zhuangtai` tinyint(1) NOT NULL COMMENT \'支付状态\',
PRIMARY KEY (`pay_id`),
KEY `pay_uid` (`pay_uid`),
KEY `pay_zhuangtai` (`pay_zhuangtai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\'支付数据表\'',
),
'bs_php_rmb_pay_log'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> 'ID',
),
'pay_id'=>
array (
'type'=> 'varchar(32)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付订单号',
),
'pay_uid'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户UID',
),
'pay_lei'=>
array (
'type'=> 'varchar(50)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付类型',
),
'pay_rbm'=>
array (
'type'=> 'float(9,2)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付金额',
),
'pay_zhuangtai'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '状态',
),
'pay_info1'=>
array (
'type'=> 'varchar(32)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '扩展信息1',
),
'pay_info2'=>
array (
'type'=> 'varchar(32)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '扩展信息2',
),
'pay_date'=>
array (
'type'=> 'datetime',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '支付时间',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
'idx_pay_id'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'pay_id',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_rmb_pay_log` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'ID\',
`pay_id` varchar(32) NOT NULL COMMENT \'支付订单号\',
`pay_uid` int(11) NOT NULL COMMENT \'用户UID\',
`pay_lei` varchar(50) NOT NULL COMMENT \'支付类型\',
`pay_rbm` float(9,2) NOT NULL COMMENT \'支付金额\',
`pay_zhuangtai` tinyint(1) NOT NULL COMMENT \'状态\',
`pay_info1` varchar(32) DEFAULT NULL COMMENT \'扩展信息1\',
`pay_info2` varchar(32) DEFAULT NULL COMMENT \'扩展信息2\',
`pay_date` datetime NOT NULL COMMENT \'支付时间\',
PRIMARY KEY (`id`),
KEY `idx_pay_id` (`pay_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT=\'人民币支付日志\'',
),
'bs_php_sysconfig'=>
array (
'columns'=>
array (
'sys_ini'=>
array (
'type'=> 'varchar(32)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '配置键',
),
'sys_val'=>
array (
'type'=> 'varchar(2000)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '配置值',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'sys_ini',
),
),
'sys_ini'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'sys_ini',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_sysconfig` (
`sys_ini` varchar(32) NOT NULL COMMENT \'配置键\',
`sys_val` varchar(2000) DEFAULT NULL COMMENT \'配置值\',
PRIMARY KEY (`sys_ini`),
KEY `sys_ini` (`sys_ini`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\'数据配置\'',
),
'bs_php_user'=>
array (
'columns'=>
array (
'user_uid'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '用户UID',
),
'user_user'=>
array (
'type'=> 'varchar(50)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户名',
),
'user_pwd'=>
array (
'type'=> 'varchar(32)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '密码',
),
'user_IsLock'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '是否锁定',
),
'user_email'=>
array (
'type'=> 'varchar(45)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '邮箱',
),
'user_mail_ok'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '邮箱验证',
),
'user_qq'=>
array (
'type'=> 'varchar(15)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> 'QQ',
),
'user_Mobile'=>
array (
'type'=> 'varchar(11)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '手机',
),
'user_mibao_wenti'=>
array (
'type'=> 'char(20)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '密保问题',
),
'user_mibao_daan'=>
array (
'type'=> 'char(20)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '密保答案',
),
'user_rmb'=>
array (
'type'=> 'float(9,2)',
'nullable'=> true,
'default'=> '0.00',
'extra'=> '',
'comment'=> '余额',
),
'user_jifen'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '积分',
),
'user_re_ip'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'user_re_date'=>
array (
'type'=> 'datetime',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '注册时间',
),
'user_Login_ip'=>
array (
'type'=> 'char(255)',
'nullable'=> true,
'default'=> '',
'extra'=> '',
'comment'=> '',
),
'user_Login_date'=>
array (
'type'=> 'datetime',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '登录时间',
),
'user_CaoShi'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '操作次数',
),
'user_yao_User'=>
array (
'type'=> 'char(150)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '邀请人',
),
'user_yao_Shu'=>
array (
'type'=> 'int(10)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '邀请数',
),
'user_Zhe'=>
array (
'type'=> 'float(9,1)',
'nullable'=> true,
'default'=> '0.0',
'extra'=> '',
'comment'=> '折扣',
),
'user_LoGinNum'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '登录次数',
),
'user_DenJi_tmp'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '等级临时',
),
'user_DenJi'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '等级',
),
'user_daili'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '是否代理',
),
'user_is_pwd'=>
array (
'type'=> 'int(11)',
'nullable'=> true,
'default'=> '0',
'extra'=> '',
'comment'=> '是否禁止修改密码',
),
'user_beizhu'=>
array (
'type'=> 'varchar(200)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户备注',
),
'user_anget_carid'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '代理卡串',
),
'user_anget_beizhu'=>
array (
'type'=> 'varchar(255)',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '代理商备注',
),
'user_extra'=>
array (
'type'=> 'longtext',
'nullable'=> true,
'default'=> NULL,
'extra'=> '',
'comment'=> '用户拓展字段JSON',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'user_uid',
),
),
'user_user'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'user_user',
),
),
'user_IsLock'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_IsLock',
),
),
'user_mail_ok'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_mail_ok',
),
),
'user_anget_beizhu'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_anget_beizhu',
),
),
'user_anget_carid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_anget_carid',
),
),
'user_beizhu'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_beizhu',
),
),
'user_daili'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_daili',
),
),
'user_LoGinNum'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_LoGinNum',
),
),
'user_Login_date'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_Login_date',
),
),
'user_Login_ip'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_Login_ip',
),
),
'user_re_date'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_re_date',
),
),
'user_re_ip'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_re_ip',
),
),
'user_rmb'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_rmb',
),
),
'user_mibao_wenti'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_mibao_wenti',
),
),
'user_Mobile'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_Mobile',
),
),
'user_qq'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_qq',
),
),
'user_email'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_email',
),
),
'user_pwd'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'user_pwd',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_user` (
`user_uid` int(11) NOT NULL AUTO_INCREMENT COMMENT \'用户UID\',
`user_user` varchar(50) NOT NULL COMMENT \'用户名\',
`user_pwd` varchar(32) NOT NULL COMMENT \'密码\',
`user_IsLock` tinyint(1) DEFAULT \'0\' COMMENT \'是否锁定\',
`user_email` varchar(45) DEFAULT NULL COMMENT \'邮箱\',
`user_mail_ok` tinyint(1) DEFAULT \'0\' COMMENT \'邮箱验证\',
`user_qq` varchar(15) DEFAULT NULL COMMENT \'QQ\',
`user_Mobile` varchar(11) DEFAULT NULL COMMENT \'手机\',
`user_mibao_wenti` char(20) DEFAULT NULL COMMENT \'密保问题\',
`user_mibao_daan` char(20) DEFAULT NULL COMMENT \'密保答案\',
`user_rmb` float(9,2) DEFAULT \'0.00\' COMMENT \'余额\',
`user_jifen` int(11) DEFAULT \'0\' COMMENT \'积分\',
`user_re_ip` varchar(255) DEFAULT \'\',
`user_re_date` datetime DEFAULT NULL COMMENT \'注册时间\',
`user_Login_ip` char(255) DEFAULT \'\',
`user_Login_date` datetime DEFAULT NULL COMMENT \'登录时间\',
`user_CaoShi` int(11) DEFAULT \'0\' COMMENT \'操作次数\',
`user_yao_User` char(150) DEFAULT NULL COMMENT \'邀请人\',
`user_yao_Shu` int(10) DEFAULT \'0\' COMMENT \'邀请数\',
`user_Zhe` float(9,1) DEFAULT \'0.0\' COMMENT \'折扣\',
`user_LoGinNum` int(11) DEFAULT \'0\' COMMENT \'登录次数\',
`user_DenJi_tmp` int(11) DEFAULT \'0\' COMMENT \'等级临时\',
`user_DenJi` int(11) DEFAULT \'0\' COMMENT \'等级\',
`user_daili` tinyint(1) DEFAULT \'0\' COMMENT \'是否代理\',
`user_is_pwd` int(11) DEFAULT \'0\' COMMENT \'是否禁止修改密码\',
`user_beizhu` varchar(200) DEFAULT NULL COMMENT \'用户备注\',
`user_anget_carid` varchar(255) DEFAULT NULL COMMENT \'代理卡串\',
`user_anget_beizhu` varchar(255) DEFAULT NULL COMMENT \'代理商备注\',
`user_extra` longtext COMMENT \'用户拓展字段JSON\',
PRIMARY KEY (`user_uid`),
UNIQUE KEY `user_user` (`user_user`),
KEY `user_IsLock` (`user_IsLock`),
KEY `user_mail_ok` (`user_mail_ok`),
KEY `user_anget_beizhu` (`user_anget_beizhu`),
KEY `user_anget_carid` (`user_anget_carid`),
KEY `user_beizhu` (`user_beizhu`),
KEY `user_daili` (`user_daili`),
KEY `user_LoGinNum` (`user_LoGinNum`),
KEY `user_Login_date` (`user_Login_date`),
KEY `user_Login_ip` (`user_Login_ip`),
KEY `user_re_date` (`user_re_date`),
KEY `user_re_ip` (`user_re_ip`),
KEY `user_rmb` (`user_rmb`),
KEY `user_mibao_wenti` (`user_mibao_wenti`),
KEY `user_Mobile` (`user_Mobile`),
KEY `user_qq` (`user_qq`),
KEY `user_email` (`user_email`),
KEY `user_pwd` (`user_pwd`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT=\'用户表\'',
),
'bs_php_user_rmb_log'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '',
),
'log_uid'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '用户UID',
),
'log_user'=>
array (
'type'=> 'varchar(50)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '用户账号',
),
'log_before'=>
array (
'type'=> 'decimal(12,2)',
'nullable'=> false,
'default'=> '0.00',
'extra'=> '',
'comment'=> '变动前余额',
),
'log_after'=>
array (
'type'=> 'decimal(12,2)',
'nullable'=> false,
'default'=> '0.00',
'extra'=> '',
'comment'=> '变动后余额',
),
'log_delta'=>
array (
'type'=> 'decimal(12,2)',
'nullable'=> false,
'default'=> '0.00',
'extra'=> '',
'comment'=> '变动金额(正=增加 负=减少)',
),
'log_reason'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '变动原因',
),
'log_order'=>
array (
'type'=> 'varchar(64)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '关联订单号等',
),
'log_date'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '时间戳',
),
'log_ip'=>
array (
'type'=> 'varchar(64)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> 'IP',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
'log_uid'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_uid',
),
),
'log_user'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_user',
),
),
'log_date'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_date',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_user_rmb_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`log_uid` int(11) NOT NULL DEFAULT \'0\' COMMENT \'用户UID\',
`log_user` varchar(50) NOT NULL DEFAULT \'\' COMMENT \'用户账号\',
`log_before` decimal(12,2) NOT NULL DEFAULT \'0.00\' COMMENT \'变动前余额\',
`log_after` decimal(12,2) NOT NULL DEFAULT \'0.00\' COMMENT \'变动后余额\',
`log_delta` decimal(12,2) NOT NULL DEFAULT \'0.00\' COMMENT \'变动金额(正=增加 负=减少)\',
`log_reason` varchar(255) NOT NULL DEFAULT \'\' COMMENT \'变动原因\',
`log_order` varchar(64) NOT NULL DEFAULT \'\' COMMENT \'关联订单号等\',
`log_date` int(11) NOT NULL DEFAULT \'0\' COMMENT \'时间戳\',
`log_ip` varchar(64) NOT NULL DEFAULT \'\' COMMENT \'IP\',
PRIMARY KEY (`id`),
KEY `log_uid` (`log_uid`),
KEY `log_user` (`log_user`),
KEY `log_date` (`log_date`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT=\'用户余额变动日志\'',
),
'bs_php_userclass'=>
array (
'columns'=>
array (
'class_id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '分组ID',
),
'class_name'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '分组名称',
),
'calss_mark'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '分组标识',
),
'class_daihao'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> '',
'comment'=> '软件代号',
),
),
'indexes'=>
array (
'class_id'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'class_id',
),
),
'class_daihao'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'class_daihao',
),
),
'class_id_2'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'class_id',
),
),
'calss_mark'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'calss_mark',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_userclass` (
`class_id` int(11) NOT NULL AUTO_INCREMENT COMMENT \'分组ID\',
`class_name` varchar(255) NOT NULL COMMENT \'分组名称\',
`calss_mark` varchar(255) NOT NULL COMMENT \'分组标识\',
`class_daihao` int(11) NOT NULL COMMENT \'软件代号\',
UNIQUE KEY `class_id` (`class_id`),
KEY `class_daihao` (`class_daihao`),
KEY `class_id_2` (`class_id`),
KEY `calss_mark` (`calss_mark`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT=\'用户分组表\'',
),
'bs_php_yao_money_log'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '',
),
'log_user'=>
array (
'type'=> 'varchar(50)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '获得佣金的用户账号',
),
'log_desc'=>
array (
'type'=> 'varchar(500)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '描述',
),
'log_amount'=>
array (
'type'=> 'decimal(10,2)',
'nullable'=> false,
'default'=> '0.00',
'extra'=> '',
'comment'=> '分成金额',
),
'log_level'=>
array (
'type'=> 'char(1)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '级别 A/B/C',
),
'log_consumer_uid'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '消费用户UID',
),
'log_order'=>
array (
'type'=> 'varchar(64)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '分成订单号(关联支付订单,便于退款)',
),
'log_status'=>
array (
'type'=> 'tinyint(1)',
'nullable'=> false,
'default'=> '1',
'extra'=> '',
'comment'=> '0=待审核 1=分成完毕 2=退款订单',
),
'log_remark'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '备注',
),
'log_date'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '时间戳',
),
'log_ip'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> 'IP',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
'log_user'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_user',
),
),
'log_date'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_date',
),
),
'log_amount'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_amount',
),
),
'log_status'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_status',
),
),
'log_order'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_order',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_yao_money_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`log_user` varchar(50) NOT NULL DEFAULT \'\' COMMENT \'获得佣金的用户账号\',
`log_desc` varchar(500) NOT NULL DEFAULT \'\' COMMENT \'描述\',
`log_amount` decimal(10,2) NOT NULL DEFAULT \'0.00\' COMMENT \'分成金额\',
`log_level` char(1) NOT NULL DEFAULT \'\' COMMENT \'级别 A/B/C\',
`log_consumer_uid` int(11) NOT NULL DEFAULT \'0\' COMMENT \'消费用户UID\',
`log_order` varchar(64) NOT NULL DEFAULT \'\' COMMENT \'分成订单号(关联支付订单,便于退款)\',
`log_status` tinyint(1) NOT NULL DEFAULT \'1\' COMMENT \'0=待审核 1=分成完毕 2=退款订单\',
`log_remark` varchar(255) NOT NULL DEFAULT \'\' COMMENT \'备注\',
`log_date` int(11) NOT NULL DEFAULT \'0\' COMMENT \'时间戳\',
`log_ip` varchar(255) NOT NULL DEFAULT \'\' COMMENT \'IP\',
PRIMARY KEY (`id`),
KEY `log_user` (`log_user`),
KEY `log_date` (`log_date`),
KEY `log_amount` (`log_amount`),
KEY `log_status` (`log_status`),
KEY `log_order` (`log_order`(32))
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT=\'佣金提成日志\'',
),
'bs_php_yao_registration_log'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '',
),
'log_user'=>
array (
'type'=> 'varchar(50)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '邀请人账号',
),
'log_beinvited'=>
array (
'type'=> 'varchar(100)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '被邀请人账号',
),
'log_desc'=>
array (
'type'=> 'varchar(500)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> '描述',
),
'log_jifen'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '获得积分',
),
'log_date'=>
array (
'type'=> 'int(11)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '时间戳',
),
'log_ip'=>
array (
'type'=> 'varchar(255)',
'nullable'=> false,
'default'=> '',
'extra'=> '',
'comment'=> 'IP',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
'log_user'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_user',
),
),
'log_date'=>
array (
'unique'=> false,
'columns'=>
array (
0=> 'log_date',
),
),
),
'create_sql'=> 'CREATE TABLE `bs_php_yao_registration_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`log_user` varchar(50) NOT NULL DEFAULT \'\' COMMENT \'邀请人账号\',
`log_beinvited` varchar(100) NOT NULL DEFAULT \'\' COMMENT \'被邀请人账号\',
`log_desc` varchar(500) NOT NULL DEFAULT \'\' COMMENT \'描述\',
`log_jifen` int(11) NOT NULL DEFAULT \'0\' COMMENT \'获得积分\',
`log_date` int(11) NOT NULL DEFAULT \'0\' COMMENT \'时间戳\',
`log_ip` varchar(255) NOT NULL DEFAULT \'\' COMMENT \'IP\',
PRIMARY KEY (`id`),
KEY `log_user` (`log_user`),
KEY `log_date` (`log_date`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT=\'邀请推广日志\'',
),
'custom_data_werew'=>
array (
'columns'=>
array (
'id'=>
array (
'type'=> 'bigint(20) unsigned',
'nullable'=> false,
'default'=> NULL,
'extra'=> 'auto_increment',
'comment'=> '',
),
'created_at'=>
array (
'type'=> 'bigint(13)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '',
),
'updated_at'=>
array (
'type'=> 'bigint(13)',
'nullable'=> false,
'default'=> '0',
'extra'=> '',
'comment'=> '',
),
),
'indexes'=>
array (
'PRIMARY'=>
array (
'unique'=> true,
'columns'=>
array (
0=> 'id',
),
),
),
'create_sql'=> 'CREATE TABLE `custom_data_werew` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`created_at` bigint(13) NOT NULL DEFAULT \'0\',
`updated_at` bigint(13) NOT NULL DEFAULT \'0\',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8',
),
),
);
