<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?>- <?php echo Plug_Lang('代理列表'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
</head>
<body>
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo Plug_Lang('代理商账号列表'); ?></div>
<div class="layui-card-body">
<div class="layui-form layui-card-header layuiadmin-card-header-auto agent-search-wrap">
<div class="layui-form-item">
<div class="layui-inline">
<label class="layui-form-label"><?php echo Plug_Lang('搜索字段'); ?></label>
<div style="width: 200px;" class="layui-input-block">
<select name="soso_id" id="soso_id">
<option value="1"><?php echo Plug_Lang('登陆账号'); ?></option>
<option value="2"><?php echo Plug_Lang('用户UID'); ?></option>
<option value="5"><?php echo Plug_Lang('折扣'); ?></option>
<option value="7"><?php echo Plug_Lang('用户状态=&gt;冻结'); ?></option>
<option value="8"><?php echo Plug_Lang('用户状态=&gt;正常'); ?></option>
<option value="15"><?php echo Plug_Lang('金额大于N用户'); ?></option>
<option value="16"><?php echo Plug_Lang('登录次数大于N用户'); ?></option>
<option value="18"><?php echo Plug_Lang('备注'); ?></option>
</select>
</div>
</div>
<div class="layui-inline">
<label class="layui-form-label"><?php echo Plug_Lang('关键字:'); ?></label>
<div class="layui-input-block w-200">
<input type="text" name="soso" id="soso" placeholder="<?php echo Plug_Lang('请输入'); ?>" autocomplete="off" class="layui-input">
</div>
</div>
<div class="layui-inline">
<label class="layui-form-label"><?php echo Plug_Lang('排序'); ?></label>
<div style="width: 120px;" class="layui-input-block">
<select name="DESC" id="DESC">
<option value="0"><?php echo Plug_Lang('正序'); ?></option>
<option value="1"><?php echo Plug_Lang('倒序'); ?></option>
</select>
</div>
</div>
<div class="layui-inline">
<button class="layui-btn layuiadmin-btn-useradmin layui-btn-normal" lay-submit lay-filter="LAY-user-front-search">
<i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
</button>
</div>
</div>
</div>
<table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
<script type="text/html" id="test-table-toolbar-toolbarDemo"><div class="layui-btn-container agent-toolbar"><button class="layui-btn layui-btn-sm layui-btn-warm" lay-event="act_4"><?php echo Plug_Lang('解封选择'); ?></button><button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="act_2"><?php echo Plug_Lang('冻结选择'); ?></button><button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="act_3"><?php echo Plug_Lang('代理结构预览'); ?></button></div></script>
<script type="text/html" id="test-table-toolbar-barDemo"><a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="set"><?php echo Plug_Lang('设置'); ?></a><a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="order"><?php echo Plug_Lang('转账'); ?></a><a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="kuka_transaction_add"><?php echo Plug_Lang('库卡转出'); ?></a><a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="kuka_transaction_reduce"><?php echo Plug_Lang('库卡收回'); ?></a></script>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>var Bsphp_G_TO='<?php echo Plug_Lang('到'); ?>';var Bsphp_G_P='<?php echo Plug_Lang('页'); ?>';var Bsphp_G_ALL='<?php echo Plug_Lang('共'); ?>';var Bsphp_G_OK='<?php echo Plug_Lang('确认'); ?>';var Bsphp_G_E='<?php echo Plug_Lang('条'); ?>';layui.config({ base: '<?php echo Plug_Get_Url_Statics() ?>style/' }).extend({ index: 'lib/index' }).use(['jquery', 'index', 'table', 'layer'], function() {var admin=layui.admin, $=layui.$, table=layui.table;table.render({elem: '#test-table-toolbar',url: 'index.php?m=<?php echo Plug_Set_Get('m'); ?>&c=<?php echo Plug_Set_Get('c'); ?>&a=<?php echo Plug_Set_Get('a'); ?>_json&json=get&soso_ok=1&t=<?php echo Plug_Set_Get('t'); ?>',toolbar: '#test-table-toolbar-toolbarDemo',title: '<?php echo Plug_Lang('用户数据表'); ?>',cellMinWidth: 110, height: 'full-250',cols: [[{type: 'checkbox', fixed: 'left'},{field: 'uid', width: 80, title: '<?php echo Plug_Lang('编号'); ?>', sort: true},{field: 'user', minWidth: 150, title: '<?php echo Plug_Lang('用户名'); ?>', sort: true},{field: 'test', width: 90, title: '<?php echo Plug_Lang('状态'); ?>', sort: true},{field: 'LoGinNum', width: 95, title: '<?php echo Plug_Lang('登录次数'); ?>'},{field: 'rmb', width: 100, title: '<?php echo Plug_Lang('余额'); ?>'},{field: 'Zhe', width: 90, title: '<?php echo Plug_Lang('折扣'); ?>'},{field: 're_date', minWidth: 160, title: '<?php echo Plug_Lang('注册时间'); ?>'},{field: 'zhhd', minWidth: 160, title: '<?php echo Plug_Lang('最后活动'); ?>'},{field: 'xianka', width: 100, title: '<?php echo Plug_Lang('现卡总数'); ?>'},{field: 'kuka', width: 100, title: '<?php echo Plug_Lang('库卡总数'); ?>'},{field: 'agent_beizhu', minWidth: 180, title: '<?php echo Plug_Lang('备注(编辑)'); ?>', edit: 'text'},{fixed: 'right', title: '<?php echo Plug_Lang('操作'); ?>', toolbar: '#test-table-toolbar-barDemo', width: 280}]],page: true});});</script>
</body>
</html>
