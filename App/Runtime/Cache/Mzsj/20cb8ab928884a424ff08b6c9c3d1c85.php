<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">

<head>
	<meta charset="utf-8" />
	<title>欢迎登陆木子设计后台管理程序</title>
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
	<link rel="stylesheet" type="text/css" href="/Static/Mzsj/images/reset.css" />
</head>

<body class="body-login">
	<div class="box-login">
		<h1 class="h1-login h_img"><img src="/Static/Mzsj/images/logo.png" width="240" height="46" alt="木子设计管理中心"></h1>
		<div class="form_group">
			<form action="<?php echo U();?>" method="post">
				<div class="form-group">
					<label for="username" class="item-label">用户名：</label>
					<input type="text" value="" name="username" class="input-text">
				</div>
				<div class="form-group">
					<label for="password" class="item-label">密码：</label>
					<input type="password" value="" name="password" class="input-text">
				</div>
				<div class="form-group">
					<label for="rolename" class="item-label">验证码：</label>
					<input type="text" value="" name="verify" class="input-text">
					<img src="<?php echo U('verify');?>" width="240" height="60" class="verify_img" onclick="this.src=this.src+'?'+Math.random()" alt="看不清，换一张">
				</div>
				<div class="form-group">
					<button type="submit" name="dosubmit" class="btn-success">提交</button><button type="reset" name="reset" class="btn-error">重填</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>