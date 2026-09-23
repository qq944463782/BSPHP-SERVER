<?php
$reqUri=$_SERVER['REQUEST_URI'] ?? '';
$path=parse_url($reqUri, PHP_URL_PATH) ?? '';
$adminSuffix='/admin';
if ($path !=='' && substr($path, -1) !=='/' && substr($path, -strlen($adminSuffix))===$adminSuffix) {
$q=parse_url($reqUri, PHP_URL_QUERY);
$loc=$path . '/index.php' . ($q !==null && $q !=='' ? '?' . $q : '');
header('Location: ' . $loc, true, 302);
exit;
}
if (isset($_GET['m'])==false and isset($_GET['c'])==false) header('Location: ?m=admin');
$resapiCorsOrigins=array(
'*'
);
$resapiM=$_GET['m'] ?? '';
if ($resapiCorsOrigins && $resapiM==='resapiadmin') {
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
const BSPHP_SET='ADMIN';
require('../LibBsphp/Global.Bsphp.Inc.php');
