<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), ����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('帐号批量维护'); ?>  Bsphp-Rsa</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
</head>
<body data="Bsphp-Rsa 2022本系统受国家版权局保护请勿破解或者二次开发传播">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('帐号批量维护'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="" name="bsphppost" id="bsphppost" method="post">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('维护范围'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<select name="select" size="13">
<option value="user_all"><?php echo ��������������������������������������������������������������������������������('所有用户'); ?></option>
<option value="out_1"><?php echo ��������������������������������������������������������������������������������('状态冻结'); ?></option>
<option value="out_0"><?php echo ��������������������������������������������������������������������������������('状态正常'); ?></option>
<option value="login_not"><?php echo ��������������������������������������������������������������������������������('未登录过用户'); ?></option>
<option value="login_today"><?php echo ��������������������������������������������������������������������������������('今天登陆用户'); ?></option>
<option value="all"><?php echo ��������������������������������������������������������������������������������('全部代理商'); ?></option>
</select>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('选择要维护的账号范围'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('代理商'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="checkbox" value="1" name="checkbox" title="<?php echo ��������������������������������������������������������������������������������('代理商除外');?>" checked>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('批量处理时候不选择代理商'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('操作'); ?></label>
<div class="layui-input-inline" style="width: aout;">
<input type="radio" name="radiobutton" id="radiobutton" lay-filter="sex"  class="radiobutton" title="<?php echo ��������������������������������������������������������������������������������('增加金额N元');?>" value="1">
<input type="radio" name="radiobutton" id="radiobutton" lay-filter="sex"  class="radiobutton" title="<?php echo ��������������������������������������������������������������������������������('减少金额N元');?>" value="2">
<input type="radio" name="radiobutton" id="radiobutton" lay-filter="sex" class="radiobutton"  title="<?php echo ��������������������������������������������������������������������������������('调整折扣N折');?>" value="3">
<input type="radio" name="radiobutton" id="radiobutton" lay-filter="sex" class="radiobutton"  title="<?php echo ��������������������������������������������������������������������������������('状态冻结');?>" value="4">
<input type="radio" name="radiobutton" id="radiobutton" lay-filter="sex"  class="radiobutton" title="<?php echo ��������������������������������������������������������������������������������('状态解冻');?>" value="5">
<input type="radio" name="radiobutton" id="radiobutton" lay-filter="sex" class="radiobutton"  title="<?php echo ��������������������������������������������������������������������������������('删除账号');?>" value="6">
<input type="radio" name="radiobutton" id="radiobutton" lay-filter="sex"  class="radiobutton" title="<?php echo ��������������������������������������������������������������������������������('删除N天未登录账号');?>" value="7">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('选择要执行的结果功能'); ?></div>
</div>
<div style="display: none;" class="layui-form-item div_intval">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('N值输入'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="intval" id="intval" placeholder="<?php echo ��������������������������������������������������������������������������������('N值'); ?>" value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('没有N操作选项可以忽略该值'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('注意'); ?></label>
<div class="layui-input-inline" style="width: auto;">
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('在批量操作数据库时请先备份相关数据库,数据无价。');?></div>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('操作摘要'); ?></label>
<div class="layui-input-inline" style="width: auto;">
<div class="layui-form-mid layui-word-aux" id="op_summary">请先选择维护范围和操作类型</div>
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<input id="admin" type="hidden" name="appenconfig" value="1">
<button class="layui-btn" id="setpost" name="setpost"><?php echo ��������������������������������������������������������������������������������('确认操作'); ?></button>
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
<script>layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['index', 'set', 'jquery', 'table','form', 'layer'], function() {var $=layui.$,form=layui.form,layer=layui.layer;function needIntval(radiobutton) {return radiobutton=='1' || radiobutton=='2' || radiobutton=='3' || radiobutton=='7';}function getRangeText(selectVal) {var map={user_all: '所有用户',out_1: '状态冻结用户',out_0: '状态正常用户',login_not: '未登录过用户',login_today: '今天登录用户',all: '全部代理商'};return map[selectVal] || '未选择范围';}function getActionText(radiobutton) {var map={'1': '增加金额','2': '减少金额','3': '调整折扣','4': '状态冻结','5': '状态解冻','6': '删除账号','7': '删除N天未登录账号'};return map[radiobutton] || '未选择操作';}function updateIntvalTips(radiobutton) {var $intval=$('#intval');var $tip=$('.div_intval .layui-word-aux');if (radiobutton=='7') {$intval.attr('placeholder', '请输入天数(正整数)');$tip.text('删除N天未登录账号时，N必须为正整数');} else if (radiobutton=='3') {$intval.attr('placeholder', '请输入折扣值');$tip.text('例如输入 8 表示8折');} else {$intval.attr('placeholder', '请输入金额');$tip.text('金额必须大于0');}}function updateSummary() {var selectVal=$('select[name="select"]').val();var radiobutton=$('input[name="radiobutton"]:checked').val();var intval=$.trim($('#intval').val());var excludeAgent=$('input[name="checkbox"]').prop('checked');var summary='范围：' + getRangeText(selectVal) + '；对象：' + (excludeAgent ? '排除代理商' : '包含代理商') + '；操作：' + getActionText(radiobutton);if (needIntval(radiobutton) && intval !=='') {summary +='（N=' + intval + '）';}if (radiobutton=='6' || radiobutton=='7') {summary +='。该操作风险较高，请确认数据已备份。';}$('#op_summary').text(summary);}function syncAgentOptionByRange() {var selectVal=$('select[name="select"]').val();var $checkbox=$('input[name="checkbox"]');if (selectVal=='all') {$checkbox.prop('checked', false).attr('disabled', true);} else {$checkbox.attr('disabled', false);}form.render('checkbox');}form.on('radio(sex)', function () {var radiobutton=$('input[name="radiobutton"]:checked').val();if (needIntval(radiobutton)) {$(".div_intval").show();updateIntvalTips(radiobutton);} else {$(".div_intval").hide();}updateSummary();});$('select[name="select"]').on('change', function () {syncAgentOptionByRange();updateSummary();});$('input[name="checkbox"]').on('change', function () {updateSummary();});$('#intval').on('input', function () {updateSummary();});syncAgentOptionByRange();updateSummary();$('#setpost').on('click', function() {var radiobutton=$('input[name="radiobutton"]:checked').val();if (!radiobutton) {layer.alert('请选择要执行的操作类型');return false;}if (needIntval(radiobutton)) {var intval=$.trim($('#intval').val());if (intval==='') {layer.alert('请输入N值');return false;}if (isNaN(intval) || Number(intval) <=0) {layer.alert('N值必须大于0');return false;}if (radiobutton=='7' && !/^\d+$/.test(intval)) {layer.alert('删除天数必须为正整数');return false;}}var formData=$('#bsphppost').serialize();var $btn=$('#setpost');var confirmMsg='请先备份数据库，确认已备份后再执行批量操作。是否继续？';if (radiobutton=='6' || radiobutton=='7') {confirmMsg='高风险操作：删除类维护不可恢复。请确认数据库已备份。是否继续？';}layer.confirm(confirmMsg, {icon: 3,title: '操作确认'}, function(index) {layer.close(index);$btn.addClass('layui-btn-disabled').attr('disabled', true).text('执行中...');var loadingIdx=layer.load(1, {shade: 0.2});$.ajax({type: 'post',url: '',data: formData,dataType: 'json',success: function(ret) {var msg=(ret && ret.msg) ? ret.msg : '操作完成';layer.alert(msg);},error: function() {layer.alert('请求失败，请稍后重试');},complete: function() {layer.close(loadingIdx);$btn.removeClass('layui-btn-disabled').attr('disabled', false).text('<?php echo ��������������������������������������������������������������������������������('确认操作'); ?>');}});});return false;});});</script>
</body>
</html>