<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP ECHO Plug_Get_Configs_Value("sys","name") ?>- <?php echo Plug_Lang('批量删除充值卡'); ?></title>
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
<div class="layui-card-header"><?php echo Plug_Lang('批量删除充值卡'); ?></div>
<div class="layui-card-body">
<form action="" name="bsphppost" id="bsphppost"  method="post">
<div class="layui-form layui-card-header layuiadmin-card-header-auto">
<div class="layui-form-item">
<div style="margin-top:10px;" class="layui-col-md12">
<textarea name="sosotxt" id="sosotxt" style="height:300px;" placeholder="<?php echo Plug_Lang('批量删除充值卡'); ?>
XXXXXXXXXXXX
XXXXXXXXXXXX
XXXXXXXXXXXX
<?php echo Plug_Lang('一行一个激活码'); ?>
" class="layui-textarea"><?php echo Plug_Set_Post('sosotxt'); ?></textarea>
</div>
<input id="soso_ok" type="submit" style="margin-top: 10px;"  class="layui-btn layui-btn-normal"  name="soso_ok" value="<?php echo Plug_Lang('删除'); ?>">
<BR/>
<div style="margin-top:10px;" class="layui-col-md12">
<textarea name="" id="" style="height:300px;" placeholder="" class="layui-textarea"><?php echo $jieguo; ?></textarea>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo Plug_Get_Url_Statics() ?>style/'}).extend({index: 'lib/index'}).use(['jquery','index', 'table','layer'], function(){var admin=layui.admin, $=layui.$,table=layui.table;$('.layuiadmin-btn-useradmin').on('click', function(){var formData=$('#bsphppost').serialize();$.ajax({type:  "post",url: '',data :formData,dataType: "text",success: function(ret) {$('#csshow').val(ret);},error: function(e, t) {layer.alert('<?php echo Plug_Lang('接口请求返还异常'); ?>');}});return false;});if ($('#soso').val() !='') {$('.layuiadmin-btn-useradmin').click();}});</script>
</body>
</html>
