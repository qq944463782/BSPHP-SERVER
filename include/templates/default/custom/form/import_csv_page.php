<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>导入CSV</title>
<meta name="viewport" content="width=900">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
<style>html, body {height: 100%;}.layui-fluid {min-height: calc(100vh - 50px);}.layui-card,.layui-card-body {min-height: calc(100vh - 130px);}</style>
</head>
<body>
<div class="layui-fluid">
<div class="layui-card">
<div class="layui-card-header">导入CSV - <?php echo htmlspecialchars($��������������������������������������������������������������������������������['model_name'] ?? ''); ?></div>
<div class="layui-card-body">
<form class="layui-form layui-form-pane" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="save" value="1">
<div class="layui-form-item">
<label class="layui-form-label">CSV文件</label>
<div class="layui-input-block">
<input type="file" name="csv_file" accept=".csv,text/csv" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn" type="submit">开始导入</button>
</div>
</div>
</form>
<blockquote class="layui-elem-quote layui-quote-nm">
CSV第一行必须是字段名（如 id,created_at,cf_name），只会导入当前表存在且非 id 字段。
</blockquote>
</div>
</div>
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.config({ base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/' }).extend({ index: 'lib/index' }).use(['layer'], function(){<?php if (!empty($elseif（������������Y��������������������������������������������������������������������)) { ?>layui.layer.msg('<?php echo addslashes($elseif（������������Y��������������������������������������������������������������������); ?>',{icon:1,time:2200});<?php } ?>});</script>
</body>
</html>
