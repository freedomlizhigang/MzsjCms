<?php
/*
 * 微信素材管理类
*/
namespace Mzsj\Controller;
use Common\Api\WxApi;
use Common\Api\Upload;
class WxattrController extends MzsjController{
	public function _initialize(){
		parent::_initialize();
		$this->upload = new Upload();
		$this->wxapi = new WxApi();
	}
	// 管理素材
	public function index()
	{
		$this->assign('title','管理素材');
		$page = I('p') ? I('p') : 1;
		$lists = M('Attr')->order('attid DESC')->where(array('islocal'=>1))->page($page,20)->select();
		$count = M('Attr')->where(array('islocal'=>1))->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('page',$show);
		$lists = num2name($lists,'islocalname','islocal','永久','临时');
		$this->assign('lists',$lists);
		$this->display();
	}
	// 查询微信素材总数，这是个坑有接口使用次数限制极低，小心
	public function attrnums(){
		$this->assign('title','微信素材总数');
		// 查询微信端素材各类型总数
		$access_token = $this->wxapi->gettoken();
		$url = "https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=$access_token";
		$nums = $this->wxapi->httpGet($url);
		$nums = json_decode($nums,true);
		$this->assign('nums',$nums);
		/*// 取微信端素材列表
		$data = array('type'=>'image','offset'=>0,'count'=>20);
		$urls = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$access_token";
		$results = $this->wxapi->httpGet($urls,json_encode($data));
		$results = json_decode($results,true);
		var_dump($results);*/
		$this->display();
	}
	// 新增素材
	public function addattr()
	{
		$this->assign('title','新增素材');
		if (IS_POST) {
			if (I('type') == null || I('image') == null){$this->error('请先选择类型或上传素材！');}
			if (I('type') == 'image' || I('type') == 'voice' || I('type') == 'thumb') {
				$this->uploadimg(I('type'),I('image'));
			}
			if (I('type') == 'video') {
				$this->uploadvideo(I('type'),I('image'),I('v'));
			}
		}else{
			$this->display();
		}
	}
	// 删除素材
	public function delattr()
	{
		$attid = I('attid');
		$hav = M('Attr')->where(array('attid'=>$attid))->find();
		if ($hav) {
			// 微信端删除操作
			$access_token = $this->wxapi->gettoken();
			$filedata = array('media_id'=>$hav['media_id']);
			$url = "https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$access_token";
			$result = $this->wxapi->httpGet($url,json_encode($filedata));
			$result = json_decode($result,true);
			if ($result['errcode'] != 0) {$this->error('删除素材失败，'.$result['errcode'].$result['errmsg']);}
			// 本地文件删除
			$filepath = SERVER_PATH.$hav['localurl'];
			if (file_exists($filepath)){unlink($filepath);}
			M('Attr')->delete($attid);
			// 记录用户行为
    		$this->addlog('attid='.$attid);
			$this->success('删除素材成功！');
		}else{
			$this->error('没有找到素材！');
		}
	}
	/*
	* 上传永久素材，图片，大小1M，格式jpg/png，数量5000张
	*/
	public function uploadimg($type,$path){
		$access_token = $this->wxapi->gettoken();
		$filepath = SERVER_PATH.$path;
		$filedata = array('media'=>"@".$filepath);
		$url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$access_token&type=$type";
		$result = $this->wxapi->httpGet($url,$filedata);
		$result = json_decode($result,true);
		// 存入本地数据库
		$data['type'] = $type;
		$data['localurl'] = $path;
		$data['inputtime'] = time();
		$data['islocal'] = 1;
		$data['media_id'] = $result['media_id'];
		$data['url'] = $result['url'];
		$insert = M('Attr')->add($data);
		if ($insert) {
			// 记录用户行为
    		$this->addlog('attid='.$attid);
			$this->success('添加素材成功！',U('index'));
		}else{
			$this->error('添加素材失败');
		}
	}
	/*
	* 上传永久素材，视频，大小10M，格式MP4,1000个
	*/
	public function uploadvideo($type,$path,$des){
		$access_token = $this->wxapi->gettoken();
		$filepath = SERVER_PATH.$path;
		$description = '{
							"title":"'.$des['title'].'",
							"introduction":"'.$des['introduction'].'"
						}';
		$filedata = array('media'=>"@".$filepath,'description'=>$description);
		$url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$access_token&type=$type";
		$result = $this->wxapi->httpGet($url,$filedata);
		$result = json_decode($result,true);
		if (!$result['media_id']) {
			$this->error('添加素材失败'.$result['errcode'].'  '.$result['errmsg']);
		}
		// 存入本地数据库
		$data['type'] = $type;
		$data['localurl'] = $path;
		$data['inputtime'] = time();
		$data['islocal'] = 1;
		$data['media_id'] = $result['media_id'];
		$insert = M('Attr')->add($data);
		if ($insert) {
			// 记录用户行为
    		$this->addlog('attid='.$attid);
			$this->success('添加素材成功！',U('index'));
		}else{
			$this->error('添加素材失败');
		}
	}
	// 上传永久素材到自己服务器
	public function wx_upload(){
		$upres = $this->upload->kindupload($size = 10240000,$path = './Upload/wx/',$exts = array('jpg','jpeg','png','amr','mp3','mp4'));
		exit($upres);
	}

	/*
	* 管理图文消息
	*/
	public function artmsg()
	{
		$this->assign('title','图文素材');
		$page = I('p') ? I('p') : 1;
		$lists = M('Wxart')->order('artid DESC')->page($page,20)->select();
		$count = M('Wxart')->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('page',$show);
		$this->assign('lists',$lists);
		$this->display();
	}
	/*
	* 新增图文素材
	*/
	public function addart()
	{
		$this->assign('title','添加图文素材');
		if (IS_POST)
		{
			$data = I('post.art');
			// 拼接数据
			$str = '{"articles":[';
			foreach ($data as $v) {
				$str .= json_encode($v,JSON_UNESCAPED_UNICODE).',';
			}
			$str .= ']}';
			// 存入微信端
			$token = $this->wxapi->gettoken();
			$url = "https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=$token";
			$res = string2array($this->wxapi->httpGet($url,$str));
			if($res['media_id'] == null){$this->error('添加图文素材失败！');}
			// 存入本地
			$l['media_id'] = $res['media_id'];
			$l['created_at'] = time();
			$l['title'] = I('post.title');
			$l['content'] = array2string(I('post.art'));
			if (M('Wxart')->add($l))
			{
				// 记录用户行为
    			$this->addlog('artid='.$attid);
				$this->success('添加图文素材成功！',U('artmsg'));
			}
			else
			{
				$this->error('添加图文素材失败！');
			}
		}
		else
		{
			$this->display();
		}
	}
	/*
	* 修改图文素材
	*/
	public function editart()
	{
		$this->assign('title','修改图文素材');
		if (IS_POST)
		{
			$data = I('post.art');
			// 更新微信端，因为不确定要更新的是哪个图文，所以全部更新一遍
			$token = $this->wxapi->gettoken();
			$url = "https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=$token";
			foreach ($data as $k => $v) {
				$k -= 1;
				$pd = json_encode(array('media_id'=>I('post.media_id'),'index'=>$k,'articles'=>$v),JSON_UNESCAPED_UNICODE);
				$res = string2array($this->wxapi->httpGet($url,$pd));
				if($res['errcode'] != 0){$this->error('修改微信图文素材失败！'.$res['errcode'].' - '.$res['errmsg']);}
			}
			// 更新本地
			$l['artid'] = I('post.artid');
			$l['title'] = I('post.title');
			$l['content'] = array2string(I('post.art'));
			if (M('Wxart')->save($l))
			{
				// 记录用户行为
    			$this->addlog('artid='.$attid);
				$this->success('修改图文素材成功！',U('artmsg'));
			}
			else
			{
				$this->error('修改图文素材失败！');
			}
		}
		else
		{
			$artid = I('artid');
			$hav = M('Wxart')->where(array('artid'=>$artid))->find();
			$hav['content'] = string2array($hav['content']);
			$this->assign('info',$hav);
			$this->display();
		}
	}
	/*
	* 删除图文素材
	*/
	public function delart()
	{
		$artid = I('artid');
		$hav = M('Wxart')->where(array('artid'=>$artid))->find();
		if ($hav) {
			// 微信端删除操作
			$access_token = $this->wxapi->gettoken();
			$filedata = array('media_id'=>$hav['media_id']);
			$url = "https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$access_token";
			$result = $this->wxapi->httpGet($url,json_encode($filedata));
			$result = json_decode($result,true);
			if ($result['errcode'] != 0) {$this->error('删除素材失败，'.$result['errcode'].$result['errmsg']);}
			// 本地文件删除
			M('Wxart')->delete($artid);
			// 记录用户行为
    		$this->addlog('artid='.$attid);
			$this->success('删除素材成功！');
		}else{
			$this->error('没有找到素材！');
		}
	}
}