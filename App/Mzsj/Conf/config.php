<?php
return array(
	//'配置项'=>'配置值'
	 /* SESSION设置 */
    'SESSION_AUTO_START'    =>  true,    // 是否自动开启Session
    'SESSION_OPTIONS'       =>  array('type'=>'Db','expire'=>7200,'path'=>'mzsj_session','prefix'=>'mzsj_'), // session 配置数组 支持type name id path expire domain 等参数
	'URL_ROUTE_RULES'       =>  array(), // 默认路由规则 针对模块
    'URL_MAP_RULES'         =>  array(), // URL映射定义规则
    'TMPL_ACTION_ERROR'     =>  MODULE_PATH.'View/jump.html', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  MODULE_PATH.'View/jump.html', // 默认成功跳转对应的模板文件
    // 打开trace
    // 'SHOW_PAGE_TRACE' =>true,
);