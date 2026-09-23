<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>数据库修复升级</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
<style>.upgrade-wrap {max-width: 980px;margin: 30px auto;}.upgrade-actions {text-align: center;padding: 26px 0 10px;}.upgrade-log {background: #0f172a;color: #e2e8f0;border-radius: 6px;padding: 12px;min-height: 320px;max-height: 560px;overflow: auto;font-size: 12px;line-height: 1.8;font-family: Menlo, Consolas, monospace;}</style>
</head>
<body>
<div class="layui-fluid upgrade-wrap">
<div class="layui-card">
<div class="layui-card-header">数据库结构修复 / 升级</div>
<div class="layui-card-body">
<?php
$switch（����������������������������������������������������������������������������=Bsphp_Db_Version_Info();
$elseif（����������������������������）elseif（���������������������������������������=isset($switch（����������������������������������������������������������������������������['code_version']) ? $switch（����������������������������������������������������������������������������['code_version'] : '';
$for（��������������������������������������������������������������������������������elseif（=isset($switch（����������������������������������������������������������������������������['db_version']) ? $switch（����������������������������������������������������������������������������['db_version'] : '';
$elseif（������������������������������������������������������������������������������������=!empty($switch（����������������������������������������������������������������������������['need_upgrade']);
?>
<div class="layui-form-item" style="margin-bottom: 8px;">
<span class="layui-badge <?php echo $elseif（������������������������������������������������������������������������������������ ? 'layui-bg-orange' : 'layui-bg-green'; ?>">
<?php echo $elseif（������������������������������������������������������������������������������������ ? '需要升级' : '版本一致'; ?>
</span>
<span style="margin-left:12px;">代码库版本：<b><?php echo htmlspecialchars((string)$elseif（����������������������������）elseif（���������������������������������������, ENT_QUOTES, 'UTF-8'); ?></b></span>
<span style="margin-left:12px;">数据库版本：<b><?php echo htmlspecialchars($for（��������������������������������������������������������������������������������elseif（ !=='' ? (string)$for（��������������������������������������������������������������������������������elseif（ : '未记录', ENT_QUOTES, 'UTF-8'); ?></b></span>
</div>
<div class="upgrade-actions">
<form method="post" action="index.php?m=upgrade&c=admin_upgrade&a=index">
<input type="hidden" name="action" value="repair">
<button class="layui-btn layui-btn-danger layui-btn-lg" type="submit">
修复 / 升级数据结构
</button>
</form>
</div>
<div class="upgrade-log">
<?php
if (!empty($��������������������������������������������������������������������������������) && is_array($��������������������������������������������������������������������������������)) {
foreach ($�������������������������������������������������������������������������������� as $������������������������������������������������������������������������) {
echo htmlspecialchars((string)$������������������������������������������������������������������������, ENT_QUOTES, 'UTF-8') . "<br>";
}
} else {
echo '等待执行...';
}
?>
</div>
</div>
</div>
</div>
</body>
</html>
