<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?> - <?php echo Plug_Lang('用户卡密续费充值'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
<style>.pwd-wrap-hide { display: none; }</style>
</head>
<body>
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('充值'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="">
<form action="" name="bsphppost" id="bsphppost" method="post">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('充值帐户/卡号'); ?></label>
<div class="layui-input-inline" style="width:400px;">
<input type="text" name="user_user" id="user_user" placeholder="<?php echo Plug_Lang('输入充值目标帐户/卡号'); ?>" value="<?php echo htmlspecialchars($user_user); ?>" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('充值卡号'); ?></label>
<div class="layui-input-inline" style="width:400px;">
<input type="text" name="ka_name" id="ka_name" placeholder="<?php echo Plug_Lang('输入充值卡号'); ?>" value="<?php echo htmlspecialchars($ka_name); ?>" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux" id="card_check_tip"></div>
</div>
<div class="layui-form-item <?php echo ($ka_pwd !=='' ? '' : 'pwd-wrap-hide'); ?>" id="pwd_wrap">
<label class="layui-form-label"><?php echo Plug_Lang('充值卡密码'); ?></label>
<div class="layui-input-inline" style="width:400px;">
<input type="text" name="ka_pwd" id="ka_pwd" placeholder="<?php echo Plug_Lang('该卡需要密码时请输入'); ?>" value="<?php echo htmlspecialchars($ka_pwd); ?>" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<div class="layui-word-aux" id="submit_tip" style="font-size:14px;color:#FF5722;"><?php echo htmlspecialchars($log_name); ?></div>
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<button class="layui-btn layuiadmin-btn-useradmin layui-btn-normal" id="submit_btn" type="submit" name="Submitadd" value="1">
<?php echo Plug_Lang('确认充值'); ?>
</button>
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
<script>layui.config({base: '<?php echo Plug_Get_Url_Statics() ?>style/'}).extend({index: 'lib/index'}).use(['index', 'set'], function() {var form=document.getElementById('bsphppost');var userInput=document.getElementById('user_user');var kaNameInput=document.getElementById('ka_name');var kaPwdInput=document.getElementById('ka_pwd');var pwdWrap=document.getElementById('pwd_wrap');var tip=document.getElementById('card_check_tip');var submitTip=document.getElementById('submit_tip');var submitBtn=document.getElementById('submit_btn');var lastCardNo='';function setPwdVisible(visible) {if (visible) {pwdWrap.classList.remove('pwd-wrap-hide');} else {pwdWrap.classList.add('pwd-wrap-hide');kaPwdInput.value='';}}function checkCardPwdNeed() {var kaName=(kaNameInput.value || '').trim();if (kaName==='' || kaName===lastCardNo) return;lastCardNo=kaName;tip.innerHTML='<?php echo Plug_Lang('检测中...'); ?>';var xhr=new XMLHttpRequest();xhr.open('POST', 'index.php?m=agent&c=UserCardRenewRechargeFeature&a=checkcardpwd', true);xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');xhr.onreadystatechange=function() {if (xhr.readyState !==4) return;if (xhr.status !==200) {tip.innerHTML='<?php echo Plug_Lang('检测失败，请稍后重试'); ?>';return;}try {var res=JSON.parse(xhr.responseText);if (res && res.exists==1) {if (res.need_password==1) {setPwdVisible(true);tip.innerHTML='<?php echo Plug_Lang('该卡需要输入密码'); ?>';} else {setPwdVisible(false);tip.innerHTML='<?php echo Plug_Lang('该卡不需要密码'); ?>';}} else {setPwdVisible(false);tip.innerHTML=(res && res.msg) ? res.msg : '<?php echo Plug_Lang('卡号不存在'); ?>';}} catch (e) {tip.innerHTML='<?php echo Plug_Lang('检测失败，请稍后重试'); ?>';}};xhr.send('ka_name=' + encodeURIComponent(kaName));}kaNameInput.addEventListener('blur', checkCardPwdNeed);kaNameInput.addEventListener('change', checkCardPwdNeed);form.addEventListener('submit', function(e) {e.preventDefault();var userUser=(userInput.value || '').trim();var kaName=(kaNameInput.value || '').trim();var kaPwd=(kaPwdInput.value || '').trim();if (userUser==='') {submitTip.innerHTML='<?php echo Plug_Lang('充值帐户/卡号不能为空'); ?>';return;}if (kaName==='') {submitTip.innerHTML='<?php echo Plug_Lang('充值卡号不能为空'); ?>';return;}submitBtn.disabled=true;submitTip.innerHTML='<?php echo Plug_Lang('提交中...'); ?>';var xhr=new XMLHttpRequest();xhr.open('POST', 'index.php?m=agent&c=UserCardRenewRechargeFeature&a=table', true);xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');xhr.onreadystatechange=function() {if (xhr.readyState !==4) return;submitBtn.disabled=false;if (xhr.status !==200) {submitTip.innerHTML='<?php echo Plug_Lang('提交失败，请稍后重试'); ?>';return;}try {var res=JSON.parse(xhr.responseText);submitTip.innerHTML=(res && res.msg) ? res.msg : '<?php echo Plug_Lang('提交失败，请稍后重试'); ?>';} catch (err) {submitTip.innerHTML='<?php echo Plug_Lang('提交失败，请稍后重试'); ?>';}};xhr.send('Submitadd=1'+ '&ajax_submit=1'+ '&user_user=' + encodeURIComponent(userUser)+ '&ka_name=' + encodeURIComponent(kaName)+ '&ka_pwd=' + encodeURIComponent(kaPwd));});if ((kaNameInput.value || '').trim() !=='') {checkCardPwdNeed();}});</script>
</body>
</html>
