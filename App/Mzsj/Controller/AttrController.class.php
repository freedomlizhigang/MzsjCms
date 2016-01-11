<?php
namespace Mzsj\Controller;
use Common\Api\Upload;
class AttrController extends MzsjController {
    public function _initialize(){
        parent::_initialize();
    }
    // 管理素材
	public function index()
	{
		$this->assign('title','管理素材');
		$page = I('p') ? I('p') : 1;
		$lists = M('Attr')->order('attid DESC')->where(array('islocal'=>0))->page($page,20)->select();
		$count = M('Attr')->where(array('islocal'=>0))->count();
		$pages = new \Think\Page($count,20);
		$show = $pages->show();
		$this->assign('page',$show);
		$this->assign('lists',$lists);
		$this->display();
	}
	// 删除素材
	public function delattr()
	{
		$attid = I('attid');
		$hav = M('Attr')->where(array('attid'=>$attid))->find();
		if ($hav) {
			// 本地文件删除
			$filepath = SERVER_PATH.$hav['localurl'];
			if (file_exists($filepath)){unlink($filepath);}
			M('Attr')->delete($attid);
			$this->success('删除素材成功！');
		}else{
			$this->error('没有找到素材！');
		}
	}
 	// kindedit上传图片
    public function kindupload(){
        // 上传
        $upload = new Upload();
        $upres = $upload->kindupload($size = 3145728,$path = './Upload/',$exts = array('jpg','jpeg','gif','png','bmp'));
        // 存入本地数据库
        $uploadarr = json_decode($upres,true);
        $data['type'] = 'image';
        $data['localurl'] = $uploadarr['url'];
        $data['inputtime'] = time();
        $data['islocal'] = 0;
        $insert = M('Attr')->add($data);
        exit($upres);
    }
}