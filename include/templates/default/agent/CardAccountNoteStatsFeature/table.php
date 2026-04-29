<?php
if ($soso_user=='') {
$soso_user=$soso=$this->user_array['user_user'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?>- <?php echo Plug_Lang('卡备注使用统计'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
</head>
<body data="">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('卡备注使用统计'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form name="formsoso" class="layui-form" method="get" action="">
<div style="margin-left: 10px;">
<div class="layui-input-inline" style="width: 160px;">
<select name="daihao" id="daihao">
<?php
$call_govicp=Plug_Get_Configs_Value('sys', 'govicp');
echo "<option value=\"-1\">" . Plug_Lang('全部软件') . "</option>";
while ($value=Plug_Pdo_Fetch_Assoc($db_array_value_app)) {
echo "<option value=\"{$value['app_daihao']}\">{$value['app_name']}</option>";
}
?>
</select>
</div>
<div class="layui-input-inline" style="width: 120px;">
<input name='soso_beizhu' type='text' id="soso_beizhu" class="layui-input" placeholder="<?php echo Plug_Lang('备注名称'); ?>" value='<?php echo $soso_beizhu ?>' />
</div>
<div class="layui-input-inline" style="width: 120px;">
<select name="date_type" class="txt" id="date_type">
<option value="-1"><?php echo Plug_Lang('全部备注'); ?></option>
<option value="1"><?php echo Plug_Lang('制卡时间'); ?></option>
<option value="0"><?php echo Plug_Lang('使用时间'); ?></option>
</select>
</div>
<div class="layui-input-inline" style="width: 130px;">
<input type="text" name="date1" id="date1" value="<?php echo $date1; ?>" placeholder="<?php echo Plug_Lang('开始 2018-12-05'); ?>" autocomplete="off" class="layui-input">
</div>
<div class="layui-input-inline" style="width: 130px;">
<input type="text" name="date2" id="date2" value="<?php echo $date2; ?>" placeholder="<?php echo Plug_Lang('结束 2018-12-05'); ?>" autocomplete="off" class="layui-input">
</div>
<input name="soso_ok" type="hidden" id="soso_ok" value="ok" />
<div class="layui-input-inline" style="width: 100px;">
<button class="layui-btn layuiadmin-btn-useradmin layui-btn-normal" lay-submit lay-filter="LAY-user-front-search">
<i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
</button>
</div>
<span class="sosodiv">
<input name="act" type="hidden" id="act" value="table">
</span><span class="sosodiv">
<input name="m" type="hidden" id="m" value="<?php echo $_GET['m'] ?>">
<input name="c" type="hidden" id="c" value="<?php echo $_GET['c'] ?>">
<input name="a" type="hidden" id="a" value="<?php echo $_GET['a'] ?>">
</span>
</div>
</form>
<?php
$����������������������������������������������������������������_GET=����������������������������������������������������������������_GET;
$soso_user_sql='';
$soso_id=0;
if ($soso_user !='') {
if ($soso_id==0) {
$soso_user_sql=" AND `user_user`='{$soso_user}' ";
} else {
$soso_user_sql=" AND `user_yao_User`='{$soso_user}' ";
}
}
$sql="SELECT * FROM  `bs_php_user` WHERE  `user_daili`  > 0 {$soso_user_sql}     LIMIT 0 , 3000";
$db_value_user_agent=Plug_Query($sql);
while ($value_user_agent=Plug_Pdo_Fetch_Assoc($db_value_user_agent)) {
if ($date_type==1) {
$date1_sql='';
if ($date1 !='') {
$date1_sql="AND `car_reDATE` > '$date1 00:00:00' ";
}
$date2_sql='';
if ($date2 !='') {
$date2_sql=" AND `car_reDATE` < '$date2 23:59:59' ";
}
} elseif ($date_type==-1) {
$date1_sql='';
$date2_sql='';
} else {
$date1_sql='';
if ($date1 !='') {
$date1_sql="AND `car_pur_date` > '$date1 00:00:00' ";
}
$date2_sql='';
if ($date2 !='') {
$date2_sql=" AND `car_pur_date` < '$date2 23:59:59' ";
}
}
$daihao_sql="";
if ($daihao > 0) {
$daihao_sql=" AND `car_DaiHao`='$daihao' ";
}
$sql="SELECT COUNT( * ) AS  `row` ,  `car_agnet_beizhu` FROM  `bs_php_cardseries` WHERE car_admin='{$value_user_agent['user_uid']}' {$date1_sql} {$date2_sql}  {$daihao_sql} GROUP BY  `car_agnet_beizhu` ORDER BY  `car_agnet_beizhu` LIMIT 3000";
$db_array_value_user=Plug_Query($sql);
$i=0;
while ($value_user=Plug_Pdo_Fetch_Assoc($db_array_value_user)) {
if ($value_user['car_agnet_beizhu']=='') $value_user['car_agnet_beizhu']=Plug_Lang('[无备注]');
if ($soso_beizhu !='') {
if ($soso_beizhu !==$value_user['car_agnet_beizhu']) {
continue;
}
}
$i++;
if ($i==1) {
?>
<table class="layui-table" style="width:98%;margin-left: 10px;" lay-filter="demoEvent">
<thead>
<tr bgcolor="" height="52">
<th width="14%"><?php echo Plug_Lang('账号'); ?></th>
<th width="14%"><?php echo $value_user_agent['user_user'] ?>(<?php echo $value_user_agent['user_uid'] ?>)</th>
<th width="14%"><?php echo Plug_Lang('余额'); ?></th>
<th width="14%"><?php echo $value_user_agent['user_rmb'] ?><?php echo $call_govicp ?></th>
<th width="14%"><?php echo Plug_Lang('卡总量'); ?></th>
<th width="14%"><?php echo $value_user['row'] ?><?php echo Plug_Lang('张'); ?></th>
<th width="*"><?php echo $����������������������������������������������������������������_GET ?></th>
</tr>
<tr bgcolor="" height="52">
<th width="*"><?php echo Plug_Lang('代理备注'); ?></th>
<th width="*"><?php echo Plug_Lang('卡类名称'); ?></th>
<th width="*"><?php echo Plug_Lang('软件名称'); ?></th>
<th width="*"><?php echo Plug_Lang('总数据量'); ?></th>
<th width="*"><?php echo Plug_Lang('已激活'); ?></th>
<th width="*"><?php echo Plug_Lang('未激活'); ?></th>
<th width="*"><?php echo Plug_Lang('已冻结'); ?></th>
</tr>
</thead>
<?php
}
$car_DaiHao='';
if ($daihao > 0) {
$car_DaiHao=" `car_DaiHao`='$daihao' AND ";
}
$sql="SELECT *, COUNT( * ) AS  `row` ,  `car_Lei`FROM  `bs_php_cardseries`where {$car_DaiHao} `car_reDATE` > '{$date1} 00:00:00' AND `car_reDATE` < '{$date2} 24:00:00'  AND  car_admin='{$value_user_agent['user_uid']}'     AND   `car_agnet_beizhu`='{$value_user['car_agnet_beizhu']}' GROUP BY  `car_Lei`ORDER BY  `car_Lei` LIMIT 1000";
$db_array_value=Plug_Query($sql);
while ($value=Plug_Pdo_Fetch_Assoc($db_array_value)) {
$soso_sql=" and `car_agnet_beizhu`='{$value_user['car_agnet_beizhu']}' ";
$app_array=����������������������������_POST����������������������������9������������������������($value['car_DaiHao']);
$lei_array=Plug_Query_One('bs_php_kalei', 'lei_id', $value['car_Lei'], ' * ');
if (!isset($lei_array['lei_name'])) {
$lei_array['lei_name']='<cite style="color: #FF5722;">[卡类已经被删除]</cite>';
}
if (!isset($app_array['app_name'])) {
$app_array['app_name']='<cite style="color: #FF5722;">[软件已经被删除]</cite>';
}
$date1_sql='';
if ($date1 !='') {
$date1_sql=" `car_pur_date` > '$date1 00:00:00' AND  ";
}
$date2_sql='';
if ($date2 !='') {
$date2_sql=" `car_pur_date` < '$date2 23:59:59' AND  ";
}
$sql="select count(*)as'hangshu' from`bs_php_cardseries`WHERE {$date1_sql} {$date2_sql} `car_Lei`={$value['car_Lei']}   AND  car_admin='{$value_user_agent['user_uid']}'  and `car_IsLock`=1 {$soso_sql} and  `car_zhuangtai`=0  and `car_DaiHao`='{$value['car_DaiHao']}'";
$tmp_arr=Plug_Query_Array($sql);
$zongshu_a=(int)$tmp_arr['hangshu'];
$date1_sql='';
if ($date1 !='') {
$date1_sql="  `car_reDATE` > '$date1 00:00:00' AND ";
}
$date2_sql='';
if ($date2 !='') {
$date2_sql="  `car_reDATE` < '$date2 23:59:59' AND  ";
}
$sql="select count(*)as'hangshu' from`bs_php_cardseries`WHERE {$date1_sql} {$date2_sql} `car_Lei`={$value['car_Lei']}   AND  car_admin='{$value_user_agent['user_uid']}'  and  `car_IsLock`=0 {$soso_sql} and  `car_zhuangtai`=0  and `car_DaiHao`='{$value['car_DaiHao']}'";
$tmp_arr=Plug_Query_Array($sql);
$zongshu_b=(int)$tmp_arr['hangshu'];
$sql="select count(*)as'hangshu' from`bs_php_cardseries`WHERE {$date1_sql} {$date2_sql}  `car_Lei`={$value['car_Lei']}  AND  car_admin='{$value_user_agent['user_uid']}'  and  `car_zhuangtai`=1 {$soso_sql} and `car_DaiHao`='{$value['car_DaiHao']}'";
$tmp_arr=Plug_Query_Array($sql);
$zongshu_c=(int)$tmp_arr['hangshu'];
print <<< EOT
<tr   height="22" >
<td height="18" >{$value['car_agnet_beizhu']}</td>
<td height="18" >{$lei_array['lei_name']}(ID{$value['car_Lei']})</td>
<td height="18" >{$app_array['app_name']}&nbsp;</td>
<td><a  onclick="openka('{$value['car_DaiHao']}','{$value['car_Lei']}','all','{$value['car_agnet_beizhu']}');"  href="javascript:void(0);">{$value['row']}张</a></td>
<td><a  onclick="openka('{$value['car_DaiHao']}','{$value['car_Lei']}','in','{$value['car_agnet_beizhu']}');"  href="javascript:void(0);">{$zongshu_a}张</a></td>
<td><a  onclick="openka('{$value['car_DaiHao']}','{$value['car_Lei']}','ok','{$value['car_agnet_beizhu']}');"  href="javascript:void(0);">{$zongshu_b}张</a></td>
<td><a  onclick="openka('{$value['car_DaiHao']}','{$value['car_Lei']}','look','{$value['car_agnet_beizhu']}');"  href="javascript:void(0);">{$zongshu_c}张</a></td>
</tr>
EOT;
}
}
print <<< EOT
</table>
EOT;
}
?>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo Plug_Get_Url_Statics() ?>style/'}).extend({index: 'lib/index'}).use(['index', 'set', 'laydate'], function() {var laydate=layui.laydate;laydate.render({elem: '#date1',type: 'date'});laydate.render({elem: '#date2',type: 'date'});});function openka(daihao, kalei, sdate, beizhu) {var date1=document.getElementById("date1").value;var date2=document.getElementById("date2").value;if (sdate=='all') {var zhuangtai=-1;var on=-1;var date_type=-1;if (date1 !='' || date2 !='') {date_type=1;}}if (sdate=='in') {var zhuangtai=1;var on=1;var date_type=0;}if (sdate=='ok') {var zhuangtai=1;var on=2;var date_type=1;}if (sdate=='look') {var zhuangtai=2;var on=-1;var date_type=1;}var soso=beizhu;var soso_id=2;var index=layer.open({type: 2,title: '<?php echo Plug_Lang('卡列表'); ?>',area: ['700px', '450px'],fixed: false,maxmin: true,content: "index.php?m=agent&c=sp&a=table&daihao=" + daihao + "&soso_ok=1&soso_id=" + soso_id + "&soso=" + soso + "&DESC=0&zhuangtai=" + zhuangtai + "&on=" + on + "&date_type=" + date_type + "&date1=" + date1 + "&date2=" + date2 + "&kalei=" + kalei});layer.full(index);}</script>
<script language="javascript">select_set_text('daihao', <?php echo Plug_Set_Get('daihao'); ?>);select_set_text('soso_id', <?php echo Plug_Set_Get('soso_id'); ?>);select_set_text('date_type', <?php echo Plug_Set_Get('date_type'); ?>);</script>
</body>
</html>