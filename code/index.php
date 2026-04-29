<?php
include ('../Plug/Plug.php');
function query_code_status($queryCode)
{
$resultText='';
$resultType='neutral';
if ($queryCode=='') {
$resultText='请输入激活码';
$resultType='warning';
return array($resultText, $resultType);
}
$info=plug_query_array("SELECT * FROM  `bs_php_cardseries` WHERE  `car_name`='$queryCode' LIMIT 1");
if (!$info) {
$resultText="您查询的激活码不存在<BR/>";
$resultType='danger';
return array($resultText, $resultType);
}
if ($info['car_zhuangtai']==1) {
$resultText="您查询的授权码被冻结";
$resultType='danger';
return array($resultText, $resultType);
}
if ($info['car_IsLock']==1) {
$bsphp_pattern_login=plug_query_array("SELECT * FROM  `bs_php_pattern_login` WHERE  `L_User_uid`='$queryCode' OR `L_ic_pwd`='$queryCode' LIMIT 1");
$vipDateText='未知';
if (is_array($bsphp_pattern_login) && isset($bsphp_pattern_login['L_vip_unix']) && $bsphp_pattern_login['L_vip_unix'] > 0) {
$vipDateText=date('Y-m-d H:i:s', (int)$bsphp_pattern_login['L_vip_unix']);
}
$resultText='授权码已激活:<BR/>激活时间:' . $info['car_pur_date'] . "<BR/>到期时间:" . $vipDateText;
$resultType='success';
return array($resultText, $resultType);
}
$resultText='您查询的授权码未激活';
$resultType='warning';
return array($resultText, $resultType);
}
$queryCode=trim(plug_set_post('code'));
$resultText='';
$resultType='neutral';
$ok=plug_set_post('ok');
$isAjax=plug_set_post('ajax');
if ($ok) {
list($resultText, $resultType)=query_code_status($queryCode);
if ($isAjax) {
header('Content-Type: application/json; charset=utf-8');
echo json_encode(array(
'code'=> 0,
'resultText'=> $resultText,
'resultType'=> $resultType
));
exit;
}
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<title>激活码查询</title>
<style>:root {--bg-start: #f7fbff;--bg-end: #edf4ff;--card-bg: rgba(255, 255, 255, 0.88);--card-border: #dce7f7;--title: #0f172a;--text: #334155;--muted: #64748b;--primary: #2563eb;--primary-hover: #1d4ed8;--success-bg: #ecfdf3;--success-border: #86efac;--success-text: #166534;--warning-bg: #fffbeb;--warning-border: #fcd34d;--warning-text: #92400e;--danger-bg: #fef2f2;--danger-border: #fca5a5;--danger-text: #991b1b;--neutral-bg: #eff6ff;--neutral-border: #bfdbfe;--neutral-text: #1e3a8a;}* { box-sizing: border-box; }body {margin: 0;min-height: 100vh;font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "PingFang SC", "Microsoft YaHei", sans-serif;color: var(--text);background:radial-gradient(circle at 12% 10%, rgba(59, 130, 246, 0.18), transparent 30%),radial-gradient(circle at 90% 85%, rgba(14, 165, 233, 0.12), transparent 34%),linear-gradient(135deg, var(--bg-start), var(--bg-end));display: flex;align-items: center;justify-content: center;padding: 24px;}.container {width: 100%;max-width: 760px;border: 1px solid var(--card-border);border-radius: 20px;background-image:linear-gradient(155deg, rgba(255, 255, 255, 0.93), rgba(255, 255, 255, 0.88)),url('/images/code-container-bg.jpg');background-size: 118% auto;background-position: 82% 78%;background-repeat: no-repeat;box-shadow: 0 20px 52px rgba(15, 23, 42, 0.12);backdrop-filter: blur(8px);overflow: hidden;}.header {padding: 28px 28px 18px;border-bottom: 1px solid #e7eefb;}.title {margin: 0;color: var(--title);font-size: 30px;line-height: 1.25;}.subtitle {margin: 10px 0 0;color: var(--muted);font-size: 14px;line-height: 1.7;}.content {padding: 24px 28px 28px;}.label {display: block;margin-bottom: 8px;color: #1e293b;font-size: 14px;font-weight: 600;}.input {width: 100%;height: 46px;border: 1px solid #d3def0;border-radius: 10px;padding: 0 14px;outline: none;font-size: 14px;color: #0f172a;transition: border-color .2s, box-shadow .2s;background: #fff;}.input:focus {border-color: var(--primary);box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.16);}.actions {margin-top: 16px;display: flex;gap: 10px;align-items: center;flex-wrap: wrap;}.btn {border: none;border-radius: 10px;height: 44px;padding: 0 26px;background: var(--primary);color: #fff;font-size: 15px;font-weight: 600;cursor: pointer;transition: background-color .2s ease, transform .05s ease;}.btn:hover { background: var(--primary-hover); }.btn:active { transform: translateY(1px); }.hint {color: var(--muted);font-size: 13px;}.result {margin-top: 18px;border-radius: 12px;padding: 12px 14px;line-height: 1.75;font-size: 14px;word-break: break-word;}.result-head {display: flex;align-items: center;margin-bottom: 4px;}.result-badge {font-size: 12px;font-weight: 700;border-radius: 99px;padding: 2px 10px;letter-spacing: .2px;}.result--success {border: 1px solid var(--success-border);background: var(--success-bg);color: var(--success-text);}.result--success .result-badge {background: #22c55e;color: #ffffff;}.result--warning {border: 1px solid var(--warning-border);background: var(--warning-bg);color: var(--warning-text);}.result--warning .result-badge {background: #f59e0b;color: #ffffff;}.result--danger {border: 1px solid var(--danger-border);background: var(--danger-bg);color: var(--danger-text);}.result--danger .result-badge {background: #ef4444;color: #ffffff;}.result--neutral {border: 1px solid var(--neutral-border);background: var(--neutral-bg);color: var(--neutral-text);}.result--neutral .result-badge {background: #3b82f6;color: #ffffff;}@media (max-width: 640px) {body { padding: 14px; }.header, .content { padding-left: 16px; padding-right: 16px; }.title { font-size: 24px; }.btn { width: 100%; }}</style>
</head>
<body>
<main class="container">
<section class="header">
<h1 class="title">激活码查询</h1>
<p class="subtitle">支持激活码与充值卡状态查询，输入完整编码后点击查询即可。</p>
</section>
<section class="content">
<form action="" method="post">
<label for="code" class="label">激活码 / 充值卡</label>
<input
type="text"
name="code"
id="code"
class="input"
value="<?php echo htmlspecialchars($queryCode, ENT_QUOTES, 'UTF-8'); ?>"
placeholder="请输入激活码或充值卡编码"
autocomplete="off"
/>
<div class="actions">
<button type="submit" value="ok" name="ok" class="btn">立即查询</button>
<span class="hint">查询结果将显示在下方提示区域</span>
</div>
</form>
<div id="resultContainer">
<?php if ($resultText !='') { ?>
<?php
$resultTypeMap=array(
'success'=> '已激活',
'warning'=> '提示',
'danger'=> '异常',
'neutral'=> '结果'
);
$resultLabel=isset($resultTypeMap[$resultType]) ? $resultTypeMap[$resultType] : '结果';
?>
<div class="result result--<?php echo htmlspecialchars($resultType, ENT_QUOTES, 'UTF-8'); ?>">
<div class="result-head">
<span class="result-badge"><?php echo $resultLabel; ?></span>
</div>
<?php
$safeText=str_replace(array('<BR/>', '<br/>', '<br>'), "\n", $resultText);
echo nl2br(htmlspecialchars($safeText, ENT_QUOTES, 'UTF-8'));
?>
</div>
<?php } ?>
</div>
</section>
</main>
<script>(function() {var form=document.querySelector('form');var submitBtn=form.querySelector('button[type="submit"]');var resultContainer=document.getElementById('resultContainer');var resultTypeMap={success: '已激活',warning: '提示',danger: '异常',neutral: '结果'};function escapeHtml(str) {return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');}function renderResult(resultText, resultType) {if (!resultText) {resultContainer.innerHTML='';return;}var label=resultTypeMap[resultType] || '结果';var safe=escapeHtml(resultText).replace(/&lt;br\s*\/?&gt;/gi, '<br>');resultContainer.innerHTML='<div class="result result--' + escapeHtml(resultType) + '">' +'<div class="result-head"><span class="result-badge">' + label + '</span></div>' +safe +'</div>';}form.addEventListener('submit', function(e) {e.preventDefault();var formData=new FormData(form);formData.set('ok', 'ok');formData.set('ajax', '1');submitBtn.disabled=true;submitBtn.textContent='查询中...';fetch(window.location.pathname, {method: 'POST',body: formData,credentials: 'same-origin',headers: { 'X-Requested-With': 'XMLHttpRequest' }}).then(function(res) { return res.json(); }).then(function(ret) {renderResult(ret.resultText || '', ret.resultType || 'neutral');}).catch(function() {renderResult('网络异常，请稍后重试', 'danger');}).finally(function() {submitBtn.disabled=false;submitBtn.textContent='立即查询';});});})();</script>
</body>
</html>