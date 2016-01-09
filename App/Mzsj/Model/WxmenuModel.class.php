<?php
namespace Mzsj\Model;
use Think\Model;
class WxmenuModel extends Model{
	protected $_auto = array(
		array('name','trim',3,'function'),
		array('key','trim',3,'function'),
	);
	protected $_validate = array(
		array('name','require','名称必需要填写！',0),
		array('name','','已经存在这个菜单了，换个名字试试！',0,'unique'),
		array('name','0,16','写太长了吧，手机哪里显示的过来！',0,'length'),
		array('type','require','类型必需要填写！',0),
	);
}
?>