<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), ����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?> - <?php echo ��������������������������������������������������������������������������������('WEBAPI接口'); ?> Bsphp-Pro</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
<style>.api-debug { --api-method-bg:#1d90fc; --api-url-bg: #fafafa; --api-border: #e8e8e8; }.api-debug .api-header { border-bottom: 1px solid var(--api-border); padding-bottom: 12px; margin-bottom: 16px; }.api-debug .api-header h2 { margin: 0; font-size: 18px; font-weight: 600; color: #262626; }.api-debug .api-header p { margin: 6px 0 0; font-size: 12px; color: #8c8c8c; }.api-debug .api-request-bar { display: flex; align-items: center; gap: 0; margin-bottom: 16px; border: 1px solid var(--api-border); border-radius: 4px; overflow: hidden; background: #fff; }.api-debug .api-method { padding: 8px 14px; font-size: 12px; font-weight: 600; background: var(--api-method-bg); color: #fff; min-width: 52px; text-align: center; }.api-debug .api-url-wrap { flex: 1; display: flex; align-items: stretch; min-width: 0; }.api-debug .api-url { flex: 1; padding: 10px 12px; font-family: Consolas, Monaco, monospace; font-size: 13px; border: none; background: var(--api-url-bg); color: #262626; resize: none; }.api-debug .api-url:focus { outline: none; background: #fff; }.api-debug .api-url-actions { display: flex; border-left: 1px solid var(--api-border); }.api-debug .api-url-actions .layui-btn { border-radius: 0; border: none; padding: 0 14px; }.api-debug .api-section { margin-bottom: 20px; }.api-debug .api-section-title { font-size: 13px; font-weight: 600; color: #262626; margin-bottom: 10px; padding-bottom: 6px; border-bottom: 1px solid #f0f0f0; }.api-debug .api-params-table { border: 1px solid var(--api-border); border-radius: 4px; overflow: hidden; }.api-debug .api-params-table .layui-table { margin: 0; }.api-debug .api-params-table .layui-table th { background: #fafafa; font-size: 12px; }.api-debug .api-params-table .layui-table td { font-size: 13px; }.api-debug .api-params-table .param-name { font-family: Consolas, Monaco, monospace; color: #d4380d; }.api-debug .api-params-table .param-required { font-size: 11px; color: #ff4d4f; margin-left: 4px; }.api-debug .api-params-table .param-desc { font-size: 12px; color: #8c8c8c; }.api-debug .api-doc-table .layui-table th { background: #fafafa; }.api-debug .api-doc-table .endpoint { font-family: Consolas, Monaco, monospace; font-size: 12px; word-break: break-all; color: #1890ff; }.api-debug .api-doc-hint { font-size: 12px; color: #8c8c8c; margin-bottom: 12px; }.api-debug .api-doc-hint a { color: #1890ff; }#apiParamsForm { padding-bottom: 200px; }</style>
</head>
<body>
<div class="layui-fluid api-debug">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-body">
<div class="api-header">
<h2><?php echo ��������������������������������������������������������������������������������('API 参数调试'); ?></h2>
<p><?php echo ��������������������������������������������������������������������������������('选择接口、填写 Query 参数后自动生成请求 URL，支持复制、预览与新窗口打开。'); ?></p>
</div>
<div class="api-section">
<div class="api-section-title"><?php echo ��������������������������������������������������������������������������������('选择接口'); ?></div>
<div style="max-width: 480px;">
<select id="apiSelect" lay-filter="apiSelect" class="layui-input"></select>
</div>
</div>
<div class="api-section">
<div class="api-section-title"><?php echo ��������������������������������������������������������������������������������('请求 URL'); ?></div>
<div class="api-request-bar">
<span class="api-method" id="apiMethod">GET</span>
<div class="api-url-wrap">
<textarea id="apiUrl" class="api-url" readonly rows="1" placeholder="<?php echo ��������������������������������������������������������������������������������('选择接口并填写参数后将生成完整 URL'); ?>"></textarea>
</div>
<div class="api-url-actions">
<button type="button" class="layui-btn layui-btn-sm layui-btn-normal" id="btnCopy" title="<?php echo ��������������������������������������������������������������������������������('复制链接'); ?>">
<i class="layui-icon layui-icon-file"></i> <?php echo ��������������������������������������������������������������������������������('复制'); ?>
</button>
<button type="button" class="layui-btn layui-btn-sm" id="btnPreview" title="<?php echo ��������������������������������������������������������������������������������('预览'); ?>">
<i class="layui-icon layui-icon-website"></i> <?php echo ��������������������������������������������������������������������������������('预览'); ?>
</button>
<button type="button" class="layui-btn layui-btn-sm" id="btnOpen" title="<?php echo ��������������������������������������������������������������������������������('新窗口打开'); ?>">
<i class="layui-icon layui-icon-website"></i> <?php echo ��������������������������������������������������������������������������������('新窗口打开'); ?>
</button>
</div>
</div>
</div>
<div class="api-section">
<div class="api-section-title"><?php echo ��������������������������������������������������������������������������������('固定参数'); ?></div>
<div class="api-params-table">
<form class="layui-form" lay-filter="apiParamsForm" id="apiParamsForm">
<table class="layui-table" lay-skin="line">
<thead>
<tr>
<th width="140"><?php echo ��������������������������������������������������������������������������������('参数名'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('参数值'); ?></th>
<th width="80"><?php echo ��������������������������������������������������������������������������������('必填'); ?></th>
<th width="200"><?php echo ��������������������������������������������������������������������������������('说明'); ?></th>
</tr>
</thead>
<tbody>
<tr>
<td><span class="param-name">wrap</span></td>
<td>
<select id="param-wrap" lay-filter="apiParamsForm" class="layui-input" style="height:32px;max-width:240px;">
<option value=""><?php echo ��������������������������������������������������������������������������������('默认风格'); ?></option>
<option value="1"><?php echo ��������������������������������������������������������������������������������('平铺风格'); ?></option>
<option value="2"><?php echo ��������������������������������������������������������������������������������('平铺无标题'); ?></option>
<option value="4"><?php echo ��������������������������������������������������������������������������������('平铺风格 宽度100% 边界0 有标题'); ?></option>
<option value="5"><?php echo ��������������������������������������������������������������������������������('平铺风格 宽度100% 边界0 无标题'); ?></option>
</select>
</td>
<td><?php echo ��������������������������������������������������������������������������������('否'); ?></td>
<td class="param-desc"><?php echo ��������������������������������������������������������������������������������('页面显示样式，嵌入时使用平铺'); ?></td>
</tr>
</tbody>
<tbody id="apiParamsBody"></tbody>
</table>
</form>
</div>
</div>
<hr class="layui-bg-gray" style="margin: 24px 0 16px;">
<div class="api-section">
<div class="api-section-title"><?php echo ��������������������������������������������������������������������������������('接口列表'); ?></div>
<div class="api-doc-hint">
<?php echo ��������������������������������������������������������������������������������('接口控制文件'); ?>: <code>include/modules/webapi/</code>
&nbsp;|&nbsp;<?php echo ��������������������������������������������������������������������������������('模版'); ?>: <code>include/templates/default/webapi/</code>
</div>
<table class="layui-table api-doc-table" lay-skin="line">
<thead>
<tr>
<th width="60">Method</th>
<th width="200"><?php echo ��������������������������������������������������������������������������������('接口'); ?></th>
<th><?php echo ��������������������������������������������������������������������������������('Endpoint'); ?></th>
</tr>
</thead>
<tbody id="apiTableBody"></tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="foot" style="padding: 12px 0; font-size: 12px; color: #8c8c8c;">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Pro <?php echo BSPHP_VERSION; ?></a> Bsphp.com · All Rights Reserved</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>bsphp_report_quickstat('<?php echo ��������������������������������������������������������������������������������("WEBAPI接口"); ?>');(function() {var softList=<?php echo json_encode(isset($������������������������������������������������������������������������������������) ? $������������������������������������������������������������������������������������ : array()); ?>;var kaleiList=<?php echo json_encode(isset($������������������������������������������������������������������������) ? $������������������������������������������������������������������������ : array()); ?>;var apiList=<?php echo json_encode(isset($��������������������������������������������������������������������������������) ? $�������������������������������������������������������������������������������� : array()); ?>;var baseUrl=window.location.protocol + '//' + window.location.host;function getApiById(id) {for (var i=0; i < apiList.length; i++) {if (apiList[i].id===id) return apiList[i];}return null;}function getUrlTemplate(api) {var q=[];if (api.fixed) {for (var k in api.fixed) {if (api.fixed.hasOwnProperty(k)) q.push(k + '=' + api.fixed[k]);}}if (api.params) {api.params.forEach(function(p) {var hint=p.labelNote || p.label || p.name;if (p.optional) hint +=':<?php echo ��������������������������������������������������������������������������������('可空'); ?>';else if (p.options) hint +='|' + p.options.map(function(o) { return o.value; }).join('|');else if (p.tip) hint +=':<?php echo ��������������������������������������������������������������������������������('自定义'); ?>';q.push(p.name + '=[' + hint + ']');});}return api.path + (q.length ? '?' + q.join('&') : '');}function escapeHtml(s) {if (s==null) return '';var d=document.createElement('div');d.textContent=s;return d.innerHTML;}function renderDocTable() {var tbody=document.getElementById('apiTableBody');if (!tbody) return;var html='';apiList.forEach(function(api) {var method=(api.method || 'GET').toUpperCase();var endpoint=baseUrl + getUrlTemplate(api);html +='<tr><td><span class="api-method" style="display:inline-block;padding:2px 8px;font-size:11px;border-radius:2px;background:#1d90fc;color:#fff;">' + method + '</span></td><td>' + escapeHtml(api.name) + '</td><td><span class="endpoint">' + escapeHtml(endpoint) + '</span></td></tr>';});tbody.innerHTML=html;}layui.use(['jquery', 'layer', 'form'], function() {var $=layui.$;var layer=layui.layer;var form=layui.form;renderDocTable();function renderSelect() {var $sel=$('#apiSelect');$sel.empty();apiList.forEach(function(api) {$sel.append($('<option>').attr('value', api.id).text(api.name));});if (apiList.length) {$sel.val(apiList[0].id);$('#apiMethod').text((apiList[0].method || 'GET').toUpperCase());}form.render('select');if (apiList.length) renderParams(getApiById(apiList[0].id));}function renderParams(api) {var tbody=$('#apiParamsBody');tbody.empty();if (!api) {buildUrl();return;}if (!api.params || !api.params.length) {tbody.html('<tr><td colspan="4" class="layui-table-cell" style="color:#8c8c8c;"><?php echo ��������������������������������������������������������������������������������('当前接口没有可配置参数'); ?></td></tr>');$('#param-wrap').off('change').on('change', buildUrl);buildUrl();return;}api.params.forEach(function(p) {var required=p.required ? '<?php echo ��������������������������������������������������������������������������������('是'); ?>' : '<?php echo ��������������������������������������������������������������������������������('否'); ?>';var desc=p.tip || p.label || (p.optional ? '<?php echo ��������������������������������������������������������������������������������('可空'); ?>' : '') || '';var inputId='param-' + p.name;var cellValue;if (p.name==='daihao') {var opts='<option value=""><?php echo ��������������������������������������������������������������������������������('请选择软件'); ?></option>';if (softList && softList.length) {opts +=softList.map(function(o) {var sel=(p.defaultValue===o.value) ? ' selected' : '';return '<option value="' + escapeHtml(o.value) + '"' + sel + '>' + escapeHtml(o.text || o.value) + '</option>';}).join('');}cellValue='<select id="' + inputId + '" lay-filter="apiParamsForm" class="layui-input" style="height:32px;">' + opts + '</select>';} else if (p.name==='carid') {var opts='<option value=""><?php echo ��������������������������������������������������������������������������������('请选择卡类'); ?></option>';if (kaleiList && kaleiList.length) {opts +=kaleiList.map(function(o) {var sel=(p.defaultValue===o.value) ? ' selected' : '';return '<option value="' + escapeHtml(o.value) + '"' + sel + '>' + escapeHtml(o.text || o.value) + '</option>';}).join('');}cellValue='<select id="' + inputId + '" lay-filter="apiParamsForm" class="layui-input" style="height:32px;">' + opts + '</select>';} else if (p.options && p.options.length) {var opts=p.options.map(function(o) {var sel=(p.defaultValue===o.value) ? ' selected' : '';return '<option value="' + escapeHtml(o.value) + '"' + sel + '>' + escapeHtml(o.text || o.value) + '</option>';}).join('');cellValue='<select id="' + inputId + '" lay-filter="apiParamsForm" class="layui-input" style="height:32px;">' + opts + '</select>';} else {var val=(p.defaultValue !=null ? escapeHtml(p.defaultValue) : '');var ph=p.optional ? '<?php echo ��������������������������������������������������������������������������������('可空'); ?>' : '';cellValue='<input type="text" class="layui-input" id="' + inputId + '" value="' + val + '" placeholder="' + ph + '" style="height:32px;" />';}var nameCell='<span class="param-name">' + escapeHtml(p.name) + '</span>' + (p.required ? '<span class="param-required">*</span>' : '');var row='<tr><td>' + nameCell + '</td><td>' + cellValue + '</td><td>' + escapeHtml(required) + '</td><td class="param-desc">' + escapeHtml(desc) + '</td></tr>';tbody.append(row);});form.render('select', 'apiParamsForm');$('#param-wrap').off('change').on('change', buildUrl);tbody.find('input, select').off('input change').on('input change', buildUrl);buildUrl();}function buildUrl() {var apiId=$('#apiSelect').val();var api=getApiById(apiId);if (!api) {$('#apiUrl').val('');return '';}var params={};if (api.fixed) {for (var k in api.fixed) {if (api.fixed.hasOwnProperty(k)) params[k]=api.fixed[k];}}if (api.params) {api.params.forEach(function(p) {var $el=$('#param-' + p.name);if ($el.length) {var val=$el.val();if (val !=null && val !=='' || p.required || p.defaultValue !=null) params[p.name]=val || p.defaultValue || '';}});}var wrapVal=$('#param-wrap').val();if (wrapVal !=='' && wrapVal !=null) params.wrap=wrapVal;var query=$.param(params);var url=baseUrl + api.path + (query ? '?' + query : '');$('#apiUrl').val(url);return url;}function copyText(text) {if (navigator.clipboard && navigator.clipboard.writeText) {navigator.clipboard.writeText(text).then(function() {layer.msg('<?php echo ��������������������������������������������������������������������������������('已复制到剪贴板'); ?>');}).catch(function() { fallbackCopy(text); });} else fallbackCopy(text);}function fallbackCopy(text) {var $ta=$('<textarea>').css({ position: 'fixed', opacity: 0 }).val(text).appendTo('body');$ta[0].select();try {document.execCommand('copy');layer.msg('<?php echo ��������������������������������������������������������������������������������('已复制到剪贴板'); ?>');} catch (e) {layer.alert('<?php echo ��������������������������������������������������������������������������������('浏览器不支持自动复制，请手动复制。'); ?>');}$ta.remove();}$('#btnCopy').on('click', function() {var url=buildUrl();if (!url) { layer.msg('<?php echo ��������������������������������������������������������������������������������('请先选择接口并填写参数'); ?>'); return; }copyText(url);});$('#btnPreview').on('click', function() {var url=buildUrl();if (!url) { layer.msg('<?php echo ��������������������������������������������������������������������������������('请先选择接口并填写参数'); ?>'); return; }layer.open({type: 2,title: '<?php echo ��������������������������������������������������������������������������������('预览'); ?>',area: ['90%', '85%'],maxmin: true,content: url});});$('#btnOpen').on('click', function() {var url=buildUrl();if (!url) { layer.msg('<?php echo ��������������������������������������������������������������������������������('请先选择接口并填写参数'); ?>'); return; }window.open(url, '_blank');});function onApiSelectChange() {var val=$('#apiSelect').val();var api=getApiById(val);if (api) {$('#apiMethod').text((api.method || 'GET').toUpperCase());renderParams(api);}}form.on('select(apiSelect)', function(data) {onApiSelectChange();});$(document).on('change', '#apiSelect', function() {onApiSelectChange();});renderSelect();});})();</script>
</body>
</html>
