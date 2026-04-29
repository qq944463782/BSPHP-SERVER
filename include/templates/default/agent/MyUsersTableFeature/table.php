<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?> - <?php echo Plug_Lang('我的用户'); ?></title>
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
<div class="layui-card-header"><?php echo Plug_Lang('我的用户列表'); ?></div>
<div class="layui-card-body">
<div class="layui-form layui-card-header layuiadmin-card-header-auto">
<div class="layui-form-item">
<div class="layui-inline">
<label class="layui-form-label"><?php echo Plug_Lang('搜索字段'); ?></label>
<div style="width:200px;" class="layui-input-block">
<select name="soso_id" id="soso_id">
<option value="1"><?php echo Plug_Lang('登陆账号'); ?></option>
<option value="2"><?php echo Plug_Lang('用户UID'); ?></option>
<option value="7"><?php echo Plug_Lang('用户状态=>冻结'); ?></option>
<option value="8"><?php echo Plug_Lang('用户状态=>正常'); ?></option>
<option value="15"><?php echo Plug_Lang('金额大于N用户'); ?></option>
<option value="16"><?php echo Plug_Lang('登录次数大于N用户'); ?></option>
<option value="18"><?php echo Plug_Lang('备注'); ?></option>
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
<script type="text/html" id="test-table-toolbar-toolbarDemo"><div class="layui-btn-container"><button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="act_2"><?php echo Plug_Lang('冻结选择'); ?></button><button class="layui-btn layui-btn-sm layui-btn-warm" lay-event="act_4"><?php echo Plug_Lang('解封选择'); ?></button></div></script>
<script type="text/html" id="test-table-toolbar-barDemo"><a class="layui-btn layui-btn-xs" lay-event="change_pwd"><?php echo Plug_Lang('改密码'); ?></a></script>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>layui.config({ base: '<?php echo Plug_Get_Url_Statics() ?>style/' }).extend({ index: 'lib/index' }).use(['jquery', 'index', 'table', 'layer'], function() {var $=layui.$, table=layui.table, layer=layui.layer;table.render({elem: '#test-table-toolbar',url: 'index.php?m=<?php echo Plug_Set_Get('m'); ?>&c=<?php echo Plug_Set_Get('c'); ?>&a=<?php echo Plug_Set_Get('a'); ?>_json&t=<?php echo Plug_Set_Get('t'); ?>',toolbar: '#test-table-toolbar-toolbarDemo',title: '<?php echo Plug_Lang('我的用户列表'); ?>',cellMinWidth: 110,height: 'full-250',cols: [[{type: 'checkbox', fixed: 'left'},{field: 'uid', width: 80, title: '<?php echo Plug_Lang('编号'); ?>'},{field: 'user', minWidth: 150, title: '<?php echo Plug_Lang('用户名'); ?>'},{field: 'daili', width: 110, title: '<?php echo Plug_Lang('类型'); ?>'},{field: 'test', width: 90, title: '<?php echo Plug_Lang('状态'); ?>'},{field: 'LoGinNum', width: 110, title: '<?php echo Plug_Lang('登录次数'); ?>'},{field: 'rmb', width: 100, title: '<?php echo Plug_Lang('余额'); ?>'},{field: 're_date', minWidth: 160, title: '<?php echo Plug_Lang('注册时间'); ?>'},{field: 'zhhd', minWidth: 160, title: '<?php echo Plug_Lang('最后活动'); ?>'},{field: 'agent_beizhu', minWidth: 180, title: '<?php echo Plug_Lang('备注(编辑)'); ?>', edit: 'text'}<?php $��������������������������������������������������������8��������������������=Plug_User_Extra_Fields_For_List();foreach ($��������������������������������������������������������8�������������������� as $_SERVER����������������������������？����������������������������������������) {$��������������������������������������������������������������������️‍����️����������������='ue_' . $_SERVER����������������������������？����������������������������������������['key']; ?>,{field: <?php echo json_encode($��������������������������������������������������������������������️‍����️����������������); ?>, minWidth: 120, title: <?php echo json_encode($_SERVER����������������������������？����������������������������������������['label'], JSON_UNESCAPED_UNICODE); ?>}<?php } ?>,{fixed: 'right', width: 100, title: '<?php echo Plug_Lang('操作'); ?>', toolbar: '#test-table-toolbar-barDemo'}]],page: true});function sendBatch(selectClass, all) {$.ajax({type: 'post',url: '',data: 'Submit_class=ok&all=' + all + '&select_class=' + selectClass,dataType: 'json',success: function(ret) {layer.alert(ret.msg);table.reload('test-table-toolbar', {page: {curr: 1}});},error: function() {layer.alert('<?php echo Plug_Lang('接口请求返还异常'); ?>');}});}table.on('toolbar(test-table-toolbar)', function(obj) {var data=table.checkStatus(obj.config.id).data;var all='';for (var key in data) all +=data[key].key + ',';all +='0';if (obj.event==='act_2') sendBatch(3, all);if (obj.event==='act_4') sendBatch(4, all);});table.on('edit(test-table-toolbar)', function(obj) {$.ajax({type: 'post',url: '',data: 'Submit_class=ok&all=' + obj.data.key + '&select_class=2&txt=' + obj.value,dataType: 'json',success: function(ret) { layer.msg(ret.msg, {offset: '15px'}); }});});table.on('tool(test-table-toolbar)', function(obj) {if (obj.event !=='change_pwd') return;layer.prompt({title: '<?php echo Plug_Lang('请输入新密码(2-14位)'); ?>',formType: 1}, function(value, index) {layer.close(index);$.ajax({type: 'post',url: '',data: 'Submit_class=ok&all=' + obj.data.key + '&select_class=5&txt=' + encodeURIComponent(value),dataType: 'json',success: function(ret) { layer.msg(ret.msg, {offset: '15px'}); },error: function() { layer.alert('<?php echo Plug_Lang('接口请求返还异常'); ?>'); }});});});$('.layuiadmin-btn-useradmin').on('click', function() {table.reload('test-table-toolbar', {page: {curr: 1}});});});</script>
</body>
</html>
