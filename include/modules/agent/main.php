<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') die('Not,This File Not Can in Ie Modules');



/*
 * Feature: 代理主控台(旧控制器)
 * Menu ID: legacy_main
 * 说明: 历史主控台控制器，负责代理首页及主框架入口逻辑。
 */
class main 
{

    private $GLOBALS_LANGS, $user_array;

    function __construct()
    {

        //开启session
        plug_session_open();
        $this->GLOBALS_LANGS = Plug_Load_Langs_Array('user', 'user_str_log');


        if (Plug_Get_Configs_Value('sys', 'stop_agent') == 0) {


            bs_lib::Alerts($this->GLOBALS_LANGS['sys'], Plug_Get_Configs_Value('sys', 'stop_agent_info'));

            exit;
        }

        $USER_UID = Plug_Get_Session_Value('USER_UID'); //登陆UID
      
        $this->user_array = Plug_Query_Array("SELECT * FROM bs_php_user WHERE user_uid = '{$USER_UID}'");
        if(!$this->user_array){
            //清空session
            Plug_Set_Session_Value('USER_UID', '');
            Plug_Alert2(Plug_Lang('你没有权限,请先登录。r'),'index.php?m=agent&c=index');
            
         
            exit;
        }
        



        //代理权限验证
        if ($this->user_array['user_daili'] == 0) {
            Plug_Alert2(Plug_Lang('你没有权限,请先登录。g'),'index.php?m=agent&c=index');
        
            exit;
        }

        /**
         * @登陆状态验证
         * 
         * 不等于登陆状态跳转到登陆页面
         */
        $login_log = Plug_User_Is_Login_Seesion();
        if ($login_log != 1047) {
            Plug_Alert(Plug_Lang('你没有权限,请先登录。'));
            Plug_Location('index.php');

            exit;
        }


    }


    /**
     * @控制面板-登录面板
     * 
     */
    function call_main()
    {


        include Plug_Load_Default_Path();
    }


    /**
     * @控制面板-登录面板
     * 
     */
    function call_center()
    {

        include Plug_Load_Default_Path();
    }


    /**
     * @控制面板-登录面板
     * 
     */
    function call_down()
    {

        include Plug_Load_Default_Path();
    }


    /**
     * @控制面板-登录面板
     * 
     */
    function call_left()
    {

        include Plug_Load_Default_Path();
    }


    /**
     * @控制面板-登录面板
     * 
     */
    function call_top()
    {


        include Plug_Load_Default_Path();
    }

    /**
     * @控制面板-登录面板
     * 
     */
    function call_info()
    {


        include Plug_Load_Default_Path();
    }
}
