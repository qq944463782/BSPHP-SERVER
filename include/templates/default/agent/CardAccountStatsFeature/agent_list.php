<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo Plug_Lang('选择代理'); ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
</head>
<body>
<div class="layui-fluid">
  <div class="layui-card">
    <div class="layui-card-header"><?php echo Plug_Lang('代理商账号列表'); ?></div>
    <div class="layui-card-body">
      <div class="layui-form layui-card-header layuiadmin-card-header-auto">
        <div class="layui-form-item">
          <input type="hidden" id="soso_id" value="1">
          <input type="hidden" id="DESC" value="0">
          <div class="layui-inline">
            <label class="layui-form-label"><?php echo Plug_Lang('关键字'); ?></label>
            <div class="layui-input-block" style="width:220px;">
              <input type="text" id="soso" placeholder="<?php echo Plug_Lang('请输入代理账号'); ?>" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <button class="layui-btn layuiadmin-btn-useradmin" id="btnSearch">
              <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
            </button>
          </div>
        </div>
      </div>
      <table class="layui-hide" id="agent-list-table" lay-filter="agent-list-table"></table>
    </div>
  </div>
</div>

<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>
layui.config({ base: '<?php echo Plug_Get_Url_Statics() ?>style/' }).extend({ index: 'lib/index' })
.use(['jquery', 'index', 'table'], function() {
  var jq = layui.jquery, table = layui.table;
  var fieldId = '<?php echo htmlspecialchars((string)Plug_Set_Get("id"), ENT_QUOTES, "UTF-8"); ?>' || 'soso';
  var initVal = '<?php echo htmlspecialchars((string)Plug_Set_Get("val"), ENT_QUOTES, "UTF-8"); ?>' || '';
  jq('#soso').val(initVal);

  table.render({
    elem: '#agent-list-table',
    id: 'agent-list-table',
    url: 'index.php?m=agent&c=CardAccountStatsFeature&a=agent_list_json',
    where: { soso: '' },
    page: true,
    height: 'full-180',
    cols: [[
      {field: 'uid', width: 90, title: 'UID', sort: true},
      {field: 'user', minWidth: 200, title: '<?php echo Plug_Lang("代理账号"); ?>'},
      {field: 'level', width: 120, title: '<?php echo Plug_Lang("星级"); ?>'},
      {field: 'parent', minWidth: 160, title: '<?php echo Plug_Lang("上级账号"); ?>'}
    ]]
  });

  table.on('rowDouble(agent-list-table)', function(obj) {
    var data = obj.data || {};
    if (window.parent && window.parent.layui) {
      window.parent.layui.jquery('#' + fieldId).val(data.user || '');
      var index = window.parent.layer.getFrameIndex(window.name);
      window.parent.layer.close(index);
    }
  });

  jq('#btnSearch').on('click', function() {
    table.reload('agent-list-table', {
      where: { soso: jq('#soso').val() },
      page: { curr: 1 }
    });
  });
});
</script>
</body>
</html>
