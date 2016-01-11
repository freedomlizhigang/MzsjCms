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
		<div class="form-group">
			<label for="msgtype" class="item-label">消息类型：<span class="color_9"> 必须填写</span></label>
			<select name="msgtype" id="">
				<option value="">消息类型</option>
				<?php if(is_array($typelist)): foreach($typelist as $key=>$tname): ?><option value="<?php echo ($key); ?>"><?php echo ($tname); ?></option><?php endforeach; endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="msgcon" class="item-label">消息内容：<span class="color_9"> 必须填写</span></label>
			<input type="text" name="msgcon" class="input-text">
		</div>
		<div class="form-group">
			<label for="title" class="item-label">回复标题：<span class="color_9"> 必须填写</span></label>
			<input type="text" name="title" class="input-text">
		</div>
		<div class="form-group">
			<label for="thumb" class="item-label">回复图片：<span class="color_9"> 图文消息时，必须填写</span></label>
			<div class="clearfix">
				<input type="text" name="thumb" id="url3" value="" class="input-text f_l">
				<input type="button" class="btn-upload f_l ml10" id="image3" value="选择图片" />
			</div>
		</div>
		<div class="form-group">
			<label for="content" class="item-label">回复内容：<span class="color_9"> 当普通文本框用，只能加个链接，别的都显示不出来，必须填写</span></label>
			<textarea name="content" id="content_edit" style="width:56%" rows="10"></textarea>
		</div>
		<div class="form-group">
			<label for="url" class="item-label">回复链接：<span class="color_9"> url，必须填写</span></label>
			<input type="text" name="url" class="input-text">
		</div>
		<div class="form-group">
			<button type="submit" name="dosubmit" class="btn-success">提交</button><button type="reset" name="reset" class="btn-error">重填</button>
		</div>
	</form>
	<script>
		KindEditor.ready(function(K) {
                window.editor = K.create('#content_edit', {
                	items : ['source','link', 'unlink'],
	                uploadJson : "<?php echo U('Mzsj/Content/kindupload');?>",
	                extraFileUploadParams: {
						session_id : '<?php echo session_id();?>'
                    }
	       		});
	       		K('#image3').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							showRemote : false,
							imageUrl : K('#url3').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#url3').val(url);
								editor.hideDialog();
							}
						});
					});
				});
        });
	</script>

	</div>
</body>

</html>