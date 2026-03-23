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
  <title><?= htmlspecialchars($appinfo['app_sale_title'] ?? $appinfo['app_name'] ?? '购买卡密') ?></title>

  <style>
    body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "PingFang SC", "Microsoft YaHei", sans-serif; background: linear-gradient(160deg, #f0f4f8 0%, #e2e8f0 50%, #f1f5f9 100%); color: #1e293b; min-height: 100vh; -webkit-font-smoothing: antialiased; }
    .container { max-width: 1000px; margin: 0 auto; padding: 28px 20px 48px; }
    .card { background: #fff; border-radius: 20px; box-shadow: 0 4px 24px rgba(15, 23, 42, .08), 0 1px 3px rgba(15, 23, 42, .04); padding: 28px; margin-bottom: 24px; border: 1px solid rgba(226, 232, 240, .8); transition: box-shadow .25s ease; }
    .card:last-of-type { margin-bottom: 0; }
    .card:hover { box-shadow: 0 8px 32px rgba(15, 23, 42, .1), 0 2px 6px rgba(15, 23, 42, .06); }
    .title { font-size: 17px; font-weight: 600; margin-bottom: 16px; color: #0f172a; letter-spacing: .02em; padding-bottom: 10px; border-bottom: 2px solid #e2e8f0; }
    .brand { display: flex; align-items: center; gap: 24px; }
    .brand-logo { width: 88px; height: 88px; border-radius: 20px; object-fit: cover; box-shadow: 0 4px 16px rgba(15, 23, 42, .12); border: 2px solid rgba(255, 255, 255, .9); }
    .brand h1 { font-size: 22px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0; letter-spacing: .01em; }
    .brand-desc { color: #64748b; margin-top: 0; font-size: 14px; line-height: 1.5; }
    .brand-kefu { margin-top: 14px; font-size: 13px; color: #334155; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 12px; padding: 14px 16px; border: 1px solid #e2e8f0; white-space: pre-line; line-height: 1.6; }
    .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
    .package { border: 2px solid #e2e8f0; border-radius: 16px; padding: 16px; cursor: pointer; transition: all .22s ease; position: relative; display: flex; align-items: center; gap: 14px; background: #fafbfc; }
    .package input { position: absolute; opacity: 0; pointer-events: none; }
    .package:hover { border-color: #c7d2fe; background: #fff; box-shadow: 0 4px 16px rgba(37, 99, 235, .08); }
    .package.active { border-color: #2563eb; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); box-shadow: 0 4px 20px rgba(37, 99, 235, .15); }
    .package-name { font-weight: 600; font-size: 16px; color: #0f172a; }
    .package-price { color: #2563eb; font-weight: 700; margin-top: 6px; font-size: 18px; letter-spacing: .02em; }
    .package-desc { font-size: 13px; color: #64748b; margin-top: 6px; line-height: 1.45; }
    .package-img { width: 56px; height: 56px; border-radius: 12px; object-fit: cover; background: #e2e8f0; flex-shrink: 0; }
    .package-body { flex: 1; min-width: 0; }
    .input { width: 100%; height: 50px; border-radius: 14px; border: 1px solid #e2e8f0; padding: 0 18px; font-size: 15px; box-sizing: border-box; background: #fff; transition: border-color .2s, box-shadow .2s; }
    .input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, .15); }
    .pay-options { display: flex; flex-wrap: wrap; gap: 12px; margin: 8px auto 0; }
    .pay { flex: 0 0 auto; min-width: 130px; height: 46px; padding: 6px 14px; border-radius: 12px; border: 2px solid #e5e7eb; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s ease; background: #f9fafb; box-sizing: border-box; }
    .pay img { display: block; max-height: 26px; width: auto; }
    .pay.active { border-color: #2563eb; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); color: #2563eb; box-shadow: 0 2px 10px rgba(37, 99, 235, .15); }
    .btn { height: 50px; border: none; border-radius: 12px; background: #2563eb; color: #fff; font-weight: 600; cursor: pointer; width: 100%; font-size: 16px; transition: .2s; }
    .btn:hover { background: #1e4ed8; }
    .article-item { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 10px 14px; margin-bottom: 10px; border-radius: 12px; background: #f9fafb; border: 1px solid #e5e7eb; text-decoration: none; color: #334155; transition: .2s; }
    .article-item:hover { border-color: #2563eb; background: #eff6ff; color: #1e40af; }
    .article-main { flex: 1; min-width: 0; overflow: hidden; }
    .article-title { font-size: 14px; font-weight: 500; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; display: block; }
    .article-meta { margin-top: 4px; font-size: 12px; color: #94a3b8; }
    .article-arrow { font-size: 16px; color: #cbd5f5; flex-shrink: 0; }
    .order-result { margin-top: 12px; padding: 14px; border-radius: 12px; display: none; }
    .order-result.show { display: block; }
    .success { background: #ecfdf5; color: #166534; }
    .pending { background: #fffbeb; color: #b45309; }
    .error { background: #fef2f2; color: #dc2626; }
    .card-info { margin-top: 12px; padding: 12px; background: #f0fdf4; border-radius: 10px; font-size: 14px; }
    .card-info p { margin: 6px 0; }
    .price-summary { font-size: 15px; color: #0f172a; font-weight: 500; }
    .price-summary .unit { color: #64748b; font-weight: 400; }
    .price-summary .total { color: #2563eb; font-weight: 700; font-size: 17px; }
    .toast { position: fixed; left: 50%; top: 40%; transform: translateX(-50%); padding: 10px 18px; border-radius: 999px; font-size: 14px; background: rgba(15, 23, 42, .95); color: #fff; z-index: 9999; box-shadow: 0 8px 20px rgba(15, 23, 42, .25); opacity: 0; transition: opacity .2s, transform .2s; }
    .toast-show { opacity: 1; transform: translateX(-50%) translateY(4px); }
    .toast-error { background: #b91c1c; }
    @media(max-width:768px) { .brand { flex-direction: column; align-items: flex-start; } }
  </style>
</head>

<body class="w<?= $wrap_mode ?>">
  <div class="container">

    <?php if (!empty($err)) { ?>
      <div class="card" style="color:#dc2626;"><?= htmlspecialchars($err) ?></div>
    <?php } elseif ($appinfo) { ?>
      <form id="gencardForm" method="get" action="index.php?m=webapi&c=salecard_gencard&a=do_pay" target="_blank">
        <input type="hidden" name="daihao" value="<?= (int)($daihao ?? 0) ?>">
        <input type="hidden" name="m" value="webapi">
        <input type="hidden" name="c" value="salecard_gencard">
        <input type="hidden" name="a" value="do_pay">
        <input type="hidden" name="is_ok" value="0">
        <div class="card brand">
          <?php if (!empty($appinfo['app_sale_img'])) { ?>
            <img src="<?= htmlspecialchars($appinfo['app_sale_img']) ?>" class="brand-logo">
          <?php } ?>
          <div>
            <h1><?= htmlspecialchars($appinfo['app_sale_title'] ?? $appinfo['app_name']) ?></h1>
            <div class="brand-desc"><?= htmlspecialchars($appinfo['app_sale_desc'] ?? '购买即生成卡密 · 支付成功后凭订单号查询') ?></div>
            <?php if (!empty(trim($appinfo['app_sale_kefu'] ?? ''))) { ?>
              <div class="brand-kefu"><?= htmlspecialchars($appinfo['app_sale_kefu']) ?></div>
            <?php } ?>
          </div>
        </div>

        <input type="hidden" id="gencardDaihao" value="<?= (int)($daihao ?? 0) ?>">

        <div class="card">
          <div class="title">选择卡类</div>
          <div class="grid">
            <?php
            $card_list = isset($card_list) ? $card_list : array();
            foreach ($card_list as $c) {
            ?>
              <label class="package" data-jiage="<?= (float)$c['lei_jiage'] ?>" data-name="<?= htmlspecialchars($c['lei_name']) ?>">
                <input type="radio" name="carid" value="<?= (int)$c['lei_id'] ?>">
                <?php if (!empty($c['lei_img'])) { ?>
                  <img src="<?= htmlspecialchars($c['lei_img']) ?>" class="package-img" alt="">
                <?php } else { ?>
                  <div class="package-img" style="display:flex;align-items:center;justify-content:center;font-size:12px;color:#9ca3af;">卡类</div>
                <?php } ?>
                <div class="package-body">
                  <div class="package-name"><?= htmlspecialchars($c['lei_name']) ?></div>
                  <div class="package-price">¥<?= number_format($c['lei_jiage'], 2) ?> / <?= (int)$c['lei_date'] ?>天</div>
                  <div class="package-desc"><?= htmlspecialchars(isset($c['lei_desc']) ? $c['lei_desc'] : '购买后即时生成卡密') ?></div>
                </div>
              </label>
            <?php } ?>
          </div>
          <?php if (empty($card_list)) { ?>
            <p style="color:#64748b;margin:12px 0 0;font-size:14px;">暂无可用卡类，请先在后台为该软件添加卡类（卡类价格≥0 才会显示）。</p>
          <?php } ?>
        </div>

        <div class="card">
          <div class="title">购买数量</div>
          <div style="display:flex;flex-wrap:wrap;align-items:center;gap:16px;">
            <input type="number" name="shuliang" id="gencardShuliang" class="input" min="1" max="99" value="1" style="max-width:100px;" placeholder="1">
            <div id="gencardPriceInfo" class="price-summary">请先选择卡类</div>
          </div>
          <p style="color:#64748b;margin:8px 0 0;font-size:13px;">同一卡类可一次购买 1～99 张，支付后按数量生成卡密。</p>
        </div>

        <div class="card">
          <div class="title">支付方式</div>
          <div class="pay-options">
            <?php foreach ($pay_channels as $ch) {
              $dir = htmlspecialchars($ch['dir']);
              $name = htmlspecialchars($ch['name']);
              $logo = !empty($ch['url']) ? htmlspecialchars($ch['url']) : '';
              $extraClass = ($ch['dir'] === 'wxpayv3js') ? ' pay-wxjs' : '';
            ?>
              <label class="pay<?= $extraClass ?>" data-paydir="<?= $dir ?>" title="<?= $name ?>">
                <input type="radio" name="type" value="<?= $dir ?>" hidden>
                <?php if ($logo) { ?>
                  <img src="<?= $logo ?>" alt="<?= $name ?>" title="<?= $name ?>" style="height:26px;max-width:120px;">
                <?php } else { ?>
                  <span title="<?= $name ?>"><?= $name ?></span>
                <?php } ?>
              </label>
            <?php } ?>
          </div>
        </div>

        <?php if (!empty($card_list) && !empty($pay_channels)) { ?>
          <div style="margin-top:10px;">
            <button type="button" class="btn" id="gencardSubmitBtn">立即购买并生成卡密</button>
          </div>
        <?php } ?>
      </form>

      <div class="card" style="margin-top:18px;">
        <div class="title">订单/卡密查询</div>
        <div style="display:flex;gap:10px;">
          <input type="text" placeholder="请输入SALEGEN开头订单号查询" id="orderInput" class="input">
          <button type="button" class="btn" style="width:120px;" id="orderBtn">查询</button>
        </div>
        <div class="order-result" id="orderResult"></div>
      </div>

      <?php if (!empty($news_list)) { ?>
        <div class="card">
          <div class="title">使用教程</div>
          <?php foreach ($news_list as $n) { ?>
            <a href="index.php?m=webapi&c=new_info&a=index&id=<?= (int)$n['news_id'] ?><?= $wrap_q ?>" target="_blank" class="article-item">
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
    <?php } ?>
  </div>

  <script>
    function showToast(msg, type) {
      type = type || 'info';
      var $old = $('.toast');
      if ($old.length) $old.remove();
      var $el = $('<div class="toast toast-' + (type === 'error' ? 'error' : 'info') + '"></div>').text(msg).appendTo('body');
      void $el[0].offsetWidth;
      $el.addClass('toast-show');
      setTimeout(function() { $el.removeClass('toast-show'); setTimeout(function() { $el.remove(); }, 200); }, 2000);
    }
    function jTrim(v) { return v == null ? '' : String(v).trim(); }
    function toggleGroup(selector, activeClass) {
      $(selector).each(function() { $(this).toggleClass(activeClass, $(this).find('input:checked').length > 0); });
    }

    $(function() {
      var ua = navigator.userAgent || '';
      if (ua.indexOf('MicroMessenger') === -1) {
        $('.pay[data-paydir="wxpayv3js"]').hide().find('input[type="radio"]').prop('checked', false);
      }
      if (!$('input[name="carid"]:checked').length) $('input[name="carid"]').first().prop('checked', true);
      if (!$('input[name="type"]:checked').length) $('input[name="type"]').first().prop('checked', true);
      toggleGroup('.package', 'active');
      toggleGroup('.pay', 'active');
      $(document).on('change', 'input[name="carid"], input[name="type"]', function() {
        if (this.name === 'carid') { toggleGroup('.package', 'active'); updatePriceSummary(); }
        if (this.name === 'type') toggleGroup('.pay', 'active');
      });

      function updatePriceSummary() {
        var $sel = $('input[name="carid"]:checked').closest('.package');
        var $num = $('#gencardShuliang');
        var qty = parseInt($num.val(), 10) || 1;
        if (qty < 1) qty = 1;
        if (qty > 99) qty = 99;
        $num.val(qty);
        var $box = $('#gencardPriceInfo');
        if (!$sel.length) {
          $box.text('请先选择卡类').removeClass('total');
          return;
        }
        var jiage = parseFloat($sel.data('jiage')) || 0;
        var name = $sel.data('name') || '';
        var total = (jiage * qty).toFixed(2);
        var namePart = name ? name + ' ' : '';
        $box.html('<span class="unit">' + namePart + '单价 ¥' + jiage.toFixed(2) + ' × ' + qty + ' 张</span> = <span class="total">合计 ¥' + total + '</span>');
      }
      $('#gencardShuliang').on('input change', function() { updatePriceSummary(); });
      updatePriceSummary();

      $('#gencardSubmitBtn').on('click', function() {
        var $car = $('input[name="carid"]:checked');
        var $pay = $('input[name="type"]:checked');
        var shu = parseInt($('#gencardShuliang').val(), 10) || 1;
        if (shu < 1) shu = 1;
        if (shu > 99) shu = 99;
        $('#gencardShuliang').val(shu);
        if (!$car.length) { showToast('请选择卡类', 'error'); return; }
        if (!$pay.length) { showToast('请选择支付方式', 'error'); return; }
        $.ajax({
          url: 'index.php?m=webapi&c=salecard_gencard&a=do_pay',
          type: 'POST',
          dataType: 'json',
          data: { daihao: $('#gencardDaihao').val() || '', carid: $car.val(), type: $pay.val(), shuliang: shu, is_ok: 9999 }
        }).done(function(d) {
          if (d && d.code === 9999) {
            $('#gencardForm').submit();
            return;
          }
          showToast((d && d.msg) || '验证未通过', 'error');
        }).fail(function() { showToast('网络错误', 'error'); });
      });

      $('#orderBtn').on('click', function() {
        var v = jTrim($('#orderInput').val());
        var $box = $('#orderResult');
        if (!v) {
          $box.removeClass('success pending').addClass('order-result show error').text('请输入SALEGEN开头订单号');
          return;
        }
        $box.removeClass('success error').addClass('order-result show pending').text('查询中...');
        $.ajax({
          url: 'index.php?m=webapi&c=salecard_gencard&a=order_status',
          type: 'POST',
          dataType: 'json',
          data: { pay_id: v, daihao: $('#gencardDaihao').val() || '' }
        }).done(function(d) {
          if (!d || d.code !== 0) {
            $box.removeClass('success pending').addClass('order-result show error').text((d && d.msg) || '查询失败');
            return;
          }
          if (d.status === 'paid') {
            var qty = (d.quantity !== undefined) ? d.quantity : 1;
            var html = '订单号：' + d.pay_id + '<br>状态：已支付，已发卡<br>数量：' + qty + ' 张<br>金额：¥' + d.amount;
            if (d.has_card && d.cards && d.cards.length) {
              for (var i = 0; i < d.cards.length; i++) {
                var c = d.cards[i];
                html += '<div class="card-info">';
                if (d.cards.length > 1) html += '<p><strong>第' + (i + 1) + '张</strong></p>';
                html += '<p><strong>卡号：</strong>' + (c.car_name || '') + '</p><p><strong>卡密：</strong>' + (c.car_pwd || '') + '</p><p><strong>套餐：</strong>' + (c.lei_name || '') + '</p><p><strong>到期：</strong>' + (c.car_reDATE || '') + '</p></div>';
              }
              html += '<a href="index.php?m=webapi&c=salecard_gencard&a=show_card&order=' + encodeURIComponent(d.pay_id) + '" target="_blank" style="color:#2563eb;">单独打开查看卡密</a>';
            } else if (d.has_card && d.card) {
              html += '<div class="card-info"><p><strong>卡号：</strong>' + (d.card.car_name || '') + '</p><p><strong>卡密：</strong>' + (d.card.car_pwd || '') + '</p><p><strong>套餐：</strong>' + (d.card.lei_name || '') + '</p><p><strong>到期：</strong>' + (d.card.car_reDATE || '') + '</p>';
              html += '<a href="index.php?m=webapi&c=salecard_gencard&a=show_card&order=' + encodeURIComponent(d.pay_id) + '" target="_blank" style="color:#2563eb;">单独打开查看卡密</a></div>';
            }
            $box.removeClass('pending error').addClass('order-result show success').html(html);
          } else {
            $box.removeClass('success error').addClass('order-result show pending').html('订单号：' + d.pay_id + '<br>状态：未支付<br>待支付金额：¥' + d.amount);
          }
        }).fail(function() {
          $box.removeClass('success pending').addClass('order-result show error').text('网络错误');
        });
      });
    });
  </script>
</body>
</html>
