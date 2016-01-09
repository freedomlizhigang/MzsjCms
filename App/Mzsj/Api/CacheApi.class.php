<?php
namespace Mzsj\Api;
class CacheApi {
	// 站点缓存
	public function sitecache(){
		$sitelist = M('Site')->order('siteid ASC')->select();
		$sitecache = array();
		foreach ($sitelist as $k => $v) {
			$sitecache[$v['siteid']] = $v;
		}
		S('sitecache',$sitecache);
	}
	// 缓存所有的角色
	public function rolecache(){
		$res = M('Role')->select();
		S('rolecache',$res);
	}
	// 缓存用户数据
	public function admincache(){
		$adminlist = M('Admin')->field('adminid,adminname')->select();
		$admincache = array();
		foreach ($adminlist as $key => $value) {
			$admincache[$value['adminid']] = $value['adminname'];
		}
		S('admincache',$admincache);
	}
	// 更新栏目缓存
    public function catecache(){
    	$this->categorys = $categorys = array();
		$this->categorys = $categorys = M('Category')->select();
		// 将数组索引转化为typeid，phpcms v9的select方法支持定义数组索引，这个坑花了两小时
		$this->categorys  = $categorys = $this->get_categorys($categorys,'catid');
		if(is_array($this->categorys)) {
			foreach($this->categorys as $catid => $cat) {
				// 取得所有父栏目
				$arrparentid = $this->get_arrparentid($catid);
				$arrchildid = $this->get_arrchildid($catid);
				$child = is_numeric($arrchildid) ? 0 : 1;
				// 如果父栏目数组、子栏目数组，及是否含有子栏目不与原来相同，更新
				if($categorys[$catid]['arrparentid']!=$arrparentid || $categorys[$catid]['arrchildid']!=$arrchildid || $categorys[$catid]['child']!=$child){
					M('Category')->save(array('catid'=>$catid,'arrparentid'=>$arrparentid,'arrchildid'=>$arrchildid,'child'=>$child));
				}
			}
		}
		//删除在非正常显示的栏目
		foreach($this->categorys as $cat) {
			if($cat['parentid'] != 0 && !isset($this->categorys[$cat['parentid']])) {
				M('type')->delete($cat['catid']);
			}
		}
		$newlist = M('Category')->select();
		$tmparr = array();
		foreach ($newlist as $v) {
			$tmparr[$v['catid']] = $v;
		}
		S('catcache',$tmparr);
    }
    // 更新推荐位缓存
	public function poscache(){
		$posarr = M('Position')->order('posid ASC')->select();
		$tmparr = array();
		foreach ($posarr as $v) {
			$tmparr[$v['posid']] = $v['name'];
		}
		S('poscache',$tmparr);
	}
	// 更新用户组缓存
	public function groupcache(){
		$list = M('Group')->select();
		$temp = array();
		foreach ($list as $v) {
			$temp[$v['groupid']] = $v['groupname'];
		}
		S('groupcache',$temp);
	}
	// 更新类别缓存
	public function typecache(){
		$this->categorys = $categorys = array();
		$this->categorys = $categorys = M('Type')->select();
		// 将数组索引转化为typeid，phpcms v9的select方法支持定义数组索引，这个坑花了两小时
		$this->categorys  = $categorys = $this->get_categorys($categorys,'typeid');
		if(is_array($this->categorys)) {
			foreach($this->categorys as $catid => $cat) {
				// 取得所有父栏目
				$arrparentid = $this->get_arrparentid($catid);
				$arrchildid = $this->get_arrchildid($catid);
				$child = is_numeric($arrchildid) ? 0 : 1;
				// 如果父栏目数组、子栏目数组，及是否含有子栏目不与原来相同，更新
				if($categorys[$catid]['arrparentid']!=$arrparentid || $categorys[$catid]['arrchildid']!=$arrchildid || $categorys[$catid]['child']!=$child){
					M('Type')->save(array('typeid'=>$catid,'arrparentid'=>$arrparentid,'arrchildid'=>$arrchildid,'child'=>$child));
				}
			}
		}
		//删除在非正常显示的栏目
		foreach($this->categorys as $cat) {
			if($cat['parentid'] != 0 && !isset($this->categorys[$cat['parentid']])) {
				M('type')->delete($cat['typeid']);
			}
		}
		$newlist = M('Type')->select();
		$tmparr = array();
		foreach ($newlist as $v) {
			$tmparr[$v['typeid']] = $v;
		}
		S('typecache',$tmparr);
	}

	/**
	 * 以索引重排结果数组
	 * @param array $categorys
	 * $zhujian 主键
	 */
	private function get_categorys($categorys = array() ,$zhujian = '') {
		if (is_array($categorys) && !empty($categorys)) {
			$temparr = array();
			foreach ($categorys as $c) {
				// 以主键做为数组索引
				$temparr[$c[$zhujian]] = $c;
			}
		} 
		return $temparr;
	}
	/**
	 * 
	 * 获取父栏目ID列表
	 * @param integer $catid              栏目ID
	 * @param array $arrparentid          父目录ID
	 * @param integer $n                  查找的层次
	 */
	private function get_arrparentid($catid, $arrparentid = '', $n = 1) {
		if($n > 5 || !is_array($this->categorys) || !isset($this->categorys[$catid])) return false;
		$parentid = $this->categorys[$catid]['parentid'];
		$arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
		// 父ID不为0时
		if($parentid) {
			$arrparentid = $this->get_arrparentid($parentid, $arrparentid, ++$n);
		} else {
			// 如果父ID为0
			$this->categorys[$catid]['arrparentid'] = $arrparentid;
		}
		$parentid = $this->categorys[$catid]['parentid'];
		return $arrparentid;
	}
	/**
	 * 
	 * 获取子栏目ID列表
	 * @param $catid 栏目ID
	 */
	private function get_arrchildid($catid) {
		$arrchildid = $catid;
		if(is_array($this->categorys)) {
			foreach($this->categorys as $id => $cat) {
				if($cat['parentid'] && $id != $catid && $cat['parentid']==$catid) {
					$arrchildid .= ','.$this->get_arrchildid($id);
				}
			}
		}
		return $arrchildid;
	}
}
?>