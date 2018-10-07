<?php
//后台普通控制器的父类
namespace Tools;

use Think\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        //为了避免覆盖父类的构造方法，先执行父类的构造方法
        parent::__construct();

        $admin_id   = session("admin_id");
        $admin_name = session("admin_name");

        //用户访问权限控制
        //获得当前正在访问的“控制器-方法 nowac”
        //判断 nowac 是否在用户的觉得权限看列表里面存在

        //1.当前请求的控制器-操作方法
        $nowac = CONTROLLER_NAME . "-" . ACTION_NAME;

        //2. 获得当前用户对应角色的权限列表信息
        //   用户---组别---权限
        // 用户信息
        $admin_info = M('Manager')->find($admin_id);

        //有一些操作，要允许在退出的状态也让访问，例如 登录，验证码之类,
        //查询 ek_auth 表，所有 auth_jichu = 2的基础属性都略过。
        $jichuinfo = M('Auth')->field('auth_c,auth_a')->where('auth_jichu=2')->select();
        foreach ($jichuinfo as $k => $v) {
            $s .= implode("-", $v) . ',';
        }
        
        //基础属性，不参与权限限制。=.=
        $rang_ac = rtrim($s, ',');

        //1. 用户不在登录状态，直接返回登录
        //2. 用户的操作还没有在 $rang_ac 出现
        //3. Index/index 是特殊情况，即使公共属性，但是又不允许是没有 session 的时候登入。

        if (empty($admin_id) && empty($admin_name) && strpos($rang_ac, $nowac) === false) {

            //跳转到首页
            $js = "<script>window.location.href='/admin.php/Manager/login'</script>";
            echo $js;
            exit;

        }

        //角色信息
        $role_id   = $admin_info['mg_role_id'];
        $role_info = M('Role')->find($role_id);

        // 拥有的权限信息
        $auth_ac = $role_info['role_auth_ac'];

        //禁止翻墙
        //判断：1.$nowac 是否在 $auth_ac存在, 2. $nowac 是否是 基础属性。3. 给管理员全部权限
        if (strpos($auth_ac, $nowac) === false && strpos($rang_ac, $nowac) === false && $role_id !== '52') {

            if (ACTION_NAME == 'zdel') {
                return show(0, '没有权限执行删除操作！');
            } else {
                // $errorjs = "<script>layer.msg('没有权限执行此操作！', {icon:1})</script>";
                $errorjs = "<script>alert('没有权限执行此操作！');history.go(-1);</script>";
                echo $errorjs;
                exit;
            }

        }

    }
}
