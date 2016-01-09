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
	<link rel="stylesheet" type="text/css" href="/Static/Mzsj/images/reset.css" />
</head>

<body>
	<div class="mainbox">
		<header class="top clearfix overh">
			<h1 class="logo">木子设计</h1>
			<nav class="menu clearfix overh">
				<ul>
				<?php if(is_array($menu["main"])): $i = 0; $__LIST__ = $menu["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U($ml['url']);?>" class="<?php echo ($ml["class"]); ?>"><?php echo ($ml["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
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
			<?php if(is_array($menu["child"])): $i = 0; $__LIST__ = $menu["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$submenu): $mod = ($i % 2 );++$i;?><h3 class="left_h3"> <i class="icon"></i>
				<?php echo ($submenu["name"]); ?>
			</h3>
			<?php if(!empty($submenu["subchild"])): ?><ul class="left_list">
				<?php if(is_array($submenu["subchild"])): $i = 0; $__LIST__ = $submenu["subchild"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subchild): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U($subchild['url']);?>"><?php echo ($subchild["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</aside>
		<section class="right overh">
			<div class="right_con">
			<!-- 右侧标题 -->
			<div class="clearfix">
				<h2 class="main_title f_l"><?php echo ($title); ?></h2>
				<div class="btn-group f_l">
				
				<?php if(is_array($rightmenu)): $i = 0; $__LIST__ = $rightmenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subml): $mod = ($i % 2 );++$i;?><a href="<?php echo U($subml['url']);?>" class="btn-green">[ <?php echo ($subml["name"]); ?> ]</a><?php endforeach; endif; else: echo "" ;endif; ?>
				
				</div>
			</div>
			
	<form action="<?php echo U();?>" class="form-box" method="post">
		<input type="hidden" value="<?php echo ($_GET['adminid']); ?>" name="adminid">
		<input type="hidden" value="<?php echo ($encrypt); ?>" name="encrypt">
		<div class="form-group">
			<label for="oldpassword" class="item-label">老密码：<span class="color_9"> 必须填写</span></label>
			<input type="password" name="oldpassword" class="input-text">
		</div>
		<div class="form-group">
			<label for="password" class="item-label">新密码：<span class="color_9"> 必须填写</span></label>
			<input type="password" name="password" class="input-text">
		</div>
		<div class="form-group">
			<label for="repassword" class="item-label">确认密码：<span class="color_9"> 必须填写</span></label>
			<input type="password" name="repassword" class="input-text">
		</div>
		<div class="form-group">
			<button type="submit" name="dosubmit" class="btn-success">提交</button><button type="reset" name="reset" class="btn-error">重填</button>
		</div>
	</form>
	<script>
		highlight_subnav('<?php echo U('index');?>');
	</script>

			</div>
		</section>
		<footer class="copyright clearfix">
			感谢使用
			<a href="http://www.muzisheji.com/" target="_blank" class="color_f60">木子CMF</a>
			<span class="vieison f_r">V 1.0</span>
		</footer>
	</div>
	<script>
	$(function(){
		var $subnav = $("#subnav"), url;
		url = window.location.pathname + window.location.search;
        url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
		$subnav.find("a[href='" + url + "']").addClass("active").parent().addClass("active");
	})
	</script>
</body>

</html>