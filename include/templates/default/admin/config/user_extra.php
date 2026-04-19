<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), ����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('用户拓展字段'); ?> Bsphp-Pro</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
</head>
<body data="BSPHP-PRO 本系统受国家版权局保护请勿破解或者二次开发传播">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('用户拓展字段'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="" name="bsphppost" id="bsphppost" method="post">
<div class="layui-form-item layui-form-text">
<div class="layui-form-mid layui-word-aux" style="margin-left: 0;">
<?php echo ��������������������������������������������������������������������������������('字段键为英文标识（首字母字母，可含数字下划线），列表与编辑页将按此处表头显示。保存后请在数据库执行升级脚本添加 user_extra 列（若尚未执行）。注册接口传参示例：&user_extra={"key1":"","key2":"","key3":""}'); ?>
</div>
</div>
<table class="layui-table" id="ue-table" lay-size="sm">
<thead>
<tr>
<th width="160"><?php echo ��������������������������������������������������������������������������������('字段键'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('表头名称'); ?></th>
<th width="90"><?php echo ��������������������������������������������������������������������������������('必填'); ?></th>
<th width="120"><?php echo ��������������������������������������������������������������������������������('用户列表显示'); ?></th>
<th width="88"><?php echo ��������������������������������������������������������������������������������('操作'); ?></th>
</tr>
</thead>
<tbody id="ue-tbody"></tbody>
</table>
<div class="layui-form-item">
<button type="button" class="layui-btn layui-btn-primary" id="ue-add"><?php echo ��������������������������������������������������������������������������������('添加一行'); ?></button>
</div>
<input type="hidden" name="user_extra_fields" id="user_extra_fields" value="">
<input id="admin" type="hidden" name="appenconfig" value="1">
<div class="layui-form-item">
<div class="layui-input-block">
<button type="button" class="layui-btn" id="ue-btn-save"><?php echo ��������������������������������������������������������������������������������('确认保存'); ?></button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="foot">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Pro <?php echo BSPHP_VERSION; ?></a> Bsphp.com <br>
All Rights Reserved </div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>bsphp_report_quickstat('<?php echo ��������������������������������������������������������������������������������("用户拓展字段"); ?>');var UE_ROWS=<?php echo json_encode(����������������������������������������������������������������������������(), JSON_UNESCAPED_UNICODE); ?>;function ueRowHtml(key, label, required, showInList) {key=key || '';label=label || '';var reqOn=(required===1 || required===true);var listOn=!(showInList===0 || showInList===false);var reqOpts='<option value="0"' + (reqOn ? '' : ' selected') + '><?php echo ��������������������������������������������������������������������������������('否'); ?></option>' +'<option value="1"' + (reqOn ? ' selected' : '') + '><?php echo ��������������������������������������������������������������������������������('是'); ?></option>';var listOpts='<option value="0"' + (listOn ? '' : ' selected') + '><?php echo ��������������������������������������������������������������������������������('否'); ?></option>' +'<option value="1"' + (listOn ? ' selected' : '') + '><?php echo ��������������������������������������������������������������������������������('是'); ?></option>';return '<tr class="ue-row">' +'<td><input type="text" class="layui-input ue-key" placeholder="company" value=' + JSON.stringify(key) + '></td>' +'<td><input type="text" class="layui-input ue-label" placeholder="" value=' + JSON.stringify(label) + '></td>' +'<td><select class="layui-input ue-req" lay-ignore>' + reqOpts + '</select></td>' +'<td><select class="layui-input ue-list" lay-ignore>' + listOpts + '</select></td>' +'<td><button type="button" class="layui-btn layui-btn-danger layui-btn-xs ue-del"><?php echo ��������������������������������������������������������������������������������('删除'); ?></button></td>' +'</tr>';}function ueSync() {var tb=document.getElementById('ue-tbody');if (!tb.querySelector('.ue-row')) {tb.insertAdjacentHTML('beforeend', ueRowHtml('', '', 0, 1));}}function ueSerializeToHidden($) {var rows=[];$('.ue-row').each(function() {var key=$(this).find('.ue-key').val().trim();var label=$(this).find('.ue-label').val().trim();if (key) {rows.push({key: key,label: label || key,required: parseInt($(this).find('.ue-req').val(), 10) ? 1 : 0,show_in_list: parseInt($(this).find('.ue-list').val(), 10) ? 1 : 0});}});$('#user_extra_fields').val(JSON.stringify(rows));}layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['index', 'jquery', 'layer'], function() {var $=layui.$;var layer=layui.layer;var tb=document.getElementById('ue-tbody');if (UE_ROWS && UE_ROWS.length) {UE_ROWS.forEach(function(r) {tb.insertAdjacentHTML('beforeend', ueRowHtml(r.key || '', r.label || '', r.required, r.show_in_list));});} else {tb.insertAdjacentHTML('beforeend', ueRowHtml('', '', 0, 1));}ueSync();document.getElementById('ue-add').onclick=function() {document.getElementById('ue-tbody').insertAdjacentHTML('beforeend', ueRowHtml('', '', 0, 1));};document.getElementById('ue-tbody').addEventListener('click', function(e) {if (e.target && e.target.classList.contains('ue-del')) {var tr=e.target.closest('tr');if (tr) tr.parentNode.removeChild(tr);ueSync();}});function layerTop() {try {if (top !==self && top.layui && top.layui.layer) {return top.layui.layer;}} catch (e) {}return layer;}$('#ue-btn-save').on('click', function() {ueSerializeToHidden($);var L=layerTop();var loadIdx=L.load(1, { shade: 0.1 });$.ajax({type: 'post',url: window.location.href.split('#')[0],data: $('#bsphppost').serialize(),dataType: 'json',success: function(ret) {L.close(loadIdx);var msg=(ret && (ret.msg !==undefined && ret.msg !==null)) ? String(ret.msg) : '';if (msg==='') {msg='OK';}L.alert(msg, { title: '<?php echo ��������������������������������������������������������������������������������('系统提示'); ?>' }, function(idx) {L.close(idx);var base=window.location.href.split('#')[0];if (base.indexOf('?') >=0) {window.location.href=base + '&_t=' + (new Date().getTime());} else {window.location.href=base + '?_t=' + (new Date().getTime());}});},error: function(xhr) {L.close(loadIdx);var txt=(xhr && xhr.responseText) ? xhr.responseText : '';L.alert(txt ? txt.substring(0, 1200) : 'request error');}});});});</script>
</body>
</html>
