<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title><?php echo Plug_Lang('UUID报告'); ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="//cache.bsphp.com/pro-statics/MyBs/admin/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="//cache.bsphp.com/pro-statics/MyBs/admin/layuiadmin/style/admin.css" media="all">
</head>

<body data="BSPHP-PRO 2022本系统受国家版权局保护请勿破解或者二次开发传播">

    <div class="layui-flui1d">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">

                    <div style="min-height: 100vh;" class="layui-card-body">


                        <ul class="layui-timeline">
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title"><?php echo Plug_Lang('报告基本信息'); ?></h3>
                                    <p>
                                    <ul>
                                        <li><span class="layui-badge layui-bg-blue">id:</span> <span class="layui-badge"><?php echo $array['id'] ?></span><br></li>
                                        <li><span class="layui-badge layui-bg-blue">访问档案:</span> <span class="layui-badge"><?php echo $array['uuid'] ?></span><br></li>
                                        <li><span class="layui-badge layui-bg-blue">访问时间:</span> <span class="layui-badge"><?php echo date('Y-m-d H:i:s', $array['time']) ?></span><br></li>
                                        <li><span class="layui-badge layui-bg-blue">访问IP:</span> <span class="layui-badge"><?php echo $array['ip'] ?></span><br></li>
                                    </ul>
                                    </p>
                                </div>
                            </li>
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title"><?php echo Plug_Lang('系统入口信息'); ?></h3>

                                    <ul>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('Sessl:'); ?></span> <span class="layui-badge"><?php echo $array['Sessl'] ?></span> </li>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('API:'); ?></span> <span class="layui-badge"><?php echo $array['api'] ?></span> </li>

                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('软件代号:'); ?></span> <span class="layui-badge"><?php echo isset($array_get['appid']) ? $array_get['appid'] : '无'; ?></span> </li>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('初始化地址:'); ?></span>

                                            <span class="layui-badge"><?php echo isset($array_head['REQUEST_SCHEME']) ? $array_head['REQUEST_SCHEME'] : ''; ?>://<?php echo isset($array_head['HTTP_HOST']) ? $array_head['HTTP_HOST'] : ''; ?><?php echo isset($array_head['REQUEST_URI']) ? $array_head['REQUEST_URI'] : ''; ?></span>


                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title"><?php echo Plug_Lang('接收数据处理'); ?></h3>
                                    <p>
                                    <ul>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('加密方式:'); ?></span> <span class="layui-badge"> <?php echo $array['decrypt'] ?></span> <?php $array['decrypt'] == 'notfun_bsphp_mdecrypt' ? ' <span class="layui-badge">(未开加密传输无需解密)</span>' : '' ?> <br></li>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('接收数据方式:'); ?></span> <span class="layui-badge"><?php

                                                                                                                                if ($array['parameter_type'] == 1) {
                                                                                                                                    echo '加密POST parameter参数接收加密参数';
                                                                                                                                }

                                                                                                                                if ($array['parameter_type'] == 2) {
                                                                                                                                    echo '加密GET parameter参数接收加密参数';
                                                                                                                                }


                                                                                                                                if ($array['parameter_type'] == 3) {
                                                                                                                                    echo '标准GET';
                                                                                                                                }
                                                                                                                                if ($array['parameter_type'] == 4) {
                                                                                                                                    echo '标准POST';
                                                                                                                                }
                                                                                                                                ?></span> </li>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('parameter原始数据:'); ?></span>
                                            <pre class="layui-code" lay-title="parameter原始数据"><?php echo $array['parameter'] ?></pre><br>
                                        </li>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('parameter解密数据:'); ?></span>
                                            <pre class="layui-code" lay-title="parameter原始数据"><?php echo (base64_decode($array['decrypt_data'])) ?></pre><br>
                                        </li>


                                    </ul>
                                    </p>
                                </div>
                            </li>
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title"><?php echo Plug_Lang('接收Sign签名数据'); ?></h3>
                                    <p>
                                    <ul>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('签名KEY:'); ?></span> <span class="layui-badge"><?php echo $array['in_sigm_key'] ?></span> <?php $array['in_sigm_key'] == '' ? '<span class="layui-badge"> (未开启签接收Sign名验证)</span>' : '' ?> <br></li>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('签名MD5:'); ?></span> <span class="layui-badge"><?php echo $array['in_sigm_md5'] ?></span> <br></li>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('签名组合:'); ?></span>
                                            <pre class="layui-code layui-code layui-box layui-code-view" lay-title="<?php echo Plug_Lang('签名组合'); ?>"><?php echo ($array['in_sigm_txt']) ?></pre><br>
                                        </li>

                                    </ul>
                                    </p>
                                </div>
                            </li>
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title"><?php echo Plug_Lang('输出Sign签名数据 (签名二开路径:/include/applibapi/output)'); ?></h3>
                                    <p>
                                    <ul>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('签名KEY:'); ?></span> <span class="layui-badge"><?php echo $array['to_sigm_key'] ?></span> <?php $array['to_sigm_key'] == '' ? ' <span class="layui-badge">(未开启签输出Sign名验证)</span>' : '' ?> <br></li>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('签名MD5:'); ?></span> <span class="layui-badge"><?php echo $array['to_sigm_md5'] ?></span> <br></li>
                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('签名组合:'); ?></span>
                                            <pre class="layui-code layui-code layui-box layui-code-view" lay-title="<?php echo Plug_Lang('签名组合'); ?>"><?php echo ($array['to_sigm_txt']) ?></pre><br>
                                        </li>

                                    </ul>
                                    </p>
                                </div>
                            </li>

                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title"><?php echo Plug_Lang('处理结果数据'); ?><<<<<<< </h3>
                                            <p>
                                            <ul>
                                                <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('输出格式:'); ?></span> <span class="layui-badge"><?php echo $array['print_fun'] ?> </span> <span class="layui-badge"><?php echo Plug_Lang('(输出格式二开路径:/include/applibapi/output)');?></span><br></li>
                                                <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('输出加密:'); ?></span> <span class="layui-badge"><?php echo $array['encryption'] ?> </span> <br></li>
                                                <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('输出数据明文:'); ?></span>
                                                    <pre class="layui-code layui-code layui-box layui-code-view" lay-title="<?php echo Plug_Lang('签名组合'); ?>"><?php echo ($array['print_fun_data']) ?></pre><br>
                                                </li>
                                                <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('输出加密后数据:'); ?></span>
                                                    <pre class="layui-code layui-code layui-box layui-code-view" lay-title="<?php echo Plug_Lang('签名组合'); ?>"><?php echo ($array['encryption_data']) ?></pre><br>
                                                </li>

                                            </ul>
                                            </p>
                                </div>
                            </li>

                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title"><?php echo Plug_Lang('客户端接收'); ?></h3>
                                    <p>
                                    <ul>


                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('报文内容(如果页面有抱错也可看见，取缓存数据):');?></span>
                                            <pre class="layui-code layui-code layui-box layui-code-view" lay-title="报文内容"><?php echo base64_decode($array['print_html']) ?></pre><br>
                                        </li>

                                    </ul>
                                    </p>
                                </div>
                            </li>





                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title"><?php echo Plug_Lang('其他数据'); ?></h3>
                                    <p>
                                    <ul>


                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('接收协议头:'); ?></span>
                                            <pre class="layui-code layui-code layui-box layui-code-view" lay-title="">
                                                <?php

                                                $arr = json_decode($array['head_data'], 1);

                                                if (is_array($arr)) {
                                                    foreach ($arr as $v => $key) {

                                                        echo $v . ":" . $key . '</br>';
                                                    }
                                                }
                                                ?></pre><br>
                                        </li>

                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('接收POST:'); ?></span>
                                            <pre class="layui-code layui-code layui-box layui-code-view" lay-title=""><?php echo $data = $array['post_data']; ?></pre><br>
                                        </li>

                                        <li><span class="layui-badge layui-bg-blue"><?php echo Plug_Lang('接收GET:'); ?></span>
                                            <pre class="layui-code layui-code layui-box layui-code-view" lay-title=""><?php echo $data = $array['get_data']; ?></pre><br>
                                        </li>

                                    </ul>
                                    </p>
                                </div>
                            </li>
                        </ul>


                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="//cache.bsphp.com/pro-statics/MyBs/admin/layuiadmin/layui/bsphp.js"></script>
    <script>
        layui.config({
            base: '//cache.bsphp.com/pro-statics/default/admin/layuiadmin/' //静态资源所在路
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'set', 'jquery', 'table', 'layer'], function() {

            var $ = layui.$,
                layer = layui.layer;

            $('#setpost').on('click', function() {




                var formData = $('#bsphppost').serialize();
                $.ajax({
                    type: 'post',
                    url: '',
                    data: formData,
                    success: function(ret) {

                        layer.alert(ret.msg);


                    }
                });

                return false;

            });

        });
    </script>
</body>

</html>