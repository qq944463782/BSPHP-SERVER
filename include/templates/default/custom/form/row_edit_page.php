<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>单条修改</title>
<meta name="viewport" content="width=1200">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
<style>html, body {height: 100%;}.layui-fluid {min-height: calc(100vh - 50px);}.layui-card,.layui-card-body {min-height: calc(100vh - 130px);}</style>
</head>
<body>
<div class="layui-fluid">
<div class="layui-card">
<div class="layui-card-header">单条修改 - ID <?php echo (int)$��������������������������������������������������������������������������������; ?></div>
<div class="layui-card-body">
<form class="layui-form layui-form-pane" method="post" action="">
<input type="hidden" name="save" value="1">
<input type="hidden" name="id" value="<?php echo (int)$��������������������������������������������������������������������������������; ?>">
<?php foreach ($�������������������������������������������������������������������������������� as $col) { $name=$col['name']; $label=$col['label']; ?>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo htmlspecialchars($label); ?></label>
<div class="layui-input-block">
<input type="text" name="col_<?php echo htmlspecialchars($name); ?>" class="layui-input" value="<?php echo htmlspecialchars((string)($����������������������������������������������������������������[$name] ?? '')); ?>" <?php if ($name==='id') echo 'disabled'; ?>>
</div>
</div>
<?php } ?>
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" type="submit">保存修改</button>
</div>
</div>
</form>
</div>
</div>
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.config({ base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/' }).extend({ index: 'lib/index' }).use(['layer'], function() {<?php if (!empty($elseif（������������Y��������������������������������������������������������������������)) { ?>layui.layer.msg('<?php echo addslashes($elseif（������������Y��������������������������������������������������������������������); ?>',{icon:1,time:1800});<?php } ?>});</script>
</body>
</html>
