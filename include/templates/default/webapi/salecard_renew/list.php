<?php include __DIR__ . '/../_wrap_inc.php'; ?>
<?php $sys_url = $sys_url ?? bs_lib::get_configs_value('sys','url'); ?>
<?php $u = isset($_GET['u']) ? trim((string)$_GET['u']) : ''; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo Plug_Lang('全部软件 - 续费入口'); ?></title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:-apple-system,BlinkMacSystemFont,"PingFang SC",sans-serif;font-size:15px;line-height:1.6;color:#333;background:#f5f5f5;padding:16px}
    .wrap{max-width:680px;margin:0 auto}
    .hd{padding:20px 0;border-bottom:1px solid #e8e8e8;margin-bottom:20px}
    .hd h1{font-size:22px;font-weight:600;color:#191919}
    .hd p{margin-top:6px;font-size:13px;color:#888}
    .app-list{display:flex;flex-direction:column;gap:16px}
    .app-item{display:flex;align-items:center;padding:16px;background:#fff;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,.08);text-decoration:none;color:inherit}
    .app-item:hover{box-shadow:0 2px 12px rgba(0,0,0,.12)}
    .app-img{width:80px;height:80px;object-fit:cover;border-radius:6px;flex-shrink:0;background:#f0f0f0}
    .app-info{flex:1;margin-left:16px}
    .app-name{font-size:17px;font-weight:600;margin-bottom:4px}
    .app-desc{font-size:13px;color:#666;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;text-overflow:ellipsis}
    .app-tag{display:inline-block;margin-top:6px;padding:2px 8px;border-radius:999px;font-size:12px;background:#eff6ff;color:#1d4ed8}
    .app-arrow{color:#999;font-size:20px}
  </style>
</head>
<body class="w<?php echo $wrap_mode; ?>">
  <div class="wrap">
    <div class="hd">
      <h1><?php echo Plug_Lang('全部软件 - 续费入口'); ?></h1>
      <p><?php echo Plug_Lang('选择软件后进入续费页面，支持直接充值续期。'); ?></p>
    </div>
    <div class="app-list">
      <?php if (empty($app_list)) { ?>
        <p style="color:#999;padding:40px 0;text-align:center"><?php echo Plug_Lang('暂无参与销售的软件'); ?></p>
      <?php } else {
        foreach ($app_list as $a) {
          $detail_url = 'index.php?m=webapi&c=salecard_renew&a=index&daihao=' . (int)$a['app_daihao'];
          if ($u !== '') {
            $detail_url .= '&u=' . urlencode($u);
          }
          $img_src = !empty($a['app_sale_img']) ? htmlspecialchars($a['app_sale_img']) : 'statics/default/admin/img/nopic.png';
      ?>
      <a class="app-item" href="<?php echo htmlspecialchars($detail_url); ?>">
        <img class="app-img" src="<?php echo $img_src; ?>" alt="">
        <div class="app-info">
          <div class="app-name"><?php echo htmlspecialchars($a['app_sale_title'] ?: $a['app_name']); ?></div>
          <?php if (!empty($a['app_sale_desc'])) { $d=strip_tags($a['app_sale_desc']); ?><div class="app-desc" title="<?php echo htmlspecialchars($d); ?>"><?php echo htmlspecialchars($d); ?></div><?php } ?>
          <span class="app-tag"><?php echo Plug_Lang('续费入口'); ?></span>
        </div>
        <span class="app-arrow">›</span>
      </a>
      <?php }
      } ?>
    </div>
  </div>
</body>
</html>

