<?php
namespace Mzsj\Controller;
use Think\Controller;
use Common\Api\Upload;
class ContentController extends MzsjController {
    public function _initialize(){
        parent::_initialize();
    }
    // 文章列表
    public function index($catid = "",$q=""){
        $page = I('page',1);
        if (!empty($catid)) {
            $map['catid'] = I('catid');
            $this->assign('catid',I('catid'));
        }
        if (!empty($q)) {
            $map['catid'] = I('catid');
            $map['title'] = array('like','%'.trim(I('q')).'%');
        }
        $lists = M('Article')->where($map)->order('artid DESC')->page($page,20)->select();
        $count = M('Article')->where($map)->count();
        $pages = new \Think\Page($count,20);
        $show = $pages->show();
        $this->assign('page',$show);
        $lists = num2name($lists,'islinkname','islink');
        $lists = num2name($lists,'statusname','status','已审核','审核中');
        // 输出栏目列表
        $this->assign('catlist',S('catcache'));
        $this->assign('lists',$lists);
        $this->title = "文章列表";
        $this->display();
    }
    // 添加文章
    public function addarticle(){
        if (IS_POST) {
            $Art = D('Article');
            // 判断审核状态
            $catname = S('catcache');
            $isshenhe = $catname[I('catid')]['shenhe'];
            if ($isshenhe == '0') {
                $_POST['status'] = '1';
            }else{
                $_POST['status'] = '0';
            }
            $res = $Art->create();
            if ($res) {
                $res['content'] = htmlspecialchars_decode(I('content'));
                $artid = $Art->add($res);
                if ($artid) {
                    // 记录用户行为
                    $this->addlog('artid='.$artid);
                    $this->success("添加成功！",U('index'));
                }else{
                    $this->error("添加失败啊，".$Art->getError());
                }
            }else{
                $this->error("添加失败啊，".$Art->getError());
            }
        }else{
            // 输出推荐位
            $this->assign('posname',S('poscache'));
            // 栏目缓存
            $this->assign('catname',S('catcache'));
            $this->title = "添加文章";
            $this->display();
        }
    }
    // 修改文章
    public function editarticle(){
        if (IS_POST) {
            $Art = D('Article');
            $res = $Art->create();
            if ($res) {
                $res['content'] = htmlspecialchars_decode(I('content'));
                $artid = $Art->save($res);
                if ($artid) {
                    // 记录用户行为
                    $this->addlog('artid='.$artid);
                    $this->success("修改成功！",U('index'));
                }else{
                    $this->error("修改失败啊，".$Art->getError());
                }
            }else{
                $this->error("修改失败啊，".$Art->getError());
            }
        }else{
            // 输出推荐位
            $this->assign('posname',S('poscache'));
            $artid = I('artid');
            $info = M('Article')->find($artid);
            $this->assign('infos',$info);
            // 栏目缓存
            $this->assign('catname',S('catcache'));
            $this->title = "修改文章";
            $this->display();
        }
    }
    // 删除文章
    public function delarticle(){
        if(I('artid')){
            $artids = I('artid');
        }elseif(is_array(I('artids'))){
            $artids = implode(',', I('artids'));
        }
        $res = M('Article')->delete($artids);
        if ($res) {
            // 记录用户行为
            $this->addlog('artid='.$artids);
            $this->success("删除成功！");
        }else{
            $this->error("删除失败！");
        }
    }
    // 查看文章并审核
    public function showart(){
        // 输出推荐位
        $this->assign('posname',S('poscache'));
        $artid = I('artid');
        $info = M('Article')->find($artid);
        $this->assign('infos',$info);
        // 栏目缓存
        $this->assign('catname',S('catcache'));
        $this->title = "修改文章";
        $this->display();
    }
    // 审核文章
    public function shenheart(){
        if(I('artid')){
            $artids = I('artid');
            $status = I('status');
            if ($status == '0') {
                $res = M('Article')->where(array('artid'=>$artids))->setfield('status','1');
            }else{
                $res = M('Article')->where(array('artid'=>$artids))->setfield('status','0');
            }
        }else{
            $this->error("没有要审核的文章，请重试！");
        }
        if ($res) {
            // 记录用户行为
            $this->addlog('artid='.$artids);
            $this->success("操作成功！");
        }else{
            $this->error("操作失败！");
        }
    }
    // 栏目列表
    public function cate(){
        $cate = $this->list_to_tree('Category','catid','parentid',0);
        $cate = num2name($cate,'ismenuname','ismenu');
        $cate = num2name($cate,'ispagename','ispage');
        $this->assign('cate',$cate);
        $this->title = "栏目列表";
    	$this->display();
    }
    // 添加栏目
    public function addcate(){
        if (IS_POST) {
            $cate = D('Category');
            $res = $cate->create();
            if ($res) {
                $res['content'] = htmlspecialchars_decode(I('content'));
                $catid = $cate->add($res);
                if ($catid) {
                    // 更新栏目缓存
                    $this->cache->catecache();
                    // 记录用户行为
                    $this->addlog('catid='.$catid);
                    $this->success("栏目添加成功~",U('cate'));
                }else{
                    $this->error("添加失败，".$cate->getError());
                }
            }else{
                $this->error("添加失败，".$cate->getError());
            }
        }else{
            $pid = I('parentid',0);
            $this->assign('pid',$pid);
            $this->title = "添加栏目";
            $this->display();
        }
    }
    // 修改栏目
    public function editcate(){
        if (IS_POST) {
            $cate = D('Category');
            $res = $cate->create();
            if ($res) {
                $res['content'] = htmlspecialchars_decode(I('content'));
                $catid = $cate->save($res);
                if ($catid) {
                    // 更新栏目缓存
                    $this->cache->catecache();
                    // 记录用户行为
                    $this->addlog('catid='.$catid);
                    $this->success("栏目修改成功~",U('cate'));
                }else{
                    $this->error("修改失败，".$cate->getError());
                }
            }else{
                $this->error("修改失败，".$cate->getError());
            }
        }else{
            $catid = I('catid',0);
            $cate = $this->list_to_tree('Category','catid','parentid',0);
            $this->assign('cate',$cate);
            $info = M('Category')->find($catid);
            $this->assign('info',$info);
            $this->title = "修改栏目";
            $this->display();
        }
    }
    // 删除栏目
    public function delcate(){
        if (I('catid')) {
            $this->delcheck(I('catid'));
            // 更新栏目缓存
            $this->cache->catecache();
            // 记录用户行为
            $this->addlog('catid='.I('catid'));
            $this->success('删除成功！');
        }elseif(is_array(I('catids'))){
            $res = $this->delcheck(I('catids'));
            // 更新栏目缓存
            $this->cache->catecache();
            // 记录用户行为
            $this->addlog('catids='.implode(',',I('catids')));
            $this->success('删除成功！');
        }else{
            $this->error("你是想删除哪个？");
        }
    }
    // 检查是否有子栏目要删除，并判断是否有文章
    private function delcheck($catid){
        if (is_array($catid)) {
            foreach ($catid as $v) {
                $this->delsubcheck($v);
            }
        }else{
            $this->delsubcheck($catid);
        }
    }
    // 检查是否有子栏目及文章，并进行删除操作
    private function delsubcheck($catid){
        $havchild = M('Category')->where(array('parentid'=>$catid))->getField('catid');
        if ($havchild) {
            $this->delcheck($havchild);
        }else{
            $havart = M('Article')->where(array('catid'=>$catid))->field('catid,artid')->find();
            if ($havart) {
                $this->error("栏目ID为 ".$havart['catid']." 的栏目下有文章啊~先去把文章删除了吧！");
            }else{
                M('Category')->delete($catid);
            }
        }
    }
}