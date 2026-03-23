<?php
$tody_date=date('Y-m-d', PLUG_UNIX());
$snutady=date('w', PLUG_UNIX());
$tody_unix=PLUG_UNIX();
$log_info_array=array();
$sql="select count(*)as'hangshu',SUM(`car_Rmb`)as'car_Rmb',SUM(`car_DaoLi_Rmb`)as'car_DaoLi_Rmb'from`bs_php_cardseries`";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['ka_all']=(int)$tmp_arr['hangshu'];
$log_info_array['ka_all_rmb']=(int)$tmp_arr['car_Rmb'];
$log_info_array['ka_all_d_rmb']=(int)$tmp_arr['car_DaoLi_Rmb'];
$sql="select count(*)as'hangshu',SUM(`car_Rmb`)as'car_Rmb',SUM(`car_DaoLi_Rmb`)as'car_DaoLi_Rmb'from`bs_php_cardseries`";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['ka_all']=(int)$tmp_arr['hangshu'];
$log_info_array['ka_all_rmb']=(int)$tmp_arr['car_Rmb'];
$log_info_array['ka_all_d_rmb']=(int)$tmp_arr['car_DaoLi_Rmb'];
$sql="select count(*)as'hangshu',SUM(`car_Rmb`)as'car_Rmb',SUM(`car_DaoLi_Rmb`)as'car_DaoLi_Rmb'from`bs_php_cardseries`WHERE`car_IsLock`='1'";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['ka_aut']=(int)$tmp_arr['hangshu'];
$log_info_array['ka_aut_rmb']=(int)$tmp_arr['car_Rmb'];
$log_info_array['ka_aut_d_rmb']=(int)$tmp_arr['car_DaoLi_Rmb'];
$sql="select count(*)as'hangshu',SUM(`car_Rmb`)as'car_Rmb',SUM(`car_DaoLi_Rmb`)as'car_DaoLi_Rmb'from`bs_php_cardseries`WHERE`car_IsLock`='0'";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['ka_die']=(int)$tmp_arr['hangshu'];
$log_info_array['ka_die_rmb']=(int)$tmp_arr['car_Rmb'];
$log_info_array['ka_die_d_rmb']=(int)$tmp_arr['car_DaoLi_Rmb'];
$sql="select count(*)as'hangshu',SUM(`car_Rmb`)as'car_Rmb',SUM(`car_DaoLi_Rmb`)as'car_DaoLi_Rmb'from`bs_php_cardseries`WHERE`car_pur_date`>'{$tody_date}'AND`car_IsLock`='1'";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['ka_tady_out_all']=(int)$tmp_arr['hangshu'];
$log_info_array['ka_tady_out_all_rmb']=(int)$tmp_arr['car_Rmb'];
$log_info_array['ka_tady_out_all_d_rmb']=(int)$tmp_arr['car_DaoLi_Rmb'];
$sql="select count(`pay_rbm`)as'hangshu'from`bs_php_rmb_pay_log`WHERE `pay_zhuangtai`='1' and `pay_date`='{$tody_date}'";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['user_tady_pay_rmb']=(int)$tmp_arr['hangshu'];
$sql="select SUM(`ka_shijia`)as'hangshu'from`bs_php_pay_log`WHERE`pay_date`>'{$tody_date}'AND`pay_zhuangtai`='1'";
$tmp_arr=Plug_Query_Assoc($sql);
$log_info_array['user_tady_buy_ka_rmb']=(int)$tmp_arr['hangshu'];
?>
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('系统消费信息'); ?><span style="color: #d0d0d0;font-size: 9px;"> <?php echo Plug_Lang('二开修改'); ?>:Plug/Admin_Statistics/Statistics_200系统消费信息.php</span></div>
<div class="layui-card-body">
<div class="layui-carousel layadmin-carousel_m3 layadmin-carousel2 layadmin-carousel layadmin-backlog">
<ul class="layui-row layui-col-space10">
<li class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('今天注册数量'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('总充值卡'); ?></h3>
<p><cite style="color: #FF5722;"><?PHP echo $log_info_array['ka_all']; ?><?php echo Plug_Lang('张'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('今天注册数量'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('总未激活卡'); ?></h3>
<p><cite style="color: #FF5722;"><?PHP echo $log_info_array['ka_die']; ?><?php echo Plug_Lang('张'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('今天注册数量'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('总已激活卡'); ?></h3>
<p><cite style="color: #FF5722;"><?PHP echo $log_info_array['ka_aut']; ?><?php echo Plug_Lang('张'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('今天充值使用卡'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('今天激活卡'); ?></h3>
<p><cite style="color: #FF5722;"><?PHP echo $log_info_array['ka_tady_out_all']; ?><?php echo Plug_Lang('张'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('今天消费余额'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('今天消费'); ?></h3>
<p><cite style="color: #FF5722;"><?PHP echo $log_info_array['user_tady_buy_ka_rmb']; ?><?php echo Plug_Lang('元'); ?></cite></p>
</a>
</li>
<li class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
<a href="javascript:;" onclick="layer.tips('<?php echo Plug_Lang('今天充值'); ?>', this, {tips: 3});" class="layadmin-backlog-body">
<h3><?php echo Plug_Lang('今天充值'); ?></h3>
<p><cite style="color: #FF5722;"><?PHP echo $log_info_array['user_tady_pay_rmb']; ?><?php echo Plug_Lang('元'); ?></cite></p>
</a>
</li>
</ul>
</div>
</div>
</div>
</div>
<style>
.layadmin-carousel_m3 {
background-color: rgb(255, 255, 255);
min-height: 105px;
}
</style>