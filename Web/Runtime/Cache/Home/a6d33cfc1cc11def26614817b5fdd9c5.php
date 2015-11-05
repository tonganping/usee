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

<div class="admin_left">
    <a href="/index.php" class="logo"><img src="/Public/p/logo.jpg" width="100" height="100"></a>
    <ul class="submenu">
        <li><a href="/index.php/Admin/index/"><b class="ico0"></b><span>帐号管理</span></a></li>
        <li class="cur"><a href="/index.php/User/index/"><b class="ico0"></b><span>用户管理</span></a></li>
        <li><a href="/index.php/Class/index/"><b class="ico0"></b><span>班级管理</span></a></li>
        <li><a href="/index.php/Camera/index/"><b class="ico0"></b><span>资源管理</span></a></li>
    </ul>
</div>

<div class="admin_right">
    <div class="username_ope">
    <ul class="admin_ul">
        <li><a href="#" class="admin_username"><b></b><?php echo (session('admin_name')); ?></a></li>
        <li><a href="/index.php/Index/logout/" class="exit" id="btn_exit"></a></li>
    </ul>
</div>

 
    <div class="change_password">用户管理</div>
    <form id="editForm" action="/index.php/admin/editSave">
        <table cellspacing="0" cellpadding="0" class="issue_tab">
            <tr>
                <td width="80">姓名</td>
                <td class="issue_td"><input class="name" type="text" name="name" value="<?php echo ($data["name"]); ?>" /></td>
            </tr>
            <tr>
                <td width="80">密码</td>
                <td class="issue_td"><input class="name" type="text" name="code" value="" /></td>
            </tr>
             
            <tr>
                <td>用户类型</td>
                <td style="text-align:left;">
                    <div class="itemList">
                        <?php if(is_array(C("ROLE_TYPES"))): $i = 0; $__LIST__ = C("ROLE_TYPES");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$U): $mod = ($i % 2 );++$i;?><label><input class="radio" type="radio" name="role_id" value="<?php echo ($key); ?>" <?php if(($key) == $data["type"]): ?>checked="checked"<?php endif; ?> /><?php echo ($U); ?></label><?php endforeach; endif; else: echo "" ;endif; ?></div>
                </td>
            </tr> 
            <tr>
                <td></td>
                <td>
                    <a href="/index.php/Admin/index" class="btn fr">返回</a>
                    <a href="javascript:void(0)" class="btn fr" id="btn_submit">确定</a>
                </td>
            </tr>
        </table>
        <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
    </form>
</div>

<script type="text/javascript" src="/Public/js/jq/form.js"></script>
<script type="text/javascript">
    Poster('Admin');
</script>


</body>
</html>