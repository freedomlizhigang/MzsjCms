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
		
	<form action="<?php echo U();?>" method="post">
	<div class="allmenu clearfix">
	<input type="hidden" name="roleid" value="<?php echo ($_GET['roleid']); ?>">
		<?php if(is_array($tree)): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i; if($menu['level'] == 1): ?><h3 class="priv_h3"><input type="checkbox" name="urls[]" class="priv" value="<?php echo ($menu["url"]); ?>"><?php echo ($menu["name"]); ?></h3><?php endif; ?>
			<?php if($menu['level'] == 2): ?><h4 class="priv_h4"><input type="checkbox" name="urls[]" class="priv" value="<?php echo ($menu["url"]); ?>"><?php echo ($menu["name"]); ?></h4><?php endif; ?>
			<?php if($menu['level'] == 3): ?><h4 class="priv_h4_2"><input type="checkbox" name="urls[]" class="priv" value="<?php echo ($menu["url"]); ?>"><?php echo ($menu["name"]); ?></h4><?php endif; ?>
			<?php if($menu['level'] == 4): ?><span><input type="checkbox" name="urls[]" class="priv" value="<?php echo ($menu["url"]); ?>"><?php echo ($menu["name"]); ?></span><?php endif; endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="priv_btn">
	<input type="submit" value="授权" class="btn-del" />
	</div>
	</form>
	<script>
		$(function(){
			var urlArr = [<?php echo ($privstr); ?>];
			$(".priv").each(function(s){
				var thisVal = $(this).val();
				$.each(urlArr,function(i){
					if(urlArr[i] == thisVal){
						$(".priv").eq(s).attr("checked","true");
					}
				});
			});
		});
	</script>

	</div>
</body>

</html>