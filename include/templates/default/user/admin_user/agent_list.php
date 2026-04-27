<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo ��������������������������������������������������������������������������������('选择代理'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
<style>html,body {height: 100%;padding: 10px;font-size: 14px;background: #fff;width: auto;margin: 0 auto;font-size: 14px;line-height: 20px;overflow: auto;box-sizing: border-box;}p {margin-bottom: 10px;}input {border: 1px solid #999;padding: 5px 10px;margin: 0 10px 10px 0;}.agent-tree-wrap {display: block;width: 100%;height: calc(100vh - 90px);min-height: 260px;overflow: auto;box-sizing: border-box;}</style>
</head>
<body data="Bsphp-Rsa 2022本系统受国家版权局保护请勿破解或者二次开发传播">
<?php
if (������������������������������������）������������������������������������������������(����������������������������������������������������������������������������(105).����������������������������������������������������������������������������(100)) !=-1) {
?>
<input class="layui-input" placeholder="<?php echo ��������������������������������������������������������������������������������('代理账号'); ?>" value="<?php echo ������������������������������������）������������������������������������������������(����������������������������������������������������������������������������(118).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(108)); ?>" id="LAY_mark">
<?php
}
?>
<div class="layui-btn-container">
<?php
if (������������������������������������）������������������������������������������������(����������������������������������������������������������������������������(105).����������������������������������������������������������������������������(100)) !=-1) {
echo
'<button class="layui-btn layui-btn-primary" data-type="setParent">'.��������������������������������������������������������������������������������('确定').'</button>';
}
?>
</div>
<div class="agent-tree-wrap">
<table class="layui-table" lay-size="sm">
<thead>
<tr>
<th style="width: 70px;">UID</th>
<th>代理账号</th>
<th style="width: 120px;">层级</th>
<th style="width: 90px;">下级数</th>
<th style="width: 120px;">用户数</th>
</tr>
</thead>
<tbody id="agent-tree-body"></tbody>
</table>
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.use(['layer'], function() {var $=layui.$,layer=layui.layer,index=parent.layer.getFrameIndex(window.name);var nodes=<?php echo json_encode(����������������������������������������������������9��������������������(-1)); ?> || [];var active={auto: function() {parent.layer.iframeAuto(index);},parentPopup: function() {parent.layer.msg('Hi, man', {shade: 0.3})},setParent: function() {var id='#<?php echo ������������������������������������）������������������������������������������������(����������������������������������������������������������������������������(105).����������������������������������������������������������������������������(100)); ?>',mark=$('#LAY_mark'),val=mark.val();if (id=='#-1') {return true;}parent.layui.$(id).val(val);parent.layer.tips('请搜索', id, {time: 5000});parent.layer.close(index);},close: function(set) {parent.layer.close(index);}};$('.layui-btn-container .layui-btn').on('click', function() {var othis=$(this),type=othis.data('type');active[type] && active[type].call(this);});function flattenTree(list, level, parentPath, out) {level=level || 1;parentPath=parentPath || '';out=out || [];for (var i=0; i < list.length; i++) {var n=list[i] || {};var rowPath=parentPath ? (parentPath + '-' + i) : String(i);var children=Array.isArray(n.children) ? n.children : [];out.push({uid: n.uid || 0,name: n.name || '',level: level,childrenCount: children.length,userCount: n.user_count || 0,path: rowPath,parentPath: parentPath,hasChildren: children.length > 0,isOpen: level <=2});if (children.length > 0) {flattenTree(children, level + 1, rowPath, out);}}return out;}function getRowVisible(row, rowsByPath) {if (!row.parentPath) return true;var p=rowsByPath[row.parentPath];if (!p) return true;if (!p.isOpen) return false;return getRowVisible(p, rowsByPath);}var flatRows=flattenTree(nodes);var rowsByPath={};for (var i=0; i < flatRows.length; i++) {rowsByPath[flatRows[i].path]=flatRows[i];}function renderTable() {var html='';for (var i=0; i < flatRows.length; i++) {var row=flatRows[i];var visible=getRowVisible(row, rowsByPath);var indent=(row.level - 1) * 18;var toggle='';if (row.hasChildren) {toggle='<a href="javascript:;" class="tree-toggle" data-path="' + row.path + '" style="margin-right:6px;">' + (row.isOpen ? '[-]' : '[+]') + '</a>';} else {toggle='<span style="display:inline-block;width:28px;"></span>';}html +='<tr class="tree-row" data-name="' + $('<div/>').text(row.name).html() + '" style="' + (visible ? '' : 'display:none;') + '">' +'<td>' + row.uid + '</td>' +'<td><span style="display:inline-block;padding-left:' + indent + 'px;">' + toggle + '<a href="javascript:;" class="pick-agent" data-name="' + $('<div/>').text(row.name).html() + '">' + $('<div/>').text(row.name).html() + '</a></span></td>' +'<td>第' + row.level + '级</td>' +'<td>' + row.childrenCount + '</td>' +'<td><a href="javascript:;" class="open-users" data-uid="' + row.uid + '">' + row.userCount + '条</a></td>' +'</tr>';}$('#agent-tree-body').html(html);}renderTable();$('#agent-tree-body').on('click', '.tree-toggle', function() {var p=$(this).data('path');if (rowsByPath[p]) {rowsByPath[p].isOpen=!rowsByPath[p].isOpen;renderTable();}});$('#agent-tree-body').on('click', '.pick-agent', function() {var val=$(this).data('name') || '';$('#LAY_mark').val(val);var id='#<?php echo ������������������������������������）������������������������������������������������(����������������������������������������������������������������������������(105).����������������������������������������������������������������������������(100)); ?>',mark=$('#LAY_mark'),v=mark.val();if (id=='#-1') {return true;}parent.layui.$(id).val(v);parent.layer.tips('请搜索', id, { time: 5000 });parent.layer.close(index);});$('#agent-tree-body').on('click', '.open-users', function() {var uid=parseInt($(this).data('uid'), 10) || 0;if (uid <=0) return;var url='index.php?m=user&c=admin_user&a=table&soso_id=6&soso=' + uid + '&soso_ok=1';if (top && top.layui && top.layui.layer) {var i=top.layui.layer.open({type: 2,title: '邀请人UID=' + uid + ' 用户列表',area: ['100%', '100%'],maxmin: true,content: url});top.layui.layer.full(i);} else {window.open(url, '_blank');}});});</script>
</body>
</html>