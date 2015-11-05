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
    <div class="show_system_name">注册</div>
    <form id="regist_form">
    <table class="regist_tab">
    	<tr>
    		<td class="show_tip">手机号码：</td>
    		<td>
    			<input class="show_input" name="cell_phone" type="text" placeholder="手机号码">
    		</td>
    	</tr>
    	<tr>
    		<td class="show_tip">家长姓名：</td>
    		<td>
    			<input class="show_input" name="name" type="text" placeholder="姓名">
    		</td>
    	</tr>
    	<tr>
    		<td class="show_tip">宝贝姓名：</td>
    		<td>
    			<input class="show_input" name="baby_name" type="text" placeholder="宝贝姓名">
    		</td>
    	</tr>
    	<tr>
    		<td class="show_tip">与宝贝的关系:</td>
    		<td>
    			<?php if(is_array($relation)): $i = 0; $__LIST__ = $relation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$R): $mod = ($i % 2 );++$i;?><label class="show_relation"><input class="radio" type="radio" name="relation_type" value="<?php echo ($key); ?>" <?php if(($key) == "1"): ?>checked="checed"<?php endif; ?>/>
            			<?php echo ($R); ?>
            		</label>
                    <?php if(($key%3) == 0): ?><br><?php endif; endforeach; endif; else: echo "" ;endif; ?>
    		</td>
    	</tr>
    	<tr>
    		<td class="show_tip">宝贝所在班级：</td>
    		<td>
                <select name="class_id" class="regist_select">
                    <option value="0" selected="selected">请选择</option>
                    <?php if(is_array($class_list)): $i = 0; $__LIST__ = $class_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$class): $mod = ($i % 2 );++$i;?><option value="<?php echo ($class["id"]); ?>"><?php echo ($class["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </td>
    	</tr>
		<tr>
			<td class="show_tip">登录密码：</td>
			<td>
				<input class="show_input" name="password" type="password" />
			</td>
		</tr>
		<tr>
			<td class="show_tip">确认密码：</td>
			<td>
				<input class="show_input" name="password2" type="password" />
			</td>
		</tr>
    </table>
        <a href="javascript:void(0)" class="regist_btn" id="btn_regist">注册</a>
		<a href="/index.php/Member/login" class="btn_go">已注册，转到登录</a>
    </form>
    <div class="record">Copyright © 有限公司</div>
    <script type="text/javascript">
    $("#btn_regist").click(function(){
        $.post('/index.php/Member/regSave/', {
        	'cell_phone':$("input[name='cell_phone']").val(),
        	'name':$("input[name='name']").val(),
        	'baby_name':$("input[name='baby_name']").val(),
        	'relation_type':$("[name='relation_type']").val(),
        	'class_id':$("[name='class_id']").val(),
        	'password':$("[name='password']").val(),
        	'password2':$("[name='password2']").val(),
        }, function(data) {
        	if(data.code==0){
        		alert(data.msg);
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