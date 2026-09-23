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
$resapiCorsOrigins=array(
'*'
);
$resapiM=$_GET['m'] ?? '';
if ($resapiCorsOrigins && $resapiM==='resapiagent') {
$origin=$_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin !=='' && in_array($origin, $resapiCorsOrigins, true)) {
header('Access-Control-Allow-Origin: ' . $origin);
header('Access-Control-Allow-Credentials: true');
header('Vary: Origin');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, bs_seesion, X-Bs-Seesion');
header('Access-Control-Max-Age: 600');
}
if (($_SERVER['REQUEST_METHOD'] ?? '')==='OPTIONS') {
http_response_code(204);
exit;
}
}
const BSPHP_SET='AGENT';
require ('../LibBsphp/Global.Bsphp.Inc.php');
?>