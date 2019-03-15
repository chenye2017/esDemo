<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2019/3/1
 * Time: 16:05
 */

namespace App\Lib;


use EasySwoole\Config;
use EasySwoole\Core\AbstractInterface\Singleton;


class Redis
{
    use Singleton;
    public $redis;

    private function __construct()
    {

        $config = Config::getInstance();
        $redisConf = ($config->toArray())['redis'];

        try {
            $this->redis = new \Redis();
            $result = $this->redis->connect($redisConf['host'], $redisConf['port']);
        } catch (\Exception $e) {
            throw  new \Exception('连接redis失败');
        }

        if (!$result) {
            throw  new \Exception('连接redis失败');
        }

    }

    public function set($key, $value)
    {
        return $this->redis->set($key, $value);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->redis, $name], $arguments);
    }
}