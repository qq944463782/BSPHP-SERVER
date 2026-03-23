<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), ����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('帐号批量维护'); ?>  Bsphp-Pro</title>
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
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('登录账号'); ?></div>
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
<div id="foot">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Pro <?php echo BSPHP_VERSION; ?></a> Bsphp.com <br>
All Rights Reserved </div>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/'}).extend({index: 'lib/index'}).use(['index', 'set', 'jquery', 'table','form', 'layer'], function() {var $=layui.$,form=layui.form,layer=layui.layer;form.on('radio(sex)', function (data) {var radiobutton=$('.radiobutton:checked').val();if (radiobutton==1 || radiobutton==2 || radiobutton==3 || radiobutton==7) {$(".div_intval").show();} else {$(".div_intval").hide();}});$('#setpost').on('click', function() {var radiobutton=$('#radiobutton:checked').val();if (radiobutton==1 || radiobutton==2 || radiobutton==3 || radiobutton==7) {if ($('#intval').val()=='' | $('#intval').val()==0) {layer.alert('请输入N值');return false;}} else {}var formData=$('#bsphppost').serialize();$.ajax({type: 'post',url: '',data: formData,success: function(ret) {layer.alert(ret.msg);}});return false;});});</script>
</body>
</html>