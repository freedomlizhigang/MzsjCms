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
		
	<div class="subcat clearfix">
		<div class="f_l subcat_list">
			<form action="<?php echo U('');?>" method="get" class="clearfix">
				<select name="catid" id="catid">
					<option value="">按栏目查看</option>
					<?php if(is_array($catlist)): foreach($catlist as $key=>$catname): ?><option value="<?php echo ($key); ?>"<?php if($key == $catid): ?>selected="selected"<?php endif; ?>><?php echo ($catname["catname"]); ?></option>><?php endforeach; endif; ?>
				</select>
				<input type="submit" value="查看">
			</form>
		</div>
		<div class="f_r search">
			<form action="<?php echo U('');?>" method="post" class="clearfix">
				<?php if(!empty($catid)): ?><input type="hidden" name="catid" value="<?php echo ($catid); ?>" /><?php endif; ?>
				<input type="text" name="q" placeholder="输入要搜索的标题关键字" />
				<input type="submit" value="搜索" >
			</form>
		</div>
	</div>
	<form action="<?php echo U('delarticle');?>" method="post">
	<table class="table-form">
		<tr class="tr-header">
			<th width="1"><input type="checkbox" value="" class="checkall"></th>
			<th width="40">ID</th>
			<th width="60">排序</th>
			<th>标题</th>
			<th width="70">状态</th>
			<th width="60">外链</th>
			<th width="170">修改时间</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$art): $mod = ($i % 2 );++$i;?><tr>
			<td><input type="checkbox" name="artids[]" value="<?php echo ($art["artid"]); ?>" class="subcheck" ></td>
			<td><?php echo ($art["artid"]); ?></td>
			<td><?php echo ($art["listorder"]); ?></td>
			<td><span class="color_9">[ <span class="color_green"><?php echo (substr($catlist[$art['catid']]['catname'],0,12)); ?></span> ]</span> <a href="<?php echo U('showart',array('artid'=>$art['artid']));?>"><?php echo ($art["title"]); ?></a></td>
			<td><?php echo ($art["statusname"]); ?></td>
			<td><?php echo ($art["islinkname"]); ?></td>
			<td><?php echo (date('Y-m-d H:i:s',$art["updatetime"])); ?></td>
			<td><a href="<?php echo U('shenheart',array('artid'=>$art['artid'],'status'=>$art['status']));?>"><?php if($art["status"] == 0): ?><span class="color_green">通过审核</span><?php else: ?><span class="color_9">撤消审核</span><?php endif; ?></a> | <a href="<?php echo U('editarticle',array('artid'=>$art['artid']));?>">修改</a> | <a href="<?php echo U('delarticle',array('artid'=>$art['artid']));?>" class="confirm">删除</a></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr class="tr-btn">
			<td width="1"><input type="checkbox" value="" class="checkall"></td>
			<td colspan="3"><input type="submit" value="删除" class="btn-del confirm" /></td>
			<td colspan="5"><div class="pages"><?php echo ($page); ?></div></td>
		</tr>
	</table>
	</form>

	</div>
</body>

</html>