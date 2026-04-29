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
<style>.recharge-panel { max-width: 920px; margin: 0 auto; }.recharge-desc { margin-bottom: 16px; color: #666; font-size: 13px; }.pay-methods { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }.pay-methods .pay-method-card { display: inline-flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1px solid #e6e8eb; border-radius: 8px; background: #fff; cursor: pointer; transition: all 0.2s ease; }.pay-methods .pay-method-card:hover { border-color: #16b777; box-shadow: 0 2px 10px rgba(22, 183, 119, 0.12); }.pay-method-radio { position: absolute; opacity: 0; pointer-events: none; }.pay-method-logo-wrap { display: inline-flex; align-items: center; justify-content: center; width: 104px; height: 54px; border-radius: 6px; }.pay-method-logo { width: 100px; height: 50px; object-fit: contain; }.pay-method-name { color: #333; font-size: 14px; font-weight: 600; white-space: nowrap; }.pay-method-card.active { border-color: #16b777; background: #f3fcf8; box-shadow: 0 3px 14px rgba(22, 183, 119, 0.16); }.pay-method-radio:checked + .pay-method-logo-wrap { background: #ecf9f3; box-shadow: inset 0 0 0 1px #16b777; }.pay-method-radio:checked + .pay-method-logo-wrap + .pay-method-name { color: #16b777; }.recharge-form-row { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; }.amount-label { color: #333; font-weight: 600; }.amount-input { width: 140px; }.amount-unit { color: #666; }</style>
</head>
<body data="">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('余额充值(只有您自己见,您下级代理无法使用与已经隐藏)'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="index.php?m=payment&c=Confirmthepayment" method="post" name="form1" target="_blank" id="form1">
<div class="recharge-panel">
<div class="recharge-desc"><?php echo Plug_Lang('请选择充值通道并输入充值金额。'); ?></div>
<div class="pay-methods"><?php echo $html; ?></div>
<div class="recharge-form-row">
<span class="amount-label"><?php echo Plug_Lang('金额:'); ?></span>
<input name="pay_amount" type="text" class="layui-input amount-input" id="pay_amount" value="10" />
<span class="amount-unit"><?php echo Plug_Get_Configs_Value('sys', 'govicp'); ?></span>
<input type="submit" name="Submit_pay" id="Submit_pay" class="layui-btn layui-btn-normal" value="<?php echo Plug_Lang('立即充值'); ?>" />
<input name="pay_user" type="hidden" id="pay_user" value="<?php echo $this->user_array['user_user']; ?>" />
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
<script>layui.config({ base: '<?php echo Plug_Get_Url_Statics() ?>style/' }).extend({ index: 'lib/index' }).use(['index', 'set', 'laydate'], function() {var laydate=layui.laydate;laydate.render({ elem: '#date', type: 'datetime' });var cards=document.querySelectorAll('.pay-method-card');var radios=document.querySelectorAll('.pay-method-radio');var updatePayCardState=function() {for (var i=0; i < cards.length; i++) {var radio=cards[i].querySelector('.pay-method-radio');if (radio && radio.checked) cards[i].classList.add('active'); else cards[i].classList.remove('active');}};for (var i=0; i < radios.length; i++) radios[i].addEventListener('change', updatePayCardState);updatePayCardState();});</script>
</body>
</html>
