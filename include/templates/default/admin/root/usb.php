
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP ECHO ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115),����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('管理员编辑'); ?>  Bsphp-Pro</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
</head>
<body data="BSPHP-PRO 2022本系统受国家版权局保护请勿破解或者二次开发传播">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('管理员编辑-'); ?><?php echo "{$����������������������������������������������������������������������������['Admin_ID']}" ;?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="" name="bsphppost" id="bsphppost"  method="post"    >
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('管理员账号'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="user" id="user"  value="<?php echo $����������������������������������������������������������������������������['Admin_AdminUserName']; ?>" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('登录密码'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="pass" id="pass"  value="<?php echo ��������������������������������������������������������������������������������('不修改留空'); ?>" placeholder="<?php echo ��������������������������������������������������������������������������������('不修改留空'); ?>" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('安全码'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="pass_key" id="pass_key"  value="<?php echo $����������������������������������������������������������������������������['Admin_MiBao']; ?>" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('说明'); ?></label>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('这里是控制后台大选项权限,建议一般不要开发外人进去'); ?></div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<input id="appenconfig" type="hidden" name="appenconfig"   value="1">
<button class="layui-btn" lay-submit lay-filter="set_website"><?php echo ��������������������������������������������������������������������������������('确认保存'); ?></button>
<button class="layui-btn" onClick='window.location.href="index.php?m=admin&c=root&a=table"; return false;' id="set_back" lay-submit lay-filter="set_back"><?php echo ��������������������������������������������������������������������������������('返回列表'); ?></button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="foot">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Pro <?php echo BSPHP_VERSION; ?></a>  Bsphp.com <br>
All Rights Reserved </div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['index', 'set']);</script>
<script language="javascript"></script>
</body>
</html>