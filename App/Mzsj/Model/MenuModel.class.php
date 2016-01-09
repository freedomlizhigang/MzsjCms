<?php
namespace Mzsj\Model;
use Think\Model;
class MenuModel extends Model{

	protected $_validate = array(
		array('name','require','请填写菜单名称！'),
		array('parentid','haspid','参数错误！',0,'callback',3),
		array('url','require','请填写URL'),
		array('listorder','number','排序只能是数字啊！',0),
	);

	protected $_auto = array(
		array('parentid','intval',3,'function'),
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
	// 
	public function getPath($pid){
		$path = array();
		$nav = $this->where("menuid={$pid}")->field('menuid,parentid,name')->find();
		$path[] = $nav;
		if($nav['parentid'] > 0){
			$path = array_merge($this->getPath($nav['parentid']),$path);
		}
		return $path;
	}
}
?>