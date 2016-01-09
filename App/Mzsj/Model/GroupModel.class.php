<?php
namespace Mzsj\Model;
use Think\Model;
class GroupModel extends Model{
	protected $_validate = array(
		array('groupname','require','请填写用户组名称！',0),
		array('groupname','','用户组名称已经存在，请换一个再试！',0,'unique'),
		array('listorder','number','顺序只能是数字啊！',0),
	);
}
?>