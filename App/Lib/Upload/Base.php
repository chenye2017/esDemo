<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2019/3/5
 * Time: 16:59
 */

namespace App\Lib\Upload;


use App\Lib\Utils;
use EasySwoole\Core\Http\AbstractInterface\Controller;

class Base extends Controller
{
    public $allowType = [];
    public $maxSize = 1024 * 1024 * 10;

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function upload($name)
    {
        $file      = $this->request()->getUploadedFile($name);
        $mainType  = $file->getClientMediaType();
        $size      = $file->getSize();
        $tmpName   = $file->getTempName();
        $name      = $file->getClientFilename();
        $extension = (pathinfo($name))['extension'];

        $arr = explode('/', $mainType);





        if (!in_array($arr[1], $this->allowType)) {
            throw new \Exception('文件类型不允许');
        }

        if ($size > $this->maxSize) {
            throw new \Exception('文件太大了');
        }

        $timeSrc = new \DateTime();
        $time    = $timeSrc->format('Ymd');
        $storage = '/Upload/' . $time;
        $dir     = EASYSWOOLE_ROOT . '/Public' . $storage;
        $filename = Utils::getFileKey($tmpName) . '.' . $extension;
        if (!is_dir($dir)) {
            mkdir($dir);
            chmod($dir, 0755);
        }

        $move = $file->moveTo($dir . '/' . $filename); // 感觉直接就是tmpName就好了。本身就是唯一的

        if (!$move) {
            throw new \Exception('文件移动失败');
        }

        return $storage.'/'.$filename;
    }
}