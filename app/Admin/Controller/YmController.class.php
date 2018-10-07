<?php
namespace Admin\Controller;

use Tools\AdminController;

class YmController extends AdminController
{
    //列表
    public function zlist()
    {
        $_ym = M('Ym');

        //全局条件，根据分配的项目来显示数据
        $arr['ym_xm'] = array('in', I('session.admin_xmid'));

        //服务器表
        $_fwq    = M('Fwq');
        $fwqinfo = $_fwq->field('fwq_id,fwq_name,fwq_mb')->select();
        //服务器赋值给模板
        $this->assign('fwqinfo', $fwqinfo);

        //项目表
        $_xm = M('Xm');
        //根据分配的项目显示
        $xmarr['xm_id'] = array('in', I('session.admin_xmid'));
        $xminfo         = $_xm->field('xm_id, xm_name')->where($xmarr)->select();
        //项目赋值给模板
        $this->assign('xminfo', $xminfo);

        //账户(百度、搜狗)
        $_zh    = M('Zh');
        $zhinfo = $_zh->field('zh_id,zh_name')->select();
        //域名赋值给模板
        $this->assign('zhinfo', $zhinfo);

        //默认只显示主域名
        $arr['ym_pid'] = array('eq', 0);
        $this->assign('ym_showzhu', 'on');

        if (!empty($_POST)) {

            //查询域名地址
            if (!empty($_POST['ym_site'])) {
                $site   = I('post.ym_site');
                $siteid = $_ym->field('ym_id, ym_pid')->where(" ym_site='$site' ")->find();

                if ($siteid['ym_pid'] !== '0') {
                    //父节点的id = $pid
                    $pid = $siteid['ym_pid'];
                } else {
                    $pid = $siteid['ym_id'];
                }

                //找到父节点和父节点下面的所有网站
                $pidinfo = $_ym->field('ym_id')->where("ym_pid = '$pid'")->select();
                //拼接字符串
                foreach ($pidinfo as $k => $v) {
                    $s .= $v['ym_id'] . ',';
                }
                $s .= $pid;
                $arr['ym_id'] = array('in', $s);

                $this->assign('ym_site', $site);
            }

            // PC/SJ
            if (!empty($_POST['ym_pc'])) {
                $arr['ym_pc'] = I('post.ym_pc');
                $this->assign('ym_pc', $arr['ym_pc']);
            }

            //查询竞价/优化/图片库
            if (!empty($_POST['ym_type'])) {
                $type = I('post.ym_type');
                switch ($type) {
                    case '1':
                        $arr['ym_type'] = '1';
                        break;
                    case '2':
                        $arr['ym_type'] = '2';
                        break;
                    case '3':
                        $arr['ym_type'] = '3';
                        break;
                    default:
                        # code...
                        break;
                }
                $this->assign('ym_type', $type);
            }

            if (!empty($_POST['ym_xm'])) {
                $arr['ym_xm'] = I('post.ym_xm');
                $this->assign('ym_xm', $arr['ym_xm']);
            }

            if ($_POST['ym_showzhu'] == "on") {
                $arr['ym_pid'] = array('EQ', 0);
                $this->assign('ym_showzhu', 'on');
            } else {
                $arr['ym_pid'] = array('EGT', 0);
                $this->assign('ym_showzhu', '');
            }

        }

        //计数
        $count = $_ym->where($arr)->count();
        $this->assign('count', $count);

        //分页
        $page = new \Think\Page($count, 100);
        $show = $page->show();
        $this->assign('page', $show);
        $zhlist = $_ym->where($arr)->limit($page->firstRow . ',' . $page->listRows)->order('ym_quan')->select();

        $this->assign('info', $zhlist);
        $this->display();
    }

    //添加
    public function zadd()
    {
        $_ym = D('Ym');
        //2个逻辑，1展示，2数据添加
        if (!empty($_POST)) {
			
			
			
			
            $data['ym_pid']      = I('post.ym_pid');
            $data['ym_site']     = I('post.ym_site');
            $data['ym_pc']       = I('post.ym_pc');
            $data['ym_type']     = I('post.ym_type');
            $data['ym_hou']      = I('post.ym_hou');
            $data['ym_admin']    = I('post.ym_admin');
            $data['ym_pwd']      = I('post.ym_pwd');
            $data['ym_fwq']      = I('post.ym_fwq');
            $data['ym_xm']       = I('post.ym_xm');
            $data['ym_zhanghu']  = I('post.ym_zhanghu');
            $data['ym_ftp']      = I('post.ym_ftp');
            $data['ym_ftppwd']   = I('post.ym_ftppwd');
            $data['ym_bz']       = I('post.ym_bz');
            $data['ym_addtime']  = time();
            $data['ym_lasttime'] = time();

            $result = $_ym->addDate($data);
			
            if (!$result) {
                return show(0, '添加失败！');
            } else {
                return show(1, '添加成功！');
            }

        } else {
            //主域名筛选出来
            $yminfo = $_ym->field('ym_id, ym_site')->where('ym_pid=0')->order('ym_addtime desc')->select();
            //主域名赋值给模板
            $this->assign('yminfo', $yminfo);

            //服务器表
            $_fwq    = M('Fwq');
            $fwqinfo = $_fwq->field('fwq_id,fwq_site')->select();
            //服务器赋值给模板
            $this->assign('fwqinfo', $fwqinfo);

            //项目表
            $_xm    = M('Xm');
            $xminfo = $_xm->field('xm_id, xm_name')->select();
            //项目赋值给模板
            $this->assign('xminfo', $xminfo);

            //账户(百度、搜狗)
            $_zh    = M('Zh');
            $zhinfo = $_zh->field('zh_id,zh_name')->select();
            //域名赋值给模板
            $this->assign('zhinfo', $zhinfo);

            $this->display();
        }
    }

