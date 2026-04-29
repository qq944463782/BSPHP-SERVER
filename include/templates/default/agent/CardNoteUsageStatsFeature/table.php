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
<div class="layui-input-inline" style="width: 200px;">
<select name="daihao" id="daihao">
<?php
echo "<option value=\"-1\">" . Plug_Lang('全部软件') . "</option>";
while ($value=Plug_Pdo_Fetch_Assoc($db_array_value_app)) {
echo "<option value=\"{$value['app_daihao']}\">{$value['app_name']}</option>";
}
?>
</select>
</div>
<div class="layui-input-inline" style="width: 150px;">
<select name="date_type" class="txt" id="date_type">
<option value="-1"><?php echo Plug_Lang('不设时间范围'); ?></option>
<option value="1"><?php echo Plug_Lang('制卡时间'); ?></option>
<option value="0"><?php echo Plug_Lang('使用时间'); ?></option>
</select>
</div>
<div class="layui-input-inline" style="width: 160px;">
<input type="text" name="date1" id="date1" value="<?php echo $date1; ?>" placeholder="<?php echo Plug_Lang('开始 2018-12-05'); ?>" autocomplete="off" class="layui-input">
</div>
<div class="layui-input-inline" style="width: 160px;">
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
<table class="layui-table" style="width:98%;margin-left: 10px;" lay-filter="demoEvent">
<thead>
<tr height="52">
<th width="*"><?php echo Plug_Lang('备注名称'); ?></th>
<th width="*"><?php echo Plug_Lang('卡数量'); ?></th>
</tr>
</thead>
<?PHP
if ($db_array_value) {
while ($value=Plug_Pdo_Fetch_Assoc($db_array_value)) {
if ($value[$beizhu_sql]=='') $value[$beizhu_sql]=Plug_Lang('[无备注]');
echo '<tr   height="22" >';
echo "<td>{$value[$beizhu_sql]}</td>";
echo "<td>{$value['row']}" . Plug_Lang('张') . "</td>";
echo '</tr>';
}
} else {
}
?>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo Plug_Get_Url_Statics() ?>style/'}).extend({index: 'lib/index'}).use(['index', 'set', 'laydate'], function() {var laydate=layui.laydate;laydate.render({elem: '#date1',type: 'date'});laydate.render({elem: '#date2',type: 'date'});});</script>
<script language="javascript">select_set_text('soso_id', <?php echo Plug_Set_Get('soso_id'); ?>);select_set_text('date_type', <?php echo Plug_Set_Get('date_type'); ?>);</script>
</body>
</html>