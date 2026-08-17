


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?PHP ECHO Plug_Get_Configs_Value("sys","name"); ?> - <?php echo Plug_Lang('代理商管理平台'); ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="<?php echo Plug_Get_Url_Statics() ?>style/style/admin.css" media="all">
</head>
<body class="layui-layout-body">
  
  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="<?php echo Plug_Lang('侧边伸缩'); ?>">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
  
          
          
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="<?php echo Plug_Lang('刷新'); ?>">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
          
        </ul>
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
          
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
              <i class="layui-icon layui-icon-theme"></i>
            </a>
          </li>
      
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
              <i class="layui-icon layui-icon-screen-full"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
              <cite><?php echo $this->user_array['user_user']; ?>(<?php echo $this->user_array['user_daili']; ?><?php echo Plug_Lang('星'); ?>) </cite>
            </a>
            
            
            <dl class="layui-nav-child">
            <dd><a target="_blank" href="../code"><?php echo Plug_Lang('查询激活码'); ?></a></dd>
            <dd><a lay-href="index.php?m=agent&c=sp&a=password"><?php echo Plug_Lang('修改密码'); ?></a></dd>

            
            
              <dd  style="text-align: center;"><a href="index.php?m=agent&c=index&a=loginout"><?php echo Plug_Lang('退出'); ?></a></dd>
            </dl>
          </li>
          
          
         
        </ul>
      </div>
      
      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="index.php?m=agent&c=main&a=info">
            <span><?PHP ECHO Plug_Get_Configs_Value("sys","name"); ?><?php echo Plug_Lang('-代理'); ?></span>
          </div>
            <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
         
         
          <?php
   
   
   
   
   //插件

        //打开目录
        $fis_Url =Plug_Get_Bsphp_Dir().'Plug/Agent_list';
        $while_id = null;
        $html = null;
        $html_txt = null;
        $handle = opendir($fis_Url); 
        //OPEN
        $f_i_l_e_s = array();
        while ($FileName = readdir($handle)) {
            if (strpos($FileName, 'agent_') === 0 && substr($FileName, -4) === '.php') {
                $file_path = $fis_Url . '/' . $FileName;
                if (is_file($file_path)) {
                    $while_id++;
                    $f_i_l_e_s[] = $file_path;
                }
            }

        }
        
        $agent_grade = Plug_Agent_Detect_Grade($this->user_array);
        $agent_menu_deny_map = Plug_Agent_Menu_Deny_Map($agent_grade);

        sort($f_i_l_e_s);
        foreach ($f_i_l_e_s as $f_i_l_e_sf_i_l_e_s) {
          $file_content = @file_get_contents($f_i_l_e_sf_i_l_e_s);
          $json_data = null;
          $is_json_menu = false;
          $is_json_candidate = false;
          if ($file_content !== false) {
            $trimmed_content = ltrim($file_content);
            if (strpos($trimmed_content, '{') === 0 || strpos($trimmed_content, '[') === 0) {
              $is_json_candidate = true;
              $json_data = json_decode($trimmed_content, true);
              if (is_array($json_data) && isset($json_data['agentMenu']) && is_array($json_data['agentMenu'])) {
                $is_json_menu = true;
              }
            }
          }

          if ($is_json_menu) {
            foreach ($json_data['agentMenu'] as $menu_item) {
              if (!is_array($menu_item)) {
                continue;
              }
              $item_data_name = isset($menu_item['dataName']) ? (string)$menu_item['dataName'] : 'menu';
              $item_id = isset($menu_item['id']) ? trim((string)$menu_item['id']) : '';
              if ($item_id !== '' && isset($agent_menu_deny_map[$item_id])) {
                continue;
              }
              $item_name = isset($menu_item['name']) ? (string)$menu_item['name'] : '';
              $item_icon = isset($menu_item['icon']) ? (string)$menu_item['icon'] : '';
              $item_link = isset($menu_item['link']) ? (string)$menu_item['link'] : '';
              $item_active = !empty($menu_item['active']);
              $item_class = 'layui-nav-item' . ($item_active ? ' layui-nav-itemed' : '');
              $item_children = (isset($menu_item['children']) && is_array($menu_item['children'])) ? $menu_item['children'] : array();
              ?>
              <li data-name="<?php echo htmlspecialchars($item_data_name, ENT_QUOTES, 'UTF-8'); ?>" class="<?php echo $item_class; ?>">
                <a href="javascript:;"
                   <?php if ($item_link !== '') { ?>lay-href="<?php echo htmlspecialchars($item_link, ENT_QUOTES, 'UTF-8'); ?>"<?php } ?>
                   <?php if ($item_active) { ?>class="layui-this"<?php } ?>
                   lay-tips="<?php echo Plug_Lang($item_name); ?>"
                   lay-direction="3">
                  <?php if ($item_icon !== '') { ?><i class="layui-icon <?php echo htmlspecialchars($item_icon, ENT_QUOTES, 'UTF-8'); ?>"></i><?php } ?>
                  <cite><?php echo Plug_Lang($item_name); ?></cite>
                </a>
                <?php if (!empty($item_children)) { ?>
                  <dl class="layui-nav-child">
                    <?php foreach ($item_children as $child_item) {
                      if (!is_array($child_item)) {
                        continue;
                      }
                      $child_name = isset($child_item['name']) ? (string)$child_item['name'] : '';
                      $child_link = isset($child_item['link']) ? (string)$child_item['link'] : '';
                      $child_data_name = isset($child_item['dataName']) ? (string)$child_item['dataName'] : '';
                      $child_id = isset($child_item['id']) ? trim((string)$child_item['id']) : '';
                      if ($child_id !== '' && isset($agent_menu_deny_map[$child_id])) {
                        continue;
                      }
                      ?>
                      <dd<?php if ($child_data_name !== '') { ?> data-name="<?php echo htmlspecialchars($child_data_name, ENT_QUOTES, 'UTF-8'); ?>"<?php } ?>>
                        <a lay-href="<?php echo htmlspecialchars($child_link, ENT_QUOTES, 'UTF-8'); ?>"><?php echo Plug_Lang($child_name); ?></a>
                      </dd>
                    <?php } ?>
                  </dl>
                <?php } ?>
              </li>
              <?php
            }
            continue;
          }

          if ($is_json_candidate) {
            continue;
          }

          $xml_text = '';
          if ($file_content !== false) {
            $trimmed_content = ltrim($file_content);
            if (strpos($trimmed_content, '<?xml') === 0 || strpos($trimmed_content, '<agentMenu>') === 0) {
              $xml_text = $trimmed_content;
            } elseif (preg_match('/<agentMenu>[\s\S]*<\/agentMenu>/', $file_content, $xml_match)) {
              $xml_text = $xml_match[0];
            }
          }
          $is_xml_menu = ($xml_text !== '');

          if ($is_xml_menu && function_exists('simplexml_load_string')) {
            $menu_xml = @simplexml_load_string($xml_text);
            if ($menu_xml !== false) {
              foreach ($menu_xml->item as $menu_item) {
                $item_data_name = (string)$menu_item['dataName'];
                if ($item_data_name === '') {
                  $item_data_name = 'menu';
                }
                $item_id = trim((string)$menu_item['id']);
                if ($item_id !== '' && isset($agent_menu_deny_map[$item_id])) {
                  continue;
                }
                $item_name = (string)$menu_item->name;
                $item_icon = (string)$menu_item->icon;
                $item_link = (string)$menu_item->link;
                $item_active = ((string)$menu_item['active'] === '1');
                $item_class = 'layui-nav-item' . ($item_active ? ' layui-nav-itemed' : '');
                ?>
                <li data-name="<?php echo htmlspecialchars($item_data_name, ENT_QUOTES, 'UTF-8'); ?>" class="<?php echo $item_class; ?>">
                  <a href="javascript:;"
                     <?php if ($item_link !== '') { ?>lay-href="<?php echo htmlspecialchars($item_link, ENT_QUOTES, 'UTF-8'); ?>"<?php } ?>
                     <?php if ($item_active) { ?>class="layui-this"<?php } ?>
                     lay-tips="<?php echo Plug_Lang($item_name); ?>"
                     lay-direction="3">
                    <?php if ($item_icon !== '') { ?><i class="layui-icon <?php echo htmlspecialchars($item_icon, ENT_QUOTES, 'UTF-8'); ?>"></i><?php } ?>
                    <cite><?php echo Plug_Lang($item_name); ?></cite>
                  </a>
                  <?php if (isset($menu_item->children->child)) { ?>
                    <dl class="layui-nav-child">
                      <?php foreach ($menu_item->children->child as $child_item) {
                        $child_name = (string)$child_item->name;
                        $child_link = (string)$child_item->link;
                        $child_data_name = (string)$child_item['dataName'];
                        $child_id = trim((string)$child_item['id']);
                        if ($child_id !== '' && isset($agent_menu_deny_map[$child_id])) {
                          continue;
                        }
                        ?>
                        <dd<?php if ($child_data_name !== '') { ?> data-name="<?php echo htmlspecialchars($child_data_name, ENT_QUOTES, 'UTF-8'); ?>"<?php } ?>>
                          <a lay-href="<?php echo htmlspecialchars($child_link, ENT_QUOTES, 'UTF-8'); ?>"><?php echo Plug_Lang($child_name); ?></a>
                        </dd>
                      <?php } ?>
                    </dl>
                  <?php } ?>
                </li>
                <?php
              }
              continue;
            }
          }

          if ($is_xml_menu) {
            continue;
          }

          include ($f_i_l_e_sf_i_l_e_s);
        }
        
        
?>









          
        
          </ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;"><?php echo Plug_Lang('关闭当前标签页'); ?></a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;"><?php echo Plug_Lang('关闭其它标签页'); ?></a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;"><?php echo Plug_Lang('关闭全部标签页'); ?></a></dd>
              </dl>
            </li>
          </ul>
        </div>
        <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="index.php?m=admin&c=tools&a=info" lay-attr="index.php?m=admin&c=tools&a=info" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
          </ul>
        </div>
      </div>
      
      
      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="index.php?m=agent&c=main&a=info" frameborder="0" class="layadmin-iframe"></iframe>
        </div>
      </div>
      
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>

  <script src="<?php echo Plug_Get_Url_Statics() ?>style/layui/bsphp.js"></script>
  <script>
  layui.config({
    base: '<?php echo Plug_Get_Url_Statics() ?>style/' /**静态资源所在路*/
	,views:'../statics/default/agent/'
	
  }).extend({
    index: 'lib/index' /**主入口模块*/
  }).use(['jquery', 'index']);
  </script>
  
  <div style="display:none;">
 
 </div>
</body>
</html>


