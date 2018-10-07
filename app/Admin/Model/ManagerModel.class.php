<?php
namespace Admin\Model;

use Think\Model;

class ManagerModel extends Model{

    public function addManager($newarr){
        // $mg_id 为新生成的主键id
        $mg_id = $this->add($newarr);

        //如果是超级管理员添加的，则为1级（项目主管），1级可以自己添加自己的下属（2级）
        //管理员通过 session('admin_role_id') = 52 来判断
        if( session('admin_role_id') == '52' ){
            $arr['mg_pid'] = 0;
            $arr['mg_path'] = $mg_id;
            $arr['mg_level'] = 0;
        }else{
            //如果不是超级管理员，则寻找他的父级的全路径，进行拼接 
            //如果不是超级管理员，找到 登录的id session('admin_id'),目前只考虑2级，所以全路径就是 session('admin_id')-$mg_id
            $arr['mg_pid'] = session('admin_id');
            $arr['mg_path'] = session('admin_id') . '-' . $mg_id;
            $arr['mg_level'] = 1;
        }

        //将空的3项 加到 新生成的数据中。
        $arr['mg_id'] = $mg_id;
        $ret = $this->save($arr);
        return $ret;

    }

}