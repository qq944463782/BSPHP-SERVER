<?php

defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');

$GLOBALS['WEBAPI_META'] = array(
    'id'    => 'register_free',
    'name'  => '网页注册接口',
    'path'  => '/index.php',
    'method'=> 'GET',
    'fixed' => array('m' => 'webapi', 'c' => 'register_free', 'a' => 'index'),
    'params'=> array(
        array('name' => 'u', 'label' => '邀请码', 'optional' => true, 'tip' => '邀请码/推荐人账号，没有不要传留空'),
        array('name' => 'daihao', 'label' => '软件代号', 'optional' => true, 'tip' => '选择软件代号（配置页自动显示软件下拉）'),
        array('name' => 'show_extra', 'label' => '显示拓展参数', 'optional' => true, 'tip' => '1=显示拓展参数(默认), 0=隐藏拓展参数'),
        array('name' => 'success_url', 'label' => '注册成功跳转URL', 'optional' => true, 'tip' => '注册成功后跳转地址，支持 http(s):// 或 /path')
    )
);

if (defined('WEBAPI_SCAN')) return;

/**
 * 网页注册接口-无需激活码 - 访问: index.php?m=webapi&c=register_free&a=index
 */
class register_free
{
    private $user_str_log;
    private $show_extra = 1;
    private $success_url = '';
    private $user_extra_defs = array();
    private $daihao = 0;

    function __construct()
    {
        Plug_Load_Modules_Common('applib', 'appen_inc');
        Plug_Load_Modules_Common('applib', 'appen_appuser');
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');
    }

    /**
     * 注册页主流程
     * 1) 解析 URL/POST 参数：daihao、show_extra、success_url、u
     * 2) 根据 daihao 读取软件维度拓展字段定义（app_user_extra）
     * 3) 提交时先注册全局用户，再按 daihao 创建软件用户并写入 L_user_extra
     */
    function call_index()
    {
        $daihao_from_url = (int)Plug_Set_Get('daihao');
        $daihao_post = (int)Plug_Set_Post('daihao');
        $this->daihao = $daihao_post > 0 ? $daihao_post : $daihao_from_url;

        $this->user_extra_defs = $this->load_user_extra_defs($this->daihao);
        $show_extra_default = count($this->user_extra_defs) > 0 ? 1 : 0;
        $show_extra_value = Plug_Set_Get('show_extra');
        if ($show_extra_value === '') {
            $show_extra_value = Plug_Set_Post('show_extra');
        }
        $this->show_extra = $this->parse_show_extra($show_extra_value, $show_extra_default);

        $success_url_value = Plug_Set_Get('success_url');
        if ($success_url_value === '') {
            $success_url_value = Plug_Set_Post('success_url');
        }
        $this->success_url = $this->sanitize_success_url($success_url_value);

        // 邀请码：优先表单提交，其次 URL 参数
        $u_from_url = Plug_Set_Get('u');
        $u_post = Plug_Set_Post('u');
        $u = $u_post !== '' ? $u_post : $u_from_url;

        // 优先按 UID 查询，再按账号查询，得到标准邀请人账号
        if ($u !== '') {
            $u_raw = trim((string)$u);
            $u_safe = addslashes($u_raw);
            $resolved = '';

            // 先按 UID 查找
            if (ctype_digit($u_raw) && (int)$u_raw > 0) {
                $sql = "SELECT `user_user` FROM `bs_php_user` WHERE `user_uid` = '{$u_safe}' LIMIT 1";
                $info = Plug_Query_Array($sql);
                if ($info && !empty($info['user_user'])) {
                    $resolved = $info['user_user'];
                }
            }

            // UID 未匹配到，再按账号查找
            if ($resolved === '') {
                $sql = "SELECT `user_user` FROM `bs_php_user` WHERE `user_user` = '{$u_safe}' LIMIT 1";
                $info = Plug_Query_Array($sql);
                if ($info && !empty($info['user_user'])) {
                    $resolved = $info['user_user'];
                }
            }

            if ($resolved !== '') {
                $u = $resolved;
            }
        }

        $user = Plug_Set_Post('user');
        $pwda = Plug_Set_Post('pwda');
        $pwdb = Plug_Set_Post('pwdb');
        $qq = Plug_Set_Post('qq');
        $mail = strtolower(trim((string)Plug_Set_Post('mail')));
        $log_name = '';
        $Submitadd = Plug_Set_Post('Submitadd');

        if ($Submitadd) {
            $app_user_extra_json = '';
            if ($this->show_extra && !empty($this->user_extra_defs)) {
                $user_extra_err = Plug_User_Extra_Validate_Required($this->user_extra_defs);
                if ($user_extra_err !== null) {
                    $log_name = $user_extra_err;
                }
                if ($log_name === '') {
                    $app_user_extra_json = Plug_User_Extra_Build_From_Post($this->user_extra_defs, null);
                }
            }

            if ($log_name === '') {
                $app_info = null;
                if ($this->daihao > 0) {
                    $app_info = $this->load_app_info($this->daihao);
                    if (!$app_info) {
                        $log_name = 'daihao不存在';
                    }
                }
            }

            if ($log_name === '') {
                $log = Plug_User_Re_Add($user, $pwda, $pwdb, $qq, $mail, $u, '', '', '', '');
                if ($log == 1005) {
                    if ($this->daihao > 0) {
                        $uid = Plug_Query_One('bs_php_user', 'user_user', $user, '`user_uid`');
                        $app_re_date = isset($app_info['app_re_date']) ? (int)$app_info['app_re_date'] : 0;
                        $vip_unix = $app_re_date > 0 ? PLUG_UNIX() + $app_re_date : 0;
                        Plug_App_Login_Add_Key($uid, $this->daihao, $vip_unix, '', $user, $user, '0', 0, 0, $app_user_extra_json);
                    }
                    $log_name = '注册成功 ';
                    if ($this->success_url !== '') {
                        header('Location: ' . $this->success_url);
                        exit;
                    }
                } else {
                    $log_name = $this->user_str_log[$log] . $log;
                }
            }
        }

        $show_extra = $this->show_extra;
        $success_url = $this->success_url;
        $user_extra_defs = $this->user_extra_defs;
        $daihao = $this->daihao;
        $show_extra_empty_tip = ($this->show_extra == 1 && $this->daihao > 0 && count($this->user_extra_defs) === 0) ? '当前软件未配置软件用户拓展字段(app_user_extra)' : '';
        include Plug_Load_Default_Path();
    }

