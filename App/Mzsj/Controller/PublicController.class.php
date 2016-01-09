<?php
namespace Mzsj\Controller;
use Think\Controller;
class PublicController extends Controller {
	public function login(){
		if(session('mz_adminid')){
			$this->success("您已经登陆，请直接进行操作！",U('Index/index'));
		}else{
			if (IS_POST) {
				$verify = I('verify');
				$verifyres = $this->check_verify($verify);
				if ($verifyres) {
					$data['adminname'] = I('username');
					$res = M('Admin')->where($data)->find();
					if (empty($res)) {$this->error("用户名不存在！");}
					if ($res['password'] != md5(md5(I('password').$res['encrypt']))) {$this->error('密码不正确！');}
					if ($res['status'] == 1) {
						$map['adminid'] = $res['adminid'];
						$map['lasttime'] = time();
						$map['lastip'] = get_client_ip();
						$save = M('Admin')->save($map);
						session('mz_adminid',$res['adminid']);
						session('mz_adminname',$res['adminname']);
						session('mz_roleid',$res['roleid']);
						// 记录用户行为
						$this->addlog();
						$this->success("登陆成功！",U('Index/index'));
					}else{
						$this->error("用户已经被禁用，请直接联系系统管理员！");
					}
				}else{
					$this->error("验证码错误");
				}
			}else{
				$this->display();
			}
		}
	}
	public function logout(){
    	session('mz_adminid',null);
		session('mz_adminname',null);
		session('mz_roleid',null);
    	$this->success("退出登陆成功！",U('login'));
    }
	// 生成验证码
	public function verify(){
		$config = array(
			'fontSize' => '70',
			'useNoise' => false,
			'useCurve' => false,
		);
	    $Verify = new \Think\Verify($config);
    	$Verify->entry();
	}
	// 检查验证码
	private function check_verify($code){
		$verify = new \Think\Verify();
		return $verify->check($code);
	}
	// 添加用户日志
	protected function addlog($q = ''){
		$data['url'] = '/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/';
		$data['data'] = $q;
		$data['adminid'] = session('mz_adminid');
		$data['adminname'] = session('mz_adminname');
		$data['ip'] = get_client_ip();
		$data['time'] = time();
		M('Log')->add($data);
	}
}
?>