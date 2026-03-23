<?php

/***********************接口介绍说明******************************************
 * appcustom.in
 * 取自定义配置值（后台应用管理-自定义配置中配置的 field_key）
 *
 * 请求参数：
 *   info   = 要获取的 field_key，多个用 | 分隔，例：API_URL|APP_NAME|NOTICE

 *   user   = (账号模式) 需登录配置时传账号 可空sessl验证用户是否登录
 *   pwd    = (账号模式) 需登录配置时传密码 可空sessl验证用户是否登录
 *   icid   = (卡模式) 需登录配置时传卡号 可空sessl验证卡是否登录
 *   icpwd  = (卡模式) 需登录配置时传卡密 可空sessl验证卡是否登录
 *
 * 返回说明：
 *   将 info 中每个 field_key 替换为对应的 field_val 后输出，格式与 info 一致
 *   例：info=API_URL|APP_NAME 且 API_URL=xxx、APP_NAME=yyy → 返回 xxx|yyy
 *
 * 权限与到期：
 *   login_required=0 的配置：无需登录，直接返回
 *   login_required=1 的配置：需传 user+pwd(账号模式) 或 icid+icpwd(卡模式) 才返回
 *   expire_allow=0 且需登录时：仅用户/卡未过期才返回该配置值
 *
 * 类型说明：
 *   code_textarea 类型存储为 Base64，接口返回原始值，客户端需自行 Base64 解码
 *
 * 调用示例：
 *   &api=appcustom.in&info=API_URL|APP_NAME|NOTICE
 *****************************************************************************
 */

$info = Plug_Set_Data('info');  # 要获取的 field_key 列表，用 | 分隔
$daihao = PLUG_DAIHAO();
$get_type = Plug_Set_Data('get_type');
if ($info == '' || trim($info) == '') {
    Plug_Echo_Info('', 200);
    exit;
}

$keys = array_map('trim', explode('|', $info));
$keys = array_filter($keys);
usort($keys, function ($a, $b) {
    return strlen($b) - strlen($a);
});  # 长 key 先替换，避免短 key 误替换


# 通过账号密码信息获取
$user = Plug_Set_Data('user');
$pwd = Plug_Set_Data('pwd');
$log = Plug_Is_User_Account($user, $pwd);
if ($log == 1011) {
    $is_login_ok = true;
    $arr_app_user = Plug_Get_App_User_Info($uid, $daihao);
}
$app_moshi = Plug_App_DaTa('app_MoShi');
$is_login_ok = false;
$arr_app_user = null;

if ($app_moshi == 'CardTerm' || $app_moshi == 'CardPoint') {
    # 卡模式：icid + icpwd 验证
    $car_id = Plug_Set_Data('icid');
    $car_pwd = Plug_Set_Data('icpwd');
    if ($car_id != '' || $car_pwd != '') {
        $log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);
        if ($log == 1080) {
            $is_login_ok = true;
            //查询SQL语句
            $sql = "SELECT*FROM`bs_php_pattern_login`WHERE`L_User_uid`='{$car_id}'AND`L_ic_pwd`='{$car_pwd}' AND `L_daihao`='{$daihao}';";
            $arr_app_user = Plug_Query_Assoc($sql);
        } else {
            if ($log != 1080) {
                Plug_Echo_Info('未登陆,登陆后才能获取配置值', 5033);
            }
        }
    } else {
        $car_id = Plug_Get_Session_Value('ic_carid');
        $car_pwd = Plug_Get_Session_Value('ic_pwd');
        $log = Plug_App_Is_Login($car_id, $car_pwd, $daihao);

        if ($log == 1080) {
            $is_login_ok = true;
            //查询SQL语句
            $sql = "SELECT*FROM`bs_php_pattern_login`WHERE`L_User_uid`='{$car_id}'AND`L_ic_pwd`='{$car_pwd}' AND `L_daihao`='{$daihao}';";
            $arr_app_user = Plug_Query_Assoc($sql);
        } else {

            Plug_Echo_Info('未登陆,登陆后才能获取配置值', 5033);
        }
    }
} else {
    # 账号模式：user + pwd 或 session 验证
    $user = Plug_Set_Data('user');
    $userpwd = Plug_Set_Data('pwd');
    $user = Plug_UserTageToUser($user, $userpwd);
    if ($user != '' && $userpwd != '') {
        $log = Plug_Is_User_Account($user, $userpwd);
        if ($log == 1011) {
            $user_row = Plug_Query_One('bs_php_user', 'user_user', $user, 'user_uid');
            $uid = $user_row && isset($user_row['user_uid']) ? $user_row['user_uid'] : 0;
            $is_login_ok = true;
            $arr_app_user = Plug_Get_App_User_Info($uid, $daihao);
        }
    } else {
        $uid = Plug_Get_Session_Value('USER_UID');
        if ($uid > 0) {
            $log = Plug_User_Is_Login_Seesion();
            if ($log == 1047) {
                $is_login_ok = true;
                $arr_app_user = Plug_Get_App_User_Info($uid, $daihao);
            }
        }
    }
}



