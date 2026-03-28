<?php
$reqUri=$_SERVER['REQUEST_URI'] ?? '';
$path=parse_url($reqUri, PHP_URL_PATH) ?? '';
if ($path !=='' && substr($path, -1) !=='/' && str_ends_with($path, '/agent')) {
$q=parse_url($reqUri, PHP_URL_QUERY);
$loc=$path . '/index.php' . ($q !==null && $q !=='' ? '?' . $q : '');
header('Location: ' . $loc, true, 302);
exit;
}
if(isset($_GET['m'])==false) header('Location: ?m=agent');
const BSPHP_SET='AGENT';
require ('../LibBsphp/Global.Bsphp.Inc.php');
?>