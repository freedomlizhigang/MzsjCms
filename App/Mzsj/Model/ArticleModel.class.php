<?php
namespace Mzsj\Model;
use Think\Model;
class ArticleModel extends Model{
	protected $_auto = array(
		array('keyword','setkeyword',3,'callback'),
	);
	protected $_validate = array(
		array('catid','require','栏目必需填写！',0),
		array('title','require','标题必需填写！',0),
		array('title','','标题已经存在了！！',0,'unique'),
		array('content','require','内容不能为空！',0),
		array('listorder','number','排序只能是数字啊！',0),
	);
	protected function setkeyword(){
		$keytemp = trim(I('keyword'));
		return str_replace('，',',',$keytemp);
	}
}
?>