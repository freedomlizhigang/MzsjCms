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
		<input type="hidden" name="menuid" value="<?php echo ($info["menuid"]); ?>">
		<div class="form-group">
			<label for="parentid" class="item-label">父菜单：</label>
			<select name="parentid" id="">
				<option value="0">一级菜单</option>
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><option value="<?php echo ($list["menuid"]); ?>"<?php if($list['menuid'] == $info['parentid']): ?>selected<?php endif; ?>><?php echo ($list["nbsp"]); echo ($list["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="name" class="item-label">菜单名称：</label>
			<input type="text" name="name" class="input-text" value="<?php echo ($info["name"]); ?>">
		</div>
		<div class="form-group">
			<label for="url" class="item-label">URL：</label>
			<input type="text" name="url" class="input-text" value="<?php echo ($info["url"]); ?>">
		</div>
		<div class="form-group">
			<label for="listorder" class="item-label">排序：</label>
			<input type="text" name="listorder" class="input-sm input-text" value="<?php echo ($info["listorder"]); ?>">
		</div>
		<div class="form-group">
			<label for="display" class="item-label">是否显示：</label>
			<input type="radio" name="display"<?php if($info['display'] == 1): ?>checked="checked"<?php endif; ?> class="input-radio" value="1"> 是
			<input type="radio" name="display"<?php if($info['display'] == 0): ?>checked="checked"<?php endif; ?> class="input-radio" value="0"> 否
		</div>
		<div class="form-group">
			<button type="submit" name="dosubmit" class="btn-success">提交</button><button type="reset" name="reset" class="btn-error">重填</button>
		</div>
	</form>

	</div>
</body>

</html>