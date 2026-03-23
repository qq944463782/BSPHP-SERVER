<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), ����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('充值卡批量维护'); ?>  Bsphp-Pro</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
</head>
<body data="BSPHP-PRO 2022本系统受国家版权局保护请勿破解或者二次开发传播">
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
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('没有N操作选项可以忽略该值'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('注意'); ?></label>
<div class="layui-input-inline" style="width: auto;">
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('在批量操作数据库时请先备份相关数据库,数据无价。'); ?></div>
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
<div id="foot">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Pro <?php echo BSPHP_VERSION; ?></a> Bsphp.com <br>
All Rights Reserved </div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>bsphp_report_quickstat('<?php echo ��������������������������������������������������������������������������������("充值卡批量维护"); ?>');layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['index', 'set', 'jquery', 'table', 'form', 'layer'], function() {var $=layui.$,form=layui.form,layer=layui.layer;layer.alert('批量操作请先备份数据库，数据无价。谨慎使用！');var radiobutton=$('#leixin:checked').val();;if (radiobutton==1) {$(".top_list").show();$(".down_list").hide();} else {$(".top_list").hide();$(".down_list").show();}form.on('radio(type)', function(data) {var radiobutton=$('#leixin:checked').val();;if (radiobutton==1) {$(".top_list").show();$(".down_list").hide();} else {$(".top_list").hide();$(".down_list").show();}});form.on('select(leiall)', function(data) {console.log(data);if (data.value > 5) {$(".div_bool").show();} else {$(".div_bool").hide();}});form.on('radio(sex)', function(data) {var radiobutton=data.value;if (radiobutton==5 || radiobutton==6 || radiobutton==7 || radiobutton==8) {$(".div_intval").show();} else {$(".div_intval").hide();}});$('#setpost').on('click', function() {var radiobutton=$('#radiobutton:checked').val();if (radiobutton==5 || radiobutton==6 || radiobutton==7 || radiobutton==8) {if ($('#int').val()=='' | $('#int').val()==0) {layer.alert('请输入N值');return false;}}var formData=$('#bsphppost').serialize();$.ajax({type: 'post',url: '',data: formData,success: function(ret) {layer.alert(ret.msg);}});return false;});});</script>
</body>
</html>