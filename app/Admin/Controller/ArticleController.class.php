<?php
namespace Admin\Controller;

use Tools\AdminController;

class ArticleController extends AdminController
{
    //列表
    public function zlist()
    {
        

        //项目表
        $_xm = M('Xm');
        //根据分配的项目显示
        $xmarr['xm_id'] = array('in', I('session.admin_xmid'));
        $xminfo = $_xm->field('xm_id, xm_name')->where($xmarr)->select();
        //项目赋值给模板
        $this->assign('xminfo', $xminfo);

        //如果有 $_GET['ym_xm'] 参数的话
        if(!empty($_POST['ym_xm'])){
           $this->assign('ym_xm', I('post.ym_xm'));
        }


        $this->display();
    }


    //layui数据表格接口
    public function zlists($ym_xm='')
    {
        //文章列表
        $_art = D('Article');

        //全局条件，根据分配的项目来显示数据
        $arr['art_xmid'] = array('in', I('session.admin_xmid'));


        if( $ym_xm != '' ){
            //指定项目
            $arr['art_xmid'] = $ym_xm;
        }

        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $count = $_art->where($arr)->count();

        $artinfo = $_art->page($page, $limit)->where($arr)->order('art_addtime desc')->select();

        //新建一个Model类，然后加一个方法，例如 saveArray() ,返回值是一个处理过后的数组
        $artinfo = $_art->saveArray($artinfo);

        $arr = array();
        $arr['code'] = 0;
        $arr['msg'] = "";
        $arr['count'] = $count;
        $arr['data'] = $artinfo;
        $arr_json = json_encode($arr);
        echo $arr_json;
    }

    // kindeditor 数据接口
    public function kindupload(){
        $upload = new \Admin\Model\UploadImageModel();

		$res = $upload->upload();
		if($res === false){
			return showKind(1, '上传失败');
		}
		return showKind(0, $res);
    }

    //添加文章
    public function zadd($ym_xm)
    {
        $_art = M('Article');
        $this->assign('ym_xm', $ym_xm);

        //2个逻辑，展示和数据添加
        if (!empty($_POST)) {
            $data['art_id'] = I('post.art_id');
            $data['art_weight'] = I('post.art_weight');
            $data['art_title'] = I('post.art_title');
            $data['art_content'] = I('post.art_content');
            $data['art_userid'] = I('session.admin_id');
            $data['art_xmid'] = $ym_xm;
            $data['art_addtime'] = time();
            $data['art_lasttime'] = time();
            $result = $_art->add($data);
            if (!$result) {
                return show(0, '添加失败！');
            } else {
                return show(1, '添加成功！');
            }
        } else {
            $this->display();
        }

    }

    //修改文章
    public function zedit($ym_xm, $art_id)
    {
        $_art = M('Article');
        $this->assign('ym_xm', $ym_xm);

        if(!empty($_POST)){
            $arr['art_id'] = $art_id;
            $arr['art_weight'] = I('post.art_weight');
            $arr['art_title'] = I('post.art_title');
            $arr['art_content'] = I('post.art_content');
            $arr['art_lasttime'] = time();

            $result = $_art->save($arr);

            if ($result !== false) {
                return show(1, '修改成功！');
            } else {
                return show(0, '修改失败！');
            }


        }else{

            $one_info = $_art->find($art_id);
            $this->assign('one_info', $one_info);


            $this->display();
        }
        
    }

    //删除文章
    public function zdel()
    {
        $id = I('post.id');
        $_art = M('Article');
        $result = $_art->delete($id);
        if (!$result) {
            return show(0, '删除失败！');
        } else {
            return show(1, '删除成功！');
        }
    }


}