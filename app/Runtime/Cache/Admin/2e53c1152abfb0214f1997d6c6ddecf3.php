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
                    <cite>修改项目</cite>
                </a>
            </div>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md8">
                    <div class="layui-card">
                        <div class="layui-card-header">修改项目</div>
                        <div class="layui-card-body">
                            <form class="layui-form" action="">
                                <input type="hidden" name="xm_id" value="<?php echo ($info["xm_id"]); ?>">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">项目名称</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="xm_name" value="<?php echo ($info["xm_name"]); ?>" required lay-verify="required" placeholder="请输入服务器名称" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">项目主管</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="xm_admin" value="<?php echo ($info["xm_admin"]); ?>" required lay-verify="required" placeholder="请输入项目主管" autocomplete="off" class="layui-input">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">备案地址</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="xm_bei" value="<?php echo ($info["xm_bei"]); ?>" placeholder="请输入备案地址" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">备案账号</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="xm_beiname" value="<?php echo ($info["xm_beiname"]); ?>" placeholder="请输入备案账号" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">备案密码</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="xm_beipwd" value="<?php echo ($info["xm_beipwd"]); ?>" placeholder="请输入备案密码" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">绑定手机号</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="xm_tell" value="<?php echo ($info["xm_tell"]); ?>" placeholder="请输入绑定手机号" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">手机联系人</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="xm_tellname" value="<?php echo ($info["xm_tellname"]); ?>" placeholder="请输入手机联系人" autocomplete="off" class="layui-input">
                                    </div>
                                </div>


                                <div class="layui-form-item">
                                    <label class="layui-form-label">备注</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="xm_bz" value="<?php echo ($info["xm_bz"]); ?>" placeholder="备注" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <div class="layui-input-block">
                                        <button class="layui-btn" lay-submit lay-filter="zadd">立即提交</button>
                                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
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
    layui.use('laydate', function() {
        var laydate = layui.laydate;
        laydate.render({
            elem: '#fwq_dq'
        })
    });
    layui.use('form', function() {
        var form = layui.form;
        form.on('submit(zadd)', function(data) {
            var data = data.field;
            var url = "/admin.php/Xm/zedit/xm_id/22";
            $.post(url, data, function(result) {
                if (result.status == 0) {
                    layer.msg(result.message);
                }
                if (result.status == 1) {
                    layer.msg(result.message, { icon: 1, time: 1000 }, function() {
                        window.location.href = "/admin.php/Xm/zlist";
                    });
                }
            }, 'JSON');
            return false;
        })
    });
    </script>
    <script src="<?php echo PUBLIC_PATH ?>dialog.js?t=<?php echo time(); ?>"></script>
</body>

</html>