<?php
/*
 * Feature: 下级代理卡类分配
 * Menu ID: my_agent_list
 * 说明: 代理列表详情中，将自己拥有的充值卡类权限继承/分配给直属下级。
 */
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET != 'AGENT') {
    die('Not,This File Not Can in Ie Modules');
}

class AgentCardTypeAssignFeature
{
    public $Grade, $GLOBALS_LANGS, $user_array, $user_str_log;

    function __construct()
    {
        plug_session_open();
        $this->user_str_log = Plug_Load_Langs_Array('user', 'user_str_log');

        if (Plug_Get_Configs_Value('sys', 'stop_agent') == 0) {
            Plug_alerts(Plug_Lang('系统维护中'), Plug_Get_Configs_Value('sys', 'stop_agent_info'));
            exit;
        }

        $user_UID = Plug_Get_Session_Value('USER_UID');
        $this->user_array = Plug_Query_Array("SELECT * FROM bs_php_user WHERE user_uid = '{$user_UID}'");
        if (!$this->user_array) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。没有权限请授权使用.'), 'index.php?m=agent');
            Plug_Location('index.php?m=agent');
            exit;
        }

        if ($this->user_array['user_daili'] == 0) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。c'), 'index.php?m=agent');
            Plug_Location('index.php');
            exit;
        }

        $login_log = Plug_User_Is_Login_Seesion();
        if ($login_log != 1047) {
            Plug_Alerts(Plug_Lang('你没有权限,请先登录。'), 'index.php?m=agent');
            Plug_Location('index.php');
            exit;
        }

        if (Plug_Get_Session_Value('USER_UID_IS') == 0) {
            Plug_ShowMsg(Plug_Lang("代理中心未授权,请授权后再使用。"), '');
            Plug_Set_Session_Value('USER_UID', 'Not');
            exit;
        }

        $this->Grade = Plug_Agent_Detect_Grade($this->user_array);
        Plug_Agent_Assert_Menu('my_agent_list', $this->Grade, false);
    }

    /**
     * 卡类分配页 / 保存
     * GET ids=下级UID
     */
    function call_table()
    {
        Plug_Agent_Assert_Menu('my_agent_list', $this->Grade, false);

        $uid = (int) Plug_Set_Get('ids');
        if ($uid <= 0) {
            $uid = (int) Plug_Set_Post('ids');
        }
        $sub = $this->find_sub_agent($uid);
        if (!$sub) {
            Plug_Alert(Plug_Lang('账号不存在.'));
        }

        $Submit = Plug_Set_Post('appenconfig');
        if ($Submit) {
            $rule = $this->build_assign_rule_from_post();
            if ($rule === false) {
                Plug_Print_Json(array('code' => 1, 'msg' => Plug_Lang('分配失败：只能分配你自己拥有的卡类权限。')));
            }
            $rule_sql = addslashes($rule);
            $self_uid = $this->user_array['user_uid'];
            $self_user = $this->user_array['user_user'];
            $ok = Plug_Query("UPDATE `bs_php_user` SET `user_anget_carid`='{$rule_sql}' WHERE `user_uid`='{$sub['user_uid']}' AND (`user_yao_User`='{$self_uid}' OR `user_yao_User`='{$self_user}')");
            if ($ok) {
                Plug_Add_AppenLog(
                    'agent_ka_log',
                    Plug_Lang('下级卡类分配成功') . ",UID:{$sub['user_uid']},{$sub['user_user']},rule:{$rule}",
                    $this->user_array['user_user']
                );
                Plug_Print_Json(array('code' => 1, 'msg' => Plug_Lang('卡类分配成功!')));
            }
            Plug_Print_Json(array('code' => 1, 'msg' => Plug_Lang('卡类分配失败!')));
        }

        $app_name = Plug_GetAppInfoNameArray();
        $parent_all = $this->is_all_card_rule($this->user_array['user_anget_carid']);
        $sub_rule = trim((string) $sub['user_anget_carid']);
        $sub_all = $this->is_all_card_rule($sub_rule);

        $sql = "SELECT k.`lei_id`, k.`lei_name`, k.`lei_daihao`, k.`lei_daili`, a.`app_name`
            FROM `bs_php_kalei` k, `bs_php_appinfo` a
            WHERE k.`lei_daili` > -1 AND a.`app_daihao` = k.`lei_daihao`
            ORDER BY a.`app_name` ASC, k.`lei_sort` ASC, k.`lei_id` ASC";
        $tmp = Plug_Query($sql);

        $card_list = array();
        while ($row = Plug_Pdo_Fetch_Assoc($tmp)) {
            $lei_id = (int) $row['lei_id'];
            if (!$this->agent_can_use_card_type($this->user_array['user_anget_carid'], $lei_id)) {
                continue;
            }
            $checked = false;
            if ($sub_all) {
                $checked = true;
            } else {
                $checked = $this->agent_can_use_card_type($sub_rule, $lei_id);
            }
            $card_list[] = array(
                'lei_id' => $lei_id,
                'lei_name' => $row['lei_name'],
                'lei_daihao' => $row['lei_daihao'],
                'app_name' => isset($row['app_name']) ? $row['app_name'] : (isset($app_name[$row['lei_daihao']]) ? $app_name[$row['lei_daihao']] : $row['lei_daihao']),
                'checked' => $checked,
            );
        }

        $user_array_agent = $sub;
        $parent_has_all = $parent_all;
        include Plug_Load_Default_Path();
    }

    /**
     * 直属下级
     */
    private function find_sub_agent($uid)
    {
        $uid = (int) $uid;
        if ($uid <= 0) {
            return null;
        }
        // user_yao_User 可能存上级 UID 或账号
        $self_uid = $this->user_array['user_uid'];
        $self_user = $this->user_array['user_user'];
        $sql = "SELECT * FROM `bs_php_user`
            WHERE (`user_yao_User` = '{$self_uid}' OR `user_yao_User` = '{$self_user}')
              AND `user_uid` = '{$uid}'
              AND `user_daili` > 0
            LIMIT 1";
        $row = Plug_Query_Array($sql);
        return $row ? $row : null;
    }

    /**
     * 空或 * = 全部卡类
     */
    private function is_all_card_rule($rule)
    {
        $rule = trim((string) $rule);
        return ($rule === '' || $rule === '*');
    }

    /**
     * 是否拥有某卡类（空/*=全部）
     */
    private function agent_can_use_card_type($rule, $lei_id)
    {
        $lei_id = (int) $lei_id;
        if ($lei_id <= 0) {
            return false;
        }
        $rule = trim((string) $rule);
        if ($this->is_all_card_rule($rule)) {
            return true;
        }
        return (bool) strrpos('###,' . $rule . ',', ',' . $lei_id . ',');
    }

    /**
     * 从 POST 组装可写规则；越权返回 false
     * show_all=1 且上级拥有全部时写 *
     * 否则写 lei_id 列表，格式对齐后台：1,2,3,0
     */
    private function build_assign_rule_from_post()
    {
        $show_all = (int) Plug_Set_Post('show_all');
        $parent_rule = $this->user_array['user_anget_carid'];

        if ($show_all === 1) {
            if (!$this->is_all_card_rule($parent_rule)) {
                return false;
            }
            return '*';
        }

        $raw = Plug_Set_Post('user_anget_carid');
        $raw = trim((string) $raw);
        if ($raw === '' || $raw === '0') {
            // 未勾选任何卡类：清空为仅占位，下级将看不到可制卡类
            return '0';
        }

        $parts = preg_split('/\s*,\s*/', $raw);
        $ids = array();
        foreach ($parts as $p) {
            $id = (int) $p;
            if ($id <= 0) {
                continue;
            }
            if (!$this->agent_can_use_card_type($parent_rule, $id)) {
                return false;
            }
            $ids[$id] = $id;
        }
        if (!$ids) {
            return '0';
        }
        return implode(',', $ids) . ',0';
    }
}
