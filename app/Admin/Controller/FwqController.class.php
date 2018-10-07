<?php
namespace Admin\Controller;

use Tools\AdminController;

class FwqController extends AdminController
{
    //列表
    public function zlist()
    {
        $_fwq = M('Fwq');

        //计数
        $count = $_fwq->count();
        $this->assign('count', $count);

        //分页
        $page    = new \Think\Page($count, 10);
        $show    = $page->show();
        $fwqlist = $_fwq->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('info', $fwqlist);
        $this->display();
    }

    //添加
    public function zadd()
    {
        //2个逻辑，1展示，2数据添加
        if (!empty($_POST)) {

            $_fwq           = M('Fwq');
            $data           = $_fwq->create();
            $data['fwq_dq'] = strtotime($data['fwq_dq']);
            $result         = $_fwq->add($data);
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
    public function zedit($fwq_id)
    {
        //2个逻辑，1展示，2数据提交
        $_fwq = M('Fwq');
        if (!empty($_POST)) {

            $data           = $_fwq->create();
            $data['fwq_dq'] = strtotime($data['fwq_dq']);
            $result         = $_fwq->save($data);

            if ($result !== false) {
                return show(1, '修改成功！');
            } else {
                return show(0, '修改失败！');
            }

        } else {
            $info = $_fwq->find($fwq_id);
            $this->assign('info', $info);
            $this->display();
        }

    }

    //删除
    public function zdel()
    {
        $id     = I('post.id');
        $_fwq   = M('Fwq');
        $result = $_fwq->delete($id);
        if (!$result) {
            return show(0, '删除失败!');
        } else {
            return show(1, '删除成功!');
        }
    }
}
