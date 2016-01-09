<?php
namespace Mzsj\Controller;
use Think\Controller;
class UserMenuController extends MzsjController{
	public function index(){
		$tree = $this->list_to_tree('UserMenu','menuid','parentid',0);
		$tree = $this->displayname($tree,'displayname','display');
		$this->assign('tree',$tree);
		$this->title = "用户菜单";
		$this->display();
	}
	public function addusermenu(){
		if (IS_POST) {
			$UserMenu = D('UserMenu');
			$res = $UserMenu->create();
			if ($res) {
				$menuid = $UserMenu->add();
				if ($menuid) {
					$this->addlog('menuid='.$menuid);
					$this->success("添加用户菜单成功！",U('index'));
				}else{
					$this->error("添加用户菜单失败，".$UserMenu->geterror());
				}
			}else{
				$this->error("添加用户菜单失败，".$UserMenu->geterror());
			}
		}else{
			$pid = I('parentid',0);
			if($pid == 0){
				$this->assign('level',1);
			}else{
				$level = M('UserMenu')->where(array('menuid'=>$pid))->getField('level');
				$level += 1;
				$this->assign('level',$level);
			}
			$this->assign('pid',$pid);
			$this->title = "添加用户菜单";
			$this->display();
		}
	}
	public function editusermenu(){
		if (IS_POST) {
			$UserMenu = D('UserMenu');
			$res = $UserMenu->create();
			if ($res) {
				$menuid = $UserMenu->save();
				if ($menuid) {
					$this->addlog('menuid='.$menuid);
					$this->success("修改用户菜单成功！",U('index'));
				}else{
					$this->error("修改用户菜单失败，".$UserMenu->geterror());
				}
			}else{
				$this->error("修改用户菜单失败，".$UserMenu->geterror());
			}
		}else{
			$tree = $this->list_to_tree('UserMenu','menuid','parentid',0,' ','menuid,name,level');
			$this->assign('list',$tree);
			$info = M('UserMenu')->find(I('mid'));
			$this->assign('info',$info);
			$this->title = "添加用户菜单";
			$this->display();
		}
	}
	public function delusermenu(){
		if (I('mid')) {
			$res = $this->delChild('UserMenu','menuid','parentid',I('mid'));
			$isdel = M('UserMenu')->delete(I('mid'));
			$this->addlog('menuid='.I('mid'));
			$this->success("删除成功");
		}elseif(is_array(I('mids'))){
			foreach (I('mids') as $value) {
				$res = $this->delChild('UserMenu','menuid','parentid',$value);
				$del = M('UserMenu')->delete($value);
			}
			$this->addlog('menuid='.implode(',',I('mids')));
			$this->success("删除成功");
		}else{
			$this->success("操作错误");
		}
	}
}
?>