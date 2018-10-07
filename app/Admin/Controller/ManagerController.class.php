<?php

namespace Admin\Controller;

use Tools\AdminController;

class ManagerController extends AdminController
{
    public function zlist()
    {

        //角色信息
        $role = M('Role');
        $roleinfo = $role->select();
        $this->assign('roleinfo', $roleinfo);

        $manager = M('Manager');
            
        //根据权限显示用户可以看到的管理员信息
        //如果是超级管理员，可以看到一切信息，如果不是超级管理员，可以看到除管理员之外的信息
        if (session('admin_role_id') != '52') {
            $arr['mg_role_id'] = array('neq', '52');

            //如果不是超级管理员，可以看到自己，和自己的下属。
            //mg_pid = 自己的id session('admin_id')
            $arr['mg_pid'] = array('eq', session('admin_id'));


        }

        $count = $manager->where($arr)->count();
            //查找的数量
        $this->assign('count', $count);
        $page = new \Think\Page($count, 25);
        $show = $page->show();
        $this->assign('page', $show);



        $img_list = $manager->where($arr)->limit($page->firstRow . ',' . $page->listRows)->order('mg_time desc')->select();

        $this->assign('info', $img_list);


        $this->display();

    }

    //删除
    public function zdel()
    {
        $id = I("post.id");
        $manager = M('Manager');
        $result = $manager->delete($id);
        if (!$result) {
            return show(0, '删除失败!');
        } else {
            return show(1, '删除成功!');
        }
    }

    //添加
    public function zadd()
    {

        //全局条件，根据分配的项目来显示数据
        $xmdata['xm_id'] = array('in', I('session.admin_xmid'));

        //项目信息
        $_xm = M('Xm');
        $xminfo = $_xm->where($xmdata)->field('xm_id, xm_name')->select();
        $this->assign('xminfo', $xminfo);

        
        //2个逻辑，1. 展示  2. 收集信息
        if (!empty($_POST)) {
            
            // 收集信息
            $manager = D('Manager');
            $data['mg_name'] = I('post.mg_name');
            $data['mg_pwd'] = I('post.mg_pwd');
            $data['mg_tname'] = I('post.mg_tname');
            $data['mg_xm'] = I('post.mg_xm');
            //如果项目没有分配且当前被分配的用户不是超级管理员，则提示，且中断
            if ($data['mg_xm'] == "" && I('post.mg_role_id') !== '52') {
                return show(0, '项目不能为空！');
                exit;
            }
            //如果是超级管理员，则显示‘all’，其他权限必须选择分配部门
            if ($data['mg_xm'] !== "") {
                $data['mg_xm'] = implode(',', $data['mg_xm']);
                //根据项目id，查询项目中文名
                $xm_ch = $_xm->field('xm_name')->select($data['mg_xm']);
                foreach ($xm_ch as $k => $v) {
                    $str .= $v['xm_name'] . ',';
                }
                $str = rtrim($str, ',');
                $data['mg_xm_ch'] = $str;
            } else if (I('post.mg_role_id') == '52') {
                $data['mg_xm_ch'] = 'all';
            }

            $data['mg_time'] = time();
            $data['mg_last_time'] = time();
            $data['mg_role_id'] = I('post.mg_role_id');

            //如果是超级管理员添加的，则为1级（项目主管），1级可以自己添加自己的下属（2级）
            //在ManagerModel 中处理好再返回数据
            $ret = $manager->addManager($data);

            if (!$ret) {
                return show(0, '添加失败！');
            } else {
                return show(1, '添加成功！');
            }

        } else {

            //角色信息
            $role = M('Role');
            //如果不是超级管理员，无法给其他管理员 超级权限
            if( session('admin_role_id') != '52' ){
                $roledata['role_id'] = array('neq', 52);
            }
            $roleinfo = $role->where($roledata)->select();
            
            $this->assign('roleinfo', $roleinfo);
            $this->display();
        }

    }

