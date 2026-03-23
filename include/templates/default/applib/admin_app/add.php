<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo ����������������������������������������������������������������::������������������������������������������������������������������������������������("sys", "name") ?> - <?php echo ��������������������������������������������������������������������������������('添加新软件'); ?> Bsphp-Pro</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
<style>.app-add-help .layui-word-aux { margin: 4px 0; width: 100%; }.app-add-help .layui-input-block { margin-left: 110px; width: calc(100% - 130px); max-width: 800px; }</style>
</head>
<body data="BSPHP-PRO 2022本系统受国家版权局保护请勿破解或者二次开发传播">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('添加新软件'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" lay-filter="app_add_form">
<form action="" name="bsphppost" id="bsphppost" method="post">
<input type="hidden" name="appenconfig" value="1">
<div class="layui-form-item">
<label class="layui-form-label"><span class="layui-form-mid" style="color:#ff5722;">*</span> <?php echo ��������������������������������������������������������������������������������('软件模式'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<select name="moshi" id="moshi" lay-verify="required">
<?php foreach ($��������������������������������������������������������️‍����️�������������������� as $��������������������������������������������������������������������������������):
$����������������R��������������������2������������������������������������=�������������������������������������������������������������������������������������️‍�($��������������������������������������������������������������������������������);
if (@$����������������R��������������������2������������������������������������['really']==1): ?>
<option value="<?php echo htmlspecialchars($��������������������������������������������������������������������������������); ?>"><?php echo htmlspecialchars($����������������R��������������������2������������������������������������['name']); ?></option>
<?php endif; endforeach; ?>
</select>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('软件验证模式,账号/卡串'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><span class="layui-form-mid" style="color:#ff5722;">*</span> <?php echo ��������������������������������������������������������������������������������('软件名称'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<input name="name" type="text" id="name" placeholder="<?php echo ��������������������������������������������������������������������������������('软件在显示时候名称'); ?>" class="layui-input" lay-verify="required">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('中文/字母'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><span class="layui-form-mid" style="color:#ff5722;">*</span> <?php echo ��������������������������������������������������������������������������������('软件代号'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<input name="daihao" type="text" id="daihao" placeholder="<?php echo ��������������������������������������������������������������������������������('建议统一8位数'); ?>" class="layui-input" lay-verify="required|number" maxlength="8">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('8位数字'); ?></div>
</div>
<div class="layui-form-item app-add-help">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('模式说明'); ?></label>
<div class="layui-input-block">
<p class="layui-word-aux"><?php echo ��������������������������������������������������������������������������������('账号限时模式(演示默认这个):账号顾名思义就是用户可以注册自己账号密码进行登录,限时如今天是2018.11.16号,我软件到期时间2018.11.20号,超过20号就无法在继续使用'); ?></p>
<p class="layui-word-aux"><?php echo ��������������������������������������������������������������������������������('账号扣点模式:账号顾名思义就是用户可以注册自己账号密码进行登录,如用户账号里有100点，用户登录一次扣一个点/执行一个功能任务扣一个点直至扣完'); ?></p>
<p class="layui-word-aux"><?php echo ��������������������������������������������������������������������������������('卡限时模式:用户一般嫌弃麻烦,软件作者只需要后台生成一个激活卡发用户,用户直接拿这张卡进行验证(登录)使用,比登录账号模式减少注册方便快捷实用,限时如今天是2018.11.16号,我软件到期时间2018.11.20号,超过20号就无法在继续使用'); ?></p>
<p class="layui-word-aux"><?php echo ��������������������������������������������������������������������������������('卡扣点模式:用户一般嫌弃麻烦,软件作者只需要后台生成一个激活卡发用户,用户直接拿这张卡进行验证(登录)使用,比登录账号模式减少注册方便快捷实用,如用户账号里有100点，用户登录一次扣一个点/执行一个功'); ?></p>
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<button type="submit" class="layui-btn" lay-submit lay-filter="app_add_submit"><?php echo ��������������������������������������������������������������������������������('确认添加'); ?></button>
<a href="index.php?m=applib&c=admin_app&a=table" class="layui-btn layui-btn-primary"><?php echo ��������������������������������������������������������������������������������('返回列表'); ?></a>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="foot" style="margin-top:20px;padding:10px 0;color:#999;font-size:12px;text-align:center;">
Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Pro <?php echo BSPHP_VERSION; ?></a> Bsphp.com · All Rights Reserved
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>bsphp_report_quickstat('<?php echo ��������������������������������������������������������������������������������("添加新软件"); ?>');layui.config({base: '<?php echo ������������������������������������������������������������������������(); ?>layuiadmin/'}).extend({ index: 'lib/index' }).use(['form', 'layer', 'jquery'], function(){var form=layui.form;var layer=layui.layer;var $=layui.jquery;form.verify({number: function(value){if(value && (isNaN(value) || parseInt(value) <=0)){return '<?php echo addslashes(��������������������������������������������������������������������������������("代号必须为正整数")); ?>';}if(value && value.length > 8){return '<?php echo addslashes(��������������������������������������������������������������������������������("软件代号长度不能超8位数字")); ?>';}}});form.on('submit(app_add_submit)', function(){var loadIndex=layer.load(1);$.ajax({type: 'post',url: 'index.php?m=applib&c=admin_app&a=add',data: $('#bsphppost').serialize(),dataType: 'json',success: function(ret){layer.close(loadIndex);if(ret && ret.msg){if((ret.msg + '').indexOf('<?php echo addslashes(��������������������������������������������������������������������������������("添加成功")); ?>') >=0 || (ret.msg + '').indexOf('添加成功') >=0){layer.msg(ret.msg, {icon: 1}, function(){});} else {layer.msg(ret.msg, {icon: 2});}} else {layer.msg('<?php echo addslashes(��������������������������������������������������������������������������������("请求异常")); ?>', {icon: 2});}},error: function(xhr){layer.close(loadIndex);layer.msg(xhr.responseText || '<?php echo addslashes(��������������������������������������������������������������������������������("请求失败")); ?>', {icon: 2});}});return false;});form.render();});</script>
</body>
</html>
