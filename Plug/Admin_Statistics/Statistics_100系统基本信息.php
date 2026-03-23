<?php
$tody_date=date('Y-m-d', PLUG_UNIX());
$snutady=date('w', PLUG_UNIX());
$tody_unix=PLUG_UNIX();
$log_info_array=array();
$sql="select count(*)as'hangshu'from`bs_php_user`WHERE `user_daili`=0";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['user_tady_all']=(int)$tmp_arr['hangshu'];
$user_tady_allQ=$log_info_array['user_tady_all'];
$sql="select SUM(`user_rmb`)as'zongrmb'from`bs_php_user`";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['user_tady_rmb_all']=(int)$tmp_arr['zongrmb'];
$sql="select count(*)as'hangshu'from`bs_php_user`WHERE `user_daili`>=1";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['user_daili']=(int)$tmp_arr['hangshu'];
$sql="select count(*)as'hangshu'from`bs_php_user`WHERE`user_re_date`>'{$tody_date}'";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['user_tady_re']=(int)$tmp_arr['hangshu'];
$sql="select count(*)as'hangshu'from`bs_php_user`WHERE`user_Login_date`>'{$tody_date}'";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['user_tady_login']=(int)$tmp_arr['hangshu'];
$sql="select count(*)as'hangshu',SUM(`car_Rmb`)as'car_Rmb',SUM(`car_DaoLi_Rmb`)as'car_DaoLi_Rmb'from`bs_php_cardseries`";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['ka_all']=(int)$tmp_arr['hangshu'];
$log_info_array['ka_all_rmb']=(int)$tmp_arr['car_Rmb'];
$log_info_array['ka_all_d_rmb']=(int)$tmp_arr['car_DaoLi_Rmb'];
$sql="select count(*)as'hangshu'from`bs_php_user`WHERE`user_re_date`>'{$tody_date}'AND`user_yao_User`!=''";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['user_tady_re_yao']=(int)$tmp_arr['hangshu'];
$links_chaoshi=PLUG_UNIX() - 1800;
$sql="select count(*)as'hangshu'from`bs_php_links_session`WHERE`links_chaoshi` > '{$links_chaoshi}' AND`links_user_name`!=''";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['user_hot']=(int)$tmp_arr['hangshu'];
$links_chaoshi=PLUG_UNIX() - 1800;
$sql="select count(*)as'hangshu'from`bs_php_appinfo` ";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['app']=(int)$tmp_arr['hangshu'];
?>
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('系统基本信息'); ?><span style="color: #d0d0d0;font-size: 9px;" > <?php echo Plug_Lang('二开修改'); ?>:Plug/Admin_Statistics/Statistics_100系统基本信息.php</span></div>
<div class="layui-card-body">
<div class="layui-carousel layadmin-carousel2 layadmin-carousel layadmin-backlog">
<ul class="layui-row layui-col-space10">
<li class="layui-col-xs12 layui-col-sm6 layui-col-md3">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('账号用户总数,不含代理'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('账号总数'); ?></h3>
<p><cite><?PHP echo $log_info_array['user_tady_all']; ?><?php echo Plug_Lang('个'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md3">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('今天登录用户'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('今天登录'); ?></h3>
<p><cite><?php echo $log_info_array['user_tady_login']; ?><?php echo Plug_Lang('个'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md3">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('代理商总数'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('代理总数'); ?></h3>
<p><cite><?PHP echo $log_info_array['user_daili']; ?><?php echo Plug_Lang('个'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md3">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('今天注册数量'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('今天注册数量'); ?></h3>
<p><cite><?PHP echo $log_info_array['user_tady_re']; ?><?php echo Plug_Lang('个'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md3">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('总用户余额,包含用户代理的'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('总用户余额'); ?></h3>
<p><cite><?PHP echo $log_info_array['user_tady_rmb_all']; ?><?php echo Plug_Lang('元'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md3">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('今天邀请注册'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('今天邀请注册'); ?></h3>
<p><cite ><?PHP echo $log_info_array['user_tady_re_yao']; ?><?php echo Plug_Lang('个'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md3">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('在线用户列表最近30分钟有活动的用户'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('在线用户(最近30活动时间)'); ?></h3>
<p><cite ><?PHP echo $log_info_array['user_hot']; ?><?php echo Plug_Lang('人'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md3">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('软件总数'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('软件总数'); ?></h3>
<p><cite ><?PHP echo $log_info_array['app']; ?><?php echo Plug_Lang('个'); ?></cite></p>
</a>
</li>
</ul>
</div>
</div>
</div>
</div>