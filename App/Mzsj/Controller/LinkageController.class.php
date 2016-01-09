<?php
namespace Mzsj\Controller;
use Think\Controller;
class LinkageController extends MzsjController{
	public function index($pid = ''){
		$pid = I('pid',0);
		$map['parentid'] = $pid;
		$list = M('Linkage')->where($map)->order('listorder DESC')->select();
		$this->assign('lists',$list);
		$this->assign('pid',$pid);
		$this->title = "关联菜单";
		$this->display();
	}
	public function addlinkage($pid = ''){
		if (IS_POST) {
			$LinkAge = D('Linkage');
			$res = $LinkAge->create();
			if ($res) {
				$linkageid = $LinkAge->add();
				if ($linkageid) {
					// 记录用户行为
            		$this->addlog('linkageid='.$linkageid);
					$this->success('添加成功！',U('index',array('pid'=>I('parentid'))));
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
			$LinkAge = D('Linkage');
			$res = $LinkAge->create();
			if ($res) {
				$linkageid = $LinkAge->save();
				if ($linkageid) {
					// 记录用户行为
            		$this->addlog('linkageid='.$linkageid);
					$this->success('添加成功！',U('index',array('pid'=>I('parentid'))));
				}else{
					$this->error("添加关联失败，".$LinkAge->geterror());
				}
			}else{
				$this->error("添加关联失败，".$LinkAge->geterror());
			}
		}else{
			$linkageid = I('linkageid',0);
			$info = M('Linkage')->find($linkageid);
			$this->assign('info',$info);
			$this->title = "修改关联";
			$this->display();
		}
	}
	public function dellinkage(){
		if (I('linkageid')) {
			$linkageid = I('linkageid');
			$res = $this->delchild('Linkage','linkageid','parentid',$linkageid);
			$delid = M('Linkage')->delete($linkageid);
			// 记录用户行为
    		$this->addlog('linkageid='.$linkageid);
			$this->success("删除成功");
		}elseif(is_array(I('linkageids'))){
			foreach (I('linkageids') as $value) {
				$res = $this->delchild('Linkage','linkageid','parentid',$value);
				$delid = M('Linkage')->delete($value);
			}
			// 记录用户行为
    		$this->addlog('linkageid='.implode(',',I('linkageids')));
			$this->success("删除成功！");
		}else{
			$this->error("参数错误啊~~");
		}
	}
}
?>