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
				
<a href="<?php echo U('addlinkage',array('pid'=>$pid));?>" class="btn-green">[ 添加关联 ]</a>

			</div>
		</div>
		
	<form action="<?php echo U('dellinkage');?>" method="post">
	<table class="table-form">
		<tr class="tr-header">
			<th width="1"><input type="checkbox" value="" class="checkall"></th>
			<th width="40">ID</th>
			<th width="60">排序</th>
			<th width="300">名称</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$link): $mod = ($i % 2 );++$i;?><tr>
			<td><input type="checkbox" name="linkageids[]" value="<?php echo ($link["linkageid"]); ?>" class="subcheck" ></td>
			<td><?php echo ($link["linkageid"]); ?></td>
			<td><?php echo ($link["listorder"]); ?></td>
			<td><a class="f_l" href="<?php echo U('',array('pid'=>$link['linkageid']));?>"><?php echo ($link["name"]); ?></a><a href="<?php echo U('addlinkage',array('pid'=>$link['linkageid']));?>" class="addsub"></a></td>
			<td><a href="<?php echo U('editlinkage',array('linkageid'=>$link['linkageid']));?>">修改</a> | <a href="<?php echo U('dellinkage',array('linkageid'=>$link['linkageid']));?>" class="confirm">删除</a></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr class="tr-btn">
			<td><input type="checkbox" value="" class="checkall"></td>
			<td colspan="7"><input type="submit" value="删除" class="btn-del confirm" /></td>
		</tr>
	</table>
	</form>

	</div>
</body>

</html>