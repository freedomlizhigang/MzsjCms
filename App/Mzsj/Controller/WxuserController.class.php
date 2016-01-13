<?php
/*
 * 微信用户组管理类
*/
namespace Mzsj\Controller;
use Common\Api\WxApi;
class WxuserController extends MzsjController
{
	public function _initialize()
	{
		parent::_initialize();
		$this->wxapi = new WxApi();
	}
	// 微信用户列表
	public function index()
	{
		$page = I('p',1);
		$lists = M('Wxuser')->order('userid DESC')->page($page,20)->select();
		$count = M('Wxuser')->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('page',$show);
		$this->assign('lists',$lists);
		$this->title = "用户列表";
		// 用户组缓存
		$this->assign('groupname',S('wxgroupcache'));
		$this->display();
	}
	// 获取微信端用户列表
	public function updateuser()
	{
		// 取所有openid
		$resopenid = $this->getlist();
		// 指拉取用户信息
		$gettoken = $this->wxapi->gettoken();
		$urls = "https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=$gettoken";
		$alldata = array();
		// 关注者多于100时，循环出所有人信息，微信规定每次拉取不得多于100人
		if (count($resopenid) > 100) {
			// 每100个请求一次用户数据
			for($i = 0; $i <= count($resopenid) - 100; $i += 100)
			{
				$alldata = $this->getuserinfo($urls,$resopenid,$alldata,$i);
			}
		}
		else
		{
			$alldata = $this->getuserinfo($urls,$resopenid,$alldata,$i = count($resopenid),$isfor = 0);
		}
		
		// 先清空数据库，然后将所有取得的数据放入数据库中
		M('Wxuser')->where('1')->delete();
		if (M('Wxuser')->addAll($alldata))
		{
			// 记录用户行为
    		$this->addlog();
			$this->success('操作完成！',U('index'));
		}
		else
		{
			$this->error('操作失败！',U('index'));
		}
	}
	/*
	* 设置用户备注信息
	*/
	public function remark()
	{
		$this->assign('title','设置备注');
		$userid = I('uid');
		if (IS_POST)
		{
			// 更新微信端数据
			$wxdata = json_encode(array('openid'=>I('post.openid'),'remark'=>I('post.remark')),JSON_UNESCAPED_UNICODE);
			$token = $this->wxapi->gettoken();
			$url = "https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=$token";
			$res = string2array($this->wxapi->httpGet($url,$wxdata));
			if ($res['errcode'] != 0) {$this->error('设置微信备注失败，'.$res['errcode'].'-'.$res['errmsg']);}
			// 更新本地数据
			$data['userid'] = I('post.userid');
			$data['remark'] = I('post.remark');
			if (M('Wxuser')->save($data)){
				// 记录用户行为
        		$this->addlog('userid='.$userid);
				$this->success('设置备注成功！',U('index'));
			}
			else
			{
				$this->error('设置备注失败 ！');
			}
		}
		else
		{
			$uinfo = M('Wxuser')->field('openid,remark,userid')->find($userid);
			$this->assign('uinfo',$uinfo);
			$this->display();
		}
	}
	/*
	* 批量移动用户分组
	*/
	public function togroup()
	{
		// 判断
		if(I('post.groupid') == null) {$this->error('请选择分组');}
		// 查出openid
		$map['userid'] = array('in',arr2str(I('post.uids')));
		$opids = M('Wxuser')->where($map)->getField('openid',true);
		// 更新微信端
		$data = json_encode(array('openid_list'=>$opids,'to_groupid'=>I('post.groupid')));
		$token = $this->wxapi->gettoken();
		$url = "https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate?access_token=$token";
		$res = string2array($this->wxapi->httpGet($url,$data));
		if ($res['errcode'] != 0){$this->error('移动用户失败，'.$res['errcode'].'-'.$res['errmsg']);}
		// 更新本地
		if (M('Wxuser')->where($map)->save(array('groupid'=>I('post.groupid'))))
		{
			// 记录用户行为
    		$this->addlog('userid='.arr2str(I('post.uids')));
			$this->error('移动用户成功',U('index'));
		}
		else
		{
			$this->error('移动用户失败');
		}
	}
	/*
	* 批量拉取用户信息方法
	*/
	private function getuserinfo($urls,$resopenid,$alldata,$i = 0,$isfor = 1)
	{
		$data = array();
		// 100个openid
		if($isfor == 0)
		{
			for($j = 0; $j < $i; $j++)
			{
				$data[] = array('openid'=>$resopenid[$j],'lang'=>"zh-CN");
			}
		}
		else
		{
			for($j = $i; $j < $i + 100; $j++)
			{
				$data[] = array('openid'=>$resopenid[$i],'lang'=>"zh-CN");
			}
		}
		$data = json_encode(array('user_list'=>$data));
		$alldata = array_merge(string2array($this->wxapi->httpGet($urls,$data))['user_info_list'],$alldata);
		return $alldata;
	}
	// 获取所有 openid方法
	private function getlist($next = '',$datas = array())
	{
		$token = $this->wxapi->gettoken();
		$url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$token&next_openid=$next";
		$res = string2array($this->wxapi->httpGet($url));
		$datas = array_merge($res['data']['openid'],$datas);
		// 当拉取到的数据大于10000时，循环拉取所有
		if ($res['count'] >= 10000) {
			$this->getlist($res['next_openid'],$datas);
		}
		return $datas;
	}
}