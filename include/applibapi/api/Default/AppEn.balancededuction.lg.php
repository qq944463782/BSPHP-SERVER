<?php



/**
 * **********************接口介绍说明******************************************
 * balancededuction.lg
 * 余额扣除
 * *****************************************************************************
 */



$daihao = PLUG_DAIHAO();
$balance = Plug_Set_Data('balance');           #扣除金额
$table = Plug_Set_Data('table');               #扣除日志标题，xxx原因消费扣除
$uid = Plug_Get_Session_Value('USER_UID');


#预设好文本字符串数组
$user_str_log = plug_load_langs_array("" . 'user', "" . 'user_str_log');
$appen_str_log = plug_load_langs_array('applib', 'appen_str_log');



$log = Plug_User_Is_Login_Seesion();
if ($log == 1047) {



  if ($balance <= 0) {

    Plug_Echo_Info($user_str_log[1100], 1100);
  }

  if ($table == '') {
    Plug_Echo_Info($user_str_log[1101], 1101);
  }



  $param_sql = "SELECT * FROM  `bs_php_user` WHERE  `user_uid` ='{$uid}'";
  $param_user_array = Plug_Query_Assoc($param_sql);
  if ($param_user_array["" . 'user_rmb'] <= 0)

    Plug_Echo_Info($user_str_log[1096], 1096);
  $balanceint = $param_user_array["" . 'user_rmb'] - $balance;
  if ($balanceint < 0)

    Plug_Echo_Info($user_str_log[1097], 1097);
  $param_sql = "UPDATE`bs_php_user`SET`user_rmb`=`user_rmb`-'{$balance}' WHERE`bs_php_user`.`user_uid`='{$uid}';";
  $param_tmp = Plug_Query($param_sql);


  if ($param_tmp) {
    Plug_Add_Rmb_Log($uid, (float)$param_user_array['user_rmb'], (float)$balanceint, $table);
    Plug_Add_AppenLog('money_buy_log', $table . Plug_Lang('，扣除') . $balance . Plug_Lang('，扣点前余额') . $param_user_array["" . 'user_rmb'], $param_user_array["" . 'user_user']);

    Plug_Echo_Info('[1098]' . $user_str_log[1098], 1098);
  } else {

    Plug_Add_AppenLog('exit_log', Plug_Lang("[错误号:88001]扣点执行失败|") . Plug_Lang('|扣点前余额') . $param_user_array["" . 'user_rmb'] . PLUG_DATE(), $balance, $param_user_array["" . 'user_user']);
    Plug_Echo_Info($user_str_log[1099], 1099);
  }
}
Plug_Echo_Info($user_str_log[$log], $log);
