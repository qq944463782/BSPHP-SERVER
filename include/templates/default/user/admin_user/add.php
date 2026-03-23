
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP ECHO ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115),����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('注册新用户Bsphp-Pro'); ?></title>
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
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('注册新用户'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="" name="bsphppost" id="bsphppost"  method="post"    >
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('账号'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="user" id="user"  placeholder="<?php echo ��������������������������������������������������������������������������������('6-8位建议'); ?>"  value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('登录账号'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('密码'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="pwd" id="pwd"  placeholder="<?php echo ��������������������������������������������������������������������������������('6-10位建议'); ?>" value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('登录密码 建议不要过于简单'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('联系QQ'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="qq" id="qq"  placeholder="<?php echo ��������������������������������������������������������������������������������('944463782'); ?>"  value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('联系方式'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('邮箱'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="mail" id="mail"  placeholder="admin@bsphp.com"  value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('联系方式'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('联系电话'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="mobile" id="mobile"  placeholder="<?php echo ��������������������������������������������������������������������������������('15278888888'); ?>"  value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('联系方式'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('邀请人'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="yao_user" id="yao_user" placeholder="<?php echo ��������������������������������������������������������������������������������('xiaozhou'); ?>" value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('上级邀请人账号'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('设置代理'); ?></label>
<div class="layui-input-block">
<input type="radio" name="agent" onclick="alert('注册成功后,需要给代理编辑分配软件,代理有权限制卡')" value="1" title="<?php echo ��������������������������������������������������������������������������������('注册一级代理');?>">
<input name="agent" type="radio" title="<?php echo ��������������������������������������������������������������������������������('注册普通用户');?>" value="0" checked="CHECKED">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('注册成功后,需要给代理编辑分配软件,代理有权限制卡'); ?></div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<input id="admin" type="hidden" name="appenconfig"   value="1">
<button class="layui-btn" id="setpost" name="setpost"  ><?php echo ��������������������������������������������������������������������������������('确认保存'); ?></button>
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
<script>layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['index', 'set','jquery','table','layer'],function(){var  $=layui.$,layer=layui.layer;$('#setpost').on('click', function(){var formData=$('#bsphppost').serialize();$.ajax({type: 'post',url: '',data: formData,success: function(ret) {layer.alert(ret.msg);}});return false;});});</script>
</body>
</html>