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
                    <cite>管理员列表</cite>
                </a>
            </div>
        </div>
        <div class="layui-fluid">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body">
                        <xblock>
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="x_admin_show('添加管理员','<?php echo U('Manager/zadd');?>')"><i class="layui-icon"></i>添加</button>
                            <span style="line-height:40px;float: right;">共有数据：<?php echo ($count); ?> 条</span>
                        </xblock>
                        <table class="layui-table">
                            <colgroup>
                                <col width="40">
                                <col width="60">
                                <col>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>
                                        <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
                                    </th>
                                    <th>ID</th>
                                    <th>登录名</th>
                                    <th>密码</th>
                                    <th>昵称</th>
                                    <th>角色</th>
                                    <th>分配项目</th>
                                    <th>添加时间</th>
                                    <th>最后修改时间</th>
                                    
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                                        <td>
                                            <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='<?php echo ($data["mg_id"]); ?>'><i class="layui-icon">&#xe605;</i></div>
                                        </td>
                                        <td><?php echo ($data["mg_id"]); ?></td>
                                        <td><?php echo ($data["mg_name"]); ?></td>
                                        <td>***</td>
                                        <td><?php echo ($data["mg_tname"]); ?></td>
                                        <td>
                                            <?php if(is_array($roleinfo)): foreach($roleinfo as $key=>$vo): if(($vo["role_id"]) == $data['mg_role_id']): echo ($vo["role_name"]); endif; endforeach; endif; ?>
                                        </td>
                                        <td><?php echo ($data["mg_xm_ch"]); ?></td>
                                        <td><?php echo (date("Y-m-d",$data["mg_time"])); ?></td>
                                        <th><?php echo (date("Y-m-d",$data["mg_last_time"])); ?></th>
                                        <td>
                                            <a class="layui-btn layui-btn-xs" onclick="x_admin_show('修改管理员','/admin.php/Manager/zedit/mg_id/<?php echo ($data["mg_id"]); ?>')">编辑</a>
                                            <a class="layui-btn layui-btn-danger layui-btn-xs" onclick="member_del(this,'<?php echo ($data["mg_id"]); ?>')" href="javascript:;">删除</a>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                
                            </tbody>
                        </table>
                        <p id="findnoresult">没有找到相关项！</p>
                        <div class="page"><?php echo ($page); ?></div>
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

    layui.use('laydate', function() {
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });
        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });
    });


    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认要删除吗？', function(index) {
            //发异步删除数据
            var url = "/admin.php/Manager/zdel";
            $.post(url, { id: id }, function(result) {
                if (result.status == 0) {
                    dialog.error(result.message);
                }
                if (result.status == 1) {
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!', { icon: 1, time: 800 });
                }
            }, 'JSON');

        });
    }

    /*用户-批量删除*/
    function delAll(argument) {
        var data = tableCheck.getData();
        if (data.length == 0) {
            layer.msg('你还为选择任何一项！');
            return false;
        }
        var str = data.join(",");
        layer.confirm('确认要删除吗？' + data, function(index) {
            //发异步删除数据
            var url = "/admin.php/Manager/zdel";

            $.post(url, { id: str }, function(result) {
                if (result.status == 0) {
                    dialog.error(result.message);
                }
                if (result.status == 1) {
                    //捉到所有被选中的，发异步进行删除
                    layer.msg('删除成功', { icon: 1 });
                    $(".layui-form-checked").not('.header').parents('tr').remove();
                }
            }, 'JSON');

        });
    }

    </script>

</body>

</html>