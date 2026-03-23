
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP ECHO ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115),����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('批量封卡'); ?>  Bsphp-Pro</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
</head>
<body>
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('批量封卡'); ?></div>
<div class="layui-card-body">
<form action="" name="bsphppost" id="bsphppost"  method="post"    >
<div class="layui-form layui-card-header layuiadmin-card-header-auto">
<div class="layui-form-item">
<div style="margin-top:10px;" class="layui-col-md12">
<textarea name="textarea" id="textarea" style="height:300px;" placeholder="<?php echo ��������������������������������������������������������������������������������('一行一卡'); ?>" class="layui-textarea"><?php echo $����return（��������������������������������������������������������������������; ?></textarea>
</div>
<input id="admin" type="hidden" name="appenconfig"   value="1">
<button class="layui-btn" lay-submit lay-filter="set_website"><?php echo ��������������������������������������������������������������������������������('确认冻结'); ?></button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<div id="foot">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Pro <?php echo BSPHP_VERSION; ?></a>  Bsphp.com <br>
All Rights Reserved </div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>bsphp_report_quickstat('<?php echo ��������������������������������������������������������������������������������("批量封卡"); ?>');layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['jquery','index', 'table','layer','set'], function(){var admin=layui.admin, $=layui.$,table=layui.table;$('.layuiadmin-btn-useradmin').on('click', function(){var formData=$('#bsphppost').serialize();$.ajax({type:  "post",url: '',data :formData,dataType: "text",success: function(ret) {$('#csshow').val(ret);},error: function(e, t) {layer.alert('<?php echo ��������������������������������������������������������������������������������('接口请求返还异常'); ?>');}})return false;});if( $('#soso').val()!=''){$('.layuiadmin-btn-useradmin').click();}});</script>
</body>
</html>