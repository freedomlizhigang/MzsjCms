<?php
namespace Index\Controller;
use Think\Controller;
use Common\Api\WxApi;
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
            $time = time();
            // 判断是事件消息还是普通消息
            $MsgType = $postObj->MsgType;
            // 注意将取得的类型等信息转化为str类型
            if ((string)$MsgType === 'event') {
            	$msgEvent = $postObj->Event;
                // 如果是关注事件
                if ((string)$msgEvent === 'subscribe') {
                   $this->subscribe($fromUsername,$toUsername,$time);
                }elseif((string)$msgEvent === 'unsubscribe'){
                    // 取消关注事件
                    $this->unsubscribe($fromUsername,$toUsername,$time);
                }elseif((string)$msgEvent === 'CLICK'){
                    // 自定义菜单点击事件
                    $this->clickeven($postObj,$fromUsername,$toUsername,$time);
                }
            }else{
                // 根据消息类型进行回复
                switch ((string)$MsgType) {
                    // 文本消息，根据关键字进行回复
                    case 'text':
                        $keyword = trim($postObj->Content);
                        if(!empty($keyword)){
                            // 查看是否有输入消息的设置
                            $res = M('Wxmsg')->where(array('msgcon'=>(string)$keyword))->find();
                            // 判断回复类型
                            $this->msgtype($fromUsername,$toUsername,$time,$res);
                        }else{
                            // 空关键字的默认回复
                            $this->msg_nokey($fromUsername,$toUsername,$time);
                        }
                        break;
                    case 'image':
                        // 反馈图片消息
                        $res['content'] = '亲，不认识图片啊！';
                        $this->msg_text($fromUsername,$toUsername,$time,$res);
                        break;

                    case 'voice':
                        // 反馈语音消息
                        $res['content'] = '亲，还没有语音识别功能哟！';
                        $this->msg_text($fromUsername,$toUsername,$time,$res);
                        break;

                    case 'video':
                        // 反馈视频消息
                        $res['content'] = '亲，小机器人看不懂视频的！';
                        $this->msg_text($fromUsername,$toUsername,$time,$res);
                        break;

                    case 'shortvideo':
                        // 反馈小视频消息
                        $res['content'] = '亲，小机器人看不懂小视频的！';
                        $this->msg_text($fromUsername,$toUsername,$time,$res);
                        break;

                    case 'location':
                        // 反馈地理位置消息
                        $res['content'] = '亲，你所在的维度是：'.$postObj->Location_X.'，经度是：'.$postObj->Location_Y.'，位置信息是：'.$postObj->Label;
                        $this->msg_text($fromUsername,$toUsername,$time,$res);
                        break;

                    case 'link':
                        // 反馈链接消息
                        $res['content'] = '亲，你发的链接是：'.$postObj->Url.'直接打开就好！';
                        $this->msg_text($fromUsername,$toUsername,$time,$res);
                        break;
                    default:
                        // 没找到对应事件时的默认回复
                        $this->msg_nokey($fromUsername,$toUsername,$time);
                        break;
                }
            }
        }
    }
    // 取得用户信息
    private function getuserinfo($openid){
        $wxapi = new WxApi();
        $atoken = $wxapi->gettoken();
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
    /*
    * 判断回复类型
    */
    public function msgtype($fromUsername,$toUsername,$time,$res)
    {
        switch ($res['msgtype']) {
            case 'text':
                // 文本消息
                $this->msg_text($fromUsername,$toUsername,$time,$res);
                break;

            case 'image':
                // 视频消息
                $this->msg_image($fromUsername,$toUsername,$time,$res);
                break;

            case 'voice':
                // 视频消息
                $this->msg_voice($fromUsername,$toUsername,$time,$res);
                break;

            case 'music':
                // 视频消息
                $this->msg_music($fromUsername,$toUsername,$time,$res);
                break;

            case 'news':
                // 图文消息
                $this->msg_news($fromUsername,$toUsername,$time,$res);
                break;

            case 'video':
                // 视频消息
                $this->msg_video($fromUsername,$toUsername,$time,$res);
                break;

            default:
                // 没找到关键字时的默认回复
                $this->msg_nokey($fromUsername,$toUsername,$time);
                break;
        }
    }
    /*
    * 回复文本消息
    */
    public function msg_text($fromUsername,$toUsername,$time,$res){
        // 消息模板
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        // 关键字回复类型为后台设置的类型，一般是图文，或文字，目前只回复关键字消息，其它消息都回复“没有找到”
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $res['content']);
        echo $resultStr;
    }
    /*
    * 没找到关键字时默认回复
    */
    public function msg_nokey($fromUsername,$toUsername,$time){
        // 消息模板
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', '没有找到你要的回复啊');
        echo $resultStr;
    }
    /*
    * 回复图片消息
    */
    public function msg_image($fromUsername,$toUsername,$time,$res){
        // 视频消息模板
        $newsTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>
                    <Image>
                    <MediaId><![CDATA[%s]]></MediaId>
                    </Image> 
                    </xml>
                    ";
        // 关键字回复类型为后台设置的类型，一般是图文，或文字，目前只回复关键字消息，其它消息都回复“没有找到”
        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $res['mediaid']);
        echo $resultStr;
    }
    /*
    * 回复语音消息
    */
    public function msg_voice($fromUsername,$toUsername,$time,$res){
        // 视频消息模板
        $newsTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[voice]]></MsgType>
                    <Voice>
                    <MediaId><![CDATA[%s]]></MediaId>
                    </Voice> 
                    </xml>
                    ";
        // 关键字回复类型为后台设置的类型，一般是图文，或文字，目前只回复关键字消息，其它消息都回复“没有找到”
        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $res['mediaid']);
        echo $resultStr;
    }
    /*
    * 回复音乐消息
    */
    public function msg_music($fromUsername,$toUsername,$time,$res){
        // 视频消息模板
        $newsTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[music]]></MsgType>
                    <Music>
                        %s
                    </Music>
                    </xml>
                    ";
        $musiccon = "<Title><![CDATA[".$res['title']."]]></Title>
                        <Description><![CDATA[".$res['content']."]]></Description>
                        <MusicUrl><![CDATA[".$res['music_url']."]]></MusicUrl>
                        <HQMusicUrl><![CDATA[".$res['hq_music_url']."]]></HQMusicUrl>
                        <ThumbMediaId><![CDATA[".$res['mediaid']."]]></ThumbMediaId>";
        // 关键字回复类型为后台设置的类型，一般是图文，或文字，目前只回复关键字消息，其它消息都回复“没有找到”
        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $musiccon);
        echo $resultStr;
    }
    /*
    * 回复视频消息
    */
    public function msg_video($fromUsername,$toUsername,$time,$res){
        // 视频消息模板
        $newsTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[video]]></MsgType>
                    <Video>
                    <MediaId><![CDATA[%s]]></MediaId>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    </Video> 
                    </xml>
                    ";
        // 关键字回复类型为后台设置的类型，一般是图文，或文字，目前只回复关键字消息，其它消息都回复“没有找到”
        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $res['mediaid'],$res['title'],$res['content']);
        echo $resultStr;
    }
    /*
    * 回复图文消息
    */
    public function msg_news($fromUsername,$toUsername,$time,$res){
        // 消息模板
        $newsTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>1</ArticleCount>
                    <Articles>
                    %s
                    </Articles>
                    </xml>";
        $newscontent = "<item>
                    <Title><![CDATA[".$res['title']."]]></Title> 
                    <Description><![CDATA[".$res['content']."]]></Description>
                    <PicUrl><![CDATA[".$res['mediaid']."]]></PicUrl>
                    <Url><![CDATA[".$res['url']."]]></Url>
                    </item>";
        // 关键字回复类型为后台设置的类型，一般是图文，或文字，目前只回复关键字消息，其它消息都回复“没有找到”
        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $newscontent);
        echo $resultStr;
    }
    /*
    * 关注事件，消息回复
    */
    public function subscribe($fromUsername,$toUsername,$time){
        // 看是否关注过，如果没有添加到用户列表中
        $ishav = $this->checkuser($fromUsername);
        if (!$ishav) {
            $userinfo = $this->getuserinfo($fromUsername);
            if ($userinfo) {
                $userid = M('Wxuser')->add($userinfo);
                if (!$userid) {
                    return false;
                }
            }else{
                return false;
            }
        }
        $subres = M('Wxmsg')->where(array('msgcon'=>'关注'))->order('msgid DESC')->find();
        $this->msgtype($fromUsername,$toUsername,$time,$subres);
    }
    /*
    * 取消关注事件
    */
    public function unsubscribe($fromUsername,$toUsername,$time){
        $subres = M('Wxmsg')->where(array('msgcon'=>'取消关注'))->order('msgid DESC')->find();
        $this->msgtype($fromUsername,$toUsername,$time,$subres);
    }
    /*
    * 自定义菜单点击事件
    */
    public function clickeven($postObj,$fromUsername,$toUsername,$time){
        $keyword = $postObj->EventKey;
        // 查看是否有输入消息的设置
        $havmsg = M('Wxmsg')->where(array('msgcon'=>(string)$keyword))->find();
        // 根据回复类型进行回复
        $this->msgtype($fromUsername,$toUsername,$time,$havmsg);
    }
}