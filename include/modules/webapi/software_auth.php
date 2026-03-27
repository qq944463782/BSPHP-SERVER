<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'software_auth',
    'name'  => '软件登录/注册/找回密码 + 公告',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'software_auth', 'a' => 'index'),
    'params'=> array(
        array('name' => 'daihao', 'label' => '软件代号', 'required' => true),
        array('name' => 'BSphpSeSsL', 'label' => '验证串,长度64位', 'required' => true),
    ),
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 独立软件 WebAPI 页面（公告 + 登录 + 注册 + 找回密码）
 * 访问: index.php?m=webapi&c=software_auth&a=index&daihao=XXX&BSphpSeSsL=XXXX
 */
class software_auth
{
    const OTP_EXPIRE = 1800; // 验证码有效期秒
    const OTP_SMS_KEY = 'sa_otp_sms_';
    const OTP_EMAIL_KEY = 'sa_otp_email_';

    private $user_str_log;

    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
        $this->user_str_log = plug_load_langs_array('user', 'user_str_log');
        $BSphpSeSsL = Plug_Set_Get('BSphpSeSsL');
        //$BSphpSeSsL不够64位提示$BSphpSeSsL错误
        if ($BSphpSeSsL != '' && strlen($BSphpSeSsL) != 64) {
            Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL错误 长度64位,请重新获取'));
            exit;
        }


       
    }

    private function otp_sms_key($scene, $area, $phone)
    {
        $p = preg_replace('/[^0-9]/', '', $phone);
        return self::OTP_SMS_KEY . $scene . '_' . $area . '_' . $p;
    }

    private function otp_email_key($scene, $email)
    {
        return self::OTP_EMAIL_KEY . $scene . '_' . md5(strtolower(trim($email)));
    }

    private function set_otp_sms($scene, $area, $phone, $code)
    {
        $key = $this->otp_sms_key($scene, $area, $phone);
        Plug_Set_Session_Value($key, array('code' => $code, 'exp' => time() + self::OTP_EXPIRE));
    }

    private function verify_otp_sms($scene, $area, $phone, $input_code)
    {
        $key = $this->otp_sms_key($scene, $area, $phone);
        $data = Plug_Get_Session_Value($key);
        if (!$data || $data['exp'] < time()) {
            return false;
        }
        $ok = (string)$data['code'] === (string)$input_code;
        if ($ok) {
            // 清理，避免验证码被重复使用
            //使用10次最多
            $count = Plug_Get_Session_Value($key .$input_code. '_count');
            if ($count === null) {
                $count = 0;
            }
            $count++;
            if ($count > 10) {
                Plug_Set_Session_Value($key, null);
               
               
            }   
            Plug_Set_Session_Value($key .$input_code. '_count', $count);
        }
        return $ok;
    }

    private function set_otp_email($scene, $email, $code)
    {
        $key = $this->otp_email_key($scene, $email);
        Plug_Set_Session_Value($key, array('code' => $code, 'exp' => time() + self::OTP_EXPIRE));
    }

    private function verify_otp_email($scene, $email, $input_code)
    {
        $key = $this->otp_email_key($scene, $email);
        $data = Plug_Get_Session_Value($key);
        if (!$data || $data['exp'] < time()) {
            return false;
        }
        $ok = (string)$data['code'] === (string)$input_code;
        if ($ok) {
            // 清理，避免验证码被重复使用
        
            //相同验证码最多使用10次清理
            $count = Plug_Get_Session_Value($key .'_'. $input_code . '_count');
            if ($count === null) {
                $count = 0;
            }
            $count++;
            if ($count > 10) {
                Plug_Set_Session_Value($key, null);
               
              
            }   
            Plug_Set_Session_Value($key .'_'. $input_code . '_count', $count);
        }
        return $ok;
    }

    /**
     * 页面入口：输出 HTML
     */
    function call_index()
    {
        $BSphpSeSsL = Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        }
        Plug_Session_Open($BSphpSeSsL);

        $daihao = Plug_Set_Get('daihao');
        if ($daihao == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'daihao必须传入'));
        }

        // URL 参数：u=邀请码/推荐人（可选）
        // 如果 u 非空，则优先使用它进行注册，并禁用前端“邀请码”输入。
        $invite_u = Plug_Set_Get('u');
        $invite_u = trim((string)$invite_u);
        // 限制格式，避免注入/破坏 JS/SQL；如需更宽松规则再调整
        $invite_u = preg_replace('/[^a-zA-Z0-9_\-]/', '', $invite_u);
        if ($invite_u !== '') {
            Plug_Set_Session_Value('APP_INVITE_U', $invite_u);
        } else {
            Plug_Set_Session_Value('APP_INVITE_U', null);
        }

        // 读取公告：按软件代号
        $app_gg = '';
        $daihao_safe = addslashes($daihao);
        $res = Plug_Query("SELECT `app_gg` FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao_safe}' LIMIT 1");
        if ($res && ($row = Plug_Pdo_Fetch_Assoc($res)) && trim($row['app_gg'] ?? '') !== '') {
            $app_gg = trim($row['app_gg']);
        }

        // 注册配置（统一通过 re_user 页面设置）
        $user_re_set        = (int)Plug_Get_Configs_Value('user', 'user_re_set');          // 是否允许注册
        $user_re_pass_mail  = (int)Plug_Get_Configs_Value('user', 'user_re_pass_mail');    // 是否启用邮箱验证模式
        $re_mail            = (int)Plug_Get_Configs_Value('user', 're_mail');              // 邮箱是否必填 + 唯一
        $re_phone           = (int)Plug_Get_Configs_Value('user', 're_phone');             // 手机是否必填 + 唯一

        // 验证码开关
        $code_login         = (int)Plug_Get_Configs_Value('code', 'coode_login');
        $code_registration  = (int)Plug_Get_Configs_Value('code', 'coode_registration');
        $code_backpwd       = (int)Plug_Get_Configs_Value('code', 'coode_backpwd');

        // 传给模版
        $config_user = array(
            'user_re_set'       => $user_re_set,
            'user_re_pass_mail' => $user_re_pass_mail,
            're_mail'           => $re_mail,
            're_phone'          => $re_phone,
        );
        $code_flags = array(
            'login'        => $code_login,
            'registration' => $code_registration,
            'backpwd'      => $code_backpwd,
        );

        include Plug_Load_Default_Path(); // 对应 include/templates/default/webapi/software_auth/index.php
    }

    /**
     * 登录接口（JSON）
     * POST: user, pwd, code(可选), BSphpSeSsL(可选), daihao(可选)
     * URL: index.php?m=webapi&c=software_auth&a=login
     */
    function call_login()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        }
        Plug_Session_Open($BSphpSeSsL);

        $daihao = Plug_Set_Data_Post_Get('daihao');
        if ($daihao == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'daihao必须传入'));
        }

        $user = Plug_Set_Data_Post_Get('user');
        $pwd  = Plug_Set_Data_Post_Get('pwd');
        $code = Plug_Set_Data_Post_Get('code');

        if ($user == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请输入账号.')));
        }
        if ($pwd == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请输入密码.')));
        }

        if ((int)Plug_Get_Configs_Value('code', 'coode_login') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }

        $user = Plug_UserTageToUser($user, $pwd);
        $log  = Plug_User_Web_Login($user, $pwd);

        if ($log == 1011) {
            Plug_Print_Json(array('code' => 1011, 'msg' => Plug_Lang('登录成功')));
        } else {
            $msg = $this->user_str_log[$log] ?? Plug_Lang('登录失败');
            Plug_Print_Json(array('code' => $log, 'msg' => $msg));
        }
    }

    /**
     * 发送短信验证码（登录/注册/找回密码通用）
     * POST: scene(login|register|reset), mobile, area(区号，默认86), BSphpSeSsL
     */
    function call_send_sms_code()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        }
        Plug_Session_Open($BSphpSeSsL);

        $scene = Plug_Set_Post('scene');
        if (!in_array($scene, array('login', 'register', 'reset'), true)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('场景错误.')));
        }
        $mobile = Plug_Set_Post('mobile');
        $area   = trim(Plug_Set_Post('area'));
        if ($area == '') $area = '86';

        if ($mobile == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写手机号.')));
        }

        $mobile_safe = addslashes(preg_replace('/[^0-9]/', '', $mobile));
        if ($mobile_safe === '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('手机号格式不正确.')));
        }

        // 注册场景：如果手机号已存在，直接拒绝发送验证码，避免后续注册流程
        if ($scene === 'register') {
            $sql = "SELECT 1 FROM `bs_php_user` WHERE `user_Mobile` = '{$mobile_safe}' LIMIT 1";
            $user_exist = Plug_Query_Array($sql);
            if ($user_exist) {
                Plug_Print_Json(array('code' => 1142, 'msg' => Plug_Lang('当前手机号已经注册过，可直接用手机登录')));
            }
        }

        // 如果开启了“发送验证码图片验证码”功能，则先校验图形验证码
        $imgCode = Plug_Set_Post('code');
        $needCode = false;
        if ($scene === 'login' && (int)Plug_Get_Configs_Value('code', 'coode_login') === 1) {
            $needCode = true;
        } elseif ($scene === 'register' && (int)Plug_Get_Configs_Value('code', 'coode_registration') === 1) {
            $needCode = true;
        } elseif ($scene === 'reset' && (int)Plug_Get_Configs_Value('code', 'coode_backpwd') === 1) {
            $needCode = true;
        }
        if ($needCode) {
            $log = Plug_Push_Cood_Imges($imgCode);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('图片验证码错误')));
            }
        }

        if ($scene === 'login') {
            $sql = "SELECT 1 FROM `bs_php_user` WHERE `user_Mobile` = '{$mobile_safe}' LIMIT 1";
            $user = Plug_Query_Array($sql);
            if (!$user) {
                Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('手机号未绑定任何账号.')));
            }
        }

        $code = '';
        for ($i = 0; $i < 4; $i++) {
            $code .= mt_rand(0, 9);
        }
        $this->set_otp_sms($scene, $area, $mobile, $code);

        $sms_file = Plug_Get_Bsphp_Dir() . 'Plug/sms/sms_manager.class.php';
        if (!file_exists($sms_file)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('短信模块不存在')));
        }
       // require_once $sms_file;
        //$sms_manager = new sms_manager();
        //$ret = $sms_manager->send_verification_code_with_value($area, $mobile, $code, '');

        // 发送短信验证码
        $ret = Plug_Send_Sms_Code($area, $mobile, $code);
        if (isset($ret['code']) && $ret['code'] == 0) {
            // 系统日志记录：发短信
            $scene_log  = (string)$scene;
            $area_log   = (string)$area;
            $mobile_log = (string)$mobile_safe;
            $code_log   = (string)$code;
            $desc_log   = $scene_log . '|area=' . $area_log . '|mobile=' . $mobile_log . '|code=' . $code_log . '|result=success';
            Plug_Add_AppenLog('sms_log', $desc_log, $mobile_log);
            Plug_Print_Json(array('code' => 0, 'msg' => Plug_Lang('验证码已发送，请查收手机')));
        } else {
            $msg = isset($ret['msg']) ? $ret['msg'] : Plug_Lang('发送失败');
            // 系统日志记录：发短信（失败）
            $scene_log  = (string)$scene;
            $area_log   = (string)$area;
            $mobile_log = (string)$mobile_safe;
            $msg_safe   = is_string($msg) ? $msg : json_encode($msg, JSON_UNESCAPED_UNICODE);
            $msg_safe   = (string)$msg_safe;
            $code_log   = (string)$code;
            $desc_log   = $scene_log . '|area=' . $area_log . '|mobile=' . $mobile_log . '|code=' . $code_log . '|result=fail|' . $msg_safe;
            Plug_Add_AppenLog('sms_log', $desc_log, $mobile_log);
            Plug_Print_Json(array('code' => -1, 'msg' => $msg));
        }
    }

    /**
     * 短信验证码登录
     * POST: mobile, area(默认86), sms_code, BSphpSeSsL
     */
    function call_login_sms()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        }
        Plug_Session_Open($BSphpSeSsL);

        $mobile   = Plug_Set_Post('mobile');
        $area     = trim(Plug_Set_Post('area'));
        if ($area == '') $area = '86';
        $sms_code = Plug_Set_Post('sms_code');
        $code     = Plug_Set_Post('code');

        if ($mobile == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请输入手机号.')));
        }
        if ($sms_code == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请输入短信验证码.')));
        }

        // 若开启登录图形验证码，则先校验图形验证码
        if ((int)Plug_Get_Configs_Value('code', 'coode_login') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('图片验证码错误')));
            }
        }

        if (!$this->verify_otp_sms('login', $area, $mobile, $sms_code)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('短信验证码错误或已过期.')));
        }

        $mobile_safe = addslashes(preg_replace('/[^0-9]/', '', $mobile));
        $sql = "SELECT `user_uid`,`user_user`,`user_pwd`,`user_IsLock`,`user_LoGinNum`,`user_Login_ip`,`user_Login_date` 
                FROM `bs_php_user` WHERE `user_Mobile` = '{$mobile_safe}' LIMIT 1";
        $row = Plug_Query_Array($sql);
        if (!$row) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('手机号未绑定任何账号.')));
        }
        if ((int)$row['user_IsLock'] !== 0) {
            Plug_Print_Json(array('code' => 1021, 'msg' => Plug_Lang('账号已被锁定或未激活.')));
        }

        $uid        = (int)$row['user_uid'];
        $user       = $row['user_user'];
        $pwd_hash   = $row['user_pwd'];
        $param_date = PLUG_DATE();
        $param_ip   = Plug_Get_IP();
        $param_UNIX = PLUG_UNIX();

        $update_sql = "UPDATE `bs_php_user` 
                       SET `user_DenJi_tmp`='{$param_UNIX}',
                           `user_Login_ip`='{$param_ip}',
                           `user_Login_date`='{$param_date}',
                           `user_CaoShi`='{$param_UNIX}',
                           `user_LoGinNum`=`user_LoGinNum`+1
                       WHERE `user_uid`='{$uid}'";
        Plug_Query($update_sql);

        $param_cookies_pwd  = Plug_Cookies_Md7($pwd_hash);
        $param_LoGinNumFlag = 'ALL';
        $param_cookies_md7  = Plug_Cookies_Md7($uid . $param_cookies_pwd . $param_date . $param_ip . $param_LoGinNumFlag);

        plug_set_session_value('USER_UID', $uid);
        plug_set_session_value('USER_YSE', $param_cookies_pwd);
        plug_set_session_value('USER_DATE', $param_date);
        plug_set_session_value('USER_IP', $param_ip);
        plug_set_session_value('USER_MD7', $param_cookies_md7);

        Plug_Print_Json(array('code' => 1011, 'msg' => Plug_Lang('登录成功'), 'user' => $user));
    }

    /**
     * 发送邮箱验证码（登录/注册/找回密码通用）
     * POST: scene(login|register|reset), email, BSphpSeSsL
     */
    function call_send_email_code()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        }
        Plug_Session_Open($BSphpSeSsL);

        $scene = Plug_Set_Post('scene');
        if (!in_array($scene, array('login', 'register', 'reset'), true)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('场景错误.')));
        }
        $email = trim(Plug_Set_Post('email'));
        if ($email == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写邮箱.')));
        }
        //写正则验证邮箱格式
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('邮箱格式不正确.')));
        }
           

        $email_safe = addslashes($email);
        if ($scene === 'login') {
            $sql = "SELECT 1 FROM `bs_php_user` WHERE `user_email` = '{$email_safe}' LIMIT 1";
            $row = Plug_Query_Array($sql);
            if (!$row) {
                Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('该邮箱未绑定任何账号.')));
            }
        } elseif ($scene === 'register') {
            // 注册场景：如果邮箱已存在，直接拒绝发送验证码，避免后续注册流程
            $sql = "SELECT 1 FROM `bs_php_user` WHERE `user_email` = '{$email_safe}' LIMIT 1";
            $row = Plug_Query_Array($sql);
            if ($row) {
                Plug_Print_Json(array('code' => 1127, 'msg' => Plug_Lang('当前邮箱已经注册过，可直接用邮箱登录。')));
            }
        }

        // 如果开启了“发送验证码图片验证码”功能，则先校验图形验证码
        $imgCode = Plug_Set_Post('code');
        $needCode = false;
        if ($scene === 'login' && (int)Plug_Get_Configs_Value('code', 'coode_login') === 1) {
            $needCode = true;
        } elseif ($scene === 'register' && (int)Plug_Get_Configs_Value('code', 'coode_registration') === 1) {
            $needCode = true;
        } elseif ($scene === 'reset' && (int)Plug_Get_Configs_Value('code', 'coode_backpwd') === 1) {
            $needCode = true;
        }
        if ($needCode) {
            $log = Plug_Push_Cood_Imges($imgCode);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }

        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= mt_rand(0, 9);
        }
        $this->set_otp_email($scene, $email, $code);

        $site_name = Plug_Get_Configs_Value('sys', 'name');
        $subject   = $site_name . ' - ' . Plug_Lang('验证码');
        $body      = Plug_Lang('您的验证码是：') . $code . '，' . self::OTP_EXPIRE . '秒内有效，请勿泄露。';
        $ret       = Plug_Send_tomail($email, $subject, $body);
        if ($ret == 1 || $ret === true) {
            // 系统日志记录：发邮件
            $scene_log = (string)$scene;
            $email_log = (string)$email;
            $email_local = preg_replace('/@.*$/', '', (string)$email);
            $log_user = substr($email_local, 0, 20);
            $code_log = (string)$code;
            $desc_log = $scene_log . '|email=' . $email_log . '|code=' . $code_log . '|result=success';
            Plug_Add_AppenLog('email_log', $desc_log, $log_user);
            Plug_Print_Json(array('code' => 0, 'msg' => Plug_Lang('验证码已发送，请查收邮件')));
        } else {
            // 系统日志记录：发邮件（失败）
            $scene_log = (string)$scene;
            $email_log = (string)$email;
            $email_local = preg_replace('/@.*$/', '', (string)$email);
            $log_user = substr($email_local, 0, 20);
            $ret_safe = is_string($ret) ? $ret : json_encode($ret, JSON_UNESCAPED_UNICODE);
            $ret_safe = (string)$ret_safe;
            $code_log = (string)$code;
            $desc_log = $scene_log . '|email=' . $email_log . '|code=' . $code_log . '|result=fail:' . $ret_safe;
            Plug_Add_AppenLog('email_log', $desc_log, $log_user);
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('发送失败') . (is_string($ret) ? ': ' . $ret : '')));
        }
    }

    /**
     * 邮箱验证码登录
     * POST: email, email_code, BSphpSeSsL
     */
    function call_login_email()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        }
        Plug_Session_Open($BSphpSeSsL);

        $email      = trim(Plug_Set_Post('email'));
        $email_code = Plug_Set_Post('email_code');
        $code       = Plug_Set_Post('code');
        if ($email == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写邮箱.')));
        }
        if ($email_code == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请输入邮箱验证码.')));
        }

        // 若开启登录图形验证码，则先校验图形验证码
        if ((int)Plug_Get_Configs_Value('code', 'coode_login') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }

        if (!$this->verify_otp_email('login', $email, $email_code)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('邮箱验证码错误或已过期.')));
        }

        $email_safe = addslashes($email);
        $sql = "SELECT `user_uid`,`user_user`,`user_pwd`,`user_IsLock`,`user_LoGinNum`,`user_Login_ip`,`user_Login_date` 
                FROM `bs_php_user` WHERE `user_email` = '{$email_safe}' LIMIT 1";
        $row = Plug_Query_Array($sql);
        if (!$row) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('该邮箱未绑定任何账号.')));
        }
        if ((int)$row['user_IsLock'] !== 0) {
            Plug_Print_Json(array('code' => 1021, 'msg' => Plug_Lang('账号已被锁定或未激活.')));
        }

        $uid        = (int)$row['user_uid'];
        $user       = $row['user_user'];
        $pwd_hash   = $row['user_pwd'];
        $param_date = PLUG_DATE();
        $param_ip   = Plug_Get_IP();
        $param_UNIX = PLUG_UNIX();

        $update_sql = "UPDATE `bs_php_user` SET `user_DenJi_tmp`='{$param_UNIX}', `user_Login_ip`='{$param_ip}',`user_Login_date`='{$param_date}', `user_CaoShi`='{$param_UNIX}',`user_LoGinNum`=`user_LoGinNum` + 1 WHERE `user_uid`='{$uid}'";
        Plug_Query($update_sql);

        $param_cookies_pwd  = Plug_Cookies_Md7($pwd_hash);
        $param_LoGinNumFlag = 'ALL';
        $param_cookies_md7  = Plug_Cookies_Md7($uid . $param_cookies_pwd . $param_date . $param_ip . $param_LoGinNumFlag);

        plug_set_session_value('USER_UID', $uid);
        plug_set_session_value('USER_YSE', $param_cookies_pwd);
        plug_set_session_value('USER_DATE', $param_date);
        plug_set_session_value('USER_IP', $param_ip);
        plug_set_session_value('USER_MD7', $param_cookies_md7);

        Plug_Print_Json(array('code' => 1011, 'msg' => Plug_Lang('登录成功'), 'user' => $user));
    }

    /**
     * 注册接口（JSON）
     * POST: user, pwd, pwdb, qq, mail, mobile, extension(邀请码/推荐人), code
     * URL: index.php?m=webapi&c=software_auth&a=register
     */
    function call_register()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        }
        Plug_Session_Open($BSphpSeSsL);

        $daihao = Plug_Set_Data_Post_Get('daihao');
        if ($daihao == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'daihao必须传入'));
        }

        $user       = Plug_Set_Post('user');
        $pwd        = Plug_Set_Post('pwd');
        $pwdb       = Plug_Set_Post('pwdb');
        $qq         = Plug_Set_Post('qq');
        $mail       = strtolower(trim((string)Plug_Set_Post('mail')));
        $extension  = Plug_Set_Post('extension'); // 邀请码/推荐人
        // URL 参数 u 优先：若携带则禁止客户端更改邀请码
        $invite_u = Plug_Get_Session_Value('APP_INVITE_U');
        $invite_u = $invite_u !== null ? trim((string)$invite_u) : '';
        if ($invite_u !== '') {
            $extension = $invite_u;
        }
        $mobile     = Plug_Set_Post('mobile');
        $question   = Plug_Set_Post('question');
        $answer     = Plug_Set_Post('answer');
        $code       = Plug_Set_Post('code');

        // 注册总开关
        $user_re_set = (int)Plug_Get_Configs_Value('user', 'user_re_set');
        if ($user_re_set !== 1) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('当前系统已关闭注册功能')));
        }

        if ($user == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请输入账号.')));
        }
        if ($pwd == '' || $pwdb == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请输入密码并确认.')));
        }

        // 邮箱/手机是否必填：由 re_user 页面控制
        $re_mail  = (int)Plug_Get_Configs_Value('user', 're_mail');
        $re_phone = (int)Plug_Get_Configs_Value('user', 're_phone');
        $user_re_pass_mail = (int)Plug_Get_Configs_Value('user', 'user_re_pass_mail'); // 1=必须邮箱激活

        // 开启“邮箱验证注册”时，强制要求填写邮箱（即使 re_mail 未设为必填）
        if ($user_re_pass_mail === 1 && $mail == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('当前已启用邮箱验证注册，请填写邮箱.')));
        }

        if ($re_mail === 1 && $mail == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写邮箱.')));
        }
        if ($re_phone === 1 && $mobile == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写手机号.')));
        }

        if ((int)Plug_Get_Configs_Value('code', 'coode_registration') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }

        // 可以按 daihao 做不同规则（不同软件不同需求）
        // if ($daihao === 'APP_A') { ... } elseif ($daihao === 'APP_B') { ... }

        $log = Plug_User_Re_Add($user, $pwd, $pwdb, $qq, $mail, $extension, $mobile, $question, $answer);
        if ($log == 1005) {
            Plug_Print_Json(array('code' => 1005, 'msg' => Plug_Lang('注册成功')));
        } else {
            $msg = $this->user_str_log[$log] ?? Plug_Lang('注册失败');
            Plug_Print_Json(array('code' => $log, 'msg' => $msg));
        }
    }

    /**
     * 手机验证码注册
     * POST: mobile, area, sms_code, pwd, pwdb, BSphpSeSsL, daihao
     */
    function call_register_sms()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        Plug_Session_Open($BSphpSeSsL);
        $daihao = Plug_Set_Data_Post_Get('daihao');
        if ($daihao == '') Plug_Print_Json(array('code' => -1, 'msg' => 'daihao必须传入'));

        if ((int)Plug_Get_Configs_Value('user', 'user_re_set') !== 1) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('当前系统已关闭注册功能')));
        }

        $reg_user = trim((string)Plug_Set_Post('user')); // 注册登录账号（可选）
        $reg_user = preg_replace('/\s+/', '', $reg_user);

        $mobile   = Plug_Set_Post('mobile');
        $area     = trim(Plug_Set_Post('area'));
        if ($area == '') $area = '86';
        $sms_code = Plug_Set_Post('sms_code');
        $code     = Plug_Set_Post('code');
        $pwd      = Plug_Set_Post('pwd');
        $pwdb     = Plug_Set_Post('pwdb');
        $extension = Plug_Set_Post('extension'); // 邀请码/推荐人（可选）
        $invite_u  = Plug_Get_Session_Value('APP_INVITE_U');
        $invite_u  = $invite_u !== null ? trim((string)$invite_u) : '';
        if ($invite_u !== '') {
            $extension = $invite_u; // 服务端强制覆盖
        }

        if ($mobile == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写手机号.')));
        }

        if ($sms_code == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写短信验证码.')));
        }
        if ($pwd == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写密码.')));
        }
        if ($pwdb == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写确认密码.')));
        }
        if ($pwd !== $pwdb) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('两次密码不一致.')));
        }

        // 注册图形验证码开关
        if ((int)Plug_Get_Configs_Value('code', 'coode_registration') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }

        if (!$this->verify_otp_sms('register', $area, $mobile, $sms_code)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('短信验证码错误或已过期.')));
        }

        $mobile_clean = preg_replace('/[^0-9]/', '', $mobile);
        // 兜底拦截：客户端若绕过“发送验证码”步骤，也不允许已注册手机号继续注册
        $sql_exist = "SELECT 1 FROM `bs_php_user` WHERE `user_Mobile` = '{$mobile_clean}' LIMIT 1";
        $exist_row = Plug_Query_Array($sql_exist);
        if ($exist_row) {
            Plug_Print_Json(array('code' => 1142, 'msg' => Plug_Lang('当前手机号已经注册过，可直接用手机登录')));
        }
        $user_name    = ($reg_user !== '') ? $reg_user : $mobile_clean;
        $log          = Plug_User_Re_Add($user_name, $pwd, $pwdb, '', '', $extension, $mobile_clean, '', '');
        if ($log == 1005) {
            Plug_Print_Json(array('code' => 1005, 'msg' => Plug_Lang('注册成功')));
        } else {
            $msg = $this->user_str_log[$log] ?? Plug_Lang('注册失败');
            Plug_Print_Json(array('code' => $log, 'msg' => $msg));
        }
    }

    /**
     * 邮箱验证码注册
     * POST: email, email_code, pwd, pwdb, BSphpSeSsL, daihao
     */
    function call_register_email()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        Plug_Session_Open($BSphpSeSsL);
        $daihao = Plug_Set_Data_Post_Get('daihao');
        if ($daihao == '') Plug_Print_Json(array('code' => -1, 'msg' => 'daihao必须传入'));

        if ((int)Plug_Get_Configs_Value('user', 'user_re_set') !== 1) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('当前系统已关闭注册功能')));
        }

        $email      = strtolower(trim(Plug_Set_Post('email')));
        $email_code = Plug_Set_Post('email_code');
        $pwd        = Plug_Set_Post('pwd');
        $pwdb       = Plug_Set_Post('pwdb');
        $code       = Plug_Set_Post('code');
        $reg_user   = trim((string)Plug_Set_Post('user')); // 注册登录账号（可选）
        $reg_user   = preg_replace('/\s+/', '', $reg_user);
        $extension  = Plug_Set_Post('extension'); // 邀请码/推荐人（可选）
        $invite_u   = Plug_Get_Session_Value('APP_INVITE_U');
        $invite_u   = $invite_u !== null ? trim((string)$invite_u) : '';
        if ($invite_u !== '') {
            $extension = $invite_u; // 服务端强制覆盖
        }

        if ($email == '' || $email_code == '' || $pwd == '' || $pwdb == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写邮箱、验证码和密码.')));
        }
        if ($pwd !== $pwdb) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('两次密码不一致.')));
        }
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('邮箱格式不正确.')));
        }

        // 注册图形验证码开关
        if ((int)Plug_Get_Configs_Value('code', 'coode_registration') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }

        if (!$this->verify_otp_email('register', $email, $email_code)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('邮箱验证码错误或已过期.')));
        }

        // 兜底拦截：客户端若绕过“发送验证码”步骤，也不允许已注册邮箱继续注册
        $email_safe = addslashes($email);
        $sql_exist = "SELECT 1 FROM `bs_php_user` WHERE `user_email` = '{$email_safe}' LIMIT 1";
        $exist_row = Plug_Query_Array($sql_exist);
            if ($exist_row) {
            Plug_Print_Json(array('code' => 1127, 'msg' => Plug_Lang('当前邮箱已经注册过，可直接用邮箱登录。')));
        }

        $local = preg_replace('/@.*$/', '', $email);
        $local = preg_replace('/[^a-zA-Z0-9_]/', '', $local);
        if (strlen($local) < 2) {
            $local = 'u';
        }
        $user_name = $local . mt_rand(1000, 9999);
        $log       = Plug_User_Re_Add(($reg_user !== '') ? $reg_user : $email, $pwd, $pwdb, '', $email, $extension, '', '', '');
        if ($log == 1005) {
            Plug_Print_Json(array('code' => 1005, 'msg' => Plug_Lang('注册成功')));
        } else {
            $msg = $this->user_str_log[$log] ?? Plug_Lang('注册失败');
            Plug_Print_Json(array('code' => $log, 'msg' => $msg));
        }
    }

    /**
     * 短信验证码找回密码
     * POST: mobile, area, sms_code, pwd, pwdb, BSphpSeSsL
     */
    function call_resetpwd_sms()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        Plug_Session_Open($BSphpSeSsL);

        $mobile   = Plug_Set_Post('mobile');
        $area     = trim(Plug_Set_Post('area'));
        if ($area == '') $area = '86';
        $sms_code = Plug_Set_Post('sms_code');
        $pwd      = Plug_Set_Post('pwd');
        $pwdb     = Plug_Set_Post('pwdb');
        $code     = Plug_Set_Post('code');

        //细分
        if ($mobile == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写手机号.')));
        }
        if ($sms_code == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写短信验证码.')));
        }
        if ($pwd == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写新密码.')));
        }
        if ($pwdb == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写确认新密码.')));
        }
        if ($code == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写图片验证码.')));
        }
      
        if ($pwd !== $pwdb) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('两次密码不一致.')));
        }

        // 找回密码图形验证码开关
        if ((int)Plug_Get_Configs_Value('code', 'coode_backpwd') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }

        if (!$this->verify_otp_sms('reset', $area, $mobile, $sms_code)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('验证码错误或已过期.')));
        }

        $mobile_safe = addslashes(preg_replace('/[^0-9]/', '', $mobile));
        $row         = Plug_Query_Array("SELECT `user_uid` FROM `bs_php_user` WHERE `user_Mobile`='{$mobile_safe}' LIMIT 1");
        if (!$row) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('手机号未绑定任何账号.')));
        }
        $uid    = (int)$row['user_uid'];
        $pwd_md = Plug_Password_Md6($pwd);
        Plug_Query("UPDATE `bs_php_user` SET `user_pwd`='{$pwd_md}' WHERE `user_uid`='{$uid}' LIMIT 1");
        Plug_Print_Json(array('code' => 1033, 'msg' => Plug_Lang('密码已重置')));
    }

    /**
     * 邮箱验证码找回密码
     * POST: email, email_code, pwd, pwdb, BSphpSeSsL
     */
    function call_resetpwd_email()
    {
        $BSphpSeSsL = Plug_Set_Data_Post_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        Plug_Session_Open($BSphpSeSsL);

        $email      = trim(Plug_Set_Post('email'));
        $email_code = Plug_Set_Post('email_code');
        $pwd        = Plug_Set_Post('pwd');
        $pwdb       = Plug_Set_Post('pwdb');
        $code       = Plug_Set_Post('code');


        //细分
        if ($email == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写邮箱.')));
        }
        if ($email_code == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写邮箱验证码.')));
        }
        if ($pwd == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写新密码.')));
        }
        if ($pwdb == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写确认新密码.')));
        }


        if ($pwd !== $pwdb) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('两次密码不一致.')));
        }
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('邮箱格式不正确.')));
        }

        // 找回密码图形验证码开关
        if ((int)Plug_Get_Configs_Value('code', 'coode_backpwd') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }

        if (!$this->verify_otp_email('reset', $email, $email_code)) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('邮箱验证码错误或已过期.')));
        }

        $email_safe = addslashes($email);
        $row        = Plug_Query_Array("SELECT `user_uid` FROM `bs_php_user` WHERE `user_email`='{$email_safe}' LIMIT 1");
        if (!$row) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('该邮箱未绑定任何账号.')));
        }
        $uid    = (int)$row['user_uid'];
        $pwd_md = Plug_Password_Md6($pwd);
        Plug_Query("UPDATE `bs_php_user` SET `user_pwd`='{$pwd_md}' WHERE `user_uid`='{$uid}' LIMIT 1");
        Plug_Print_Json(array('code' => 1033, 'msg' => Plug_Lang('密码已重置')));
    }

    /**
     * 找回密码（密保）接口
     * POST: user, pwd(新), pwdb(确认), mibao(问题), daan(答案), code
     * URL: index.php?m=webapi&c=software_auth&a=findpwd
     */
    function call_findpwd()
    {
        $BSphpSeSsL = Plug_Set_Post('BSphpSeSsL') ?: Plug_Set_Get('BSphpSeSsL');
        if ($BSphpSeSsL == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'BSphpSeSsL必须传入'));
        }
        Plug_Session_Open($BSphpSeSsL);

        $daihao = Plug_Set_Post('daihao') ?: Plug_Set_Get('daihao');
        if ($daihao == '') {
            Plug_Print_Json(array('code' => -1, 'msg' => 'daihao必须传入'));
        }

        $user  = Plug_Set_Post('user');
        $pwd   = Plug_Set_Post('pwd');
        $pwdb  = Plug_Set_Post('pwdb');
        $mibao = Plug_Set_Post('mibao');
        $daan  = Plug_Set_Post('daan');
        $code  = Plug_Set_Post('code');

        //细分
        if ($user == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写账号.')));
        }
        if ($pwd == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写新密码.')));
        }
        if ($pwdb == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写确认新密码.')));
        }
        if ($mibao == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写密保.')));
        }
        if ($daan == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写答案.')));
        }
        if ($code == '' ) {
            Plug_Print_Json(array('code' => -1, 'msg' => Plug_Lang('请填写验证码.')));
        }

      

        if ((int)Plug_Get_Configs_Value('code', 'coode_backpwd') == 1) {
            $log = Plug_Push_Cood_Imges($code);
            if ((int)$log !== 1037) {
                Plug_Print_Json(array('code' => -11111, 'msg' => Plug_Lang('验证码错误')));
            }
        }

        $user = Plug_UserTageToUser($user, $pwdb);
        $log  = Plug_User_MiBao_Pwd($user, $pwd, $pwdb, $mibao, $daan);

        if ($log == 1033) {
            Plug_Print_Json(array('code' => 1033, 'msg' => Plug_Lang('密码已成功找回')));
        } else {
            $msg = $this->user_str_log[$log] ?? Plug_Lang('找回失败');
            Plug_Print_Json(array('code' => $log, 'msg' => $msg));
        }
    }
}

