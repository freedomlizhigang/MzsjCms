<?php
namespace Mzsj\Controller;
use Think\Controller;
class AdminController extends MzsjController {
	public function _initialize(){
		parent::_initialize();
	}
	// 用户首页
	public function index(){
		$page = I('p') ? I('p') : 1;
		$lists = M('Admin')->order('adminid ASC')->page($page,20)->select();
		$count = M('Admin')->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('page',$show);
		$lists = $this->statusname($lists);
		$this->assign('lists',$lists);
		// 将角色缓存存入数组
		$rolelist = S('rolecache');
		$temparr = array();
		foreach ($rolelist as $key => $value) {
			$temparr[$value['roleid']] = $value['rolename'];
		}
		$this->assign('rolename',$temparr);
		$this->title = "用户首页";
		$this->display();
	}
	// 添加用户
	public function addadmin(){
		if (IS_POST) {
			$admin = D('Admin');
			$res = $admin->create();
			if ($res) {
				$adminid = $admin->add();
				if ($adminid) {
					// 更新用户数据缓存
					$this->cache->admincache();
					// 记录用户行为
            		$this->addlog('adminid='.$adminid);
					$this->success("添加用户成功！",U('index'));
				}else{
					$this->error("添加失败，".$admin->getError());
				}
			}else{
				$this->error("添加失败，".$admin->getError());
			}
		}else{
			// 用户组列表
			$rolelist = S('rolecache');
			$this->assign('rolelist',$rolelist);
			$this->title = "添加用户";
			$this->display();
		}
	}
	// 修改用户信息
	public function editadmin(){
		if (IS_POST) {
			$admin = D('Admin');
			$res = $admin->create();
			if ($res) {
				$res['realname'] = trim($res['realname']);
				$adminid = $admin->save($res);
				if ($adminid) {
					// 更新用户数据缓存
					$this->cache->admincache();
					// 记录用户行为
            		$this->addlog('adminid='.$adminid);
					$this->success("用户资料修改成功！",U('index'));
				}else{
					$this->error("修改失败，".$admin->getError());
				}
			}else{
				$this->error("修改失败，".$admin->getError());
			}
		}else{
			$aid = I('adminid');
			$info = M('Admin')->find($aid);
			// 用户组列表
			$rolelist = S('rolecache');
			$this->assign('rolelist',$rolelist);
			$this->assign('info',$info);
			$this->title = "修改用户资料";
			$this->display();
		}
	}
	// 修改密码
	public function editpassword(){
		if (IS_POST) {
			$admin = D('Admin');
			$res = $admin->create();
			if ($res) {
				$adminid = $admin->save();
				if ($adminid) {
					// 记录用户行为
            		$this->addlog('adminid='.$adminid);
					$this->success("修改密码成功！",U('index'));
				}else{
					$this->error("修改失败，".$admin->getError());
				}
			}else{
				$this->error("修改失败，".$admin->getError());
			}
		}else{
			$this->assign('encrypt',create_randomstr(6));
			$this->title = "修改密码";
			$this->display();
		}
	}
	// 删除用户
	public function deladmin(){
		if (I('adminid')) {
			$ids = I('adminid');
		}
		if (is_array(I('adminids'))) {
			$ids = implode(',',I('adminids'));
		}
		$res = M('Admin')->delete($ids);
		if ($res) {
			// 更新用户数据缓存
			$this->cache->admincache();
			// 记录用户行为
    		$this->addlog('adminid='.$ids);
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
	}
	// 角色列表
	public function rolelist(){
		$page = I('page') ? I('page') : 1;
		$lists = M('Role')->order('roleid ASC')->page($page,20)->select();
		$count = M('Role')->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('page',$show);
		$lists = $this->statusname($lists);
		$this->assign('lists',$lists);
		$this->title = "角色列表";
		$this->display();
	}
	// 添加角色
	public function addrole(){
		if (IS_POST) {
			$role = D('Role');
			$res = $role->create();
			if ($res) {
				$roleid = $role->add();
				if ($roleid) {
					// 更新角色缓存
					$this->cache->rolecache();
					// 记录用户行为
            		$this->addlog('roleid='.$roleid);
					$this->success("角色添加成功！",U('rolelist'));
				}else{
					$this->error("添加失败，".$role->getError());
				}
			}else{
				$this->error("添加失败，".$role->getError());
			}
		}else{
			$this->title = "添加角色";
			$this->display();
		}
	}
	// 修改角色
	public function editrole(){
		if (IS_POST) {
			$role = D('Role');
			$res = $role->create();
			if ($res) {
				$roleid = $role->save();
				if ($roleid) {
					// 更新角色缓存
					$this->cache->rolecache();
					// 记录用户行为
            		$this->addlog('roleid='.$roleid);
					$this->success("角色修改成功！",U('rolelist'));
				}else{
					$this->error("修改失败，".$role->getError());
				}
			}else{
				$this->error("修改失败，".$role->getError());
			}
		}else{
			$info = M('Role')->where(array('roleid'=>I('roleid')))->find();
			$this->assign('info',$info);
			$this->title = "修改角色";
			$this->display();
		}
	}
	// 删除角色
	public function delrole(){
		if (I('roleid')) {
			$ids = I('roleid');
			$this->roleisnull($ids);
		}
		if (is_array(I('roleids'))) {
			foreach (I('roleids') as $key => $value) {
				$this->roleisnull($value);
			}
			$ids = implode(',',I('roleids'));
		}
		$res = M('Role')->delete($ids);
		if ($res) {
			// 更新角色缓存
			$this->cache->rolecache();
			// 记录用户行为
    		$this->addlog('roleid='.$ids);
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
	}
	// 用户组权限管理
	public function adminpriv(){
		if (IS_POST) {
			$rid = I('roleid');
			if (empty($rid)) $this->error("请选择用户组！");
			$urls = I('urls');
			$urls = array_unique($urls);
			$addArr = array();
			foreach ($urls as $value) {
				$addArr[] = array('roleid'=>$rid,'url'=>$value);
			}
			$delres = M('AdminPriv')->where(array('roleid'=>$rid))->delete();
			$addres = M('AdminPriv')->addAll($addArr);
			if ($addres) {
				// 记录用户行为
        		$this->addlog('roleid='.$rid);
				$this->success("更新权限成功！",U('rolelist'));
			}else{
				$this->error("更新权限失败！");
			}
		}else{
			$tree = $this->list_to_tree('Menu','menuid','parentid',0);
			$this->assign('tree',$tree);
			$privlist = M('AdminPriv')->where(array('roleid'=>I('roleid')))->field('url')->select();
			$privstr = '';
			foreach ($privlist as $value) {
				$privstr .= "'".$value['url']."',";
			}
			$privstr = trim($privstr,',');
			$this->assign('privstr',$privstr);
			$rolename = M('Role')->where(array('roleid'=>I('roleid')))->getfield('rolename');
			$this->title = $rolename." 组授权";
			$this->display();
		}
	}
	// 检查组下是否有用户
	private function roleisnull($rid){
		$res = M('Admin')->where(array('roleid'=>$rid))->find();
		if ($res) {
			$this->error("请检查是否组下都没有用户！");
		}else{
			return true;
		}
	}
}
?>