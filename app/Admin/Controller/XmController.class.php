<?php
namespace Admin\Controller;

use Tools\AdminController;

class XmController extends AdminController
{
    //列表
    public function zlist()
    {
        $_xm = M('Xm');

        //如果是超级管理员显示所有，如果不是，根据分配的显示
        if( session('admin_role_id') != '52'){
            //全局条件，根据分配的项目来显示数据
            $arr['xm_id'] = array('in', I('session.admin_xmid'));
        }

        //计数
        $count = $_xm->where($arr)->count();
        $this->assign('count', $count);

        //分页
        $page   = new \Think\Page($count, 25);
        $show   = $page->show();
        $this->assign('page', $show);
		
        $xmlist = $_xm->limit($page->firstRow . ',' . $page->listRows)->where($arr)->select();
        $this->assign('info', $xmlist);
        $this->display();
    }

    //添加
    public function zadd()
    {
        //2个逻辑，1展示，2数据添加
        if (!empty($_POST)) {
            $_xm = M('Xm');

            $data['xm_name']     = I('post.xm_name');
            $data['xm_admin']    = I('post.xm_admin');
            $data['xm_bei'] = I('post.xm_bei');
            $data['xm_beiname'] = I('post.xm_beiname');
            $data['xm_beipwd'] = I('post.xm_beipwd');
            $data['xm_tell'] = I('post.xm_tell');
            $data['xm_tellname'] = I('post.xm_tellname');
            $data['xm_addtime']  = time();
            $data['xm_lasttime'] = time();
            $data['xm_bz']       = I('post.xm_bz');

            $result = $_xm->add($data);
            if (!$result) {
                return show(0, '添加失败！');
            } else {
                return show(1, '添加成功！');
            }

        } else {
            $this->display();
        }

    }

    //修改
    public function zedit($xm_id)
    {
        //2个逻辑，1展示，2数据提交
        $_xm = M('Xm');
        if (!empty($_POST)) {

            $data['xm_id']       = $xm_id;
            $data['xm_name']     = I('post.xm_name');
            $data['xm_admin']    = I('post.xm_admin');
            $data['xm_bei'] = I('post.xm_bei');
            $data['xm_beiname'] = I('post.xm_beiname');
            $data['xm_beipwd'] = I('post.xm_beipwd');
            $data['xm_tell'] = I('post.xm_tell');
            $data['xm_tellname'] = I('post.xm_tellname');
            $data['xm_lasttime'] = time();
            $data['xm_bz']       = I('post.xm_bz');

            $result = $_xm->save($data);

            if ($result !== false) {
                return show(1, '修改成功！');
            } else {
                return show(0, '修改失败！');
            }

        } else {
            $info = $_xm->find($xm_id);
            $this->assign('info', $info);
            $this->display();
        }
    }

    //删除
    public function zdel()
    {
        $id     = I('post.id');
        $_xm    = M('Xm');
        $result = $_xm->delete($id);
        if (!$result) {
            return show(0, '删除失败！');
        } else {
            return show(1, '删除成功！');
        }
    }
}
