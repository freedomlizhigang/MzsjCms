<?php
namespace Mzsj\Controller;
use Think\Controller;
class LinkController extends MzsjController{
	public function index(){
		$page = I('page',1);
        $lists = M('Link')->order('listorder DESC')->page($page,20)->select();
        $count = M('Link')->count();
        $pages = new \Think\Page($count,20);
        $show = $pages->show();
        $this->assign('page',$show);
        $this->assign('lists',$lists);
		$this->title = "友情链接列表";
		$this->display();
	}
	public function addlink(){
		if(IS_POST){
			$Link = D('Link');
            $res = $Link->create();
            if ($res) {
                $linkid = $Link->add();
                if ($linkid) {
                    // 记录用户行为
                    $this->addlog('linkid='.$linkid);
                    $this->success("添加成功！",U('index'));
                }else{
                    $this->error("添加失败啊，".$Link->getError());
                }
            }else{
                $this->error("添加失败啊，".$Link->getError());
            }
		}else{
			$this->title = "添加链接";
			$this->display();
		}
	}
	public function editlink(){
		if(IS_POST){
			$Link = D('Link');
            $res = $Link->create();
            if ($res) {
                $linkid = $Link->save();
                if ($linkid) {
                    // 记录用户行为
                    $this->addlog('linkid='.$linkid);
                    $this->success("添加成功！",U('index'));
                }else{
                    $this->error("添加失败啊，".$Link->getError());
                }
            }else{
                $this->error("添加失败啊，".$Link->getError());
            }
		}else{
			$linkid = I('linkid');
			$info = M('Link')->find($linkid);
			$this->assign('info',$info);
			$this->title = "修改链接";
			$this->display();
		}
	}
    public function dellink(){
        if (I('linkid')) {
            $lids = I('linkid');
        }elseif(is_array(I('linkids'))){
            $lids = implode(',',I('linkids'));
        }
        $res = M('Link')->delete($lids);
        if ($res) {
            // 记录用户行为
            $this->addlog('linkid='.$lids);
            $this->success("删除成功！");
        }else{
            $this->error("删除失败!");
        }
    }
}
?>