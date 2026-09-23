<?php

/**
 * 输出文件
 * 
 *  * 文件名_bsphp_output(显示内容)  输出显示函数
 */


/**
 * @输出给客户端mxl格式文件
 */
function bsphp_xml_bsphp_output($data, $code)
{


    $data = "<?xml version=\"1.0\" encoding=\"utf-8\"?><response><data>{$data}</data><code>{$code}</code><date>" . PLUG_DATE() . "</date><unix>" . PLUG_UNIX() . "</unix><appsafecode>" . Plug_Set_Data('appsafecode') . "</appsafecode></response>";

    return ($data);
}
