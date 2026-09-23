<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="renderer" content="webkit" />
<title>系统维护关闭 - <?php echo Plug_Get_Configs_Value("sys","name"); ?></title>
<style type="text/css">:root {--bg-start: #0b132b;--bg-end: #1d4ed8;--card-bg: rgba(255, 255, 255, 0.12);--card-border: rgba(255, 255, 255, 0.24);--title: #f8fafc;--text: #dbeafe;--muted: #bfdbfe;--btn-bg: #2563eb;--btn-hover: #1d4ed8;}* { box-sizing: border-box; }body {margin: 0;min-height: 100vh;display: flex;align-items: center;justify-content: center;padding: 20px;font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "PingFang SC", "Microsoft YaHei", sans-serif;background:radial-gradient(circle at 12% 18%, rgba(56, 189, 248, 0.20), transparent 28%),radial-gradient(circle at 88% 82%, rgba(99, 102, 241, 0.24), transparent 34%),linear-gradient(135deg, var(--bg-start), var(--bg-end));color: var(--text);}.card {width: 100%;max-width: 760px;border-radius: 18px;border: 1px solid var(--card-border);background: var(--card-bg);box-shadow: 0 24px 56px rgba(2, 6, 23, 0.38);backdrop-filter: blur(10px);overflow: hidden;}.header {padding: 26px 28px 16px;border-bottom: 1px solid rgba(255, 255, 255, 0.16);}.header h1 {margin: 0;font-size: 28px;color: var(--title);line-height: 1.3;}.header p {margin: 8px 0 0;font-size: 14px;color: var(--muted);}.content {padding: 22px 28px 24px;line-height: 1.8;font-size: 15px;color: var(--text);word-break: break-word;}.content p {margin: 0;}.footer {padding: 0 28px 24px;display: flex;gap: 10px;flex-wrap: wrap;}.btn {display: inline-block;text-decoration: none;color: #fff;border-radius: 10px;background: var(--btn-bg);padding: 10px 16px;font-size: 14px;transition: background-color .2s ease;}.btn:hover {background: var(--btn-hover);}</style>
</head>
<body>
<main class="card">
<section class="header">
<h1><?php echo Plug_Get_Configs_Value("sys","name"); ?> - 系统维护中</h1>
<p>Maintenance Notice</p>
</section>
<section class="content">
<p><?php echo Plug_Get_Configs_Value("sys","stop_info"); ?></p>
</section>
<section class="footer">
<a class="btn" href="index.php">返回首页</a>
<a class="btn" href="javascript:location.reload();">刷新页面</a>
</section>
</main>
</body>
</html>
