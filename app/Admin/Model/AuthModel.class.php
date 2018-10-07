<?php
namespace Admin\Model;

use Think\Model;

class AuthModel extends Model
{
    // 权限管理
    // 全路径（auth_path）和等级字段(auth_level)数组需要二期制作
    public function saveDate($four)
    {
        // 1. 利用已有数据生成一条新纪录（获得新记录主键id值）
        $newid = $this->add($four); //数组方法添加数据
        
        // 2. 利用新记录信息制作 全路径和等级
        // ----制作全路径
        if ($four['auth_pid'] == 0) {
            // ---- 1. 顶级权限
            $path = $newid;
        } else {
            // ---- 2. 非顶级权限
            // ----     获得对应父级权限的信息（父级全路径）
            $pinfo    = $this->find($four['auth_pid']);
            $authinfo = $pinfo['auth_path'];	//父级全路径
            $path     = $authinfo . '-' . $newid;
        }


        // ----制作等级
        // 算法：全路径中 “-” 的个数。
        $level = substr_count($path, '-');
        //把缺少的两个字段（全路径、等级）通过 save更新进来。

        $data['auth_path'] = $path;
        $data['auth_level'] = $level;
        return $this->where("auth_id= $newid")->save($data);
    }
}
