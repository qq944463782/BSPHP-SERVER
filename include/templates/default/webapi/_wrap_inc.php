<?php
/**
 * 公共参数 wrap - 控制 .wrap 显示模式
 * wrap=0 或不传: 默认风格(灰底、圆角、阴影)
 * wrap=1: 平铺风格(白底、边框)
 * wrap=2: 平铺无标题(白底、边框、隐藏.hd)
 * wrap=4: 平铺风格 宽度100% 边界0 有标题
 * wrap=5: 平铺风格 宽度100% 边界0 无标题
 */
if (!isset($wrap_mode)) {
    $wrap_mode = isset($_GET['wrap']) ? (int)$_GET['wrap'] : 0;
}
$wrap_mode = max(0, min(5, $wrap_mode));
if ($wrap_mode === 3) $wrap_mode = 0; // 3 保留未用
$wrap_class = ['wrap-default', 'wrap-embed', 'wrap-embed-min', '', 'wrap-full', 'wrap-full-min'][$wrap_mode];
$show_header = !in_array($wrap_mode, [2, 5], true);
