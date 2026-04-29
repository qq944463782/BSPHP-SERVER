<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?>- <?php echo Plug_Lang('现卡制作'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
<style>.card-type-select {width: 285px;}</style>
</head>
<body data="">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('余额购卡'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-elem-quote">
<?php echo Plug_Lang('选择卡类型和数量后即可快速制卡，系统会自动计算当前代理价格。'); ?>
</div>
<div class="layui-form" wid100 lay-filter="">
<form action="" onsubmit="return false;" name="bsphppost" id="bsphppost" method="post">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('卡串类型'); ?></label>
<div style="width: 385px;" class="layui-input-inline card-type-select">
<select name="select">
<option value="0"><?php echo Plug_Lang('请选择制作类型。。。'); ?></option>
<?php
$i=0;
$agent_card_rule=trim((string)$this->user_array['user_anget_carid']);
$agent_show_all_cards=($agent_card_rule==='' || $agent_card_rule==='*');
while ($var=Plug_Pdo_Fetch_Assoc($tmp)) {
if ($var['lei_for']==0) $var['lei_for']=1;
$jiage=$var['lei_daili'];
$uesr_zhe=$this->user_array['user_Zhe'];
$zheinfo=null;
if ($uesr_zhe > 0) {
$jiage=$var['lei_daili'] / 10 * $uesr_zhe;
}
$show_jiage=$jiage;
if ($agent_show_all_cards) {
echo  '<option value="' . $var['lei_id'] . '">' . $app_name[$var['lei_daihao']] . '>' . $var['lei_name'] . '  ,价格' . $jiage . Plug_Get_Configs_Value('sys', 'govicp') . '</option>';
} else {
if (strrpos('###,' . $agent_card_rule . ',', "," . $var['lei_id'] . ",")) {
echo  '<option value="' . $var['lei_id'] . '">' . $app_name[$var['lei_daihao']] . '>' . $var['lei_name'] . '  ,价格' . $jiage . Plug_Get_Configs_Value('sys', 'govicp') . '</option>';
}
}
$i++;
}
if ($i==0) {
echo  '<option value="0">没有可制作卡类，联系上级分配</option>';
}
?>
</select>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo Plug_Lang('制卡类型'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('制作数量'); ?></label>
<div class="layui-input-inline">
<input type="text" name="shu" id="shu" placeholder="输入数量如:1" value="1" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo Plug_Lang('需要制卡数量'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('制卡方式'); ?></label>
<div class="layui-input-block">
<input type="radio" name="make_mode" value="direct" title="<?php echo Plug_Lang('立即制作'); ?>" lay-filter="make_mode" checked>
<input type="radio" name="make_mode" value="stock" title="<?php echo Plug_Lang('存到库存卡'); ?>" lay-filter="make_mode">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo Plug_Lang('立即制作会直接出卡；存到库存卡用于后续库存制卡。'); ?> <a href="index.php?m=agent&c=kuka&a=kuka_add" ><?php echo Plug_Lang('查看库存卡'); ?></a></div>
</div>
<div class="layui-form-item" id="beizhu-item">
<label class="layui-form-label"><?php echo Plug_Lang('备注'); ?></label>
<div class="layui-input-inline">
<input type="text" name="beizhu" id="beizhu" placeholder="<?php echo Plug_Lang('自己可见'); ?>" value="" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('余额'); ?></label>
<div class="layui-form-mid layui-word-aux"><span class="layui-badge layui-bg-green"><?php echo $this->user_array['user_rmb']; ?> <?php echo Plug_Get_Configs_Value('sys', 'govicp'); ?></span></div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<input id="admin" type="hidden" name="appenconfig" value="1">
<button class="layui-btn layui-btn-normal" lay-submit lay-filter="set_website"><?php echo Plug_Lang('确认制卡'); ?></button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo Plug_Get_Url_Statics() ?>style/'}).extend({index: 'lib/index'}).use(['index', 'set', 'form', 'laydate'], function() {var laydate=layui.laydate;var form=layui.form;var $=layui.$;laydate.render({elem: '#date',type: 'datetime'});var toggleBeizhuByMode=function(mode) {if (mode==='stock') {$('#beizhu-item').hide();$('#beizhu').val('');} else {$('#beizhu-item').show();}};form.on('radio(make_mode)', function(data) {toggleBeizhuByMode(data.value);});toggleBeizhuByMode($('input[name="make_mode"]:checked').val());form.on('submit(set_website_2)', function(obj) {layer.load(1);var formData=$('#bsphppost').serialize();$.ajax({type: 'post',url: '',data: formData,success: function(ret) {layer.closeAll();if (ret.code==8) {layer.confirm(ret.msg, { btn: ['确定'] }, function() {window.location.href=ret.url;})} else if (ret.code==9) {layer.confirm(ret.msg, { btn: ['确定', '停留当前页面'] }, function() {window.location.href=ret.url;})} else {layer.alert(ret.msg);}}});return false;});});</script>
</body>
</html>
