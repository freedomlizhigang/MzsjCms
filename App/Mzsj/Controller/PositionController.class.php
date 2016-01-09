<?php
namespace Mzsj\Controller;
use Think\Controller;
class PositionController extends MzsjController{
	public function _initialize(){
		parent::_initialize();
	}
	public function index(){
		$page = I('page',1);
		$lists = M('Position')->order('posid DESC')->page($page,20)->select();
		$count = M('Position')->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('page',$show);
		$this->assign('lists',$lists);
		$this->title = "推荐位列表";
		$this->display();
	}
	public function addpos(){
		if (IS_POST) {
			$Pos = D('Position');
			$res = $Pos->create();
			if ($res) {
				$posid = $Pos->add();
				if ($posid) {
					// 更新推荐位缓存
					$this->cache->poscache();
					// 记录用户行为
    				$this->addlog('posid='.$posid);
					$this->success("添加成功",U('index'));
				}else{
					$this->error("添加失败，".$Pos->geterror());
				}
			}else{
				$this->error("添加失败，".$Pos->geterror());
			}
		}else{
			$this->title = "添加推荐位";
			$this->display();
		}
	}
	public function editpos(){
		if (IS_POST) {
			$Pos = D('Position');
			$res = $Pos->create();
			if ($res) {
				$posid = $Pos->save();
				if ($posid) {
					// 更新推荐位缓存
					$this->cache->poscache();
					// 记录用户行为
    				$this->addlog('posid='.$posid);
					$this->success("添加成功",U('index'));
				}else{
					$this->error("添加失败，".$Pos->geterror());
				}
			}else{
				$this->error("添加失败，".$Pos->geterror());
			}
		}else{
			$info = M('Position')->find(I('posid'));
			$this->assign('info',$info);
			$this->title = "添加推荐位";
			$this->display();
		}
	}
	public function delpos(){
		if (I('posid')) {
			$posids = I('posid');
		}elseif(is_array(I('posids'))){
			$posids = implode(',',I('posids'));
		}else{
			$this->error("参数错误！");
		}
		$delres = M('Position')->delete($posids);
		// 更新推荐位缓存
		$this->cache->poscache();
		if ($delres) {
			// 记录用户行为
			$this->addlog('posid='.$posids);
			$this->success("删除成功！");
		}else{
			$this->error('删除失败！');
		}
	}
}
?>