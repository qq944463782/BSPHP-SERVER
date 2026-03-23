<?php

/**
 * PC用户中心 - Vue 单页
 * 功能：登陆、注册、解绑定、充值、改密码、找回密码、反馈问题
 * 依赖：Vue 3、BSphpSeSsL、daihao（URL参数）
 */
include __DIR__ . '/../_wrap_inc.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <script src="./statics/vue/vue.global.prod.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>PC用户中心</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      font-size: 14px;
      line-height: 1.5;
      color: #333;
      background: #e9edf1
    }

    body.w0 {
      background: #f5f5f5;
      padding: 20px
    }

    body.w1,
    body.w2 {
      background: #fff;
      padding: 12px
    }

    body.w4,
    body.w5 {
      background: #fff;
      padding: 0
    }

    .wrap {
      max-width: 900px;
      min-height: 600px;
      margin: 0 auto;
      background: #f7f9fb;
      border: 1px solid #cfd6e4;
      border-radius: 6px;
      box-shadow: 0 6px 24px rgba(0, 0, 0, .08);
      overflow: hidden;
      display: flex;
      flex-direction: column
    }

    body.w1 .wrap,
    body.w2 .wrap {
      border: 1px solid #cfd6e4;
      border-radius: 6px;
      box-shadow: 0 6px 24px rgba(0, 0, 0, .08)
    }

    body.w4 .wrap,
    body.w5 .wrap {
      width: 100%;
      max-width: none;
      margin: 0;
      border: 0;
      border-radius: 0;
      box-shadow: none
    }

    body.w2 .hd,
    body.w5 .hd {
      display: none
    }



    /* 公告头部 */
    .announce-header {
      padding: 10px 14px;
      background: linear-gradient(180deg, #3a7bd5 0%, #3358cc 100%);
      color: #fff;
      border-bottom: 1px solid rgba(0, 0, 0, .1)
    }

    .announce-header h2 {
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 6px;
      display: flex;
      align-items: center
    }

    .announce-header h2:before {
      content: "📢";
      margin-right: 8px;
      font-size: 18px
    }

    .announce-list {
      max-height: 120px;
      overflow-y: auto
    }

    .announce-item {
      padding: 6px 0;
      font-size: 13px;
      opacity: .95;
      line-height: 1.6
    }

    .announce-item:not(:last-child) {
      border-bottom: 1px solid rgba(255, 255, 255, .1)
    }

    .announce-item a {
      color: #fff;
      text-decoration: none;
      display: block
    }

    .announce-item a:hover {
      opacity: .8
    }

    .announce-text {
      padding: 6px 0;
      font-size: 13px;
      opacity: .95;
      line-height: 1.7;
      word-break: break-word
    }

    .announce-empty {
      padding: 8px 0;
      font-size: 13px;
      opacity: .8
    }

    /* 标签页导航 */
    .tabs-nav {
      display: flex;
      background: #eef2f7;
      border-bottom: 1px solid #cfd6e4;
      overflow-x: auto;
      scrollbar-width: none;
      -ms-overflow-style: none
    }

    .tabs-nav::-webkit-scrollbar {
      display: none
    }

    .tabs-nav-item {
      flex: 1;
      min-width: 100px;
      padding: 10px 12px;
      text-align: center;
      cursor: pointer;
      font-size: 13px;
      color: #445;
      transition: all .2s;
      white-space: nowrap;
      position: relative;
      border-right: 1px solid #dde3ef
    }

    .tabs-nav-item {
      user-select: none;
      -webkit-user-select: none;
      -ms-user-select: none;
      -moz-user-select: none
    }

    .tabs-nav-item:hover {
      background: #e3eaf5
    }

    .tabs-nav-item.active {
      background: #fff;
      color: #1f55aa;
      font-weight: 600;
      box-shadow: inset 0 -2px 0 #1f55aa
    }

    .tabs-nav-item.active:after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      right: 0;
      height: 2px;
      background: #1890ff
    }

    /* 内容区域 */
    .tabs-content {
      padding: 0;
      flex: 1;
      overflow: auto;
      background: #fff
    }

    .tab-panel {
      display: none;
      padding: 16px 18px
    }

    .tab-panel.active {
      display: block
    }

    .tab-panel form {
      max-width: 800px;
      margin: 0 auto
    }

    /* 表单样式：聚焦时在输入框上方浮出提示，不占位避免跳动 */
    .form-group {
      margin: 0 auto 12px;
      display: flex;
      flex-direction: column;
      align-items: stretch;
      max-width: 720px;
      position: relative
    }

    .form-group:last-of-type {
      margin-bottom: 0
    }

    /* 聚焦提示：纯色背景、层级在上、不透明 */
    .form-group .focus-hint,
    .form-col .focus-hint {
      position: absolute;
      left: 0;
      bottom: 100%;
      margin-bottom: 6px;
      padding: 6px 12px;
      font-size: 12px;
      color: #1a4a9e;
      font-weight: 600;
      pointer-events: none;
      white-space: nowrap;
      background: #e8f0fe;
      border: 1px solid #a8c7fa;
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
      z-index: 10
    }

    .form-group input,
    .form-group textarea,
    .form-group select,
    .form-col input,
    .form-col textarea,
    .form-col select {
      flex: 1;
      min-width: 0;
      padding: 8px 10px;
      border: 1px solid #cfd6e4;
      border-radius: 4px;
      background: #f9fbfd;
      font-size: 13px;
      font-family: inherit;
      transition: border-color .15s, background .15s
    }

    .form-group input,
    .form-col input {
      max-width: none
    }

    /* placeholder 常显：不随焦点变淡，label 保持左侧不采用浮动标签 */
    .form-group input::placeholder,
    .form-group textarea::placeholder,
    .form-col input::placeholder,
    .form-col textarea::placeholder {
      color: #8c9aa8;
      opacity: 1
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus,
    .form-col input:focus,
    .form-col textarea:focus,
    .form-col select:focus {
      outline: none;
      border-color: #1f55aa;
      background: #fff
    }

    .form-group textarea {
      min-height: 60px;
      resize: vertical
    }

    .form-group .code-img {
      cursor: pointer;
      border-radius: 4px;
      border: 1px solid #cfd6e4;
      height: 38px
    }

    .form-row {
      display: flex;
      align-items: flex-start;
      margin: 0 auto 12px;
      max-width: 720px
    }

    .form-row>.form-col+.form-col {
      margin-left: 12px
    }

    .form-col {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: stretch;
      position: relative
    }

    .code-wrap {
      display: flex;
      align-items: center
    }

    .code-wrap>*+* {
      margin-left: 10px
    }

    .code-refresh {
      margin-left: 4px;
      color: #1f55aa;
      cursor: pointer;
      font-size: 12px;
      text-decoration: underline
    }

    .code-wrap input {
      width: 120px;
      max-width: 120px;
      flex: 0 0 120px
    }

    /* 消息提示（表单内保留，用于登录成功等持久状态） */
    .msg {
      margin-top: 16px;
      padding: 12px;
      background: #fff7e6;
      border: 1px solid #ffd591;
      border-radius: 6px;
      color: #d46b08;
      font-size: 13px
    }

    .msg.success {
      background: #f6ffed;
      border-color: #b7eb8f;
      color: #52c41a
    }

    .msg.error {
      background: #fff1f0;
      border-color: #ffccc7;
      color: #ff4d4f
    }

    /* 弹出提示：3秒后自动消失 */
    .toast {
      position: fixed;
      top: 24px;
      left: 50%;
      transform: translateX(-50%);
      padding: 12px 24px;
      border-radius: 6px;
      font-size: 14px;
      z-index: 9999;
      box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
      animation: toastIn .25s ease
    }

    .toast.success {
      background: #f6ffed;
      border: 1px solid #b7eb8f;
      color: #52c41a
    }

    .toast.error {
      background: #fff1f0;
      border: 1px solid #ffccc7;
      color: #ff4d4f
    }

    @keyframes toastIn {
      from {
        opacity: 0;
        transform: translateX(-50%) translateY(-10px)
      }

      to {
        opacity: 1;
        transform: translateX(-50%) translateY(0)
      }
    }

    /* 按钮 */
    .btn {
      display: block;
      width: 280px;
      height: 40px;
      margin: 16px auto 0px;
      border: none;
      border-radius: 4px;
      background: #1f55aa;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: background .2s
    }

    .btn:hover {
      background: #2f66c0
    }

    /* 所有页面按钮统一居中与宽度 */
    .btn:disabled {
      background: #d9d9d9;
      cursor: not-allowed
    }

    /* 加载中 */
    .loading {
      text-align: center;
      padding: 40px;
      color: #999
    }

    .loading:before {
      content: "⏳";
      display: block;
      font-size: 32px;
      margin-bottom: 12px
    }

    body.ie-legacy .wrap {
      display: block
    }

    body.ie-legacy .tabs-content {
      height: auto;
      min-height: 420px
    }

    body.ie-legacy .tabs-nav {
      white-space: nowrap
    }

    body.ie-legacy .tabs-nav-item {
      display: inline-block;
      zoom: 1;
      flex: none;
      min-width: auto
    }

    body.ie-legacy .form-row,
    body.ie-legacy .form-col {
      display: block
    }

    body.ie-legacy .form-group {
      display: block;
      zoom: 1
    }

    body.ie-legacy .form-group:after {
      content: '';
      display: block;
      clear: both
    }

    body.ie-legacy .form-group input,
    body.ie-legacy .form-group select,
    body.ie-legacy .form-group textarea {
      float: left;
      display: inline
    }

    body.ie-legacy .form-col input,
    body.ie-legacy .form-col select,
    body.ie-legacy .form-col textarea {
      float: left
    }

    .tabs-content {
      display: flex;
      justify-content: center;
      padding-top: 30px;
    }
  </style>
</head>

<body class="w<?php echo $wrap_mode; ?>">
  <div id="app">
    <!-- 弹出提示：3秒后自动消失 -->
    <div v-if="toastVisible" :class="['toast', toastOk?'success':'error']">{{ toastText }}</div>
    <div class="wrap">
      <?php if ($show_header) { ?>
        <div class="hd">
          <h1><?php echo Plug_Lang('用户中心'); ?></h1>
        </div>
      <?php } ?>

      <!-- 软件公告：按当前 daihao 从 bs_php_appinfo.app_gg 读取并显示 -->
      <div class="announce-header">
        <h2>软件公告</h2>
        <div class="announce-list" id="announceList">
          <?php
          $app_gg = '';
          if (($daihao ?? '') !== '') {
            $daihao_safe = addslashes($daihao);
            $res = Plug_Query("SELECT `app_gg` FROM `bs_php_appinfo` WHERE `app_daihao`='{$daihao_safe}' LIMIT 1");
            if ($res && ($row = Plug_Pdo_Fetch_Assoc($res)) && trim($row['app_gg'] ?? '') !== '') {
              $app_gg = trim($row['app_gg']);
            }
          }
          if ($app_gg !== '') {
            echo '<div class="announce-text">' . nl2br(htmlspecialchars($app_gg, ENT_QUOTES, 'UTF-8')) . '</div>';
          } else {
            echo '<div class="announce-empty">暂无公告</div>';
          }
          ?>
        </div>
      </div>

      <!-- 标签页导航 -->
      <div class="tabs-nav">
        <div :class="['tabs-nav-item', {active: activeTab==='login'}]" data-tab="login" @click="selectTab('login')">登陆</div>
        <div :class="['tabs-nav-item', {active: activeTab==='register'}]" data-tab="register" @click="selectTab('register')">注册</div>
        <div :class="['tabs-nav-item', {active: activeTab==='unbind'}]" data-tab="unbind" @click="selectTab('unbind')">解绑定</div>
        <div :class="['tabs-nav-item', {active: activeTab==='recharge'}]" data-tab="recharge" @click="selectTab('recharge')">充值</div>
        <div :class="['tabs-nav-item', {active: activeTab==='changepwd'}]" data-tab="changepwd" @click="selectTab('changepwd')">改密码</div>
        <div :class="['tabs-nav-item', {active: activeTab==='findpwd'}]" data-tab="findpwd" @click="selectTab('findpwd')">找回密码</div>
        <div :class="['tabs-nav-item', {active: activeTab==='feedback'}]" data-tab="feedback" @click="selectTab('feedback')">反馈问题</div>
      </div>

      <!-- 标签页内容 -->
      <div class="tabs-content">
        <div :class="['tab-panel', {active: activeTab==='login'}]" class="tab-panel" id="tab-login">

          <!-- 登录 -->
          <form id="form-login" method="post" @submit.prevent="submitLogin">
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'login-user'">会员账号</span>
              <input id="login-user" name="user" type="text" placeholder="请输入会员账号" title="会员账号" v-model="loginUser" @focus="focusedField = 'login-user'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'login-pwd'">会员密码</span>
              <input id="login-pwd" name="pwd" type="password" placeholder="请输入会员密码" title="会员密码" v-model="loginPwd" @focus="focusedField = 'login-pwd'" @blur="focusedField = ''">
            </div>
            <div class="form-group" v-show="codeLoginOn">
              <span class="focus-hint" v-show="focusedField === 'login-code'">验证码</span>
              <div class="code-wrap">
                <input id="login-code" v-model="loginCode" type="text" placeholder="请输入验证码" title="验证码" @focus="focusedField = 'login-code'" @blur="focusedField = ''">
                <img ref="loginCaptcha" class="code-img" @click="refreshCaptcha('login')" :src="'index.php?m=coode&time='+captchaTs+'&sessl=<?php echo $BSphpSeSsL; ?>'" alt="验证码" width="160" height="38">
                <a class="code-refresh" href="javascript:void(0)" @click.prevent="refreshCaptcha('login')">看不清？换一个</a>
              </div>
            </div>
            <button type="submit" class="btn" :disabled="loginLoading">{{ loginLoading ? '登录中...' : '登录' }}</button>
          </form>
        </div>

        <!-- 注册 -->
        <div class="tab-panel" :class="['tab-panel', {active: activeTab==='register'}]" id="tab-register">
          <form method="post" @submit.prevent="submitRegister">
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'reg-user'">会员账号</span>
              <input id="reg-user" v-model="reg.user" type="text" placeholder="请输入会员账号" title="会员账号" @focus="focusedField = 'reg-user'" @blur="focusedField = ''">
            </div>
            <div class="form-row">
              <div class="form-col">
                <span class="focus-hint" v-show="focusedField === 'reg-pwd'">密码</span>
                <input id="reg-pwd" v-model="reg.pwd" type="password" placeholder="请输入密码" title="密码" @focus="focusedField = 'reg-pwd'" @blur="focusedField = ''">
              </div>
              <div class="form-col">
                <span class="focus-hint" v-show="focusedField === 'reg-pwdb'">再次密码</span>
                <input id="reg-pwdb" v-model="reg.pwdb" type="password" placeholder="请再次输入密码" title="再次密码" @focus="focusedField = 'reg-pwdb'" @blur="focusedField = ''">
              </div>
            </div>
            <div class="form-row">
              <div class="form-col">
                <span class="focus-hint" v-show="focusedField === 'reg-question'">密保问题</span>
                <select id="reg-question" v-model="reg.question" title="密保问题" @focus="focusedField = 'reg-question'" @blur="focusedField = ''">
                  <option value="0">密保问题</option>
                  <option value="1">您母亲的名字是？</option>
                  <option value="2">您父亲的名字是？</option>
                  <option value="3">您第一所学校名称是？</option>
                  <option value="4">您最喜欢的老师是？</option>
                  <option value="5">您最喜欢的电影是？</option>
                </select>
              </div>
              <div class="form-col">
                <span class="focus-hint" v-show="focusedField === 'reg-answer'">密保答案</span>
                <input id="reg-answer" v-model="reg.answer" type="text" placeholder="请输入密保答案" title="密保答案" @focus="focusedField = 'reg-answer'" @blur="focusedField = ''">
              </div>
            </div>
            <div class="form-row">
              <div class="form-col">
                <span class="focus-hint" v-show="focusedField === 'reg-qq'">QQ</span>
                <input id="reg-qq" v-model="reg.qq" type="text" placeholder="QQ选填" title="QQ" @focus="focusedField = 'reg-qq'" @blur="focusedField = ''">
              </div>
              <div class="form-col">
                <span class="focus-hint" v-show="focusedField === 'reg-mobile'">电话</span>
                <input id="reg-mobile" v-model="reg.mobile" type="text" placeholder="电话选填" title="电话" @focus="focusedField = 'reg-mobile'" @blur="focusedField = ''">
              </div>
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'reg-mail'">邮箱</span>
              <input id="reg-mail" v-model="reg.mail" type="email" placeholder="邮箱选填" title="邮箱" @focus="focusedField = 'reg-mail'" @blur="focusedField = ''">
            </div>
            <div class="form-group" v-show="codeRegistrationOn">
              <span class="focus-hint" v-show="focusedField === 'reg-code'">验证码</span>
              <div class="code-wrap">
                <input id="reg-code" v-model="reg.code" type="text" placeholder="请输入验证码" title="验证码" @focus="focusedField = 'reg-code'" @blur="focusedField = ''">
                <img ref="regCaptcha" class="code-img" @click="refreshCaptcha('reg')" :src="'index.php?m=coode&time='+captchaTs+'&sessl=<?php echo $BSphpSeSsL; ?>'" alt="验证码" width="160" height="38">
                <a class="code-refresh" href="javascript:void(0)" @click.prevent="refreshCaptcha('reg')">看不清？换一个</a>
              </div>
            </div>
            <button type="submit" class="btn" :disabled="regLoading">{{ regLoading?'注册中...':'注册' }}</button>
          </form>
        </div>

        <div class="tab-panel" :class="['tab-panel', {active: activeTab==='unbind'}]" id="tab-unbind">
          <form method="post" @submit.prevent="submitUnbind">
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'unbind-user'">账号</span>
              <input id="unbind-user" v-model="unbind.user" type="text" placeholder="请输入账号" title="账号" @focus="focusedField = 'unbind-user'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'unbind-pwd'">密码</span>
              <input id="unbind-pwd" v-model="unbind.pwd" type="password" placeholder="请输入密码" title="密码" @focus="focusedField = 'unbind-pwd'" @blur="focusedField = ''">
            </div>
            <button type="submit" class="btn" :disabled="unbindLoading">{{ unbindLoading?'提交中...':'解除绑定' }}</button>
          </form>
        </div>

        <div class="tab-panel" :class="['tab-panel', {active: activeTab==='recharge'}]" id="tab-recharge">
          <form method="post" @submit.prevent="submitRecharge">
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'recharge-user'">充值账号</span>
              <input id="recharge-user" v-model="recharge.user" type="text" placeholder="请输入充值账号" title="充值账号" @focus="focusedField = 'recharge-user'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'recharge-userpwd'">账号密码</span>
              <input id="recharge-userpwd" v-model="recharge.userpwd" type="password" placeholder="请输入账号密码" title="账号密码" @focus="focusedField = 'recharge-userpwd'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'recharge-ka'">卡号</span>
              <input id="recharge-ka" v-model="recharge.ka" type="text" placeholder="请输入卡号" title="卡号" @focus="focusedField = 'recharge-ka'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'recharge-pwd'">卡密</span>
              <input id="recharge-pwd" v-model="recharge.pwd" type="text" placeholder="请输入卡密" title="卡密" @focus="focusedField = 'recharge-pwd'" @blur="focusedField = ''">
            </div>
            <button type="submit" class="btn" :disabled="rechargeLoading">{{ rechargeLoading?'提交中...':'充值' }}</button>
          </form>
        </div>

        <div class="tab-panel" :class="['tab-panel', {active: activeTab==='changepwd'}]" id="tab-changepwd">
          <form method="post" @submit.prevent="submitChangepwd">
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'cp-user'">账号</span>
              <input id="cp-user" v-model="changepwd.user" type="text" placeholder="请输入账号" title="账号" @focus="focusedField = 'cp-user'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'cp-pwd'">旧密码</span>
              <input id="cp-pwd" v-model="changepwd.pwd" type="password" placeholder="请输入旧密码" title="旧密码" @focus="focusedField = 'cp-pwd'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'cp-pwda'">新密码</span>
              <input id="cp-pwda" v-model="changepwd.pwda" type="password" placeholder="请输入新密码" title="新密码" @focus="focusedField = 'cp-pwda'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'cp-pwdb'">确认密码</span>
              <input id="cp-pwdb" v-model="changepwd.pwdb" type="password" placeholder="请再次输入新密码" title="确认密码" @focus="focusedField = 'cp-pwdb'" @blur="focusedField = ''">
            </div>
            <div class="form-group" v-show="codeBackpwdOn">
              <span class="focus-hint" v-show="focusedField === 'cp-code'">验证码</span>
              <div class="code-wrap">
                <input id="cp-code" v-model="changepwd.code" type="text" placeholder="请输入验证码" title="验证码" @focus="focusedField = 'cp-code'" @blur="focusedField = ''">
                <img ref="cpCaptcha" class="code-img" @click="refreshCaptcha('cp')" :src="'index.php?m=coode&time='+captchaTs+'&sessl=<?php echo $BSphpSeSsL; ?>'" alt="验证码" width="160" height="38">
                <a class="code-refresh" href="javascript:void(0)" @click.prevent="refreshCaptcha('cp')">看不清？换一个</a>
              </div>
            </div>
            <button type="submit" class="btn" :disabled="cpLoading">{{ cpLoading?'提交中...':'修改密码' }}</button>
          </form>
        </div>

        <div class="tab-panel" :class="['tab-panel', {active: activeTab==='findpwd'}]" id="tab-findpwd">
          <form method="post" @submit.prevent="submitFindpwd">
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'fp-user'">会员账号</span>
              <input id="fp-user" v-model="findpwd.user" type="text" placeholder="请输入会员账号" title="会员账号" @focus="focusedField = 'fp-user'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'fp-pwd'">新密码</span>
              <input id="fp-pwd" v-model="findpwd.pwd" type="password" placeholder="请输入新密码" title="新密码" @focus="focusedField = 'fp-pwd'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'fp-pwdb'">再次输入</span>
              <input id="fp-pwdb" v-model="findpwd.pwdb" type="password" placeholder="请再次输入新密码" title="再次输入" @focus="focusedField = 'fp-pwdb'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'fp-mibao'">密保问题</span>
              <input id="fp-mibao" v-model="findpwd.mibao" type="text" placeholder="如：1 或问题文本" title="密保问题" @focus="focusedField = 'fp-mibao'" @blur="focusedField = ''">
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'fp-daan'">密保答案</span>
              <input id="fp-daan" v-model="findpwd.daan" type="text" placeholder="请输入密保答案" title="密保答案" @focus="focusedField = 'fp-daan'" @blur="focusedField = ''">
            </div>
            <div class="form-group" v-show="codeBackpwdOn">
              <span class="focus-hint" v-show="focusedField === 'fp-code'">验证码</span>
              <div class="code-wrap">
                <input id="fp-code" v-model="findpwd.code" type="text" placeholder="请输入验证码" title="验证码" @focus="focusedField = 'fp-code'" @blur="focusedField = ''">
                <img ref="fpCaptcha" class="code-img" @click="refreshCaptcha('fp')" :src="'index.php?m=coode&time='+captchaTs+'&sessl=<?php echo $BSphpSeSsL; ?>'" alt="验证码" width="160" height="38">
                <a class="code-refresh" href="javascript:void(0)" @click.prevent="refreshCaptcha('fp')">看不清？换一个</a>
              </div>
            </div>
            <button type="submit" class="btn" :disabled="fpLoading">{{ fpLoading?'提交中...':'找回密码' }}</button>
          </form>
        </div>

        <div class="tab-panel" :class="['tab-panel', {active: activeTab==='feedback'}]" id="tab-feedback">
          <form method="post" @submit.prevent="submitFeedback">
            <div class="form-row">
              <div class="form-col">
                <span class="focus-hint" v-show="focusedField === 'fb-user'">账号</span>
                <input id="fb-user" v-model="feedback.user" type="text" placeholder="请输入账号" title="账号" @focus="focusedField = 'fb-user'" @blur="focusedField = ''">
              </div>
              <div class="form-col">
                <span class="focus-hint" v-show="focusedField === 'fb-pwd'">密码</span>
                <input id="fb-pwd" v-model="feedback.pwd" type="password" placeholder="请输入密码" title="密码" @focus="focusedField = 'fb-pwd'" @blur="focusedField = ''">
              </div>
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'fb-table'">标题</span>
              <input id="fb-table" v-model="feedback.table" type="text" placeholder="请输入标题" title="标题" @focus="focusedField = 'fb-table'" @blur="focusedField = ''">
            </div>
            <div class="form-row">
              <div class="form-col">
                <span class="focus-hint" v-show="focusedField === 'fb-qq'">联系方式</span>
                <input id="fb-qq" v-model="feedback.qq" type="text" placeholder="QQ/手机/邮箱" title="联系方式" @focus="focusedField = 'fb-qq'" @blur="focusedField = ''">
              </div>
              <div class="form-col">
                <span class="focus-hint" v-show="focusedField === 'fb-leix'">反馈类型</span>
                <select id="fb-leix" v-model="feedback.leix" title="反馈类型" @focus="focusedField = 'fb-leix'" @blur="focusedField = ''">
                  <option value="bug">BUG反馈</option>
                  <option value="adv">功能建议</option>
                  <option value="other">其他</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <span class="focus-hint" v-show="focusedField === 'fb-txt'">内容</span>
              <textarea id="fb-txt" v-model="feedback.txt" placeholder="请描述问题或建议" title="内容" @focus="focusedField = 'fb-txt'" @blur="focusedField = ''"></textarea>
            </div>
            <div class="form-group" v-show="codeSayOn">
              <span class="focus-hint" v-show="focusedField === 'fb-code'">验证码</span>
              <div class="code-wrap">
                <input id="fb-code" v-model="feedback.code" type="text" placeholder="请输入验证码" title="验证码" @focus="focusedField = 'fb-code'" @blur="focusedField = ''">
                <img ref="fbCaptcha" class="code-img" @click="refreshCaptcha('fb')" :src="'index.php?m=coode&time='+captchaTs+'&sessl=<?php echo $BSphpSeSsL; ?>'" alt="验证码" width="160" height="38">
                <a class="code-refresh" href="javascript:void(0)" @click.prevent="refreshCaptcha('fb')">看不清？换一个</a>
              </div>
            </div>
            <button type="submit" class="btn" :disabled="fbLoading">{{ fbLoading?'提交中...':'提交' }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script>
    // API 基础路径（webapi/pc 模块）
    var PC_BASE = 'index.php?m=webapi&c=pc';
    // 必需参数：daihao、BSphpSeSsL（由 URL 传入）
    var PC_PARAMS = '&daihao=<?php echo $daihao; ?>&BSphpSeSsL=<?php echo $BSphpSeSsL; ?>';
    var PC_DAIHAO = '<?php echo ($daihao ?? '') !== '' ? addslashes($daihao) : 'default'; ?>';
    var PC_LOGIN_URL = PC_BASE + '&a=login' + PC_PARAMS;
    // 验证码开关：来自后台 配置->验证码设置 (index.php?m=admin&c=config&a=code)，1=需要验证码，0=不需要
    var PC_CODE_LOGIN = <?php echo (int)($code_login ?? 0); ?>;
    var PC_CODE_REGISTRATION = <?php echo (int)($code_registration ?? 0); ?>;
    var PC_CODE_BACKPWD = <?php echo (int)($code_backpwd ?? 0); ?>;
    var PC_CODE_SAY = <?php echo (int)($code_say ?? 0); ?>;
    var PC_SESSL = '<?php echo $BSphpSeSsL; ?>';

    function isCaptchaError(code) {
      return code === -11111;
    }
    // 长期保存账号/密码到 localStorage（按 daihao 区分，关闭浏览器再打开仍存在）
    function loadLoginCache() {
      try {
        var k = 'bsphp_pc_login_' + PC_DAIHAO;
        var s = localStorage.getItem(k);
        if (s) {
          var o = JSON.parse(s);
          return {
            user: o.user || '',
            pwd: o.pwd || ''
          };
        }
      } catch (e) {}
      return {
        user: '',
        pwd: ''
      };
    }

    function saveLoginCache(user, pwd) {
      try {
        localStorage.setItem('bsphp_pc_login_' + PC_DAIHAO, JSON.stringify({
          user: user || '',
          pwd: pwd || ''
        }));
      } catch (e) {}
    }
    (function() {
      const {
        createApp
      } = window.Vue;
      // 标签页顺序，用于 #tbas=0 / #tabs=0 或 ?tbas=0 / ?tabs=0 跳转（0=登陆 1=注册 2=解绑定 3=充值 4=改密码 5=找回密码 6=反馈问题）
      var TAB_IDS = ['login', 'register', 'unbind', 'recharge', 'changepwd', 'findpwd', 'feedback'];
      function parseTbasFromUrl() {
        var h = (window.location.hash || '').replace(/^#/, '');
        var s = (window.location.search || '').replace(/^\?/, '');
        var str = h + (h && s ? '&' : '') + s;
        try { str = decodeURIComponent(str); } catch (e) {}
        // 同时支持 tbas 和 tabs 两种写法
        var m = str.match(/(?:tbas|tabs)=(\d+)/);
        if (m) {
          var i = parseInt(m[1], 10);
          if (i >= 0 && i < TAB_IDS.length) return TAB_IDS[i];
        }
        return null;
      }
      function getInitialTab() {
        return parseTbasFromUrl() || 'login';
      }
      createApp({
        data() {
          return {
            activeTab: getInitialTab(), // 当前标签：可由 #tbas=0~6 指定
            captchaTs: Date.now(), // 验证码刷新戳，用于强制刷新图片
            loginUser: (function() {
              var c = loadLoginCache();
              return c.user;
            })(),
            loginPwd: (function() {
              var c = loadLoginCache();
              return c.pwd;
            })(),
            loginCode: '',
            loginSuccess: window.location.hash === '#login=ok',
            loginLoading: false,
            toastText: '',
            toastOk: false,
            toastVisible: false,
            focusedField: '', // 当前聚焦的 input id，用于在输入框上方显示提示
            reg: {
              user: '',
              pwd: '',
              pwdb: '',
              question: '1',
              answer: '',
              qq: '',
              mobile: '',
              mail: '',
              code: ''
            },
            regMsg: '',
            regOk: false,
            regLoading: false, // 注册：msg=提示，ok=成功，loading=提交中
            unbind: {
              user: '',
              pwd: ''
            },
            unbindMsg: '',
            unbindOk: false,
            unbindLoading: false,
            recharge: {
              user: '',
              userpwd: '',
              ka: '',
              pwd: ''
            }, // ka=卡号，pwd=卡密
            rechargeMsg: '',
            rechargeOk: false,
            rechargeLoading: false,
            changepwd: {
              user: '',
              pwd: '',
              pwda: '',
              pwdb: '',
              code: ''
            }, // pwda=新密码，pwdb=确认
            cpMsg: '',
            cpOk: false,
            cpLoading: false,
            findpwd: {
              user: '',
              pwd: '',
              pwdb: '',
              mibao: '',
              daan: '',
              code: ''
            }, // mibao=密保问题，daan=密保答案
            fpMsg: '',
            fpOk: false,
            fpLoading: false,
            feedback: {
              user: '',
              pwd: '',
              table: '',
              leix: 'bug',
              qq: '',
              txt: '',
              code: ''
            }, // table=标题，leix=类型，txt=内容
            fbMsg: '',
            fbOk: false,
            fbLoading: false,
            codeLoginOn: typeof PC_CODE_LOGIN !== 'undefined' ? PC_CODE_LOGIN === 1 : true,
            codeRegistrationOn: typeof PC_CODE_REGISTRATION !== 'undefined' ? PC_CODE_REGISTRATION === 1 : true,
            codeBackpwdOn: typeof PC_CODE_BACKPWD !== 'undefined' ? PC_CODE_BACKPWD === 1 : true,
            codeSayOn: typeof PC_CODE_SAY !== 'undefined' ? PC_CODE_SAY === 1 : true
          };
        },
        mounted() {
          var vm = this;
          if (window.location.hash === '#login=ok') vm.loginSuccess = true;
          var tabFromUrl = parseTbasFromUrl();
          if (tabFromUrl) vm.activeTab = tabFromUrl;
          window.addEventListener('hashchange', function() {
            var t = parseTbasFromUrl();
            if (t) vm.activeTab = t;
          });
        },
        methods: {
          selectTab(name) {
            this.activeTab = name;
          },
          refreshCaptcha(k) {
            this.captchaTs = Date.now();
          },
          showToast(text, ok) {
            var vm = this;
            vm.toastText = text || '';
            vm.toastOk = !!ok;
            vm.toastVisible = true;
            clearTimeout(vm._toastT);
            vm._toastT = setTimeout(function() {
              vm.toastVisible = false;
            }, 3000);
          },
          submitLogin() {
            this.loginSuccess = false;
            if (!this.loginUser) {
              this.showToast('请输入账号', false);
              return;
            }
            if (!this.loginPwd) {
              this.showToast('请输入密码', false);
              return;
            }
            if (this.codeLoginOn && !this.loginCode) {
              this.showToast('请输入验证码', false);
              return;
            }
            this.loginLoading = true;
            var fd = new FormData();
            fd.append('user', this.loginUser);
            fd.append('pwd', this.loginPwd);
            fd.append('code', this.loginCode);
            fd.append('login', '1');
            if (typeof PC_DAIHAO !== 'undefined') fd.append('daihao', PC_DAIHAO);
            if (typeof PC_SESSL !== 'undefined') {
              fd.append('BSphpSeSsL', PC_SESSL);
            }
            var vm = this;
            fetch(PC_LOGIN_URL, {
                method: 'POST',
                body: fd
              })
              .then(r => r.json())
              .then(function(res) {
                vm.loginLoading = false;
                if (res.code === 1011) {
                  vm.loginSuccess = true;
                  window.location.hash = '#login=ok';
                  saveLoginCache(vm.loginUser, vm.loginPwd);
                  vm.showToast('登录成功！', true);
                } else {
                  vm.showToast(res.msg || '登录失败', false);
                  if (isCaptchaError(res.code)) vm.captchaTs = Date.now();
                }
              })
              .catch(function() {
                vm.loginLoading = false;
                vm.showToast('请求失败，请重试', false);
              });
          },
          // 通用提交封装（可选），各 success code：1005=注册，200=解绑，1011=登录/充值，1033=改密/找回，1=反馈
          _submit(act, data, captchaKey, loadingKey, msgKey, okKey) {
            var fd = new FormData();
            for (var k in data) {
              if (data[k] !== '') fd.append(k, data[k]);
            }
            if (act === 'register') fd.append('extension', '0');
            this[loadingKey] = true;
            this[msgKey] = '';
            this[okKey] = false;
            var vm = this;
            fetch(PC_BASE + '&a=' + act + PC_PARAMS, {
                method: 'POST',
                body: fd
              })
              .then(r => r.json())
              .then(function(res) {
                vm[loadingKey] = false;
                vm[msgKey] = res.msg || (res.code >= 0 ? '操作成功' : '操作失败');
                vm[okKey] = [1005, 200, 1011, 1033, 1].indexOf(res.code) >= 0;
                if (res.code === -11111) vm.captchaTs = Date.now();
              })
              .catch(function() {
                vm[loadingKey] = false;
                vm[msgKey] = '请求失败';
              });
          },
          // 注册：成功 code=1005
          submitRegister() {
            var d = this.reg;
            if (this.codeRegistrationOn && !d.code) {
              this.showToast('请输入验证码', false);
              return;
            }
            var fd = new FormData();
            fd.append('user', d.user);
            fd.append('pwd', d.pwd);
            fd.append('pwdb', d.pwdb);
            fd.append('question', d.question);
            fd.append('answer', d.answer);
            fd.append('qq', d.qq);
            fd.append('mobile', d.mobile);
            fd.append('mail', d.mail);
            fd.append('code', d.code);
            fd.append('extension', '0');
            if (typeof PC_DAIHAO !== 'undefined') fd.append('daihao', PC_DAIHAO);
            if (typeof PC_SESSL !== 'undefined') {
              fd.append('BSphpSeSsL', PC_SESSL);
            }
            this.regLoading = true;
            this.regMsg = '';
            this.regOk = false;
            var vm = this;
            fetch(PC_BASE + '&a=register' + PC_PARAMS, {
                method: 'POST',
                body: fd
              })
              .then(r => r.json())
              .then(function(res) {
                vm.regLoading = false;
                if (isCaptchaError(res.code)) vm.captchaTs = Date.now();
                if (res.code === 1005) {
                  vm.regOk = true;
                  vm.activeTab = 'login';
                  vm.loginUser = d.user;
                  vm.loginPwd = d.pwd;
                  saveLoginCache(d.user, d.pwd);
                  vm.showToast('注册成功，请登录', true);
                } else {
                  vm.showToast(res.msg || '注册失败', false);
                }
              })
              .catch(function() {
                vm.regLoading = false;
                vm.showToast('请求失败', false);
              });
          },
          // 解绑定：成功 code=200
          submitUnbind() {
            var fd = new FormData();
            fd.append('user', this.unbind.user);
            fd.append('pwd', this.unbind.pwd);
            this.unbindLoading = true;
            this.unbindMsg = '';
            this.unbindOk = false;
            var vm = this;
            fetch(PC_BASE + '&a=unbind' + PC_PARAMS, {
                method: 'POST',
                body: fd
              })
              .then(r => r.json())
              .then(function(res) {
                vm.unbindLoading = false;
                vm.showToast(res.msg || '', res.code === 200);
              })
              .catch(function() {
                vm.unbindLoading = false;
                vm.showToast('请求失败', false);
              });
          },
          // 充值：成功 code 为 1|1005|200|1011|1033
          submitRecharge() {
            var d = this.recharge;
            var fd = new FormData();
            fd.append('user', d.user);
            fd.append('userpwd', d.userpwd);
            fd.append('ka', d.ka);
            fd.append('pwd', d.pwd);
            this.rechargeLoading = true;
            this.rechargeMsg = '';
            this.rechargeOk = false;
            var vm = this;
            fetch(PC_BASE + '&a=recharge' + PC_PARAMS, {
                method: 'POST',
                body: fd
              })
              .then(r => r.json())
              .then(function(res) {
                vm.rechargeLoading = false;
                vm.showToast(res.msg || '', [1, 1005, 200, 1011, 1033].indexOf(res.code) >= 0);
              })
              .catch(function() {
                vm.rechargeLoading = false;
                vm.showToast('请求失败', false);
              });
          },
          // 改密码：成功 code=1033，需验证码
          submitChangepwd() {
            var d = this.changepwd;
            if (this.codeBackpwdOn && !d.code) {
              this.showToast('请输入验证码', false);
              return;
            }
            var fd = new FormData();
            fd.append('user', d.user);
            fd.append('pwd', d.pwd);
            fd.append('pwda', d.pwda);
            fd.append('pwdb', d.pwdb);
            fd.append('code', d.code);
            if (typeof PC_DAIHAO !== 'undefined') fd.append('daihao', PC_DAIHAO);
            if (typeof PC_SESSL !== 'undefined') {
              fd.append('BSphpSeSsL', PC_SESSL);
            }
            this.cpLoading = true;
            this.cpMsg = '';
            this.cpOk = false;
            var vm = this;
            fetch(PC_BASE + '&a=changepwd' + PC_PARAMS, {
                method: 'POST',
                body: fd
              })
              .then(r => r.json())
              .then(function(res) {
                vm.cpLoading = false;
                vm.showToast(res.msg || '', res.code === 1033);
                if (res.code === -11111) vm.captchaTs = Date.now();
              })
              .catch(function() {
                vm.cpLoading = false;
                vm.showToast('请求失败', false);
              });
          },
          // 找回密码：通过密保，成功 code=1033
          submitFindpwd() {
            var d = this.findpwd;
            if (this.codeBackpwdOn && !d.code) {
              this.showToast('请输入验证码', false);
              return;
            }
            var fd = new FormData();
            fd.append('user', d.user);
            fd.append('pwd', d.pwd);
            fd.append('pwdb', d.pwdb);
            fd.append('mibao', d.mibao);
            fd.append('daan', d.daan);
            fd.append('code', d.code);
            if (typeof PC_DAIHAO !== 'undefined') fd.append('daihao', PC_DAIHAO);
            if (typeof PC_SESSL !== 'undefined') {
              fd.append('BSphpSeSsL', PC_SESSL);
            }
            this.fpLoading = true;
            this.fpMsg = '';
            this.fpOk = false;
            var vm = this;
            fetch(PC_BASE + '&a=findpwd' + PC_PARAMS, {
                method: 'POST',
                body: fd
              })
              .then(r => r.json())
              .then(function(res) {
                vm.fpLoading = false;
                vm.showToast(res.msg || '', res.code === 1033);
                if (res.code === -11111) vm.captchaTs = Date.now();
              })
              .catch(function() {
                vm.fpLoading = false;
                vm.showToast('请求失败', false);
              });
          },
          // 反馈问题：成功 code=1
          submitFeedback() {
            var d = this.feedback;
            if (this.codeSayOn && !d.code) {
              this.showToast('请输入验证码', false);
              return;
            }
            var fd = new FormData();
            fd.append('user', d.user);
            fd.append('pwd', d.pwd);
            fd.append('table', d.table);
            fd.append('leix', d.leix);
            fd.append('qq', d.qq);
            fd.append('txt', d.txt);
            fd.append('code', d.code);
            if (typeof PC_DAIHAO !== 'undefined') fd.append('daihao', PC_DAIHAO);
            if (typeof PC_SESSL !== 'undefined') {
              fd.append('BSphpSeSsL', PC_SESSL);
            }
            this.fbLoading = true;
            this.fbMsg = '';
            this.fbOk = false;
            var vm = this;
            fetch(PC_BASE + '&a=feedback' + PC_PARAMS, {
                method: 'POST',
                body: fd
              })
              .then(r => r.json())
              .then(function(res) {
                vm.fbLoading = false;
                vm.showToast(res.msg || '', res.code === 1);
                if (res.code === -11111) vm.captchaTs = Date.now();
              })
              .catch(function() {
                vm.fbLoading = false;
                vm.showToast('请求失败', false);
              });
          }
        }
      }).mount('#app');
    })();
  </script>
</body>

</html>