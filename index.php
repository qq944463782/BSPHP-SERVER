<?php
if (!file_exists('Data/install.txt'))
{
echo '<meta http-equiv="Refresh" content="0;URL=install/index.php" />';
exit();
}
if (isset($_GET['m'])==false)
$_GET['m']='index';
define('BSPHP_SET','INDEX');
require ('LibBsphp/Global.Bsphp.Inc.php');
?>