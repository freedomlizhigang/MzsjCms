<?php
namespace Mzsj\Model;
use Think\Model;
class UserMenuModel extends Model{
	protected $_validate = array(
		array('name','require','请填写菜单名称！'),
		array('parentid','haspid','参数错误！',0,'callback',3),
		array('module','require','请填写模块名'),
		array('controller','require','请填写控制器名'),
		array('action','require','请填写方法名'),
		array('listorder','number','排序只能是数字啊！',0),
	);

	protected $_auto = array(
		array('parentid','intval',3,'function'),
		array('level','updatelevel',2,'callback'),
	);
	// 判断是否有父ID
	protected function haspid(){
		$parentid = I('parentid');
		if ($parentid == 0) {
			return true;
		}else{
			if ($this->where(array('menuid'=>$parentid))->find() && I('parentid') != I('menuid')) {
				return true;
			}else{
				return false;
			}
			
		}
	}
	// 判断是否更改层数
	protected function updatelevel(){
		$mid = I('menuid');
		$pid = I('parentid');
		$res = $this->where(array('menuid'=>$mid))->field('parentid,level')->find();
		if ($res['parentid'] == $pid) {
			return $res['level'];
		}else{
			$level = $this->where(array('menuid'=>$pid))->getfield('level');
			$level += 1;
			return $level;
		}
	}
}
?>