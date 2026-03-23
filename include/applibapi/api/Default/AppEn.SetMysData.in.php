<?php

/***********************接口介绍说明******************************************
 * SetMysData.in
 * 远程配置设置
 * *****************************************************************************
 */

$keys = Plug_Set_Data('keys');   #键值
$datas = Plug_Set_Data('datas'); #存储参数，如果特殊内容建议base64编码或者utl编码等编码测试


$tmp = Plug_Set_mydata($keys, $datas);
if ($tmp) {
	//保存成功
	Plug_Echo_Info('ok', 200);
} else {
	//保存失败
	Plug_Echo_Info('no', 200);
}
