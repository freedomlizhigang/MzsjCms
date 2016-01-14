<?php
/*
 * 微信群发消息类
*/
namespace Mzsj\Controller;
use Common\Api\WxApi;
class WxmsgController extends MzsjController
{
	public function _initialize()
	{
		parent::_initialize();
		$this->wxapi = new WxApi();
	}
	/*
	* 发送过的消息列表
	*/
	public function index()
	{
		$this->assign('title','历史消息列表');
		$this->display();
	}
	/*
	* 发新消息
	*/
	public function sendmsg()
	{
		$this->assign('title','发新消息');
		$this->display();
	}
	/*
	* 
	*/
}