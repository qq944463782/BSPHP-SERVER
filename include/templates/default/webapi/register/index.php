<?php include __DIR__.'/../_wrap_inc.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title><?php echo Plug_Lang('注册账号'); ?></title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;font-size:14px;line-height:1.5;color:#333}
    body.w0{background:#f5f5f5;padding:20px}
    body.w1,body.w2{background:#fff;padding:12px}
    body.w4,body.w5{background:#fff;padding:0}
    .wrap{max-width:420px;margin:0 auto;background:#fff;overflow:hidden}
    body.w0 .wrap{border-radius:8px;box-shadow:0 2px 12px rgba(0,0,0,.08)}
    body.w1 .wrap,body.w2 .wrap{border:1px solid #eee;border-radius:4px}
    body.w4 .wrap,body.w5 .wrap{width:100%;max-width:none;margin:0;border:0;border-radius:0;box-shadow:none}
    body.w2 .hd,body.w5 .hd{display:none}
    .hd{padding:20px;border-bottom:1px solid #eee}
    .hd h1{font-size:18px;font-weight:600;color:#262626}
    .bd{padding:24px}
    .fg{margin-bottom:20px}
    .fg:last-of-type{margin-bottom:0}
    .fg label{display:block;margin-bottom:8px;font-weight:500;color:#262626}
    .fg input{width:100%;height:42px;padding:0 14px;border:1px solid #ddd;border-radius:6px;font-size:14px}
    .fg input:focus{outline:none;border-color:#1890ff}
    .msg{margin-top:16px;padding:12px;background:#fff7e6;border:1px solid #ffd591;border-radius:6px;color:#d46b08;font-size:13px}
    .msg.ok{background:#f6ffed;border-color:#b7eb8f;color:#52c41a}
    .btn{width:100%;height:44px;margin-top:24px;border:none;border-radius:6px;background:#1890ff;color:#fff;font-size:15px;font-weight:500;cursor:pointer}
    .btn:hover{background:#40a9ff}
  </style>
</head>
<body class="w<?php echo $wrap_mode; ?>">
  <div class="wrap">
    <?php if ($show_header) { ?><div class="hd"><h1><?php echo Plug_Lang('注册账号'); ?></h1></div><?php } ?>
    <form id="form1" name="form1" method="post" action="">
      <div class="bd">
        <div class="fg">
          <label><?php echo Plug_Lang('注册账号'); ?></label>
          <input name="user" value="<?php echo htmlspecialchars($user ?? ''); ?>" type="text" placeholder="<?php echo Plug_Lang('注册账号'); ?>">
        </div>
        <div class="fg">
          <label><?php echo Plug_Lang('密码'); ?></label>
          <input name="pwda" value="<?php echo htmlspecialchars($pwda ?? ''); ?>" type="password" placeholder="<?php echo Plug_Lang('密码'); ?>">
        </div>
        <div class="fg">
          <label><?php echo Plug_Lang('再次确认密码'); ?></label>
          <input name="pwdb" value="<?php echo htmlspecialchars($pwdb ?? ''); ?>" type="password" placeholder="<?php echo Plug_Lang('再次确认密码'); ?>">
        </div>
        <div class="fg">
          <label><?php echo Plug_Lang('QQ'); ?></label>
          <input name="qq" value="<?php echo htmlspecialchars($qq ?? ''); ?>" type="text" placeholder="<?php echo Plug_Lang('用于找回密码等操作'); ?>">
        </div>
        <?php if (!empty($u_from_url ?? '')) { ?>
          <!-- URL 已带邀请码时，隐藏输入框，只保留隐藏字段 -->
          <input type="hidden" name="u" value="<?php echo htmlspecialchars($u ?? ''); ?>">
        <?php } else { ?>
        <div class="fg">
          <label><?php echo Plug_Lang('邀请码'); ?></label>
          <input name="u" value="<?php echo htmlspecialchars($u ?? ''); ?>" type="text" placeholder="<?php echo Plug_Lang('请输入邀请码/推荐人账号（没有可留空）'); ?>">
        </div>
        <?php } ?>
        <div class="fg">
          <label><?php echo Plug_Lang('激活码'); ?></label>
          <input name="code_ka" value="<?php echo htmlspecialchars($code_ka ?? ''); ?>" type="text" placeholder="<?php echo Plug_Lang('激活码，联系销售或者代理购买'); ?>">
        </div>
        <?php if (!empty($log_name)) { ?><div class="msg<?php echo (strpos($log_name,'成功')!==false)?' ok':''; ?>"><?php echo htmlspecialchars($log_name); ?></div><?php } ?>
        <button type="submit" name="Submitadd" value="1" class="btn"><?php echo Plug_Lang('确认注册'); ?></button>
      </div>
    </form>
  </div>
</body>
</html>
