<?php
namespace Mzsj\Model;
use Think\Model;
class LinkModel extends Model{
	protected $_validate = array(
		array('name','require','名称必需填写啊！',0),
		array('name','','名称已经存在了！',0,'unique'),
		array('url','url','URL填写不正确！',0),
		array('url','','url已经存在了！',0,'unique'),
		array('listorder','number','排序必需是数字啊！',0),
	);
}
?>