<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" name="viewport" content="initial-scale=0.7 maximum-scale=1.0, user-scalable=no, width=device-width">
    <title><?php echo (C("PROJECT_NAME")); ?></title>
    <link rel="stylesheet"  href="/Public/css/style.css">
    <link rel="stylesheet"  href="/Public/css/show.css">
    <script src="/Public/js/jq/jquery.js"></script>
    <script src="/Public/js/web.js"></script>
    <script src="/Public/js/oa.js"></script>
    <script src="/Public/js/sha1.js"></script>
</head>

<body>
<div class="land_bg"></div>
<div class="land_layout">
    <div class="land_logo"></div>
    <div class="system_name">系统</div>
    <form id="land_form">
        <input id="username" name="username" class="land_input" type="text" value="" placeholder="用户名" />
        <input id="password" name="password" class="land_input" type="password" value="" placeholder="密码" />
        <a href="javascript:void(0)" class="land_btn" id="btn_login">登录</a>
    </form>
    <div class="record">Copyright © 有限公司</div>
</div>








</body>
</html>