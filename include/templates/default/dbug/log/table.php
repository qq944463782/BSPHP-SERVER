<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo Plug_Lang('Dbug'); ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="<?php echo call_my_Get_Url_Statics() ?>layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="<?php echo call_my_Get_Url_Statics() ?>layuiadmin/style/admin.css" media="all">
</head>

<body data="BSPHP-PRO 2019本系统受国家版权局保护请勿破解或者二次开发传播">
    <style>
        .layui-tab-brief>.layui-tab-more li.layui-this::after,
        .layui-tab-brief>.layui-tab-title .layui-this::after {
            border-top: none;
            border-right: none;
            border-left: none;
            border-image: initial;
            border-radius: 0px;
            border-bottom: 2px solid rgb(29 145 251);
        }
    </style>

    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">

                    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                        <ul class="layui-tab-title">
                            <li class="layui-this"><?php echo Plug_Lang('接口监控调试插件'); ?></li>


                        </ul>
                        <div class="layui-tab-content"></div>
                    </div>
                    <div class="layui-card-body">


                        <li><?php echo Plug_Lang('说明:系统配置>系统信息设置>系统调试模式>开启调试;开始记录API接口调试日志.');?></li>



                        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label"><?php echo Plug_Lang('搜索字段'); ?></label>
                                    <div class="layui-input-block">

                                        <select name="soso_id" id="soso_id">
                                            <option value="1"><?php echo Plug_Lang('ID'); ?></option>
                                            <option value="2"><?php echo Plug_Lang('访问IP'); ?></option>
                                            <option value="3"><?php echo Plug_Lang('uuid'); ?></option>
                                            <option value="4"><?php echo Plug_Lang('Sessl(Token/Seesion)'); ?></option>
                                            <option value="5"><?php echo Plug_Lang('接口名称'); ?></option>
                                            <option value="6"><?php echo Plug_Lang('信息提示'); ?></option>
                                            <option value="7"><?php echo Plug_Lang('输出数据'); ?></option>
                                        </select>

                                    </div>
                                </div>
                                <div class="layui-inline">
                                     <label class="layui-form-label"><?php echo Plug_Lang('关键字:'); ?></label>
                                    <div class="layui-input-block" style="width:200px">
                                        <input type="text" name="soso" id="soso" placeholder="<?php echo Plug_Lang('请输入'); ?>" autocomplete="off" class="layui-input">
                                    </div>
                                </div>

                                <div class="layui-inline">
                                    <label class="layui-form-label"><?php echo Plug_Lang('排序'); ?></label>
                                    <div class="layui-input-block" style="width:100px">
                                        <select name="DESC" id="DESC">
                                            <option value="0"><?php echo Plug_Lang('正序'); ?></option>
                                            <option value="1"><?php echo Plug_Lang('倒序'); ?></option>

                                        </select>
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="LAY-user-front-search">

                                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                                    </button>
                                </div>
                            </div>
                        </div>




                        <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

                        <script type="text/html" id="test-table-toolbar-toolbarDemo">
                            <div class="layui-btn-container">


                                <button class="layui-btn layui-btn-sm" lay-event="act_3"><?php echo Plug_Lang('删除选择'); ?></button>


                                <button class="layui-btn layui-btn-sm" lay-event="act_2"><?php echo Plug_Lang('清空全部调试'); ?></button>


                            </div>
                        </script>


                        <script type="text/html" id="dbuginfo">
                            <div class="shopinfo">

                                <div class="regs regspadding0">



                                    <div class="describes">
                                        <span class="layui-badge layui-badge-rim"><?php echo Plug_Lang('时间'); ?> {{d.time}}</span>
                                    </div>
                                    <div class="describes">
                                        <span class="layui-badge layui-badge-rim"><?php echo Plug_Lang('IP'); ?> {{d.ip}}</span>
                                    </div>
                                    <div class="describes">
                                        <span title=“{{d.api}}” class="layui-badge layui-badge-rim"><?php echo Plug_Lang('接口'); ?> {{d.api}}</span>
                                    </div>
                                </div>
                            </div>
                        </script>


                        <script type="text/html" id="Sessl">
                            <div class="shopinfo">
                                <div class="regs regspadding0">
                                    <div title="{{d.Sessl}}" style="word-break: break-all;white-space: pre-wrap;font-size: 12px;" class="describes">{{d.Sessl}}</div>
                                </div>
                            </div>
                        </script>

                        <script type="text/html" id="error">
                            <div class="shopinfo">
                                <div class="regs regspadding0">
                                    <div title="{{d.error}}" style="word-break: break-all;white-space: pre-wrap;font-size: 13px;color: #f00;" class="describes">{{d.error}}</div>
                                </div>
                            </div>
                        </script>





                        <script type="text/html" id="test-table-toolbar-barDemo">
                            <a class="layui-btn layui-btn-xs" lay-event="edit"><?php echo Plug_Lang('查看报告'); ?></a>
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="foot">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Pro <?php echo BSPHP_VERSION; ?></a> Bsphp.com <br>
        All Rights Reserved </div>
        <script src="<?php echo call_my_Get_Url_Statics() ?>layuiadmin/layui/bsphp.js"></script>
    <script>
    bsphp_report_quickstat('<?php echo call_my_Lang("接口监控调试插件"); ?>');

