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
		$lists = M('Wxattr')->order('attid DESC')->page($page,20)->select();
		$count = M('Wxattr')->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('page',$show);
		$lists = num2name($lists,'islocalname','islocal','永久','临时');
		$this->assign('lists',$lists);
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
		$this->assign('title','删除素材');
		$this->display();
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
		$insert = M('Wxattr')->add($data);
		if ($insert) {
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
		$insert = M('Wxattr')->add($data);
		if ($insert) {
			$this->success('添加素材成功！',U('index'));
		}else{
			$this->error('添加素材失败');
		}
	}
	// 上传永久素材到自己服务器
	public function wx_upload(){
		$this->upload->kindupload($size = 10240000,$path = './Upload/wx/',$exts = array('jpg','jpeg','png','amr','mp3','mp4',''));
	}
}