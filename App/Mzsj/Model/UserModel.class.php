<?php
namespace Mzsj\Model;
use Think\Model;
class UserModel extends Model{
	protected $_auto = array(
		array('password','md5',1,'function'),
		array('password','',2,'ignore'),
		array('lasttime','time',1,'function'),
		array('regtime','time',1,'function'),
	);
	protected $_validate = array(
		array('username','require','请输入用户名！',0),
		array('username','','用户名已经存在，请换一个再试！',0,'unique'),
		array('username','checkuser','请检查用户名长度是否符合标准！',0,'callback'),
		array('openid','','openid已经存在，是不是已经开通过快速登陆了！',2,'unique'),
		array('ucenterid','','用户已经存在，是不是已经注册过了！',2,'unique'),
		array('nickname','0,20','昵称这么长，人家记得住吗！',2,'length'),
		array('groupid','require','请选择用户所在组！',0),
		array('password','6,15','请检查密码的长度是否符合标准！',0,'length'),
		array('repassword','password','两次密码输入的不一致！',0,'confirm'),
		array('email','email','邮箱格式不正确！',0),
		array('tel','number','电话号码格式不正确！',2),
		array('point','number','积分应该是数字！',0),
		array('oldpassword','checkpassword','老密码不正确，请重新输入！',0,'callback'),
	);
	protected function checkuser($username){
		$username = strlen($username);
		if ($username < 4 || $username > 25) {
			return false;
		}else{
			return true;
		}
	}
	protected function checkpassword(){
		$password = M('User')->where(array('userid'=>I('userid')))->getField('password');
		if ($password == md5(I('oldpassword'))) {
			return true;
		}else{
			return false;
		}
	}
}
?>