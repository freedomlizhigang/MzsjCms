<?php
namespace Index\Controller;
class UserController extends CheckPrivController{
	protected function _initialize(){
		parent::_initialize();
        $this->assign('SITE',S('sitecache'));
	}
	public function index(){
		$this->assign('info',$this->getinfo());
		$this->title = "用户信息";
		$this->display();
	}
	// 修改用户信息
	public function userinfo(){
		if (IS_POST) {
			$User = D('Mzsj/User');
			$res = $User->create();
			if ($res) {
				$saves = $User->save();
				if ($saves) {
					// 记录用户行为
					cookie('mzsj_nickname',$res['nickname']);
					cookie('mzsj_thumb',$res['thumb']);
					$this->nickname = $res['nickname'];
					$this->thumb = $res['thumb'];
					$this->success('修改用户信息成功！');
				}else{
					$this->error("修改用户信息失败，".$User->geterror());
				}
			}else{
				$this->error("修改用户信息失败了，".$User->geterror());
			}
		}else{
			$this->title = "修改用户信息";
			$info = $this->getinfo();
			$this->assign('info',$info);
			$this->display();
		}
	}
	// 修改用户信息
	public function editpwd(){
		if (IS_POST) {
			$User = D('Mzsj/User');
			$data = $_POST;
			$res = $User->create($data);
			if ($res) {
				// 同步修改密码，没发现UC有同步过来，算了，不加了
				// 加载配置文件
		        require_once APP_PATH.'Common/conf/uc_config.php';
		        // 加载UC客户端文件
		        require_once APP_PATH.'Uc/client.php';
		        $updateuc = uc_user_edit(I('uname'),I('oldpassword'),I('password'));
		        if ($updateuc < 0) {
		        	if ($updateuc == -1) {
			        	$this->error('老密码不正确');
			        }
		        }else{
				$data['password'] = md5($res['password']);
				$saves = $User->save($data);
				if ($saves) {
					$this->success('修改密码成功！');
				}else{
					$this->error("修改密码失败，".$User->geterror());
				}
				}
			}else{
				$this->error("修改密码失败了，".$User->geterror());
			}
		}else{
			$this->title = "修改用户密码";
			$this->display();
		}
	}
}
?>