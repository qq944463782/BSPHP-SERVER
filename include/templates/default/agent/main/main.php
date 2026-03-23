
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP ECHO ����������������������������������������������������������������::������������������������������������������������������������������������������������("sys","name"); ?> - <?php echo ��������������������������������������������������������������������������������('代理商管理平台'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>style/style/admin.css" media="all">
</head>
<body class="layui-layout-body">
<div id="LAY_app">
<div class="layui-layout layui-layout-admin">
<div class="layui-header">
<ul class="layui-nav layui-layout-left">
<li class="layui-nav-item layadmin-flexible" lay-unselect>
<a href="javascript:;" layadmin-event="flexible" title="<?php echo ��������������������������������������������������������������������������������('侧边伸缩'); ?>">
<i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
</a>
</li>
<li class="layui-nav-item" lay-unselect>
<a href="javascript:;" layadmin-event="refresh" title="<?php echo ��������������������������������������������������������������������������������('刷新'); ?>">
<i class="layui-icon layui-icon-refresh-3"></i>
</a>
</li>
</ul>
<ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
<li class="layui-nav-item layui-hide-xs" lay-unselect>
<a href="javascript:;" layadmin-event="theme">
<i class="layui-icon layui-icon-theme"></i>
</a>
</li>
<li class="layui-nav-item layui-hide-xs" lay-unselect>
<a href="javascript:;" layadmin-event="fullscreen">
<i class="layui-icon layui-icon-screen-full"></i>
</a>
</li>
<li class="layui-nav-item" lay-unselect>
<a href="javascript:;">
<cite><?php echo $this->function（����������������������������������������������������������������������������['user_user']; ?>(<?php echo $this->function（����������������������������������������������������������������������������['user_daili']; ?><?php echo ��������������������������������������������������������������������������������('星'); ?>) </cite>
</a>
<dl class="layui-nav-child">
<dd><a target="_blank" href="../code"><?php echo ��������������������������������������������������������������������������������('查询激活码'); ?></a></dd>
<dd><a lay-href="index.php?m=agent&c=sp&a=password"><?php echo ��������������������������������������������������������������������������������('修改密码'); ?></a></dd>
<dd  style="text-align: center;"><a href="index.php?m=agent&c=index&a=loginout"><?php echo ��������������������������������������������������������������������������������('退出'); ?></a></dd>
</dl>
</li>
</ul>
</div>
<div class="layui-side layui-side-menu">
<div class="layui-side-scroll">
<div class="layui-logo" lay-href="index.php?m=agent&c=main&a=info">
<span><?PHP ECHO ����������������������������������������������������������������::������������������������������������������������������������������������������������("sys","name"); ?><?php echo ��������������������������������������������������������������������������������('-代理'); ?></span>
</div>
<ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
<?php
$����������������������������️‍������������������������������������������������������������=����������������������������������������4��������������������.'Plug/Agent_list';
$return（����������������������������������������������������8����������������=null;
$����������������������������������������������������������������������������=null;
$��������������������������������������������������������������������=null;
$����������������������������������������������������������������������������=opendir($����������������������������️‍������������������������������������������������������������);
$��������������������������������������������������������������������������������=array();
while ($������������������������������������������������������������������������elseif（=readdir($����������������������������������������������������������������������������)) {
if (strstr($������������������������������������������������������������������������elseif（, 'agent_'.$this->function（����������������������������������������������������������������������������['user_daili'])) {
$return（����������������������������������������������������8����������������++;
$��������������������������������������������������������������������������������[]=$����������������������������️‍������������������������������������������������������������ . '/' . $������������������������������������������������������������������������elseif（ ;
}
}
sort($��������������������������������������������������������������������������������);
foreach ($�������������������������������������������������������������������������������� as $����������������������������������������������������B��������������������������������) {
include ($����������������������������������������������������B��������������������������������);
}
?>
</ul>
</div>
</div>
<div class="layadmin-pagetabs" id="LAY_app_tabs">
<div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
<div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
<div class="layui-icon layadmin-tabs-control layui-icon-down">
<ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
<li class="layui-nav-item" lay-unselect>
<a href="javascript:;"></a>
<dl class="layui-nav-child layui-anim-fadein">
<dd layadmin-event="closeThisTabs"><a href="javascript:;"><?php echo ��������������������������������������������������������������������������������('关闭当前标签页'); ?></a></dd>
<dd layadmin-event="closeOtherTabs"><a href="javascript:;"><?php echo ��������������������������������������������������������������������������������('关闭其它标签页'); ?></a></dd>
<dd layadmin-event="closeAllTabs"><a href="javascript:;"><?php echo ��������������������������������������������������������������������������������('关闭全部标签页'); ?></a></dd>
</dl>
</li>
</ul>
</div>
<div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
<ul class="layui-tab-title" id="LAY_app_tabsheader">
<li lay-id="index.php?m=admin&c=tools&a=info" lay-attr="index.php?m=admin&c=tools&a=info" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
</ul>
</div>
</div>
<div class="layui-body" id="LAY_app_body">
<div class="layadmin-tabsbody-item layui-show">
<iframe src="index.php?m=agent&c=main&a=info" frameborder="0" class="layadmin-iframe"></iframe>
</div>
</div>
<div class="layadmin-body-shade" layadmin-event="shade"></div>
</div>
</div>
<script src="<?php echo ������������������������������������������������������������������������() ?>style/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo ������������������������������������������������������������������������() ?>style/',views:'../statics/default/agent/'}).extend({index: 'lib/index'}).use('index');</script>
<div style="display:none;">
</div>
</body>
</html>
