<?php
return array(
	//'配置项'=>'配置值'
	'COOKIE_EXPIRE'         =>  0,       // Cookie有效期
    'COOKIE_DOMAIN'         =>  '',      // Cookie有效域名
    'COOKIE_PATH'           =>  '/',     // Cookie路径
    'COOKIE_PREFIX'         =>  'mz_',      // Cookie前缀 避免冲突
    /* SESSION设置 */
    'SESSION_AUTO_START'    =>  true,    // 是否自动开启Session
    'SESSION_OPTIONS'       =>  array('type'=>'','expire'=>7200,'path'=>APP_PATH.'/Index/Session','prefix'=>'mzsjcms_'), // session 配置数组 支持type name id path expire domain 等参数
	'TOKEN_ON' => false,	// 是否开启令牌验证 默认关闭
	'TOKEN_NAME' => '__hash__', // 令牌验证的表单隐藏字段名称，默认为__hash__
	'TOKEN_TYPE' => 'md5', //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET' => true, //令牌验证出错后是否重置令牌 默认为true
	'DEFAULT_THEME' => 'default',
	'TMPL_DETECT_THEME' => false, // 自动侦测模板主题
	'URL_ROUTER_ON' => true,   // 是否开启URL路由
	'URL_CASE_INSENSITIVE' => true,  //url不区分大小写
    'TMPL_ACTION_ERROR'     =>  'Public:error', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  'Public:success', // 默认成功跳转对应的模板文件
    'TMPL_EXCEPTION_FILE'   =>  APP_PATH.'/Index/View/default/Public_exception.html',// 异常页面的模板文件
    'ERROR_PAGE' =>'http://www.mzsj.com/',// 错误定向页面
    'URL_ROUTE_RULES'=>array(
        // 首页
        'index' => 'Index/index',
        // 栏目
        'cate/:catdir' => 'Index/lists',
        // 文章
        'article/:artid' => 'Index/show',
    ),
);