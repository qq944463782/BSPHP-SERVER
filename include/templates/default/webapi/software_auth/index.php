<?php
// 软件用户中心：登录 / 注册 / 找回密码，每种支持 账号密码 / 邮箱验证码 / 手机短信
$area_list = array(
    array('v' => '86', 'l' => '中国大陆 +86'),
    array('v' => '852', 'l' => '香港 +852'),
    array('v' => '853', 'l' => '澳门 +853'),
    array('v' => '886', 'l' => '台湾 +886'),
    array('v' => '1', 'l' => '美国/加拿大 +1'),
    array('v' => '81', 'l' => '日本 +81'),
    array('v' => '82', 'l' => '韩国 +82'),
    array('v' => '44', 'l' => '英国 +44'),
    array('v' => '49', 'l' => '德国 +49'),
    array('v' => '33', 'l' => '法国 +33'),
    array('v' => '61', 'l' => '澳大利亚 +61'),
    array('v' => '65', 'l' => '新加坡 +65'),
);
// URL 语言参数（例如 ?lang=en_US），仅做透传
$lang = isset($_GET['lang']) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['lang']) : '';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang ?: 'zh-CN', ENT_QUOTES, 'UTF-8'); ?>">
<head>
  <meta charset="utf-8">
  <title>软件用户中心</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="./statics/vue/vue.global.prod.js"></script>
  <style>
    *{box-sizing:border-box;}
    body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;background:linear-gradient(145deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);min-height:100vh;margin:0;padding:20px;color:#333;}
    .wrap{max-width:420px;margin:0 auto;background:#fff;border-radius:12px;padding:24px;box-shadow:0 20px 60px rgba(0,0,0,.3);}
    .announce{
      position:relative;
      margin:0 0 20px;
      padding:12px 12px 12px 72px;
      border-radius:10px;
      background:linear-gradient(135deg,rgba(64,150,255,.14) 0%,rgba(9,88,217,.06) 100%);
      border:1px solid rgba(64,150,255,.25);
      font-size:13px;
      line-height:1.6;
      color:#1f2933;
      box-shadow:0 8px 20px rgba(15,52,96,.12);
      overflow:hidden;
    }
    .announce::before{
      content:'公告';
      position:absolute;
      left:14px;
      top:12px;
      padding:2px 6px;
      border-radius:999px;
      font-size:11px;
      letter-spacing:1px;
      text-transform:uppercase;
      background:linear-gradient(135deg,#4096ff 0%,#1677ff 100%);
      color:#fff;
      box-shadow:0 4px 10px rgba(9,88,217,.35);
    }
    .announce strong{
      display:block;
      margin-bottom:4px;
      font-size:13px;
      font-weight:600;
      color:#102a43;
    }
    .main-tabs{
      display:flex;
      border-radius:999px;
      padding:4px;
      margin-bottom:20px;
      background:rgba(245,247,250,.9);
      box-shadow:0 2px 10px rgba(15,52,96,.08);
    }
    .main-tabs .mt{
      flex:1;
      text-align:center;
      padding:8px 0;
      cursor:pointer;
      font-weight:500;
      color:#666;
      font-size:14px;
      border-radius:999px;
      position:relative;
      transition:all .2s ease;
      user-select:none;
    }
    .main-tabs .mt.on{
      color:#fff;
      background:linear-gradient(135deg,#4096ff 0%,#1677ff 50%,#0958d9 100%);
      box-shadow:0 4px 12px rgba(9,88,217,.35);
    }
    .sub-tabs{
      display:inline-flex;
      flex-wrap:wrap;
      justify-content:flex-start;
      gap:8px;
      margin:0 auto 16px;
      padding:4px;
      border-radius:999px;
      background:rgba(245,247,250,.9);
      box-shadow:0 2px 8px rgba(0,0,0,.04) inset;
    }
    .sub-tabs .st{
      position:relative;
      padding:6px 16px;
      border-radius:999px;
      cursor:pointer;
      font-size:13px;
      color:#666;
      transition:all .2s ease;
      user-select:none;
      white-space:nowrap;
    }
    .sub-tabs .st::before{
      content:'';
      position:absolute;
      inset:0;
      border-radius:999px;
      background:linear-gradient(135deg,#e0ecff 0%,#f5f7ff 100%);
      opacity:0;
      transform:scale(.95);
      transition:all .2s ease;
      z-index:-1;
    }
    .sub-tabs .st:hover{
      color:#1890ff;
    }
    .sub-tabs .st.on{
      color:#fff;
      font-weight:500;
      background:linear-gradient(135deg,#4096ff 0%,#1677ff 50%,#0958d9 100%);
      box-shadow:0 4px 12px rgba(9,88,217,.3);
    }
    .sub-tabs .st.on::before{
      opacity:0;
    }
    .form-item{margin-bottom:12px;}
    .form-item label{display:block;font-size:12px;color:#666;margin-bottom:4px;}
    .form-item input,.form-item select{width:100%;padding:10px 12px;border:1px solid #d9d9d9;border-radius:6px;font-size:14px;}
    .form-item input:focus,.form-item select:focus{outline:none;border-color:#1890ff;}
    .code-row{display:flex;gap:8px;align-items:center;}
    .code-row input{flex:1;}
    .code-row .btn-send{flex:0 0 auto;padding:10px 14px;font-size:13px;white-space:nowrap;}
    .img-code-row{display:flex;align-items:center;gap:8px;}
    .img-code-row input{width:100px;}
    .img-code-row img{height:36px;border-radius:4px;cursor:pointer;border:1px solid #d9d9d9;}
    .img-code-row .refresh-txt{font-size:12px;color:#1890ff;cursor:pointer;}
    .btn{
      width:100%;
      padding:12px;
      border:none;
      border-radius:999px;
      background:linear-gradient(135deg,#4096ff 0%,#1677ff 50%,#0958d9 100%);
      color:#fff;
      font-size:15px;
      font-weight:600;
      cursor:pointer;
      margin-top:8px;
      box-shadow:0 8px 18px rgba(9,88,217,.35);
      transition:all .2s ease;
    }
    .btn:hover:not(:disabled){
      transform:translateY(-1px);
      box-shadow:0 10px 22px rgba(9,88,217,.45);
    }
    .btn:active:not(:disabled){
      transform:translateY(0);
      box-shadow:0 6px 16px rgba(9,88,217,.35);
    }
    .btn:disabled{
      background:#d9d9d9;
      box-shadow:none;
      cursor:not-allowed;
    }
    .btn-send{
      padding:8px 14px;
      border-radius:999px;
      border:1px solid #1677ff;
      background:#fff;
      color:#1677ff;
      cursor:pointer;
      font-size:13px;
      font-weight:500;
      box-shadow:0 2px 6px rgba(9,88,217,.18);
      transition:all .2s ease;
    }
    .btn-send:hover:not(:disabled){
      background:linear-gradient(135deg,#e6f4ff 0%,#f0f5ff 100%);
      color:#0958d9;
      box-shadow:0 3px 8px rgba(9,88,217,.25);
      transform:translateY(-0.5px);
    }
    .btn-send:active:not(:disabled){
      transform:translateY(0);
      box-shadow:0 2px 6px rgba(9,88,217,.18);
    }
    .btn-send:disabled{
      border-color:#d9d9d9;
      color:#bfbfbf;
      background:#f5f5f5;
      box-shadow:none;
      cursor:not-allowed;
    }
    .link-row{margin-top:16px;display:flex;justify-content:space-between;font-size:13px;}
    .link-row a{color:#1890ff;cursor:pointer;text-decoration:none;}
    .link-row a:hover{text-decoration:underline;}
    .msg{margin-top:10px;padding:8px 12px;border-radius:6px;font-size:13px;}
    .msg.ok{background:#f6ffed;border:1px solid #b7eb8f;color:#52c41a;}
    .msg.err{background:#fff2f0;border:1px solid #ffccc7;color:#ff4d4f;}
    .pane{display:none;}
    .pane.on{display:block;}
    .area-input{display:flex;gap:8px;}
    .area-input select{width:160px;flex-shrink:0;}
    .area-input input{flex:1;}
  </style>
</head>
<body>
<div id="app">
  <div class="wrap">
    <div class="announce">
      <strong>软件公告</strong>
      <?php if (!empty($app_gg)) {
        echo nl2br(htmlspecialchars($app_gg, ENT_QUOTES, 'UTF-8'));
      } else {
        echo '暂无公告';
      } ?>
    </div>

    <div class="main-tabs">
      <div class="mt" :class="{on:tab==='login'}" @click="tab='login'">登录</div>
      <div class="mt" :class="{on:tab==='register'}" @click="tab='register'">注册</div>
      <div class="mt" :class="{on:tab==='reset'}" @click="tab='reset'">找回密码</div>
    </div>

    <!-- ========== 登录 ========== -->
    <div class="pane" :class="{on:tab==='login'}">
      <div class="sub-tabs">
        <span class="st" :class="{on:loginWay==='account'}" @click="loginWay='account'">账号密码</span>
        <span class="st" :class="{on:loginWay==='email'}" @click="loginWay='email'">邮箱验证码</span>
        <span class="st" :class="{on:loginWay==='sms'}" @click="loginWay='sms'">手机短信</span>
      </div>
      <template v-if="loginWay==='account'">
        <div class="form-item">
          <input v-model="login.user" placeholder="账号 / 邮箱 / 手机">
        </div>
        <div class="form-item">
          <input v-model="login.pwd" type="password" placeholder="密码">
        </div>
      </template>
      <template v-if="loginWay==='email'">
        <div class="form-item">
          <input v-model="login.email" type="email" placeholder="邮箱">
        </div>
        <div class="form-item">
          <div class="code-row">
            <input v-model="login.emailCode" placeholder="邮箱验证码">
            <button type="button" class="btn-send" @click="sendEmailCode('login')" :disabled="emailCooldown>0">{{ emailCooldown>0 ? emailCooldown+'s 后重发' : '发送验证码' }}</button>
          </div>
        </div>
      </template>
      <template v-if="loginWay==='sms'">
        <div class="form-item">
          <div class="area-input">
            <select v-model="login.area">
              <?php foreach ($area_list as $a) { ?>
              <option value="<?php echo $a['v']; ?>"><?php echo $a['l']; ?></option>
              <?php } ?>
            </select>
            <input v-model="login.mobile" placeholder="手机号">
          </div>
        </div>
        <div class="form-item">
          <div class="code-row">
            <input v-model="login.smsCode" placeholder="短信验证码">
            <button type="button" class="btn-send" @click="sendSmsCode('login')" :disabled="smsCooldown>0">{{ smsCooldown>0 ? smsCooldown+'s 后重发' : '发送验证码' }}</button>
          </div>
        </div>
      </template>
      <div class="form-item" v-if="codeFlags.login===1">
        <div class="img-code-row">
           <input v-model="imgCode" name="imgCode" placeholder="图片验证码">
          <img :src="'index.php?m=coode&time='+captchaTs+'&sessl='+sessl" alt="验证码" @click="refreshCaptcha">
          <span class="refresh-txt" @click="refreshCaptcha">换一张</span>
        </div>
      </div>
      <button class="btn" @click="doLogin" :disabled="loading.login">登录</button>
      <div class="link-row">
        <a @click="tab='register'">注册新账号</a>
        <a @click="tab='reset'">忘记密码？</a>
      </div>
      <div class="msg" :class="res.loginOk?'ok':'err'" v-if="res.loginMsg">{{ res.loginMsg }}</div>
    </div>

    <!-- ========== 注册 ========== -->
    <div class="pane" :class="{on:tab==='register'}">
      <?php if (($config_user['user_re_set'] ?? 0) != 1) { ?>
      <div class="msg err">当前系统已关闭注册功能</div>
      <?php } else { ?>
      <div class="sub-tabs">
        <span class="st" :class="{on:regWay==='sms'}" @click="regWay='sms'">手机短信</span>
        <span class="st" :class="{on:regWay==='email'}" @click="regWay='email'">邮箱验证码</span>
        <span class="st" :class="{on:regWay==='account'}" @click="regWay='account'">账号密码</span>
      </div>
      <template v-if="regWay==='account'">
        <div class="form-item"><input v-model="reg.user" placeholder="账号"></div>
        <div class="form-item"><input v-model="reg.pwd" type="password" placeholder="密码"></div>
        <div class="form-item"><input v-model="reg.pwdb" type="password" placeholder="确认密码"></div>
        <div class="form-item"><input v-model="reg.qq" placeholder="QQ(选填)"></div>
        <div class="form-item"><input v-model="reg.mail" type="email" placeholder="邮箱<?php echo ($config_user['re_mail']??0)==1?'(必填)':'(选填)'; ?>"></div>
        <div class="form-item"><input v-model="reg.mobile" placeholder="手机<?php echo ($config_user['re_phone']??0)==1?'(必填)':'(选填)'; ?>"></div>
        <div class="form-item"><input v-model="reg.extension" :disabled="inviteU!==''" placeholder="邀请码(选填)"></div>
      </template>
      <template v-if="regWay==='email'">
        <div class="form-item">
          
          <input v-model="reg.user" placeholder="登陆账号">
        </div>
        <div class="form-item"><input v-model="reg.email" type="email" placeholder="邮箱"></div>
        <div class="form-item">
          <div class="code-row">
            <input v-model="reg.emailCode" name="emailCode" placeholder="邮箱验证码">
            <button type="button" class="btn-send" @click="sendEmailCode('register')" :disabled="emailCooldown>0">{{ emailCooldown>0 ? emailCooldown+'s 后重发' : '发送验证码' }}</button>
          </div>
        </div>
        <div class="form-item"><input v-model="reg.pwd" type="password" placeholder="密码"></div>
        <div class="form-item"><input v-model="reg.pwdb" type="password" placeholder="确认密码"></div>
        <div class="form-item"><input v-model="reg.extension" :disabled="inviteU!==''" placeholder="邀请码(选填)"></div>
      </template>
      <template v-if="regWay==='sms'">
        <div class="form-item">
     
          <input v-model="reg.user" placeholder="登陆账号">
        </div>
        <div class="form-item">
          <div class="area-input">
            <select v-model="reg.area">
              <?php foreach ($area_list as $a) { ?>
              <option value="<?php echo $a['v']; ?>"><?php echo $a['l']; ?></option>
              <?php } ?>
            </select>
            <input v-model="reg.mobile" placeholder="手机号">
          </div>
        </div>
        <div class="form-item">
          <div class="code-row">
            <input v-model="reg.smsCode" placeholder="短信验证码">
            <button type="button" class="btn-send" @click="sendSmsCode('register')" :disabled="smsCooldown>0">{{ smsCooldown>0 ? smsCooldown+'s 后重发' : '发送验证码' }}</button>
          </div>
        </div>
        <div class="form-item"><input v-model="reg.pwd" type="password" placeholder="密码"></div>
        <div class="form-item"><input v-model="reg.pwdb" type="password" placeholder="确认密码"></div>
        <div class="form-item"><input v-model="reg.extension" :disabled="inviteU!==''" placeholder="邀请码(选填)"></div>
      </template>
      <div class="form-item" v-if="codeFlags.registration===1">
        <div class="img-code-row">
           <input v-model="imgCode" name="imgCode" placeholder="图片验证码">
          <img :src="'index.php?m=coode&time='+captchaTs+'&sessl='+sessl" alt="验证码" @click="refreshCaptcha">
          <span class="refresh-txt" @click="refreshCaptcha">换一张</span>
        </div>
      </div>
      <button class="btn" @click="doRegister" :disabled="loading.reg">注册</button>
      <div class="link-row">
        <a @click="tab='login'">已有账号？登录</a>
        <a @click="tab='reset'">忘记密码？</a>
      </div>
      <div class="msg" :class="res.regOk?'ok':'err'" v-if="res.regMsg">{{ res.regMsg }}</div>
      <?php } ?>
    </div>

    <!-- ========== 找回密码 ========== -->
    <div class="pane" :class="{on:tab==='reset'}">
      <div class="sub-tabs">
        <span class="st" :class="{on:resetWay==='email'}" @click="resetWay='email'">邮箱验证码</span>
        <span class="st" :class="{on:resetWay==='sms'}" @click="resetWay='sms'">手机短信</span>
      </div>
      <template v-if="resetWay==='email'">
        <div class="form-item"><input v-model="reset.email" type="email" placeholder="邮箱"></div>
        <div class="form-item">
          <div class="code-row">
            <input v-model="reset.emailCode" placeholder="邮箱验证码">
            <button type="button" class="btn-send" @click="sendEmailCode('reset')" :disabled="emailCooldown>0">{{ emailCooldown>0 ? emailCooldown+'s 后重发' : '发送验证码' }}</button>
          </div>
        </div>
        <div class="form-item"><input v-model="reset.pwd" type="password" placeholder="新密码"></div>
        <div class="form-item"><input v-model="reset.pwdb" type="password" placeholder="确认新密码"></div>
      </template>
      <template v-if="resetWay==='sms'">
        <div class="form-item">
          <div class="area-input">
            <select v-model="reset.area">
              <?php foreach ($area_list as $a) { ?>
              <option value="<?php echo $a['v']; ?>"><?php echo $a['l']; ?></option>
              <?php } ?>
            </select>
            <input v-model="reset.mobile" placeholder="手机号">
          </div>
        </div>
        <div class="form-item">
          <div class="code-row">
            <input v-model="reset.smsCode" name="smsCode" placeholder="短信验证码">
            <button type="button" class="btn-send" @click="sendSmsCode('reset')" :disabled="smsCooldown>0">{{ smsCooldown>0 ? smsCooldown+'s 后重发' : '发送验证码' }}</button>
          </div>
        </div>
        <div class="form-item"><input v-model="reset.pwd" type="password" placeholder="新密码"></div>
        <div class="form-item"><input v-model="reset.pwdb" type="password" placeholder="确认新密码"></div>
      </template>
      <div class="form-item" v-if="codeFlags.backpwd===1">
        <div class="img-code-row">
          <input v-model="imgCode" name="imgCode" placeholder="图片验证码">
          <img :src="'index.php?m=coode&time='+captchaTs+'&sessl='+sessl" alt="验证码" @click="refreshCaptcha">
          <span class="refresh-txt" @click="refreshCaptcha">换一张</span>
        </div>
      </div>
      <button class="btn" @click="doReset" :disabled="loading.reset">重置密码</button>
      <div class="link-row">
        <a @click="tab='login'">返回登录</a>
        <a @click="tab='register'">注册新账号</a>
      </div>
      <div class="msg" :class="res.resetOk?'ok':'err'" v-if="res.resetMsg">{{ res.resetMsg }}</div>
    </div>

  </div>
</div>

<script>
(function(){
  var areaList = <?php echo json_encode($area_list); ?>;
  var codeFlags = {
    login: <?php echo (int)$code_flags['login']; ?>,
    registration: <?php echo (int)$code_flags['registration']; ?>,
    backpwd: <?php echo (int)$code_flags['backpwd']; ?>
  };
  var daihao = '<?php echo addslashes($daihao); ?>';
  var sessl = '<?php echo addslashes($BSphpSeSsL); ?>';
  var inviteU = '<?php echo addslashes($invite_u ?? ''); ?>';
  // 后端可能返回空字符串/空白字符；统一 trim，保证空时允许手动输入
  inviteU = (inviteU || '').trim();
  var lang  = '<?php echo addslashes($lang); ?>';

  function post(action, data, cb) {
    var fd = new FormData();
    data = data || {};
    data.daihao = daihao;
    data.BSphpSeSsL = sessl;
    if (lang) data.lang = lang;
    for (var k in data) { if (data[k] !== undefined) fd.append(k, data[k]); }
    fetch('index.php?m=webapi&c=software_auth&a=' + action, { method: 'POST', body: fd })
      .then(function(r){ return r.json(); })
      .then(function(res){ cb && cb(res); })
      .catch(function(){ cb && cb({ code: -1, msg: '请求失败' }); });
  }

  var app = window.Vue.createApp({
    data: function() {
      return {
        tab: 'login',
        loginWay: 'account',
        regWay: 'sms',
        resetWay: 'email',
        codeFlags: codeFlags,
        captchaTs: Date.now(),
        daihao: daihao,
        sessl: sessl,
        inviteU: inviteU,
        imgCode: '',
        login: { user: '', pwd: '', code: '', email: '', emailCode: '', area: '86', mobile: '', smsCode: '' },
        reg: { user: '', pwd: '', pwdb: '', qq: '', mail: '', mobile: '', extension: inviteU, code: '', email: '', emailCode: '', area: '86', smsCode: '' },
        reset: { email: '', emailCode: '', area: '86', mobile: '', smsCode: '', pwd: '', pwdb: '' },
        loading: { login: false, reg: false, reset: false },
        smsCooldown: 0,
        emailCooldown: 0,
        res: { loginOk: false, loginMsg: '', regOk: false, regMsg: '', resetOk: false, resetMsg: '' },
        timers: { login: null, reg: null, reset: null }
      };
    },
    mounted: function() {
      var vm = this;
      setInterval(function() {
        if (vm.smsCooldown > 0) vm.smsCooldown--;
        if (vm.emailCooldown > 0) vm.emailCooldown--;
      }, 1000);
    },
    methods: {
      refreshCaptcha: function() { this.captchaTs = Date.now(); },
      scheduleHideErrMsg: function(which) {
        var vm = this;
        var tkey = (which === 'loginMsg') ? 'login' : ((which === 'regMsg') ? 'reg' : 'reset');
        if (vm.timers[tkey]) clearTimeout(vm.timers[tkey]);
        vm.timers[tkey] = setTimeout(function() {
          if (which === 'loginMsg' && !vm.res.loginOk) vm.res.loginMsg = '';
          if (which === 'regMsg' && !vm.res.regOk) vm.res.regMsg = '';
          if (which === 'resetMsg' && !vm.res.resetOk) vm.res.resetMsg = '';
        }, 3000);
      },
      sendSmsCode: function(scene) {
        var vm = this;
        var mobile = vm.tab === 'login' ? vm.login.mobile : (vm.tab === 'register' ? vm.reg.mobile : vm.reset.mobile);
        var area = vm.tab === 'login' ? vm.login.area : (vm.tab === 'register' ? vm.reg.area : vm.reset.area);
        if (!mobile) {
          if (scene === 'login') { vm.res.loginOk = false; vm.res.loginMsg = '请先填写手机号'; vm.scheduleHideErrMsg('loginMsg'); }
          if (scene === 'register') { vm.res.regOk = false; vm.res.regMsg = '请先填写手机号'; vm.scheduleHideErrMsg('regMsg'); }
          if (scene === 'reset') { vm.res.resetOk = false; vm.res.resetMsg = '请先填写手机号'; vm.scheduleHideErrMsg('resetMsg'); }
          return;
        }
        var needCode = (scene === 'login') ? (vm.codeFlags.login === 1) : ((scene === 'register') ? (vm.codeFlags.registration === 1) : (vm.codeFlags.backpwd === 1));
        if (needCode && !vm.imgCode) {
          if (scene === 'login') { vm.res.loginOk = false; vm.res.loginMsg = '请输入图片验证码'; vm.scheduleHideErrMsg('loginMsg'); }
          if (scene === 'register') { vm.res.regOk = false; vm.res.regMsg = '请输入图片验证码'; vm.scheduleHideErrMsg('regMsg'); }
          if (scene === 'reset') { vm.res.resetOk = false; vm.res.resetMsg = '请输入图片验证码'; vm.scheduleHideErrMsg('resetMsg'); }
          return;
        }
        var fd = { scene: scene, mobile: mobile, area: area };
        if (needCode) fd.code = vm.imgCode;
        post('send_sms_code', fd, function(res) {
          if (res.code === 0) { vm.smsCooldown = 60; }
          if (scene === 'login') {
            vm.res.loginOk = (res.code === 0);
            vm.res.loginMsg = res.msg || '';
            if (res.code !== 0) vm.scheduleHideErrMsg('loginMsg');
          } else if (scene === 'register') {
            vm.res.regOk = (res.code === 0);
            vm.res.regMsg = res.msg || '';
            if (res.code !== 0) vm.scheduleHideErrMsg('regMsg');
          } else {
            vm.res.resetOk = (res.code === 0);
            vm.res.resetMsg = res.msg || '';
            if (res.code !== 0) vm.scheduleHideErrMsg('resetMsg');
          }
        });
      },
      sendEmailCode: function(scene) {
        var vm = this;
        var email = vm.tab === 'login' ? vm.login.email : (vm.tab === 'register' ? vm.reg.email : vm.reset.email);
        if (!email) {
          if (scene === 'login') { vm.res.loginOk = false; vm.res.loginMsg = '请先填写邮箱'; vm.scheduleHideErrMsg('loginMsg'); }
          if (scene === 'register') { vm.res.regOk = false; vm.res.regMsg = '请先填写邮箱'; vm.scheduleHideErrMsg('regMsg'); }
          if (scene === 'reset') { vm.res.resetOk = false; vm.res.resetMsg = '请先填写邮箱'; vm.scheduleHideErrMsg('resetMsg'); }
          return;
        }
        var needCode = (scene === 'login') ? (vm.codeFlags.login === 1) : ((scene === 'register') ? (vm.codeFlags.registration === 1) : (vm.codeFlags.backpwd === 1));
        if (needCode && !vm.imgCode) {
          if (scene === 'login') { vm.res.loginOk = false; vm.res.loginMsg = '请输入图片验证码'; vm.scheduleHideErrMsg('loginMsg'); }
          if (scene === 'register') { vm.res.regOk = false; vm.res.regMsg = '请输入图片验证码'; vm.scheduleHideErrMsg('regMsg'); }
          if (scene === 'reset') { vm.res.resetOk = false; vm.res.resetMsg = '请输入图片验证码'; vm.scheduleHideErrMsg('resetMsg'); }
          return;
        }
        var fd = { scene: scene, email: email };
        if (needCode) fd.code = vm.imgCode;
        post('send_email_code', fd, function(res) {
          if (res.code === 0) { vm.emailCooldown = 60; }
          if (scene === 'login') {
            vm.res.loginOk = (res.code === 0);
            vm.res.loginMsg = res.msg || '';
            if (res.code !== 0) vm.scheduleHideErrMsg('loginMsg');
          } else if (scene === 'register') {
            vm.res.regOk = (res.code === 0);
            vm.res.regMsg = res.msg || '';
            if (res.code !== 0) vm.scheduleHideErrMsg('regMsg');
          } else {
            vm.res.resetOk = (res.code === 0);
            vm.res.resetMsg = res.msg || '';
            if (res.code !== 0) vm.scheduleHideErrMsg('resetMsg');
          }
        });
      },
      doLogin: function() {
        var vm = this, L = vm.login;
        vm.loading.login = true;
        vm.res.loginMsg = '';
        if (vm.loginWay === 'account') {
          post('login', { user: L.user, pwd: L.pwd, code: vm.imgCode }, function(res) {
            vm.loading.login = false;
            if(res.code === 1011){
              vm.res.loginOk = true;
              vm.res.loginMsg = '登录成功';
              //#login=账号密码/短信/邮箱都跳-时间戳 
              var hash = '#login=' + vm.loginWay + '-' + Date.now();
              if(location.hash !== hash) location.hash = hash;
            }else{
              vm.res.loginOk = false;
              vm.res.loginMsg = res.msg || '登录失败';
              vm.scheduleHideErrMsg('loginMsg');
            }
          });
        } else if (vm.loginWay === 'email') {
          post('login_email', { email: L.email, email_code: L.emailCode, code: vm.imgCode }, function(res) {
            vm.loading.login = false;
            if(res.code === 1011){
              vm.res.loginOk = true;
              vm.res.loginMsg = '登录成功';
              //#login=邮箱验证码-时间戳 
              var hash = '#login=' + vm.loginWay + '-' + Date.now();
              if(location.hash !== hash) location.hash = hash;
            }else{
              vm.res.loginOk = false;
              vm.res.loginMsg = res.msg || '登录失败';
              vm.scheduleHideErrMsg('loginMsg');
            }
          });
        } else {
          post('login_sms', { mobile: L.mobile, area: L.area, sms_code: L.smsCode, code: vm.imgCode }, function(res) {
            vm.loading.login = false;
            if(res.code === 1011){
              vm.res.loginOk = true;
              vm.res.loginMsg = '登录成功';
              //#login=短信验证码-时间戳 
              var hash = '#login=' + vm.loginWay + '-' + Date.now();
              if(location.hash !== hash) location.hash = hash;
            }else{
              vm.res.loginOk = false;
              vm.res.loginMsg = res.msg || '登录失败';
              vm.scheduleHideErrMsg('loginMsg');
            }
          });
        }
      },
      doRegister: function() {
        var vm = this, R = vm.reg;
        vm.loading.reg = true;
        vm.res.regMsg = '';
        if (vm.regWay === 'account') {
          post('register', { user: R.user, pwd: R.pwd, pwdb: R.pwdb, qq: R.qq, mail: R.mail, mobile: R.mobile, extension: R.extension, code: vm.imgCode }, function(res) {
            vm.loading.reg = false;
            vm.res.regOk = (res.code === 1005);
            vm.res.regMsg = res.msg || (vm.res.regOk ? '注册成功' : '注册失败');
            if (!vm.res.regOk) vm.scheduleHideErrMsg('regMsg');
          });
        } else if (vm.regWay === 'email') {
          post('register_email', { user: R.user, email: R.email, email_code: R.emailCode, pwd: R.pwd, pwdb: R.pwdb, extension: R.extension, code: vm.imgCode }, function(res) {
            vm.loading.reg = false;
            vm.res.regOk = (res.code === 1005);
            vm.res.regMsg = res.msg || (vm.res.regOk ? '注册成功' : '注册失败');
            if (!vm.res.regOk) vm.scheduleHideErrMsg('regMsg');
          });
        } else {
          post('register_sms', { user: R.user, mobile: R.mobile, area: R.area, sms_code: R.smsCode, pwd: R.pwd, pwdb: R.pwdb, extension: R.extension, code: vm.imgCode }, function(res) {
            vm.loading.reg = false;
            vm.res.regOk = (res.code === 1005);
            vm.res.regMsg = res.msg || (vm.res.regOk ? '注册成功' : '注册失败');
            if (!vm.res.regOk) vm.scheduleHideErrMsg('regMsg');
          });
        }
      },
      doReset: function() {
        var vm = this, R = vm.reset;
        vm.loading.reset = true;
        vm.res.resetMsg = '';
        if (vm.resetWay === 'email') {
          post('resetpwd_email', { email: R.email, email_code: R.emailCode, pwd: R.pwd, pwdb: R.pwdb, code: vm.imgCode }, function(res) {
            vm.loading.reset = false;
            vm.res.resetOk = (res.code === 1033);
            vm.res.resetMsg = res.msg || (vm.res.resetOk ? '密码已重置' : '操作失败');
            if (!vm.res.resetOk) vm.scheduleHideErrMsg('resetMsg');
          });
        } else {
          post('resetpwd_sms', { mobile: R.mobile, area: R.area, sms_code: R.smsCode, pwd: R.pwd, pwdb: R.pwdb, code: vm.imgCode }, function(res) {
            vm.loading.reset = false;
            vm.res.resetOk = (res.code === 1033);
            vm.res.resetMsg = res.msg || (vm.res.resetOk ? '密码已重置' : '操作失败');
            if (!vm.res.resetOk) vm.scheduleHideErrMsg('resetMsg');
          });
        }
      }
    }
  });
  app.mount('#app');
})();
</script>
</body>
</html>
