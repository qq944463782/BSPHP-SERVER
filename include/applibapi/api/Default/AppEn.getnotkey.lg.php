<?php


/***********************接口介绍说明******************************************
 * getnotkey.lg
 * 查询绑定key是否存在
 * *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$key = Plug_Set_Data('key');   #需要查询特征码
//查询该key是否已经在数据库
$sql = "SELECT*FROM`bs_php_pattern_login`WHERE`L_daihao`='{$daihao}'AND`L_key_info`= '{$key}' LIMIT 1;";
$zhong_arr = Plug_Query_Assoc($sql);
if ($zhong_arr) {
  //重覆返回
  Plug_Echo_Info('10089', 10089);
} else {
  //没有重覆返回
  Plug_Echo_Info('10809', 10809);
}
