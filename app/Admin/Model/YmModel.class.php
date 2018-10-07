<?php
namespace Admin\Model;

use Think\Model;

class YmModel extends Model
{
    //域名添加时全路径制作
    public function addDate($arr)
    {	
		
		
        //1. 利用已有数据生成一条新纪录（获得新纪录的主键id值）
        $newid = $this->add($arr);
		

		

        //2. 利用新纪录制作，全路径
        if ($arr['ym_pid'] == 0) {
            $path = $newid;
        } else {
            $pinfo    = $this->find($arr['ym_pid']);
            $authinfo = $pinfo['ym_quan'];
            $path     = $authinfo . '-' . $newid;
        }

        //制作等级
        //算法：全路径中 “-” 的个数
        $level = substr_count($path, '-');

        $data['ym_quan']  = $path;
        $data['ym_level'] = $level;
		
			
			
        return $this->where("ym_id=$newid")->save($data);
    }

    //域名修改时全路径制作
    public function saveDate($arr)
    {
        if ($arr['ym_pid'] == 0) {
            $path = $arr['ym_id'];
        } else {
            $pinfo    = $this->find($arr['ym_pid']);
            $authinfo = $pinfo['ym_quan'];
            $path     = $authinfo . '-' . $arr['ym_id'];
        }
        //制作等级
        //算法：全路径中 “-” 的个数
        $level = substr_count($path, '-');
        
        $arr['ym_quan'] = $path;
        $arr['ym_level'] = $level;
        return $this->where("ym_id=" . $arr['ym_id'])->save($arr);

    }

}
