<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), ����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('应用账号批量维护'); ?>  Bsphp-Rsa</title>
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
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('应用账号批量维护'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="" name="bsphppost" id="bsphppost" method="post">
<div class="layui-form-item">
<label class="layui-form-label"><span class="layui-badge layui-bg-blue"><?php echo ��������������������������������������������������������������������������������('A.ID批量处理'); ?></span></label>
<div class="layui-input-inline" style="width: 200px;">
<input name="lei_x" id="leixin" lay-filter="type" type="radio" title="<?php echo ��������������������������������������������������������������������������������('通过索引ID维护'); ?>" onClick="SETradio();" value="1" <?PHP if ($while（������������������������������������������������������������������������ !=NULL) echo 'checked' ?>>
</div>
<div class="layui-form-mid layui-word-aux"></div>
</div>
<div class="top_list">
<div class="layui-form-item">
<label class="layui-form-label">ID：</label>
<div class="layui-input-inline" style="width: 200px;">
<input name="text_id" type="text" class="layui-input" placeholder="1,2,3" id="text_id" value="<?php echo $while（������������������������������������������������������������������������ ?>">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('要维护的索引ID'); ?></div>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><span class="layui-badge layui-bg-blue"><?php echo ��������������������������������������������������������������������������������('B.筛选选处理'); ?></span></label>
<div class="layui-input-inline" style="width: 200px;">
<input name="lei_x" id="leixin" lay-filter="type" type="radio" title="<?php echo ��������������������������������������������������������������������������������('通过范围选择维护'); ?>" onClick="SETradio();" value="2" <?PHP if ($while（������������������������������������������������������������������������==NULL) echo 'checked' ?>>
</div>
<div class="layui-form-mid layui-word-aux"></div>
</div>
<div class="down_list">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('选择软件'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<select name="appall" id="appall">
<option value=""><?php echo ��������������������������������������������������������������������������������('请选择软件'); ?></option>
<option value="all"><?php echo ��������������������������������������������������������������������������������('全部软件 (慎重)'); ?></option>
<?php
while ($��������������������������������������������������������������������������������=Plug_Pdo_Fetch_Assoc($��������������������������������������������������������������������������������)) {
echo '<option value="' . $��������������������������������������������������������������������������������['app_daihao'] . '" >' . $��������������������������������������������������������������������������������['app_name'] . '</option>';
}
?>
</select>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('选择要维护的软件'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('维护范围'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<select name="leiall"  lay-filter="leiall" class="select" onclick="SETradio();" id="leiall">
<option value="1"><?php echo ��������������������������������������������������������������������������������('全部用户'); ?></option>
<option value="2"><?php echo ��������������������������������������������������������������������������������('没到期用 (时间模式判断)'); ?></option>
<option value="3"><?php echo ��������������������������������������������������������������������������������('已经到期 (时间模式判断)'); ?></option>
<option value="4"><?php echo ��������������������������������������������������������������������������������('X天前到期用户*'); ?></option>
<option value="5"><?php echo ��������������������������������������������������������������������������������('用户UID[逻辑]'); ?></option>
<option value="6"><?php echo ��������������������������������������������������������������������������������('绑定特征[逻辑]'); ?></option>
<option value="7"><?php echo ��������������������������������������������������������������������������������('到期时间[逻辑] (时间(戳)/点)'); ?></option>
<option value="8"><?php echo ��������������������������������������������������������������������������������('添加时间[逻辑]'); ?></option>
</select>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('维护类型选择'); ?></div>
</div>
<div style="display: none;" class="layui-form-item div_bool">
<label class="layui-form-label"><span class="layui-badge layui-bg-orange"><?php echo ��������������������������������������������������������������������������������('[逻辑]表达'); ?></span></label>
<div class="layui-input-inline" style="width: 200px;">
<select name="select">
<option value="0"><?php echo ��������������������������������������������������������������������������������('等于内容='); ?></option>
<option value="1"><?php echo ��������������������������������������������������������������������������������('大于内容&gt;'); ?></option>
<option value="2"><?php echo ��������������������������������������������������������������������������������('小于内容&lt;'); ?></option>
<option value="3"><?php echo ��������������������������������������������������������������������������������('不等于内容!='); ?></option>
</select>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('选择范围没有[逻辑]忽略维护类型表达！'); ?></div>
</div>
<div style="display: none;" class="layui-form-item div_bool">
<label class="layui-form-label"><span class="layui-badge layui-bg-orange"><?php echo ��������������������������������������������������������������������������������('[逻辑]值输入'); ?></span></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="leiall_test" id="leiall_test" placeholder="<?php echo ��������������������������������������������������������������������������������('*值'); ?>" value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('维护范围如果没有[逻辑]值忽略'); ?></div>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><span class="layui-badge"><?php echo ��������������������������������������������������������������������������������('选择维护功能'); ?><span></label>
<div class="layui-input-inline" style="width: aout;">
<input lay-filter="sex" type="radio" title="<?php echo ��������������������������������������������������������������������������������('添加时间N(秒/点)'); ?>" name="radiobutton" value="1">
<input lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('减少时间N(秒/点)'); ?>" type="radio" name="radiobutton" value="2">
<input lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('冻结账号'); ?>" type="radio" name="radiobutton" value="7">
<input lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('解除冻结'); ?>" type="radio" name="radiobutton" value="8">
<input lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('到期时间N(点/时间戳)'); ?>" type="radio" name="radiobutton" value="4">
<input lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('绑定特征N'); ?>" type="radio" name="radiobutton" value="5">
<input lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('删除(谨慎操作)'); ?>" type="radio" name="radiobutton" value="6">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('选择要执行的结果功能'); ?></div>
</div>
<div style="display: none;" class="layui-form-item div_intval">
<label class="layui-form-label"><span class="layui-badge layui-bg-orange"><?php echo ��������������������������������������������������������������������������������('N值输入'); ?></span></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="int" id="int" placeholder="<?php echo ��������������������������������������������������������������������������������('N值'); ?>" value="" class="layui-input">
</div>
<div class="layui-input-inline" style="width: auto;">
<button type="button" class="layui-btn layui-btn-primary layui-btn-sm" id="btn_time_to_unix">时间转时间戳</button>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('没有N操作选项可以忽略该值'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('注意'); ?></label>
<div class="layui-input-inline" style="width: auto;">
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('在批量操作数据库时请先备份相关数据库,数据无价。'); ?></div>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('操作摘要'); ?></label>
<div class="layui-input-inline" style="width: auto;">
<div class="layui-form-mid layui-word-aux" id="op_summary">请先选择处理方式与维护功能</div>
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
<script>bsphp_report_quickstat('<?php echo ��������������������������������������������������������������������������������("应用账号批量维护"); ?>');layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['index', 'set', 'jquery', 'table', 'form', 'layer', 'laydate'], function() {var $=layui.$,form=layui.form,layer=layui.layer,laydate=layui.laydate;layer.alert('批量操作请先备份数据库，数据无价。谨慎使用！');function isIdMode() {return $('input[name="lei_x"]:checked').val()=='1';}function needNValue(radioVal) {return radioVal=='1' || radioVal=='2' || radioVal=='4' || radioVal=='5';}function getActionText(radioVal) {var map={'1': '添加时间N(秒/点)','2': '减少时间N(秒/点)','4': '到期时间N(点/时间戳)','5': '绑定特征N','6': '删除','7': '冻结账号','8': '解除冻结'};return map[radioVal] || '未选择维护功能';}function updateModeUI() {if (isIdMode()) {$(".top_list").show();$(".down_list").hide();} else {$(".top_list").hide();$(".down_list").show();}}function updateSummary() {var modeText=isIdMode() ? '通过索引ID维护' : '通过范围筛选维护';var actionVal=$('input[name="radiobutton"]:checked').val();var summary='模式：' + modeText + '；功能：' + getActionText(actionVal);if (isIdMode()) {summary +='；ID：' + ($.trim($('#text_id').val()) || '未填写');} else {summary +='；软件：' + ($('#appall option:selected').text() || '未选择');summary +='；范围：' + ($('#leiall option:selected').text() || '未选择');}if (needNValue(actionVal) && $.trim($('#int').val()) !=='') {summary +='；N=' + $.trim($('#int').val());}if (actionVal=='6') {summary +='。该操作风险较高，请确认已备份数据库。';}$('#op_summary').text(summary);}function openTimeToUnixTool(targetSelector) {var randomId='time_picker_' + (new Date().getTime());var content=['<div style="padding:15px;">','<div class="layui-form-item">','<label class="layui-form-label" style="width:90px;">选择时间</label>','<div class="layui-input-inline" style="width:220px;">','<input type="text" id="' + randomId + '" class="layui-input" placeholder="YYYY-MM-DD HH:mm:ss">','</div>','</div>','<div class="layui-form-item" style="margin-bottom:0;">','<label class="layui-form-label" style="width:90px;">时间戳</label>','<div class="layui-input-inline" style="width:220px;">','<input type="text" id="' + randomId + '_unix" class="layui-input" readonly>','</div>','</div>','</div>'].join('');layer.open({type: 1,title: '时间转时间戳工具',area: ['420px', '220px'],content: content,btn: ['使用该时间戳', '取消'],success: function() {laydate.render({elem: '#' + randomId,type: 'datetime',trigger: 'click',done: function(value) {if (!value) return;var unix=Math.floor(new Date(value.replace(/-/g, '/')).getTime() / 1000);$('#' + randomId + '_unix').val(unix);}});},yes: function(index) {var unixVal=$.trim($('#' + randomId + '_unix').val());if (!unixVal) {layer.msg('请先选择时间');return;}$(targetSelector).val(unixVal);updateSummary();layer.close(index);}});}updateModeUI();updateSummary();form.on('select(leiall)', function(data) {if (data.value > 3) {$(".div_bool").show();} else {$(".div_bool").hide();}if (data.value=='7') {openTimeToUnixTool('#leiall_test');}updateSummary();});form.on('select(appall)', function() {updateSummary();});form.on('radio(sex)', function(data) {if (needNValue(data.value)) {$(".div_intval").show();} else {$(".div_intval").hide();}if (data.value=='4') {openTimeToUnixTool('#int');}updateSummary();});form.on('radio(type)', function() {updateModeUI();updateSummary();});$('#text_id,#int,#leiall_test').on('input', function() {updateSummary();});$('#btn_time_to_unix').on('click', function() {openTimeToUnixTool('#int');});$('#setpost').on('click', function() {var actionVal=$('input[name="radiobutton"]:checked').val();if (!actionVal) {layer.alert('请选择维护功能');return false;}if (isIdMode() && $.trim($('#text_id').val())==='') {layer.alert('请输入要维护的索引ID');return false;}if (!isIdMode() && $.trim($('#appall').val())==='') {layer.alert('请选择要维护的软件');return false;}if (needNValue(actionVal)) {var intval=$.trim($('#int').val());if (intval==='' || Number(intval)===0 || isNaN(intval)) {layer.alert('请输入有效N值');return false;}}var formData=$('#bsphppost').serialize();var $btn=$('#setpost');var confirmMsg='请先备份数据库，确认已备份后再执行批量操作。是否继续？';if (actionVal=='6') {confirmMsg='高风险操作：删除不可恢复。请确认数据库已备份。是否继续？';}layer.confirm(confirmMsg, {icon: 3,title: '操作确认'}, function(index) {layer.close(index);$btn.addClass('layui-btn-disabled').attr('disabled', true).text('执行中...');var loadingIdx=layer.load(1, {shade: 0.2});$.ajax({type: 'post',url: '',data: formData,dataType: 'json',success: function(ret) {var msg=(ret && ret.msg) ? ret.msg : '操作完成';layer.alert(msg);},error: function() {layer.alert('请求失败，请稍后重试');},complete: function() {layer.close(loadingIdx);$btn.removeClass('layui-btn-disabled').attr('disabled', false).text('<?php echo ��������������������������������������������������������������������������������('确认操作'); ?>');}});});return false;});});</script>
</body>
</html>