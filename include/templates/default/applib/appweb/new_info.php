<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo  $news_array['news_table']; ?></title>
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
          <h3 class="box-title"><?php echo  $news_array['news_table']; ?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form id="form1" name="form1" method="post" action="">
          <div class="box-body">







            <!-- Content Wrapper. Contains page content -->

            <!-- Content Header (Page header) -->
            <section class="content-header">

              <ol class="breadcrumb">
                <li><a href="index.php?m=applib&c=appweb&a=new_list"><i class="fa fa-dashboard"></i><?php echo Plug_Lang('列表'); ?></a></li>



                <li><a href="index.php?m=applib&c=appweb&a=new_list&list=<?php echo $news_class_array['class_id']; ?>"><?php echo $news_class_array['class_name']; ?></a> </li>
                <li><a href='index.php?m=applib&c=appweb&a=new_info&id=&id=<?php echo $news_array['news_id']; ?>' title='<?php echo  $news_array['news_table']; ?>'><?php echo  $news_array['news_table']; ?></a>



              </ol>
            </section>

            <!-- Main content -->
            <section class="content">

              <!-- Default box -->

              <div class="box-header with-border">



                <?php echo $news_test; ?>

              </div>



              <!-- /.box-body -->

              <!-- /.box -->
          </div>
      </div>
    </div>
</body>

</html>