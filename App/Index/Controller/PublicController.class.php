<?php
namespace Index\Controller;
use Think\Controller;
class PublicController extends Controller {
	public function _initialize(){
        $this->assign('SITE',S('sitecache'));
	}
	public function index(){
		$this->redirect('login');
	}
	public function login(){
		if(cookie('mzsj_userid')){
			$this->success("您已经登陆，请直接进行操作！",U('User/index'));
		}else{
			if (IS_POST) {
				$verify = I('verify');
				$verifyres = $this->check_verify($verify);
				if ($verifyres) {
					$data['username'] = I('uname');
					$data['password'] = md5(I('password'));
					$res = M('User')->where($data)->find();
					// 如果是本地用户，直接登陆
					if (!empty($res)) {
						if ($res['status'] == 1) {
							$map['userid'] = $res['userid'];
							$map['lasttime'] = time();
							$map['lastip'] = get_client_ip();
							$save = D('Mzsj/User')->save($map);
							// 本地登陆信息存储
							cookie('mzsj_userid',sys_auth($res['userid']));
							cookie('mzsj_username',sys_auth($res['username']));
							$this->success("登陆成功！",U('User/index'));
						}else{
							$this->error("用户已经被禁用，请直接联系系统管理员！");
						}
					}else{
						$this->error("请检查用户名密码是否正确！");
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
		// 本地退出
		session('USER_MENU_LIST',null);
		cookie('mzsj_userid',null);
		cookie('mzsj_username',null);
		cookie('mzsj_thumb',null);
    	$this->success("退出登陆成功！",U('login'));
    }
	// 生成验证码
	public function verify(){
		$config = array(
			'fontSize' => '90',
			'useNoise' => false,
			'useCurve' => false,
			'length' => 4,
		);
	    $Verify = new \Think\Verify($config);
    	$Verify->entry();
	}
	// 注册
	public function reg(){
		if (IS_POST) {
			$verify = I('verify');
			$verifyres = $this->check_verify($verify);
			if ($verifyres) {
				$User = D('Mzsj/User');
				$_POST['groupid'] = 1;
				$_POST['status'] = 1;
				$res = $User->create();
				if ($res) {
					$userid = $User->add($res);
					if ($userid) {
						cookie('mzsj_userid',sys_auth($userid));
						cookie('mzsj_username',sys_auth($res['username']));
						$this->success('注册成功！',U('User/index'));
					}else{
						$this->error("注册失败，".$User->geterror());
					}
				}else{
					$this->error("注册失败，".$User->geterror());
				}
			}else{
				$this->error("验证码错误");
			}
		}else{
			if (empty(cookie('mzsj_userid')) || empty(cookie('mzsj_username'))) {
				$this->title = "注册新用户";
				$this->display();
			}else{
				$this->error('已经登陆了，请先退出！',U('User/index'));
			}
		}
	}
	// 检查验证码
	private function check_verify($code){
		$verify = new \Think\Verify();
		return $verify->check($code);
	}
	// kindedit上传图片
    public function kindupload(){
        session('upload_error', null);
        /* 上传配置 */
        $setting = array(
            'maxSize'       =>  3145728, //上传的文件大小限制 (0-不做限制)
            'exts'          =>  array('jpg','jpeg','gif','png','bmp'), //允许上传的文件后缀
            'rootPath'      =>  './Upload/', //保存路径
        );
        /* 调用文件上传组件上传文件 */
        $this->uploader = new \Think\Upload($setting);
        $info   = $this->uploader->upload();
        if($info){
            $url = $setting['rootPath'].$info['imgFile']['savepath'].$info['imgFile']['savename'];
            $url = str_replace('./', '/', $url);
            $info['fullpath'] = __ROOT__.$url;
        }
        session('upload_error', $this->uploader->getError());
        /* 返回标准数据 */
        $return  = array('error' => 0, 'info' => '上传成功', 'data' => '');
        /* 记录附件信息 */
        if($info){
            $return['url'] = $info['fullpath'];
            unset($return['info'], $return['data']);
        } else {
            $return['error'] = 1;
            $return['message']   = session('upload_error');
        }
        /* 返回JSON数据 */
        exit(json_encode($return));
    }
    // kindedit上传头像
    public function kinduploadthumb(){
        session('upload_error', null);
        /* 上传配置 */
        $setting = array(
            'maxSize'       =>  102400, //上传的文件大小限制 (0-不做限制)
            'exts'          =>  array('jpg','jpeg','gif','png','bmp'), //允许上传的文件后缀
            'rootPath'      =>  './Upload/', //保存路径
        );
        /* 调用文件上传组件上传文件 */
        $this->uploader = new \Think\Upload($setting);
        $info   = $this->uploader->upload();
        if($info){
            $url = $setting['rootPath'].$info['imgFile']['savepath'].$info['imgFile']['savename'];
            $url = str_replace('./', '/', $url);
            $info['fullpath'] = __ROOT__.$url;
        }
        session('upload_error', $this->uploader->getError());
        /* 返回标准数据 */
        $return  = array('error' => 0, 'info' => '上传成功', 'data' => '');
        /* 记录附件信息 */
        if($info){
            $return['url'] = $info['fullpath'];
            unset($return['info'], $return['data']);
        } else {
            $return['error'] = 1;
            $return['message']   = session('upload_error');
        }
        /* 返回JSON数据 */
        exit(json_encode($return));
    }
}
?>