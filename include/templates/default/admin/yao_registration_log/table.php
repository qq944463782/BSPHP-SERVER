<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������("sys", "name") ?>- <?php echo ��������������������������������������������������������������������������������('邀请推广管理'); ?> Bsphp-Pro</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=1580">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
</head>
<body>
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('邀请推广管理'); ?></div>
<div class="layui-card-body">
<div class="layui-form layui-card-header layuiadmin-card-header-auto">
<div class="layui-form-item">
<div class="layui-inline">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('搜索字段'); ?></label>
<div class="layui-input-block">
<select name="soso_id" id="soso_id">
<option value="1"><?php echo ��������������������������������������������������������������������������������('推荐人账号'); ?></option>
<option value="2"><?php echo ��������������������������������������������������������������������������������('被邀请人账号'); ?></option>
<option value="3"><?php echo ��������������������������������������������������������������������������������('描述'); ?></option>
</select>
</div>
</div>
<div class="layui-inline">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('关键字:'); ?></label>
<div class="layui-input-block" style="width:200px">
<input type="text" name="soso" id="soso" placeholder="<?php echo ��������������������������������������������������������������������������������('请输入'); ?>" autocomplete="off" class="layui-input">
</div>
</div>
<div class="layui-inline">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('排序'); ?></label>
<div class="layui-input-block" style="width:100px">
<select name="DESC" id="DESC">
<option value="0"><?php echo ��������������������������������������������������������������������������������('倒序'); ?></option>
<option value="1"><?php echo ��������������������������������������������������������������������������������('正序'); ?></option>
</select>
</div>
</div>
<div class="layui-inline">
<button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="LAY-user-front-search">
<i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
</button>
</div>
</div>
</div>
<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>bsphp_report_quickstat('<?php echo ��������������������������������������������������������������������������������("邀请推广管理"); ?>');var Bsphp_G_TO='<?php echo ��������������������������������������������������������������������������������('到'); ?>';var Bsphp_G_P='<?php echo ��������������������������������������������������������������������������������('页'); ?>';var Bsphp_G_ALL='<?php echo ��������������������������������������������������������������������������������('共'); ?>';var Bsphp_G_OK='<?php echo ��������������������������������������������������������������������������������('确认'); ?>';var Bsphp_G_E='<?php echo ��������������������������������������������������������������������������������('条'); ?>';layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/',version: "20240311"}).extend({index: 'lib/index'}).use(['jquery', 'index', 'table', 'layer'], function() {var admin=layui.admin,$=layui.$,table=layui.table;table.render({elem: '#test-table-toolbar',url: 'index.php?m=admin&c=yao_registration_log&a=table_json&json=get&soso_ok=1',title: '<?php echo ��������������������������������������������������������������������������������('邀请推广管理'); ?>',height: 'full-290',cols: [[{ type: 'checkbox', fixed: 'left' },{ field: 'id', width: 80, title: '<?php echo ��������������������������������������������������������������������������������('编号'); ?>', sort: true },{ field: 'log_user', width: 150, title: '<?php echo ��������������������������������������������������������������������������������('推荐人账号'); ?>', sort: true },{ field: 'log_beinvited', width: 200, title: '<?php echo ��������������������������������������������������������������������������������('被邀请人账号'); ?>', sort: true },{ field: 'log_jifen', width: 130, title: '<?php echo ��������������������������������������������������������������������������������('推荐获得积分'); ?>', sort: true },{ field: 'log_date', width: 160, title: '<?php echo ��������������������������������������������������������������������������������('注册时间'); ?>', sort: true },{ field: 'log_ip', title: '<?php echo ��������������������������������������������������������������������������������('IP地址'); ?>' }]],page: true});$('.layuiadmin-btn-useradmin').on('click', function() {table.reload('test-table-toolbar', {where: {soso: $('#soso').val(),soso_id: $('#soso_id').val(),DESC: $('#DESC').val()},page: {curr: 1}});});});</script>
</body>
</html>
