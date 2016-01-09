<?php
namespace Mzsj\Controller;
use Think\Controller;
use Mzsj\Api\CacheApi;
class MzsjController extends Controller{
	public function _initialize(){
		$this->islogin();
		$this->getadmin();
		$this->check_priv();
		$this->cache = new CacheApi();
		$this->assign('rightmenu',$this->getsubmenu());
	}
	// 判断是否登陆
	public function islogin(){
		if(!session('mz_adminid') || !session('mz_roleid')){
			$this->error("请先登陆后台，再进行操作！",U('Public/login'));
		}
	}
	// 取得用户信息
	public function getadmin(){
		$adminid = session('mz_adminid');
		$info = M('Admin')->where(array('adminid'=>$adminid))->find();
		$this->assign('admininfo',$info);
	}
	// 检查权限
	final function check_priv(){
		if(MODULE_NAME =='Mzsj' && CONTROLLER_NAME =='Public' && ACTION_NAME =='login') return true;
		// 获取菜单功能
		if(MODULE_NAME =='Mzsj' && CONTROLLER_NAME =='Index' && ACTION_NAME =='left_menu') return true;
		// 右侧基础信息功能
		if(MODULE_NAME =='Mzsj' && CONTROLLER_NAME =='Index' && ACTION_NAME =='main') return true;
		if(session('mz_roleid') == 1) return true;
		$nowsurl = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$res = M('AdminPriv')->where(array('roleid'=>session('mz_roleid'),'url'=>$nowsurl))->find();
		if (!$res) $this->error("您没有这个操作的权限！");
	}
	// 找出所有有权限的url
	private function privurl(){
		$list = M('AdminPriv')->where(array('roleid'=>session('mz_roleid')))->select();
		return $list;
	}
	// 输出导航菜单
	public function getsubmenu(){
		$privmenu = $this->privurl();
		$submenus = array();
		$url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
		$menuid = M('Menu')->where("url = '".$url."'")->find();
		$tempsub = array();
		if ($menuid) {
			$submenus = M('Menu')->where("display = 1 and parentid = ".$menuid['menuid'])->order('listorder ASC,menuid ASC')->select();
			if (session('mz_roleid') == 1) {
				$tempsub = $submenus;
			}else{
				foreach ($submenus as $privsub) {
					if (is_array($privmenu)) {
						foreach ($privmenu as $pvsub) {
							if($privsub['url'] == $pvsub['url']){
								$tempsub[] = $privsub;
							}
						}
					}
				}
			}
		}
		return $tempsub;
	}
	/*
	* 按父级查找菜单
	* pid 父级id 找到下级子栏目
	*/
	public function findmenu($pid = 0){
	    $pid = intval($pid);
	    $sql = 'parentid = '.$pid.' and display = 1';
	    $menus = M('Menu')->where($sql)->order('listorder ASC,menuid ASC')->select();
	    // 取出所有可以显示的菜单
	    $privmenu = $this->privurl();
	    $array = array();
	    foreach ($menus as $mv) {
	        if (is_array($privmenu)) {
	            foreach ($privmenu as $pv) {
	                if($mv['url'] == $pv['url']){
	                    $array[] = $mv;
	                }
	            }
	        }
	    }
	    // 超级管理员拥有所有权限
	    if (session('mz_roleid') == 1) {
	        $array = $menus;
	    }
	    return $array;
	}
	// 输出树形菜单
	protected $resarray = array();
	protected function list_to_tree($model = '',$pkname = '',$parentidname = '',$pid = 0 ,$level = 0 ,$jg = '',$field = '*'){
		$number = 1;
		$Model = M($model);
		$lists = $Model->where($parentidname.' = '.$pid)->field($field)->order('listorder ASC,'.$pkname.' ASC')->select();
		if (is_array($lists)) {
			// 计算子菜单总数，如果有下级菜单，层数+1
			$level++;
			$total = count($lists);
			foreach($lists as $ml){
				// 判断是不是最后一个，最后一个用“ └ ”分隔
				$j=$k='';
				if($number==$total){
					$j .= '└ ';
				}else{
					$j .= '├ ';
				}
				// 为拼接下一级循环用的分隔符做准备
				$k = $jg ? '│ ' : '';
				// 保存分隔符
				$ml['nbsp'] = $jg ? $jg.$j : '';
				$ml['level'] = $level;
				$this->resarray[] = $ml;
				$this->list_to_tree($model,$pkname,$parentidname,$ml[$pkname],$level,$jg.$k.'&nbsp');
				$number++;
			}
		}
		return $this->resarray;
	}
	// 转换是：否
	protected function displayname($list,$newzd='',$oldzd=''){
		foreach ($list as $key => $value) {
			$list[$key][$newzd] = $value[$oldzd] ? "<span class='color_green'>是</span>" : "<span class='color_red'>否</span>";
		}
		return $list;
	}
	// 转换状态
	protected function statusname($list){
		foreach ($list as $key => $value) {
			$list[$key]['statusname'] = $value['status'] ? "<span class='color_green'>正常</span>" : "<span class='color_red'>禁用</span>";
		}
		return $list;
	}
	// 审核状态
	protected function shenhename($list){
		foreach ($list as $key => $value) {
			$list[$key]['statusname'] = $value['status'] ? "<span class='color_green'>已审核</span>" : "<span class='color_red'>审核中</span>";
		}
		return $list;
	}
	// 循环删除子菜单
	protected function delChild($model = '',$pkname = '',$parentid = '',$pid = ''){
		$res = M($model)->where(array($parentid=>$pid))->field($pkname)->select();
		if ($res) {
			foreach ($res as $value) {
				$r=M($model)->delete($value[$pkname]);
				$this->delChild($model,$pkname,$parentid,$value[$pkname]);
			}
		}
		return true;
	}
	// 添加用户日志
	protected function addlog($q = ''){
		$data['url'] = '/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/';
		$data['data'] = $q;
		$data['adminid'] = session('mz_adminid');
		$data['adminname'] = session('mz_adminname');
		$data['ip'] = get_client_ip();
		$data['time'] = time();
		M('Log')->add($data);
	}
}
?>