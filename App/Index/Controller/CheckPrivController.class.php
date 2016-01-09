<?php
namespace Index\Controller;
use Think\Controller;
class CheckPrivController extends Controller{
	protected $userid,$USER,$username;
	protected function _initialize(){
		$this->userid = sys_auth(cookie('mzsj_userid'),'DECODE');
		$this->username = sys_auth(cookie('mzsj_username'),'DECODE');
		// 用户公用信息
		$this->USER = $this->getinfo();
		// 检查登陆情况
		$this->checklogin();
		$this->assign('USER',$this->USER);
		$this->assign('userid',$this->userid);
		$this->assign('username',$this->username);
		$this->assign('gname',S('groupcache'));
		// 输出菜单
		$menu = $this->getmenu($this->userid,$this->USER['groupid']);
		$this->assign('menu',$menu);
	}
	private function checklogin(){
		if (empty(cookie('mzsj_userid')) || empty($this->USER)) {
			$this->error("请先登陆",U('Public/login'));
		}
	}
	protected function getinfo(){
		$info = M('User')->where(array('userid'=>$this->userid))->find();
		return $info;
	}
	private function getmenu($userid,$gid){
		// 缓存下菜单，省查询，测试时关掉
		$menus = session('USER_MENU_LIST.'.$userid);
		if (empty($menus)) {
			$list = M('UserMenu')->where(array('parentid'=>0,'display'=>1))->order('listorder ASC,menuid ASC')->select();
			$privlist = M('UserPriv')->where(array('groupid'=>$gid))->select();
			$menus = array();
			foreach ($list as $mv) {
				foreach ($privlist as $k => $pv) {
					if ($mv['menuid'] == $pv['menuid']) {
						$menus[$k]['menuid'] = $mv['menuid'];
						$menus[$k]['name'] = $mv['name'];
						$menus[$k]['url'] = $mv['module']."/".$mv['controller']."/".$mv['action']."/".$mv['data'];
					}
				}
			}
			foreach ($menus as $k => $v) {
				$child = M('UserMenu')->where(array('parentid'=>$v['menuid'],'display'=>1))->order('listorder ASC,menuid ASC')->select();
				$tmpchild = array();
				foreach ($child as $cv) {
					foreach ($privlist as $kcv => $pv) {
						if ($cv['menuid'] == $pv['menuid']) {
							$tmpchild[$kcv]['menuid'] = $cv['menuid'];
							$tmpchild[$kcv]['name'] = $cv['name'];
							$tmpchild[$kcv]['url'] = $cv['module']."/".$cv['controller']."/".$cv['action']."/".$cv['data'];
						}
					}
				}
				$menus[$k]['child'] = $tmpchild;
			}
			session('USER_MENU_LIST.'.$userid,$menus);
		}
		return $menus;
	}
}
?>