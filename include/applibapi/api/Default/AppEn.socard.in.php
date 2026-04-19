<?php
/*
<api>
  <name>socard.in</name>
  <title>激活码查询</title>
    <intro>接口参数说明</intro>
  <common_params type="1">
    <param name="api" type="1" required="true" dtype="string" desc="API接口名称"></param>
    <param name="BSphpSeSsL" type="1" required="true" dtype="string" desc="BSphpSeSsL连接Cookies"></param>
    <param name="date" type="1" required="false" dtype="string" desc="服务器时间超时验证；可空，后台设置超时0即关闭"></param>
    <param name="mutualkey" type="1" required="true" dtype="string" desc="通信认证Key，用作软件数据包交换数据验证串"></param>
    <param name="appsafecode" type="1" required="false" dtype="string" desc="封包劫持检测；可空，客户端提交参数给服务器时原样返回"></param>
    <param name="md5" type="1" required="false" dtype="string" desc="程序MD5；可空，后台MD5内容要为空"></param>
  </common_params>

  <params>
    <param name="cardid" required="false" type="string" desc="参数说明"></param>
  </params>
</api>
*/




/***********************接口介绍说明******************************************
 * socard.in
 * 激活码查询
 * *****************************************************************************
 */


$daihao = PLUG_DAIHAO();
$card = Plug_Set_Data('cardid');





if ($card == '') {
    $textfield = Plug_Lang('请输入激活码');
    Plug_Echo_Info($textfield, 200);
} else {



    $info = Plug_Query_One('bs_php_cardseries', 'car_name', $card, ' `car_id`,`car_zhuangtai`,`car_IsLock`,`car_pur_date` ');


    if (!$info) {
        $textfield = Plug_Lang("您查询的激活码不存在");
        Plug_Echo_Info($textfield, 200);
    } else {

        if ($info['car_zhuangtai'] == 1) {
            $textfield = Plug_Lang("您查询的授权码被冻结");
            Plug_Echo_Info($textfield, 200);
        } else {


            if ($info['car_IsLock'] == 1) {
                $bsphp_pattern_login = Plug_Query_One('bs_php_pattern_login', 'L_User_uid', $card, ' `L_id`, `L_vip_unix`');
                if ($bsphp_pattern_login) {
                    $textfield = Plug_Lang("授权码已激活:激活时间:") . $info["" . 'car_pur_date'] . Plug_Lang(" 到期时间:") . date('Y-m-d H:i:s', $bsphp_pattern_login['L_vip_unix']);
                    Plug_Echo_Info($textfield, 200);
                } else {

                    $bsphp_pattern_login = Plug_Query_One('bs_php_pattern_login', 'L_User_uid', $info["" . 'car_chong_uid'], ' `L_id`, `L_vip_unix`');
                    if ($bsphp_pattern_login) {
                        $textfield = Plug_Lang("授权码已激活:激活时间:") . $info["" . 'car_pur_date'] . Plug_Lang(" 到期时间:" ). date('Y-m-d H:i:s', $bsphp_pattern_login['L_vip_unix']);
                        Plug_Echo_Info($textfield, 200);
                    } else {
                        $textfield = Plug_Lang("授权码已激活:激活时间:" ). $info["" . 'car_pur_date'] . Plug_Lang(" 到期时间:已清理");
                        Plug_Echo_Info($textfield, 200);
                    }
                }
            } else {
                $textfield = Plug_Lang('您查询的授权码未激活');
                Plug_Echo_Info($textfield, 200);
            }
        }
    }
}
