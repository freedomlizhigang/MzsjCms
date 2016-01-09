<?php
namespace Index\Controller;
use Think\Controller;
class IndexController extends Controller {
    static $CookieUser;
	protected function _initialize(){
        $this->assign('SITE',S('sitecache'));
        $this->assign('CATEGORYS',S('catcache'));
	}
    public function index(){
        $this->display();
    }
    public function lists($catdir = '',$p = ''){
        if (!$catdir) $this->error("参数错误！");
        $catinfo = M('Category')->where(array('catdir'=>$catdir))->find();
        $this->assign('catinfo',$catinfo);
        if ($catinfo['ispage'] == 0) {
            $p = I('p',1);
            // 找下级栏目，并确定栏目数组
            $catids = M('Category')->field('catid')->where(array('parentid'=>$catinfo['catid']))->select();
            $tmparr = array();
            foreach ($catids as $v) {
                $tmparr[] = $v['catid'];
            }
            $catids = is_array($tmparr) ? implode(',',$tmparr) : $catinfo['catid'];
            // 查询
            $map['catid'] = array('in',$catids);
            $map['status'] = 1;
            $artlist = M('Article')->order('artid DESC')->where($map)->page($p,20)->select();
            $count = M('Article')->where($map)->count();
            $pages = new \Think\Page($count,20);
            $show = $pages->show();
            $this->assign('page',$show);
            $this->assign('artlist',$artlist);
            $this->display($catinfo['cattpl']);
        }else{
            $this->display($catinfo['cattpl']);
        }
        
    }
    // 文章页详情
    public function show($artid = ''){
        if (I('artid',0)) {
            $artinfo = M('Article')->find(I('artid'));
            $this->assign('artinfo',$artinfo);

            $this->display();
        }else{
            $this->error('您要查看的文章已经不在，去别的地方看看吧！',U('index'));
        }
    }
}