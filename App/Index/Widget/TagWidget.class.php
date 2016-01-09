<?php
namespace Index\Widget;
use Think\Controller;
class TagWidget extends Controller{
	// 导航菜单，栏目列表
	public function menutag($pid='0'){
		$map['parentid'] = $pid;
		$map['ismenu'] = 1;
		$menulist = M('Category')->where($map)->order('listorder ASC,catid ASC')->field('catid,catname,parentid,islink,url,catdir')->select();
		$this->assign('menulist',$menulist);
		$this->display('Tag:menutag');
	}
	// 文章列表，调用时参数必须按顺序填写
	public function artlist($catid = '',$nums = '10',$order = 'artid DESC',$posid = ''){
		// 栏目id
		if ($catid) $map['catid'] = $catid;
		// 是否推荐
		if ($posid) $map['posid'] = $posid;
		// 审核通过的
		$map['status'] = '1';
		$artlist = M('Article')->where($map)->field('artid,catid,title,thumb,description,inputtime,updatetime,islink,url')->order($order)->limit($nums)->select();
		$this->assign('artlist',$artlist);
		$this->display('Tag:artlist');
	}
	// 栏目名称及链接
	public function categorys($catid = ''){
		$cates = M("Category")->field('catid,catname,islink,url')->find($catid);
		$this->assign('cate',$cates);
		$this->display('Tag:categorys');
	}
	// 当前位置
	public function catpos($catid){
		$arrparent = explode(',',S('catcache')[$catid]['arrparentid']);
		// 删除0
		array_shift($arrparent);
		// 添加自身
		$arrparent[] = $catid;
		$str = '';
		foreach ($arrparent as $v) {
			$str .= "&nbsp;>&nbsp;<a href=".U('Index/lists',array('catdir'=>S('catcache')[$v]['catdir'])).">".S('catcache')[$v]['catname']."</a>";
		}
		echo $str;
	}
}
?>