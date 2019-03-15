<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2019/3/5
 * Time: 16:59
 */

namespace App\Lib\Upload;


class Image extends Base
{
    public $allowType = [
        'jpeg'
    ];
    public $maxSize = 1024 * 1024 * 10;
}