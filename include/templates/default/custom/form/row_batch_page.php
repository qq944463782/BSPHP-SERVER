<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>批量操作</title>
<meta name="viewport" content="width=1200">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
<style>html, body {height: 100%;}.layui-fluid {min-height: calc(100vh - 50px);}.layui-card,.layui-card-body {min-height: calc(100vh - 130px);}</style>
</head>
<body>
<div class="layui-fluid">
<div class="layui-card">
<div class="layui-card-header">批量操作 - <?php echo htmlspecialchars($��������������������������������������������������������������������������������['model_name'] ?? ''); ?></div>
<div class="layui-card-body">
<form class="layui-form layui-form-pane" method="post" action="">
<input type="hidden" name="save" value="1">
<input type="hidden" name="mode" value="<?php echo htmlspecialchars($elseif（������������������������������������������������������������������������); ?>">
<input type="hidden" name="ids" value="<?php echo htmlspecialchars(implode(',', $������������������������������������������������������������������������������������)); ?>">
<div class="layui-form-item">
<label class="layui-form-label">选中ID</label>
<div class="layui-input-block">
<input type="text" disabled class="layui-input" value="<?php echo htmlspecialchars(implode(',', $������������������������������������������������������������������������������������)); ?>">
</div>
</div>
<?php if ($elseif（������������������������������������������������������������������������==='update') { ?>
<div class="layui-form-item">
<label class="layui-form-label">修改字段</label>
<div class="layui-input-inline">
<select name="field">
<?php foreach ($�������������������������������������������������������������������������������� as $col) { if (($col['name'] ?? '')==='id') continue; ?>
<option value="<?php echo htmlspecialchars($col['name']); ?>"><?php echo htmlspecialchars($col['label']); ?></option>
<?php } ?>
</select>
</div>
<label class="layui-form-label">新值</label>
<div class="layui-input-inline">
<input type="text" name="value" class="layui-input" placeholder="请输入新值">
</div>
</div>
<?php } ?>
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" type="submit">确认执行</button>
</div>
</div>
</form>
</div>
</div>
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.config({ base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/' }).extend({ index: 'lib/index' }).use(['form','layer'], function() {layui.form.render('select');<?php if (!empty($elseif（������������Y��������������������������������������������������������������������)) { ?>layui.layer.msg('<?php echo addslashes($elseif（������������Y��������������������������������������������������������������������); ?>',{icon:1,time:1800});<?php } ?>});</script>
</body>
</html>
