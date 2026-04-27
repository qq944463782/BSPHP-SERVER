<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), ����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('充值卡批量维护'); ?>  Bsphp-Rsa</title>
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
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('充值卡批量维护'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="" name="bsphppost" id="bsphppost" method="post">
<div class="layui-form-item">
<label class="layui-form-label"><span class="layui-badge layui-bg-blue"><?php echo ��������������������������������������������������������������������������������('A.ID批量处理');?></span></label>
<div class="layui-input-inline" style="width: 200px;">
<input name="lei_x" id="leixin" lay-filter="type" type="radio" title="<?php echo ��������������������������������������������������������������������������������('通过索引ID维护');?>" onClick="SETradio();" value="1" <?PHP if ($while（������������������������������������������������������������������������ !=NULL) echo 'checked' ?>>
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
<label class="layui-form-label"><span class="layui-badge layui-bg-blue"><?php echo ��������������������������������������������������������������������������������('B.筛选选处理');?></span></label>
<div class="layui-input-inline" style="width: 200px;">
<input name="lei_x" id="leixin" lay-filter="type" type="radio" title="<?php echo ��������������������������������������������������������������������������������('通过范围选择维护');?>" onClick="SETradio();" value="2" <?PHP if ($while（������������������������������������������������������������������������==NULL) echo 'checked' ?>>
</div>
<div class="layui-form-mid layui-word-aux"></div>
</div>
<div class="down_list">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('选择软件'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<select name="appall" id="appall">
<option value="all"><?php echo ��������������������������������������������������������������������������������('全部软件'); ?></option>
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
<select name="leiall" class="select" onclick="SETradio();" lay-filter="leiall" id="leiall">
<option value="1"><?php echo ��������������������������������������������������������������������������������('全部卡串'); ?></option>
<option value="2"><?php echo ��������������������������������������������������������������������������������('状态冻结'); ?></option>
<option value="3"><?php echo ��������������������������������������������������������������������������������('状态正常'); ?></option>
<option value="4"><?php echo ��������������������������������������������������������������������������������('未使用'); ?></option>
<option value="5"><?php echo ��������������������������������������������������������������������������������('已使用'); ?></option>
<option value="6"><?php echo ��������������������������������������������������������������������������������('卡类型ID[逻辑]'); ?></option>
<option value="7"><?php echo ��������������������������������������������������������������������������������('充值时间[逻辑]'); ?></option>
<option value="8"><?php echo ��������������������������������������������������������������������������������('销售价格[逻辑]'); ?></option>
<option value="9"><?php echo ��������������������������������������������������������������������������������('代理价格[逻辑]'); ?></option>
<option value="10"><?php echo ��������������������������������������������������������������������������������('制卡人员[逻辑]'); ?></option>
<option value="11"><?php echo ��������������������������������������������������������������������������������('制作时间[逻辑]'); ?></option>
<option value="12"><?php echo ��������������������������������������������������������������������������������('冲卡用户[逻辑]'); ?></option>
</select>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('维护类型选择'); ?></div>
</div>
<div style="display:none;" class="layui-form-item div_bool">
<label class="layui-form-label"><span class="layui-badge layui-bg-orange"><?php echo ��������������������������������������������������������������������������������('[逻辑]表达') ?></span></label>
<div class="layui-input-inline" style="width: 200px;">
<select name="select">
<option value="0"><?php echo ��������������������������������������������������������������������������������('等于内容='); ?></option>
<option value="1"><?php echo ��������������������������������������������������������������������������������('大于内容&gt;'); ?></option>
<option value="2"><?php echo ��������������������������������������������������������������������������������('小于内容&lt;'); ?></option>
<option value="3"><?php echo ��������������������������������������������������������������������������������('不等于内容!=');?></option>
</select>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('选择范围没有[逻辑]忽略维护类型表达！');?></div>
</div>
<div style="display:none;" class="layui-form-item div_bool">
<label class="layui-form-label"><span class="layui-badge layui-bg-orange"><?php echo ��������������������������������������������������������������������������������('[逻辑]值输入');?></span></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="leiall_test" id="leiall_test" placeholder="*<?php echo ��������������������������������������������������������������������������������('值');?>" value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('维护范围如果没有[逻辑]值忽略'); ?></div>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><span class="layui-badge"><?php echo ��������������������������������������������������������������������������������('选择维护功能'); ?><span></label>
<div class="layui-input-inline" style="width: aout;">
<input type="radio" lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('设置未使用'); ?>" name="radiobutton" value="1">
<input type="radio" lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('设置已使用'); ?>" name="radiobutton" value="2">
<input type="radio" lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('设置冻结'); ?>" name="radiobutton" value="3">
<input type="radio" lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('设置正常'); ?>" name="radiobutton" value="4">
<input type="radio" lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('设置充值天数为N (如:1)'); ?>" name="radiobutton" value="5">
<input type="radio" lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('设置销售价格为N (如:68)'); ?>" name="radiobutton" value="6">
<input type="radio" lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('设置代理价格为N (如:68)'); ?>" name="radiobutton" value="7">
<input type="radio" lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('设置制卡时间为N (如:2022-01-30 23:23:00)'); ?>" name="radiobutton" value="8">
<input type="radio" lay-filter="sex" title="<?php echo ��������������������������������������������������������������������������������('删除卡串(谨慎操作)'); ?>" name="radiobutton" value="9">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('选择要执行的结果功能'); ?></div>
</div>
<div style="display: none;" class="layui-form-item div_intval">
<label class="layui-form-label"><span class="layui-badge layui-bg-orange"><?php echo ��������������������������������������������������������������������������������('N值输入'); ?></span></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="int" id="int" placeholder="<?php echo ��������������������������������������������������������������������������������('N值'); ?>" value="" class="layui-input">
</div>
<div class="layui-input-inline" style="width: auto;">
<button type="button" class="layui-btn layui-btn-primary layui-btn-sm" id="btn_datetime_fill">时间辅助</button>
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
<style>.layui-form-radio {width: 400px;}.layui-form-radio div {width: 300px;}</style>
<div id="foot">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Rsa <?php echo BSPHP_VERSION; ?></a> Bsphp.com <br>
All Rights Reserved </div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>bsphp_report_quickstat('<?php echo ��������������������������������������������������������������������������������("充值卡批量维护"); ?>');layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['index', 'set', 'jquery', 'table', 'form', 'layer', 'laydate'], function() {var $=layui.$,form=layui.form,layer=layui.layer,laydate=layui.laydate;layer.alert('批量操作请先备份数据库，数据无价。谨慎使用！');function isIdMode() {return $('input[name="lei_x"]:checked').val()=='1';}function needNValue(actionVal) {return actionVal=='5' || actionVal=='6' || actionVal=='7' || actionVal=='8';}function updateModeUI() {if (isIdMode()) {$(".top_list").show();$(".down_list").hide();} else {$(".top_list").hide();$(".down_list").show();}}function updateNInputTips(actionVal) {var $tip=$('.div_intval .layui-word-aux');var $btn=$('#btn_datetime_fill');if (actionVal=='5') {$('#int').attr('placeholder', '请输入充值天数(整数)');$tip.text('示例: 1 表示 1 天');$btn.hide();} else if (actionVal=='6') {$('#int').attr('placeholder', '请输入销售价格');$tip.text('示例: 68');$btn.hide();} else if (actionVal=='7') {$('#int').attr('placeholder', '请输入代理价格');$tip.text('示例: 68');$btn.hide();} else if (actionVal=='8') {$('#int').attr('placeholder', '请输入制卡时间(YYYY-MM-DD HH:mm:ss)');$tip.text('可点击右侧“时间辅助”快速填入');$btn.show();} else {$btn.hide();}}function getActionText(actionVal) {var map={'1': '设置未使用','2': '设置已使用','3': '设置冻结','4': '设置正常','5': '设置充值天数为N','6': '设置销售价格为N','7': '设置代理价格为N','8': '设置制卡时间为N','9': '删除卡串'};return map[actionVal] || '未选择维护功能';}function updateSummary() {var modeText=isIdMode() ? '通过索引ID维护' : '通过范围筛选维护';var actionVal=$('input[name="radiobutton"]:checked').val();var summary='模式：' + modeText + '；功能：' + getActionText(actionVal);if (isIdMode()) {summary +='；ID：' + ($.trim($('#text_id').val()) || '未填写');} else {summary +='；软件：' + ($('#appall option:selected').text() || '未选择');summary +='；范围：' + ($('#leiall option:selected').text() || '未选择');if ($('#leiall').val() > 5) {summary +='；逻辑值：' + ($.trim($('#leiall_test').val()) || '未填写');}}if (needNValue(actionVal) && $.trim($('#int').val()) !=='') {summary +='；N=' + $.trim($('#int').val());}if (actionVal=='9') {summary +='。该操作风险较高，请确认已备份数据库。';}$('#op_summary').text(summary);}function openDateTimeTool(targetSelector) {var inputId='dt_tool_' + (new Date().getTime());var content=['<div style="padding:15px;">','<div class="layui-form-item">','<label class="layui-form-label" style="width:90px;">选择时间</label>','<div class="layui-input-inline" style="width:220px;">','<input type="text" id="' + inputId + '" class="layui-input" placeholder="YYYY-MM-DD HH:mm:ss">','</div>','</div>','</div>'].join('');layer.open({type: 1,title: '时间选择工具',area: ['400px', '170px'],content: content,btn: ['使用该时间', '取消'],success: function() {laydate.render({elem: '#' + inputId,type: 'datetime',trigger: 'click'});},yes: function(index) {var val=$.trim($('#' + inputId).val());if (!val) {layer.msg('请先选择时间');return;}$(targetSelector).val(val);updateSummary();layer.close(index);}});}updateModeUI();updateSummary();form.on('radio(type)', function() {updateModeUI();updateSummary();});form.on('select(leiall)', function(data) {if (data.value > 5) {$(".div_bool").show();if (data.value=='7' || data.value=='11') {openDateTimeTool('#leiall_test');}} else {$(".div_bool").hide();}updateSummary();});form.on('select(appall)', function() {updateSummary();});form.on('radio(sex)', function(data) {if (needNValue(data.value)) {$(".div_intval").show();updateNInputTips(data.value);if (data.value=='8') {openDateTimeTool('#int');}} else {$(".div_intval").hide();}updateSummary();});$('#btn_datetime_fill').on('click', function() {openDateTimeTool('#int');});$('#text_id,#leiall_test,#int').on('input', function() {updateSummary();});$('#setpost').on('click', function() {var actionVal=$('input[name="radiobutton"]:checked').val();if (!actionVal) {layer.alert('请选择维护功能');return false;}if (isIdMode() && $.trim($('#text_id').val())==='') {layer.alert('请输入要维护的索引ID');return false;}if (needNValue(actionVal)) {var intval=$.trim($('#int').val());if (intval==='') {layer.alert('请输入N值');return false;}if (actionVal=='5' && (!/^\d+$/.test(intval) || Number(intval) <=0)) {layer.alert('充值天数必须为正整数');return false;}if ((actionVal=='6' || actionVal=='7') && (isNaN(intval) || Number(intval) <=0)) {layer.alert('价格必须大于0');return false;}}var formData=$('#bsphppost').serialize();var $btn=$('#setpost');var confirmMsg='请先备份数据库，确认已备份后再执行批量操作。是否继续？';if (actionVal=='9') {confirmMsg='高风险操作：删除卡串不可恢复。请确认数据库已备份。是否继续？';}layer.confirm(confirmMsg, {icon: 3,title: '操作确认'}, function(index) {layer.close(index);$btn.addClass('layui-btn-disabled').attr('disabled', true).text('执行中...');var loadingIdx=layer.load(1, {shade: 0.2});$.ajax({type: 'post',url: '',data: formData,dataType: 'json',success: function(ret) {var msg=(ret && ret.msg) ? ret.msg : '操作完成';layer.alert(msg);},error: function() {layer.alert('请求失败，请稍后重试');},complete: function() {layer.close(loadingIdx);$btn.removeClass('layui-btn-disabled').attr('disabled', false).text('<?php echo ��������������������������������������������������������������������������������('确认操作'); ?>');}});});return false;});});</script>
</body>
</html>