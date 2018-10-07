<?php
namespace Admin\Controller;

use Tools\AdminController;

class RoleController extends AdminController
{
    public function zlist()
    {
        $_role    = M('Role');

        //数量查询
        $count = $_role->count();
        $this->assign("count", $count);
        $page = new \Think\Page($count, 13);
        $show = $page->show();
        $this->assign('page', $show);
        $img_list = $_role->limit($page->firstRow . ',' . $page->listRows)->order("role_addtime desc")->select();
        $this->assign('roleinfo', $img_list);
        $this->display();
    }


    //分配权限
    public function distribute($role_id)
    {
        $_role = D('Role');
        //两个逻辑：展示、收集信息
        if (!empty($_POST)) {
            //$_POST 需要二期制作才可以写入数据库
            //在自定义RoleModel里面制作一个方法，实现数据制作和存储
            $z = $_role->saveAuth($role_id, $_POST['auth_id']);
            if ($z !== false) {
                return show(1, '分配权限成功！');
            } else {
                return show(0, '分配权限失败！');
            }
        } else {
            //查询被分配权限的角色信息
            $roleinfo = $_role->find($role_id);
            $this->assign("roleinfo", $roleinfo);
            //角色已经拥有的权限信息，转为数组
            $have_auth = explode(',', $roleinfo['role_auth_ids']);
            $this->assign('have_auth', $have_auth);
            //获得全部用于分配的权限并展示给模板
            $_auth = M("Auth");
            //顶级权限和次顶级权限
            $auth_infoA = M('Auth')->where('auth_level = 0 and auth_jichu=1')->select();
            $auth_infoB = M('Auth')->where('auth_level = 1 and auth_jichu=1')->select();
            //把权限赋值给模板
            $this->assign("auth_infoA", $auth_infoA);
            $this->assign("auth_infoB", $auth_infoB);
            $this->display();
        }
    }


    //添加角色
    public function zadd()
    {
        //2个逻辑：1.展示   2.提交信息
        if (!empty($_POST)) {
            //2. 提交信息
            $data['role_name']     = I('post.role_name');
			$data['role_auth_ac'] = '';
            $data['role_addtime']  = time();
            $data['role_lasttime'] = time();
            $_role                 = M('Role');
            //添加数据
            $ret = $_role->add($data);
            if (!$ret) {
                return show(0, '添加失败！');
            } else {
                return show(1, '添加成功！');
            }
        } else {
            //1. 展示
            $this->display();
        }
    }


    //删除角色
    public function zdel()
    {
        $id    = I('post.id');


        if( strpos($id, '52') !== false ){
            return show(0, '超级管理员无法删除！');
            exit();
        }

        $_role = M('Role');
        $ret   = $_role->delete($id);
        if (!$ret) {
            return show(0, '删除失败！');
        } else {
            return show(1, '删除成功！');
        }
    }

    //修改角色
    public function zedit($role_id){

        $_role = M('Role');


        //两个逻辑 ，1展示，2修改数据
        if(!empty($_POST)){
            //超级管理员不能删除
            if( $role_id == '52' ){
                return show(0, '超级管理员不能被修改！');
            }

            $data['role_id'] = I('post.role_id');
            $data['role_name'] = I('post.role_name');
            $data['role_lasttime'] = time();
            //保存数据
            $ret = $_role->save($data);
            

            if($ret === false){
                return show(0, '修改失败!');
            }else{
                return show(1, '修改成功！');
            }

        }else{
            
            //查找需要修改的角色
            $roleinfo = $_role->find($role_id);
            //赋值给模板
            $this->assign('roleinfo', $roleinfo);
            $this->display();
        }
        
    }


}
