<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title><?php echo ($catinfo['catname']); ?></title>
		<meta name="author" content="李潇喃：www.muzisheji.com" />
		<!-- IE最新兼容 -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- 国产浏览器高速 -->
		<meta name="renderer" content="webkit">
		<!-- 移动设备禁止缩放 -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<!-- <base target="_blank" /> -->
		<!-- No Baidu Siteapp-->
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<!-- 基础url -->
		<base href="<?php echo ($SITE[1]['siteurl']); ?>" />
		<!-- 小角标 -->
		<link rel="icon" type="image/png" href="/Static/Index/images/favicon.png">

		<!-- Add to homescreen for Chrome on Android -->
		<meta name="mobile-web-app-capable" content="yes">
		<link rel="icon" sizes="192x192" href="/Static/Index/images/app.png">

		<!-- Add to homescreen for Safari on iOS -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-title" content="Mzsj" />
		<link rel="apple-touch-icon-precomposed" href="/Static/Index/images/app.png">

		<!-- Tile icon for Win8 (144x144 + tile color) -->
		<meta name="msapplication-TileImage" content="/Static/Index/images/app.png">
		<meta name="msapplication-TileColor" content="#0e90d2">
		<!--[if gt IE 9]>
		<script src="/Static/Common/js/html5.js"></script>
		<script src="/Static/Common/js/respond.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="/Static/Index/images/reset.css">
		<script src="/Static/Common/js/jquery.js"></script>
	</head>

	<body>
		<!--header-->
		<header class="top_bg overh m_a mt20 clearfix">
		<h1 class="logo f_l"><a href="<?php echo ($SITE['1']['siteurl']); ?>">木子设计</a></h1>
		</header>
		<!--menu-->
		<nav class="menu mt20 m_a clearfix">
			<ul>
				<li><a href="<?php echo ($SITE['1']['siteurl']); ?>">网站首页</a></li>
				<?php echo W('Tag/menutag',array('pid'=>'0'));?>
			</ul>
		</nav>
		<!--wrap_one-->
		<section class="wrap_one overh mt15 m_a clearfix">
			<!--wrap_left-->
			<div class="wrap_left f_l overh">
			
	<?php echo ($catinfo['content']); ?>

			</div>
			<!--wrap_right-->
			<aside class="wrap_right f_r">
				右边的
			</aside>
		</section>
		<!--footer-->
		
		<footer class="foot_bg m_a overh">
			copyright @ 2015-2017 木子设计
		</footer>
		

	</body>

</html>