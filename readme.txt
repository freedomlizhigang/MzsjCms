thinkphp 版本 3.2.3

目录：
app
  |-common  	公共配置文件及公用函数
  |-Index   	前台模块
  	|-Session  	前台session存放目录
  |-Mzsj    	后台管理模块（后台使用mysql存放session）
  |-Uc			Ucenter文件
  |-Runtime 	thinkphp生成的缓存文件
Core			ThinkPHP框架文件（修改了U方法，可以路由后的参数直接解析出来）
Static			静态文件存放地址
Upload			上传文件存放的地址
index.php  		前台入口绑定文件
mzsj.php   		后台入口绑定文件
.htaccess		伪静态配置文件