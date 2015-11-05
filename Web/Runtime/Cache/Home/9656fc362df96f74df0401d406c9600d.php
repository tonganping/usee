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
        <li><a href="/index.php/User/changepwd/"><b class="ico0"></b><span>管理员账号分权管理</span></a></li>
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


    <div class="change_password">资源管理</div>
    <form id="editForm" action="/index.php/Camera/editSave">
        <table cellspacing="0" cellpadding="0" class="issue_tab">
            <tr>
                <td width="80">名称</td>
                <td class="issue_td"><input class="name" type="text" name="name" value="<?php echo ($data["name"]); ?>" /></td>
            </tr>
            <tr>
                <td>所属班级</td>
                <td>
                    <select name="class_id">
                        <option value="0">请选择</option>
                        <?php if(is_array($class_list)): $i = 0; $__LIST__ = $class_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$class): $mod = ($i % 2 );++$i;?><option value="<?php echo ($class["id"]); ?>"<?php if(($class["id"]) == $data["class_id"]): ?>selected="selected"<?php endif; ?>><?php echo ($class["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
            </tr>
            <tr>
                <td>类型</td>
                <td style="text-align:left;">
                    <div class="itemList">
                        <?php if(is_array(C("CAMERA_TYPES"))): $i = 0; $__LIST__ = C("CAMERA_TYPES");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$T): $mod = ($i % 2 );++$i;?><label><input class="radio" type="radio" name="type" value="<?php echo ($key); ?>" <?php if(($key) == $data["type"]): ?>checked="checked"<?php endif; ?> /><?php echo ($T); ?></label><?php endforeach; endif; else: echo "" ;endif; ?></div>
                </td>
            </tr>
            <tr>
                <td>网络地址</td>
                <td><input name="url" class="name" type="text" value="<?php echo ($data["url"]); ?>" /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href="/index.php/Camera/index" class="fr">返回</a>
                    <a href="javascript:void(0)" class="btn fr" id="btn_submit">确定</a>
                </td>
            </tr>
        </table>
        <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
    </form>
</div>

<script type="text/javascript" src="/Public/js/jq/form.js"></script>
<script type="text/javascript">
    Poster('camera');
</script>


</body>
</html>