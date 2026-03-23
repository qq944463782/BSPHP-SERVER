<?php include __DIR__ . '/../_wrap_inc.php'; ?>
<?php
$wrap_mode = $wrap_mode ?? 0;
$wrap_q = isset($_GET['wrap']) ? '&wrap=' . (int)$_GET['wrap'] : '';
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="./statics/jq/query.min.js"></script>
  <title><?= htmlspecialchars($appinfo['app_sale_title'] ?? $appinfo['app_name'] ?? '充值续费') ?></title>

  <style>
    /* 基础与布局（浅色背景） */
    body {
      margin: 0;
      font-family: -apple-system, BlinkMacSystemFont, "PingFang SC", "Microsoft YaHei", sans-serif;
      background: linear-gradient(160deg, #f0f4f8 0%, #e2e8f0 50%, #f1f5f9 100%);
      color: #1e293b;
      min-height: 100vh;
      -webkit-font-smoothing: antialiased;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 24px 20px 48px;
    }

    .card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 14px 40px rgba(15, 23, 42, .16);
      padding: 24px 24px 28px;
      margin-bottom: 24px;
      border: 1px solid rgba(226, 232, 240, .9);
      transition: box-shadow .25s ease, transform .18s ease;
    }

    .card:last-of-type {
      margin-bottom: 0;
    }

    .card:hover {
      box-shadow: 0 18px 55px rgba(15, 23, 42, .20);
      transform: translateY(-1px);
    }

    .title {
      font-size: 17px;
      font-weight: 600;
      margin-bottom: 16px;
      color: #0f172a;
      letter-spacing: .02em;
      padding-bottom: 10px;
      border-bottom: 2px solid #e2e8f0;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 24px;
    }

    .brand-logo {
      width: 88px;
      height: 88px;
      border-radius: 20px;
      object-fit: cover;
      box-shadow: 0 4px 16px rgba(15, 23, 42, .12);
      border: 2px solid rgba(255, 255, 255, .9);
    }

    .brand h1 {
      font-size: 22px;
      font-weight: 700;
      color: #0f172a;
      margin: 0 0 6px 0;
      letter-spacing: .01em;
    }

    .brand-desc {
      color: #64748b;
      margin-top: 0;
      font-size: 14px;
      line-height: 1.5;
    }

    .brand-kefu {
      margin-top: 14px;
      font-size: 13px;
      color: #334155;
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      border-radius: 12px;
      padding: 14px 16px;
      border: 1px solid #e2e8f0;
      white-space: pre-line;
      line-height: 1.6;
      box-shadow: inset 0 1px 2px rgba(255, 255, 255, .5);
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 16px;
    }

    .package {
      border: 2px solid #e2e8f0;
      border-radius: 16px;
      padding: 16px;
      cursor: pointer;
      transition: all .22s ease;
      position: relative;
      display: flex;
      align-items: center;
      gap: 14px;
      background: #fafbfc;
    }

    .package input {
      position: absolute;
      opacity: 0;
      pointer-events: none;
    }

    .package:hover {
      border-color: #c7d2fe;
      background: #fff;
      box-shadow: 0 4px 16px rgba(37, 99, 235, .08);
    }

    .package.active {
      border-color: #2563eb;
      background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
      box-shadow: 0 4px 20px rgba(37, 99, 235, .15);
    }

    .package-name {
      font-weight: 600;
      font-size: 16px;
      color: #0f172a;
    }

    .package-price {
      color: #2563eb;
      font-weight: 700;
      margin-top: 6px;
      font-size: 18px;
      letter-spacing: .02em;
    }

    .package-desc {
      font-size: 13px;
      color: #64748b;
      margin-top: 6px;
      line-height: 1.45;
    }

    .package-img {
      width: 56px;
      height: 56px;
      border-radius: 12px;
      object-fit: cover;
      background: #e2e8f0;
      flex-shrink: 0;
    }

    .package-body {
      flex: 1;
      min-width: 0;
    }

    .input {
      width: 100%;
      height: 50px;
      border-radius: 14px;
      border: 1px solid #e2e8f0;
      padding: 0 18px;
      font-size: 15px;
      box-sizing: border-box;
      background: #fff;
      transition: border-color .2s, box-shadow .2s;
    }

    .input::placeholder {
      color: #94a3b8;
    }

    .input:focus {
      outline: none;
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, .15);
    }

    .pay-options {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin: 8px auto 0;
    }

    .pay {
      flex: 0 0 auto;
      min-width: 130px;
      height: 46px;
      padding: 6px 14px;
      border-radius: 12px;
      border: 2px solid #e5e7eb;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all .2s ease;
      background: #f9fafb;
      box-sizing: border-box;
    }

    .pay img {
      display: block;
      max-height: 26px;
      width: auto;
    }

    .pay.active {
      border-color: #2563eb;
      background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
      color: #2563eb;
      box-shadow: 0 2px 10px rgba(37, 99, 235, .15);
    }

    .btn {
      height: 50px;
      border: none;
      border-radius: 999px;
      background: linear-gradient(135deg, #4096ff 0%, #1677ff 50%, #0958d9 100%);
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
      box-shadow: 0 8px 18px rgba(9, 88, 217, .35);
      transition: all .2s ease;
    }

    .btn:hover {
      background: linear-gradient(135deg, #4f9dff 0%, #1677ff 50%, #0a66e0 100%);
      box-shadow: 0 10px 22px rgba(9, 88, 217, .45);
      transform: translateY(-1px);
    }

    .btn:active {
      transform: translateY(0);
      box-shadow: 0 6px 16px rgba(9, 88, 217, .35);
    }

    .feature-list {
      line-height: 1.9;
      color: #334155;
    }

    .article-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding: 10px 14px;
      margin-bottom: 10px;
      border-radius: 12px;
      background: #f9fafb;
      border: 1px solid #e5e7eb;
      text-decoration: none;
      color: #334155;
      transition: .2s;
    }

    .article-item:last-child {
      margin-bottom: 0;
    }

    .article-item:hover {
      border-color: #2563eb;
      background: #eff6ff;
      color: #1e40af;
    }

    .article-main {
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    .article-title {
      font-size: 14px;
      font-weight: 500;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
    }

    .article-meta {
      margin-top: 4px;
      font-size: 12px;
      color: #94a3b8;
    }

    .article-arrow {
      font-size: 16px;
      color: #cbd5f5;
    }

    .order-result {
      margin-top: 12px;
      padding: 14px;
      border-radius: 12px;
      display: none;
    }

    .order-result.show {
      display: block;
    }

    .success {
      background: #ecfdf5;
      color: #166534;
    }

    .pending {
      background: #fffbeb;
      color: #b45309;
    }

    .error {
      background: #fef2f2;
      color: #dc2626;
    }

    .toast {
      position: fixed;
      left: 50%;
      top: 40%;
      transform: translateX(-50%);
      padding: 10px 18px;
      border-radius: 999px;
      font-size: 14px;
      background: rgba(15, 23, 42, .95);
      color: #fff;
      z-index: 9999;
      box-shadow: 0 8px 20px rgba(15, 23, 42, .25);
      opacity: 0;
      transition: opacity .2s, transform .2s;
    }

    .toast-show {
      opacity: 1;
      transform: translateX(-50%) translateY(4px);
    }

    .toast-error {
      background: #b91c1c;
    }

    .toast-success {
      background: #15803d;
    }

    .toast-info {
      background: #0f172a;
    }

    @media(max-width:768px) {
      .brand {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>

<body class="w<?= $wrap_mode ?>">


  <div class="container">

    <?php if (!empty($err)) { ?>
      <div class="card" style="color:#dc2626;">
        <?= htmlspecialchars($err) ?>
      </div>
    <?php } elseif ($appinfo) { ?>
      <form id="renewHiddenForm" method="get" action="index.php?m=webapi&c=salecard_renew&a=do_pay" target="_blank">
        <input type="hidden" name="daihao" value="<?php echo (int)($daihao ?? 0) ?>">
        <input type="hidden" name="m" value="webapi">
        <input type="hidden" name="c" value="salecard_renew">
        <input type="hidden" name="a" value="do_pay">
        <input type="hidden" name="is_ok" value="0">
        <!-- 品牌区 -->
        <div class="card brand">
          <?php if (!empty($appinfo['app_sale_img'])) { ?>
            <img src="<?= htmlspecialchars($appinfo['app_sale_img']) ?>" class="brand-logo">
          <?php } ?>
          <div>
            <h1><?= htmlspecialchars($appinfo['app_sale_title'] ?? $appinfo['app_name']) ?></h1>
            <div class="brand-desc">
              <?= htmlspecialchars($appinfo['app_sale_desc'] ?? '专业稳定 · 高效安全 · 自动续费') ?>
            </div>
            <?php if (!empty(trim($appinfo['app_sale_kefu'] ?? ''))) { ?>
              <div class="brand-kefu">
                <?= htmlspecialchars($appinfo['app_sale_kefu']) ?>
              </div>
            <?php } ?>
          </div>
        </div>


        <input type="hidden" id="renewDaihao" value="<?= (int)($daihao ?? 0) ?>">

        <!-- 套餐 -->
        <div class="card">
          <div class="title">选择套餐</div>
          <div class="grid">
            <?php foreach ($card_list as $c) { ?>
              <label class="package">
                <input type="radio" name="carid"
                  value="<?= (int)$c['lei_id'] ?>">
                <?php if (!empty($c['lei_img'])) { ?>
                  <img src="<?= htmlspecialchars($c['lei_img']) ?>" class="package-img" alt="">
                <?php } else { ?>
                  <div class="package-img" style="display:flex;align-items:center;justify-content:center;font-size:12px;color:#9ca3af;">
                    套餐
                  </div>
                <?php } ?>
                <div class="package-body">
                  <div class="package-name">
                    <?= htmlspecialchars($c['lei_name']) ?>
                  </div>
                  <div class="package-price">
                    ¥<?= number_format($c['lei_jiage'], 2) ?>
                    / <?= (int)$c['lei_date'] ?>天
                  </div>
                  <div class="package-desc">
                    <?= htmlspecialchars($c['lei_desc'] ?? '适合个人或普通用户使用') ?>
                  </div>
                </div>
              </label>
            <?php } ?>
          </div>
        </div>

        <!-- 账号 -->
        <div class="card">
          <div class="title">充值帐户/机器码/卡号</div>
          <input type="text" id="renewUid" class="input" name="uid" value="<?= htmlspecialchars($renew_user ?? '') ?>" placeholder="请输入账号/卡号/机器码" required>
        </div>

        <!-- 支付方式 -->
        <div class="card">
          <div class="title">支付方式</div>
          <div class="pay-options">
            <?php foreach ($pay_channels as $ch) {
              $dir = htmlspecialchars($ch['dir']);
              $name = htmlspecialchars($ch['name']);
              $logo = !empty($ch['url']) ? htmlspecialchars($ch['url']) : '';
              $extraClass = ($ch['dir'] === 'wxpayv3js') ? ' pay-wxjs' : '';
            ?>
              <label class="pay<?php echo $extraClass; ?>" data-paydir="<?php echo $dir; ?>" title="<?php echo $name; ?>">
                <input type="radio" name="type"
                  value="<?php echo $dir; ?>"
                  hidden>
                <?php if ($logo) { ?>
                  <img src="<?php echo $logo; ?>" alt="<?php echo $name; ?>" title="<?php echo $name; ?>" style="height:26px;max-width:120px;">
                <?php } else { ?>
                  <span title="<?php echo $name; ?>"><?php echo $name; ?></span>
                <?php } ?>
              </label>
            <?php } ?>
          </div>
        </div>
    
        <?php if (!empty($card_list) && !empty($pay_channels)) { ?>
          <div style="margin-top:10px;margin-bottom:20px;">
            <button type="button" class="btn" id="renewSubmitBtn">立即支付</button>
          </div>
        <?php } ?>


        </form>
     <div style="margin-top:10px;">
     
     </div>


      <!-- 教程 -->
      <?php if (!empty($news_list)) { ?>
        <div class="card" style="margin-top:18px;">
          <div class="title">使用教程</div>
          <?php foreach ($news_list as $n) { ?>
            <a href="index.php?m=webapi&c=new_info&a=index&id=<?= (int)$n['news_id'] ?><?= $wrap_q ?>"
              target="_blank"
              class="article-item">
              <div class="article-main">
                <span class="article-title"><?= htmlspecialchars($n['news_table']) ?></span>
                <?php if (!empty($n['news_unix'])) { ?>
                  <span class="article-meta"><?= date('Y-m-d H:i', (int)$n['news_unix']) ?></span>
                <?php } ?>
              </div>
              <span class="article-arrow">›</span>
            </a>
          <?php } ?>
        </div>
      <?php } ?>

      <!-- 客服：按你要求，去掉“售后保障”整块 -->

      <!-- 订单查询 -->
      <div class="card">
        <div class="title">订单查询</div>
        <div style="display:flex;gap:10px;">
          <input type="text" placeholder="请输入BUYVIP开头订单查询" id="orderInput" class="input">
          <button type="button"
            class="btn"
            style="width:120px;"
            id="orderBtn">查询</button>
        </div>
        <div class="order-result" id="orderResult"></div>
      </div>

    <?php } ?>
  </div>

  <script>
    // 简单 Toast 提示
    function showToast(msg, type) {
      type = type || 'info';
      var $old = $('.toast');
      if ($old.length) {
        $old.remove();
      }
      var $el = $('<div class="toast toast-' + type + '"></div>').text(msg).appendTo('body');
      // 强制回流再加类，触发过渡
      void $el[0].offsetWidth;
      $el.addClass('toast-show');
      setTimeout(function() {
        $el.removeClass('toast-show');
        setTimeout(function() {
          $el.remove();
        }, 200);
      }, 2000);
    }

    // 兼容 jQuery 4，去掉 $.trim 依赖
    function jTrim(v) {
      if (v == null) {
        return '';
      }
      return String(v).trim();
    }

    function toggleGroup(selector, activeClass) {
      $(selector).each(function() {
        var $el = $(this);
        $el.toggleClass(activeClass, $el.find('input:checked').length > 0);
      });
    }

    $(function() {
      // 非微信环境隐藏 JSAPI 支付选项
      var ua = navigator.userAgent || '';
      var inWx = ua.indexOf('MicroMessenger') !== -1;
      if (!inWx) {
        $('.pay[data-paydir="wxpayv3js"]').hide().find('input[type="radio"]').prop('checked', false);
      }

      // 默认选中第一个套餐和第一个支付方式
      if (!$('input[name="carid"]:checked').length) {
        $('input[name="carid"]').first().prop('checked', true);
      }
      if (!$('input[name="type"]:checked').length) {
        $('input[name="type"]').first().prop('checked', true);
      }
      // 初始选中样式
      toggleGroup('.package', 'active');
      toggleGroup('.pay', 'active');

      // 选项切换
      $(document).on('change', 'input[name="carid"], input[name="type"]', function() {
        if (this.name === 'carid') toggleGroup('.package', 'active');
        if (this.name === 'type') toggleGroup('.pay', 'active');
      });

      // 提交续费：先验证（is_ok=9999），通过后再放行提交表单
      $('#renewSubmitBtn').on('click', function() {
        var $car = $('input[name="carid"]:checked');
        var uid = jTrim($('#renewUid').val());
        var $pay = $('input[name="type"]:checked');

        if (!$car.length) {
          showToast('请选择套餐', 'error');
          return;
        }
        if (!uid) {
          showToast('充值帐户/机器码/卡号', 'error');
          $('#renewUid').focus();
          return;
        }
        if (!$pay.length) {
          showToast('请选择支付方式', 'error');
          return;
        }

        // 第一步：仅验证，is_ok=9999，返回 9999 才放行
        $.ajax({
          url: 'index.php?m=webapi&c=salecard_renew&a=do_pay',
          type: 'POST',
          dataType: 'json',
          data: {
            daihao: $('#renewDaihao').val() || '',
            carid: $car.val(),
            uid: uid,
            type: $pay.val(),
            is_ok: 9999
          }
        }).done(function(d) {
          if (d && d.code === 9999) {
            $('#renewHiddenForm').submit();
            return;
          }
          showToast((d && d.msg) || '验证未通过', 'error');
        }).fail(function() {
          showToast('网络错误', 'error');
        });
      });

      // 订单查询
      $('#orderBtn').on('click', function() {
        var v = jTrim($('#orderInput').val());
        var $box = $('#orderResult');

        if (!v) {
          $box
            .removeClass('success pending')
            .addClass('order-result show error')
            .text('请输入BUYVIP开头订单号');
          return;
        }

        $box
          .removeClass('success error')
          .addClass('order-result show pending')
          .text('查询中...');

        $.ajax({
          url: 'index.php?m=webapi&c=salecard_renew&a=order_status',
          type: 'POST',
          dataType: 'json',
          data: {
            pay_id: v,
            daihao: $('#renewDaihao').val() || ''
          }
        }).done(function(d) {
          if (!d || d.code !== 0) {
            $box
              .removeClass('success pending')
              .addClass('order-result show error')
              .text((d && d.msg) || '查询失败');
            return;
          }
          if (d.status === 'paid') {
            $box
              .removeClass('pending error')
              .addClass('order-result show success')
              .html(
                '订单号：' + d.pay_id +
                '<br>状态：充值已完成' +
                '<br>金额：¥' + d.amount
              );
          } else {
            $box
              .removeClass('success error')
              .addClass('order-result show pending')
              .html(
                '订单号：' + d.pay_id +
                '<br>状态：未完成支付' +
                '<br>待支付金额：¥' + d.amount
              );
          }
        }).fail(function() {
          $box
            .removeClass('success pending')
            .addClass('order-result show error')
            .text('网络错误');
        });
      });
    });
  </script>

</body>

</html>