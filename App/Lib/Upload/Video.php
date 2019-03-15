<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2019/3/5
 * Time: 17:00
 */

namespace App\Lib\Upload;


class Video extends Base
{
    public $allowType = [
        'mp4'
    ];
    public $maxSize = 1024 * 1024 * 10;

}