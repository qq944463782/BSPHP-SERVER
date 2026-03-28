<?php
$reqUri=$_SERVER['REQUEST_URI'] ?? '';
$path=parse_url($reqUri, PHP_URL_PATH) ?? '';
if ($path !=='' && substr($path, -1) !=='/' && str_ends_with($path, '/admin')) {
$q=parse_url($reqUri, PHP_URL_QUERY);
$loc=$path . '/index.php' . ($q !==null && $q !=='' ? '?' . $q : '');
header('Location: ' . $loc, true, 302);
exit;
}
if(isset($_GET['m'])==false AND isset($_GET['c'])==false) header('Location: ?m=admin');
const BSPHP_SET='ADMIN';
require ('../LibBsphp/Global.Bsphp.Inc.php');
?>