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
                    <cite>后台首页</cite>
                </a>
            </div>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body">
                            <blockquote class="layui-elem-quote">
                                <?php echo BIND_SYSNAME; ?> 提供核心功能模块,后续功能根据 630工作室 需求再次开发。
                            </blockquote>
                            <?php if(is_array($xm_list)): $i = 0; $__LIST__ = $xm_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$xm): $mod = ($i % 2 );++$i;?><a href="/admin.php/Ym/zkind/ym_xm/<?php echo ($xm["xm_id"]); ?>" class="layui-btn layui-btn-lg zqbgc0<?php echo ($i); ?>"><?php echo ($xm["xm_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">域名表格</div>
                        <div class="layui-card-body">
                            <div class="layuiadmin-card-text">
                                <div id="main" style="width: 100%;height: 600px;">
                                </div>
								<script src="<?php echo Admin_JS_URL; ?>echarts.js?t=<?php echo time(); ?>" charset="utf-8"></script>
                                <script>
                                    var app = echarts.init(document.getElementById('main'));

                                    var posList = [
                                        'left', 'right', 'top', 'bottom',
                                        'inside',
                                        'insideTop', 'insideLeft', 'insideRight', 'insideBottom',
                                        'insideTopLeft', 'insideTopRight', 'insideBottomLeft', 'insideBottomRight'
                                    ];

                                    app.configParameters = {
                                        rotate: {
                                            min: -90,
                                            max: 90
                                        },
                                        align: {
                                            options: {
                                                left: 'left',
                                                center: 'center',
                                                right: 'right'
                                            }
                                        },
                                        verticalAlign: {
                                            options: {
                                                top: 'top',
                                                middle: 'middle',
                                                bottom: 'bottom'
                                            }
                                        },
                                        position: {
                                            options: echarts.util.reduce(posList, function (map, pos) {
                                                map[pos] = pos;
                                                return map;
                                            }, {})
                                        },
                                        distance: {
                                            min: 0,
                                            max: 100
                                        }
                                    };

                                    app.config = {
                                        rotate: 90,
                                        align: 'left',
                                        verticalAlign: 'middle',
                                        position: 'insideBottom',
                                        distance: 15,
                                        onChange: function () {
                                            var labelOption = {
                                                normal: {
                                                    rotate: app.config.rotate,
                                                    align: app.config.align,
                                                    verticalAlign: app.config.verticalAlign,
                                                    position: app.config.position,
                                                    distance: app.config.distance
                                                }
                                            };
                                            myChart.setOption({
                                                series: [{
                                                    label: labelOption
                                                }, {
                                                    label: labelOption
                                                }]
                                            });
                                        }
                                    };
                                    var labelOption = {
                                        normal: {
                                            show: true,
                                            position: app.config.position,
                                            distance: app.config.distance,
                                            align: app.config.align,
                                            verticalAlign: app.config.verticalAlign,
                                            rotate: app.config.rotate,
                                            formatter: '{c}  {name|{a}}',
                                            fontSize: 16,
                                            rich: {
                                                name: {
                                                    textBorderColor: '#fff'
                                                }
                                            }
                                        }
                                    };
                                    // 指定图表的配置项和数据
                                    option = {
                                        color: ['#4cabce', '#e5323e'],
                                        tooltip: {
                                            trigger: 'axis',
                                            axisPointer: {
                                                type: 'shadow'
                                            }
                                        },

                                        calculable: true,
                                        xAxis: [{
                                            type: 'category',
                                            axisTick: { show: false },
                                            data: <?php echo json_encode($xm_ch); ?>
                                    }],
                                    yAxis: [{
                                        type: 'value'
                                    }],
                                        series: [{
                                            name: '全部',
                                            type: 'bar',
                                            barGap: 0,
                                            label: labelOption,
                                            data: <?php echo json_encode($quan_info); ?>
                                        },
                                        {
                                            name: '2月内到期',
                                            type: 'bar',
                                            label: labelOption,
                                            data: <?php echo json_encode($quan_one_info); ?>
                                        }

                                        ]
                                };

                                    // 使用刚指定的配置项和数据显示图表。
                                    app.setOption(option);
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo PUBLIC_PATH; ?>layui/layui.js?t=<?php echo time(); ?>" charset="utf-8"></script>
    <script>
        //JavaScript代码区域
        layui.use('element', function () {
            var element = layui.element;
        });

        layui.use('form', function () {
            var form = layui.form;
        });
    </script>
    <script src="<?php echo PUBLIC_PATH ?>dialog.js?t=<?php echo time(); ?>"></script>
</body>

</html>