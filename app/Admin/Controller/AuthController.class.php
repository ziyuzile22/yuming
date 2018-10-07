<?php

namespace Admin\Controller;

use Tools\AdminController;

class AuthController extends AdminController
{
    public function zlist()
    {
        $_auth = M('Auth');

        //数量查询
        $count = $_auth->count();
        $this->assign("count", $count);

        $page = new \Think\Page($count, 20);
        $show = $page->show();
        $this->assign('page', $show);
        $img_list = $_auth->limit($page->firstRow . ',' . $page->listRows)->order('auth_path')->select();

        $this->assign('info', $img_list);

        $this->display();
    }

    public function zadd()
    {   
        $_auth = D('Auth');

        //两个逻辑：展示、收集
        if (!empty($_POST)) {
            // 全路径（auth_path）和等级字段(auth_level)数组需要二期制作
            $z = $_auth->saveDate($_POST);
            if ($z == false) {
                return show(0, '添加失败!');
            } else {
                return show(1, '添加成功!');
            }

        } else {
            //调用出父级栏目以供添加时候使用。
            
            // 这里只提供1级栏目供选择
            $pidinfo = $_auth->where('auth_level=0')->field('auth_id,auth_name')->order('auth_pid')->select();
            $this->assign('pidinfo', $pidinfo);
            $this->display();
        }

    }

    public function zdel(){
        $id = I("post.id");
        $_auth = M('Auth');
        $ret = $_auth->delete($id);

        if(!$ret){
            return show(0, '删除失败！');
        }else{
            return show(1, '删除成功！');
        }
    }
    
    public function zedit($auth_id){
        $_auth = M('Auth');

        //2个逻辑：1.展示 2.收集信息
        if(!empty($_POST)){

            $data = $_POST;
            $data['auth_id'] = $auth_id;

            $ret = $_auth->save($data);

            if($ret === false){
                return show(0, '修改失败！');
            }else{
                return show(1, '修改成功！');
            }

        }else{
            //根据 auth_id 来查询信息
            $authinfo = $_auth->find($auth_id);
            //赋值给模板
            $this->assign('authinfo', $authinfo);

            //列出1级权限，供模板调用
            $pidinfo = $_auth->where('auth_level=0 and auth_show=1')->select();
            //赋值给模板
            $this->assign('pidinfo', $pidinfo);


            $this->display();
        }

        
    }


}
