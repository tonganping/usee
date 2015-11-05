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
<div class="show_layout"> 	
    <div class="show_system_name"><?php echo ($class_name); ?></div>
    <div class="show_resource">
        <div class="show_img">
            <?php if(!empty($imgResource)): if(is_array($imgResource)): $i = 0; $__LIST__ = $imgResource;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?><img src="<?php echo ($img["url"]); ?>"><?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </div>
        <div class="show_vadio">
            <?php if(!empty($camResource)): if(is_array($camResource)): $i = 0; $__LIST__ = $camResource;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cam): $mod = ($i % 2 );++$i;?><video controls>
                        <source src="<?php echo ($cam["url"]); ?>" type="application/vnd.apple.mpegurl" />
                        <p class="warning">Your browser does not support HTML5 video.</p>
                    </video><?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </div>
    </div>
    <a href="/index.php/Member/logout" class="btn_go">重新登录</a>
    <div class="record">Copyright © 有限公司</div>
</div>
</body>
</html>