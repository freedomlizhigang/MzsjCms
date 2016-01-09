<?php
namespace Mzsj\Controller;
class GroupController extends MzsjController{
	public function _initialize(){
		parent::_initialize();
	}
	public function index(){
		$page = I('p',1);
		$res = M('Group')->page($page,20)->select();
		$count = M('Group')->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('pages',$show);
		$res = $this->statusname($res);
		$this->assign('list',$res);
		$this->title = "用户组管理";
		$this->display();
	}
	public function addgroup(){
		if(IS_POST){
			$Group = D('Group');
			$res = $Group->create();
			if ($res) {
				$groupid = $Group->add();
				if ($groupid) {
					// 更新用户缓存
					$this->cache->groupcache();
					// 添加操作日志
					$this->addlog('groupid='.$groupid);
					$this->success("添加成功",U('index'));
				}else{
					$this->error("添加失败，".$Group->geterror());
				}
			}else{
				$this->error("添加失败，".$Group->geterror());
			}
		}else{
			$this->title = "添加用户组";
			$this->display();
		}
	}
	public function editgroup(){
		if(IS_POST){
			$Group = D('Group');
			$res = $Group->create();
			if ($res) {
				$groupid = $Group->save();
				if ($groupid) {
					// 更新用户缓存
					$this->cache->groupcache();
					// 添加操作日志
					$this->addlog('groupid='.$groupid);
					$this->success("修改成功",U('index'));
				}else{
					$this->error("修改失败，".$Group->geterror());
				}
			}else{
				$this->error("修改失败，".$Group->geterror());
			}
		}else{
			$info = M('Group')->find(I('groupid'));
			$this->assign('info',$info);
			$this->title = "添加用户组";
			$this->display();
		}
	}
	public function delgroup(){
		if (I('groupid')) {
			$this->checkuser(I('groupid'));
			$groupids = I('groupid');
		}elseif(is_array(I('groupids'))){
			foreach (I('groupids') as $gid) {
				$this->checkuser($gid);
			}
			$groupids = implode(',',I('groupids'));
		}else{
			$this->error("参数错误！");
		}
		$dels = M('Group')->delete($groupids);
		if ($dels) {
			// 更新用户缓存
			$this->cache->groupcache();
			// 添加操作日志
			$this->addlog('groupid='.$dels);
			$this->success("删除成功！");
		}else{
			$this->error("删除失败！");
		}
	}
	// 检查是否含有用户
	private function checkuser($gid){
		$res = M('User')->where(array('groupid'=>$gid))->select();
		if ($res) {
			$this->error("组里还有用户，请先把用户转移到其他组中！");
		}else{
			return true;
		}
	}
	// 更新用户组权限
	public function grouppriv(){
		if (IS_POST) {
			$groupid = I('groupid');
			$menuids = I('menuids');
			$maps['menuid'] = array('in',$menuids);
			$menulist = M('UserMenu')->where($maps)->field('menuid,module,controller,action,data')->select();
			$addArr = array();
			foreach ($menulist as $v) {
				$addArr[] = array('groupid'=>$groupid,'menuid'=>$v['menuid'],'module'=>$v['module'],'controller'=>$v['controller'],'action'=>$v['action'],'data'=>$v['data']);
			}
			$delres = M('UserPriv')->where(array('groupid'=>$groupid))->delete();
			$addres = M('UserPriv')->addAll($addArr);
			if ($addres) {
				// 记录用户行为
        		$this->addlog('groupid='.$groupid);
				$this->success("更新权限成功！",U('index'));
			}else{
				$this->error("更新权限失败！");
			}
		}else{
			if (I('groupid') != '' && I('groupid') != 0) {
				$privlist = M('UserPriv')->where(array('groupid'=>I('groupid')))->field('menuid')->select();
				$menuids = '';
				foreach ($privlist as $value) {
					$menuids .= "'".$value['menuid']."',";
				}
				$menuids = trim($menuids,',');
				$this->assign('menuids',$menuids);
				$tree = $this->list_to_tree('UserMenu','menuid','parentid',0);
				$this->assign('tree',$tree);
				$this->title = "更改用户权限";
				$this->assign('groupid',I('groupid'));
				$this->display();
			}else{
				$this->error("参数错误！",U('index'));
			}
		}
	}
}
?>