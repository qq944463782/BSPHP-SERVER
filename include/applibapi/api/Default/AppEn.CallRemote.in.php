<?php

/***********************接口介绍说明******************************************
 * CallRemote.in
 * 网关侨接数据
 * *****************************************************************************
 */


$datas = Plug_Set_Data('datas');   #中转地址
$url = Plug_Get_Configs_Value("" . 'sys', 'admin_mail');
if (strpos($url, ":") > 0) {
} else {
   $url = "127.0.0.1:3365";
}

$data = @file_get_contents("http://$url/?bsphp=1&data=$datas&endtime=" . time());
Plug_Echo_Info($data, 200);
