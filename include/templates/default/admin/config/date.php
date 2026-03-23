<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo ��������������������������������������������������������������������������������('BSPHP-date'); ?></title>
<link rel="stylesheet" href="<?php echo ������������������������������������������������������������������������() ?>layui/css/layui.css?t=1515376178709" media="all">
<script src="<?php echo ������������������������������������������������������������������������() ?>layui/layui.js?t=1515376178709"></script>
<link rel="stylesheet" type="text/css" href="<?PHP ECHO ������������������������������������������������������������������������(); ?>skin/style/base.css">
</head>
<body leftmargin='8' topmargin='8'>
<!--  标题  -->
<div class="nametable">
<div id="texttale"  class="texttale"><?php echo ��������������������������������������������������������������������������������('时间差计算'); ?></DIV>
[<a href="javascript:window.location.reload();">+</a>]</div>
<!--  快捷  -->
<div id="Shortcut">
<ul>
<li><a href="index.php?m=admin&c=config&a=sys"><?php echo ��������������������������������������������������������������������������������('返回上层'); ?></a></li>
</ul>
</div>
<form name="form1" action="" method="POST">
<table width="530" border="0" cellpadding="0" cellspacing="0" align="center">
<tr bgcolor="#FFFFFF">
<td width="20%" height="52" align="right">当前系统时间：</td>
<td width="80%" height="52"><?php echo $date; ?></td>
</tr>
<tr bgcolor="#FFFFFF">
<td height="52" align="right">需要计算时间：</td>
<td height="52"><input name="xitong" type="text"  class="layui-input" placeholder="务必格式:2012-06-18 11:31:561" id="xitong" value="<?PHP ECHO $xitong; ?>" size="25">
</td>
</tr>
<tr bgcolor="#FFFFFF">
<td height="52" align="right">时间差：</td>
<td height="52"><?php echo $cha; ?></td>
</tr>
<tr>
<td height="52" colspan="2" align="center">
<div align="center">
<input name="add" type="submit"  class="layui-btn layui-btn-sm layui-btn-normal" id="add" style="width:100px" value="计算">
</div></td>
</tr>
</table>
<div id="foot">Copyright &copy;2009-2018 <a href="http://www.bsphp.com" target="_blank">BsphpCms <?php echo BSPHP_VERSION; ?></a>   Bsphp.com <br>
All Rights Reserved </div>
</form>