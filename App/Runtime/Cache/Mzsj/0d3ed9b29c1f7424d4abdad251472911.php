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
		
	<form action="<?php echo U('deluser');?>" method="post">
	<table class="table-form">
		<tr class="tr-header">
			<th width="1"><input type="checkbox" value="" class="checkall"></th>
			<th width="50">ID</th>
			<th width="120">用户名</th>
			<th width="120">所在组</th>
			<th width="120">昵称</th>
			<th width="100">积分</th>
			<th width="160">状态</th>
			<th width="200">最后登陆时间</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><tr>
			<td><input type="checkbox" name="userids[]" value="<?php echo ($user["userid"]); ?>" class="subcheck" /></td>
			<td><?php echo ($user["userid"]); ?></td>
			<td><a href="<?php echo U('showuser',array('userid'=>$user['userid']));?>"><?php echo ($user["username"]); ?></a></td>
			<td><?php echo ($gname[$user[groupid]]); ?></td>
			<td><?php echo ($user["nickname"]); ?></td>
			<td><?php echo ($user["point"]); ?></td>
			<td><?php echo ($user["statusname"]); ?></td>
			<td><?php echo (date('Y-m-d H:i:s',$user["lasttime"])); ?></td>
			<td><a href="<?php echo U('userinfo',array('userid'=>$user['userid']));?>">修改资料</a> | <a href="<?php echo U('edituser',array('userid'=>$user['userid']));?>">修改密码</a> | <a href="<?php echo U('deluser',array('userid'=>$user['userid']));?>" class="confirm">删除</a></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr class="tr-btn">
			<td><input type="checkbox" value="" class="checkall"></td>
			<td colspan="2"><input type="submit" value="删除" class="btn-del confirm" /></td>
			<td colspan="7"><div class="pages"><?php echo ($page); ?></div></td>
		</tr>
	</table>
	</form>

	</div>
</body>

</html>