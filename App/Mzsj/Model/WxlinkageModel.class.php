<?php
namespace Mzsj\Model;
use Think\Model;
class WxlinkageModel extends Model{
	protected $_validate = array(
		array('name','require','关联名称必填！',0),
		array('name','','关联名称已经存在了！！',0,'unique'),
		array('val','require','关联菜单的值必填！',0),
		array('val','','关联菜单的值已经存在了！！',0,'unique'),
		array('listorder','number','排序必然是数字啊！',0),
	);
}
?>