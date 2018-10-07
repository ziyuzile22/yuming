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
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">添加管理员</div>
                    <div class="layui-card-body">
                        <form class="layui-form" action="">
                            <input type="hidden" name="mg_id" value="<?php echo ($info["mg_id"]); ?>">
                            <div class="layui-form-item">
                                <label class="layui-form-label">登录名</label>
                                <div class="layui-input-block">
                                    <input type="text" name="mg_name" required lay-verify="required" placeholder="请输入标题" autocomplete="off" value="<?php echo ($info["mg_name"]); ?>" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">真实姓名</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="mg_tname" value="<?php echo ($info["mg_tname"]); ?>" required lay-verify="required" placeholder="请输入真实姓名" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">密码框</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="mg_pwd" required lay-verify="required" placeholder="请输入密码" autocomplete="off" value="<?php echo ($info["mg_pwd"]); ?>" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">角色</label>
                                <div class="layui-input-inline">
                                    <select name="mg_role_id" lay-verify="required">
                                        <option value=""></option>

                                        <?php if(is_array($roleinfo)): $i = 0; $__LIST__ = $roleinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php if(($vo["role_id"]) == $info['mg_role_id']): ?>selected<?php endif; ?> value="<?php echo ($vo["role_id"]); ?>"><?php echo ($vo["role_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

                                    </select>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">分配项目</label>
                                <div class="layui-input-block">
                                    <?php if(is_array($xminfo)): $i = 0; $__LIST__ = $xminfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$xm): $mod = ($i % 2 );++$i;?><input type="checkbox" <?php if(in_array($xm['xm_id'], $have_xm)): ?>checked<?php endif; ?> name="mg_xm[]" value="<?php echo ($xm["xm_id"]); ?>" title="<?php echo ($xm["xm_name"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="zedit">修改</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </div>
                        </form>
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

        form.on('submit(zedit)', function(data){
            var data = data.field;
            var url = "/admin.php/Manager/zedit";
            $.post(url, data, function(result){
                if(result.status == 0){
                    layer.msg(result.message);
                }

                if(result.status == 1){
                    layer.msg(result.message,{icon:1,time: 800},function(){
                        parent.location.href= "/admin.php/Manager/zlist";
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