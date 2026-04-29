<?php
$arr=��������������������������������������������������������������������������������($this->user_array['user_user']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name"); ?> - <?php echo Plug_Lang('代理商管理平台'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
<style>body.agent-dashboard {background: #f4f7fb;}.agent-dashboard .layui-fluid {padding-top: 18px;padding-bottom: 18px;}.agent-dashboard .layui-card {border: 1px solid #eaf0f7;border-radius: 12px;box-shadow: 0 8px 22px rgba(31, 45, 61, 0.06);transition: transform .2s ease, box-shadow .2s ease;overflow: hidden;}.agent-dashboard .layui-card:hover {transform: translateY(-2px);box-shadow: 0 12px 28px rgba(31, 45, 61, 0.1);}.agent-dashboard .layui-card-header {min-height: 50px;line-height: 50px;padding: 0 16px;font-weight: 600;border-bottom: 1px solid #eef3f9;background: linear-gradient(180deg, #ffffff 0%, #f9fbfe 100%);}.agent-dashboard .layui-card-body {padding: 14px 16px;}.agent-dashboard .layuiadmin-big-font {font-size: 30px !important;color: #1f2d3d;line-height: 1.2;margin-bottom: 6px;font-weight: 700;letter-spacing: .5px;}.agent-dashboard .layuiadmin-card-list p {color: #5f6d7a;margin-top: 4px;margin-bottom: 0;}.agent-dashboard .layuiadmin-badge {border-radius: 12px;padding: 0 10px;font-size: 12px;}.agent-dashboard .layuiadmin-home2-usernote li {background: #f8fbff;border: 1px solid #e9f1fc;border-radius: 10px;margin-bottom: 10px;padding: 10px 12px;}.agent-dashboard .layuiadmin-home2-usernote li h3 {font-size: 15px;color: #22354a;margin-bottom: 4px;}.agent-dashboard .layuiadmin-home2-usernote li p {color: #516174;line-height: 1.6;margin-bottom: 4px;word-break: break-all;}.agent-dashboard .layuiadmin-home2-usernote li span {color: #8a97a6;font-size: 12px;}.agent-dashboard .layui-table {border-radius: 10px;overflow: hidden;background: #fff;}.agent-dashboard .layui-table thead tr {background: #f3f8ff;}.agent-dashboard .layui-table th {color: #304156;font-weight: 600;}.agent-dashboard .layui-table td,.agent-dashboard .layui-table th {border-color: #edf2f8;padding: 12px 10px;}.agent-dashboard .layui-table tbody tr:hover {background: #f7fbff;}</style>
</head>
<body class="agent-dashboard">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-sm12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('代理公告'); ?></div>
<div class="layui-card-body">
<ul class="layuiadmin-card-status layuiadmin-home2-usernote">
<?php
if ($this->user_array['user_daili']==1) {
$sql="SELECT*FROM`bs_php_news`WHERE`news_class`='91000' or `news_class`='92000' ORDER BY `news_id` DESC LIMIT 20";
$db_array_value=Plug_Query($sql);
} else {
$sql="SELECT*FROM`bs_php_news`WHERE`news_class`='91000'  ORDER BY `news_id` DESC LIMIT 20";
$db_array_value=Plug_Query($sql);
}
while ($array_value=Plug_Pdo_Fetch_Assoc($db_array_value)) {
if ($array_value['news_class']==91000) {
$array_value['news_class']=Plug_Lang('全体公告');
} else {
$array_value['news_class']=Plug_Lang('总代理可见');
}
$array_value['news_unix']=������������������������������������������������������������������������������������($array_value['news_unix']);
$array_value['news_test']=base64_decode($array_value['news_test']);
echo "
<li>
<h3>{$array_value['news_table']} </h3>
<p>{$array_value['news_test']}</p>
<span>{$array_value['news_unix']} {$array_value['news_class']}</span>
</li>";
}
?>
</ul>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('当前账号余额，可进行上下级交易')?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('账户余额'); ?>
<span class="layui-badge layui-bg-blue layuiadmin-badge"><?php
echo Plug_Get_Configs_Value('sys', 'govicp');
?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php echo ($this->user_array['user_rmb']);  ?></p>
<p>
<?php
echo Plug_Lang(Plug_Get_Configs_Value('sys', 'govicp'));
?>
</span>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('卡列表表里总数'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('卡总数'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$sql="select count(*)as'hangshu'from`bs_php_cardseries`WHERE`car_admin`='{$this->user_array['user_uid']}'";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
$a=$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('卡列表里激活总量'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('已经激活使用'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$sql="select count(*)as'hangshu'from`bs_php_cardseries`WHERE`car_admin`='{$this->user_array['user_uid']}'AND`car_IsLock`='1'  and  `car_zhuangtai`=0  ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('卡列表里没使用充值卡总量，不含库存卡')?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('未激活使用'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$sql="select count(*)as'hangshu'from`bs_php_cardseries`WHERE`car_admin`='{$this->user_array['user_uid']}'AND`car_IsLock`='0'  and  `car_zhuangtai`=0  ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('登录账号数量'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('已冻结卡'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$sql="select count(*)as'hangshu'from`bs_php_cardseries`WHERE`car_admin`='{$this->user_array['user_uid']}' AND `car_zhuangtai`=1  ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('今天制作出来充值卡，包括库卡与现金制卡')?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('今天制卡'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$date=date('Y-m-d');
$sql="select count(*)as'hangshu'from`bs_php_cardseries`WHERE`car_admin`='{$this->user_array['user_uid']}'AND`car_IsLock`='1'  and  `car_zhuangtai`=0 And `car_reDATE` > '{$date}' ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('当前登录账号激活数量'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('今天激活'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$date=date('Y-m-d');
$sql="select count(*)as'hangshu'from`bs_php_cardseries`WHERE`car_admin`='{$this->user_array['user_uid']}'AND`car_IsLock`='1'  and  `car_zhuangtai`=0 And `car_pur_date` > '{$date}' ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('当前登录账号数量'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('今天冻结'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$date=date('Y-m-d');
$sql="select count(*)as'hangshu'from`bs_php_cardseries`WHERE`car_admin`='{$this->user_array['user_uid']}'AND`car_IsLock`='1'  and  `car_zhuangtai`=1 And `car_pur_date` > '{$date}' ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('当前登录账号激活数量'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('昨天激活'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$date=date('Y-m-d');
$date2=date('Y-m-d', time() - 86400);
$sql="select count(*)as'hangshu'from`bs_php_cardseries`WHERE`car_admin`='{$this->user_array['user_uid']}' AND `car_zhuangtai`=1 And `car_reDATE` > '{$date2}'  And `car_reDATE` < '{$date}'";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('没有制作出来激活卡剩余总数，可进行转赠下级交易，也可以收回')?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('库卡总数'); ?>
<span class="layui-badge layui-bg-orange layuiadmin-badge"><?php echo Plug_Lang('库存卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$date=date('Y-m-d');
$sql="select SUM(`kuka_val`)as'hangshu'from`bs_php_kuka`WHERE`kuka_uid`='{$this->user_array['user_uid']}' ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('全部代理由您开始下属N级代理,不包含自己在内'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('全国今天激活'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$int='';
$count=count($arr);
$i=0;
foreach ($arr as $key) {
$i++;
$strtotime=strtotime($date);
$int=$int . $key['user_uid'] . ',';
}
$int=$int . '999999';
$date=date('Y-m-d');
$sql="select count(*)as'hangshu'from`bs_php_cardseries`WHERE   `car_admin`in({$int}) AND`car_IsLock`='1'  and  `car_zhuangtai`=0 And `car_pur_date` > '{$date}' ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张 (包括下下...代理)'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('全部代理由您开始下属N级代理'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('全国昨天激活'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$date=date('Y-m-d');
$date2=date('Y-m-d', time() - 86400);
$sql="select count(*)as'hangshu'from`bs_php_cardseries` WHERE  `car_admin`in({$int}) AND `car_zhuangtai`=1 And `car_reDATE` > '{$date2}'  And `car_reDATE` < '{$date}'";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张 (包括下下...代理)'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('全部代理由您开始下属N级代理,新注册人数'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('全国最近7天激活'); ?>
<span class="layui-badge layui-bg-cyan layuiadmin-badge"><?php echo Plug_Lang('卡'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$date=date('Y-m-d');
$date2=date('Y-m-d', time() - 604800);
$sql="select count(*)as'hangshu'from`bs_php_cardseries` WHERE `car_admin` > 0 AND `car_admin`in({$int}) AND `car_zhuangtai`=1 And `car_reDATE` > '{$date2}' ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('张 (包括下下...代理)'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('表示当前账号下一级管辖代理'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('直属代理总数'); ?>
<span class="layui-badge layui-bg-green layuiadmin-badge"><?php echo Plug_Lang('代理'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$date=date('Y-m-d');
$sql="select count(*)as'hangshu'from`bs_php_user`WHERE  `user_yao_User`='{$this->user_array['user_user']}' ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?></p>
<p>
<?php echo Plug_Lang('人'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('全部代理由您开始下属N级代理,新注册人数'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('今天出生国民'); ?>
<span class="layui-badge layui-bg-green layuiadmin-badge"><?php echo Plug_Lang('代理'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$int=0;
$date=date('Y-m-d');
foreach ($arr as $key) {
$strtotime=strtotime($date);
if (strtotime($key['user_re_date']) > $strtotime) {
$int=$int + 1;
}
}
echo $int;
?></p>
<p>
<?php echo Plug_Lang('人 (包括下下...代理)'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('全部代理由您开始下属N级代理'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('今天王国活跃数'); ?>
<span class="layui-badge layui-bg-green layuiadmin-badge"><?php echo Plug_Lang('代理'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$int=0;
$date=date('Y-m-d');
foreach ($arr as $key) {
$strtotime=strtotime($date);
if (strtotime($key['user_Login_date']) > $strtotime) {
$int=$int + 1;
}
}
echo $int;
?></p>
<p>
<?php echo Plug_Lang('人 (包括下下...代理)'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('全部代理由您开始下属N级代理'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('昨天王国活跃数'); ?>
<span class="layui-badge layui-bg-green layuiadmin-badge"><?php echo Plug_Lang('代理'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$int=0;
$date=date('Y-m-d');
$date2=date('Y-m-d', time() - 86400);
foreach ($arr as $key) {
$strtotime=strtotime($date);
$strtotime2=strtotime($date2);
if (strtotime($key['user_Login_date']) > $strtotime2 and strtotime($key['user_Login_date']) < $strtotime) {
$int=$int + 1;
}
}
echo $int;
?></p>
<p>
<?php echo Plug_Lang('人 (包括下下...代理)'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('全部代理由您开始下属N级代理'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('最近7天全国活跃'); ?>
<span class="layui-badge layui-bg-green layuiadmin-badge"><?php echo Plug_Lang('代理'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$int=0;
$date=date('Y-m-d');
$date2=date('Y-m-d', time() - 604800);
foreach ($arr as $key) {
$strtotime=strtotime($date);
$strtotime2=strtotime($date2);
if (strtotime($key['user_Login_date']) > $strtotime2) {
$int=$int + 1;
}
}
echo $int;
?></p>
<p>
<?php echo Plug_Lang('人 (包括下下...代理)'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('全部代理由您开始下属N级代理'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('全国被冻结总数'); ?>
<span class="layui-badge layui-bg-green layuiadmin-badge"><?php echo Plug_Lang('代理'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
$int=0;
$date=date('Y-m-d');
foreach ($arr as $key) {
if ($key['user_IsLock']==1) {
$int=$int + 1;
}
}
echo $int;
?></p>
<p>
<?php echo Plug_Lang('人 (包括下下...代理)'); ?>
</p>
</div>
</div>
</div>
<div onclick="layer.tips('<?php echo Plug_Lang('全部代理由您开始下属N级代理'); ?>', this, {tips: 3});" class="layui-col-sm6 layui-col-md3">
<div class="layui-card">
<div class="layui-card-header">
<?php echo Plug_Lang('我代理王国总人口'); ?>
<span class="layui-badge layui-bg-green layuiadmin-badge"><?php echo Plug_Lang('代理'); ?></span>
</div>
<div class="layui-card-body layuiadmin-card-list">
<p class="layuiadmin-big-font"><?php
echo count($arr);
?></p>
<p>
<?php echo Plug_Lang('人'); ?>
</p>
</div>
</div>
</div>
<div class="layui-col-sm12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('我的库存卡列表'); ?></div>
<div class="layui-card-body">
<div class="layui-row layui-col-space15">
<div class="layui-col-sm12">
<table class="layui-table layuiadmin-page-table" lay-skin="line">
<thead>
<tr>
<th><?php echo Plug_Lang('软件名称'); ?></th>
<th><?php echo Plug_Lang('卡类名称'); ?></th>
<th><?php echo Plug_Lang('数量'); ?></th>
</tr>
</thead>
<tbody>
<?php
$sql="SELECT*FROM`bs_php_kalei` ";
$dbs_array_value=Plug_Query($sql);
$class_array[0]=Plug_Lang('类型已经删除');
if ($dbs_array_value) {
while ($array_value=Plug_Pdo_Fetch_Assoc($dbs_array_value)) {
$class_array[$array_value["lei_id"]]=$array_value["lei_name"];
}
}
$sql="SELECT `app_daihao`,`app_name` FROM`bs_php_appinfo` ";
$dbs_array_value=Plug_Query($sql);
$class_array[0]=Plug_Lang('软件已经删除');
if ($dbs_array_value) {
while ($array_value=Plug_Pdo_Fetch_Assoc($dbs_array_value)) {
$appclass_array[$array_value['app_daihao']]=$array_value['app_name'];
}
}
$sql="SELECT*FROM`bs_php_kuka` WHERE `kuka_uid`='{$this->user_array['user_uid']}'";
$db_array_value=Plug_Query($sql);
while ($value=Plug_Pdo_Fetch_Assoc($db_array_value)) {
if (isset($appclass_array[$value['kuka_daihao']]) && isset($class_array[$value['kuka_kalei']]))
?>
<tr>
<?php
?>
<td><?php echo $appclass_array[$value['kuka_daihao']]; ?></td>
<td><?php echo $class_array[$value['kuka_kalei']]; ?></td>
<td><?php echo $value['kuka_val']; ?><?php echo Plug_Lang('张'); ?></td>
</tr>
<?php
}
?>
<tr>
<?php
?>
</tbody>
<thead>
<td><?php echo Plug_Lang('合计'); ?></td>
<td></td>
<td><?php
$date=date('Y-m-d');
$sql="select SUM(`kuka_val`)as'hangshu'from`bs_php_kuka`WHERE`kuka_uid`='{$this->user_array['user_uid']}' ";
$tmp_arr=Plug_Query_Array($sql);
echo (int)$tmp_arr['hangshu'];
?><?php echo Plug_Lang('张'); ?></td>
</tr>
</thead>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo Plug_Get_Url_Statics() ?>style/'}).extend({index: 'lib/index'}).use('index');</script>
<div style="display:none;">
<script type="text/javascript">var cnzz_protocol=(("https:"==document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1275305941'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s5.cnzz.com/stat.php%3Fid%3D1275305941' type='text/javascript'%3E%3C/script%3E"));</script>
</body>
</html>