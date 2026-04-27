<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), ����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- 超级表单管理 Bsphp-Rsa</title>
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
<div class="layui-card-header">超级表单管理</div>
<div class="layui-card-body">
<div class="layui-form layui-card-header layuiadmin-card-header-auto">
<div class="layui-form-item">
<div class="layui-inline">
<div class="layui-input-block">
<select name="key" id="key">
<?php if (empty($for（��������������������������������������������������������������������������������)) { ?>
<option value="">暂无模型</option>
<?php } ?>
<?php foreach ($for（�������������������������������������������������������������������������������� as $row) { ?>
<option value="<?php echo htmlspecialchars($row['model_key']); ?>" <?php if (!empty($for（��������������������������������������������������������������������������������['model_key']) && $for（��������������������������������������������������������������������������������['model_key']===$row['model_key']) echo 'selected'; ?>>
<?php echo htmlspecialchars($row['model_name']); ?>
</option>
<?php } ?>
</select>
</div>
</div>
<div class="layui-inline">
<div class="layui-input-block">
<select name="soso_id" id="soso_id">
<?php if (empty($）����_SESSION������������������������������������������������������������������������)) { ?>
<?php } ?>
<?php foreach ($）����_SESSION������������������������������������������������������������������������ as $col) { ?>
<option value="<?php echo htmlspecialchars($col['name']); ?>" <?php if (!empty($��������������������������������������������������������������������) && $��������������������������������������������������������������������===$col['name']) echo 'selected'; ?>>
<?php echo htmlspecialchars($col['label']); ?>
</option>
<?php } ?>
</select>
</div>
</div>
<div class="layui-inline">
<div class="layui-input-block" style="width:220px">
<input type="text" name="soso" id="soso" value="<?php echo htmlspecialchars($���������������������������������������������������������������������������� ?? ''); ?>" placeholder="请输入搜索内容" autocomplete="off" class="layui-input">
</div>
</div>
<div class="layui-inline">
<div class="layui-input-block">
<select name="DESC" id="DESC">
<option value="0" <?php if (!isset($��������������������������������������������������������������������������������) || (int)$��������������������������������������������������������������������������������===0) echo 'selected'; ?>>倒序</option>
<option value="1" <?php if (isset($��������������������������������������������������������������������������������) && (int)$��������������������������������������������������������������������������������===1) echo 'selected'; ?>>正序</option>
</select>
</div>
</div>
<div class="layui-inline">
<button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="custom-search">
<i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
</button>
</div>
<div class="layui-inline">
<button type="button" class="layui-btn layui-btn-primary" id="btn-export-csv">导出CSV</button>
</div>
<div class="layui-inline">
<button type="button" class="layui-btn layui-btn-primary" id="btn-import-csv">导入CSV</button>
</div>
<div class="layui-inline">
<button type="button" class="layui-btn layui-btn-normal" id="btn-model-page">创建/管理模型</button>
</div>
<div class="layui-inline">
<button type="button" class="layui-btn layui-btn-warm" id="btn-field-page">新增字段</button>
</div>
</div>
</div>
<table class="layui-hide" id="custom-table" lay-filter="custom-table"></table>
<script type="text/html" id="custom-toolbar"><div class="layui-btn-container"><button class="layui-btn layui-btn-sm" lay-event="batch-del">批量删除</button><button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="batch-update">批量类型修改</button></div></script>
<script type="text/html" id="custom-row-tool"><a class="layui-btn layui-btn-xs" lay-event="edit">单修改</a></script>
</div>
</div>
</div>
</div>
</div>
<div id="foot">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Rsa <?php echo BSPHP_VERSION; ?></a> Bsphp.com <br>
All Rights Reserved </div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/',version: "20240311"}).extend({index: 'lib/index'}).use(['jquery', 'index', 'table', 'form', 'layer'], function() {var $=layui.$,table=layui.table,form=layui.form,layer=layui.layer;form.render('select');var cols=<?php ;$colJs=array();foreach ($）����_SESSION������������������������������������������������������������������������ as $c) {$colJs[]=array('field'=> (string)$c['name'], 'title'=> (string)$c['label'], 'minWidth'=> 120);}if (empty($colJs)) $colJs[]=array('field'=> 'id', 'title'=> '编号', 'minWidth'=> 120);echo json_encode($colJs, JSON_UNESCAPED_UNICODE);?>;function getUrl() {var tVal=$('#key').val() || '';var descVal=$('#DESC').val() || '0';var sfVal=$('#soso_id').val() || '';var kwVal=$('#soso').val() || '';return 'index.php?m=custom&c=form&a=table_json&key=' + encodeURIComponent(tVal) +'&DESC=' + encodeURIComponent(descVal) +'&soso_id=' + encodeURIComponent(sfVal) +'&soso=' + encodeURIComponent(kwVal);}var tInit=$('#key').val() || '';if (tInit !=='' && $('#custom-table').length > 0) {table.render({elem: '#custom-table',url: getUrl(),toolbar: '#custom-toolbar',title: '自定义数据表',height: 'full-260',cols: [[{type:'checkbox', fixed:'left'}].concat(cols).concat([{fixed:'right',title:'操作',toolbar:'#custom-row-tool',width:90}])],page: {layout: ['prev', 'page', 'next', 'count', 'skip'],limit: 20},limit: 20});}form.on('submit(custom-search)', function() {var tVal=$('#key').val() || '';var descVal=$('#DESC').val() || '0';var sfVal=$('#soso_id').val() || '';var kwVal=$('#soso').val() || '';if (tVal==='') return false;window.location.href='index.php?m=custom&c=form&a=table&key=' + encodeURIComponent(tVal) +'&DESC=' + encodeURIComponent(descVal) +'&soso_id=' + encodeURIComponent(sfVal) +'&soso=' + encodeURIComponent(kwVal);return false;});$('#key').on('change', function() {var tVal=$('#key').val() || '';var descVal=$('#DESC').val() || '0';var sfVal=$('#soso_id').val() || '';var kwVal=$('#soso').val() || '';if (tVal==='') return;window.location.href='index.php?m=custom&c=form&a=table&key=' + encodeURIComponent(tVal) +'&DESC=' + encodeURIComponent(descVal) +'&soso_id=' + encodeURIComponent(sfVal) +'&soso=' + encodeURIComponent(kwVal);});$('#btn-model-page').on('click', function() {layer.open({type: 2,title: '创建/管理模型',shadeClose: false,maxmin: true,area: ['1200px', '760px'],content: 'index.php?m=custom&c=form&a=model_page'});});$('#btn-export-csv').on('click', function() {var tVal=$('#key').val() || '';var descVal=$('#DESC').val() || '0';var sfVal=$('#soso_id').val() || '';var kwVal=$('#soso').val() || '';if (tVal==='') { layer.msg('请先选择模型'); return; }window.open('index.php?m=custom&c=form&a=export_csv&key=' + encodeURIComponent(tVal) +'&DESC=' + encodeURIComponent(descVal) +'&soso_id=' + encodeURIComponent(sfVal) +'&soso=' + encodeURIComponent(kwVal), '_blank');});$('#btn-import-csv').on('click', function() {var tVal=$('#key').val() || '';if (tVal==='') { layer.msg('请先选择模型'); return; }layer.open({type: 2,title: '导入CSV',shadeClose: false,maxmin: true,area: ['900px', '520px'],content: 'index.php?m=custom&c=form&a=import_csv_page&key=' + encodeURIComponent(tVal)});});$('#btn-field-page').on('click', function() {var tVal=$('#key').val() || '';layer.open({type: 2,title: '新增字段',shadeClose: false,maxmin: true,area: ['1300px', '760px'],content: 'index.php?m=custom&c=form&a=field_page&key=' + encodeURIComponent(tVal)});});table.on('toolbar(custom-table)', function(obj){var check=table.checkStatus('custom-table');var data=check.data || [];if (!data.length) { layer.msg('请先选择数据'); return; }var ids=[];for (var i=0;i<data.length;i++){ if (data[i].id) ids.push(data[i].id); }var tVal=$('#key').val() || '';if (obj.event==='batch-del') {layer.open({type: 2,title: '批量删除',maxmin: true,area: ['900px','520px'],content: 'index.php?m=custom&c=form&a=row_batch_page&key=' + encodeURIComponent(tVal) + '&mode=delete&ids=' + encodeURIComponent(ids.join(','))});} else if (obj.event==='batch-update') {layer.open({type: 2,title: '批量类型修改',maxmin: true,area: ['980px','560px'],content: 'index.php?m=custom&c=form&a=row_batch_page&key=' + encodeURIComponent(tVal) + '&mode=update&ids=' + encodeURIComponent(ids.join(','))});}});table.on('tool(custom-table)', function(obj){if (obj.event==='edit') {var tVal=$('#key').val() || '';var id=obj.data.id || 0;layer.open({type: 2,title: '单修改',maxmin: true,area: ['980px','680px'],content: 'index.php?m=custom&c=form&a=row_edit_page&key=' + encodeURIComponent(tVal) + '&id=' + encodeURIComponent(id)});}});});</script>
</body>
</html>
