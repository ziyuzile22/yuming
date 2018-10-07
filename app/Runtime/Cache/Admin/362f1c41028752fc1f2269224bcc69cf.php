<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>首页</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <script src="<?php echo PUBLIC_PATH; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo PUBLIC_PATH; ?>layui/css/layui.css?t=<?php echo time(); ?>" media="all">
    <base target="right">
    <style>
    .layui-logo {
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1002;
        width: 200px;
        height: 60px;
        padding: 0 15px;
        box-sizing: border-box;
        overflow: hidden;
        font-weight: 300;
        background-repeat: no-repeat;
        background-position: center center;
        font-size: 18px;
        line-height: 60px;
        color: rgba(255, 255, 255, .8);
        text-align: center;
        background: #506f4e;
    }

    .layui-nav {
        margin-top: 60px;
    }
    </style>
</head>

<body>
    <div class="layui-side layui-bg-black">
        <div class="layui-logo" lay-href=""> <span><?php echo BIND_SYSNAME; ?></span> </div>
        <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="demo">
            <?php if(is_array($auth_infoA)): $i = 0; $__LIST__ = $auth_infoA;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;"><i class="layui-icon <?php echo ($vo["auth_tubiao"]); ?>"></i> <cite><?php echo ($vo["auth_name"]); ?></cite></a>
                    <dl class="layui-nav-child">
                        <?php if(is_array($auth_infoB)): foreach($auth_infoB as $key=>$bo): ?><!-- 子集权限的pid与外部权限的id必须相等  且 auth_show等于1 才显示出来。-->
                            <?php if(($bo['auth_pid'] == $vo['auth_id'])): ?><dd><a href="/admin.php/<?php echo ($bo["auth_c"]); ?>/<?php echo ($bo["auth_a"]); ?>"><?php echo ($bo["auth_name"]); ?></a></dd><?php endif; endforeach; endif; ?>
                    </dl>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <script src="<?php echo PUBLIC_PATH; ?>layui/layui.js?t=<?php echo time(); ?>" charset="utf-8"></script>
    <script>
    //JavaScript代码区域
    layui.use('element', function() {
        var element = layui.element;
    });
    </script>
</body>

</html>