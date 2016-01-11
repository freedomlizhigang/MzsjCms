<?php
namespace Mzsj\Controller;
use Think\Controller;
class IndexController extends MzsjController {
    public function _initialize(){
        parent::_initialize();
        $this->site = D('Site');
    }
    public function index(){
        $this->assign('mainmenu',$this->findmenu(0));
        $this->display();
    }
    public function main(){
        echo "main";
    }
    // 左侧菜单
    public function left_menu()
    {
        $menulist = $this->findmenu(I('pid',0));
        foreach ($menulist as $k => $v) {
            $menulist[$k]['submenu'] = $this->findmenu($v['menuid']);
        }
        $this->assign('two_menu',$menulist);
        $this->display();
    }
    // 站点列表
    public function sitelist(){
        $this->title = "站点列表";
        $page = I('page',1);
        $list = $this->site->order('siteid ASC')->page($page,20)->select();
        $count = $this->site->count();
        $pages = new \Think\Page($count,20);
        $show = $pages->show();
        $this->assign('pages',$show);
        $this->assign('listinfo',$list);
        $this->display();
    }
    // 添加站点信息
    public function addsite(){
        if (IS_POST) {
            $res = $this->site->create();
            if ($res) {
                $siteid = $this->site->add();
                if ($siteid) {
                    // 更新站点缓存
                    $this->cache->sitecache();
                    // 记录用户行为
                    $this->addlog();
                    $this->success("添加站点成功！",U('sitelist'));
                }else{
                    $this->error("添加站点失败,".$this->site->getError());
                }
            }else{
                $this->error("添加站点失败,".$this->site->getError());
            }
        }else{
            $this->title = "添加站点";
            $this->display();
        }
    }
    // 修改站点信息
    public function editsite(){
    	if (IS_POST) {
    		$res = $this->site->create();
    		if ($res) {
    			$siteid = $this->site->save();
    			if ($siteid) {
                    // 更新站点缓存
                    $this->cache->sitecache();
                    // 记录用户行为
                    $this->addlog();
    				$this->success("更新站点信息成功！",U('sitelist'));
    			}else{
    				$this->error("修改失败,".$this->site->getError());
    			}
    		}else{
    			$this->error("修改失败,".$this->site->getError());
    		}
    	}else{
    		$site = $this->site->find(I('siteid'));
    		$this->assign('site',$site);
	    	$this->title = "编辑站点信息";
	    	$this->display();
	    }
    }
    // 删除站点
    public function delsite(){
        if (I('siteid') && I('siteid') !== '1') {
            $siteid = $this->site->delete(I('siteid'));
            if ($siteid) {
                // 更新站点缓存
                $this->cache->sitecache();
                // 记录用户行为
                $this->addlog();
                $this->success("站点删除成功！");
            }else{
                $this->error("站点删除失败，请再试一次！");
            }
        }else{
            $this->error("输入的参数不正确");
        }
    }
    // 更新全站缓存
    public function updatecache(){
        // 更新站点缓存
        $this->cache->sitecache();
        $this->show("<p>更新站点缓存成功...</p>");
        // 用户组缓存
        $this->cache->rolecache();
        $this->show("<p>更新用户组缓存成功...</p>");
        // 用户缓存
        $this->cache->admincache();
        $this->show("<p>更新用户缓存成功...</p>");
        // 栏目缓存
        $this->cache->catecache();
        $this->show("<p>更新栏目缓存成功...</p>");
        // 推荐位缓存
        $this->cache->poscache();
        $this->show("<p>更新推荐位缓存成功...</p>");
        // 会员组缓存
        $this->cache->groupcache();
        $this->show("<p>更新会员组缓存成功...</p>");
        // 类别缓存
        $this->cache->typecache();
        $this->show("<p>更新类别缓存成功...</p>");
        // 完成后跳转
        echo "<p style='color:red'>更新完成！</p>";
    }
    // 日志列表
    public function loglist(){
        $page = I('page',1);
        $lists = M('Log')->order('logid DESC')->page($page,20)->select();
        $count = M('Log')->count();
        $pages = new \Think\Page($count,20);
        $show = $pages->show();
        $this->assign('pages',$show);
        $this->assign('list',$lists);
        $this->title = "日志列表";
        $this->display();
    }
    // 清除7天前日志
    public function clear(){
        $oldtime = time() - (3600*24*7);
        $map['time'] = array('lt',$oldtime);
        $res = M('Log')->where($map)->delete();
        if ($res) {
            $this->success("删除成功！");
        }else{
            $this->error('删除失败，请检查是否有7天前的日志！');
        }
    }
    
}