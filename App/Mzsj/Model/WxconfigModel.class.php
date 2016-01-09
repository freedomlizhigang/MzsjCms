<?php
namespace Mzsj\Model;
use Think\Model;
class WxconfigModel extends Model{
	protected $_auto = array(
		array('appid','trim',3,'function'),
		array('appsecret','trim',3,'function'),
		array('rzurl','trim',3,'function'),
		array('token','trim',3,'function'),
	);
	protected $_validate = array(
		array('appid','require',"appid不能为空",0),
		array('appsecret','require',"appsecret不能为空",0),
		array('rzurl','require',"认证url不能为空",0),
		array('token','require',"token不能为空",0),
	);
}
?>