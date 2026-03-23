<?php



/***********************接口介绍说明******************************************
 * GetPleaseregister.lg
 * 检测账号是否存在
 * *****************************************************************************
 */
#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');
$daihao = PLUG_DAIHAO();
$user = Plug_Set_Data('user');   #需要检测的账号

//获取用户信息
$sql = "SELECT*FROM`bs_php_user`WHERE`user_user`='$user';";
$user_array = Plug_Query_Assoc($sql);
if (!$user_array) {
  Plug_Echo_Info(Plug_Lang('[1001],账号不存在'), '1001');
}
Plug_Echo_Info(Plug_Lang('账号已经存在'), -1);
