<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2019/3/5
 * Time: 17:38
 */

namespace App\Lib;


use App\Lib\Upload\Base;

class ClassInit
{
    public static function aliasName()
    {
        return [
            'image' => '\App\Lib\Upload\Image',
            'video' => '\App\Lib\Upload\Video'
        ];
    }

    public static function classInit($type, $params):Base
    {
        $all = self::aliasName();
        $types = array_keys($all);

        if (!in_array($type, $types)) {
            throw  new \Exception('参数名称错误');
        }




        $reflector = new \ReflectionClass($all[$type]);

        /*var_dump($reflector->getConstructor());
        exit;*/

        $res =  $reflector->newInstanceArgs($params);
        return $res;
    }

}