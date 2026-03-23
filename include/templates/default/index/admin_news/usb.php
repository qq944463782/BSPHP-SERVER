<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo ����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), ����������������������������������������������������������������������������(110).����������������������������������������������������������������������������(97).����������������������������������������������������������������������������(109).����������������������������������������������������������������������������(101)) ?>- <?php echo ��������������������������������������������������������������������������������('文章修改'); ?>  Bsphp-Pro</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/style/admin.css" media="all">
<link href="<?php echo ������������������������������������������������������������������������(); ?>wangeditor/css/style.css" rel="stylesheet">
<style>#news-editor-wrapper{border:1px solid #ccc;border-radius:2px;}#news-toolbar-container{border-bottom:1px solid #ccc;}#news-editor-container{height:450px;overflow-y:auto;}</style>
</head>
<body data="BSPHP-PRO 2022本系统受国家版权局保护请勿破解或者二次开发传播">
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><?php echo ��������������������������������������������������������������������������������('文章修改'); ?></div>
<div class="layui-card-body" pad15>
<div class="layui-form" wid100 lay-filter="news_edit_form">
<form action="" name="bsphppost" id="bsphppost" method="post" lay-filter="news_edit_form">
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('标题'); ?></label>
<div class="layui-input-inline" style="width: 300px;">
<input type="text" name="news_table" id="news_table" value="<?php echo $����������������������������������������������������������������������������['news_table']; ?>" class="layui-input">
</div>
<div class="layui-form-mid layui-word-aux"></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('分组'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<select name="news_class" id="news_class">
<?php
while ($����������������������������������������������������������������������������=Plug_Pdo_Fetch_Assoc($����������������������������������������������������W��������������������)) {
$������������������������������������R������������������������_SERVER=($����������������������������������������������������������������������������['news_class']==$����������������������������������������������������������������������������['class_id']) ? ' selected' : '';
echo "<option value='{$����������������������������������������������������������������������������['class_id']}'{$������������������������������������R������������������������_SERVER}>{$����������������������������������������������������������������������������['class_name']}</option>";
}
?>
</select>
</div>
<div class="layui-form-mid layui-word-aux"></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('所属软件'); ?></label>
<div class="layui-input-inline" style="width: 200px;">
<select name="news_daihao" id="news_daihao">
<option value="0"><?php echo ��������������������������������������������������������������������������������('不关联'); ?></option>
<?php
$cur_daihao=isset($����������������������������������������������������������������������������['news_daihao']) ? (int)$����������������������������������������������������������������������������['news_daihao'] : 0;
if (isset($����������������������������������������������������������������������������_GET��������)) {
while ($row=Plug_Pdo_Fetch_Assoc($����������������������������������������������������������������������������_GET��������)) {
$sel=($cur_daihao===(int)$row['app_daihao']) ? ' selected' : '';
echo "<option value='" . (int)$row['app_daihao'] . "'{$sel}>" . htmlspecialchars($row['app_name']) . "</option>";
}
}
?>
</select>
</div>
<div class="layui-form-mid layui-word-aux"><?php echo ��������������������������������������������������������������������������������('可选，关联到软件说明'); ?></div>
</div>
<div class="layui-form-item">
<label class="layui-form-label"><?php echo ��������������������������������������������������������������������������������('内容'); ?></label>
<div class="layui-input-block" style="width:calc(100% - 220px);">
<div id="news-editor-wrapper">
<div id="news-toolbar-container"></div>
<div id="news-editor-container"></div>
</div>
<div style="margin-top:8px;">
<button type="button" class="layui-btn layui-btn-sm layui-btn-primary" id="news_upload_attach"><?php echo ��������������������������������������������������������������������������������('上传附件'); ?></button>
<input type="file" id="news_attach_input" style="display:none;" accept=".zip,.rar,.7z,.gz,.apk,.ipa,.exe,.dmg,.json,.js,.css,.html,.txt,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.webp">
</div>
<textarea name="news_test" id="news_test" style="display:none;"></textarea>
</div>
</div>
<div class="layui-form-item">
<div class="layui-input-block">
<input id="admin" type="hidden" name="appenconfig" value="1">
<button type="button" class="layui-btn" lay-submit lay-filter="news_edit_submit"><?php echo ��������������������������������������������������������������������������������('确认保存');?></button>
<input type="hidden" name="<?php echo $this->��������������������������������������������������������������������������������(); ?>" value="1">
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="foot">Copyright © 2009-2026 <a href="http://www.bsphp.com?pro" target="_blank">Bsphp-Pro <?php echo BSPHP_VERSION; ?></a> Bsphp.com <br>
All Rights Reserved </div>
<script>var NEWS_INIT_HTML=<?php echo json_encode($����������������������������������������������������������������������������['news_test'] ?? ''); ?>;</script>
<script src="<?php echo ������������������������������������������������������������������������() ?>layuiadmin/layui/bsphp.js"></script>
<script src="<?php echo ������������������������������������������������������������������������(); ?>wangeditor/index.js"></script>
<script>var newsEditor=null;(function(){var E=window.wangEditor;if(!E){alert('WangEditor加载失败');return;}var initHtml=(typeof NEWS_INIT_HTML !=='undefined' && NEWS_INIT_HTML) ? NEWS_INIT_HTML : '<p><br></p>';var editorConfig={placeholder: '<?php echo ��������������������������������������������������������������������������������("请输入内容"); ?>',MENU_CONF: {uploadImage: {async customUpload(file, insertFn) {var fd=new FormData();fd.append('file', file);try {var r=await fetch('index.php?m=index&c=admin_news&a=upload_image', { method: 'POST', body: fd });var res=await r.json();if (res.code===0 && res.data && res.data.src) {insertFn(res.data.src, file.name || '', res.data.src);} else { throw new Error(res.msg || '上传失败'); }} catch (e) { alert(e.message || '上传失败'); }}},uploadVideo: { show: false }}};newsEditor=E.createEditor({ selector: '#news-editor-container', html: initHtml, config: editorConfig, mode: 'default' });var toolbarConfig={};E.createToolbar({ editor: newsEditor, selector: '#news-toolbar-container', config: toolbarConfig, mode: 'default' });document.getElementById('news_upload_attach').onclick=function(){ document.getElementById('news_attach_input').click(); };document.getElementById('news_attach_input').onchange=function(){var f=this.files[0]; if(!f) return;var fd=new FormData(); fd.append('file', f);fetch('index.php?m=index&c=admin_news&a=upload_file', { method: 'POST', body: fd }).then(function(r){ return r.json(); }).then(function(res){if(res.code===0 && res.url){var html='<p><a href="'+res.url+'" target="_blank">'+res.name+'</a></p>';if(newsEditor) newsEditor.dangerouslyInsertHtml(html);} else { alert(res.msg || '上传失败'); }}).catch(function(e){ alert(e.message || '上传失败'); });this.value='';};})();layui.config({ base: '<?php echo ������������������������������������������������������������������������() ?>layuiadmin/', version: "20240311" }).extend({ index: 'lib/index' }).use(['index', 'set', 'form'], function(){var form=layui.form;form.on('submit(news_edit_submit)', function(){if(newsEditor){ document.getElementById('news_test').value=newsEditor.getHtml(); }document.getElementById('bsphppost').submit();return false;});});</script>
<script language="javascript">select_set('stop', <?php echo (int)����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), 'stop') ?>);select_set('safe_sql', <?php echo (int)����������������������������������������������������������������::������������������������������������������������������������������������������������(����������������������������������������������������������������������������(115).����������������������������������������������������������������������������(121).����������������������������������������������������������������������������(115), 'safe_sql') ?>);</script>
</body>
</html>