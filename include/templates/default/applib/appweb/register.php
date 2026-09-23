<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo Plug_Lang('注册账号'); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/statics/default/applib/bootstrap/css/bootstrap.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/statics/default/applib/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/statics/default/applib/css/AdminLTE.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="">
    <div style="max-width: 800px;margin:0 auto;" class=".col-xs-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo Plug_Lang('注册账号'); ?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form id="form1" name="form1" method="post" action="">
          <div class="box-body">


            <div class="form-group">
              <label for="exampleInputPassword1"><?php echo Plug_Lang('注册账号'); ?></label>
              <div class="input-group">
                <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                <input class="form-control" name="user" value="<?php echo $user; ?>" type="text" placeholder="<?php echo Plug_Lang('注册账号'); ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1"><?php echo Plug_Lang('密码'); ?></label>
              <div class="input-group">
                <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                <input class="form-control" name="pwda" value="<?php echo $pwda; ?>" type="text" placeholder="<?php echo Plug_Lang('密码'); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1"><?php echo Plug_Lang('再次确认密码'); ?></label>
              <div class="input-group">
                <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                <input class="form-control" name="pwdb" value="<?php echo $pwdb; ?>" type="text" placeholder="<?php echo Plug_Lang('再次确认密码'); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1"><?php echo Plug_Lang('QQ'); ?></label>
              <div class="input-group">
                <div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
                <input class="form-control" name="qq" value="<?php echo $qq; ?>" type="text" placeholder="<?php echo Plug_Lang('用于找回密码等操作'); ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1"><?php echo Plug_Lang('激活码'); ?></label>
              <div class="input-group">
                <div class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></div>
                <input class="form-control" name="code_ka" value="<?php echo $code_ka; ?>" type="text" placeholder="<?php echo Plug_Lang('激活码，联系销售或者代理购买'); ?>">
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-body">
              <h4><?php echo $log_name; ?></h4>
            </div>
            <div class="box-footer">
              <button type="submit" name="Submitadd" value="1" class="btn btn-primary btn-lg btn-block"><?php echo Plug_Lang('确认注册'); ?></button>
            </div>
          </div>
        </form>
        <!-- /.box -->
      </div>
    </div>
  </div>
</body>

</html>