    /**
     * 解析 show_extra 开关值
     * - 支持: 1/0, true/false, yes/no
     * - 空值时回退到 default（通常由是否存在拓展字段决定）
     */
    private function parse_show_extra($value, $default = 1)
    {
        $value = trim((string)$value);
        if ($value === '') {
            return (int)$default;
        }
        if ($value === '1' || strtolower($value) === 'true' || strtolower($value) === 'yes') {
            return 1;
        }
        if ($value === '0' || strtolower($value) === 'false' || strtolower($value) === 'no') {
            return 0;
        }
        return (int)$default;
    }

    /**
     * success_url 安全过滤
     * 仅允许:
     * - 站内相对路径（/xxx）
     * - http(s) 绝对地址
     * 禁止换行，避免 Header 注入。
     */
    private function sanitize_success_url($url)
    {
        $url = trim((string)$url);
        if ($url === '') {
            return '';
        }
        // 限制为相对路径或 http(s) 链接，避免注入非法 Header。
        if (strpos($url, "\r") !== false || strpos($url, "\n") !== false) {
            return '';
        }
        if (strpos($url, '/') === 0) {
            return $url;
        }
        if (preg_match('/^https?:\/\/[^\s]+$/i', $url)) {
            return $url;
        }
        return '';
    }

    /**
     * 读取软件维度用户拓展字段定义（来源: bs_php_appinfo.app_user_extra）
     * 仅按当前 daihao 读取，不回退全局 user_extra 配置。
     */
    private function load_user_extra_defs($daihao = 0)
    {
        $defs = Plug_App_User_Extra_Fields_Def((int)$daihao);
        return is_array($defs) ? $defs : array();
    }

    /**
     * 读取软件信息（用于校验 daihao 与 app_re_date）
     */
    private function load_app_info($daihao)
    {
        $daihao = (int)$daihao;
        if ($daihao <= 0) {
            return null;
        }
        $sql = "SELECT * FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao}' LIMIT 1";
        return Plug_Query_Array($sql);
    }
}

