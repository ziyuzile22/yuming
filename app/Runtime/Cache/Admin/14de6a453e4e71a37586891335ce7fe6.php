<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <title></title>
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
</head>

<body>
    <div class="layui-header">
    <ul class="layui-nav layui-left" lay-filter="">
        <li class="layui-nav-item"><a href="/admin.php" target="_parent">回到首页</a></li>
        <li class="layui-nav-item"><a href="javascript:;" onclick="reload();return false;">刷新页面</a></li>
        <!-- hide s 0622 /
        <li class="layui-nav-item"><a href="javascript:;">最新加入</a></li>
        <li class="layui-nav-item">
            <a href="javascript:;">解决方案</a>
            <dl class="layui-nav-child">
                <dd><a href="">移动模块</a></dd>
                <dd><a href="">后台模版</a></dd>
                <dd><a href="">电商平台</a></dd>
            </dl>
        </li>
        / hide e 0622 -->
    </ul>
    <ul class="layui-nav layui-right">
        <li class="layui-nav-item">
            <a href="/admin.php/Manager/zself/mg_id/<?php echo session(admin_id); ?>">修改密码<span class="layui-badge-dot"></span></a>
        </li>
        <li class="layui-nav-item">
            <a href="/admin.php/Manager/logout.html">退出系统</a>
        </li>
        <li class="layui-nav-item">
            <a href=""><?php echo session('admin_name'); ?></a>
            <dl class="layui-nav-child">
                <dd><a href="/admin.php/Manager/zself/mg_id/<?php echo session(admin_id); ?>">修改信息</a></dd>
                <dd><a href="/admin.php/Manager/logout.html">退了</a></dd>
            </dl>
        </li>
    </ul>
</div>
<script>
//刷新页面 
function reload(){
    location.reload();
}
</script>
    <div class="layui-body zq-body">
        <div class="layui-card layadmin-header">
            <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
                <a lay-href="">主页</a><span lay-separator="">/</span>
                <a>
                    <cite>分配权限</cite>
                </a>
            </div>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header"><b style="font-size: 16px;">【 <?php echo ($roleinfo["role_name"]); ?> 】</b> - 分配权限</div>
                        <div class="layui-card-body">

<form class="layui-form" action="">
    <div class="layui-row">
        <div class="layui-col-md12">
            <?php if(is_array($auth_infoA)): $i = 0; $__LIST__ = $auth_infoA;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="layui-form-item">
                    <div class="layui-form-label" style="padding: 0;text-align: left;">
                        <input type="checkbox" name="auth_id[]" <?php if(in_array($vo[auth_id], $have_auth)): ?>checked<?php endif; ?>  value="<?php echo ($vo["auth_id"]); ?>" autocomplete="off" class="layui-input" title="<?php echo ($vo["auth_name"]); ?>">
                    </div>
                    


                    <div class="layui-input-block" style="margin-left: 130px;">
                        <?php if(is_array($auth_infoB)): foreach($auth_infoB as $key=>$bo): if(($bo['auth_pid'] == $vo['auth_id']) and ($bo['auth_jichu'] == 1)): ?><input type="checkbox" name="auth_id[]" <?php if(in_array($bo[auth_id], $have_auth)): ?>checked<?php endif; ?> value="<?php echo ($bo["auth_id"]); ?>" autocomplete="off" class="layui-input" title="<?php echo ($bo["auth_name"]); ?>"><?php endif; endforeach; endif; ?>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="zadd">分配权限</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </div>
</form>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo PUBLIC_PATH; ?>/layui/layui.js?t=<?php echo time(); ?>" charset="utf-8"></script>
    <script>
    //JavaScript代码区域
    layui.use('element', function() {
        var element = layui.element;


    });

    layui.use('form', function() {
        var form = layui.form;

    });


    layui.use('form', function() {
        var form = layui.form;

        form.on('submit(zadd)', function(data) {
            var data = data.field;
            var url = "/admin.php/Role/distribute/role_id/54";
            $.post(url, data, function(result) {
                if (result.status == 0) {
                    layer.msg(result.message);
                }

                if (result.status == 1) {
                    layer.msg(result.message, { icon: 1, time: 2000 }, function() {
                        location.href = "/admin.php/Role/zlist";
                    });

                }
            }, 'JSON');
            return false;
        })

    });
    </script>
</body>

</html>