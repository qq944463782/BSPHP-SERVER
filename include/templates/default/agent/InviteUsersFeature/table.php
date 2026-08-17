<?php
$uid = (int)$this->user_array['user_uid'];
$host = rtrim((string)Plug_Get_Configs_Value('sys', 'url'), '/');
if ($host == '') {
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
  $hostName = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '127.0.0.1:8000';
  $host = rtrim($scheme . $hostName, '/');
}
$links = array(
  array(
    'title' => '推广注册链接',
    'desc'  => 'WEB页面注册（无需激活码）',
    'url'   => $host . '/index.php?m=webapi&c=register_free&a=index&u=' . $uid
  ),
  array(
    'title' => '销售卡1',
    'desc'  => 'WEB页面直接充值续费',
    'url'   => $host . '/index.php?m=webapi&c=salecard_renew&a=list&u=' . $uid
  ),
  array(
    'title' => '销售卡2',
    'desc'  => 'WEB页面购买卡类充值',
    'url'   => $host . '/index.php?m=webapi&c=salecard_gencard&a=list&u=' . $uid
  ),
  array(
    'title' => '销售卡3',
    'desc'  => 'WEB页面购买预制卡充值',
    'url'   => $host . '/index.php?m=webapi&c=salecard_salecard&a=list&u=' . $uid
  ),
);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?> - <?php echo Plug_Lang('邀请推广用户'); ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
  <style>
    .invite-link-box { margin-bottom: 14px; border: 1px solid #f0f0f0; border-radius: 8px; }
    .invite-link-title { font-weight: 600; margin-bottom: 6px; }
    .invite-link-desc { color: #666; margin-bottom: 10px; }
    .invite-link-url { word-break: break-all; color: #1e9fff; margin-bottom: 10px; }
  </style>
</head>
<body>
<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-header"><?php echo Plug_Lang('邀请推广链接'); ?></div>
        <div class="layui-card-body">
          <?php foreach ($links as $item) { ?>
            <div class="layui-card invite-link-box">
              <div class="layui-card-body">
                <div class="invite-link-title"><?php echo $item['title']; ?></div>
                <div class="invite-link-desc"><?php echo $item['desc']; ?></div>
                <div class="invite-link-url" id="url_<?php echo md5($item['title']); ?>"><?php echo htmlspecialchars($item['url']); ?></div>
                <button class="layui-btn layui-btn-sm layui-btn-normal" onclick="copyText('url_<?php echo md5($item['title']); ?>')"><?php echo Plug_Lang('复制链接'); ?></button>
                <a class="layui-btn layui-btn-sm" href="<?php echo htmlspecialchars($item['url']); ?>" target="_blank"><?php echo Plug_Lang('打开链接'); ?></a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>
layui.config({ base: '<?php echo Plug_Get_Url_Statics() ?>style/' }).extend({ index: 'lib/index' })
.use(['jquery', 'index', 'layer'], function() {
  var layer = layui.layer;
  window.copyText = function(id) {
    var el = document.getElementById(id);
    var txt = el ? (el.textContent || el.innerText) : '';
    if (!txt) return;
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(txt).then(function () {
        layer.msg('<?php echo Plug_Lang('复制成功'); ?>');
      }, function () {
        fallbackCopy(txt);
      });
    } else {
      fallbackCopy(txt);
    }
  };
  function fallbackCopy(txt) {
    var input = document.createElement('textarea');
    input.value = txt;
    document.body.appendChild(input);
    input.select();
    try { document.execCommand('copy'); } catch (e) {}
    document.body.removeChild(input);
    layer.msg('<?php echo Plug_Lang('复制成功'); ?>');
  }
});
</script>
</body>
</html>
