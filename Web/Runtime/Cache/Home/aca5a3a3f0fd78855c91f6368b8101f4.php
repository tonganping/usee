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
        <?php if(is_array(C("MENU_INFO"))): $i = 0; $__LIST__ = C("MENU_INFO");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$U): $mod = ($i % 2 );++$i;?><label>
                <?php  if (in_array($_SESSION['admin_role'],$U['role'])){ ?> 
                <li class="cur"  ><a href="/index.php<?php echo ($key); ?>"><b class="ico0"></b><span><?php echo ($U["name"]); ?></span></a></li>
                <?php }?>
            </label><?php endforeach; endif; else: echo "" ;endif; ?>
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
    <form id="editForm" action="/index.php/admin/changeSave">
        <table cellspacing="0" cellpadding="0" class="issue_tab">
            <tr>
                <td width="80">用户名</td>
                <td class="issue_td">
                    <?php echo ($data["name"]); ?>
                </td>
            </tr>
            <tr>
                <td width="80">旧密码</td>
                <td class="issue_td">
                    <input class="name" type="password" name="oldpwd" value="" />
                </td>
            </tr>
            <tr>
                <td>新密码</td>
                <td class="issue_td">
                    <input class="name" type="password" name="code" value="" />
                </td>
            </tr>
            
            <tr>
                <td ></td>
                <td>
                    <a href="/index.php/admin/index" class="fr btn">返回</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:void(0)" class="btn fr" id="btn_submit">确定</a>
                </td>
            </tr>
        </table>
        <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
    </form>
</div>

<script type="text/javascript" src="/Public/js/jq/form.js"></script>
<script type="text/javascript">
    PosterDo('Admin','changeSave');
</script>


</body>
</html>