<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">

<head>
	<meta charset="utf-8" />
	<title><?php echo ($title); ?>-木子设计后台管理程序</title>
	<meta name="author" content="李潇喃：www.muzisheji.com" />
	<!-- IE最新兼容 -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- 国产浏览器高速 -->
	<meta name="renderer" content="webkit">
	<!-- 移动设备禁止缩放 -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- No Baidu Siteapp-->
	<meta http-equiv="Cache-Control" content="no-siteapp" />

	<link rel="icon" type="image/png" href="/Static/Common/img/favicon.png">

	<!-- Add to homescreen for Chrome on Android -->
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="icon" sizes="192x192" href="/Static/Common/img/app.png">

	<!-- Add to homescreen for Safari on iOS -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="Mzsj" />
	<link rel="apple-touch-icon-precomposed" href="/Static/Common/img/app.png">

	<!-- Tile icon for Win8 (144x144 + tile color) -->
	<meta name="msapplication-TileImage" content="/Static/Common/img/app.png">
	<meta name="msapplication-TileColor" content="#0e90d2">
	<!--[if lt IE 9]>
	<script src="/Static/Common/js/html5.js"></script>
	<script src="/Static/Common/js/respond.js"></script>
	<![endif]-->
	<script src="/Static/Common/js/jquery.js"></script>
	<script src="/Static/Mzsj/js/common.js"></script>
	<script charset="utf-8" src="/static/Common/kindeditor/kindeditor-all-min.js"></script>
	<script charset="utf-8" src="/static/Common/kindeditor/lang/zh_CN.js"></script>
	<link rel="stylesheet" href="/static/Common/kindeditor/themes/default/default.css">
	<link rel="stylesheet" type="text/css" href="/Static/Mzsj/images/reset.css" />
</head>

<body>
	<div class="right_con">
		<!-- 右侧标题 -->
		<div class="clearfix">
			<h2 class="main_title f_l"><?php echo ($title); ?></h2>
			<div class="btn-group f_l">
				
				<?php if(is_array($rightmenu)): $i = 0; $__LIST__ = $rightmenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subml): $mod = ($i % 2 );++$i;?><a href="<?php echo U($subml['url']);?>" class="btn-green">[ <?php echo ($subml["name"]); ?> ]</a><?php endforeach; endif; else: echo "" ;endif; ?>
				
			</div>
		</div>
		
	<form action="<?php echo U();?>" class="form-box" method="post">
		<div class="form-group">
			<label for="adminname" class="item-label">用户组：<span class="color_9"> 必须填写</span></label>
			<select name="roleid" id="">
				<option value="">请选择用户组</option>
				<?php if(is_array($rolelist)): $i = 0; $__LIST__ = $rolelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rlist): $mod = ($i % 2 );++$i;?><option value="<?php echo ($rlist["roleid"]); ?>"><?php echo ($rlist["rolename"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="adminname" class="item-label">用户名：<span class="color_9"> 必须填写</span></label>
			<input type="text" name="adminname" class="input-text">
		</div>
		<div class="form-group">
			<label for="realname" class="item-label">真实姓名：<span class="color_9"> 必须填写</span></label>
			<input type="text" name="realname" class="input-text">
		</div>
		<div class="form-group">
			<label for="password" class="item-label">密码：<span class="color_9"> 必须填写</span></label>
			<input type="password" name="password" class="input-text">
		</div>
		<div class="form-group">
			<label for="repassword" class="item-label">确认密码：<span class="color_9"> 必须填写</span></label>
			<input type="password" name="repassword" class="input-text">
		</div>
		<div class="form-group">
			<label for="email" class="item-label">邮箱：<span class="color_9"> 必须填写</span></label>
			<input type="text" name="email" class="input-text">
		</div>
		<div class="form-group">
			<label for="tel" class="item-label">电话：<span class="color_9"> 必须填写</span></label>
			<input type="text" name="tel" class="input-text">
		</div>
		<div class="form-group">
			<label for="status" class="item-label">状态：</label>
			<input type="radio" name="status" checked="checked" class="input-radio" value="1"> 启用
			<input type="radio" name="status" class="input-radio" value="0"> 禁用
		</div>
		<div class="form-group">
			<button type="submit" name="dosubmit" class="btn-success">提交</button><button type="reset" name="reset" class="btn-error">重填</button>
		</div>
	</form>

	</div>
</body>

</html>