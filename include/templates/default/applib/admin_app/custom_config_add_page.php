<!DOCTYPE html>
<html style="background-color: #ffffff;">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
</head>
<body style="padding:16px;background:#fff;">
<form class="layui-form" id="bsphpCustomConfigAddForm" lay-filter="cc_add_form">
<input type="hidden" name="id" value="<?php echo intval($��������������������������������������������������������������������������������); ?>">
<input type="hidden" name="exist_id" value="0">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('字段key'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<input type="text" name="field_key" class="layui-input" placeholder="<?php echo ��������������������������������������������������������������������������������('字母数字下划线'); ?>" required lay-verify="required">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('类型名称'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<input type="text" name="model_name" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('表单类型'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<select name="field_type" lay-filter="cc_field_type">
<option value="input"><?php echo ��������������������������������������������������������������������������������('单行文本'); ?></option>
<option value="textarea"><?php echo ��������������������������������������������������������������������������������('多行文本'); ?></option>
<option value="code_textarea"><?php echo ��������������������������������������������������������������������������������('代码多行文本'); ?></option>
<option value="select"><?php echo ��������������������������������������������������������������������������������('下拉选择'); ?></option>
<option value="upload"><?php echo ��������������������������������������������������������������������������������('文件上传'); ?></option>
</select>
</div>
</div>
<div class="layui-form-item cc-field-options-wrap" style="display:none">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('下拉选项'); ?></label>
<div class="layui-input-inline" style="width: 320px;">
<textarea name="field_options" class="layui-textarea" rows="6" placeholder="<?php echo ��������������������������������������������������������������������������������('每行一个'); ?>" style="min-width:300px;" tabindex="0"></textarea>
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('说明'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<input type="text" name="field_desc" class="layui-input">
</div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('获取状态'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<select name="login_required">
<option value="0"><?php echo ��������������������������������������������������������������������������������('无需登录可取'); ?></option>
<option value="1"><?php echo ��������������������������������������������������������������������������������('需登录后才可取'); ?></option>
<option value="2"><?php echo ��������������������������������������������������������������������������������('需要登陆切没过期才可取'); ?></option>
</select>
</div>
</div>
<div class="layui-form-item cc-field-val-input-wrap">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('当前值'); ?></label>
<div class="layui-input-inline" style="width: 220px;">
<input type="text" class="layui-input" id="ccAddFieldValInput">
</div>
</div>
<div class="layui-form-item cc-field-val-code-wrap" style="display:none">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('当前值'); ?></label>
<div class="layui-input-inline" style="width: 400px;">
<textarea id="ccAddCodeTextarea" class="layui-textarea" rows="8" style="font-family:monospace;font-size:13px;"></textarea>
</div>
</div>
<input type="hidden" name="field_val" id="ccAddFieldValHidden">
<div class="layui-form-item">
<div class="layui-input-block">
<button type="button" class="layui-btn" id="ccAddSaveBtn"><?php echo ��������������������������������������������������������������������������������('保存'); ?></button>
<button type="button" class="layui-btn layui-btn-primary" id="ccAddCancelBtn"><?php echo ��������������������������������������������������������������������������������('取消'); ?></button>
</div>
</div>
</form>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script>layui.use(['form', 'layer', 'jquery'], function(){var form=layui.form;var layer=layui.layer;var $=layui.jquery;form.on('select(cc_field_type)', function(data){var v=data.value;$(data.elem).closest('form').find('.cc-field-options-wrap').toggle(v==='select');$(data.elem).closest('form').find('.cc-field-val-input-wrap').toggle(v !=='code_textarea');$(data.elem).closest('form').find('.cc-field-val-code-wrap').toggle(v==='code_textarea');});var saveUrl='index.php?m=applib&c=admin_app&a=custom_config_save';$('#ccAddSaveBtn').on('click', function(){var f=$('#bsphpCustomConfigAddForm');if ($('[name=field_type]', f).val()==='code_textarea') {try {var raw=$('#ccAddCodeTextarea').val();$('#ccAddFieldValHidden').val(btoa(unescape(encodeURIComponent(raw))));} catch (e) { $('#ccAddFieldValHidden').val(''); }} else {$('#ccAddFieldValHidden').val($('#ccAddFieldValInput').val());}var fd=f.serialize();$.post(saveUrl, fd, function(ret) {if (ret && ret.code=='0') {layer.msg(ret.msg || '<?php echo addslashes(��������������������������������������������������������������������������������("保存成功")); ?>');var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.location.hash='#tabs=4';parent.location.reload();} else {layer.msg(ret && ret.msg ? ret.msg : '<?php echo addslashes(��������������������������������������������������������������������������������("保存失败")); ?>', {icon: 2});}}, 'json');});$('#ccAddCancelBtn').on('click', function(){var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);});form.render();});</script>
</body>
</html>
