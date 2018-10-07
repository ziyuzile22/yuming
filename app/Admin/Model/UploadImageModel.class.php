<?php
namespace Admin\Model;

use Think\Model;

class UploadImageModel extends Model
{

    private $_uploadObj = '';
    private $_uploadImageData = '';

    const UPLOAD = 'Public/upload/images';

    public function __construct()
    {
        $this->_uploadObj = new \Think\Upload();

        $this->_uploadObj->rootPath = './' . self::UPLOAD . '/';
        $this->_uploadObj->subName = date(Y) . '/' . date(m) . '/' . date(d);
    }

    public function upload()
    {
        $res = $this->_uploadObj->upload();

        if ($res) {
            return BIND_WEBSITE . '/' . self::UPLOAD . '/' . $res['imgFile']['savepath'] . $res['imgFile']['savename'];
        } else {
            return false;
        }
    }


}