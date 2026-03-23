<?php include __DIR__.'/../_wrap_inc.php'; ?>
<?php
$sys_name = class_exists('bs_lib') ? (bs_lib::get_configs_value('sys','name') ?: '') : '';
$news_date = isset($news_array['news_unix']) ? date('Y-m-d H:i', (int)$news_array['news_unix']) : '';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title><?php echo htmlspecialchars($news_array['news_table']); ?></title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:-apple-system,BlinkMacSystemFont,"PingFang SC","Helvetica Neue",STHeiti,"Microsoft Yahei",sans-serif;font-size:17px;line-height:1.8;color:#333;background:#f7f7f7;padding:0}
    body.w0{background:#f7f7f7}
    body.w1,body.w2,body.w4,body.w5{background:#fff}
    .wrap{max-width:667px;margin:0 auto;background:#fff;overflow:hidden;min-height:100vh}
    body.w0 .wrap{margin-top:12px;margin-bottom:12px;border-radius:4px;box-shadow:0 1px 3px rgba(0,0,0,.06)}
    body.w1 .wrap,body.w2 .wrap{border:1px solid #e7e7eb}
    body.w4 .wrap,body.w5 .wrap{max-width:100%;border:none;box-shadow:none}
    body.w2 .hd,body.w5 .hd{display:none}
    /* 公众号风格头部 */
    .hd{padding:24px 20px 20px;text-align:center;border-bottom:1px solid #e7e7eb}
    .hd .title{font-size:22px;font-weight:600;color:#191919;line-height:1.4;margin-bottom:16px;letter-spacing:.5px}
    .hd .meta{font-size:13px;color:#8c8c8c}
    .hd .meta .author{margin-right:12px}
    .bd{padding:20px 20px 40px}
    .nav{font-size:14px;color:#8c8c8c;margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid #f0f0f0}
    .nav a{color:#576b95;text-decoration:none}
    .nav a:hover{text-decoration:underline}
    .nav span{margin:0 8px;color:#d9d9d9}
    /* 正文 - 公众号风格 */
    .art{font-size:17px;line-height:1.9;color:#3e3e3e;word-wrap:break-word}
    .art p{margin-bottom:16px;text-indent:0}
    .art img{max-width:100%!important;height:auto!important;display:block;margin:12px auto}
    .art a{color:#576b95;text-decoration:none}
    .art a:hover{text-decoration:underline}
    .art blockquote{margin:16px 0;padding:12px 16px;border-left:3px solid #e7e7eb;background:#f7f7f7;color:#595959}
    .art h1,.art h2,.art h3{font-weight:600;margin:24px 0 12px;color:#191919}
    .art ul,.art ol{margin:12px 0;padding-left:24px}
  </style>
</head>
<body class="w<?php echo $wrap_mode; ?>">
  <div class="wrap">
    <?php if ($show_header) { ?>
    <div class="hd">
      <h1 class="title"><?php echo htmlspecialchars($news_array['news_table']); ?></h1>
      <div class="meta">
        <?php if ($sys_name) { ?><span class="author"><?php echo htmlspecialchars($sys_name); ?></span><?php } ?>
        <span><?php echo htmlspecialchars($news_date); ?></span>
      </div>
    </div>
    <?php } ?>
    <div class="bd">
      <div class="nav">
        <a href="index.php?m=webapi&c=new_list&a=index<?php if(isset($_GET['wrap']))echo '&wrap='.(int)$_GET['wrap']; ?>"><?php echo Plug_Lang('列表'); ?></a>
        <span>&gt;</span>
        <a href="index.php?m=webapi&c=new_list&a=index&list=<?php echo $news_class_array['class_id']; ?><?php if(isset($_GET['wrap']))echo '&wrap='.(int)$_GET['wrap']; ?>"><?php echo htmlspecialchars($news_class_array['class_name']); ?></a>
        <span>&gt;</span>
        <span><?php echo htmlspecialchars($news_array['news_table']); ?></span>
      </div>
      <div class="art"><?php echo $news_test; ?></div>
    </div>
  </div>
</body>
</html>
