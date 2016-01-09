<?php
namespace Mzsj\Controller;
class AdmineditController extends MzsjController {
	// 修改用户信息
    public function editadmin(){
        if (IS_POST) {
            $admin = D('Admin');
            $res = $admin->create();
            if ($res) {
                $res['realname'] = trim($res['realname']);
                $adminid = $admin->save($res);
                if ($adminid) {
                    // 更新用户数据缓存
                    $this->cache->admincache();
                    // 记录用户行为
                    $this->addlog('adminid='.$adminid);
                    $this->success("用户资料修改成功！");
                }else{
                    $this->error("修改失败，".$admin->getError());
                }
            }else{
                $this->error("修改失败，".$admin->getError());
            }
        }else{
            $aid = session('mz_adminid');
            $info = M('Admin')->find($aid);
            // 用户组列表
            $rolelist = S('rolecache');
            $this->assign('rolelist',$rolelist);
            $this->assign('info',$info);
            $this->title = "修改用户资料";
            $this->display();
        }
    }
    // 修改密码
    public function editpassword(){
        if (IS_POST) {
            $data = I('post.');
            $data['encrypt'] = create_randomstr(6);
            $admin = D('Admin');
            $res = $admin->create($data);
            if ($res) {
                $adminid = $admin->save();
                if ($adminid) {
                    // 记录用户行为
                    $this->addlog('adminid='.$adminid);
                    $this->success("修改密码成功！");
                }else{
                    $this->error("修改失败，".$admin->getError());
                }
            }else{
                $this->error("修改失败，".$admin->getError());
            }
        }else{
            $this->assign('adminid',session('mz_adminid'));
            $this->assign('encrypt',create_randomstr(6));
            $this->title = "修改密码";
            $this->display();
        }
    }
}
?>