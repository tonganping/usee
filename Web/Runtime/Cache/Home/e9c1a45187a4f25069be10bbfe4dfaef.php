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


    <div class="data_list_bt">班级管理</div>
    <div class="issue_div">
        <a href="/index.php/Class/edit" class="btn" id="btn_edit">添加</a>
    </div>
    <table class="data_list" width="100%">
        <tr>
            <th width="5%">ID</th>
            <th>名称</th>
            <th width="10%">排序</th>
            <th width="15%">操作</th>
        </tr>
        <?php if(is_array($data_list)): $i = 0; $__LIST__ = $data_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($data["id"]); ?></td>
            <td><?php echo ($data["name"]); ?></td>
            <td><?php echo ($data["order"]); ?></td>
            <td>
                <a href="/index.php/Class/edit/id/<?php echo ($data["id"]); ?>">编辑</a>
                <a href="javascript:;" onclick="Deleter('Class', <?php echo ($data["id"]); ?>);">删除</a>
            </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
    <div class="pages"><?php echo ($pager); ?></div>
</div>





</body>
</html>