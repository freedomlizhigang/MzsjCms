<?php
namespace Mzsj\Model;
use Think\Model;
class AdminModel extends Model{
	protected $_validate = array(
		array('roleid','require','角色不能为空啊~',0),
		array('adminname','require','用户名不能全为空格啊~',0),
		array('adminname','6,12','用户名为6-12位长短',0,'length'),
		array('adminname','','用户名已经存在，请换一个再试~',0,'unique'),
		array('realname','require','真实姓名必须填写~',0),
		array('password','6,15','密码应该在6-15位之间~',0,'length'),
		array('repassword','password','两次密码不一致~~',0,'confirm'),
		array('email','email','邮箱格式不对啊~',0),
		array('email','','邮箱已经存在，请换一个再试~',0,'unique'),
		array('tel','number','电话不应该都是数字吗?',0),
		array('tel','','电话号码已经存在，请换一个再试~',0,'unique'),
		array('oldpassword','pwdval','旧密码错误，请重新输入',0,'callback'),
		// array('password','ispwd','密码错误，请重新输入',0,'callback',2),
	);
	protected $_auto = array(
		array('password','pwd_jm',3,'callback'),
	);
	// protected function ispwd(){
	// 	$aid = I('adminid');
	// 	$pwdinput = md5(I('password'));
	// 	$oldpwd = $this->where(array('adminid'=>$aid))->getfield('password');
	// 	if ($oldpwd == $pwdinput) {
	// 		return true;
	// 	}else{
	// 		return false;
	// 	}
	// }
	protected function pwdval(){
		$aid = I('adminid');
		$oldpwd = $this->where(array('adminid'=>$aid))->field('password,encrypt')->find();
		$oldpwdinput = md5(md5(I('oldpassword').$oldpwd['encrypt']));
		if ($oldpwd['password'] == $oldpwdinput) {
			return true;
		}else{
			return false;
		}
	}
	// 密码加密
	protected function pwd_jm(){
		return md5(md5(I('password').I('encrypt')));
	}
}
?>