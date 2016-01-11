<?php
/*
* 附件上传类
*/
namespace Common\Api;
class Upload {
	// kindedit上传图片
    public function kindupload($size = 2048000,$path = './Upload/',$exts = array('jpg','jpeg','gif','png','bmp')){
        session('upload_error', null);
        /* 上传配置 */
        $setting = array(
            'maxSize'       =>  $size, //上传的文件大小限制 (0-不做限制)
            'exts'          =>  $exts, //允许上传的文件后缀
            'rootPath'      =>  $path, //保存路径
        );
        /* 调用文件上传组件上传文件 */
        $this->uploader = new \Think\Upload($setting);
        $info   = $this->uploader->upload();
        if($info){
            $url = $setting['rootPath'].$info['imgFile']['savepath'].$info['imgFile']['savename'];
            $url = str_replace('./', '/', $url);
            $info['fullpath'] = __ROOT__.$url;
        }
        session('upload_error', $this->uploader->getError());
        /* 返回标准数据 */
        $return  = array('error' => 0, 'info' => '上传成功', 'data' => '');
        /* 记录附件信息 */
        if($info){
            $return['url'] = $info['fullpath'];
            unset($return['info'], $return['data']);
        } else {
            $return['error'] = 1;
            $return['message']   = session('upload_error');
        }
        /* 返回JSON数据 */
        exit(json_encode($return));
    }
}