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
		
	<form action="<?php echo U('deltype');?>" method="post">
	<table class="table-form">
		<tr class="tr-header">
			<th width="1"><input type="checkbox" value="" class="checkall"></th>
			<th width="50">ID</th>
			<th width="60">排序</th>
			<th>菜单名称</th>
			<th width="100">类别目录</th>
			<th width="100">是否显示</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($tree)): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><tr>
			<td><input type="checkbox" name="tids[]" value="<?php echo ($type["typeid"]); ?>" class="subcheck"></td>
			<td><?php echo ($type["typeid"]); ?></td>
			<td><?php echo ($type["listorder"]); ?></td>
			<td><span class="f_l"><?php echo ($type["nbsp"]); echo ($type["typename"]); ?></span><?php if($type['level'] < 4): ?><a href="<?php echo U('addtype',array('parentid'=>$type['typeid']));?>" class="addsub"></a><?php endif; ?></td>
			<td><?php echo ($type["typedir"]); ?></td>
			<td><?php echo ($type["displayname"]); ?></td>
			<td><a href="<?php echo U('edittype',array('tid'=>$type['typeid']));?>">修改</a> | <a href="<?php echo U('deltype',array('tid'=>$type['typeid']));?>" class="confirm">删除</a></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr class="tr-btn">
			<td><input type="checkbox" value="" class="checkall"></td>
			<td colspan="6"><input type="submit" value="删除" class="btn-del confirm" /></td>
		</tr>
	</table>
	</form>

	</div>
</body>

</html>