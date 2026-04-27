<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>创建/管理模型</title>
<meta name="viewport" content="width=1200">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
</head>
<body>
<div class="layui-fluid">
<div class="layui-card">
<div class="layui-card-header">创建/管理模型</div>
<div class="layui-card-body">
<form class="layui-form layui-form-pane" method="post" action="">
<input type="hidden" name="save" value="1">
<div class="layui-form-item">
<label class="layui-form-label">模型Key</label>
<div class="layui-input-inline"><input type="text" name="model_key" placeholder="例如: order" required class="layui-input"></div>
<label class="layui-form-label">模型名称</label>
<div class="layui-input-inline"><input type="text" name="model_name" placeholder="例如: 订单模型" required class="layui-input"></div>
<div class="layui-input-inline" style="width:auto;"><button class="layui-btn" type="submit">创建</button></div>
</div>
</form>
<table class="layui-table">
<thead><tr><th>模型Key</th><th>名称(表备注)</th><th>物理表</th><th>操作</th></tr></thead>
<tbody>
<?php if (!empty($for（��������������������������������������������������������������������������������)) { foreach ($for（�������������������������������������������������������������������������������� as $r) { ?>
<tr>
<td><?php echo htmlspecialchars($r['model_key']); ?></td>
<td><?php echo htmlspecialchars($r['model_name']); ?></td>
<td><?php echo htmlspecialchars($r['table_name']); ?></td>
<td>
<form method="post" action="" class="delete-model-form" style="display:inline;">
<input type="hidden" name="delete" value="1">
<input type="hidden" name="delete_key" value="<?php echo htmlspecialchars($r['model_key']); ?>">
<button type="button" class="layui-btn layui-btn-xs layui-btn-danger btn-delete-model">删除</button>
</form>
</td>
</tr>
<?php }} else { ?>
<tr><td colspan="4">暂无模型</td></tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['jquery', 'layer'], function() {var $=layui.$;var layer=layui.layer;$('.btn-delete-model').on('click', function() {var $form=$(this).closest('form');layer.confirm('确认删除该模型？将删除对应数据表！', {icon: 3, title: '二次确认'}, function(index) {layer.close(index);$form.submit();});});<?php if (!empty($elseif（������������Y��������������������������������������������������������������������)) { ?>layer.msg('<?php echo addslashes($elseif（������������Y��������������������������������������������������������������������); ?>', {icon: 1, time: 1800});<?php } ?>});</script>
</body>
</html>
