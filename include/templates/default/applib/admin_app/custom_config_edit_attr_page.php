<?php
$field_key=$����������������������������������������������������������������['field_key'] ?? '';
$model_name=$����������������������������������������������������������������['model_name'] ?? '';
$field_type=$����������������������������������������������������������������['field_type'] ?? 'input';
$field_desc=$����������������������������������������������������������������['field_desc'] ?? '';
$field_options=$����������������������������������������������������������������['field_options'] ?? '';
$login_req=(int)$����������������������������������������������������������������['login_required'];
$options_arr=array();
if ($field_options) {
$tmp=@json_decode($field_options, true);
if (is_array($tmp)) $options_arr=$tmp;
}
$options_text=is_array($options_arr) ? implode("\n", $options_arr) : $field_options;
$field_key_esc=htmlspecialchars($field_key, ENT_QUOTES, 'UTF-8');
$model_name_esc=htmlspecialchars($model_name, ENT_QUOTES, 'UTF-8');
$field_desc_esc=htmlspecialchars($field_desc, ENT_QUOTES, 'UTF-8');
$options_text_esc=htmlspecialchars($options_text, ENT_QUOTES, 'UTF-8');
$exist_id=(int)($����������������������������������������������������������������['id'] ?? 0);
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
<form class="layui-form" id="bsphpCustomConfigForm" lay-filter="cc_edit_attr_form">
<input type="hidden" name="id" value="<?php echo intval($��������������������������������������������������������������������������������); ?>">
<input type="hidden" name="exist_id" value="<?php echo $exist_id; ?>">
<input type="hidden" name="attr_only" value="1">
<input type="hidden" name="field_key" value="<?php echo $field_key_esc; ?>">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('字段key'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<span class="layui-form-mid" style="padding-left:0;"><?php echo $field_key_esc; ?></span>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('类型名称'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<input type="text" name="model_name" class="layui-input" value="<?php echo $model_name_esc; ?>">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('表单类型'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<select name="field_type" lay-filter="cc_field_type">
<option value="input"<?php echo $field_type==='input' ? ' selected' : ''; ?>><?php echo ��������������������������������������������������������������������������������('单行文本'); ?></option>
<option value="textarea"<?php echo $field_type==='textarea' ? ' selected' : ''; ?>><?php echo ��������������������������������������������������������������������������������('多行文本'); ?></option>
<option value="code_textarea"<?php echo $field_type==='code_textarea' ? ' selected' : ''; ?>><?php echo ��������������������������������������������������������������������������������('代码多行文本'); ?></option>
<option value="select"<?php echo $field_type==='select' ? ' selected' : ''; ?>><?php echo ��������������������������������������������������������������������������������('下拉选择'); ?></option>
<option value="upload"<?php echo $field_type==='upload' ? ' selected' : ''; ?>><?php echo ��������������������������������������������������������������������������������('文件上传'); ?></option>
</select>
</div>
</div>
<div class="layui-form-item cc-field-options-wrap" style="<?php echo $field_type==='select' ? '' : 'display:none'; ?>">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('下拉选项'); ?></label>
<div class="layui-input-inline" style="width: 320px;">
<textarea name="field_options" class="layui-textarea" rows="6" placeholder="<?php echo ��������������������������������������������������������������������������������('每行一个'); ?>" style="min-width:300px;" tabindex="0"><?php echo $options_text_esc; ?></textarea>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('说明'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<input type="text" name="field_desc" class="layui-input" value="<?php echo $field_desc_esc; ?>">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('获取状态'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<select name="login_required">
<option value="0"<?php echo $login_req===0 ? ' selected' : ''; ?>><?php echo ��������������������������������������������������������������������������������('无需登录可取'); ?></option>
<option value="1"<?php echo $login_req===1 ? ' selected' : ''; ?>><?php echo ��������������������������������������������������������������������������������('需登录后才可取'); ?></option>
<option value="2"<?php echo $login_req===2 ? ' selected' : ''; ?>><?php echo ��������������������������������������������������������������������������������('需要登陆切没过期才可取'); ?></option>
</select>
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<button type="button" class="layui-btn" id="ccEditAttrSaveBtn"><?php echo ��������������������������������������������������������������������������������('保存'); ?></button>
<button type="button" class="layui-btn layui-btn-primary" id="ccEditAttrCancelBtn"><?php echo ��������������������������������������������������������������������������������('取消'); ?></button>
</div>
</div>
</form>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.use(['form', 'layer', 'jquery'], function(){var form=layui.form;var layer=layui.layer;var $=layui.jquery;form.on('select(cc_field_type)', function(data){$(data.elem).closest('form').find('.cc-field-options-wrap').toggle(data.value==='select');});var saveUrl='index.php?m=applib&c=admin_app&a=custom_config_save';$('#ccEditAttrSaveBtn').on('click', function(){var f=$('#bsphpCustomConfigForm');var fd=f.serialize();$.post(saveUrl, fd, function(ret) {if (ret && ret.code=='0') {layer.msg(ret.msg || '<?php echo addslashes(��������������������������������������������������������������������������������("保存成功")); ?>');var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.location.hash='#tabs=4';parent.location.reload();} else {layer.msg(ret && ret.msg ? ret.msg : '<?php echo addslashes(��������������������������������������������������������������������������������("保存失败")); ?>', {icon: 2});}}, 'json');});$('#ccEditAttrCancelBtn').on('click', function(){var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);});form.render();});</script>
</body>
</html>
