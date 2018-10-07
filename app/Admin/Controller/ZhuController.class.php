<?php

namespace Admin\Controller;

use Tools\AdminController;

class ZhuController extends AdminController
{
    //列表
    public function zlist()
    {
        $_zhu = M('Zhu');

        //全局条件，根据分配的项目来显示数据
        $arr['zhu_xm'] = array('in', I('session.admin_xmid'));

        //项目
        $_xm = M('Xm');
        $xmarr['xm_id'] = array('in', I('session.admin_xmid'));
        $xminfo = $_xm->field('xm_id, xm_name')->where($xmarr)->select();
        $this->assign('xminfo', $xminfo);


        //域名注册商
        $_zc = M('Zc');
        $zcinfo = $_zc->field('zc_id, zc_name, zc_site')->select();
        $this->assign('zcinfo', $zcinfo);

        if (!empty($_POST)) {

            if (!empty($_POST['zhu_xm'])) {
                $arr['zhu_xm'] = I("post.zhu_xm");
                $this->assign('zhu_xm', $arr['zhu_xm']);
            }

            if (!empty($_POST['zhu_beian'])) {
                $arr['zhu_beian'] = I("post.zhu_beian");
                $this->assign('zhu_beian', $arr['zhu_beian']);
            }

            if (!empty($_POST['zhu_dqtime'])) {
                $arr['zhu_dqtime'] = I("post.zhu_dqtime");

                //今天日期
                $beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                switch ($arr['zhu_dqtime']) {
                    case '1':
                        $endmonth = mktime(23, 59, 59, date('m') + 1, date('d'), date('Y'));
                        break;
                    case '2':
                        $endmonth = mktime(23, 59, 59, date('m') + 2, date('d'), date('Y'));
                        break;
                    case '3':
                        $endmonth = mktime(23, 59, 59, date('m') + 3, date('d'), date('Y'));
                        break;
                    default:
                        # code...
                        break;
                }

                $arr['zhu_dq'] = array('between', array($beginToday, $endmonth));

                $this->assign('zhu_dqtime', $arr['zhu_dqtime']);
            }

            //搜索地址
            if (!empty($_POST['zhu_site'])) {
                $arr['zhu_site'] = I('post.zhu_site');
                $this->assign('zhu_site', $arr['zhu_site']);
            }

        }

        //计数
        $count = $_zhu->where($arr)->count();
        $this->assign('count', $count);

        //分页
        $page = new \Think\Page($count, 20);
        $show = $page->show();
        $this->assign('page', $show);
        $zhlist = $_zhu->where($arr)->limit($page->firstRow . ',' . $page->listRows)->order('zhu_beian desc,zhu_lasttime desc')->select();
        $this->assign('info', $zhlist);

        $this->display();
    }

    //添加
    public function zadd()
    {

        //2个逻辑，1展示，2数据添加
        if (!empty($_POST)) {

            $_zhu = M('Zhu');
            $data['zhu_site'] = I('post.zhu_site');
            $data['zhu_zc'] = I('post.zhu_zc');
            $data['zhu_xm'] = I('post.zhu_xm');
            $data['zhu_beian'] = I('post.zhu_beian');
            $data['zhu_dq'] = strtotime(I('post.zhu_dq'));
            $data['zhu_addtime'] = time();
            $data['zhu_lasttime'] = time();

            $result = $_zhu->add($data);

            if (!$result) {
                return show(0, '添加失败！');
            } else {
                return show(1, '添加成功！');
            }

        } else {

            //域名注册商
            $_zc = M('Zc');
            $zcinfo = $_zc->field('zc_id, zc_name')->select();
            $this->assign('zcinfo', $zcinfo);

            //项目
            $_xm = M('Xm');
            $xminfo = $_xm->field('xm_id, xm_name')->select();
            $this->assign('xminfo', $xminfo);

            $this->display();
        }
    }

    //修改
    public function zedit($zhu_id)
    {
        //2个逻辑，1展示，2数据提交
        $_zhu = M('Zhu');
        if (!empty($_POST)) {

            $data['zhu_id'] = $zhu_id;
            $data['zhu_site'] = I('post.zhu_site');
            $data['zhu_zc'] = I('post.zhu_zc');
            $data['zhu_xm'] = I('post.zhu_xm');
            $data['zhu_beian'] = I('post.zhu_beian');
            $data['zhu_dq'] = strtotime(I('post.zhu_dq'));
            $data['zhu_lasttime'] = time();

            $result = $_zhu->save($data);

            if ($result !== false) {
                return show(1, '修改成功！');
            } else {
                return show(0, '修改失败！');
            }

        } else {

            //域名注册商
            $_zc = M('Zc');
            $zcinfo = $_zc->field('zc_id, zc_name')->select();
            $this->assign('zcinfo', $zcinfo);

            //项目
            $_xm = M('Xm');
            $xminfo = $_xm->field('xm_id, xm_name')->select();
            $this->assign('xminfo', $xminfo);

            $info = $_zhu->find($zhu_id);
            $this->assign('info', $info);
            $this->display();
        }
    }

    //删除
    public function zdel()
    {
        $id = I('post.id');
        $_zhu = M('Zhu');
        $result = $_zhu->delete($id);
        if (!$result) {
            return show(0, '删除失败！');
        } else {
            return show(1, '删除成功！');
        }
    }

}
