<?php
namespace Mzsj\Controller;
use Common\Api\WxApi;
class WxController extends MzsjController{
	public function wxconfig(){
		$wxid = 1;
		if (IS_POST) {
			$wxconfig = D('Wxconfig');
    		$res = $wxconfig->create();
    		if ($res) {
    			$save = $wxconfig->save();
    			if ($save) {
                    $config = M('Wxconfig')->find($wxid);
					S('wxconfigcache',$config);
					S('token',null);
		            // 记录用户行为
                    $this->addlog();
    				$this->success("更新微信设置成功！");
    			}else{
    				$this->error("修改失败,".$wxconfig->getError());
    			}
    		}else{
    			$this->error("修改失败,".$wxconfig->getError());
    		}
		}else{
			$config = M('Wxconfig')->find($wxid);
			S('wxconfigcache',$config);
			$this->assign('wxcon',S('wxconfigcache'));
			$this->title = "微信设置";
			$this->display();
		}
	}
	// 消息回复列表
	public function wxmsg(){
		$page = I('p',1);
		$lists = M('Wxmsg')->order('msgid DESC')->page($page,20)->select();
		$count = M('Wxmsg')->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('page',$show);
		$this->assign('lists',$lists);
		$this->assign('typename',$this->typename());
		$this->title = "消息回复设置";
		$this->display();
	}
	// 消息类型缓存
	private function typename(){
		// 消息类型转文字
		$linkage = M('Wxlinkage')->where(array('parentid'=>1))->field('val,name')->order('listorder ASC')->select();
		$typeval = array();
		foreach ($linkage as $v) {
			$typeval[$v['val']] = $v['name'];
		}
		return $typeval;
	}
	// 添加消息回复
	public function addmsg(){
		if (IS_POST) {
			$wxmsg = D('Wxmsg');
            $res = $wxmsg->create();
            if ($res) {
                $msgid = $wxmsg->add();
                if ($msgid) {
                    // 记录用户行为
                    $this->addlog('msgid='.$msgid);
                    $this->success("添加成功！",U('wxmsg'));
                }else{
                    $this->error("添加失败啊，".$wxmsg->getError());
                }
            }else{
                $this->error("添加失败啊，".$wxmsg->getError());
            }
		}else{
			$this->assign('typelist',$this->typename());
			$this->title = "添加消息回复";
			$this->display();
		}
	}
	// 添加消息回复
	public function editmsg(){
		if (IS_POST) {
			$wxmsg = D('Wxmsg');
            $res = $wxmsg->create();
            if ($res) {
            	$res['content'] = htmlspecialchars_decode($res['content']);
                $msgid = $wxmsg->save($res);
                if ($msgid) {
                    // 记录用户行为
                    $this->addlog('msgid='.$msgid);
                    $this->success("添加成功！",U('wxmsg'));
                }else{
                    $this->error("添加失败啊，".$wxmsg->getError());
                }
            }else{
                $this->error("添加失败啊，".$wxmsg->getError());
            }
		}else{
			$msgid = I('msgid');
			if ($msgid) {
				$info = M('Wxmsg')->find($msgid);
				$this->assign('info',$info);
				$this->assign('typelist',$this->typename());
				$this->title = "添加消息回复";
				$this->display();
			}else{
				$this->error("参数错误！",U('wxmsg'));
			}
		}
	}
	// 删除回复设置
	public function delmsg(){
		if (I('msgid')) {
			$ids = I('msgid');
		}
		if (is_array(I('msgids'))) {
			$ids = implode(',',I('msgids'));
		}
		$res = M('Wxmsg')->delete($ids);
		if ($res) {
			// 记录用户行为
    		$this->addlog('msgid='.$ids);
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
	}
	// 自定义菜单缓存
	private function selfmenucache(){
		if (S('selfmenucache') == ''){
			// 消息类型转$selfmenu文字
			$linkage = M('Wxlinkage')->where(array('parentid'=>14))->field('val,name')->order('listorder ASC')->select();
			$typeval = array();
			foreach ($linkage as $v) {
				$typeval[$v['val']] = $v['name'];
			}
			S('selfmenucache',$typeval);
		}
		return S('selfmenucache');
	}
	// 自定义菜单
	public function menulist(){
		$tree = $this->list_to_tree('Wxmenu','menuid','parentid',0);
		$this->assign('tree',$tree);
		$this->assign('selfmenu',$this->selfmenucache());
		$this->title = "菜单列表";
		$this->display();
	}
	// 添加菜单
	public function addmenu(){
		if (IS_POST) {
			$Wxmenu = D('Wxmenu');
			$pid = I('parentid');
			$count = $Wxmenu->where(array('parentid'=>$pid))->count();
			if ($pid == 0 && $count > 2) {
				$this->error("一级菜单只能添加三个！",U('menulist'));
			}elseif($pid !=0 && $count > 4){
				$this->error("一级菜单只能添加五个！",U('menulist'));
			}
			$res = $Wxmenu->create();
			if($res){
				$res['url'] = I('url','',0);
				$menuid = $Wxmenu->add($res);
				if($menuid){
					session('ADMIN_MENU_LIST',null);
					// 记录用户行为
            		$this->addlog('menuid='.$menuid);
					$this->success("添加成功！",U('menulist'));
				}else{
					$this->error("添加失败，".$Wxmenu->getError());
				}
			}else{
				$this->error("添加失败，".$Wxmenu->getError());
			}
		}else{
			$this->assign('selfmenu',$this->selfmenucache());
			$this->assign('pid',I('parentid',0));
			$this->title = "添加菜单";
			$this->display();
		}
	}
	// 添加菜单
	public function editmenu(){
		if (IS_POST) {
			$Wxmenu = D('Wxmenu');
			$res = $Wxmenu->create();
			if($res){
				$res['url'] = I('url','',0);
				$menuid = $Wxmenu->save($res);
				if($menuid){
					session('ADMIN_MENU_LIST',null);
					// 记录用户行为
            		$this->addlog('menuid='.$menuid);
					$this->success("添加成功！",U('menulist'));
				}else{
					$this->error("添加失败，".$Wxmenu->getError());
				}
			}else{
				$this->error("添加失败，".$Wxmenu->getError());
			}
		}else{
			$info = M('Wxmenu')->where(array('menuid'=>I('mid')))->find();
			$this->assign('info',$info);
			$this->assign('selfmenu',$this->selfmenucache());
			$this->title = "修改菜单";
			$this->display();
		}
	}
	// 删除菜单
	public function delmenu(){
		if (I('mid')) {
			$res = $this->delChild('Wxmenu','menuid','parentid',I('mid'));
			$del = M('Wxmenu')->delete(I('mid'));
			// 记录用户行为
    		$this->addlog('menuid='.I('mid'));
			$this->success("删除成功");
		}else{
			$this->success("操作错误");
		}
	}
	// 更新自定义菜单
    public function updatemenu(){
    	$wxapi = new WxApi();
    	// 取得access_token
        $atoken = $wxapi->gettoken();
        $delurl = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$atoken;
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$atoken;
        $menuarr = M('Wxmenu')->where(array('parentid'=>0))->field('menuid,name,key,type,url')->select();
        foreach ($menuarr as $k => $v) {
        	$subres = M('Wxmenu')->where(array('parentid'=>$v['menuid']))->field('name,key,type,url')->select();
        	if ($subres) {
        		$menuarr[$k]['sub_button'] = $subres;
        	}
        	unset($menuarr[$k]['menuid']);
        }
        $data = '{"button":'.json_encode($menuarr,JSON_UNESCAPED_UNICODE).'}';
        // 向微信发送消息
	 	$del = $wxapi->httpGet($delurl);
	 	$del = json_decode($del,true);
	 	// 向微信发送消息
	 	$result = $wxapi->httpGet($url,$data);
	 	$result = json_decode($result,true);
        if ($del['errmsg'] == 'ok' && $result['errmsg'] == 'ok') {
        	$this->success("更新自定义菜单成功，大概24小时后可以查看，也可以取消关注再关注直接查看更改！");
        }else{
        	$this->error("更新失败！".$del['errcode']."-".$result['errcode']);
        }
    }
    // 清空数据
    public function clearwx(){
    	// M('Wxuser')->where("userid > 0")->delete();
    	$this->success('清空数据成功');
    }
    // 清空缓存
    public function clearcache(){
    	S('token',null);
    	S('tickettime',null);
        S('jsapi_ticket',null);
        echo "清空缓存成功";
    }
    // 微信关联菜单
    public function wxlinkage($pid = ''){
		$pid = I('pid',0);
		$map['parentid'] = $pid;
		$list = M('Wxlinkage')->where($map)->order('listorder DESC')->select();
		$this->assign('lists',$list);
		$this->title = "关联菜单";
		$this->display();
	}
	public function addlinkage($pid = ''){
		if (IS_POST) {
			$LinkAge = D('Wxlinkage');
			$res = $LinkAge->create();
			if ($res) {
				$linkageid = $LinkAge->add();
				if ($linkageid) {
					// 记录用户行为
            		$this->addlog('wxlinkageid='.$linkageid);
					$this->success('添加成功！',U('wxlinkage',array('pid'=>I('parentid'))));
				}else{
					$this->error("添加关联失败，".$LinkAge->geterror());
				}
			}else{
				$this->error("添加关联失败，".$LinkAge->geterror());
			}
		}else{
			$this->assign('parentid',I('pid',0));
			$this->title = "添加关联";
			$this->display();
		}
	}
	public function editlinkage($pid = ''){
		if (IS_POST) {
			$LinkAge = D('Wxlinkage');
			$res = $LinkAge->create();
			if ($res) {
				$linkageid = $LinkAge->save();
				if ($linkageid) {
					// 记录用户行为
            		$this->addlog('wxlinkageid='.$linkageid);
					$this->success('修改成功！',U('wxlinkage',array('pid'=>I('parentid'))));
				}else{
					$this->error("修改关联失败，".$LinkAge->geterror());
				}
			}else{
				$this->error("修改关联失败，".$LinkAge->geterror());
			}
		}else{
			$linkageid = I('linkageid',0);
			$info = M('Wxlinkage')->find($linkageid);
			$this->assign('info',$info);
			$this->title = "修改关联";
			$this->display();
		}
	}
	public function dellinkage(){
		if (I('linkageid')) {
			$linkageid = I('linkageid');
			$res = $this->delchild('Linkage','linkageid','parentid',$linkageid);
			$delid = M('Wxlinkage')->delete($linkageid);
			// 记录用户行为
    		$this->addlog('wxlinkageid='.$linkageid);
			$this->success("删除成功");
		}elseif(is_array(I('linkageids'))){
			foreach (I('linkageids') as $value) {
				$res = $this->delchild('Linkage','linkageid','parentid',$value);
				$delid = M('Wxlinkage')->delete($value);
			}
			// 记录用户行为
    		$this->addlog('wxlinkageid='.implode(',',I('linkageids')));
			$this->success("删除成功！");
		}else{
			$this->error("参数错误啊~~");
		}
	}
}
?>