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
                    <cite>域名列表</cite>
                </a>
            </div>
        </div>
        <div class="layui-fluid">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="zq-header">
                        <div class="layui-form-item layui-form layui-form-pane">
                            <form method="post" action="/admin.php/Ym/zlist">
                                <div class="layui-inline">
                                    <label class="layui-form-label">域名</label>
                                    <div class="layui-input-block">
                                        <input type="text" class="layui-input" name="ym_site" value="<?php echo ($ym_site); ?>">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label">项目</label>
                                    <div class="layui-input-block">
                                        <select name="ym_xm">
                                            <option value="">--请选择--</option>
                                            <?php if(is_array($xminfo)): foreach($xminfo as $key=>$xm): ?><option <?php if(($xm["xm_id"]) == $ym_xm): ?>selected<?php endif; ?>
                                                    value="<?php echo ($xm["xm_id"]); ?>"><?php echo ($xm["xm_name"]); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label">竞价/优化</label>
                                    <div class="layui-input-block">
                                        <select name="ym_type">
                                            <option value="">--请选择--</option>
                                            <option <?php if(($ym_type) == "1"): ?>selected<?php endif; ?> value="1">竞价</option>
                                            <option <?php if(($ym_type) == "2"): ?>selected<?php endif; ?> value="2">优化</option>
                                            <option <?php if(($ym_type) == "3"): ?>selected<?php endif; ?> value="3">图片库</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label">PC/SJ</label>
                                    <div class="layui-input-block">
                                        <select name="ym_pc">
                                            <option value="">--请选择--</option>
                                            <option <?php if(($ym_pc) == "1"): ?>selected<?php endif; ?> value="1">PC</option>
                                            <option <?php if(($ym_pc) == "2"): ?>selected<?php endif; ?> value="2">SJ</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="layui-inline">
                                    <label class="layui-form-label">只显示主站</label>
                                    <div class="layui-input-block">
                                        <input type="checkbox" name="ym_showzhu" <?php if(($ym_showzhu) == "on"): ?>checked<?php endif; ?> lay-skin="switch" lay-text="开启|关闭">
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
                        <xblock>
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="window.open('/admin.php/Ym/zadd', 'right')"><i class="layui-icon"></i>添加</button>
                            <span style="line-height:40px;float: right;">共有数据：<?php echo ($count); ?> 条</span>
                        </xblock>
                        <table class="layui-table" lay-even>
                            <thead>
                                <tr>
                                    <th>
                                        <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
                                    </th>
                                    <th>ID</th>
                                    <th>域名地址</th>
                                    <th>PC/SJ</th>
                                    <th>竞价/优化</th>
                                    <th>后台地址</th>
                                    <th>服务器</th>
                                    <th>项目</th>
                                    <th>账户</th>
                                    <th>ftp账号</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody id="tbody" class="zqbody">
                                <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                                        <td>
                                            <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='<?php echo ($data["ym_id"]); ?>'><i class="layui-icon">&#xe605;</i></div>
                                        </td>
                                        <td><?php echo ($i); ?></td>
                                        <td><a href="http://<?php echo ($data["ym_site"]); ?>" target="_blank"><?php echo (repeatFg($data["ym_level"])); ?> <?php echo ($data["ym_site"]); ?></a></td>
                                        <td>
                                            <?php if(($data['ym_pc']) == "1"): ?>PC<?php endif; ?>
                                            <?php if(($data['ym_pc']) == "2"): ?>SJ<?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(($data['ym_type']) == "1"): ?>竞价<?php endif; ?>
                                            <?php if(($data['ym_type']) == "2"): ?>优化<?php endif; ?>
                                            <?php if(($data['ym_type']) == "3"): ?>图片库<?php endif; ?>
                                        </td>
                                        <td><a href="http://<?php echo ($data["ym_site"]); ?>/<?php echo ($data["ym_hou"]); ?>" target="_blank"><?php echo ($data["ym_hou"]); ?></a></td>
                                        <td>
                                            <?php if(is_array($fwqinfo)): foreach($fwqinfo as $key=>$fwq): if(($fwq["fwq_id"]) == $data["ym_fwq"]): echo ($fwq["fwq_name"]); endif; endforeach; endif; ?>
                                        </td>
                                        <td>
                                            <?php if(is_array($xminfo)): foreach($xminfo as $key=>$xm): if(($xm["xm_id"]) == $data["ym_xm"]): echo ($xm["xm_name"]); endif; endforeach; endif; ?>
                                        </td>
                                        <td>
                                            <?php if(is_array($zhinfo)): foreach($zhinfo as $key=>$zh): if(($zh["zh_id"]) == $data["ym_zhanghu"]): echo ($zh["zh_name"]); endif; endforeach; endif; ?>
                                        </td>
                                        <td><?php echo ($data["ym_ftp"]); ?></td>
                                        <td>
                                            
                                            <?php if(($data["ym_pid"]) == "0"): ?><a class="layui-btn layui-btn-xs layui-btn-normal" href="/admin.php/Ym/zaddnew/ym_id/<?php echo ($data["ym_id"]); ?>">添加子集</a><?php endif; ?>
                                            
                                            <a class="layui-btn layui-btn-xs" href="/admin.php/Ym/zedit/ym_id/<?php echo ($data["ym_id"]); ?>">编辑</a>
                                            <a class="layui-btn layui-btn-danger layui-btn-xs" onclick="member_del(this,'<?php echo ($data["ym_id"]); ?>')" href="javascript:;">删除</a>
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

    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认要删除吗？', function(index) {
            //发异步删除数据
            var url = "/admin.php/Ym/zdel";
            $.post(url, { id: id }, function(result) {
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
        layer.confirm('确认要删除吗？' + data, function(index) {
            //发异步删除数据
            var url = "/admin.php/Ym/zdel";
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