<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?>- <?php echo Plug_Lang('库卡制作'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
</head>
<body data="Bsphp-Rsa 2022本系统受国家版权局保护请勿破解或者二次开发传播">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('库存制卡'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="" onsubmit="return false;" name="bsphppost" id="bsphppost" method="post">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('剩余库存'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<select name="select">
<option value="0"><?php echo Plug_Lang('请选择制作类型。。。'); ?></option>
<?php
$i=0;
while ($var=Plug_Pdo_Fetch_Assoc($tmp)) {
if ($var['kuka_val'] > 0 && isset($class_array[$var['kuka_kalei']])) {
echo  '<option value="' . $var['kuka_id'] . '">' . $var['app_name'] . '>' . $class_array[$var['kuka_kalei']] . '  ,' . Plug_Lang('剩余') . $var['kuka_val'] . Plug_Lang('张') . '</option>';
}
$i++;
}
?>
</select>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo Plug_Lang('制卡类型'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('制作数量'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="shu" id="shu" placeholder="<?php echo Plug_Lang('输入数量如:1'); ?>" value="1" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo Plug_Lang('需要制卡数量'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('备注'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="beizhu" id="beizhu" placeholder="<?php echo Plug_Lang('自己可见'); ?>" value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"></div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<input id="admin" type="hidden" name="appenconfig" value="1">
<button class="layui-btn layui-btn-normal" lay-submit lay-filter="set_website"><?php echo Plug_Lang('确认制卡'); ?></button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo Plug_Get_Url_Statics() ?>style/'}).extend({index: 'lib/index'}).use(['index', 'set', 'laydate'], function() {var laydate=layui.laydate;laydate.render({ elem: '#date', type: 'datetime' });});</script>
</body>
</html>
