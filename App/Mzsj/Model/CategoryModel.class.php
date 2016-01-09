<?php
namespace Mzsj\Model;
use Think\Model;
class CategoryModel extends Model{
	protected $_auto = array(
		array('parentid','intval',3,'function'),
	);

	protected $_validate = array(
		array('catname','require','栏目名必须填写！',0),
		array('catname','','栏目名已经存在~',0,'unique',1),
		array('catdir','require','栏目目录必须填写！',0),
		array('catdir','/^[A-Za-z]+$/','栏目目录只能用字母啊~',0),
		array('catdir','','栏目目录已经存在~',0,'unique',1),
		array('content','require','内容不能为空！',0),
		array('cattpl','require','栏目模板必须填写！',0),
		array('arttpl','require','文章模板必须填写！',0),
		array('parentid','haspid','参数错误！',0,'callback',3),
		array('listorder','number','排序只能是数字啊！',0),
	);

	// 判断是否有父ID
	protected function haspid(){
		$parentid = I('parentid');
		if ($parentid == 0) {
			return true;
		}else{
			if ($this->where(array('catid'=>$parentid))->find() && I('parentid') != I('catid')) {
				return true;
			}else{
				return false;
			}
			
		}
	}
}
?>