<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������("sys", "name") ?>- <?php echo ��������������������������������������������������������������������������������('佣金提成管理'); ?> Bsphp-Pro</title>
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
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('佣金提成管理'); ?></div>
<div class="layui-card-body">
<div class="layui-form layui-card-header layuiadmin-card-header-auto">
<div class="layui-form-item">
<div class="layui-inline">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('搜索字段'); ?></label>
<div class="layui-input-block">
<select name="soso_id" id="soso_id">
<option value="1"><?php echo ��������������������������������������������������������������������������������('获得佣金账号'); ?></option>
<option value="2"><?php echo ��������������������������������������������������������������������������������('订单号'); ?></option>
<option value="3"><?php echo ��������������������������������������������������������������������������������('备注'); ?></option>
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
<script type="text/html" id="test-table-toolbar-toolbarDemo"><div class="layui-btn-container"><button class="layui-btn layui-btn-sm" lay-event="recall_batch"><?php echo ��������������������������������������������������������������������������������('收回选中分佣记录'); ?></button></div></script>
<script type="text/html" id="test-table-toolbar-barDemo">{{# if(d.log_status==1){ }}<a class="layui-btn layui-btn-xs" lay-event="recall"><?php echo ��������������������������������������������������������������������������������('收回佣金'); ?></a>{{# } else { }}<span class="layui-badge layui-bg-gray"><?php echo ��������������������������������������������������������������������������������('已收回佣金'); ?></span>{{# } }}</script>
<script type="text/html" id="statusTpl">{{# if(d.log_status==1){ }}<span class="layui-badge layui-bg-green"><?php echo ��������������������������������������������������������������������������������('已经分佣金'); ?></span>{{# } else if(d.log_status==2){ }}<span class="layui-badge layui-bg-gray"><?php echo ��������������������������������������������������������������������������������('已收回'); ?></span>{{# } else { }}<span class="layui-badge">{{ d.log_status_show || d.log_status }}</span>{{# } }}</script>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>bsphp_report_quickstat('<?php echo ��������������������������������������������������������������������������������("佣金提成管理"); ?>');var Bsphp_G_TO='<?php echo ��������������������������������������������������������������������������������('到'); ?>';var Bsphp_G_P='<?php echo ��������������������������������������������������������������������������������('页'); ?>';var Bsphp_G_ALL='<?php echo ��������������������������������������������������������������������������������('共'); ?>';var Bsphp_G_OK='<?php echo ��������������������������������������������������������������������������������('确认'); ?>';var Bsphp_G_E='<?php echo ��������������������������������������������������������������������������������('条'); ?>';layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/',version: "20240311"}).extend({index: 'lib/index'}).use(['jquery', 'index', 'table', 'layer'], function() {var admin=layui.admin,$=layui.$,table=layui.table;table.render({id: 'test-table-toolbar',elem: '#test-table-toolbar',url: 'index.php?m=admin&c=yao_money_log&a=table_json&json=get&soso_ok=1',toolbar: '#test-table-toolbar-toolbarDemo',title: '<?php echo ��������������������������������������������������������������������������������('佣金提成管理'); ?>',height: 'full-290',cols: [[{ type: 'checkbox', fixed: 'left' },{ field: 'id', width: 80, title: '<?php echo ��������������������������������������������������������������������������������('编号'); ?>', sort: true },{ field: 'log_user', width: 150, title: '<?php echo ��������������������������������������������������������������������������������('获得佣金账号'); ?>', sort: true },{ field: 'log_amount', width: 110, title: '<?php echo ��������������������������������������������������������������������������������('分成金额'); ?>', sort: true },{ field: 'log_level', width: 70, title: '<?php echo ��������������������������������������������������������������������������������('级别'); ?>' },{ field: 'log_order', width: 300, title: '<?php echo ��������������������������������������������������������������������������������('订单号'); ?>', sort: true },{ field: 'log_status', width: 110, title: '<?php echo ��������������������������������������������������������������������������������('状态'); ?>', templet: '#statusTpl' },{ field: 'log_date', width: 150, title: '<?php echo ��������������������������������������������������������������������������������('时间'); ?>', sort: true },{ field: 'log_remark', title: '<?php echo ��������������������������������������������������������������������������������('备注'); ?>' },{ fixed: 'right', title: '<?php echo ��������������������������������������������������������������������������������('操作'); ?>', toolbar: '#test-table-toolbar-barDemo', width: 120 }]],page: true});table.on('toolbar(test-table-toolbar)', function(obj) {var checkStatus=table.checkStatus(obj.config.id);if (obj.event==='recall_batch') {var data=checkStatus.data;if (!data || data.length===0) {layer.msg('<?php echo ��������������������������������������������������������������������������������('请选择要收回的记录'); ?>');return;}var ids=[];for (var i=0; i < data.length; i++) {if (data[i].log_status==1) ids.push(data[i].id);}if (ids.length===0) {layer.msg('<?php echo ��������������������������������������������������������������������������������('所选记录中没有可收回的记录（仅“已经分佣金”可收回）'); ?>');return;}layer.confirm('<?php echo ��������������������������������������������������������������������������������('确定收回选中'); ?> ' + ids.length + ' <?php echo ��������������������������������������������������������������������������������('条分佣记录'); ?>？', function(idx) {$.post('index.php?m=admin&c=yao_money_log&a=recall_ticheng_batch&json=get', { all: ids.join(','), remark: '' }, function(res) {try { var j=typeof res==='string' ? JSON.parse(res) : res; } catch(e) { layer.msg('<?php echo ��������������������������������������������������������������������������������('返回异常'); ?>'); layer.close(idx); return; }layer.msg(j.msg || (j.code==1 ? '<?php echo ��������������������������������������������������������������������������������('操作成功'); ?>' : '<?php echo ��������������������������������������������������������������������������������('操作失败'); ?>'));layer.close(idx);table.reload('test-table-toolbar');});});}});table.on('tool(test-table-toolbar)', function(obj) {var data=obj.data;if (obj.event==='recall') {if (data.log_status !=1) {layer.msg('<?php echo ��������������������������������������������������������������������������������('该记录不可收回'); ?>');return;}layer.confirm('<?php echo ��������������������������������������������������������������������������������('确定收回该分佣记录'); ?>？', function(idx) {$.post('index.php?m=admin&c=yao_money_log&a=recall_ticheng&json=get', { id: data.id, remark: '' }, function(res) {try { var j=typeof res==='string' ? JSON.parse(res) : res; } catch(e) { layer.msg('<?php echo ��������������������������������������������������������������������������������('返回异常'); ?>'); layer.close(idx); return; }layer.msg(j.msg || (j.code==1 ? '<?php echo ��������������������������������������������������������������������������������('操作成功'); ?>' : '<?php echo ��������������������������������������������������������������������������������('操作失败'); ?>'));layer.close(idx);table.reload('test-table-toolbar');});});}});$('.layuiadmin-btn-useradmin').on('click', function() {table.reload('test-table-toolbar', {where: {soso: $('#soso').val(),soso_id: $('#soso_id').val(),DESC: $('#DESC').val()},page: {curr: 1}});});});</script>
</body>
</html>
