<?php
namespace Mzsj\Controller;
class TypeController extends MzsjController {
	public function _initialize(){
		parent::_initialize();
	}
	public function index(){
		$tree = $this->list_to_tree('Type','typeid','parentid',0);
		$tree = num2name($tree,'displayname','display');
		$this->assign('tree',$tree);
		$this->title = "类别管理";
		$this->display();
	}
	// 添加类别
	public function addtype(){
		if (IS_POST) {
			$type = D('Type');
			if($type->create()){
				$tid = $type->add();
				if($tid){
					// 更新缓存
					$this->cache->typecache();
					// 记录用户行为
            		$this->addlog('typeid='.$tid);
					$this->success("添加成功！",U('index'));
				}else{
					$this->error("添加失败，".$type->getError());
				}
			}else{
				$this->error("添加失败，".$type->getError());
			}
		}else{
			$pid = I('parentid',0);
			$this->assign('pid',$pid);
			$this->assign('title',"添加类别");
			$this->display();
		}
	}
	// 修改类别
	public function edittype(){
		if (IS_POST) {
			$type = D('Type');
			if($type->create()){
				$typeid = $type->save();
				if ($typeid) {
					// 更新缓存
					$this->cache->typecache();
					// 记录用户行为
            		$this->addlog('typeid='.$typeid);
					$this->success("修改成功！",U('index'));
				}else{
					$this->error("修改失败，".$type->getError());
				}
			}else{
				$this->error("修改失败，".$type->getError());
			}
		}else{
			$info = M('Type')->where(array('typeid'=>I('tid')))->find();
			$list = $this->list_to_tree('Type','typeid','parentid',0,' ','typeid,typename,level');
			$this->assign('list',$list);
			$this->assign('info',$info);
			$this->assign('title',"修改菜单");
			$this->display();
		}
	}
	// 删除类别
	public function deltype(){
		if (I('tid')) {
			$res = $this->delChild('Type','typeid','parentid',I('tid'));
			$del = M('Type')->delete(I('tid'));
			// 更新缓存
			$this->cache->typecache();
			// 记录用户行为
    		$this->addlog('typeid='.I('tid'));
			$this->success("删除成功");
		}elseif(is_array(I('tids'))){
			foreach (I('tids') as $value) {
				$res = $this->delChild('Type','typeid','parentid',$value);
				$del = M('Type')->delete($value);
			}
			// 更新缓存
			$this->cache->typecache();
			// 记录用户行为
    		$this->addlog('typeid='.implode(',',I('tids')));
			$this->success("删除成功");
		}else{
			$this->success("操作错误");
		}
	}
}
?>