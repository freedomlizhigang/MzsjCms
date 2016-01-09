<?php
namespace Mzsj\Model;
use Think\Model;
class PositionModel extends Model{
	protected $_validate = array(
		array('name','require','名称不能为空~',0),
		array('name','','名称已经存在了~',0,'unique'),
	);
}
?>