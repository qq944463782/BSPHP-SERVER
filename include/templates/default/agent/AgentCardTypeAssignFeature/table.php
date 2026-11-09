<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name") ?>- <?php echo Plug_Lang('卡类分配'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
<style>body { background: #fff; }.assign-wrap { padding: 16px 20px 20px; }.assign-meta { color: #666; margin-bottom: 12px; }.card-type-box { max-height: 420px; overflow-y: auto; padding: 4px 0 8px; }.card-type-box .layui-form-checkbox { margin: 4px 0; display: block; }.assign-tip { color: #999; font-size: 12px; line-height: 1.6; margin: 8px 0 16px; }.assign-actions { padding-top: 4px; }</style>
</head>
<body>
<div class="assign-wrap">
<div class="assign-meta">
<?php echo Plug_Lang('下级代理'); ?>：
<strong><?php echo htmlspecialchars($user_array_agent['user_user']); ?></strong>
(UID:<?php echo (int)$user_array_agent['user_uid']; ?>)
</div>
<div class="layui-form" lay-filter="card-type-assign">
<form action="" onsubmit="return false;" name="bsphppost" id="bsphppost" method="post">
<input type="hidden" name="ids" value="<?php echo (int)$user_array_agent['user_uid']; ?>">
<input type="hidden" name="user_anget_carid" id="user_anget_carid" value="">
<?php if (!empty($parent_has_all)) { ?>
<input type="checkbox" name="show_all" id="show_all" value="1" lay-skin="primary" lay-filter="show_all" title="<?php echo Plug_Lang('默认全部显示'); ?>" <?php echo !empty($sub_all) ? 'checked' : ''; ?>>
<?php } ?>
<div class="card-type-box" id="card-type-list">
<?php
if (empty($card_list)) {
echo '<div class="layui-word-aux">' . Plug_Lang('你当前没有可分配的卡类，请联系上级分配。') . '</div>';
} else {
foreach ($card_list as $item) {
$checked=!empty($item['checked']) ? 'checked' : '';
$title=htmlspecialchars($item['app_name'] . '-' . $item['lei_name']);
echo "<input type='checkbox' name='cardid' value='{$item['lei_id']}' lay-skin='primary' title='{$title}' {$checked}><br />";
}
}
?>
</div>
<div class="assign-tip">
<?php echo Plug_Lang('说明:只能把你自己拥有的卡类权限分给下级；中途取消某卡类后，下级需重新保存才会同步取消。'); ?>
</div>
<div class="assign-actions">
<input type="hidden" name="appenconfig" value="1">
<button class="layui-btn layui-btn-normal" lay-submit lay-filter="card_type_save"><?php echo Plug_Lang('确认分配'); ?></button>
</div>
</form>
</div>
</div>
<script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
<script>layui.config({base: '<?php echo Plug_Get_Url_Statics() ?>style/'}).extend({index: 'lib/index'}).use(['index', 'form', 'layer'], function() {var $=layui.$, form=layui.form, layer=layui.layer;function getHostLayer() {try { if (top && top.layer) return top.layer; } catch (e) {}try { if (parent && parent.layer) return parent.layer; } catch (e2) {}return layer;}function syncCardListDisabled() {var allChecked=$('#show_all').length && $('#show_all').prop('checked');$('#card-type-list input[name="cardid"]').each(function() {$(this).prop('disabled', !!allChecked);});form.render('checkbox');}syncCardListDisabled();form.on('checkbox(show_all)', function() {syncCardListDisabled();});form.on('submit(card_type_save)', function() {var showAll=($('#show_all').length && $('#show_all').prop('checked')) ? 1 : 0;var ids='';if (!showAll) {$('input[name="cardid"]:checked').each(function() {ids +=$(this).val() + ',';});ids +='0';}$('#user_anget_carid').val(ids);layer.load(1);$.ajax({type: 'post',url: '',data: {appenconfig: 1,ids: $('input[name="ids"]').val(),show_all: showAll,user_anget_carid: $('#user_anget_carid').val()},dataType: 'json',success: function(ret) {layer.closeAll('loading');var hostLayer=getHostLayer();hostLayer.alert(ret.msg, function(index) {hostLayer.close(index);if (String(ret.code)==='1' || Number(ret.code)===100) {try {var frameIndex=hostLayer.getFrameIndex(window.name);hostLayer.close(frameIndex);} catch (e) {}try {if (parent && parent.layui && parent.layui.table) {parent.layui.table.reload('test-table-toolbar');}} catch (e2) {}}});},error: function() {layer.closeAll('loading');layer.alert('<?php echo Plug_Lang('请求失败'); ?>');}});return false;});});</script>
</body>
</html>
