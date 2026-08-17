<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?>- <?php echo Plug_Lang('卡列表'); ?></title>
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
          <div class="layui-card-header"><?php echo Plug_Lang('卡列表'); ?></div>

          <div class="layui-card-body">


            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
              <div class="layui-form-item">

                <div class="layui-inline">

                  <div class="layui-input-" style="width:200px">

                    <select name="daihao" id="daihao">

                      <?php

                      echo "<option value=\"-1\">" . Plug_Lang('全部软件') . "</option>";
                      $BS_val_daihao = array();
                      while ($value = Plug_Pdo_Fetch_Assoc($db_array_value_app)) {

                        if (!isset($BS_val_daihao[$value['app_daihao']])) {
                          $BS_val_daihao[$value['app_daihao']] = $value['app_name'];
                        }
                        echo "<option value=\"{$value['app_daihao']}\">{$value['app_name']}</option>";
                      }


                      ?>

                    </select>

                  </div>
                </div>

                <div class="layui-inline">

                  <div class="layui-input-" style="width:200px">

                    <select name="soso_id" id="soso_id">
                      <option value="1"><?php echo Plug_Lang('充值卡号'); ?></option>
                      <option value="2"><?php echo Plug_Lang('搜索备注'); ?></option>
                      <option value="3"><?php echo Plug_Lang('充值账号'); ?></option>
                      <option value="4"><?php echo Plug_Lang('制卡时间'); ?></option>
                      <option value="5"><?php echo Plug_Lang('(全国)下级制卡人'); ?></option>
                      <option value="6"><?php echo Plug_Lang('(全国)下级制卡人+子下级'); ?></option>
                    </select>

                  </div>
                </div>
                <div class="layui-inline">

                  <div class="layui-input-" style="width:150px">
                    <input type="text" name="soso" id="soso" placeholder="<?php echo Plug_Lang('搜索内容'); ?>" autocomplete="off" value="<?php echo Plug_Set_Get('soso'); ?>" class="layui-input">
                  </div>
                </div>
                <div class="layui-inline">

                  <div class="layui-input-" style="width:100px">
                    <select name="kalei" id="kalei">

                      <option value="-1"><?php echo Plug_Lang('全部卡类'); ?></option>
                      <?php



                      while ($value = Plug_Pdo_Fetch_Assoc($db_array_value_lei)) {

                        if ($this->user_array['user_anget_carid'] == '') {

                          echo "<option value=\"{$value['lei_id']}\">{$value['lei_name']} ({$BS_val_daihao[$value['lei_daihao']]})  (id:{$value['lei_id']})</option>";
                        } else {


                          if (strrpos('###' . $this->user_array['user_anget_carid'], $value['lei_id'] . ",")) {
                            echo "<option value=\"{$value['lei_id']}\">{$value['lei_name']} ({$BS_val_daihao[$value['lei_daihao']]})  (id:{$value['lei_id']})</option>";
                          }
                        }
                      }

                      ?>

                    </select>
                  </div>
                </div>
                <div class="layui-inline">

                  <div class="layui-input-" style="width:100px">
                    <select name="DESC" id="DESC">
                      <option value="0"><?php echo Plug_Lang('正序'); ?></option>
                      <option value="1"><?php echo Plug_Lang('倒序'); ?></option>

                    </select>
                  </div>
                </div>

                <div class="layui-inline">

                  <div class="layui-input-" style="width:100px">
                    <select name="on" id="on">

                      <option value="-1"><?php echo Plug_Lang('全部使用'); ?></option>
                      <option value="1"><?php echo Plug_Lang('已充值使用'); ?></option>
                      <option value="2"><?php echo Plug_Lang('未充值使用'); ?></option>

                    </select>
                  </div>
                </div>

                <div class="layui-inline">

                  <div class="layui-input-" style="width:100px">
                    <select name="zhuangtai" id="zhuangtai">
                      <option value="-1"><?php echo Plug_Lang('全部状态'); ?></option>
                      <option value="1"><?php echo Plug_Lang('正常卡'); ?></option>
                      <option value="2"><?php echo Plug_Lang('冻结卡'); ?></option>

                    </select>
                  </div>
                </div>
                <div class="layui-inline">

                  <div class="layui-input-" style="width:100px">

                    <select name="date_type" class="txt" id="date_type">

                      <option value="-1"><?php echo Plug_Lang('不设时间'); ?></option>
                      <option value="1"><?php echo Plug_Lang('制卡时间'); ?></option>
                      <option value="0"><?php echo Plug_Lang('充值时间'); ?></option>

                    </select>
                  </div>
                </div>
                <div class="layui-inline">

                  <div class="layui-input-" style="width:120px">
                    <input type="text" name="date1" id="date1" placeholder="<?php echo Plug_Lang('开始 2018-12-06'); ?>" value="<?php echo Plug_Set_Get('date1'); ?>" class="layui-input">

                  </div>
                </div>

                <div class="layui-inline">

                  <div class="layui-input-" style="width:120px">
                    <input type="text" name="date2" id="date2" placeholder="<?php echo Plug_Lang('结束 2018-12-06'); ?>" value="<?php echo Plug_Set_Get('date2'); ?>" class="layui-input">

                  </div>
                </div>

                <div class="layui-inline">
                  <button class="layui-btn layuiadmin-btn-useradmin  layui-btn-normal" lay-submit lay-filter="LAY-user-front-search">
                    <i class="layui-icon  layui-icon-search layuiadmin-button-btn"></i>
                  </button>
                </div>
              </div>
            </div>




            <?php
            $can_freeze = (Plug_Get_Configs_Value('agents', 'car_sdate_' . $this->Grade) != 0) || (Plug_Get_Configs_Value('agents', 'car_off_' . $this->Grade) != 0);
            $can_unfreeze = Plug_Get_Configs_Value('agents', 'car_sdate_no_' . $this->Grade) != 0;
            $can_delete = (Plug_Get_Configs_Value('agents', 'car_delete_' . $this->Grade) != 0) || (Plug_Get_Configs_Value('agents', 'pay_chong_' . $this->Grade) != 0);
            $show = 0;
            if (!$can_freeze) $show++;
            if (!$can_unfreeze) $show++;
            if (!$can_delete) $show++;
            ?>

            <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

            <script type="text/html" id="test-table-toolbar-toolbarDemo">
              <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="act_1"><?php echo Plug_Lang('导出选中卡号'); ?></button>
                <button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="act_2"><?php echo Plug_Lang('下载选中卡号'); ?></button>
                <button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="act_3"><?php echo Plug_Lang('导出报表'); ?></button>
                <?php if ($can_freeze) { ?>
                <button class="layui-btn layui-btn-sm layui-btn-warm" lay-event="batch_lock"><?php echo Plug_Lang('批量冻结'); ?></button>
                <?php } ?>
                <?php if ($can_unfreeze) { ?>
                <button class="layui-btn layui-btn-sm" lay-event="batch_unlock"><?php echo Plug_Lang('批量解冻'); ?></button>
                <?php } ?>
                <?php if ($can_delete) { ?>
                <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="batch_delete"><?php echo Plug_Lang('批量删除'); ?></button>
                <?php } ?>
              </div>
            </script>



            <script type="text/html" id="test-table-toolbar-barDemo">
              <a <?php if (!$can_freeze) echo ' style="display: none;" '; ?> class="layui-btn layui-btn-xs layui-btn-normal" lay-event="lock_1"><?php echo Plug_Lang('冻结'); ?></a>
              <a <?php if (!$can_unfreeze) echo ' style="display: none;" '; ?> class="layui-btn layui-btn-xs layui-btn-normal" lay-event="lock_0"><?php echo Plug_Lang('解冻'); ?></a>
              <a <?php if (!$can_delete) echo ' style="display: none;" '; ?> class="layui-btn layui-btn-xs layui-btn-danger" lay-event="delete"><?php echo Plug_Lang('删除'); ?></a>
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
  <script>

