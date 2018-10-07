<?php
namespace Admin\Controller;

use Tools\AdminController;

class ZcController extends AdminController
{
    //列表
    public function zlist()
    {
        $_zc = M('Zc');

        //计数
        $count = $_zc->count();
        $this->assign('count', $count);

        //分页
        $page   = new \Think\Page($count, 10);
        $show   = $page->show();
        $zhlist = $_zc->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('info', $zhlist);
        $this->display();
    }

    //添加
    public function zadd()
    {
        //2个逻辑，1展示，2数据添加
        if (!empty($_POST)) {
            $_zc = M('Zc');

            $data['zc_name']     = I('post.zc_name');
            $data['zc_site']     = I('post.zc_site');
            $data['zc_admin']    = I('post.zc_admin');
            $data['zc_pwd']      = I('post.zc_pwd');
            $data['zc_tell']     = I('post.zc_tell');
            $data['zc_tellname'] = I('post.zc_tellname');
            $data['zc_addtime']  = time();
            $data['zc_lasttime'] = time();

            $result = $_zc->add($data);
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
    public function zedit($zc_id)
    {
        //2个逻辑，1展示，2数据提交
        $_zc = M('Zc');
        if (!empty($_POST)) {
            $data['zc_id']       = $zc_id;
            $data['zc_name']     = I('post.zc_name');
            $data['zc_site']     = I('post.zc_site');
            $data['zc_admin']    = I('post.zc_admin');
            $data['zc_pwd']      = I('post.zc_pwd');
            $data['zc_tell']     = I('post.zc_tell');
            $data['zc_tellname'] = I('post.zc_tellname');
            $data['zc_lasttime'] = time();

            $result = $_zc->save($data);

            if ($result !== false) {
                return show(1, '修改成功！');
            } else {
                return show(0, '修改失败！');
            }

        } else {
            $info = $_zc->find($zc_id);
            $this->assign('info', $info);
            $this->display();
        }
    }

    //删除
    public function zdel()
    {
        $id     = I('post.id');
        $_zc    = M('Zc');
        $result = $_zc->delete($id);
        if (!$result) {
            return show(0, '删除失败！');
        } else {
            return show(1, '删除成功！');
        }
    }
}