    //修改
    public function zedit($mg_id)
    {

        //角色信息
        $role = M('Role');
        $roleinfo = $role->select();
        $this->assign('roleinfo', $roleinfo);

        //项目信息
        $_xm = M('Xm');
        $xminfo = $_xm->field('xm_id, xm_name')->select();
        $this->assign('xminfo', $xminfo);

        $manager = M('Manager');

        if (!empty($_POST)) {

            $data['mg_id'] = $mg_id;
            $data['mg_name'] = I('post.mg_name');
            $data['mg_pwd'] = I('post.mg_pwd');
            $data['mg_tname'] = I('post.mg_tname');

            $data['mg_xm'] = I('post.mg_xm');
            //如果项目没有分配且当前被分配的用户不是超级管理员，则提示，且中断
            if ($data['mg_xm'] == "" && I('post.mg_role_id') !== '52') {
                return show(0, '项目不能为空！');
                exit;
            }
            //如果是超级管理员，则显示‘all’，其他权限必须选择分配部门
            if ($data['mg_xm'] !== "") {
                $data['mg_xm'] = implode(',', $data['mg_xm']);
                //根据项目id，查询项目中文名
                $xm_ch = $_xm->field('xm_name')->select($data['mg_xm']);
                foreach ($xm_ch as $k => $v) {
                    $str .= $v['xm_name'] . ',';
                }
                $str = rtrim($str, ',');
                $data['mg_xm_ch'] = $str;
            } else if (I('post.mg_role_id') == '52') {
                $data['mg_xm_ch'] = 'all';
            }

            $data['mg_last_time'] = time();
            $data['mg_role_id'] = I('post.mg_role_id');

            $ret = $manager->save($data);

            if ($ret !== false) {
                return show(1, '修改成功！');
            } else {
                return show(0, '修改失败！');
            }

        } else {

            $info = $manager->find($mg_id);

            //把 mg_xm 字符串转换为数组，并传给模板
            $have_xm = explode(',', $info['mg_xm']);
            $this->assign('have_xm', $have_xm);

            $this->assign('info', $info);
            $this->display();

        }

    }

    //登录
    public function login()
    {
        $this->display();
    }

    //验证
    public function check()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        //验证用户名不能为空
        if (!trim($username)) {
            return show(0, '用户名不能为空！');
        }
        //验证密码不能为空
        if (!trim($password)) {
            return show(0, '密码不能为空！');
        }

        $userpwd = array(
            'mg_name' => $username,
            'mg_pwd' => $password,
        );

        $ret = M('Manager')->where($userpwd)->find();

        if (!$ret) {
            return show(0, '用户名或密码错误！');
        }

        // session 持久化用户信息 （名字、ID）,页面跳转
        session('admin_name', $ret['mg_name']);
        session('admin_role_id', $ret['mg_role_id']);
        session('admin_id', $ret['mg_id']);

        //如果是超级管理员，则赋予所有项目id
        if ($ret['mg_role_id'] == '52') {
            $info = M('Xm')->field('xm_id')->select();
            foreach ($info as $k => $v) {
                $s .= $v['xm_id'] . ',';
            }
            $mg_xm = rtrim($s, ',');

        } else {
            $mg_xm = $ret['mg_xm'];
        }
        //项目ID赋值到 session 中。
        session('admin_xmid', $mg_xm);

        return show(1, '登录成功');
    }

    //退出系统
    public function logout()
    {
        //清除 session ,跳转到 Manager/login
        session(null);
        $js = "<script>window.top.location.href='/admin.php/Manager/login'</script>";
        echo $js;
        exit;
    }

    //修改个人资料
    public function zself($mg_id)
    {
        $manager = M('Manager');

        if (!empty($_POST)) {
            $data['mg_pwd'] = I('post.mg_pwd');
            $data['mg_last_time'] = time();
            $data['mg_id'] = $mg_id;

            $ret = $manager->save($data);

            if (!$ret) {
                return show(0, '修改失败！');
            } else {
                return show(1, '修改成功！');
            }

        } else {
            $info = $manager->find($mg_id);
            $this->assign('info', $info);
        }

        $this->display();
    }

    //个人信息
    public function zselflist()
    {
        $this->display();
    }

}
