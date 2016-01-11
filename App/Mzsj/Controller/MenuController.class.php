<?php
namespace Mzsj\Controller;
use Think\Controller;
class MenuController extends MzsjController{
	// 菜单列表
	public function index(){
		$tree = $this->list_to_tree('Menu','menuid','parentid',0);
		$tree = num2name($tree,'displayname','display');
		$this->assign('title','菜单列表');
		$this->assign('tree',$tree);
		$this->display();
	}
	// 添加菜单
	public function addmenu(){
		if (IS_POST) {
			$menu = D('Menu');
			$res = $menu->create();
			if($menu->create()){
				$menuid = $menu->add();
				if($menuid){
					// 记录用户行为
            		$this->addlog('menuid='.$menuid);
					$this->success("添加成功！",U('index'));
				}else{
					$this->error("添加失败，".$menu->getError());
				}
			}else{
				$this->error("添加失败，".$menu->getError());
			}
		}else{
			$pid = I('parentid',0);
			$this->assign('pid',$pid);
			$this->assign('title',"添加菜单");
			$this->display();
		}
	}
	// 修改菜单
	public function editmenu(){
		if (IS_POST) {
			$menu = D('Menu');
			$res = $menu->create();
			if($menu->create()){
				$menuid = $menu->save();
				if ($menuid) {
					// 记录用户行为
            		$this->addlog('menuid='.$menuid);
					$this->success("修改成功！",U('index'));
				}else{
					$this->error("修改失败，".$menu->getError());
				}
			}else{
				$this->error("修改失败，".$menu->getError());
			}
		}else{
			$info = M('Menu')->where(array('menuid'=>I('mid')))->find();
			$list = $this->list_to_tree('Menu','menuid','parentid',0,'','','menuid,name');
			$this->assign('list',$list);
			$this->assign('info',$info);
			$this->assign('title',"修改菜单");
			$this->display();
		}
	}
	// 删除菜单
	public function delmenu(){
		if (I('mid')) {
			$res = $this->delChild('Menu','menuid','parentid',I('mid'));
			$del = M('Menu')->delete(I('mid'));
			// 记录用户行为
    		$this->addlog('menuid='.I('mid'));
			$this->success("删除成功");
		}elseif(is_array(I('mids'))){
			foreach (I('mids') as $value) {
				$res = $this->delChild('Menu','menuid','parentid',$value);
				$del = M('Menu')->delete($value);
			}
			// 记录用户行为
    		$this->addlog('menuid='.implode(',',I('mids')));
			$this->success("删除成功");
		}else{
			$this->success("操作错误");
		}
	}
}
?>