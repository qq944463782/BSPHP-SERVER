<?php



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
