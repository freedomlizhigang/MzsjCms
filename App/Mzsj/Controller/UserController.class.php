<?php
namespace Mzsj\Controller;
use Think\Controller;
class UserController extends MzsjController {
	public function index(){
		$page = I('p',1);
		$list = M('User')->order('userid DESC')->page($page,20)->select();
		$count = M('User')->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('pages',$show);
		$list = num2name($list,'statusname','status','正常','禁用');
		$this->assign('list',$list);
		$this->assign('gname',S('groupcache'));
		$this->title = "用户列表";
		$this->display();
	}
	public function adduser(){
		if(IS_POST){
			$User = D('User');
			$res = $User->create();
			if ($res) {
				$userid = $User->add();
				if($userid){
					$this->addlog('userid='.$userid);
					$this->success("添加成功！",U('index'));
				}else{
					$this->error("添加失败，".$User->geterror());
				}
			}else{
				$this->error("添加失败，".$User->geterror());
			}
		}else{
			$this->assign('group',S('groupcache'));
			$this->title = "添加用户";
			$this->display();
		}
	}
	// 修改密码
	public function edituser(){
		if(IS_POST){
			$User = D('User');
			$data = $_POST;
			$res = $User->create($data);
			if ($res) {
				$data['password'] = md5($res['password']);
				$userid = $User->save($data);
				if($userid){
					$this->addlog('userid='.$userid);
					$this->success("修改密码成功！",U('index'));
				}else{
					$this->error("修改密码失败，".$User->geterror());
				}
			}else{
				$this->error("修改密码失败，".$User->geterror());
			}
		}else{
			if (I('userid')) {
				$username = M('User')->where(array('userid'=>I('userid')))->getField('username');
				$this->assign('username',$username);
				$this->assign('userid',I('userid'));
				$this->title = "修改密码";
				$this->display();
			}else{
				$this->error("参数错误！");
			}
		}
	}
	// 修改用户信息
	public function userinfo(){
		if(IS_POST){
			$User = D('User');
			$res = $User->create();
			if ($res) {
				$userid = $User->save();
				if($userid){
					$this->addlog('userid='.$userid);
					$this->success("修改用户资料成功！",U('index'));
				}else{
					$this->error("修改用户资料失败，".$User->geterror());
				}
			}else{
				$this->error("修改用户资料失败，".$User->geterror());
			}
		}else{
			if (I('userid')) {
				$info = M('User')->field('userid,username,groupid,nickname,email,tel,point,status')->find(I('userid'));
				$this->assign('info',$info);
				$this->assign('gname',S('groupcache'));
				$this->title = "修改用户资料";
				$this->display();
			}else{
				$this->error("参数错误！");
			}
		}
	}
	// 查看用户信息
	public function showuser(){
		if (I('userid')) {
			$info = M('User')->find(I('userid'));
			$this->assign('info',$info);
			$this->assign('gname',S('groupcache'));
			$this->title = "查看用户资料";
			$this->display();
		}else{
			$this->error("参数错误！");
		}
	}
	// 删除用户
	public function deluser(){
		if (I('userid')) {
			$uids = I('userid');
		}elseif(is_array(I('userids'))){
			$uids = implode(',',I('userids'));
		}else{
			$this->error("参数错误！");
		}
		$del = M('User')->delete($uids);
		if ($del) {
			$this->addlog('userid='.$uids);
			$this->success("删除用户成功！");
		}else{
			$this->error("删除失败！");
		}
	}
}
?>