    //修改
    public function zedit($ym_id)
    {
        //2个逻辑，1展示，2数据提交
        $_ym = D('Ym');
        if (!empty($_POST)) {

            $data['ym_id']       = $ym_id;
            $data['ym_pid']      = I('post.ym_pid');
            $data['ym_site']     = I('post.ym_site');
            $data['ym_pc']       = I('post.ym_pc');
            $data['ym_type']     = I('post.ym_type');
            $data['ym_hou']      = I('post.ym_hou');
            $data['ym_admin']    = I('post.ym_admin');
            $data['ym_pwd']      = I('post.ym_pwd');
            $data['ym_fwq']      = I('post.ym_fwq');
            $data['ym_xm']       = I('post.ym_xm');
            $data['ym_zhanghu']  = I('post.ym_zhanghu');
            $data['ym_ftp']      = I('post.ym_ftp');
            $data['ym_ftppwd']   = I('post.ym_ftppwd');
            $data['ym_bz']       = I('post.ym_bz');
            $data['ym_lasttime'] = time();

            $result = $_ym->saveDate($data);

            if ($result !== false) {
                return show(1, '修改成功！');
            } else {
                return show(0, '修改失败！');
            }

        } else {
            //主域名筛选出来
            $yminfo = $_ym->field('ym_id, ym_site')->where('ym_pid=0')->select();
            //主域名赋值给模板
            $this->assign('yminfo', $yminfo);

            //服务器表
            $_fwq    = M('Fwq');
            $fwqinfo = $_fwq->field('fwq_id,fwq_site')->select();
            //服务器赋值给模板
            $this->assign('fwqinfo', $fwqinfo);

            //项目表
            $_xm    = M('Xm');
            $xminfo = $_xm->field('xm_id, xm_name')->select();
            //项目赋值给模板
            $this->assign('xminfo', $xminfo);

            //账户
            $_zh    = M('Zh');
            $zhinfo = $_zh->field('zh_id,zh_name')->select();
            //账户赋值给模板
            $this->assign('zhinfo', $zhinfo);

            $info = $_ym->find($ym_id);
            $this->assign('info', $info);
            $this->display();
        }
    }

    //删除
    public function zdel()
    {
        $id     = I('post.id');
        $_ym    = M('Ym');
        $result = $_ym->delete($id);
        if (!$result) {
            return show(0, '删除失败！');
        } else {
            return show(1, '删除成功！');
        }
    }

    //检查添加的域名，它的主域名是否已经在主域名表中。如不在提示添加。
    public function checksite()
    {
        $site = I('post.site');
        //检查域名是否存在
        $_ym    = M('Ym');
        $yminfo = $_ym->field('ym_site')->select();
        $ret    = deep_in_array($site, $yminfo);
        if ($ret) {
            return show(2, '该域名已经存在！请勿重复添加！');
        }

        //获得主域名，查看 . 的个数，如果是就1个本身就是主域名，如果是2个，表示是2级域名
        $diannum = substr_count($site, '.');
        if ($diannum == 1) {
            $newsite = $site;
        } else if ($diannum == 2) {
            $newsite = substr($site, strpos($site, '.') + 1);
        } else {
            return show(0, '域名添加错误！');
            exit;
        }

        //查询主域名表
        $_zhu    = M('Zhu');
        $zhuinfo = $_zhu->field('zhu_site')->select();

        $result = deep_in_array($newsite, $zhuinfo);
        if ($result) {
            return show(1, '域名可以添加');
        } else {
            return show(0, '主域名不存在！请先添加主域名');
        }
    }

