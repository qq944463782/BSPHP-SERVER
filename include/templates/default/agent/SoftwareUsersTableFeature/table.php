<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?> - <?php echo Plug_Lang('间接软件用户'); ?></title>
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
<div class="layui-card-header"><?php echo Plug_Lang('间接软件用户列表'); ?></div>
<div class="layui-card-body">
<div class="layui-form layui-card-header layuiadmin-card-header-auto">
<div class="layui-form-item">
<div class="layui-inline">
<label class="layui-form-label"><?php echo Plug_Lang('搜索字段'); ?></label>
<div style="width:200px;" class="layui-input-block">
<select name="soso_id" id="soso_id">
<option value="1"><?php echo Plug_Lang('用户名'); ?></option>
<option value="2"><?php echo Plug_Lang('用户UID'); ?></option>
<option value="3"><?php echo Plug_Lang('所属代理UID'); ?></option>
<option value="4"><?php echo Plug_Lang('IP'); ?></option>
</select>
</div>
</div>
<div class="layui-inline">
<label class="layui-form-label"><?php echo Plug_Lang('关键字'); ?></label>
<div class="layui-input-block" style="width:200px;">
<input type="text" name="soso" id="soso" autocomplete="off" class="layui-input">
</div>
</div>
<div class="layui-inline">
<label class="layui-form-label"><?php echo Plug_Lang('排序'); ?></label>
<div style="width:120px;" class="layui-input-block">
<select name="DESC" id="DESC">
<option value="0"><?php echo Plug_Lang('正序'); ?></option>
<option value="1"><?php echo Plug_Lang('倒序'); ?></option>
</select>
</div>
</div>
<div class="layui-inline">
<button class="layui-btn layuiadmin-btn-useradmin layui-btn-normal" lay-submit lay-filter="LAY-search">
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
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>layui.config({ base: '<?php echo Plug_Get_Url_Statics() ?>style/' }).extend({ index: 'lib/index' }).use(['jquery', 'index', 'table'], function() {var table=layui.table;table.render({elem: '#test-table-toolbar',url: 'index.php?m=<?php echo Plug_Set_Get('m'); ?>&c=<?php echo Plug_Set_Get('c'); ?>&a=<?php echo Plug_Set_Get('a'); ?>_json&t=<?php echo Plug_Set_Get('t'); ?>',title: '<?php echo Plug_Lang('间接软件用户列表'); ?>',cellMinWidth: 110,height: 'full-250',cols: [[{field: 'id', width: 90, title: 'ID'},{field: 'uid', minWidth: 150, title: '<?php echo Plug_Lang('用户UID'); ?>'},{field: 'user', minWidth: 150, title: '<?php echo Plug_Lang('用户名'); ?>'},{field: 'daihao', width: 110, title: '<?php echo Plug_Lang('软件代号'); ?>'},{field: 'agent_uid', width: 130, title: '<?php echo Plug_Lang('所属代理UID'); ?>'},{field: 'ip', minWidth: 130, title: 'IP'},{field: 'addtime', minWidth: 170, title: '<?php echo Plug_Lang('记录时间'); ?>'}]],page: true});$('.layuiadmin-btn-useradmin').on('click', function() {table.reload('test-table-toolbar', {page: {curr: 1}});});});</script>
</body>
</html>
