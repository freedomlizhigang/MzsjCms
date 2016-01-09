<?php
namespace Mzsj\Model;
use Think\Model;
class WxmsgModel extends Model{
	protected $_auto = array(
		array('msgcon','trim',3,'function'),
	);
	protected $_validate = array(
		array('msgtype','require','消息类型必需填写！',0),
		array('msgcon','require','消息内容必需填写！',0),
		array('msgcon','','消息内容已经存在了！！',0,'unique'),
		array('content','require','回复内容不能为空！',0),
		array('url','url','链接格式不正确！',2),
	);
}
?>