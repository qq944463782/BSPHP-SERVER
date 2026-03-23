<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo Plug_Lang('账号在线信息'); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/statics/default/applib/bootstrap/css/bootstrap.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="/statics/default/applib/css/AdminLTE.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div style="max-width: 800px;margin:0 auto;" class="">
    <div class=".col-xs-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo Plug_Lang('账号在线信息'); ?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form id="form1" name="form1" method="post" action="">
          <div class="box-body">







            <!-- Main content -->




            <!-- /.box-header -->

            <table class="table">
              <tr>
                <th style="width: 10px"><?php echo Plug_Lang('ID'); ?></th>
                <th><?php echo Plug_Lang('在线标记'); ?></th>
                <th><?php echo Plug_Lang('机器ID'); ?></th>
                <th><?php echo Plug_Lang('登录时间'); ?></th>
                <th><?php echo Plug_Lang('自动退出'); ?></th>
                <th><?php echo Plug_Lang('操作'); ?></th>
              </tr>


              <?php

              $i = 1;


              while ($value = Plug_Pdo_Fetch_Assoc($db_array_value)) {


                #$date = date('Y/h/m', $value["" . 'news_unix']);






                echo '<tr>
                  <td><span class="badge bg-light-blue">' . $i . '</span></td>
                  <td><span class="badge bg-light-blue">' . md5($value["" . 'links_session_id']) . '</span></td>
                  <td>
                    
                    <span class="badge bg-green">' . md5($value["" . 'links_biaoji']) . '</span>
                   
                  </td>
                  <td><span class="badge bg-yellow">' . date('Y-m-d H:i:s', $value["" . 'links_add_time']) . '</span></td>
                  <td><span class="badge bg-yellow">' . date('Y-m-d H:i:s', $value["" . 'links_out_time']) . '</span></td>
                  <td><span class="badge bg-blue"><a class="badge bg-blue" href="index.php?m=applib&c=appweb&a=links_login&$daihao=' . $daihao . '&id=' . $value["" . 'links_id'] . '">T</a></span></td>
                </tr>';






                $i++;
              }
              ?>


            </table>

            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">


              </ul>
            </div>



            <!-- /.box-body -->

        </form>
        <!-- /.box -->
      </div>
    </div>
  </div>
</body>

</html>