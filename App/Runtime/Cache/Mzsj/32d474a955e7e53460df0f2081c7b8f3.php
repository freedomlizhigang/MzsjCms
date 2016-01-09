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
		
	<form action="<?php echo U('delrole');?>" method="post">
	<table class="table-form">
		<tr class="tr-header">
			<th width="1"><input type="checkbox" value="" class="checkall"></th>
			<th width="50">ID</th>
			<th width="160">名称</th>
			<th width="160">状态</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?><tr>
			<td><input type="checkbox" name="roleids[]" class="subcheck"<?php if($role['roleid'] == 1): ?>disabled="true"<?php else: ?> value="<?php echo ($role["roleid"]); ?>"<?php endif; ?>/></td>
			<td><?php echo ($role["roleid"]); ?></td>
			<td><?php echo ($role["rolename"]); ?></td>
			<td><?php echo ($role["statusname"]); ?></td>
			<td><a href="<?php echo U('editrole',array('roleid'=>$role['roleid']));?>">修改</a> | <?php if($role['roleid'] != 1): ?><a href="<?php echo U('delrole',array('roleid'=>$role['roleid']));?>" class="confirm">删除</a><?php else: ?>删除<?php endif; ?> | <?php if($role['roleid'] != 1): ?><a href="<?php echo U('adminpriv',array('roleid'=>$role['roleid']));?>">权限管理</a><?php else: ?>权限管理<?php endif; ?></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr class="tr-btn">
			<td><input type="checkbox" value="" class="checkall"></td>
			<td colspan="2"><input type="submit" value="删除" class="btn-del confirm" /></td>
			<td colspan="2"><div class="pages"><?php echo ($page); ?></div></td>
		</tr>
	</table>
	</form>

	</div>
</body>

</html>