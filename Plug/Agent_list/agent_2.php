
<li data-name="console" class="layui-nav-item layui-nav-itemed">
<a href="javascript:;" lay-href="index.php?m=agent&c=main&a=info" class="layui-this" lay-tips="<?php echo Plug_Lang('中控台'); ?>" lay-direction="0">
<i class="layui-icon layui-icon-home"></i>
<cite><?php echo Plug_Lang('中控台'); ?></cite>
</a>
</li>
<li data-name="get" class="layui-nav-item">
<a href="javascript:;" lay-href="index.php?m=agent&c=sp&a=table" lay-tips="<?php echo Plug_Lang('卡管理'); ?>" lay-direction="3">
<i class="layui-icon layui-icon-layouts"></i>
<cite><?php echo Plug_Lang('卡管理'); ?></cite>
</a>
</li>
<li data-name="get" class="layui-nav-item">
<a href="javascript:;" lay-href="index.php?m=agent&c=sp&a=add" lay-tips="<?php echo Plug_Lang('财务管理'); ?>" lay-direction="5">
<i class="layui-icon layui-icon-cart-simple"></i>
<cite><?php echo Plug_Lang('余额制卡'); ?></cite>
</a>
</li>
<li data-name="get" class="layui-nav-item">
<a href="javascript:;" lay-href="index.php?m=agent&c=kuka&a=kuka_add" lay-tips="<?php echo Plug_Lang('库存制卡'); ?>" lay-direction="4">
<i class="layui-icon layui-icon-add-1"></i>
<cite><?php echo Plug_Lang('库存制卡'); ?></cite>
</a>
</li>
<li data-name="get" class="layui-nav-item">
<a href="javascript:;" lay-href="index.php?m=agent&c=sp&a=chong" lay-tips="<?php echo Plug_Lang('余额充值'); ?>" lay-direction="4">
<i class="layui-icon layui-icon-add-circle-fine"></i>
<cite><?php echo Plug_Lang('余额充值'); ?></cite>
</a>
</li>
<li data-name="home" class="layui-nav-item ">
<a href="javascript:;" lay-tips="<?php echo Plug_Lang('我的代理'); ?>" lay-direction="3">
<i class="layui-icon layui-icon-user"></i>
<cite><?php echo Plug_Lang('我的代理'); ?></cite>
</a>
<dl class="layui-nav-child">
<dd data-name="console" >
<a lay-href="index.php?m=agent&c=sp&a=dailiuser"><?php echo Plug_Lang('我的代理列表'); ?></a>
</dd>
<dd data-name="console">
<a lay-href="index.php?m=agent&c=sp&a=useradd"><?php echo Plug_Lang('添加新代理'); ?></a>
</dd>
</dl>
</li>
<li data-name="user" class="layui-nav-item">
<a href="javascript:;" lay-tips="<?php echo Plug_Lang('财务管理'); ?>" lay-direction="3">
<i class="layui-icon layui-icon-release"></i>
<cite><?php echo Plug_Lang('财务管理'); ?></cite>
</a>
<dl class="layui-nav-child">
<dd> <a lay-href="index.php?m=agent&c=carinfo&a=cardinfo"><?php echo Plug_Lang('卡通过账号统计'); ?></a></dd>
<dd> <a lay-href="index.php?m=agent&c=carinfo&a=cardbeizhu"><?php echo Plug_Lang('卡备注使用统计'); ?></a></dd>
<dd> <a lay-href="index.php?m=agent&c=carinfo&a=cardbeizhuinfo"><?php echo Plug_Lang('卡账号备注统计'); ?></a></dd>
</dl>
</li>
<li data-name="user" class="layui-nav-item">
<a href="javascript:;" lay-tips="<?php echo Plug_Lang('代理工具'); ?>" lay-direction="3">
<i class="layui-icon layui-icon-star"></i>
<cite><?php echo Plug_Lang('代理工具'); ?></cite>
</a>
<dl class="layui-nav-child">
<dd> <a lay-href="index.php?m=agent&c=carinfo&a=socard"><?php echo Plug_Lang('批量查询'); ?></a></dd>
<dd> <a lay-href="index.php?m=agent&c=carinfo&a=sdate_off"><?php echo Plug_Lang('批量冻结'); ?></a></dd>
<dd> <a lay-href="index.php?m=agent&c=carinfo&a=sdate_on"><?php echo Plug_Lang('批量解冻'); ?></a></dd>
<dd> <a lay-href="index.php?m=agent&c=carinfo&a=sdate_del"><?php echo Plug_Lang('批量删除'); ?></a></dd>
</dl>
</li>
