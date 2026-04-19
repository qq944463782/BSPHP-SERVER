<?php
/*
<api>
  <name>globalinfo.in</name>
  <title>取软件配置信息段</title>
    <intro>接口参数说明</intro>
  <common_params type="1">
    <param name="api" type="1" required="true" dtype="string" desc="API接口名称"></param>
    <param name="BSphpSeSsL" type="1" required="true" dtype="string" desc="BSphpSeSsL连接Cookies"></param>
    <param name="date" type="1" required="false" dtype="string" desc="服务器时间超时验证；可空，后台设置超时0即关闭"></param>
    <param name="mutualkey" type="1" required="true" dtype="string" desc="通信认证Key，用作软件数据包交换数据验证串"></param>
    <param name="appsafecode" type="1" required="false" dtype="string" desc="封包劫持检测；可空，客户端提交参数给服务器时原样返回"></param>
    <param name="md5" type="1" required="false" dtype="string" desc="程序MD5；可空，后台MD5内容要为空"></param>
  </common_params>

  <params>
    <param name="info" required="false" type="string" desc="信息字段，一次可以获取那些值"></param>
  </params>
</api>
*/



/***********************接口介绍说明******************************************
 * globalinfo.in
 * 取软件配置信息段
 * *****************************************************************************
 */

$info=Plug_Set_Data('info');  #信息字段，一次可以获取那些值
/**
 * 信息字段：
GLOBAL_WEBURL=取Web浏览地址
GLOBAL_URL=预设URL地址 
GLOBAL_LOGICA=逻辑提示A
GLOBAL_LOGICINFOA=逻辑提示A内容
GLOBAL_LOGICB=逻辑提示B
GLOBAL_LOGICINFOB=逻辑提示B内容
GLOBAL_BSPHPDATE=Bsphp服务器系统时间
GLOBAL_BSPHPUNIX=Bsphp服务器系统时间UNIX时间
GLOBAL_V=版本号
GLOBAL_INTERNET=网络通信验证 正常返回1,错误返回服务器代码
GLOBAL_GG=取软件公告
GLOBAL_MIAOSHU=取软件公告
GLOBAL_SENDDATE=注册赠送时间 单位:秒
GLOBAL_TURN=转绑定扣除时间 单位:秒
GLOBAL_LINKS=软件最大同时连接数
GLOBAL_CHARGESET=是否免费模式,免费模式 = 1
*/
$info=str_replace('GLOBAL_WEBURL',Plug_App_DaTa('app_WEB_URL'),$info);
$info=str_replace('GLOBAL_URL',Plug_App_DaTa('app_URL'),$info);
$info=str_replace('GLOBAL_LOGICA',Plug_App_DaTa('app_LogicA'),$info);
$info=str_replace('GLOBAL_LOGICINFOA',Plug_App_DaTa('app_LogicinfoA'),$info);
$info=str_replace('GLOBAL_LOGICB',Plug_App_DaTa('app_LogicB'),$info);
$info=str_replace('GLOBAL_LOGICINFOB',Plug_App_DaTa('app_LogicinfoB'),$info);
$info=str_replace('GLOBAL_BSPHPDATE',PLUG_DATE(),$info);
$info=str_replace('GLOBAL_BSPHPUNIX',PLUG_UNIX(),$info);
$info=str_replace('GLOBAL_V',Plug_App_DaTa('app_v'),$info);
$info=str_replace('GLOBAL_INTERNET','1',$info);
$info=str_replace('GLOBAL_GG',Plug_App_DaTa('app_gg'),$info);
$info=str_replace('GLOBAL_MIAOSHU',Plug_App_DaTa('app_miaoshu'),$info);
$info=str_replace('GLOBAL_SENDDATE',Plug_App_DaTa('app_re_date'),$info);
$info=str_replace('GLOBAL_TURN',Plug_App_DaTa('app_zhuang_date'),$info);
$info=str_replace('GLOBAL_LINKS',Plug_App_DaTa('app_links'),$info);
$info=str_replace('GLOBAL_CHARGESET',Plug_App_DaTa('app_chargeset'),$info);



Plug_Echo_Info($info,200);
?>