<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo Plug_Get_Configs_Value("sys", "name"); ?> - <?php echo Plug_Lang('代理商管理平台'); ?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<style>:root {--bg-start: #0f172a;--bg-end: #1d4ed8;--card-bg: #ffffff;--title: #0f172a;--text: #334155;--muted: #64748b;--border: #dbe2ea;--focus: #2563eb;--button: #2563eb;--button-hover: #1d4ed8;--danger: #dc2626;--success: #16a34a;}* {box-sizing: border-box;}body {margin: 0;min-height: 100vh;font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "PingFang SC", "Microsoft YaHei", sans-serif;background: linear-gradient(135deg, var(--bg-start), var(--bg-end));color: var(--text);display: flex;align-items: center;justify-content: center;padding: 24px;}.login-wrapper {width: 100%;max-width: 980px;display: grid;grid-template-columns: 1.1fr 1fr;border-radius: 20px;overflow: hidden;background: rgba(255, 255, 255, 0.08);backdrop-filter: blur(6px);box-shadow: 0 24px 60px rgba(15, 23, 42, 0.35);}.brand-panel {position: relative;padding: 52px 40px;color: #e2e8f0;background-image:linear-gradient(135deg, rgba(2, 6, 23, 0.70), rgba(15, 23, 42, 0.40)),url('<?php echo Plug_Get_Url_Statics() ?>style/images/agent-login-bg.jpg');background-position: center;background-size: cover;background-repeat: no-repeat;display: flex;flex-direction: column;justify-content: center;gap: 14px;}.brand-panel h1,.brand-panel p {position: relative;z-index: 1;}.brand-panel h1 {margin: 0;font-size: 34px;line-height: 1.25;color: #ffffff;}.brand-panel p {margin: 0;line-height: 1.75;color: #cbd5e1;}.login-card {background: var(--card-bg);padding: 42px 34px 30px;}.login-title {margin: 0;color: var(--title);font-size: 26px;font-weight: 700;line-height: 1.3;}.login-subtitle {margin: 8px 0 24px;color: var(--muted);font-size: 14px;}.form-item {margin-bottom: 16px;}.form-item label {display: block;margin-bottom: 8px;font-size: 14px;color: var(--text);}.input,.select {width: 100%;height: 44px;border: 1px solid var(--border);border-radius: 10px;padding: 0 14px;outline: none;font-size: 14px;color: #0f172a;transition: border-color 0.2s, box-shadow 0.2s;background: #fff;}.input:focus,.select:focus {border-color: var(--focus);box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.16);}.captcha-row {display: grid;grid-template-columns: 1fr 118px;gap: 10px;align-items: center;}.captcha-img {width: 118px;height: 44px;border: 1px solid var(--border);border-radius: 10px;object-fit: cover;cursor: pointer;user-select: none;}.submit-btn {width: 100%;height: 44px;border: none;border-radius: 10px;background: var(--button);color: #fff;font-size: 15px;font-weight: 600;cursor: pointer;transition: background-color 0.2s, transform 0.05s;}.submit-btn:hover {background: var(--button-hover);}.submit-btn:active {transform: translateY(1px);}.submit-btn:disabled {opacity: 0.75;cursor: not-allowed;}.msg {min-height: 22px;margin-bottom: 12px;font-size: 13px;line-height: 1.6;}.msg.error {color: var(--danger);}.msg.success {color: var(--success);}@media (max-width: 900px) {.login-wrapper {grid-template-columns: 1fr;max-width: 520px;}.brand-panel {padding: 28px 26px 24px;}.brand-panel h1 {font-size: 26px;}}</style>
<script>if (self !=top) {parent.location.href='index.php';}</script>
</head>
<body>
<div class="login-wrapper">
<div class="brand-panel">
<h1><?PHP echo Plug_Get_Configs_Value("sys", "name"); ?></h1>
<p><?php echo Plug_Lang('欢迎登录代理商管理平台'); ?></p>
<p><?php echo Plug_Lang('请使用代理账号完成身份验证后进入系统。'); ?></p>
</div>
<div class="login-card">
<h2 class="login-title"><?php echo Plug_Lang('代理商管理平台登录'); ?></h2>
<p class="login-subtitle"><?php echo Plug_Lang('请输入账号信息并选择语言'); ?></p>
<form action="" name="bsphppost" id="bsphppost" method="post">
<div class="msg" id="formMsg"></div>
<div class="form-item">
<label for="amdin_name"><?php echo Plug_Lang('用户名'); ?></label>
<input type="text" name="amdin_name" id="amdin_name" class="input" autocomplete="username" required>
</div>
<div class="form-item">
<label for="admin_password"><?php echo Plug_Lang('密码'); ?></label>
<input type="password" name="admin_password" id="admin_password" class="input" autocomplete="current-password" required>
</div>
<div class="form-item">
<label for="lang"><?php echo Plug_Lang('语言'); ?></label>
<select name="lang" id="lang" class="select">
<option value="0"><?php echo Plug_Lang('简体中文'); ?></option>
<option value="5"><?php echo Plug_Lang('繁体中文'); ?></option>
<option value="6"><?php echo Plug_Lang('英语'); ?></option>
<option value="7"><?php echo Plug_Lang('俄语'); ?></option>
<option value="8"><?php echo Plug_Lang('日语'); ?></option>
<option value="9"><?php echo Plug_Lang('韩语'); ?></option>
<option value="10"><?php echo Plug_Lang('法语'); ?></option>
<option value="11"><?php echo Plug_Lang('德语'); ?></option>
</select>
</div>
<div class="form-item" <?php if (Plug_Get_Configs_Value('code', 'coode_login')==0) echo 'style="display:none;"';  ?>>
<label for="code"><?php echo Plug_Lang('图形验证码'); ?></label>
<div class="captcha-row">
<input type="text" name="code" id="code" class="input" placeholder="<?php echo Plug_Lang('请输入验证码'); ?>">
<img src="index.php?m=coode" class="captcha-img" id="captchaImage">
</div>
</div>
<input id="admin" type="hidden" name="appenconfig" value="1">
<button type="submit" class="submit-btn" id="submitBtn"><?php echo Plug_Lang('登 入'); ?></button>
</form>
</div>
</div>
<script>(function() {var form=document.getElementById('bsphppost');var submitBtn=document.getElementById('submitBtn');var msgBox=document.getElementById('formMsg');var captchaImage=document.getElementById('captchaImage');var langSelect=document.getElementById('lang');var langValue='<?php echo Plug_Get_Session_Value('AGENT_LANG')==""?Plug_Get_Configs_Value('sys', 'cms_langs'):Plug_Get_Session_Value('AGENT_LANG'); ?>';if (langSelect && langValue !=='') {for (var i=0; i < langSelect.options.length; i++) {if (langSelect.options[i].value===langValue) {langSelect.selectedIndex=i;break;}}}if (captchaImage) {captchaImage.addEventListener('click', function() {captchaImage.src='index.php?m=coode&time=' + Date.now();});}function showMessage(text, type) {msgBox.className='msg ' + (type || 'error');msgBox.textContent=text || '';}form.addEventListener('submit', function(event) {event.preventDefault();showMessage('', '');var username=document.getElementById('amdin_name').value.trim();var password=document.getElementById('admin_password').value.trim();if (!username || !password) {showMessage('<?php echo Plug_Lang('请填写完整登录信息'); ?>', 'error');return;}submitBtn.disabled=true;submitBtn.textContent='<?php echo Plug_Lang('登录中...'); ?>';var formData=new FormData(form);fetch(window.location.href, {method: 'POST',body: formData,credentials: 'same-origin',headers: {'X-Requested-With': 'XMLHttpRequest'}}).then(function(response) {return response.json();}).then(function(ret) {if (ret.code==8) {showMessage(ret.msg, 'success');window.location.href=ret.url;return;}if (ret.code==9) {if (window.confirm(ret.msg)) {window.location.href=ret.url;}return;}showMessage(ret.msg || '<?php echo Plug_Lang('登录失败'); ?>', 'error');if (captchaImage) {captchaImage.click();}}).catch(function() {showMessage('<?php echo Plug_Lang('网络异常，请稍后重试'); ?>', 'error');}).finally(function() {submitBtn.disabled=false;submitBtn.textContent='<?php echo Plug_Lang('登 入'); ?>';});});})();</script>
</body>
</html>