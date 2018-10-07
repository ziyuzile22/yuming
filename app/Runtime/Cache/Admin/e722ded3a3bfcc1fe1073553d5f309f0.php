<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录系统</title>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1,user-scalable=no">

<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<script src="<?php echo PUBLIC_PATH; ?>js/jquery.min.js"></script>

<link rel="stylesheet" href="<?php echo PUBLIC_PATH; ?>layui/css/layui.css?t=<?php echo time(); ?>" media="all">

<script src="<?php echo PUBLIC_PATH; ?>dialog.js?t=<?php echo time(); ?>"></script>

<link rel="stylesheet" href="<?php echo Admin_CSS_URL; ?>common.css?t=<?php echo time(); ?>">
<script src="<?php echo Admin_JS_URL; ?>y-common.js?t=<?php echo time(); ?>"></script>

<base target="_self">
    <script src="<?php echo PUBLIC_PATH; ?>/layui/layui.js?t=<?php echo time(); ?>" charset="utf-8"></script>
    <link rel="stylesheet" href="<?php echo Admin_CSS_URL; ?>xadmin.css?t=<?php echo time(); ?>">

</head>
<body class="login-bg">
<div class="login">
    <div class="message"><?php echo BIND_SYSNAME; ?></div>
    <div id="darkbannerwrap"></div>
    <form method="post" class="layui-form">
        <input name="username" placeholder="用户名" type="text" lay-verify="required" class="layui-input">
        <hr class="hr15">
        <input name="password" lay-verify="required" placeholder="密码" type="password" class="layui-input">
        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
        <hr class="hr20">
    </form>
</div>
<script>
    $(function () {
        layui.use('form', function () {
            var form = layui.form;
            //监听提交
            form.on('submit(login)', function (data) {
                var url = "/admin.php/Manager/check";

                //异步执行请求 $.post
                $.post(url, data.field, function (result) {
                    if (result.status == 0) {
                        return dialog.error(result.message);
                    }
                    if (result.status == 1) {
                        return dialog.success(result.message, '/admin.php');
                    }
                }, 'JSON');
                return false;
            });
        });
    })
</script>
<!-- 底部结束 -->
</body>
</html>