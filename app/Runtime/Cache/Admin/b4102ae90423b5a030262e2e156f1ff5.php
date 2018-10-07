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
                    <cite>文章列表</cite>
                </a>
            </div>
        </div>
        <div class="layui-fluid">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="zq-header">
                        <div class="layui-form-item layui-form layui-form-pane">
                            <form method="post" action="/admin.php/Article/zlist">

                                <div class="layui-inline">
                                    <label class="layui-form-label">项目</label>
                                    <div class="layui-input-block">
                                        <select name="ym_xm">
                                            <option value="">--请选择--</option>
                                            <?php if(is_array($xminfo)): foreach($xminfo as $key=>$xm): ?><option <?php if(($xm["xm_id"]) == $ym_xm): ?>selected<?php endif; ?>
                                                    value="<?php echo ($xm["xm_id"]); ?>"><?php echo ($xm["xm_name"]); ?>
                                                </option><?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="layui-inline">
                                    <div class="layui-input-block">
                                        <button class="layui-btn layuiadmin-btn-admin" id="zlist-search">
                                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="layui-card-body">
                        <table id="demo" lay-filter="test"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo PUBLIC_PATH; ?>/layui/layui.js?t=<?php echo time(); ?>" charset="utf-8"></script>
    <script>
        //JavaScript代码区域
        layui.use('element', function () {
            var element = layui.element;
        });
        layui.use('form', function () {
            var form = layui.form;
        });

        /*用户-删除*/
        function member_del(obj, id) {
            layer.confirm('确认要删除吗？', function (index) {
                //发异步删除数据
                var url = "/admin.php/Article/zdel";
                $.post(url, { id: id }, function (result) {
                    if (result.status == 0) {
                        dialog.error(result.message);
                    }
                    if (result.status == 1) {
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!', { icon: 1, time: 1000 });
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
            layer.confirm('确认要删除吗？' + data, function (index) {
                //发异步删除数据
                var url = "/admin.php/Article/zdel";
                $.post(url, { id: str }, function (result) {
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
        layui.use('table', function () {
            var table = layui.table;

            //第一个实例
            table.render({
                elem: '#demo'
                , height: 730
                , limit: 20
                , url: '/admin.php/Article/zlists/ym_xm/<?php echo ($ym_xm); ?>' //数据接口
                , page: true //开启分页
                , cols: [[ //表头
                    { field: 'art_id', title: 'ID', width: '5%', sort: true, fixed: 'left' }
                    , { field: 'art_title', title: '标题', width: '55%' }
                    , { field: 'art_tname', title: '发布', width: '10%' }
                    , { field: 'art_xmname', title: '项目', width: '10%', sort: true }
                    , { field: 'art_addtime', title: '发布时间', width: '10%', templet: '<div>{{ layui.laytpl.toDateString(d.createdTime) }}</div>' }
                    , { fixed: 'right', title: '操作', width: '10%', align: 'center', toolbar: '#barDemo' }
                ]]
            });

            //监听工具条
            table.on('tool(test)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data; //获得当前行数据
                
                var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
                var tr = obj.tr; //获得当前行 tr 的DOM对象

                if (layEvent === 'detail') { //查看
                    //do somehing
                    console.log(data.art_id);
                } else if (layEvent === 'del') { //删除
                    layer.confirm('真的删除行么', function (index) {

                        //发送异步数据
                        var url = "/admin.php/Article/zdel";
                        $.post(url, { id: data.art_id }, function (result) {
                            if (result.status == 0) {
                                dialog.error(result.message);
                            }

                            if (result.status == 1) {
                                obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                                layer.close(index);
                                //向服务端发送删除指令
                                layer.msg('已删除!', { icon: 1, time: 800 });
                            }
                        }, 'JSON');


                    });
                } else if (layEvent === 'edit') { //编辑
                    //do something

                    var show_url = '/admin.php/Article/zedit/ym_xm/' + data.art_xmid +'/art_id/' + data.art_id;
                    
                    x_admin_show('修改日志', show_url);
                }
            });
            layui.laytpl.toDateString = function (d, format) {
                var date = new Date(d || new Date())
                    , ymd = [
                        this.digit(date.getFullYear(), 4)
                        , this.digit(date.getMonth() + 1)
                        , this.digit(date.getDate())
                    ]
                    , hms = [
                        this.digit(date.getHours())
                        , this.digit(date.getMinutes())
                        , this.digit(date.getSeconds())
                    ];

                format = format || 'yyyy-MM-dd';

                return format.replace(/yyyy/g, ymd[0])
                    .replace(/MM/g, ymd[1])
                    .replace(/dd/g, ymd[2])
                    .replace(/HH/g, hms[0])
                    .replace(/mm/g, hms[1])
                    .replace(/ss/g, hms[2]);
            };

            //数字前置补零
            layui.laytpl.digit = function (num, length, end) {
                var str = '';
                num = String(num);
                length = length || 2;
                for (var i = num.length; i < length; i++) {
                    str += '0';
                }
                return num < Math.pow(10, length) ? str + (num | 0) : num;
            };
        });


    </script>
    <!-- 工具条 -->
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>




</body>

</html>