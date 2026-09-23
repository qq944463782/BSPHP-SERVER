<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo  $list_array['class_name']; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/statics/default/applib/bootstrap/css/bootstrap.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="/statics/default/applib/css/AdminLTE.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="">
    <div class=".col-xs-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo  $list_array['class_name']; ?></h3>
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
                <th><?php echo Plug_Lang('分类'); ?></th>
                <th><?php echo Plug_Lang('标题'); ?></th>
                <th style="width: 40px"><?php echo Plug_Lang('时间'); ?></th>
              </tr>


              <?php

              $i = 1;


            
              while ($value = Plug_Pdo_Fetch_Assoc($pdb_array_value)) {


                $date = date('Y/h/m', $value["" . 'news_unix']);






                echo '<tr>
                  <td><span class="badge bg-light-blue">' . $i . '</span></td>
                  <td><span class="badge bg-light-blue"><a class="bg-light-blue" href="index.php?m=applib&c=appweb&open_new=' . $open_new . '&a=new_list&list=' . $value["" . 'class_id'] . '">' . $value["" . 'class_name'] . '</a></span></td>
                  <td>
                    
                    <span class="badge bg-green"><a  class="bg-green" target="' . $open_new . '"  href="index.php?m=applib&c=appweb&a=new_info&id=' . $value["" . 'news_id'] . '">' . $value["" . 'news_table'] . '</a></span>
                   
                  </td>
                  <td><span class="badge bg-yellow">' . $date . '</span></td>
                </tr>';




                $i++;
              }
              ?>


            </table>

            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">

                <?php echo $pg_text; ?>
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