    //添加子域名
    public function zaddnew($ym_id)
    {

        if (!empty($_POST)) {

            $arr['ym_pid']  = $ym_id;
            $arr['ym_site'] = I('post.ym_site');
            $arr['ym_bz']   = I('post.ym_bz');

            //查询父级的 PC/SJ 竞价/优化 服务器 项目 账户 这几个属性并赋值给子集

            $_ym                = D('Ym');
            $info               = $_ym->find($ym_id);
            $arr['ym_pc']       = $info['ym_pc'];
            $arr['ym_type']     = $info['ym_type'];
            $arr['ym_fwq']      = $info['ym_fwq'];
            $arr['ym_xm']       = $info['ym_xm'];
            $arr['ym_zhanghu']  = $info['ym_zhanghu'];
            $arr['ym_addtime']  = time();
            $arr['ym_lasttime'] = time();

            $result = $_ym->addDate($arr);

            if (!$result) {
                return show(0, '添加失败！');
            } else {
                return show(1, '添加成功！');
            }

        } else {
            $this->display();
        }

    }

    //分类显示单个项目下域名
    public function zkind($ym_xm){
        
        $_ym = M('Ym');

        //全局条件，根据分配的项目来显示数据
        $arr['ym_xm'] = array('eq', $ym_xm);
        $this->assign('ym_xm', $ym_xm);

        //默认显示 竞价站、手机站
        $arr['ym_pc'] = 2;
        $this->assign('ym_pc', $arr['ym_pc']);
        $arr['ym_type'] = '1';
        $this->assign('ym_type', $arr['ym_type']);


        //服务器表
        $_fwq    = M('Fwq');
        $fwqinfo = $_fwq->field('fwq_id,fwq_name,fwq_mb')->select();
        //服务器赋值给模板
        $this->assign('fwqinfo', $fwqinfo);

        //项目表
        $_xm = M('Xm');
        //根据分配的项目显示
        $xmarr['xm_id'] = array('in', I('session.admin_xmid'));
        $xminfo         = $_xm->field('xm_id, xm_name')->where($xmarr)->select();

        //项目赋值给模板
        $this->assign('xminfo', $xminfo);

        //账户(百度、搜狗)
        $_zh    = M('Zh');
        $zhinfo = $_zh->field('zh_id,zh_name')->select();
        //域名赋值给模板
        $this->assign('zhinfo', $zhinfo);

        //默认只显示主域名
        $arr['ym_pid'] = array('eq', 0);
        $this->assign('ym_showzhu', 'on');

        if (!empty($_POST)) {

            //查询域名地址
            if (!empty($_POST['ym_site'])) {
                $site   = I('post.ym_site');
                $siteid = $_ym->field('ym_id, ym_pid')->where(" ym_site='$site' ")->find();

                if ($siteid['ym_pid'] !== '0') {
                    //父节点的id = $pid
                    $pid = $siteid['ym_pid'];
                } else {
                    $pid = $siteid['ym_id'];
                }

                //找到父节点和父节点下面的所有网站
                $pidinfo = $_ym->field('ym_id')->where("ym_pid = '$pid'")->select();
                //拼接字符串
                foreach ($pidinfo as $k => $v) {
                    $s .= $v['ym_id'] . ',';
                }
                $s .= $pid;
                $arr['ym_id'] = array('in', $s);

                $this->assign('ym_site', $site);
            }

            // PC/SJ
            if (!empty($_POST['ym_pc'])) {
                $arr['ym_pc'] = I('post.ym_pc');
                $this->assign('ym_pc', $arr['ym_pc']);
            }

            //查询竞价/优化/图片库
            if (!empty($_POST['ym_type'])) {
                $type = I('post.ym_type');
                switch ($type) {
                    case '1':
                        $arr['ym_type'] = '1';
                        break;
                    case '2':
                        $arr['ym_type'] = '2';
                        break;
                    case '3':
                        $arr['ym_type'] = '3';
                        break;
                    default:
                        # code...
                        break;
                }
                $this->assign('ym_type', $type);
            }
    
            if ($_POST['ym_showzhu'] == "on") {
                $arr['ym_pid'] = array('EQ', 0);
                $this->assign('ym_showzhu', 'on');
            } else {
                $arr['ym_pid'] = array('EGT', 0);
                $this->assign('ym_showzhu', '');
            }

        }

        //计数
        $count = $_ym->where($arr)->count();
        $this->assign('count', $count);

        //分页
        $page = new \Think\Page($count, 100);
        $show = $page->show();
        $this->assign('page', $show);
        $zhlist = $_ym->where($arr)->limit($page->firstRow . ',' . $page->listRows)->order('ym_quan')->select();

        $this->assign('info', $zhlist);

        //当前的项目
        $xm_name = M('Xm')->field('xm_name')->find($ym_xm);
        $this->assign('xm_name', $xm_name['xm_name']);

        //文章列表时间线展示
        $_art = M('Article');
        $arr_art['art_xmid'] = $ym_xm;
        //权重越大越靠前
        $art_info = $_art->order('art_weight desc')->where($arr_art)->limit(8)->select();
        //内容转移
        foreach ($art_info as $k => &$v) {
            $v['art_content'] = htmlspecialchars_decode(html_entity_decode($v['art_content']));
        }

        $this->assign('art_info', $art_info);
        

        $this->display();


        

    }
    


}
