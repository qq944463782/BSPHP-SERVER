<?php
$reqUri=$_SERVER['REQUEST_URI'] ?? '';
$path=parse_url($reqUri, PHP_URL_PATH) ?? '';
$agentSuffix='/agent';
if ($path !=='' && substr($path, -1) !=='/' && substr($path, -strlen($agentSuffix))===$agentSuffix) {
$q=parse_url($reqUri, PHP_URL_QUERY);
$loc=$path . '/index.php' . ($q !==null && $q !=='' ? '?' . $q : '');
header('Location: ' . $loc, true, 302);
exit;
}
if(isset($_GET['m'])==false) header('Location: ?m=agent');
const BSPHP_SET='AGENT';
require ('../LibBsphp/Global.Bsphp.Inc.php');
?>