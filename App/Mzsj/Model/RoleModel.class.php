<?php
namespace Mzsj\Model;
use Think\Model;
class RoleModel extends Model{
	protected $_validate = array(
		array('rolename','require','请填写角色名！',0),
		array('rolename','','角色名已经存在！',0,'unique'),
	);
}
?>