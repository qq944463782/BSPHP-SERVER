<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo Plug_Lang('充值'); ?></title>
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
  <div style="max-width: 800px;margin:0 auto;" class="">
    <div class=".col-xs-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo Plug_Lang('续费充值'); ?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form id="form1" name="form1" method="post" action="">
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputPassword1"><?php echo Plug_Lang('充值账号'); ?></label>
              <div class="input-group">
                <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                <input class="form-control" name="user_user" value="<?php echo $user_user; ?>" type="test" placeholder="<?php echo Plug_Lang('充值账号'); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1"><?php echo Plug_Lang('充值卡号'); ?></label>
              <div class="input-group">
                <div class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></div>
                <input class="form-control" name="ka_name" value="<?php echo $ka_name; ?>" type="test" placeholder="<?php echo Plug_Lang('充值卡卡号'); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1"><?php echo Plug_Lang('充值卡密码'); ?></label>
              <div class="input-group">
                <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                <input class="form-control" name="ka_pwd" value="<?php echo $ka_pwd; ?>" type="test" placeholder="充值卡密码,没有可空">
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-body">
              <h4><?php echo $log_name; ?></h4>
            </div>
            <div class="box-footer">
              <button type="submit" name="Submitadd" value="1" class="btn btn-primary btn-lg btn-block"><?php echo Plug_Lang('确认充值'); ?></button>
            </div>
          </div>
        </form>
        <!-- /.box -->
      </div>
    </div>
  </div>
</body>

</html>