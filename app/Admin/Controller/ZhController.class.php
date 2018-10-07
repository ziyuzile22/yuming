<?php
namespace Admin\Controller;

use Tools\AdminController;

class ZhController extends AdminController
{
    //列表
    public function zlist()
    {
        $_zh = M('Zh');

        //计数
        $count = $_zh->count();
        $this->assign('count', $count);

        //分页
        $page   = new \Think\Page($count, 20);
        $show   = $page->show();
		$this->assign('page', $show);
        $zhlist = $_zh->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('info', $zhlist);
        $this->display();
    }

    //添加
    public function zadd()
    {
        
        //2个逻辑，1展示，2数据添加
        if (!empty($_POST)) {
            $_zh = M('Zh');

            $data['zh_name']     = I('post.zh_name');
            $data['zh_bz']       = I('post.zh_bz');
            $data['zh_addtime']  = time();
            $data['zh_lasttime'] = time();

            $result = $_zh->add($data);
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
    public function zedit($zh_id)
    {
        //2个逻辑，1展示，2数据提交
        $_zh = M('Zh');
        if (!empty($_POST)) {

            $data['zh_id']       = $zh_id;
            $data['zh_name']     = I('post.zh_name');
            $data['zh_bz']       = I('post.zh_bz');
            $data['zh_lasttime'] = time();

            $result = $_zh->save($data);

            if ($result !== false) {
                return show(1, '修改成功！');
            } else {
                return show(0, '修改失败！');
            }

        } else {
            $info = $_zh->find($zh_id);
            $this->assign('info', $info);
            $this->display();
        }
    }

    //删除
    public function zdel()
    {
        $id     = I('post.id');
        $_zh    = M('Zh');
        $result = $_zh->delete($id);
        if (!$result) {
            return show(0, '删除失败！');
        } else {
            return show(1, '删除成功！');
        }
    }
}
