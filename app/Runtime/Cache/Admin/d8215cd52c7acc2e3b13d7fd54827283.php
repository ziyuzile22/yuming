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
    <style>
        .layui-form-item .layui-input-inline{
            width: 50%;
        }
    </style>
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
                    <cite>添加域名</cite>
                </a>
            </div>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md8">
                    <div class="layui-card">
                        <div class="layui-card-header">添加域名</div>
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" action="">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">主域名</label>
                                    <div class="layui-input-block">
                                        <select name="ym_pid">
                                            <option value="0" selected>自身为一级栏目</option>
                                            
                                            <?php if(is_array($yminfo)): $i = 0; $__LIST__ = $yminfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ym): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ym["ym_id"]); ?>"><?php echo ($ym["ym_site"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">域名地址</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="ym_site" id="ym_site" required lay-verify="required" placeholder="域名地址" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux noticeredred" id="ym_site_notice">*域名地址不能为空!</div>
                                </div>
                                
                                <div class="layui-form-item">
                                    <label class="layui-form-label">PC/SJ</label>
                                    <div class="layui-input-block">
                                        <select name="ym_pc" required lay-verify="required">
                                            <option value="1" selected>PC</option>
                                            <option value="2">SJ</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">竞价/优化</label>
                                    <div class="layui-input-block">
                                        <select name="ym_type" required lay-verify="required">
                                            <option value="1" selected>竞价</option>
                                            <option value="2">优化</option>
                                            <option value="3">图片库</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">后台地址</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="ym_hou" placeholder="后台地址" autocomplete="off" class="layui-input">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">用户名</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="ym_admin" placeholder="用户名" autocomplete="off" class="layui-input">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">密码</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="ym_pwd" placeholder="密码" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                
                                <div class="layui-form-item">
                                    <label class="layui-form-label">服务器</label>
                                    <div class="layui-input-block">
                                        <select name="ym_fwq" required lay-verify="required">
                                            <option value="">----请选择----</option>
                                            <?php if(is_array($fwqinfo)): $i = 0; $__LIST__ = $fwqinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fwq): $mod = ($i % 2 );++$i;?><option value="<?php echo ($fwq["fwq_id"]); ?>"><?php echo ($fwq["fwq_site"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">项目</label>
                                    <div class="layui-input-block">
                                        <select name="ym_xm" required lay-verify="required">
                                            <option value="">----请选择----</option>

                                            <?php if(is_array($xminfo)): $i = 0; $__LIST__ = $xminfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$xm): $mod = ($i % 2 );++$i;?><option value="<?php echo ($xm["xm_id"]); ?>"><?php echo ($xm["xm_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">账户</label>
                                    <div class="layui-input-block">
                                        <select name="ym_zhanghu" required lay-verify="required">
                                            <option value="">----请选择----</option>
                                            <?php if(is_array($zhinfo)): $i = 0; $__LIST__ = $zhinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$zh): $mod = ($i % 2 );++$i;?><option value="<?php echo ($zh["zh_id"]); ?>"><?php echo ($zh["zh_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">ftp账户名</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="ym_ftp" placeholder="ftp账户名" autocomplete="off" class="layui-input">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">ftp密码</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="ym_ftppwd" placeholder="ftp密码" autocomplete="off" class="layui-input">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">备注</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="ym_bz" placeholder="备注" autocomplete="off" class="layui-input">
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

    //检查域名的主域名是否存在，不存在则提示添加
    $('#ym_site').blur(function(){
        var url = "/admin.php/Ym/checksite";
        var data = { site: $(this).val() };

        if(data.site == ""){
            $('#ym_site_notice').html('域名不能为空!');
            $('#ym_site_notice').addClass('noticeredred');
            $('#ym_site_notice').removeClass('noticeredgreen');
            return false;
        }
        
        $.post(url, data, function(result){

            if(result.status == 0){
                $('#ym_site_notice').html(result.message);
                $('#ym_site_notice').addClass('noticeredred');
                $('#ym_site_notice').removeClass('noticeredgreen');

                dialog.confirm(result.message, '/admin.php/Zhu/zadd');
            }

            if(result.status == 1){
                $('#ym_site_notice').text(result.message);
                $('#ym_site_notice').addClass('noticeredgreen');
                $('#ym_site_notice').removeClass('noticeredred');
            }

            if(result.status == 2){
                $('#ym_site_notice').text(result.message);
                $('#ym_site_notice').addClass('noticeredred');
                $('#ym_site_notice').removeClass('noticeredgreen');

                dialog.confirm(result.message, '/admin.php/Ym/zlist');
            }

        }, 'JSON');
    });


    layui.use('form', function() {
        var form = layui.form;
        form.on('submit(zadd)', function(data) {
            var data = data.field;
            var url = "/admin.php/Ym/zadd";
            $.post(url, data, function(result) {
                if (result.status == 0) {
                    layer.msg(result.message);
                }
                if (result.status == 1) {
                    layer.msg(result.message, { icon: 1, time: 1000 }, function() {
                        window.location.href = "/admin.php/Ym/zlist";
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