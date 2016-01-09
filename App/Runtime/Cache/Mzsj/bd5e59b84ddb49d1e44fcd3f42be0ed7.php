<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">

<head>
	<meta charset="utf-8" />
	<title>木子设计后台管理程序</title>
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
	<link rel="stylesheet" type="text/css" href="/Static/Mzsj/images/reset.css" />
</head>

<body class="box">
	<div class="mainbox">
		<header class="top clearfix overh">
			<h1 class="logo">木子设计</h1>
			<nav class="menu clearfix overh">
				<ul id="mainmenu">
				<?php if(is_array($mainmenu)): $i = 0; $__LIST__ = $mainmenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?><li><a href="javascript:;" <?php if($ml["menuid"] == 42): ?>class="active"<?php endif; ?> data-menuid="<?php echo ($ml['menuid']); ?>"><?php echo ($ml["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</nav>
			<span class="userinfo">
				欢迎回来：<?php echo ($admininfo["adminname"]); ?> |
				<a href="<?php echo U('Public/logout');?>">退出</a>
			</span>
		</header>
		<div class="leftbg"></div>
		<!-- 左侧菜单 -->
		<aside class="left overh" id="subnav">
		</aside>
		<section class="right overh">
			<iframe name="right" id="rightMain" src="/mzsj.php/index/main/" frameborder="false" scrolling="auto" style="border:none; margin-bottom:30px" width="100%" height="auto" allowtransparency="true"></iframe>
		</section>
		<footer class="copyright clearfix">
			感谢使用
			<a href="http://www.muzisheji.com/" target="_blank" class="color_f60">木子CMF</a>
			<span class="vieison f_r">V 1.0</span>
		</footer>
	</div>
	<script>
		$(function(){
			// 加载默认左侧菜单
			$("#subnav").load("/mzsj.php/index/left_menu/pid/"+42+"/");
			// 点击切换左侧菜单列表
			$("#mainmenu li a").click(function(){
				var mid = $(this).attr('data-menuid');
				$("#subnav").load("/mzsj.php/index/left_menu/pid/"+mid+"/");
				$(this).addClass('active').parent('li').siblings('li').children('a').removeClass('active');
			});
			// 右侧高度
			var RHeight = $('body').height() - 80;
			$('#rightMain').height(RHeight);
		})
		// 左侧菜单点击添加效果
		function _LM(menuid,targetUrl)
		{
			// 添加样式
			$('.sub_menu').removeClass('active');
			$('#left_menu'+menuid+' ,#left_menu'+menuid+' a').addClass('active');
			// 改变右侧内容区域
			$("#rightMain").attr('src',targetUrl);
		}
	</script>
</body>

</html>