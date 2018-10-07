<?php
namespace Admin\Controller;

use Tools\AdminController;

class IndexController extends AdminController
{
    public function index()
    {
        //如果 session 不存在，跳转到登录页面
        $admin_id = session("admin_id");
        $admin_name = session("admin_name");
        if (empty($admin_id) && empty($admin_name)) {
            //跳转到首页
            $js = "<script>window.location.href='/admin.php/Manager/login'</script>";
            echo $js;
            exit;
        }

        //通过 session 来确定 $role_id
        $role_id = session('admin_role_id');
        //如果$role_id为52则为超级管理员，跳转到 right方法，其他跳转到 content方法
        //把 $role_id 赋值给模板
        $this->assign('role_id', $role_id);

        $this->display();
    }

    //左侧
    public function left()
    {
        $manager = M("Manager");

        //用户id
        $mg_id = session('admin_id');

        //根据id获得用户信息
        $admin_info = $manager->find($mg_id);

        //角色id
        $role_id = $admin_info['mg_role_id'];

        //获得角色信息
        $role_info = M('Role')->find($role_id);
        //权限的ids信息
        $auth_ids = $role_info['role_auth_ids'];

        //超级管理员给所有权限
        if ($role_id === '52') {
            //如果是超级管理员

            //获得顶级权限
            $auth_infoA = M('Auth')->where("auth_level=0 and auth_show=1")->order('auth_weight')->select();
            //获得次顶级权限
            $auth_infoB = M('Auth')->where("auth_level=1 and auth_show=1")->order('auth_weight')->select();

        } else {
            //如果不是超级管理员

            //获得顶级权限
            $auth_infoA = M('Auth')->where("auth_id in ($auth_ids) and auth_level=0 and auth_show=1")->order('auth_weight')->select();

            //获得次顶级权限
            $auth_infoB = M('Auth')->where("auth_id in ($auth_ids) and auth_level=1 and auth_show=1")->order('auth_weight')->select();
        }

        //把获得的权限信息传递给模板显示
        $this->assign("auth_infoA", $auth_infoA);
        $this->assign("auth_infoB", $auth_infoB);

        $this->display();
    }

    //右侧 - 超级管理员
    public function right()
    {

        //如果是超级管理员，显示所有项目，如果不是，则根据分配的显示项目
        if( session('admin_role_id') == '52' ){
            $xm = M('Xm')->field('xm_id')->select();
            $xm = twoarrToStr($xm, 'xm_id');
            $xm_ch_info = M('Xm')->field('xm_name')->select();
        }else{
            //全局条件，根据分配的项目来显示数据
            $xm = I('session.admin_xmid');
            //可见部门中文名称
            $map['xm_id'] = array('in', $xm);
            $xm_ch_info = M('Xm')->field('xm_name')->where($map)->select();
        }


        //将部门信息的二维数组转为一维数组
        $xm_ch = array_reduce($xm_ch_info, function ($result, $value) {
            return array_merge($result, array_values($value));
        }, array());
        //把部门中文信息赋值给模板
        $this->assign('xm_ch', $xm_ch);

        //如果是超级管理员，显示所有项目，如果不是，则根据分配的显示项目
        if( session('admin_role_id') == '52'){
            $xm_list = M('Xm')->field('xm_id,xm_name')->select();
        }else{
            //全局条件，根据分配的项目来显示数据
            $xm_list = M('Xm')->field('xm_id,xm_name')->where($map)->select();
        }
        
        
        //赋值给模板
        $this->assign('xm_list', $xm_list);

        /*
         **取出各个项目的全部域名数量
         **取出各个项目的一个月内到期的域名数量
         */
        //把项目id字符串转为数组
        $xmid = explode(',', $xm);
        //遍历数组分别取出各自项目的全部域名数量和一个月内到期的域名数量
        //全部域名数量 保存到 $quan_num 字符串 中，一个月内到期的域名数量保存到 $quan_one_num 字符串中

        //今天的日期
        $beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        //1个月内的日期
        $endmonth = mktime(23, 59, 59, date('m') + 2, date('d'), date('Y'));

        foreach ($xmid as $k => $v) {
            $num1 = M('Zhu')->where("zhu_xm = '$v'")->count();
            $quan_num .= $num1 . ',';

            $map['zhu_xm'] = $v;
            $map['zhu_dq'] = array('between', array($beginToday, $endmonth));
            $num2 = M('Zhu')->where($map)->count();
            $quan_one_num .= $num2 . ',';


        }



        //将$quan_num， $quan_one_num 后面的 ‘，’  去掉
        $quan_num = rtrim($quan_num, ',');
        $quan_one_num = rtrim($quan_one_num, ',');

        //将$quan_num, $quan_one_num 转为数组
        $quan_info = explode(',', $quan_num);
        $quan_one_info = explode(',', $quan_one_num);

        //赋值给模板
        $this->assign('quan_info', $quan_info);
        $this->assign('quan_one_info', $quan_one_info);

        $this->display();
    }

    // 右侧 - 普通用户
    public function content()
    {
        //根据 session('admin_id') 来寻找昵称
        $mg_info = M('Manager')->find(session('admin_id'));
        $mg_tname = $mg_info['mg_tname'];
        $this->assign('mg_tname', $mg_tname);

        //表格逻辑
        //全局条件，根据分配的项目来显示数据
        $xm = I('session.admin_xmid');
        //可见部门中文名称
        $map['xm_id'] = array('in', $xm);
        $xm_ch_info = M('Xm')->field('xm_name')->where($map)->select();
        //将部门信息的二维数组转为一维数组
        $xm_ch = array_reduce($xm_ch_info, function ($result, $value) {
            return array_merge($result, array_values($value));
        }, array());
        //把部门中文信息赋值给模板
        $this->assign('xm_ch', $xm_ch);

        //全局条件，根据分配的项目来显示数据
        $xm_list = M('Xm')->field('xm_id,xm_name')->where($map)->select();
        //赋值给模板
        $this->assign('xm_list', $xm_list);


        /*
         **取出各个项目的全部域名数量
         **取出各个项目的一个月内到期的域名数量
         */
        //把项目id字符串转为数组
        $xmid = explode(',', $xm);
        //遍历数组分别取出各自项目的全部域名数量和一个月内到期的域名数量
        //全部域名数量 保存到 $quan_num 字符串 中，一个月内到期的域名数量保存到 $quan_one_num 字符串中

        //今天的日期
        $beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        //1个月内的日期
        $endmonth = mktime(23, 59, 59, date('m') + 2, date('d'), date('Y'));

        foreach ($xmid as $k => $v) {
            $num1 = M('Zhu')->where("zhu_xm = '$v'")->count();
            $quan_num .= $num1 . ',';

            $map['zhu_xm'] = $v;
            $map['zhu_dq'] = array('between', array($beginToday, $endmonth));
            $num2 = M('Zhu')->where($map)->count();
            $quan_one_num .= $num2 . ',';


        }

        //将$quan_num， $quan_one_num 后面的 ‘，’  去掉
        $quan_num = rtrim($quan_num, ',');
        $quan_one_num = rtrim($quan_one_num, ',');

        //将$quan_num, $quan_one_num 转为数组
        $quan_info = explode(',', $quan_num);
        $quan_one_info = explode(',', $quan_one_num);

        //赋值给模板
        $this->assign('quan_info', $quan_info);
        $this->assign('quan_one_info', $quan_one_info);

        $this->display();
    }

}
