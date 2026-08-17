<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?> - <?php echo Plug_Lang('分佣金收入记录'); ?></title>
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
        <div class="layui-card-header"><?php echo Plug_Lang('分佣金收入记录'); ?></div>
        <div class="layui-card-body">
          <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
              <div class="layui-inline">
                <label class="layui-form-label"><?php echo Plug_Lang('来源'); ?></label>
                <div style="width:180px;" class="layui-input-block">
                  <select name="source" id="source">
                    <option value="direct"><?php echo Plug_Lang('用户直接充值收入'); ?></option>
                    <option value="all"><?php echo Plug_Lang('全部分佣收入'); ?></option>
                    <option value="renew"><?php echo Plug_Lang('续期分佣'); ?></option>
                    <option value="gencard"><?php echo Plug_Lang('制卡购买分佣'); ?></option>
                    <option value="salecard"><?php echo Plug_Lang('现卡购买分佣'); ?></option>
                  </select>
                </div>
              </div>
              <div class="layui-inline">
                <label class="layui-form-label"><?php echo Plug_Lang('搜索字段'); ?></label>
                <div style="width:160px;" class="layui-input-block">
                  <select name="soso_id" id="soso_id">
                    <option value="2"><?php echo Plug_Lang('订单号'); ?></option>
                    <option value="3"><?php echo Plug_Lang('描述'); ?></option>
                    <option value="1"><?php echo Plug_Lang('备注'); ?></option>
                  </select>
                </div>
              </div>
              <div class="layui-inline">
                <label class="layui-form-label"><?php echo Plug_Lang('关键字'); ?></label>
                <div class="layui-input-block" style="width:200px;">
                  <input type="text" name="soso" id="soso" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-inline">
                <label class="layui-form-label"><?php echo Plug_Lang('排序'); ?></label>
                <div style="width:110px;" class="layui-input-block">
                  <select name="DESC" id="DESC">
                    <option value="0"><?php echo Plug_Lang('倒序'); ?></option>
                    <option value="1"><?php echo Plug_Lang('正序'); ?></option>
                  </select>
                </div>
              </div>
              <div class="layui-inline">
                <button class="layui-btn layuiadmin-btn-useradmin layui-btn-normal" id="searchBtn">
                  <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                </button>
              </div>
              <div class="layui-inline">
                <span class="layui-badge layui-bg-blue" id="total_amount_show"><?php echo Plug_Lang('分佣合计'); ?>: 0</span>
              </div>
            </div>
          </div>

          <table class="layui-hide" id="moneylog-table" lay-filter="moneylog-table"></table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>
layui.config({ base: '<?php echo Plug_Get_Url_Statics() ?>style/' }).extend({ index: 'lib/index' })
.use(['jquery', 'index', 'table'], function() {
  var jq = layui.jquery, table = layui.table;

  var tableIns = table.render({
    elem: '#moneylog-table',
    id: 'moneylog-table',
    url: 'index.php?m=agent&c=CommissionLogsFeature&a=table_json',
    title: '<?php echo Plug_Lang('分佣金收入记录'); ?>',
    cellMinWidth: 110,
    height: 'full-260',
    where: { source: 'direct', soso_id: 2, DESC: 0, soso: '' },
    cols: [[
      {field: 'id', width: 80, title: '<?php echo Plug_Lang('编号'); ?>', sort: true},
      {field: 'log_amount', width: 110, title: '<?php echo Plug_Lang('分佣金额'); ?>', sort: true},
      {field: 'log_level', width: 80, title: '<?php echo Plug_Lang('级别'); ?>'},
      {field: 'log_order', minWidth: 260, title: '<?php echo Plug_Lang('订单号'); ?>'},
      {field: 'log_desc', minWidth: 220, title: '<?php echo Plug_Lang('描述'); ?>'},
      {field: 'log_status_show', width: 110, title: '<?php echo Plug_Lang('状态'); ?>'},
      {field: 'log_date', width: 150, title: '<?php echo Plug_Lang('时间'); ?>'},
      {field: 'log_remark', minWidth: 180, title: '<?php echo Plug_Lang('备注'); ?>'}
    ]],
    page: true,
    done: function(res) {
      var total = 0;
      if (res && res.extra && typeof res.extra.total_amount !== 'undefined') {
        total = res.extra.total_amount;
      }
      jq('#total_amount_show').text('<?php echo Plug_Lang('分佣合计'); ?>: ' + total);
    }
  });

  jq('#searchBtn').on('click', function() {
    table.reload('moneylog-table', {
      where: {
        source: jq('#source').val(),
        soso_id: jq('#soso_id').val(),
        DESC: jq('#DESC').val(),
        soso: jq('#soso').val()
      },
      page: { curr: 1 }
    });
  });
});
</script>
</body>
</html>
