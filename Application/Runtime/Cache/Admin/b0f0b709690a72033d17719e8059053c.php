<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
        </ul>
    </div>
    <div class="mainindex">
        <div class="welinfo">
            <span><img src="/Public/Admin/images/sun.png" alt="天气" /></span>
            <b><?php echo (session('name')); ?>
              <?php if( date('H',time()) > 4 && date('H',time()) < 12 ): ?>
                早上好
              <?php elseif( date('H',time()) > 11 && date('H',time()) < 18 ): ?>
                
                下午好
              <?php elseif( date('H',time()) > 17 && date('H',time()) < 24 ): ?>
                
                晚上好
              <?php else: ?>
                
                夜深了<?php endif; ?>
              ,欢迎使用商品管理系统</b>
            <a href="<?php echo U('manager/changePwd');?>">修改密码</a>
        </div>
        <div class="welinfo">
            <span><img src="/Public/Admin/images/time.png" alt="时间" /></span>
            <i>您上次登录的时间：<?php echo (date('Y-m-d H:i',session('lastTime'))); ?></i>
        </div>
        <div class="xline"></div>
        <div class="box"></div>
        <div class="welinfo">
            <span><img src="/Public/Admin/images/dp.png" alt="提醒" /></span>
            <b>环境信息</b>
        </div>
        <ul class="infolist">
          <?php echo ($_SERVER['SERVER_SOFTWARE']); ?>
        </ul>
        <div class="xline"></div>
        <div class="uimakerinfo"><b>最新订单信息</b></div>
        <ul class="infolist">
            <li><a href="#">如何发布文章</a></li>
            <li><a href="#">如何访问网站</a></li>
            <li><a href="#">如何管理广告</a></li>
        </ul>
    </div>
</body>

</html>