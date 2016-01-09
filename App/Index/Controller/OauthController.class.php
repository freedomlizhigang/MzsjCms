<?php

// 用户点击的页面地址，从这里（https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx1bb03278d5d74909&redirect_uri=http://www.muzisheji.com/wx/index.php/oauth/index.html&response_type=code&scope=snsapi_base&state=1#wechat_redirect）跳转到现在这个页面，然后进行openID的获取，再进行逻辑操作。
namespace Index\Controller;
use Think\Controller;
use Index\Api\WxApi;
class OauthController extends Controller {
    public function _initialize(){
        $this->WxApi = new WxApi();
    }
	/*
	1、index($hdid)主入口，跳转到微信上取用户的openid。
	*/
	public function index(){
		// 根据code判断是否取到了openid，没有先取openid
		if(I('code',0) && empty($_GET['openid'])){
			// 取openid
			$openid = $this->getoauthtoken(I('code'));
			if (empty($openid)) goto tocode;
			$this->assign('openid',$openid);
		}else{
			tocode:
			// 这里的appid一定要换，url也要换
			header("Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=".S('wxconfigcache')['appid']."&redirect_uri=".S('sitecache')['1']['siteurl']."/oauth/index/&response_type=code&scope=snsapi_base&state=1#wechat_redirect");
			exit;
		}
		// 分享参数
        $this->assign('signPackage',$this->WxApi->share());
        // 分享参数结束
		$this->display();
	}
	// 取得oauth用的access_token
    private function getoauthtoken($code){
        $wxconfig = S('wxconfigcache');
        $appid = $wxconfig['appid'];
        $appsecret = $wxconfig['appsecret'];
        $access_token = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code");
        $atoken = json_decode($access_token,true);
        return $atoken['openid'];
    }
}
?>