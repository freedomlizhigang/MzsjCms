<?php
namespace Index\Controller;
use Think\Controller;
class WxController extends Controller {
    public function _initialize(){
        if (empty($_GET['echostr'])) {
            $this->resmsg();
        }else{
            $this->index();
        }
    }
    public function index(){
        $echoStr = I('echostr');
        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
    // 回复消息
    public function resmsg(){   
		//取得发送的消息数据
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      	//如果存在消息
		if (!empty($postStr)){
            /*将xml消息解析成自己需要的内容*/
            libxml_disable_entity_loader(true);
          	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            // 消息模板
            $textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						</xml>";
            // 判断是事件消息还是普通消息
            $MsgType = $postObj->MsgType;
            $regmsg = M('Wxmsg');
            // 注意将取得的类型等信息转化为str类型
            if ((string)$MsgType === 'event') {
            	$msgEvent = $postObj->Event;
                if ((string)$msgEvent === 'subscribe') {
                    // 看是否关注过，如果没有添加到用户列表中
                    $ishav = $this->checkuser($fromUsername);
                    if (!$ishav) {
                        $userinfo = $this->getuserinfo($fromUsername);
                        if ($userinfo) {
                            $data['openid'] = $userinfo['openid'];
                            $data['wxnick'] = $userinfo['nickname'];
                            $data['wxxb'] = $userinfo['sex'];
                            $data['wxthumb'] = $userinfo['headimgurl'];
                            $data['gztime'] = $userinfo['subscribe_time'];
                            $userid = M('Wxuser')->add($data);
                            if (!$userid) {
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }
                    $subres = $regmsg->where(array('msgtype'=>'subscribe'))->order('msgid DESC')->find();
                    if ($subres) {
                        $contentStr = $subres['content'];
	                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', $contentStr);
	                    echo $resultStr;
                    }
                }elseif((string)$msgEvent == 'unsubscribe'){
                    $unsubres = $regmsg->where(array('msgtype'=>'unsubscribe'))->order('msgid DESC')->find();
                    if ($unsubres) {
                        $contentStr = $subres['content'];
	                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', $contentStr);
	                    echo $resultStr;
                    }
                }elseif((string)$msgEvent === 'CLICK'){
                    // 自定义菜单点击事件
                    $keyword = $postObj->EventKey;
                    // 查看是否有输入消息的设置
                    $res = $regmsg->where(array('msgcon'=>(string)$keyword))->find();
                    if($res){
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, (string)$MsgType, $res['content']);
                        echo $resultStr;
                    }else{
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', '没有找到你要的信息啊');
                        echo $resultStr;
                    }
                }
            }else{
                // 先判断类型，目前只回复关键字的，回复类型为：文本、图文
                if ((string)$MsgType == 'text') {
                    if(!empty($keyword)){
                        // 查看是否有输入消息的设置
                        $res = $regmsg->where(array('msgcon'=>(string)$keyword))->find();
                        // 如果发奖关键字与用户输入的相同，判断用户是否领过奖
                        if($res['msgtype'] == 'text'){
                            // 关键字回复类型为后台设置的类型，一般是图文，或文字，目前只回复关键字消息，其它消息都回复“没有找到”
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $res['msgtype'], $res['content']);
                            echo $resultStr;
                        }elseif($res['msgtype'] == 'news'){
                            // 消息模板
                            $newsTpl = "<xml>
                                        <ToUserName><![CDATA[%s]]></ToUserName>
                                        <FromUserName><![CDATA[%s]]></FromUserName>
                                        <CreateTime>%s</CreateTime>
                                        <MsgType><![CDATA[%s]]></MsgType>
                                        <ArticleCount>1</ArticleCount>
                                        <Articles>
                                        %s
                                        </Articles>
                                        </xml>";
                            $newscontent = "<item>
                                        <Title><![CDATA[".$res['title']."]]></Title> 
                                        <Description><![CDATA[".$res['content']."]]></Description>
                                        <PicUrl><![CDATA[http://www.muzisheji.com".$res['thumb']."]]></PicUrl>
                                        <Url><![CDATA[".$res['url']."]]></Url>
                                        </item>";
                            // 关键字回复类型为后台设置的类型，一般是图文，或文字，目前只回复关键字消息，其它消息都回复“没有找到”
                            $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $res['msgtype'], $newscontent);
                            echo $resultStr;
                        }else{
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', '没有找到你要的回复啊');
                            echo $resultStr;
                        }
                    }
                }else{
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', '没有找到你要的信息啊');
                    echo $resultStr;
                }
            }
        }
    }
    // 取得用户信息
    private function getuserinfo($openid){
        $atoken = $this->gettoken();
        $userinfo = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$atoken."&openid=".$openid."&lang=zh_CN");
        $userinfo = json_decode($userinfo,true);
        return $userinfo;
    }
    // 检查是否已经关注过了
    private function checkuser($fromUsername){
        $ishavs = M('Wxuser')->where(array('openid'=>(string)$fromUsername))->find();
        if ($ishavs) {
            return true;
        }else{
            return false;
        }
    }
    // 微信验证url
    private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = S('wxconfigcache')['token'];
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1( $tmpStr );
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
    // 取得access_token
    private function gettoken(){
        // 7000秒取一次，避免过多超过2000
        if (time() - S('token')['times'] > 7000) {
            $wxconfig = S('wxconfigcache');
            $appid = $wxconfig['appid'];
            $appsecret = $wxconfig['appsecret'];
            $access_token = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret);
            $atoken = json_decode($access_token,true);
            $tokencache = array('access_token'=>$atoken['access_token'],'times'=>time());
            S('token',$tokencache);
            return $atoken['access_token'];
        }else{
            return S('token')['access_token'];
        }
    }
}