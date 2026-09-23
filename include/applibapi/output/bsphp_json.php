<?php
header("Content-type: application/json; charset=utf-8");
/**
 * 输出文件
 * 
 *  * 文件名_bsphp_output(显示内容)  输出显示函数
 */


/**
 * @输出给客户端mxl格式文件
 */
function bsphp_json_bsphp_output($data, $code)
{


    if (is_array($data)) {

        /*
        //参数修改
        $code_array_php='';
        foreach ($data as $param_value => $key)
        {

            $key = addslashes($key);
            $code_array_php .= "\"$param_value\":\"$key\",";
        }
        
        $data=$code_array_php.'\"Bsphp\":\"NULL\"';
        $data = "{{$data}}";  */

        $data = json_encode($data);
    } else {
        // $data_sgin = $data;
        // $data = '"'.$data.'"' ;
    }




    $json_array = array();

    $json_array['response']['data'] = $data; //数据内容
    $json_array['response']['code'] = $code; //数据内容编码代号
    $json_array['response']['SeSsL'] = session_id(); //session/BSphpSeSsL
    $json_array['response']['unix'] = "" . PLUG_UNIX(); //系统时间
    $json_array['response']['date'] = PLUG_DATE(); //系统时间
    $json_array['response']['appsafecode'] = Plug_Set_Data('appsafecode'); //原样返回安全代码
 



    $data = json_encode($json_array, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);



    return ($data);
}
