<?php include __DIR__.'/../_wrap_inc.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title><?php echo Plug_Lang('在线信息'); ?></title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;font-size:14px;line-height:1.5;color:#333}
    body.w0{background:#f5f5f5;padding:20px}
    body.w1,body.w2{background:#fff;padding:12px}
    body.w4,body.w5{background:#fff;padding:0}
    .wrap{max-width:900px;margin:0 auto;background:#fff;overflow:hidden}
    body.w0 .wrap{border-radius:8px;box-shadow:0 2px 12px rgba(0,0,0,.08)}
    body.w1 .wrap,body.w2 .wrap{border:1px solid #eee;border-radius:4px}
    body.w4 .wrap,body.w5 .wrap{width:100%;max-width:none;margin:0;border:0;border-radius:0;box-shadow:none}
    body.w2 .hd,body.w5 .hd{display:none}
    .hd{padding:20px;border-bottom:1px solid #eee}
    .hd h1{font-size:18px;font-weight:600;color:#262626}
    .bd{padding:20px;overflow-x:auto}
    table{width:100%;border-collapse:collapse}
    th,td{padding:12px 14px;text-align:left;border-bottom:1px solid #eee}
    th{background:#fafafa;font-weight:600;color:#262626;font-size:13px}
    td{font-size:13px}
    .tag{display:inline-block;padding:2px 8px;border-radius:4px;font-size:12px}
    .tag-id{background:#e6f7ff;color:#1890ff}
    .tag-md5{background:#f6ffed;color:#52c41a}
    .tag-time{background:#fff7e6;color:#fa8c16}
    .lnk{color:#1890ff;text-decoration:none}
    .lnk:hover{text-decoration:underline}
  </style>
</head>
<body class="w<?php echo $wrap_mode; ?>">
  <div class="wrap">
    <?php if ($show_header) { ?><div class="hd"><h1><?php echo Plug_Lang('在线信息'); ?></h1></div><?php } ?>
    <form id="form1" name="form1" method="post" action="">
      <div class="bd">
        <table>
          <thead>
            <tr>
              <th style="width:50px"><?php echo Plug_Lang('ID'); ?></th>
              <th><?php echo Plug_Lang('在线标记'); ?></th>
              <th><?php echo Plug_Lang('机器ID'); ?></th>
              <th><?php echo Plug_Lang('登录时间'); ?></th>
              <th><?php echo Plug_Lang('自动退出'); ?></th>
              <th><?php echo Plug_Lang('操作'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; while ($value = Plug_Pdo_Fetch_Assoc($param_db_array_value)) { ?>
            <tr>
              <td><span class="tag tag-id"><?php echo $i; ?></span></td>
              <td><span class="tag tag-md5"><?php echo md5($value['links_session_id']); ?></span></td>
              <td><span class="tag tag-md5"><?php echo md5($value['links_biaoji']); ?></span></td>
              <td><span class="tag tag-time"><?php echo call_my_show_Time_Day(date('Y-m-d H:i:s', $value['links_add_time'])); ?></span></td>
              <td><span class="tag tag-time"><?php echo call_my_show_Time_Day(date('Y-m-d H:i:s', $value['links_out_time'])); ?></span></td>
              <td><a class="lnk" href="index.php?m=webapi&c=links_car&a=index&daihao=<?php echo $daihao; ?>&id=<?php echo $value['links_id']; ?>&login=YES"><?php echo Plug_Lang("T出"); ?></a></td>
            </tr>
            <?php $i++; } ?>
          </tbody>
        </table>
      </div>
    </form>
  </div>
</body>
</html>
