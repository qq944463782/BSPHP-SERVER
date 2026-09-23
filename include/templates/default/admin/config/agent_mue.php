<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), ����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('代理导航菜单控制'); ?> Bsphp-Rsa</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=1580">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
</head>
<body data="Bsphp-Rsa 2022本系统受国家版权局保护请勿破解或者二次开发传播">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('代理导航菜单控制'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="" name="bsphppost" id="bsphppost" method="post">
<?php
$agent_menu_rows=array();
$agent_menu_scan_dir=����������������������������������������4�������������������� . 'Plug/Agent_list';
if (is_dir($agent_menu_scan_dir)) {
$agent_menu_files=@scandir($agent_menu_scan_dir);
if (is_array($agent_menu_files)) {
foreach ($agent_menu_files as $menu_file_name) {
if (strpos($menu_file_name, 'agent_') !==0 || substr($menu_file_name, -4) !=='.php') {
continue;
}
$menu_file_path=$agent_menu_scan_dir . '/' . $menu_file_name;
if (!is_file($menu_file_path)) {
continue;
}
$menu_text=@file_get_contents($menu_file_path);
if ($menu_text===false) {
continue;
}
$menu_json=json_decode(trim($menu_text), true);
if (!is_array($menu_json) || !isset($menu_json['agentMenu']) || !is_array($menu_json['agentMenu'])) {
continue;
}
foreach ($menu_json['agentMenu'] as $menu_item) {
if (!is_array($menu_item) || empty($menu_item['id'])) {
continue;
}
$menu_id=trim((string)$menu_item['id']);
$menu_name=isset($menu_item['name']) ? (string)$menu_item['name'] : $menu_id;
if (!isset($agent_menu_rows[$menu_id])) {
$agent_menu_rows[$menu_id]=array(
'id'=> $menu_id,
'name'=> $menu_name,
'level'=> 1,
);
}
if (isset($menu_item['children']) && is_array($menu_item['children'])) {
foreach ($menu_item['children'] as $child_item) {
if (!is_array($child_item) || empty($child_item['id'])) {
continue;
}
$child_id=trim((string)$child_item['id']);
$child_name=isset($child_item['name']) ? (string)$child_item['name'] : $child_id;
if (!isset($agent_menu_rows[$child_id])) {
$agent_menu_rows[$child_id]=array(
'id'=> $child_id,
'name'=> $child_name,
'level'=> 2,
);
}
}
}
}
}
}
}
$saved_hide_map=array();
for ($grade_i=1; $grade_i <=3; $grade_i++) {
$saved_hide_ids=trim((string)����������������������������������������������������������������::������������������������������������������������������������������������������������('agents', 'agent_menu_hide_ids_' . $grade_i));
$saved_hide_arr=$saved_hide_ids==='' ? array() : array_map('trim', explode(',', $saved_hide_ids));
$saved_hide_map[$grade_i]=array();
foreach ($saved_hide_arr as $hide_id) {
if ($hide_id !=='') {
$saved_hide_map[$grade_i][$hide_id]=1;
}
}
}
?>
<div class="layui-form-mid layui-word-aux" style="margin-bottom: 10px;">
<?php echo ��������������������������������������������������������������������������������('单表控制：勾选代表对应星级显示，默认都显示。'); ?>
</div>
<table class="layui-table" lay-size="sm">
<colgroup>
<col width="420">
<col width="220">
<col width="130">
<col width="130">
<col width="130">
</colgroup>
<thead>
<tr>
<th><?php echo ��������������������������������������������������������������������������������('菜单名称'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('菜单ID'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('1星总代理'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('2星代理'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('3星代理'); ?></th>
</tr>
</thead>
<tbody>
<?php if (!empty($agent_menu_rows)) { ?>
<?php foreach ($agent_menu_rows as $menu_row) { ?>
<?php
$row_id=$menu_row['id'];
$row_name=$menu_row['name'];
$row_level=(int)$menu_row['level'];
?>
<tr>
<td><?php if ($row_level==2) { ?>└─ <?php } ?><?php echo htmlspecialchars($row_name, ENT_QUOTES, 'UTF-8'); ?></td>
<td><?php echo htmlspecialchars($row_id, ENT_QUOTES, 'UTF-8'); ?></td>
<?php for ($grade_i=1; $grade_i <=3; $grade_i++) { ?>
<?php $checked=!isset($saved_hide_map[$grade_i][$row_id]); ?>
<td>
<input type="checkbox"
name="agent_menu_show_ids_arr_<?php echo $grade_i; ?>[]"
value="<?php echo htmlspecialchars($row_id, ENT_QUOTES, 'UTF-8'); ?>"
<?php if ($checked) { ?>checked<?php } ?>>
</td>
<?php } ?>
</tr>
<?php } ?>
<?php } else { ?>
<tr><td colspan="5"><?php echo ��������������������������������������������������������������������������������('未检测到菜单JSON，请检查 Plug/Agent_list/agent_*.php'); ?></td></tr>
<?php } ?>
</tbody>
</table>
<div class="layui-form-item">
<div class="layui-input-block">
<input id="admin" type="hidden" name="appenconfig" value="1">
<button class="layui-btn" lay-submit lay-filter="set_website"><?php echo ��������������������������������������������������������������������������������('确认保存'); ?></button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="foot">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Rsa <?php echo BSPHP_VERSION; ?></a> Bsphp.com <br>
All Rights Reserved </div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>bsphp_report_quickstat('<?php echo ��������������������������������������������������������������������������������("代理导航菜单控制"); ?>');layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['index', 'set']);</script>
</body>
</html>
