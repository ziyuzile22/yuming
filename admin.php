<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// ceshi
// 应用入口文件
//将项目编码设置为 utf-8
header("content-type:text/html;charset=utf-8");
// 检测PHP环境
if (version_compare(PHP_VERSION, '5.3.0', '<')) die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);


// 定义应用目录
define('APP_PATH', './app/');

//公共资源
define('PUBLIC_PATH', '/Public/');

//后台
define('Admin_CSS_URL', '/app/Admin/Public/css/');
define('Admin_IMG_URL', '/app/Admin/Public/img/');
define('Admin_JS_URL', '/app/Admin/Public/js/');

//后台默认模块
define('BIND_MODULE', 'Admin');

//系统名称
define('BIND_SYSNAME', '网络管理 - v3.1');

//网址
define('BIND_WEBSITE', 'http://ym.rzxdnk120.com');

//upload下载地址
define('UPLOAD_PATH', '/Public/upload/');


// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单