<?php
$field_key=$����������������������������������������������������������������['field_key'] ?? '';
$field_type=$����������������������������������������������������������������['field_type'] ?? 'input';
$field_val=$����������������������������������������������������������������['field_val'] ?? '';
$field_options=$����������������������������������������������������������������['field_options'] ?? '';
$exist_id=(int)($����������������������������������������������������������������['id'] ?? 0);
$field_key_esc=htmlspecialchars($field_key, ENT_QUOTES, 'UTF-8');
$field_val_esc=htmlspecialchars($field_val, ENT_QUOTES, 'UTF-8');
$display_val=$field_val_esc;
if ($field_type==='code_textarea' && $field_val !=='') {
$decoded=@base64_decode($field_val, true);
if ($decoded !==false) {
$display_val=htmlspecialchars($decoded, ENT_QUOTES, 'UTF-8');
}
}
$select_options=array();
if ($field_type==='select' && $field_options !=='') {
$tmp=@json_decode($field_options, true);
if (is_array($tmp)) {
$select_options=$tmp;
} else {
$select_options=array_filter(array_map('trim', explode("\n", $field_options)));
}
}
?>
<!DOCTYPE html>
<html style="background-color: #ffffff;">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
</head>
<body style="padding:16px;background:#fff;">
<form class="layui-form" id="bsphpCustomConfigValForm" lay-filter="cc_edit_val_form">
<input type="hidden" name="id" value="<?php echo intval($��������������������������������������������������������������������������������); ?>">
<input type="hidden" name="exist_id" value="<?php echo $exist_id; ?>">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('字段key'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<span class="layui-form-mid" style="padding-left:0;"><?php echo $field_key_esc; ?></span>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('当前值'); ?></label>
<div class="layui-input-inline" style="width:calc(100% - 130px);">
<?php if ($field_type==='textarea'): ?>
<textarea name="field_val" class="layui-textarea" rows="18"><?php echo $field_val_esc; ?></textarea>
<?php elseif ($field_type==='code_textarea'): ?>
<input type="hidden" name="field_val" id="ccFieldValHidden">
<textarea id="ccCodeTextarea" class="layui-textarea" rows="18" style="font-family:monospace;font-size:13px;"><?php echo $display_val; ?></textarea>
<?php elseif ($field_type==='select'): ?>
<select name="field_val" lay-filter="cc_field_val" lay-verify="">
<option value=""><?php echo ��������������������������������������������������������������������������������('请选择'); ?></option>
<?php foreach ($select_options as $opt): $opt_val=is_string($opt) ? trim($opt) : (string)$opt; $opt_esc=htmlspecialchars($opt_val, ENT_QUOTES, 'UTF-8'); ?>
<option value="<?php echo $opt_esc; ?>"<?php echo ($field_val===$opt_val || trim($field_val)===$opt_val) ? ' selected' : ''; ?>><?php echo $opt_esc; ?></option>
<?php endforeach; ?>
</select>
<?php elseif ($field_type==='upload'): ?>
<input type="text" name="field_val" class="layui-input" id="ccFieldValInput" value="<?php echo $field_val_esc; ?>" style="display:inline-block;width:calc(100% - 110px);vertical-align:middle;">
<button type="button" class="layui-btn layui-btn-sm" id="ccUploadBtn"><?php echo ��������������������������������������������������������������������������������('选择文件'); ?></button>
<?php else: ?>
<input type="text" name="field_val" class="layui-input" value="<?php echo $field_val_esc; ?>">
<?php endif; ?>
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<button type="button" class="layui-btn" id="ccEditValSaveBtn"><?php echo ��������������������������������������������������������������������������������('保存'); ?></button>
<button type="button" class="layui-btn layui-btn-primary" id="ccEditValCancelBtn"><?php echo ��������������������������������������������������������������������������������('取消'); ?></button>
</div>
</div>
</form>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.use(['form', 'layer', 'jquery', 'upload'], function(){var form=layui.form;var layer=layui.layer;var $=layui.jquery;var upload=layui.upload;var saveValUrl='index.php?m=applib&c=admin_app&a=custom_config_save_val';$('#ccEditValSaveBtn').on('click', function(){var fd;<?php if ($field_type==='code_textarea'): ?>var raw=$('#ccCodeTextarea').val();try {var b64=btoa(unescape(encodeURIComponent(raw)));$('#ccFieldValHidden').val(b64);} catch (e) { $('#ccFieldValHidden').val(''); }fd=$('#bsphpCustomConfigValForm').serialize();<?php else: ?>fd=$('#bsphpCustomConfigValForm').serialize();<?php endif; ?>$.post(saveValUrl, fd, function(ret) {if (ret && ret.code=='0') {layer.msg(ret.msg || '<?php echo addslashes(��������������������������������������������������������������������������������("保存成功")); ?>');var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.location.hash='#tabs=4';parent.location.reload();} else {layer.msg(ret && ret.msg ? ret.msg : '<?php echo addslashes(��������������������������������������������������������������������������������("保存失败")); ?>', {icon: 2});}}, 'json');});$('#ccEditValCancelBtn').on('click', function(){var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);});<?php if ($field_type==='upload'): ?>upload.render({elem: '#ccUploadBtn',url: 'index.php?m=applib&c=admin_app&a=storage_upload',accept: 'file',exts: 'zip|rar|7z|gz|apk|ipa|exe|dmg|json|js|css|html|txt|pdf|doc|docx|xls|xlsx|ppt|pptx|jpg|jpeg|png|gif|webp',done: function(res) {if (res && res.code==='0' && res.url) {$('#ccFieldValInput').val(res.url);layer.msg(res.msg || '<?php echo addslashes(��������������������������������������������������������������������������������("上传成功")); ?>');} else {layer.msg(res && res.msg ? res.msg : '<?php echo addslashes(��������������������������������������������������������������������������������("上传失败")); ?>', {icon: 2});}}});<?php endif; ?>form.render();});</script>
</body>
</html>
