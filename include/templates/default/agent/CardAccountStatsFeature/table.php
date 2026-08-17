<?php

$HOST_DATE = HOST_DATE;
if ($soso == '') $soso = $this->user_array['user_user'];

#检测权限
$BS_val_agent_ok = 0;
$i = 0;
if ($soso == '') $soso = $this->user_array['user_user'];
if ($soso == $this->user_array['user_user']) {
  $BS_val_agent_ok = 1;
} else {


  $BS_val_agent_array = Plug_Query_One('bs_php_user', 'user_user', $soso, ' `user_uid`,`user_user`,`user_IsLock`,`user_yao_User` ');
  while ($i < 100) {
    $i++;
    if (!$BS_val_agent_array) {
      break;
    }
    if ($BS_val_agent_array['user_yao_User'] == $this->user_array['user_user'] or $BS_val_agent_array['user_user'] == $this->user_array['user_user']) {
      $BS_val_agent_ok = 1;
      break;
    }
    $BS_val_agent_array = Plug_Query_One('bs_php_user', 'user_user', $BS_val_agent_array['user_yao_User'], ' `user_uid`,`user_user`,`user_IsLock`,`user_yao_User` ');
  }
}
if ($BS_val_agent_ok == 0) {
  echo 'cuowu';
  exit;
}


$agenttype = Plug_Set_Get('agenttype');

if (Plug_Set_Get('soso_id') == 1) {


  if ($soso == '') {
    $soso2_sql = "";
  } else {
    $soso2_sql = "and `user_yao_User` =  '$soso' ";
  }


  $soso_sql = "";
} else {
  if ($soso == '') {
    $soso_sql = "";
  } else {

    //$sql = "SELECT * FROM  `bs_php_user`WHERE  `user_user` ='$soso'     LIMIT 0 , 3000";
    //$uids_arr = Plug_Query_Array($sql);
    $soso_sql = "and `user_user` =  '{$soso}' ";
  }
  $soso2_sql = "";
}


?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?>- <?php echo Plug_Lang('卡通过代理统计批量'); ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
</head>

