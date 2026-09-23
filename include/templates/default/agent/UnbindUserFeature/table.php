<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?> - <?php echo Plug_Lang('解除绑定'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
</head>
<body>
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('解除绑定'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="" name="bsphppost" id="bsphppost" method="post">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('软件选择'); ?></label>
<div class="layui-input-inline" style="width:300px;">
<select class="form-control" name="daihao" id="daihao">
<option value=""><?php echo Plug_Lang('请选择软件'); ?></option>
<?php
while ($v=Plug_Pdo_Fetch_Assoc($app_list)) {
echo "<option value='{$v['app_daihao']}'>{$v['app_name']}</option>";
}
?>
</select>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('账号/卡'); ?></label>
<div class="layui-input-inline" style="width:400px;">
<input type="text" name="user" id="user" placeholder="<?php echo Plug_Lang('输入用户账户/卡号'); ?>" value="" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('新绑定'); ?></label>
<div class="layui-input-inline" style="width:400px;">
<input type="text" name="key" id="key" placeholder="<?php echo Plug_Lang('新绑定内容,不绑定新留空'); ?>" value="" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<input type="hidden" name="appenconfig" value="1">
<button class="layui-btn layuiadmin-btn-useradmin layui-btn-normal" lay-submit lay-filter="set_website">
<?php echo Plug_Lang('确认提交'); ?>
</button>
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
<script>layui.config({base: '<?php echo Plug_Get_Url_Statics() ?>style/'}).extend({index: 'lib/index'}).use(['index', 'set']);</script>
</body>
</html>
