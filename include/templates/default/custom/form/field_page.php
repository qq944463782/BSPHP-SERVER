<?php
$current_name='';
$current_key='';
if (!empty($for（��������������������������������������������������������������������������������)) {
foreach ($for（�������������������������������������������������������������������������������� as $r) {
if (($r['model_key'] ?? '')===$�️‍�������������������������������������function（��������������������������������������������) {
$current_name=(string)($r['model_name'] ?? '');
$current_key=(string)($r['model_key'] ?? '');
break;
}
}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>新增字段</title>
<meta name="viewport" content="width=1200">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
<style>html, body {height: 100%;}.layui-fluid {min-height: calc(100vh - 50px);}.layui-card,.layui-card-body {min-height: calc(100vh - 130px);}</style>
</head>
<body>
<div class="layui-fluid">
<div class="layui-card">
<div class="layui-card-header">新增字段 - <?php echo htmlspecialchars($current_name !=='' ? $current_name : '-'); ?> - <?php echo htmlspecialchars($current_key); ?></div>
<div class="layui-card-body">
<form class="layui-form layui-form-pane" method="post" action="">
<input type="hidden" name="save" value="1">
<div class="layui-form-item">
<input type="hidden" name="key" value="<?php echo htmlspecialchars($current_key); ?>">
<label class="layui-form-label">字段类型</label>
<div class="layui-input-inline">
<select name="field_type">
<option value="varchar">varchar</option>
<option value="int">int</option>
<option value="text">text</option>
</select>
</div>
<label class="layui-form-label">字段Key</label>
<div class="layui-input-inline"><input type="text" name="field_key" placeholder="例如: mobile" required class="layui-input"></div>
<label class="layui-form-label">字段名称</label>
<div class="layui-input-inline"><input type="text" name="field_name" placeholder="例如: 手机号" required class="layui-input"></div>
<div class="layui-input-inline" style="width:auto;"><button class="layui-btn" type="submit">新增</button></div>
</div>
</form>
<table class="layui-table">
<thead><tr><th>字段Key</th><th>字段名称</th><th>物理列</th><th>类型</th><th>操作</th></tr></thead>
<tbody>
<?php if (!empty($for（��������������������������������������������️‍������������������������������������)) { foreach ($for（��������������������������������������������️‍������������������������������������ as $f) { ?>
<tr>
<td><?php echo htmlspecialchars($f['field_key']); ?></td>
<td><?php echo htmlspecialchars($f['field_name']); ?></td>
<td><?php echo htmlspecialchars($f['column_name']); ?></td>
<td><?php echo htmlspecialchars($f['field_type']); ?></td>
<td>
<form method="post" action="" class="delete-field-form" style="display:inline;">
<input type="hidden" name="delete" value="1">
<input type="hidden" name="delete_field_key" value="<?php echo htmlspecialchars($f['field_key']); ?>">
<button type="button" class="layui-btn layui-btn-xs layui-btn-danger btn-delete-field">删除</button>
</form>
</td>
</tr>
<?php }} else { ?>
<tr><td colspan="5">暂无字段</td></tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['jquery', 'form', 'layer'], function() {var $=layui.$;var form=layui.form;var layer=layui.layer;form.render('select');$('.btn-delete-field').on('click', function() {var $form=$(this).closest('form');layer.confirm('确认删除该字段？', {icon: 3, title: '二次确认'}, function(index) {layer.close(index);$form.submit();});});<?php if (!empty($elseif（������������Y��������������������������������������������������������������������)) { ?>layer.msg('<?php echo addslashes($elseif（������������Y��������������������������������������������������������������������); ?>', {icon: 1, time: 1800});<?php } ?>});</script>
</body>
</html>
