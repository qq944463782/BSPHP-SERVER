<?php
if(isset($_GET['m'])==false AND isset($_GET['c'])==false) header('Location: ?m=admin');
const BSPHP_SET='ADMIN';
require ('../LibBsphp/Global.Bsphp.Inc.php');
?>