# 按 key 查配置并替换 info 中占位符
foreach ($keys as $key) {
    $key_safe = addslashes($key);
    $sql = "SELECT field_val, login_required, expire_allow FROM `bs_php_app_custom_config` WHERE field_key='{$key_safe}' AND app_daihao=" . intval($daihao) . " LIMIT 1";
    $row = Plug_Query_Assoc($sql);

    $val = $row['field_val'];
    if ($row && isset($row['field_val'])) {
        $login_req = $row['login_required']; //登陆后可取 0=无需登录 1=需登录 2=需要登陆切没过期才可取
        $expire_allow = $row['expire_allow']; //没到期可取 0=未到期才可取 1=过期也可取

        if ($login_req == 1) {

            if (!$is_login_ok) {
                $val = '';  # 需登录但未登录，返回空
                Plug_Echo_Info($key_safe . '未登陆,登陆后才能获取配置值', 5033);
            }
            //正常返回配置值    
            $val = $row['field_val'];
        } elseif ($login_req == 2) {


            if (!$is_login_ok) {
                $val = '';  # 需登录但未登录，返回空
                Plug_Echo_Info($key_safe . '未登陆,登陆后才能获取配置值', 5033);
            }

            //登陆卡模式扣点模式判断 判断是否到期的配置 扣点不需要时间判断
            if ($app_moshi == 'CardPoint') {

                if ($arr_app_user['L_vip_unix'] > 0) {
                    $val = '';
                    Plug_Echo_Info($key_safe . '未登陆,登陆后才能获取配置值', 5033);
                }
            }
            //扣点不需要时间判断
            if ($app_moshi == 'LoginPoint') {
                if ($arr_app_user['L_vip_unix'] > 0) {
                    $val = '';
                    Plug_Echo_Info($key_safe . '未登陆,登陆后才能获取配置值', 5033);
                }
            }

            //登录卡模式判断 判断是否到期的配置 时间判断的配置
            if ($app_moshi == 'CardTerm') {
                if ($arr_app_user['L_vip_unix'] < PLUG_UNIX()) {
                    $val = '';
                    Plug_Echo_Info($key_safe . '未登陆,登陆后才能获取配置值', 5033);
                }
            }

            //登录账号模式判断 判断是否到期的配置 时间判断的配置
            if ($app_moshi == 'LoginTerm') {
                if ($arr_app_user['L_vip_unix'] < PLUG_UNIX()) {
                    $val = '';
                    Plug_Echo_Info($key_safe . '未登陆,登陆后才能获取配置值', 5033);
                }
            }
        } else {
            $val = $row['field_val'];
        }
        $info = str_replace($key, $val, $info);
    }
}


Plug_Echo_Info($info, 2000);
