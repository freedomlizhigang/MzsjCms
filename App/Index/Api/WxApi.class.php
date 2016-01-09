<?php
namespace Index\Api;
// 微信的api，主要是分享部分
class WxApi {
	// 分享参数
	public function share(){
		$jsapiTicket = $this->getJsApiTicket();
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = 'jsapi_ticket='.$jsapiTicket.'&noncestr='.$nonceStr.'&timestamp='.$timestamp.'&url='.$url;
        $signature = sha1($string);
        $wxconfig = S('wxconfigcache');
        $appid = $wxconfig['appid'];
        $signPackage = array(
          "appId"     => $appid,
          "nonceStr"  => $nonceStr,
          "timestamp" => $timestamp,
          "url"       => $url,
          "signature" => $signature,
          "rawString" => $string
        );
        return $signPackage;
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
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
          $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    // 取得微信JS接口的临时票据
    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        if (time() - S('tickettime') > 7000) {
          	$accessToken = $this->gettoken();
          	// 如果是企业号用以下 URL 获取 ticket
          	// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
          	$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token='.$accessToken;
        	$res = json_decode($this->httpGet($url));
          	$ticket = $res->ticket;
	        S('tickettime',time());
	        S('jsapi_ticket',$ticket);
        } else {
          $ticket = S('jsapi_ticket');
        }
        return $ticket;
    }
    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
}
?>