<?php
/*
 ** 公共方法
 */
function show($status, $message, $data = array())
{
    $result = array(
        'status'  => $status,
        'message' => $message,
        'data'    => $data,
    );

    exit(json_encode($result));
}

//根据生日算年龄
function getAge($birthday)
{
    //格式化出生时间年月日
    $byear  = date('Y', $birthday);
    $bmonth = date('m', $birthday);
    $bday   = date('d', $birthday);

    //格式化当前时间年月日
    $tyear  = date('Y');
    $tmonth = date('m');
    $tday   = date('d');

    //开始计算年龄
    $age = $tyear - $byear;
    if ($bmonth > $tmonth || $bmonth == $tmonth && $bday > $tday) {
        $age--;
    }
    return $age;
}

//模板自定义函数，字符串重复多少次。
function repeatFg($number){
    $info = str_repeat('—|—|', $number);
    return $info;
}

//多维度数组检查值是否存在
function deep_in_array($value, $array) {   
    foreach($array as $item) {   
        if(!is_array($item)) {   
            if ($item == $value) {  
                return true;  
            } else {  
                continue;   
            }  
        }   
        if(in_array($value, $item)) {  
            return true;      
        } else if(deep_in_array($value, $item)) {  
            return true;      
        }  
    }   
    return false;   
}

// kindeditor 返回接口
function showKind($status, $data){
	header('Content-type:application/json;charset=utf-8');
	if($status == 0){
		exit(json_encode(array('error'=>0, 'url'=>$data)));
	}
	exit(json_encode(array('error'=>1, 'message'=>'上传失败')));
}

/*
* 把二维数组转换为字符串
*   array(11) {
*    [0] => array(1) {
*        ["xm_id"] => string(1) "4"
*    }
*    [1] => array(1) {
*        ["xm_id"] => string(1) "5"
*    }
*    }
* $arr 2维数组
* $ziduan 2维数组的单个字段
*/
function twoarrToStr($arr, $ziduan){
    $s = '';
    foreach ($arr as $k => $v) {
        $s .= $v[$ziduan].',';
    }
    $s = rtrim($s, ',');
    return $s;
}