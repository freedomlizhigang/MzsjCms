<?php
/*
 * 微信用户组管理类
*/
namespace Mzsj\Controller;
use Common\Api\WxApi;
class WxgroupController extends MzsjController
{
	public function _initialize()
	{
		parent::_initialize();
		$this->wxapi = new WxApi();
	}
	/*
	* 获取所有分组信息
	*/
	public function index()
	{
		$this->assign('title','所有分组');
		$page = I('p') ? I('p') : 1;
		$lists = M('Wxgroup')->order('id ASC')->page($page,20)->select();
		$count = M('Wxgroup')->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('page',$show);
		$this->assign('lists',$lists);
		$this->display();
	}
	/*
	* 同步用户分组
	*/
	public function updategroup()
	{
		$token = $this->wxapi->gettoken();
		$url = "https://api.weixin.qq.com/cgi-bin/groups/get?access_token=$token";
		// 返回的是json，解码后是对象，要循环成数组输出
		$res = string2array($this->wxapi->httpGet($url))['groups'];
		// 清空组信息
		M('Wxgroup')->where('1')->delete();
		// 批量写入信息
		if(M('Wxgroup')->addAll($res))
		{
			// 缓存
			$this->cache->wxgroupcache();
			// 记录用户行为
    		$this->addlog();
			$this->success('同步成功！');
		}
		else
		{
			$this->error('同步失败！');
		}
	}
	/*
	* 创建新的分组
	*/
	public function addgroup()
	{
		if (IS_POST)
		{
			// 更新微信服务器端
			$token = $this->wxapi->gettoken();
			$url = "https://api.weixin.qq.com/cgi-bin/groups/create?access_token=$token";
			$data = array('group'=>array('name'=>I('post.name')));
			// 注意json中文
			$res = string2array($this->wxapi->httpGet($url,json_encode($data,JSON_UNESCAPED_UNICODE)));
			if ($res['errcode'] != 0) {$this->error('创建分组失败，'.$res['errcode'].'-'.$res['errmsg']);}
			// 更新本地数据库
			if (M('Wxgroup')->add(array('id'=>$res['group']['id'],'name'=>I('post.name')))){
				// 缓存
				$this->cache->wxgroupcache();
				// 记录用户行为
        		$this->addlog('id='.$id);
				$this->success('创建分组成功！',U('index'));
			}
			else
			{
				$this->error('创建分组失败 ！');
			}
		}
		else
		{
			$this->assign('title','创建分组');
			$this->display();
		}
	}
	/*
	* 修改用户分组信息
	*/
	public function editgroup()
	{
		$id = I('id');
		if (IS_POST)
		{
			// 更新微信服务器端
			$token = $this->wxapi->gettoken();
			$url = "https://api.weixin.qq.com/cgi-bin/groups/update?access_token=$token";
			$data = array('group'=>array('id'=>I('post.id'),'name'=>I('post.name')));
			// 注意json中文
			$res = string2array($this->wxapi->httpGet($url,json_encode($data,JSON_UNESCAPED_UNICODE)));
			if ($res['errcode'] != 0) {$this->error('更改分组名称失败，'.$res['errcode'].'-'.$res['errmsg']);}
			// 更新本地数据库
			if (M('Wxgroup')->save(array('id'=>I('post.id'),'name'=>I('post.name')))){
				// 缓存
				$this->cache->wxgroupcache();
				// 记录用户行为
        		$this->addlog('id='.$id);
				$this->success('更改分组名称成功！',U('index'));
			}
			else
			{
				$this->error('更改分组名称失败 ！');
			}
		}
		else
		{
			$this->assign('title','修改分组名称');
			$info = M('Wxgroup')->find($id);
			$this->assign('info',$info);
			$this->display();
		}
	}
	/*
	* 删除用户分组
	*/
	public function delgroup()
	{
		$id = I('get.id');
		$token = $this->wxapi->gettoken();
		$url = "https://api.weixin.qq.com/cgi-bin/groups/delete?access_token=$token";
		// 返回的是json，解码后是对象，要循环成数组输出
		$data = array('group'=>array('id'=>$id));
		$res = string2array($this->wxapi->httpGet($url,json_encode($data)));
		if ($res['errcode'] != 0) {$this->error('删除分组失败，'.$res['errcode'].'-'.$res['errmsg']);}
		// 更新本地数据库
		if (M('Wxgroup')->delete($id)){
			// 缓存
			$this->cache->wxgroupcache();
			// 记录用户行为
    		$this->addlog('id='.$id);
			$this->success('删除分组成功！');
		}
		else
		{
			$this->error('删除分组失败 ！');
		}
	}
}