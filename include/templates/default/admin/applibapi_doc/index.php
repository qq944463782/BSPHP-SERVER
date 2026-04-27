<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo htmlspecialchars(����������������������������������������������������������������::������������������������������������������������������������������������������������('sys', 'name'), ENT_QUOTES, 'UTF-8'); ?> - <?php echo ��������������������������������������������������������������������������������('客户端API接口'); ?> Bsphp-Rsa</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
<style>.apilib-doc-group { margin-bottom: 18px; }.apilib-doc-group-title { font-size: 15px; font-weight: 600; margin: 0 0 10px 0; padding-bottom: 6px; border-bottom: 1px solid #f0f0f0; color: #333; }.apilib-doc-group-hint { font-weight: normal; color: #999; font-size: 12px; margin-left: 8px; }.apilib-doc-item { margin-bottom: 10px; }.apilib-doc-meta { color: #888; font-size: 12px; margin: 6px 0; }.apilib-doc-intro { margin: 8px 0; line-height: 1.6; white-space: pre-wrap; }.apilib-doc-pre { max-height: 280px; overflow: auto; background: #f8f8f8; padding: 10px; border-radius: 2px; font-size: 12px; }</style>
</head>
<body>
<div class="layui-fluid">
<div class="layui-card">
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('客户端API接口'); ?></div>
<div class="layui-card-body">
<p class="layui-word-aux"><?php echo ��������������������������������������������������������������������������������('以下为 include/applibapi/api 目录下接口文件头注释中的 &lt;api&gt; 说明，由系统自动扫描生成。'); ?></p>
<p class="layui-word-aux" style="margin-top: 4px;"><?php echo ��������������������������������������������������������������������������������('分组规则'); ?>：<code>.in</code> <?php echo ��������������������������������������������������������������������������������('公共接口'); ?> &nbsp; <code>.lg</code> <?php echo ��������������������������������������������������������������������������������('用户登陆模式'); ?> &nbsp; <code>.ic</code> <?php echo ��������������������������������������������������������������������������������('卡串验证模式'); ?></p>
<div class="layui-form layui-form-pane" style="margin: 12px 0;">
<div class="layui-form-item">
<div class="layui-inline">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('筛选'); ?></label>
<div class="layui-input-inline" style="width: 320px;">
<input type="text" id="apilib-doc-filter" placeholder="<?php echo ��������������������������������������������������������������������������������('接口名 / 标题 / 文件 / 目录 / 模式'); ?>" autocomplete="off" class="layui-input">
</div>
</div>
</div>
</div>
<div id="apilib-doc-root">
<?php
if (empty($��������������������������������������������������������������������)) {
echo '<div class="layui-word-aux">' . ��������������������������������������������������������������������������������('未扫描到带 &lt;api&gt; 注释的接口文件。') . '</div>';
} else {
foreach ($�������������������������������������������������������������������� as $g) {
$glabel=htmlspecialchars((string)($g['mode_label'] ?? ''), ENT_QUOTES, 'UTF-8');
$gmode=htmlspecialchars((string)($g['mode'] ?? ''), ENT_QUOTES, 'UTF-8');
$suffix=($gmode !=='other') ? '.' . $gmode : '';
?>
<div class="apilib-doc-group" data-group="1">
<div class="apilib-doc-group-title">
<?php echo $glabel; ?>
<?php if ($suffix !=='') { ?>
<span class="apilib-doc-group-hint">（<?php echo $suffix; ?>）</span>
<?php } else { ?>
<span class="apilib-doc-group-hint">（<?php echo ��������������������������������������������������������������������������������('非 in/lg/ic 后缀'); ?>）</span>
<?php } ?>
</div>
<div class="layui-collapse" lay-filter="apilib-doc-collapse">
<?php
foreach ($g['items'] as $row) {
$name=htmlspecialchars((string)($row['name'] ?? ''), ENT_QUOTES, 'UTF-8');
$title=htmlspecialchars((string)($row['title'] ?? ''), ENT_QUOTES, 'UTF-8');
$intro=htmlspecialchars((string)($row['intro'] ?? ''), ENT_QUOTES, 'UTF-8');
$file=htmlspecialchars((string)($row['file'] ?? ''), ENT_QUOTES, 'UTF-8');
$folder=htmlspecialchars((string)($row['folder'] ?? ''), ENT_QUOTES, 'UTF-8');
$raw=htmlspecialchars((string)($row['raw_xml'] ?? ''), ENT_QUOTES, 'UTF-8');
$searchBlob=$name . ' ' . $title . ' ' . $file . ' ' . $folder . ' ' . $glabel . ' ' . $gmode;
?>
<div class="layui-colla-item apilib-doc-item" data-search="<?php echo htmlspecialchars($searchBlob, ENT_QUOTES, 'UTF-8'); ?>">
<h2 class="layui-colla-title"><?php echo $title !=='' ? $title : $name; ?>
<span style="font-weight: normal; color: #999; font-size: 12px;"> — <?php echo $name; ?></span>
</h2>
<div class="layui-colla-content">
<div class="apilib-doc-meta"><?php echo ��������������������������������������������������������������������������������('目录'); ?>：<code><?php echo $folder; ?></code> &nbsp;|&nbsp; <?php echo ��������������������������������������������������������������������������������('文件'); ?>：<code><?php echo $file; ?></code></div>
<?php if ($intro !=='') { ?>
<div class="apilib-doc-intro"><?php echo nl2br($intro); ?></div>
<?php } ?>
<?php if (!empty($row['common_params'])) { ?>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 12px;">
<legend><?php echo ��������������������������������������������������������������������������������('公共参数'); ?></legend>
</fieldset>
<table class="layui-table" lay-skin="line">
<thead>
<tr>
<th><?php echo ��������������������������������������������������������������������������������('参数'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('类型'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('必填'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('说明'); ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($row['common_params'] as $p) {
$pn=htmlspecialchars((string)($p['name'] ?? ''), ENT_QUOTES, 'UTF-8');
$dt=htmlspecialchars((string)($p['dtype'] ?? ''), ENT_QUOTES, 'UTF-8');
$rq=htmlspecialchars((string)($p['required'] ?? ''), ENT_QUOTES, 'UTF-8');
$ds=htmlspecialchars((string)($p['desc'] ?? ''), ENT_QUOTES, 'UTF-8');
?>
<tr>
<td><code><?php echo $pn; ?></code></td>
<td><?php echo $dt; ?></td>
<td><?php echo $rq; ?></td>
<td><?php echo $ds; ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } ?>
<?php if (!empty($row['params'])) { ?>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 12px;">
<legend><?php echo ��������������������������������������������������������������������������������('业务参数'); ?></legend>
</fieldset>
<table class="layui-table" lay-skin="line">
<thead>
<tr>
<th><?php echo ��������������������������������������������������������������������������������('参数'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('类型'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('必填'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('说明'); ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($row['params'] as $p) {
$pn=htmlspecialchars((string)($p['name'] ?? ''), ENT_QUOTES, 'UTF-8');
$dt=htmlspecialchars((string)($p['dtype'] ?? ''), ENT_QUOTES, 'UTF-8');
$rq=htmlspecialchars((string)($p['required'] ?? ''), ENT_QUOTES, 'UTF-8');
$ds=htmlspecialchars((string)($p['desc'] ?? ''), ENT_QUOTES, 'UTF-8');
?>
<tr>
<td><code><?php echo $pn; ?></code></td>
<td><?php echo $dt; ?></td>
<td><?php echo $rq; ?></td>
<td><?php echo $ds; ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } ?>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 12px;">
<legend><?php echo ��������������������������������������������������������������������������������('原始 XML'); ?></legend>
</fieldset>
<pre class="apilib-doc-pre"><?php echo $raw; ?></pre>
</div>
</div>
<?php } ?>
</div>
</div>
<?php
}
}
?>
</div>
</div>
</div>
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/layui.js"></script>
<script>layui.use(['element', 'form'], function () {var element=layui.element;var $=layui.$;var inp=document.getElementById('apilib-doc-filter');if (!inp) return;function applyFilter() {var q=(inp.value || '').toLowerCase().replace(/^\s+|\s+$/g, '');var items=document.querySelectorAll('#apilib-doc-root .apilib-doc-item');for (var i=0; i < items.length; i++) {var el=items[i];var blob=(el.getAttribute('data-search') || '').toLowerCase();var show=!q || blob.indexOf(q) !==-1;el.style.display=show ? '' : 'none';}var groups=document.querySelectorAll('#apilib-doc-root .apilib-doc-group');for (var g=0; g < groups.length; g++) {var grp=groups[g];var vis=false;var ch=grp.querySelectorAll('.apilib-doc-item');for (var j=0; j < ch.length; j++) {if (ch[j].style.display !=='none') { vis=true; break; }}grp.style.display=vis ? '' : 'none';}}inp.addEventListener('input', applyFilter);inp.addEventListener('change', applyFilter);});</script>
</body>
</html>
