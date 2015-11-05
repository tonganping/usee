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
<!-- <div class="show_bg"></div> -->
<div class="regist_layout"> 	
    <div class="show_system_name">家长登录</div>
    <form id="regist_form">
    <table class="regist_tab">
    	<tr>
    		<td class="show_tip">手机/姓名：</td>
    		<td>
    			<input class="show_input" id="name" type="text" placeholder="手机号码/姓名" />
    		</td>
    	</tr>
		<tr>
			<td class="show_tip">登录密码：</td>
			<td>
				<input class="show_input" id="password" type="password" />
			</td>
		</tr>
    </table>
	<a href="javascript:void(0)" class="regist_btn" id="btn_submit">确定</a>
	<a href="/index.php/Member/reg" class="btn_go">新用户注册</a>
    </form>

    <div class="record">Copyright © 有限公司</div>
    <script type="text/javascript">
    $("#btn_submit").click(function(){
        $.post('/index.php/Member/check/', {
        	'name':$("#name").val(),
        	'pass':$('#password').val(),
        }, function(data) {
        	if(data.code==0){
        		location.href='/index.php/Member/index';
        	}else{
        		alert(data.msg);
        	}
        });
    });
    </script>
</div>
</body>
</html>