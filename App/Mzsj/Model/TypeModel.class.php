<?php
namespace Mzsj\Model;
use Think\Model;
class TypeModel extends Model{

	protected $_validate = array(
		array('typename','require','请填写类别名称！'),
		array('typename','','类别名称已经存在！',0,'unique'),
		array('parentid','haspid','参数错误！',0,'callback',3),
		array('typedir','require','请填写类别目录'),
		array('typedir','','类别目录不能跟别的重复',0,'unique'),
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
			if ($this->where(array('typeid'=>$parentid))->find() && I('parentid') != I('typeid')) {
				return true;
			}else{
				return false;
			}
			
		}
	}
	// 
	public function getPath($pid){
		$path = array();
		$nav = $this->where("typeid={$pid}")->field('typeid,parentid,name')->find();
		$path[] = $nav;
		if($nav['parentid'] > 0){
			$path = array_merge($this->getPath($nav['parentid']),$path);
		}
		return $path;
	}
}
?>