var Bsphp_G_TO = '<?php echo Plug_Lang('到'); ?>';
   var Bsphp_G_P ='<?php echo Plug_Lang('页'); ?>';
   var Bsphp_G_ALL = '<?php echo Plug_Lang('共'); ?>';
   var Bsphp_G_OK = '<?php echo Plug_Lang('确认'); ?>';
   var Bsphp_G_E = '<?php echo Plug_Lang('条'); ?>';

   
        layui.config({
            base: '<?php echo call_my_Get_Url_Statics() ?>layuiadmin/' /**静态资源所在路*/
            ,  version: "20240311"
        }).extend({
            index: 'lib/index'
        }).use(['jquery', 'index', 'table', 'layer'], function() {
            var admin = layui.admin,
                $ = layui.$,
                table = layui.table;




            table.render({
                elem: '#test-table-toolbar',
                url: 'index.php?m=<?php echo Plug_Set_Get('m'); ?>&c=<?php echo Plug_Set_Get('c'); ?>&a=<?php echo Plug_Set_Get('a'); ?>_json&json=get&soso_ok=1&t=<?php echo Plug_Set_Get('t'); ?>',
                toolbar: '#test-table-toolbar-toolbarDemo',
                toolbar: '#test-table-toolbar-toolbarDemo',
                title: '<?php echo Plug_Lang('用户数据表'); ?>',
                cols: [
                    [{
                            type: 'checkbox',
                            fixed: 'left'
                        }, {
                            field: 'key',
                            width: 80,
                            title: '<?php echo Plug_Lang('编号'); ?>',

                        }

                        , {
                            field: 'time',
                            width: 200,
                            title: '<?php echo Plug_Lang('信息'); ?>',
                            templet: "#dbuginfo",

                        }, {
                            field: '',
                            width: 240,
                            title: '<?php echo Plug_Lang('Sessl(Token/Seesion)'); ?>',
                            templet: "#Sessl",
                     

                        }, {
                            field: '',
                            width: 450,
                            title: '<?php echo Plug_Lang('信息解释提示/解决方法'); ?>',
                            templet: "#error",
                    

                        }, {
                            field: 'print_fun_data',
                            width: 1000,
                            title: '<?php echo Plug_Lang('输出数据/故障问题'); ?>',

                        }

                        , {
                            fixed: 'right',
                            title: '<?php echo Plug_Lang('查看报告'); ?>',
                            toolbar: '#test-table-toolbar-barDemo',
                            width: 90
                        }



                    ]
                ],
                page: true

            });





            //头工具栏事件
            table.on('toolbar(test-table-toolbar)', function(obj) {
                var checkStatus = table.checkStatus(obj.config.id);

                switch (obj.event) {
                    case 'act_1':
                        var bsphp_all = '';
                        var data = checkStatus.data;
                        for (var key in data) {
                            bsphp_all = bsphp_all + data[key]['key'] + ',';
                        }
                        bsphp_all = bsphp_all + '0';
                        $.ajax({
                            type: "post",
                            url: '',
                            data: 'Submit_class=ok&all=' + bsphp_all + '&select_class=1',
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
                    case 'act_2':
                        
                        $.ajax({
                            type: "post",
                            url: '',
                            data: 'Submit_class=ok&all=-1&select_class=2',
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
                    case 'act_3':
                        var bsphp_all = '';
                        var data = checkStatus.data;
                        for (var key in data) {
                            bsphp_all = bsphp_all + data[key]['key'] + ',';
                        }
                        bsphp_all = bsphp_all + '0';
                        $.ajax({
                            type: "post",
                            url: '',
                            data: 'Submit_class=ok&all=' + bsphp_all + '&select_class=3',
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








            //监听行工具事件
            table.on('tool(test-table-toolbar)', function(obj) {
                var data = obj.data;
                //  alert(obj.data);
                if (obj.event === 'del') {
                    $.ajax({
                        type: "post",
                        url: '',
                        data: 'act=del&id=' + data.links_id,
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
                    })

                } else if (obj.event === 'edit') {
                    var index = layer.open({
                        type: 2,
                        title: '<?php echo Plug_Lang('查看'); ?>' + data.uuid + '<?php echo Plug_Lang('请求信息报告'); ?>',

                        content: "index.php?m=dbug&c=log&a=info&id=" + data.key,
                        area: ['600px', '500px'],
                        maxmin: true
                    });
                    layer.full(index);


                };




            });



            $('.layuiadmin-btn-useradmin').on('click', function() {
                //执行重载
                table.reload('test-table-toolbar', {
                    page: {
                        curr: 1
                    }
                });

            });







        });
    </script>

    <style>
        .layui-table-body .layui-table-cell {
            height: 60px;
            display: flex;
            line-height: 60px;
            align-content: center;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        .shopinfo {
            display: flex;
        }

        .shopinfo .regs {
            padding-left: 10px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            line-height: 20px;
            min-width: 141px;
        }

        .shopinfo .regs .describes {
            text-align: left;
            width: 100%;
        }

        .shopinfo .regs .title {
            font-weight: 600;
            text-align: left;
            width: 100%;
        }

        .shopinfo .regs .title a {
            width: 100%;
        }

        .shopinfo .regspadding0 {
            padding-left: 0px;
        }

        .shopinfo .imgs {
            width: 80px;
            height: 80px;
        }

        .shopinfo .imgs img {
            width: 80px;
            height: 80px;
        }



        .layui-table-body .laytable-cell-1-0-0,.layui-table-body .laytable-cell-2-0-0,.layui-table-body .laytable-cell-3-0-0,.layui-table-body .laytable-cell-4-0-0,.layui-table-body .laytable-cell-5-0-0 {
           
            justify-content: center;
        }
    </style>
</body>

</html>