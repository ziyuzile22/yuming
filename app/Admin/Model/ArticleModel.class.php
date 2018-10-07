<?php

namespace Admin\Model;

use Think\Model;

class ArticleModel extends Model
{
    // 接受一个数组，然后处理，返回处理过后的数组
    public function saveArray($arr)
    {

        //取出项目的id和name
        $_xm = M('Xm');
        $xminfo = $_xm->field('xm_id, xm_name')->select();

        //取出用户 mg_id 和昵称 mg_tname
        $_mg = M('Manager');
        $mginfo = $_mg->field('mg_id, mg_tname')->select();

        foreach ($arr as $k => &$v) {
            //判断项目id
            foreach ($xminfo as $kk => $vv) {
                if ($v['art_xmid'] == $vv['xm_id']) {
                    $v['art_xmname'] = $vv['xm_name'];
                }
            }

            //判断用户id
            foreach ($mginfo as $kk => $vv) {
                if ($v['art_userid'] == $vv['mg_id']) {
                    $v['art_tname'] = $vv['mg_tname'];
                }
            }

        }

        return $arr;
    }


}