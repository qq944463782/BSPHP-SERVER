<?php
#BSPHP2009
require_once ('../Plug.php');
if (!function_exists('����������������������������������������������������������������������������')) {
function ����������������������������������������������������������������������������($md7)
{
return md5(Plug_Get_Configs_Value("sys", "pass_key") . $md7 .
Plug_Get_Configs_Value("sys", "pass_key"));
}
}
$��������������������������������������������������������������������=Plug_Set_Get('uid');
$md5_get=Plug_Set_Get('md5');
$sgin_get=Plug_Set_Get('sgin');
$unix_get=Plug_Set_Get('unix');
$name=Plug_Get_Configs_Value("sys","name");
$cookie_pre=Plug_Get_Configs_Value(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), 'cookie_pre');
$name=Plug_Get_Configs_Value(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), 'name');
$����������������������������������������������������������������������������=time();
$sgin=md5($md5_get . $�������������������������������������������������������������������� . $cookie_pre . 'bsphp' . $unix_get);
if ($sgin_get !==$sgin)
{
mailShowMsg('重置密码验证失败', '签名错误!', '');
}
if ($unix_get > (time() + 600))
{
mailShowMsg('重置密码验证失败', '连接超时,请重新找回密码!', '');
}
$sql="SELECT`user_uid`,`user_user`,`user_pwd`,`user_IsLock`,`user_LoGinNum`,`user_Login_ip`,`user_Login_date`,`user_daili`,`user_email`FROM`bs_php_user`WHERE`user_uid`='{$��������������������������������������������������������������������}'; ";
$arr=Plug_Query_Array($sql);
if (!$arr)
{
mailShowMsg('重置密码验证失败', '连接参数错误!', '');
}
$����������������������������������������������������������������������������=time();
$md5=md5($arr['user_LoGinNum'] . $arr['user_pwd'] . $arr['user_uid'] . $�������������������������������������������������������������������� . $cookie_pre . date('Ymd', $����������������������������������������������������������������������������));
if ($md5_get !==$md5)
{
mailShowMsg('重置密码验证失败', '签名错误,或者已经失效!', '');
} else
{
$pwds1=Plug_Set_Post('pwds1');
$pwds2=Plug_Set_Post('pwds2');
if ($pwds1 !=='' and $pwds2 !=='')
{
if ($pwds1==$pwds2 && $pwds1 !=='')
{
$md6=����������������������������������������������������������������������������($pwds1);
$sql="UPDATE `bs_php_user` SET  `user_LoGinNum`=`user_LoGinNum` + '1',  `user_pwd`='{$md6}' WHERE  `user_uid`={$arr['user_uid']};";
Plug_Query($sql);
mailShowMsg('重置密码成功', '尊敬用户:' . $arr['user_user'] . '您密码已经重置成功,当前页面可以关闭了!', '');
} else
{
mailShowMsg('重置密码验证失败', '密码格式错误!.', '');
}
}
}
function mailShowMsg($table, $text)
{
@header('Content-Type: text/html; charset=utf-8');
echo '<title>' . $table . '</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div style=" font-size: 4vw;border: 1px dashed #00CC00;font-family:Tahoma;background-color:#CCFFCC;width:98%;padding:10px;color:#CC6600;"><strong>' . $table . '<BR/></strong><br>' . $text . '</div>';
exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php
echo $name
?> - 找回重置密码</title>
<meta name="renderer" content="webkit">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="//cache.bsphp.com/pro-statics/default/agent/style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="//cache.bsphp.com/pro-statics/default/agent/style/style/admin.css" media="all">
<link rel="stylesheet" href="//cache.bsphp.com/pro-statics/default/agent/style/style/login.css" media="all">
</head>
<body>
<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" >
<div class="layadmin-user-login-main">
<div class="layadmin-user-login-box layadmin-user-login-header">
<h2><?php
echo $name
?> - 找回重置密码</h2>
<p></p>
</div>
<form id="form1" name="form1" method="post" action="">
<div class="layadmin-user-login-box layadmin-user-login-body layui-form">
<div class="layui-form-item">
<label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
<input type="text"  id="LAY-user-login-username"  value="<?php
echo $arr['user_user'];
?>"  disabled placeholder="用户名" class="layui-input">
</div>
<div class="layui-form-item">
<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
<input type="password" name="pwds1" id="pwds1" lay-verify="required" placeholder="密码" class="layui-input">
</div>
<div class="layui-form-item">
<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
<input type="password" name="pwds2" id="pwds2" lay-verify="required" placeholder="密码确认密码" class="layui-input">
</div>
<div class="layui-form-item">
<button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-login-submit">确认修改密码</button>
</div>
</div>
</div>
</form>
</div>
<script src="//cache.bsphp.com/pro-statics/default/agent/style/layui/bsphp.js"></script>
<script>layui.config({base: '//cache.bsphp.com/pro-statics/default/agent/style/'}).extend({index: 'lib/index'}).use(['index', 'user'], function(){var $=layui.$,setter=layui.setter,admin=layui.admin,form=layui.form,router=layui.router(),search=router.search;form.render();form.on('submit(LAY-user-login-submit)', function(obj){if($('#pwds1').val()==''){layer.msg('请输入密码', {offset: '15px',icon: 1});return false;}if($('#pwds1').val()=='123456'){layer.msg('密码过于简单', {offset: '15px',icon: 1});return false;}if($('#pwds1').val()!==$('#pwds2').val()){layer.msg('2次输入密码不一致', {offset: '15px',icon: 1});return false;}if($('#pwds1').val().length < 6){layer.msg('密码不能输入少于6位数', {offset: '15px',icon: 1});return false;}form.S});});</script>
</body>
</html>