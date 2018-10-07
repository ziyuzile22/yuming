<?php
namespace Admin\Model;

use Think\Model;

//Role 模型model类
class RoleModel extends Model
{
    //分配权限，收集信息、二期制作、存储信息
    public function saveAuth($role_id, $auth_ids)
    {
    	//1. 数组的 $auth_ids 变为 字符串
    	$authid_str = implode(",", $auth_ids);
    	//2. 根据字符串的auth_ids信息，查询相应的 "控制器-操作方法"
    	$authinfo = M('Auth')->select($authid_str);
    	foreach ($authinfo as $k => $v) {
    		if(!empty($v['auth_c']) && !empty($v['auth_a'])){
    			$s .= $v['auth_c'] . '-' . $v['auth_a'] . ',';
    		}
    	}

    	$s = rtrim($s, ',');
    	
    	$sql = "update zq_role set role_auth_ids='$authid_str', role_auth_ac='$s' where role_id = '$role_id'";
    	return $this->execute($sql);

    }
}
