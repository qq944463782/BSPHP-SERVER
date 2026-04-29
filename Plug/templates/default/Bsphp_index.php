<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<title><?php echo Plug_Get_Configs_Value("sys","name"); ?></title>
<style type="text/css">:root {--bg-start: #0b132b;--bg-end: #1d4ed8;--text-main: #f8fafc;--text-sub: #cbd5e1;--card: rgba(255, 255, 255, 0.14);--card-border: rgba(255, 255, 255, 0.24);--btn: #2563eb;--btn-hover: #1d4ed8;}* { box-sizing: border-box; }body {margin: 0;min-height: 100vh;font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "PingFang SC", "Microsoft YaHei", sans-serif;color: var(--text-main);background:radial-gradient(circle at 15% 20%, rgba(56, 189, 248, 0.20), transparent 28%),radial-gradient(circle at 85% 80%, rgba(99, 102, 241, 0.24), transparent 34%),linear-gradient(135deg, var(--bg-start), var(--bg-end));display: flex;align-items: center;justify-content: center;padding: 28px 16px;}.page {width: 100%;max-width: 1080px;border-radius: 22px;border: 1px solid var(--card-border);background: var(--card);backdrop-filter: blur(14px);box-shadow: 0 28px 60px rgba(2, 6, 23, 0.36);overflow: hidden;}.hero {padding: 44px 36px 24px;border-bottom: 1px solid rgba(255, 255, 255, 0.18);}.title {margin: 0;font-size: 34px;line-height: 1.25;letter-spacing: 0.3px;}.subtitle {margin: 10px 0 0;color: var(--text-sub);font-size: 15px;line-height: 1.75;max-width: 760px;}.grid {padding: 24px 24px 28px;display: grid;grid-template-columns: 1.2fr 1fr;gap: 18px;}.card {border-radius: 16px;border: 1px solid rgba(255, 255, 255, 0.18);background: rgba(9, 19, 45, 0.34);padding: 20px;}.card h2 {margin: 0 0 12px;font-size: 18px;color: #e2e8f0;}.clock {display: flex;align-items: baseline;gap: 8px;margin: 4px 0 4px;}.clock-time {font-size: 44px;font-weight: 700;letter-spacing: 1px;line-height: 1.2;color: #ffffff;}.clock-sec {font-size: 20px;font-weight: 600;color: #93c5fd;}.clock-date {margin: 6px 0 0;color: #cbd5e1;font-size: 14px;}.entry-list {display: grid;grid-template-columns: repeat(3, 1fr);gap: 12px;margin-top: 8px;}.entry {display: block;text-decoration: none;text-align: center;border-radius: 12px;padding: 14px 10px;color: #dbeafe;border: 1px solid rgba(147, 197, 253, 0.36);background: rgba(30, 64, 175, 0.22);transition: transform 0.1s ease, background-color 0.2s ease;}.entry:hover {background: rgba(37, 99, 235, 0.36);transform: translateY(-1px);}.entry b {display: block;font-size: 14px;margin-bottom: 6px;}.entry span {color: #bfdbfe;font-size: 12px;}.note {margin-top: 14px;color: #bfdbfe;font-size: 12px;line-height: 1.7;}.brand {margin: 0;padding: 10px 24px 14px;text-align: right;font-size: 11px;line-height: 1.4;color: rgba(219, 234, 254, 0.75);border-top: 1px solid rgba(255, 255, 255, 0.12);}.brand a {color: rgba(219, 234, 254, 0.0);text-decoration: none;}.brand a:hover {color: #ffffff;color: rgba(219, 234, 254, 0.0);text-decoration: underline;}@media (max-width: 900px) {.grid {grid-template-columns: 1fr;}.entry-list {grid-template-columns: 1fr;}.title {font-size: 28px;}.clock-time {font-size: 38px;}.brand {text-align: center;}}</style>
</head>
<body>
<main class="page">
<section class="hero">
<h1 class="title"><?php echo Plug_Get_Configs_Value("sys","name"); ?></h1>
<p class="subtitle">
<?php echo Plug_Lang('欢迎访问系统门户，您可以在此快速进入管理后台、激活码查询和代理中心。'); ?>
</p>
</section>
<section class="grid">
<article class="card">
<h2><?php echo Plug_Lang('实时系统时间'); ?></h2>
<div class="clock">
<div class="clock-time" id="clockMain">00:00</div>
<div class="clock-sec" id="clockSec">00</div>
</div>
<p class="clock-date" id="clockDate">-</p>
</article>
<article class="card">
<h2><?php echo Plug_Lang('快速入口'); ?></h2>
<div class="entry-list">
<a class="entry" href="admin">
<b><?php echo Plug_Lang('进入后台'); ?></b>
<span>Admin Center</span>
</a>
<a class="entry" href="code">
<b><?php echo Plug_Lang('激活码查询'); ?></b>
<span>Code Search</span>
</a>
<a class="entry" href="agent">
<b><?php echo Plug_Lang('代理中心'); ?></b>
<span>Agent Portal</span>
</a>
</div>
<p class="note"><?php echo Plug_Lang('本页内容可在下面路径修改:'); ?> `Plug/templates/default/Bsphp_index.php`</p>
</article>
</section>
<p class="brand"><a href="https://www.bsphp.com/">Bsphp验证系统</a></p>
</main>
<script>(function() {var clockMain=document.getElementById('clockMain');var clockSec=document.getElementById('clockSec');var clockDate=document.getElementById('clockDate');function pad(v) {return v < 10 ? '0' + v : String(v);}function updateClock() {var now=new Date();clockMain.textContent=pad(now.getHours()) + ':' + pad(now.getMinutes());clockSec.textContent=pad(now.getSeconds());clockDate.textContent=now.getFullYear() + '-' + pad(now.getMonth() + 1) + '-' + pad(now.getDate());}updateClock();window.setInterval(updateClock, 500);var httpRequest=new XMLHttpRequest();httpRequest.open('GET', 'index.php?m=index&c=index&a=acctoken', true);httpRequest.send();httpRequest.onreadystatechange=function() {if (httpRequest.readyState===4 && httpRequest.status===200) {console.log(httpRequest.responseText);}};})();</script>
</body>
</html>