<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?>- <?php echo Plug_Lang('库卡转出'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
<style>body { background: #fff; }.kuka-wrap { padding: 16px 20px 20px; }.kuka-tip { color: #999; font-size: 12px; margin-left: 8px; }</style>
</head>
<body>
<div class="kuka-wrap">
<div class="layui-form" lay-filter="kuka-transfer">
<form action="" onsubmit="return false;" name="bsphppost" id="bsphppost" method="post">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('接收代理'); ?></label>
<div class="layui-input-block">
<div class="layui-form-mid layui-word-aux"><?php echo htmlspecialchars($user_array_agent['user_user']); ?></div>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('剩余库存'); ?></label>
<div class="layui-input-block" style="max-width: 420px;">
<select name="select">
<option value="0"><?php echo Plug_Lang('请选择制作类型。。。'); ?></option>
<?php
while ($var=Plug_Pdo_Fetch_Assoc($tmp)) {
if ($var['kuka_val'] > 0 && isset($class_array[$var['kuka_kalei']])) {
echo '<option value="' . $var['kuka_id'] . '">' . $var['app_name'] . '>' . $class_array[$var['kuka_kalei']] . '  ,' . Plug_Lang('剩余可转') . $var['kuka_val'] . Plug_Lang('张') . '</option>';
}
}
?>
</select>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo Plug_Lang('转给数量'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<input type="text" name="shu" id="shu" placeholder="<?php echo Plug_Lang('输入数量如:1'); ?>" value="1" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"><?php echo Plug_Lang('把自己卡转下级数量'); ?></div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<input type="hidden" name="appenconfig" value="1">
<button class="layui-btn layui-btn-normal" lay-submit lay-filter="kuka_transfer"><?php echo Plug_Lang('确认转出'); ?></button>
</div>
</div>
</form>
</div>
</div>
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo Plug_Get_Url_Statics() ?>style/'}).extend({index: 'lib/index'}).use(['index', 'form', 'layer'], function() {var $=layui.$, form=layui.form, layer=layui.layer;function getHostLayer() {try { if (top && top.layer) return top.layer; } catch (e) {}try { if (parent && parent.layer) return parent.layer; } catch (e2) {}return layer;}form.on('submit(kuka_transfer)', function() {layer.load(1);$.ajax({type: 'post',url: '',data: $('#bsphppost').serialize(),dataType: 'json',success: function(ret) {layer.closeAll('loading');var hostLayer=getHostLayer();hostLayer.alert(ret.msg, function(index) {hostLayer.close(index);if (String(ret.code)==='1' || Number(ret.code)===100) {try {var frameIndex=hostLayer.getFrameIndex(window.name);hostLayer.close(frameIndex);} catch (e) {}try {if (parent && parent.layui && parent.layui.table) {parent.layui.table.reload('test-table-toolbar');}} catch (e2) {}}});},error: function() {layer.closeAll('loading');layer.alert('<?php echo Plug_Lang('请求失败'); ?>');}});return false;});});</script>
</body>
</html>