<body data="">

  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header"><?php echo Plug_Lang('卡通过代理统计批量'); ?></div>
          <div class="layui-card-body" pad15>
            <div class="layui-form" wid100 lay-filter="">




              <form name="formsoso" class="layui-form" method="get" action="">
                <div style="margin-left: 10px;">

                  <div class="layui-form-item">
                    <div class="layui-inline">



                      <div class="layui-input-inline" style="width: 150px;">
                        <select name="daihao" id="daihao">

                          <?php

                          echo "<option value=\"-1\">" . Plug_Lang('全部软件') . "</option>";

                          while ($value = Plug_Pdo_Fetch_Assoc($db_array_value_app)) {



                            echo "<option value=\"{$value['app_daihao']}\">{$value['app_name']}</option>";
                          }

                          ?>

                        </select>
                      </div>

                      <div class="layui-input-inline" style="width: 150px;">
                        <select name="soso_id" class="txt" id="soso_id">
                          <option value="0"><?php echo Plug_Lang('指定代理账号'); ?></option>
                          <option value="1"><?php echo Plug_Lang('指定上级代理'); ?></option>
                        </select>
                      </div>



                      <div class="layui-input-inline" style="width: 100px;">
                        <input name='soso' type='text' id="soso" class="layui-input" placeholder="<?php echo Plug_Lang('代理账号'); ?>" value='<?php echo $soso ?>' />
                      </div>

                      <div class="layui-input-inline" style="width: 150px;">
                        <select name="agenttype" class="txt" id="agenttype">

                          <option value="0"><?php echo Plug_Lang('只统计搜索账号'); ?></option>
                          <option value="1"><?php echo Plug_Lang('统计包含下线代理'); ?></option>


                        </select>
                      </div>


                      <div class="layui-input-inline" style="width: 160px;">
                        <input type="text" name="date1" id="date1" value="<?php echo $date1 ?>" placeholder="<?php echo Plug_Lang('开始 2018-12-05'); ?>" autocomplete="off" class="layui-input">
                      </div>


                      <div class="layui-input-inline" style="width: 160px;">
                        <input type="text" name="date2" id="date2" value="<?php echo $date2 ?>" placeholder="<?php echo Plug_Lang('结束 2018-12-05'); ?>" autocomplete="off" class="layui-input">
                      </div>
                      <input name="soso_ok" type="hidden" id="soso_ok" value="ok" />

                      <div class="layui-input-inline" style="width: 100px;">
                        <button class="layui-btn layuiadmin-btn-useradmin  layui-btn-normal" lay-submit lay-filter="LAY-user-front-search">
                          <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                      </div>
                    </div>
                  </div>

                  <span class="sosodiv">
                    <input name="act" type="hidden" id="act" value="table">
                  </span><span class="sosodiv">
                    <input name="m" type="hidden" id="m" value="<?php echo $_GET['m'] ?>">
                    <input name="c" type="hidden" id="c" value="<?php echo $_GET['c'] ?>">
                    <input name="a" type="hidden" id="a" value="<?php echo $_GET['a'] ?>">

                  </span>
                </div>
              </form>








              <form action="" class="layui-form" name="form" method="post" onClick="return allcheckbox();">

                <?php





                $sql = "SELECT * FROM  `bs_php_user`WHERE  `user_daili`  > 0 {$soso_sql}  {$soso2_sql}     LIMIT 0 , 3000";

                $db_array_value_user = Plug_Query($sql);
                while ($value_user = Plug_Pdo_Fetch_Assoc($db_array_value_user)) {

                  $car_admin = $value_user['user_uid'];





                  if ($agenttype == 1) {

                    if ($soso != '') {
                      $BS_val_IN = Plug_get_agent_info_in($soso);
                      $BS_val_car_admin_sql = "  `car_admin`IN($BS_val_IN) AND";
                    } else {
                      $BS_val_car_admin_sql = "  `car_admin`IN(99999) AND";
                    }
                  } else {

                    $BS_val_car_admin_sql = "    `car_admin` = '{$car_admin}' AND";
                  }






                  /** 库卡*/
                  $sql = "select SUM(`kuka_val`)as'hangshu' from`bs_php_kuka`WHERE`kuka_uid`='{$value_user['user_uid']}'";
                  $tmp_arr = Plug_Query_Array($sql);
                  $kuka_row = (int)$tmp_arr['hangshu'];




                  $call_govicp = Plug_Get_Configs_Value('sys', 'govicp');

                ?>
                  <table class="layui-table" style="width:98%;margin-left: 10px;" lay-filter="demoEvent">
                    <thead>
                      <tr bgcolor="" height="52">
                          <th width="14%"><?php echo Plug_Lang('账号'); ?></th>
                          <th width="14%"><?php echo $value_user['user_user']; ?>(UID<?php echo $value_user['user_uid'] ?>)</th>
                          <th width="14%"><?php echo Plug_Lang('剩余库卡:') ?></th>
                          <th width="14%"><?php echo $kuka_row ?><?php echo Plug_Lang('张'); ?></th>
                          <th width="14%"><?php echo Plug_Lang('余额'); ?></th>
                          <th width="14%"><?php echo $value_user['user_rmb']; ?><?php echo Plug_Lang('元'); ?></th>
                          <th width="*"><?php echo $HOST_DATE ?></th>
                        </tr>


                      <tr bgcolor="" height="52">
                        <th width="*"><?php echo Plug_Lang('卡类ID'); ?></th>
                        <th width="*"><?php echo Plug_Lang('卡类名称'); ?></th>
                        <th width="*"><?php echo Plug_Lang('软件名称'); ?></th>
                        <th width="*"><?php echo Plug_Lang('总数据量'); ?></th>
                        <th width="*"><?php echo Plug_Lang('已激活'); ?></th>
                        <th width="*"><?php echo Plug_Lang('未激活'); ?></th>
                        <th width="*"><?php echo Plug_Lang('已冻结'); ?></th>

                      </tr>

                    </thead>

                  <?php

                  $car_DaiHao = " ";
                  if ($daihao > 0) {

                    $car_DaiHao = " `car_DaiHao` = '$daihao' AND ";
                  }



                    //制卡时间
                    $a_date1_sql = '';
                    if ($date1 != '') {
                      $a_date1_sql = "  `car_reDATE` > '{$date1} 00:00:00' AND ";
                    }

                    $a_date2_sql = '';
                    if ($date2 != '') {
                      $a_date2_sql = "  `car_reDATE` < '{$date2} 23:59:59' AND  ";
                    }


                    $b_date1_sql2 = '';
                    if ($date1 != '') {
                      $b_date1_sql2 = "  `car_pur_date` > '{$date1} 00:00:00' AND ";
                    }

                    $b_date2_sql2 = '';
                    if ($date2 != '') {
                      $b_date2_sql2 = "  `car_pur_date` < '{$date2} 23:59:59' AND  ";
                    }




                  /*开始枚举 */
                  $sql = "SELECT *, COUNT( * ) AS  `row` ,  `car_Lei`FROM  `bs_php_cardseries`where {$car_DaiHao} {$a_date1_sql} {$a_date2_sql}  {$BS_val_car_admin_sql}   car_id > 0 or {$car_DaiHao} {$b_date1_sql2} {$b_date2_sql2}  {$BS_val_car_admin_sql}   car_id > 0 GROUP BY  `car_Lei`ORDER BY  `car_Lei`LIMIT 1000";

                  $db_array_value = Plug_Query($sql);

                  while ($value = Plug_Pdo_Fetch_Assoc($db_array_value)) {


                    $soso = Plug_Set_Post('soso');


                    $soso_sql = " AND " . $BS_val_car_admin_sql;
                    $app_array = call_my_get_appdaihao_info_array($value['car_DaiHao']);
                    $lei_array = Plug_Query_One('bs_php_kalei', 'lei_id', $value['car_Lei'], ' * ');


                    if (!isset($lei_array['lei_name'])) {
                      $lei_array['lei_name'] = '<cite style="color: #FF5722;">[卡类已经被删除]</cite>';
                    }


                    if (!isset($app_array['app_name'])) {
                      $app_array['app_name'] = '<cite style="color: #FF5722;">[软件已经被删除]</cite>';
                    }




                    $date1_sql = '';
                    if ($date1 != '') {
                      $date1_sql = " `car_pur_date` > '{$date1} 00:00:00' AND  ";
                    }

                    $date2_sql = '';
                    if ($date2 != '') {
                      $date2_sql = " `car_pur_date` < '{$date2} 23:59:59' AND  ";
                    }
                    $sql = "select count(*)as'hangshu' from`bs_php_cardseries`WHERE {$date1_sql} {$date2_sql} `car_Lei`={$value['car_Lei']} and `car_IsLock`=1 {$soso_sql}   `car_zhuangtai`=0  and `car_DaiHao`='{$value['car_DaiHao']}'";
                    //  ECHO $sql;
                    $tmp_arr = Plug_Query_Array($sql);
                    $zongshu_a = (int)$tmp_arr['hangshu']; //用户总数





                    $date1_sql = '';
                    if ($date1 != '') {
                      $date1_sql = "  `car_reDATE` > '{$date1} 00:00:00' AND ";
                    }

                    $date2_sql = '';
                    if ($date2 != '') {
                      $date2_sql = "  `car_reDATE` < '{$date2} 23:59:59' AND  ";
                    }
                    $sql = "select count(*)as'hangshu' from`bs_php_cardseries`WHERE {$date1_sql} {$date2_sql} `car_Lei`={$value['car_Lei']} and  `car_IsLock`=0 {$soso_sql}   `car_zhuangtai`=0  and `car_DaiHao`='{$value['car_DaiHao']}'";
                    $tmp_arr = Plug_Query_Array($sql);
                    $zongshu_b = (int)$tmp_arr['hangshu']; //用户总数


                    $sql = "select count(*)as'hangshu' from`bs_php_cardseries`WHERE {$date1_sql} {$date2_sql}  `car_Lei`={$value['car_Lei']} and  `car_zhuangtai`=1 {$soso_sql}  `car_DaiHao`='{$value['car_DaiHao']}'";
                    $tmp_arr = Plug_Query_Array($sql);
                    $zongshu_c = (int)$tmp_arr['hangshu']; //用户总数	


                    $rows  = $zongshu_a + $zongshu_a;
                    print <<< EOT

                
                
      


<tr   height="22" >
           <td height="18" >{$value['car_Lei']}</td>
           <td height="18" >{$lei_array['lei_name']}</td>
		   <td height="18" >{$app_array['app_name']}&nbsp;</td>
                 <td ><a  onclick="openka('{$value['car_DaiHao']}','{$value['car_Lei']}','all','{$value_user['user_user']}');"  href="javascript:void(0);">{$rows}张</a></td>
                <td  ><a  onclick="openka('{$value['car_DaiHao']}','{$value['car_Lei']}','in','{$value_user['user_user']}');"  href="javascript:void(0);">{$zongshu_a}张</a></td>
                <td  ><a  onclick="openka('{$value['car_DaiHao']}','{$value['car_Lei']}','ok','{$value_user['user_user']}');"  href="javascript:void(0);">{$zongshu_b}张</a></td>
                <td  ><a  onclick="openka('{$value['car_DaiHao']}','{$value['car_Lei']}','look','{$value_user['user_user']}');"  href="javascript:void(0);">{$zongshu_c}张</a></td>

</tr>
	  
EOT;
                  }
                  echo '</table><BR/><BR/>';
                }
                  ?>


                  <p> </p>






              </form>






            </div>


          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
  <script>
    layui.config({
      base: '<?php echo Plug_Get_Url_Statics() ?>style/' /**静态资源所在路*/
    }).extend({
      index: 'lib/index' /**主入口模块*/
    }).use(['jquery', 'index', 'set', 'laydate', 'layer'], function() {
      var laydate = layui.laydate,
        jq = layui.jquery,
        admin = layui.admin;

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

        layer.open({
          type: 2,
          title: '<?php echo Plug_Lang('选择代理'); ?>',

          area: ['700px', '450px'],
          fixed: false,
          maxmin: true,
          content: 'index.php?m=agent&c=CardAccountStatsFeature&a=agent_list&val=' + jq('#soso').val() + "&id=soso"
        });
      })



    });



    function openka(daihao, kalei, sdate, name) {
      var date1 = document.getElementById("date1").value;
      var date2 = document.getElementById("date2").value;
      var agenttype = document.getElementById("agenttype").value;
      if (sdate == 'all') {
        var zhuangtai = -1;
        var on = -1;
        var date_type = -1;
        if (date1 != '' || date2 != '') {
          date_type = 1;
        }



      }
      if (sdate == 'in') {
        var zhuangtai = 1;
        var on = 1;
        var date_type = 0;
      }
      if (sdate == 'ok') {
        var zhuangtai = 1;
        var on = 2;
        var date_type = 1;
      }
      if (sdate == 'look') {
        var zhuangtai = 2;
        var on = -1;
        var date_type = 1;
      }

      var soso = name;


      if (agenttype == 0) {
        var soso_id = 5;
      }
      if (agenttype == 1) {
        var soso_id = 6;
      }


      var index = layer.open({
        type: 2,
        title: '<?php echo Plug_Lang('卡列表'); ?>',
        area: ['700px', '450px'],
        fixed: false,
        maxmin: true,
        content: "index.php?m=agent&c=sp&a=table&daihao=" + daihao + "&agenttype=" + agenttype + "&soso_ok=1&soso_id=" + soso_id + "&soso=" + soso + "&DESC=0&zhuangtai=" + zhuangtai + "&on=" + on + "&date_type=" + date_type + "&date1=" + date1 + "&date2=" + date2 + "&kalei=" + kalei
      });
      layer.full(index);


    }
  </script>



  <script language="javascript">
    select_set_text('agenttype', <?php echo Plug_Set_Get('agenttype'); ?>);
    select_set_text('daihao', <?php echo Plug_Set_Get('daihao'); ?>);
    select_set_text('soso_id', <?php echo Plug_Set_Get('soso_id'); ?>);
  </script>
</body>

</html>