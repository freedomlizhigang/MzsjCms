<?php
namespace Mzsj\Model;
use Think\Model;
class SiteModel extends Model{
	protected $_validate = array(
		array('name','require','站点名称必填',0),
		array('sitename','require','SEO用站点名称必填',0),
		array('siteurl','url','域名必填',0),
		array('keyword','require','关键字必填',0),
		array('description','require','描述必填',0),
		array('linkman','require','联系人必填',0),
		array('tel','number','电话怎么不是数字呢',0),
		array('qq','number','qq还能是字母的？',0),
		array('address','require','地址必填',0),
		array('content','require','联系方式必填',0),
		array('template','require','默认模板目录必填',0),
	);
}
?>