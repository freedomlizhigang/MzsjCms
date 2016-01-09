<?php
namespace Index\Controller;
use Think\Controller;
class PublicController extends Controller {
	public function _initialize(){
		// 加载配置文件
        require_once APP_PATH.'Common/conf/uc_config.php';
        // 加载UC客户端文件
        require_once APP_PATH.'Uc/client.php';
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
					// 开始同步登陆判断
					// if ($res['issynlogin'] != 0) {
					$userzh = mb_convert_encoding(I('uname'),'gbk','utf8');
					list($uid, $username, $password, $email) = uc_user_login($userzh, I('password'));
					if($uid > 0) {
						//生成同步登录的代码
						$ucsynlogin = uc_user_synlogin($uid);
						echo $ucsynlogin;
					} elseif($uid == -1) {
						$this->error("用户不存在,或者被删除");
					} elseif($uid == -2) {
						$this->error("密码错误，请重试！");
					} else {
						$this->error("请查看您的论坛帐号是否已经激活，或者直接从论坛登陆！");
					}
					// }
					// 如果是论坛用户，可以直接登陆
					if (empty($res) && $uid > 0) {
						// 查一下是否有这个用户
						$havuser = M('User')->where(array('username'=>I('uname'),'ucenterid'=>$uid))->find();
						if ($havuser) {
							if ($res['status'] == 0) $this->error("用户已经被禁用，请直接联系系统管理员！");
							$map['userid'] = $havuser['userid'];
							$map['password'] = md5(I('password'));
							$map['lasttime'] = time();
							$map['lastip'] = get_client_ip();
							$save = M('User')->save($map);
							// 本地登陆信息存储
							cookie('mzsj_userid',sys_auth($havuser['userid']));
							cookie('mzsj_username',sys_auth($havuser['username']));
							$this->success("登陆成功！",U('User/index'));
							exit;
						}else{
							// 没有这个用户直接添加一个
							list($ucenterid, $username, $email) = uc_get_user($userzh);
							$regdata['username'] = I('uname');
							$regdata['email'] = $email;
							$regdata['ucenterid'] = $ucenterid;
							$regdata['groupid'] = 1;
							$regdata['status'] = 1;
							$regdata['password'] = I('password');
							$regdata['__hash__'] = I('__hash__');
							$User = D('Mzsj/User');
							$addres = $User->create($regdata);
							// 判断是否添加成功
							if ($addres) {
								$addid = $User->add($addres);
								if($addid) {
									cookie('mzsj_userid',sys_auth($addid));
									cookie('mzsj_username',sys_auth($addres['username']));
									$this->success("登陆成功！",U('User/index'));
									exit;
								}else{
									$this->error("登陆失败，".$User->geterror());
								}
							}else{
								$this->error('登陆失败，'.$User->getError());
							}
						}
					}
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
		//同步退出
		$ucsynlogout = uc_user_synlogout();
		echo $ucsynlogout;
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
					// 同步注册开始，坑爹的编码不一致
					$uid = uc_user_register(mb_convert_encoding($res['username'],'gbk','utf8'), I('password'), $res['email']);
					if($uid <= 0) {
						if($uid == -1) {
							$this->error("注册失败，用户名不合法");
						} elseif($uid == -2) {
							$this->error("注册失败，包含要允许注册的词语");
						} elseif($uid == -3) {
							$this->error("注册失败，用户名已经存在");
						} elseif($uid == -4) {
							$this->error("注册失败，该 Email 格式有误");
						} elseif($uid == -5) {
							$this->error("注册失败，该 Email 不允许注册");
						} elseif($uid == -6) {
							$this->error("注册失败，该 Email 已经被注册");
						} else {
							$this->error("注册失败，".$User->geterror());
						}
					} else {
						// 同步注册成功，开始本地注册
						$res['ucenterid'] = $uid;
						$userid = $User->add($res);
						if ($userid) {
							cookie('mzsj_userid',sys_auth($userid));
							cookie('mzsj_username',sys_auth($res['username']));
							$this->success('注册成功，如想使用论坛功能，请先到论坛进行激活！',U('User/index'));
						}else{
							$this->error("注册失败，".$User->geterror());
						}
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