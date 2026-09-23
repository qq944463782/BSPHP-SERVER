<?php


/**
 * 接口调试插件
 * bs_lib::get_configs_value("" . "sys", "" . "name")
 */
class log
{


    function __construct()
    {
        Plug_Session_Open();

        if (Plug_Get_Session_Value('ADMIN_UID') <= 0) {
            die('请登录');
            exit;
        }
    }



    function call_info()
    {

        $id = Plug_Set_Get('id');


        $sql = "SELECT * FROM `bs_php_api_dbug` WHERE `id` = '$id' ";
        $array = Plug_Query_Assoc($sql);
        if (!$array) {
            echo 'uuid错误;';
            exit;
        }



        $array_get = json_decode($array['get_data'], 1);
        $array_head = json_decode($array['head_data'], 1);

        if ($array_head == '') {

            $array['head_data'] = @iconv("GB2312", "UTF-8", $array['head_data']);

            $array['head_data'] = str_replace('\\', '/', $array['head_data']);

            $array_head = json_decode($array['head_data'], 1);
        }

        // print_r($array_head);


        include Plug_Load_Default_Path();
    }




    /**
     * @列表
     * ur
     */
    function call_table()
    {

        /**
         * 下拉框批量操作
         */
        $Submit_class = plug_set_post('Submit_class');
        $all = plug_set_post('all');
        $select_class = plug_set_post('select_class');
        if ($Submit_class) {
            if ($select_class == 3) { //删除
                $param_sql = "DELETE FROM `bs_php_api_dbug` WHERE  `bs_php_api_dbug`.`id` IN({$all});";
                if (plug_query($param_sql)) {

                    plug_print_json(array("" . 'code' => "" . '1', "" . 'msg' => call_my_Lang( "删除成功！")));
                } else {

                    plug_print_json(array("" . 'code' => "" . '1', "" . 'msg' => call_my_Lang("删除失败")));
                }
            } else if ($select_class == 2) { //删除
                $param_sql = "DELETE FROM `bs_php_api_dbug` ";
                if (plug_query($param_sql)) {

                    plug_print_json(array("" . 'code' => "" . '1', "" . 'msg' => call_my_Lang( "全部删除成功！")));
                } else {

                    plug_print_json(array("" . 'code' => "" . '1', "" . 'msg' => call_my_Lang("删除失败")));
                }
            } else {
                //$this->intelligence_admin_alert( call_my_Lang("你没有选择操作项目"));
                plug_print_json(array("" . 'code' => "" . '1', "" . 'msg' => call_my_Lang("你没有选择操作项目")));
            }
        } //按钮接受



        include Plug_Load_Default_Path();
    }
    /**
     * @列表返回的数据
     *
     */
    function call_table_json()
    {



        /*翻页参数初始化*/


        /*系统翻页*/
        $FANYE = (int)Plug_Set_Get('page');


        if ($FANYE > 0) {
            $db_ID = $FANYE - 1; //防止注入
        } else {
            $db_ID = 0;
            $FANYE = 1;
        }


        $shu = Plug_Set_Get('limit'); //每页显示 
        if ($shu == 0) $shu = 10;
        $db_ID = $db_ID * $shu;


        /**
         * @接收搜搜参数
         * 
         * 这里表显示以搜搜模式来显示
         */
        /*取得搜搜内容*/
        $soso = Plug_Set_Get('soso');
        $soso_id = (int)Plug_Set_Get('soso_id');
        $DESC_id = (int)Plug_Set_Get('DESC');
        //$soso_id > 0 ? $soso_id_show = $soso_id - 1 : $soso_id_show = 0;
        $DESC_id == 1 ? $DESC = 'ASC' : $DESC = 'DESC';


        /**
         * @定义搜搜字段
         * 
         * $soso_db_table = 要搜搜的字段
         */

        if ($soso_id == 1) {
            $soso_db_table = 'id';
        } else if ($soso_id == 2) {
            $soso_db_table = 'ip';
        } else if ($soso_id == 3) {
            $soso_db_table = 'uuid';
        } else if ($soso_id == 4) {
            $soso_db_table = 'Sessl';
        } else if ($soso_id == 5) {
            $soso_db_table = 'api';
        } else if ($soso_id == 6) {
            $soso_db_table = 'error';
        } else if ($soso_id == 7) {
            $soso_db_table = 'print_fun_data';
        }


        /*开始枚举*/
        $sql = "SELECT*FROM`bs_php_api_dbug`WHERE`$soso_db_table`LIKE '%$soso%'  ORDER BY`id`$DESC LIMIT $db_ID,$shu";
        $db_array_value = plug_query($sql);


        /**
         * @获取条数
         * //这里可以获取数据库优化的结果直接去行数sql
         */


        /*开始枚举*/
        $param_sql_rows = "SELECT  count(*) as 'hangshu'  FROM `bs_php_api_dbug` WHERE `$soso_db_table`LIKE '%$soso%'  ";

        /**
         * @获取条数
         */
        $param_my_rows_array = Plug_Query_Assoc($param_sql_rows);
        $zongshu = $param_my_rows_array["" . 'hangshu'];




        $while_array_list_all = array();
        while ($value = Plug_Pdo_Fetch_Assoc($db_array_value)) {
            // print_R($value);
            $while_array_list = $value;
            //返回列表的json信息
            $while_array_list['key'] = $value['id'];


            $while_array_list['time'] = date('Y-m-d H:i:s', $value['time']);;


            $while_array_list_all[] = $while_array_list;
        }



        //固定格式
        $json_array = array();
        $json_array["" . 'data'] = (array) $while_array_list_all;
        $json_array["" . 'code'] = 0;
        $json_array["" . 'msg'] = '';
        $json_array['count'] = $zongshu;



        plug_print_json($json_array);
    }




    function call_edit()
    {
        $id = Plug_Set_Get('id');
        $sql = "SELECT * FROM  `bs_php_api_dbug` WHERE  `id` = $id LIMIT 1";
        $array = plug_query_array($sql);

        $k = plug_set_post('sdate');



        include Plug_Load_Default_Path();
    }
}
