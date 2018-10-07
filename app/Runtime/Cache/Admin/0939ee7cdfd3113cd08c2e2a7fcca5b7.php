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
                    <div class="layui-card-body">
                        <form class="layui-form" action="">
                            <div class="layui-form-item">
                                <label class="layui-form-label">文章标题</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="art_title" value="<?php echo ($one_info["art_title"]); ?>" required lay-verify="required" placeholder="请输入文章标题" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">文章内容</label>
                                <div class="layui-input-block">
                                    <textarea name="art_content" id="textarea_id" style="padding:10px;"><?php echo ($one_info["art_content"]); ?></textarea>
                                </div>
                            </div>

                            <script src="/Public/kindeditor/kindeditor-all.js"></script>
                            <script src="/Public/kindeditor/lang/zh-CN.js"></script>
                            <script>
                                KindEditor.ready(function (K) {
                                    var options = {
                                        width: '100%',
                                        height: '600px',
                                        urlType: 'domain',
                                        uploadJson: '/admin.php/Article/kindupload',
                                        afterBlur: function () { this.sync(); }

                                    };
                                    window.editor = K.create('#textarea_id', options);

                                });
                            </script>


                            <div class="layui-form-item">
                                <label class="layui-form-label">权重</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="art_weight" value="<?php echo ($one_info["art_weight"]); ?>" placeholder="权重" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">越大越靠前</div>
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
            var url = "/admin.php/Article/zedit/ym_xm/4/art_id/41";
            $.post(url, data, function(result){
                if(result.status == 0){
                    layer.msg(result.message);
                }

                if(result.status == 1){
                    layer.msg(result.message,{icon:1,time: 800},function(){
                        parent.location.href= "/admin.php/Ym/zkind/ym_xm/<?php echo ($ym_xm); ?>";
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