var Bsphp_G_TO = '<?php echo Plug_Lang('到'); ?>';
   var Bsphp_G_P ='<?php echo Plug_Lang('页'); ?>';
   var Bsphp_G_ALL = '<?php echo Plug_Lang('共'); ?>';
   var Bsphp_G_OK = '<?php echo Plug_Lang('确认'); ?>';
   var Bsphp_G_E = '<?php echo Plug_Lang('条'); ?>';
    layui.config({
      base: '<?php echo Plug_Get_Url_Statics() ?>style/' /**静态资源所在路*/
      ,  version: "20240311"
    }).extend({
      index: 'lib/index' /**主入口模块*/
    }).use(['jquery', 'index', 'table', 'layer', 'laydate'], function() {
      var admin = layui.admin,
        jq = layui.jquery,
        table = layui.table,
        admin = layui.admin,
        laydate = layui.laydate;

      var runBatch = function(selectClass, rows, title) {
        if (!rows || !rows.length) {
          layer.alert('<?php echo Plug_Lang('请先选择数据'); ?>');
          return;
        }
        var total = rows.length;
        if (rows.length > 50) {
          rows = rows.slice(0, 50);
        }
        var lines = [];
        var i = 0;
        var stopped = false;
        var area = admin.screen() < 2 ? ['100%', '410px'] : ['520px', '430px'];
        layer.open({
          type: 1,
          title: title,
          area: area,
          content: '<textarea id="batch_result" class="layui-textarea" style="height:350px;font-family:Verdana,Geneva,sans-serif;font-size:12px;"></textarea>',
          success: function() {
            if (total > 50) {
              lines.push('<?php echo Plug_Lang('一次最多50条,已截取前50条,原选择'); ?>' + total + '<?php echo Plug_Lang('条'); ?>');
              jq('#batch_result').val(lines.join('\n'));
            }
            var next = function() {
              if (stopped) return;
              if (i >= rows.length) {
                lines.push('<?php echo Plug_Lang('处理完成'); ?>');
                jq('#batch_result').val(lines.join('\n'));
                table.reload('test-table-toolbar');
                return;
              }
              var row = rows[i];
              var name = row.car_name || row.key;
              jq.ajax({
                type: 'post',
                url: '',
                data: 'Submit_class=ok&all=' + row.key + '&select_class=' + selectClass,
                dataType: 'json',
                success: function(ret) {
                  lines.push(name + ' >>> ' + (ret && ret.msg ? ret.msg : ''));
                  jq('#batch_result').val(lines.join('\n'));
                  i++;
                  next();
                },
                error: function() {
                  lines.push(name + ' >>> <?php echo Plug_Lang('接口请求返还异常'); ?>');
                  jq('#batch_result').val(lines.join('\n'));
                  i++;
                  next();
                }
              });
            };
            next();
          },
          end: function() {
            stopped = true;
          }
        });
      };


      table.render({
        elem: '#test-table-toolbar',
        url: 'index.php?m=<?php echo Plug_Set_Get('m'); ?>&c=<?php echo Plug_Set_Get('c'); ?>&a=<?php echo Plug_Set_Get('a'); ?>_json&json=get&soso_ok=1&t=<?php echo Plug_Set_Get('t'); ?>',
        toolbar: '#test-table-toolbar-toolbarDemo',
        toolbar: '#test-table-toolbar-toolbarDemo',
        title: '<?php echo Plug_Lang('用户数据表'); ?>',
        height: 'full-290',
        cols: [
          [

            {
              type: 'checkbox',
              fixed: 'left'
            }, {
              field: 'key',
              width: 80,
              title: '<?php echo Plug_Lang('编号'); ?>',
            }, {
              field: 'car_name',
              width: 280,
              title: '<?php echo Plug_Lang('卡号'); ?>',
            }, {
              field: 'car_pwd',
              width: 100,
              title: '<?php echo Plug_Lang('密码'); ?>'
            }, {
              field: 'app_name',
              width: 100,
              title: '<?php echo Plug_Lang('软件名称'); ?>'
            }, {
              field: 'app_leiname',
              width: 100,
              title: '<?php echo Plug_Lang('卡类'); ?>'
            }, {
              field: 'app_date',
              width: 100,
              title: '<?php echo Plug_Lang('时间'); ?>'
            }, {
              field: 'zhuangtai',
              width: 80,
              title: '<?php echo Plug_Lang('锁状态'); ?>',
            }, {
              field: 'IsLock',
              width: 120,
              title: '<?php echo Plug_Lang('激活状态'); ?>',
            }, {
              field: 'car_reDATE',
              width: 120,
              title: '<?php echo Plug_Lang('制作时间'); ?>',
            }, {
              field: 'car_admin',
              width: 120,
              title: '<?php echo Plug_Lang('制卡人'); ?>',
            }, {
              field: 'car_pur_date',
              width: 120,
              title: '<?php echo Plug_Lang('使用时间'); ?>',
            }, {
              field: 'car_cong_user',
              width: 120,
              title: '<?php echo Plug_Lang('充值账号'); ?>',
            }, {
              field: 'car_agnet_beizhu',
              width: 200,
              title: '<?php echo Plug_Lang('备注(编辑)'); ?>',
              edit: 'text'
            }



            , {
              fixed: '<?php if ($show == 3) {
                        echo '';
                      } else {
                        echo 'right';
                      } ?>',
              title: '<?php echo Plug_Lang('操作'); ?>',
              toolbar: '#test-table-toolbar-barDemo',
              width: <?php if ($show == 3) {
                        echo 0;
                      } else {
                        echo 200;
                      } ?>
            }
          ]
        ],
        page: true,
        where: {
          zhuangtai: document.getElementById("zhuangtai").value,
          on: document.getElementById("on").value,
          date_type: document.getElementById("date_type").value,
          date1: document.getElementById("date1").value,
          date2: document.getElementById("date2").value,
          daihao: document.getElementById("daihao").value,
          kalei: document.getElementById("kalei").value
        }

      });




      /**监听单元格编辑*/
      table.on('edit(test-table-toolbar)', function(obj) {
        var value = obj.value,
          data = obj.data,
          field = obj.field;


        jq.ajax({
          type: "post",
          url: '',
          data: 'Submit_class=ok&all=' + data.key + '&select_class=12&txt=' + value,
          dataType: "json",
          success: function(ret) {

            layer.msg(ret.msg, {
              offset: '15px'
            });
          },
          error: function(e, t) {
            layer.alert('<?php echo Plug_Lang('接口请求返还异常'); ?>');

          }
        });




      });


      /**头工具栏事件*/
      table.on('toolbar(test-table-toolbar)', function(obj) {
        var checkStatus = table.checkStatus(obj.config.id);

        switch (obj.event) {
          case 'act_1':
            var bsphp_all = '';
            var data = checkStatus.data;
            for (var key in data) {


              if (data[key]['car_pwd'] == '') {
                bsphp_all = bsphp_all + data[key]['car_name'] + '\n';
              } else {
                bsphp_all = bsphp_all + data[key]['car_name'] + '---' + data[key]['car_pwd'] + '\n';
              }

            }



            layer.tab({
              area: admin.screen() < 2 ? ['100%', '410px'] : ['400px', '410px'],

              tab: [{
                title: '<?php echo Plug_Lang('导出卡号'); ?>',
                content: '<textarea wrap="off" style="font-family: Verdana, Geneva, sans-serif;font-size:12px;word-wrap:normal;height:100%;min-height:350px" name="" class="layui-textarea">' + bsphp_all + '</textarea>'
              }]
            });




            break;
          case 'act_2':
            var bsphp_all = '';
            var data = checkStatus.data;
            for (var key in data) {


              if (data[key]['car_pwd'] == '') {
                bsphp_all = bsphp_all + data[key]['car_name'] + '\r\n';
              } else {
                bsphp_all = bsphp_all + data[key]['car_name'] + '---' + data[key]['car_pwd'] + '\r\n';
              }

            };

            exportRaw('卡密.txt', bsphp_all);


            break;
          case 'act_3':
            layer.alert('需要更详细导出请点击右边菜单按钮选择导出栏目隐藏或者显示导出或者打印');
            break;
          case 'batch_lock':
            runBatch(1, checkStatus.data, '<?php echo Plug_Lang('批量冻结'); ?>');
            break;
          case 'batch_unlock':
            runBatch(2, checkStatus.data, '<?php echo Plug_Lang('批量解冻'); ?>');
            break;
          case 'batch_delete':
            layer.confirm('<?php echo Plug_Lang('确认批量删除选中卡密？一次最多50条'); ?>', function(index) {
              layer.close(index);
              runBatch(3, checkStatus.data, '<?php echo Plug_Lang('批量删除'); ?>');
            });
            break;
          case 'act_4':
            jq.ajax({
              type: "post",
              url: '',
              data: 'Submit_class=ok&all=1&select_class=4',
              dataType: "json",
              success: function(ret) {
                layer.alert(ret.msg);
                table.reload('test-table-toolbar', {
                  page: {
                    curr: 1
                  }
                });
              },
              error: function(e, t) {
                layer.alert('<?php echo Plug_Lang('接口请求返还异常'); ?>');

              }
            });

            break;

        };
      });








      /**监听行工具事件*/
      table.on('tool(test-table-toolbar)', function(obj) {
        var data = obj.data;

        if (obj.event === 'lock_1') {
          jq.ajax({
            type: "post",
            url: '',
            data: 'Submit_class=ok&all=' + data.key + '&select_class=1',
            dataType: "json",
            success: function(ret) {
              layer.alert(ret.msg);
              table.reload('test-table-toolbar', {
                page: {
                  curr: 1
                }
              });
            },
            error: function(e, t) {
              layer.alert('<?php echo Plug_Lang('接口请求返还异常'); ?>');

            }
          });

        } else if (obj.event === 'lock_0') {
          jq.ajax({
            type: "post",
            url: '',
            data: 'Submit_class=ok&all=' + data.key + '&select_class=2',
            dataType: "json",
            success: function(ret) {
              layer.alert(ret.msg);
              table.reload('test-table-toolbar', {
                page: {
                  curr: 1
                }
              });
            },
            error: function(e, t) {
              layer.alert('<?php echo Plug_Lang('接口请求返还异常'); ?>');

            }
          });


        } else if (obj.event === 'delete') {
          jq.ajax({
            type: "post",
            url: '',
            data: 'Submit_class=ok&all=' + data.key + '&select_class=3',
            dataType: "json",
            success: function(ret) {
              layer.alert(ret.msg);
              table.reload('test-table-toolbar', {
                page: {
                  curr: 1
                }
              });
            },
            error: function(e, t) {
              layer.alert('<?php echo Plug_Lang('接口请求返还异常'); ?>');

            }
          });


        }




      });



      jq('.layuiadmin-btn-useradmin').on('click', function() {
        /**执行重载*/
        table.reload('test-table-toolbar', {

          page: {
            curr: 1
          },
          where: {
            zhuangtai: document.getElementById("zhuangtai").value,
            on: document.getElementById("on").value,
            date_type: document.getElementById("date_type").value,
            date1: document.getElementById("date1").value,
            date2: document.getElementById("date2").value,
            daihao: document.getElementById("daihao").value,
            kalei: document.getElementById("kalei").value



          }



        });

      });


      /**日期时间选择器*/
      laydate.render({
        elem: '#date1',
        type: 'date'
      });

      /**日期时间选择器*/
      laydate.render({
        elem: '#date2',
        type: 'date'
      });




      jq('#soso').on('click', function() {



        if (jq('#soso_id').val() == 5 || jq('#soso_id').val() == 6) {
          layer.open({
            type: 2,
            title: '<?php echo Plug_Lang('选择代理'); ?>',

            area: ['700px', '450px'],
            fixed: false,
            maxmin: true,
            content: 'index.php?m=agent&c=sp&a=agent_list&val=' + jq('#soso').val() + "&id=soso"
          });

        }
      });


    });




    function fakeClick(obj) {
      var ev = document.createEvent("MouseEvents");
      ev.initMouseEvent("click", true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
      obj.dispatchEvent(ev);
    }

    function exportRaw(name, data) {
      var urlObject = window.URL || window.webkitURL || window;
      var export_blob = new Blob([data]);
      var save_link = document.createElementNS("http://www.w3.org/1999/xhtml", "a");
      save_link.href = urlObject.createObjectURL(export_blob);
      save_link.download = name;
      fakeClick(save_link);
    }





    select_set_text('soso_id', '<?php echo Plug_Set_Get('soso_id'); ?>');
    select_set_text('daihao', '<?php echo Plug_Set_Get('daihao'); ?>');
    select_set_text('DESC', '<?php echo Plug_Set_Get('DESC'); ?>');
    select_set_text('kalei', '<?php echo Plug_Set_Get('kalei'); ?>');
    select_set_text('on', '<?php echo Plug_Set_Get('on'); ?>');
    select_set_text('zhuangtai', '<?php echo Plug_Set_Get('zhuangtai'); ?>');
    select_set_text('date_type', '<?php echo Plug_Set_Get('date_type'); ?>');
    select_set_text('agenttype', '<?php echo Plug_Set_Get('agenttype'); ?>');
  </script>
</body>

</html>
