<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dylib一键生成</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="//cache.bsphp.com/pro-statics/MyBs/admin/layuiadmin/layui/css/layui.css" media="all">
</head>
<body>
<blockquote class="layui-elem-quote layui-text">
注意：用学习开发项目快速集成授权。
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
<legend>配置参数</legend>
</fieldset>
<form class="layui-form" action="dylib.php">
<div class="layui-form-item">
<label class="layui-form-label">服务器地址</label>
<div class="layui-input-block">
<input type="text" name="dizhi"lay-verify="title" autocomplete="off" placeholder="http://xxxxxx?appid=66666666&m=3a9d8b17c0a10b1b77f0544d35e835fa" value="<?php echo @$_GET['appurl']; ?>"  maxlength="110" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label">通信KEY</label>
<div class="layui-input-block">
<input type="text" name="key" lay-verify="required"  value="<?php echo @$_GET['mutualkey']; ?>" maxlength="32" placeholder="417a696c5ee663c14bc6fa48b3f53d51" autocomplete="off" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label">加密密码</label>
<div class="layui-input-block">
<input type="text" name="pwd" lay-verify="required"  value="<?php echo @$_GET['app_pwd']; ?>" maxlength="15" placeholder="password_123" autocomplete="off" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label">签名insgin</label>
<div class="layui-input-block">
<input type="text" name="insgin" lay-verify="required"  value="<?php echo @$_GET['app_insgin']; ?>" maxlength="15" placeholder="[KEY]in123456" placeholder="password_123"  autocomplete="off" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label">签名tosgin</label>
<div class="layui-input-block">
<input type="text" name="tosgin" lay-verify="required"   value="<?php echo @$_GET['app_tosgin']; ?>" maxlength="15" placeholder="[KEY]to456789" autocomplete="off" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label">API匿名密码</label>
<div class="layui-input-block">
<input type="text" name="api_password" lay-verify="required"   value="<?php echo @$_GET['app_api_pwd']; ?>" maxlength="15" placeholder="api_password" autocomplete="off" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label">dylib功能</label>
<div class="layui-input-block" >
<select name="dylib" id="dylib">
<option value='1'>A生成简单弹窗验证库</option>
<option value='2'>B生成简单弹窗信息框提示(引流)</option>
</select>
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" lay-submit="" lay-filter="demo2">提交生成</button>
</div>
</div>
<input type="hidden" name="app_MoShi"   value="<?php echo @$_GET['app_MoShi']; ?>">
</form>
<blockquote class="layui-elem-quote layui-text">
注意：A=弹窗卡模式验证到期的,B=只弹提示公告内容的功能<br>
注意：服务器地址请使用https协议 <br>
</blockquote>
</body>
</html>
<script src="//cache.bsphp.com/pro-statics/MyBs/admin/layuiadmin/layui/bsphp.js"></script>
<script>layui.config({base: '//cache.bsphp.com/pro-statics/MyBs/admin/layuiadmin/'}).extend({index: 'lib/index'}).use(['index', 'set','form'], function(){var form=layui.form;var layer=layui.layer;var  $=layui.$});</script>
