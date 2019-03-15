<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/1/9
 * Time: 下午1:04
 */

namespace EasySwoole;

use App\Lib\Consumer;
use App\Lib\Redis;
use \EasySwoole\Core\AbstractInterface\EventInterface;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Swoole\Process\ProcessManager;
use \EasySwoole\Core\Swoole\ServerManager;
use \EasySwoole\Core\Swoole\EventRegister;
use \EasySwoole\Core\Http\Request;
use \EasySwoole\Core\Http\Response;
use EasySwoole\Core\Utility\File;

Class EasySwooleEvent implements EventInterface {

    public static function frameInitialize(): void
    {
        // TODO: Implement frameInitialize() method.
        date_default_timezone_set('Asia/Shanghai');

        self::loadConf(EASYSWOOLE_ROOT . '/Conf');
    }

    public static function mainServerCreate(ServerManager $server,EventRegister $register): void
    {
        // TODO: Implement mainServerCreate() method.
        // 建立redis 连接
        Di::getInstance()->set('REDIS', Redis::getInstance());
        // 建立数据库连接
        Di::getInstance()->set('MYSQL', \MysqliDb::class, [
            'host' => '192.168.33.10',
            'username' => 'root',
            'password' => 'wyqnkxk2012_CY',
            'db' => 'user',
            'port' => 3306,
            'charset' => 'utf8'
        ]);

        // 启动3个进程
        /*$allNum = 3;
        for ($i = 0 ;$i < $allNum;$i++){
            ProcessManager::getInstance()->addProcess("consumer_{$i}",Consumer::class);
        }*/
    }

    public static function onRequest(Request $request,Response $response): void
    {
        // TODO: Implement onRequest() method.
    }

    public static function afterAction(Request $request,Response $response): void
    {
        // TODO: Implement afterAction() method.
    }

    public function loadConf($ConfPath)
    {
        $Conf  = Config::getInstance();
        $files = File::scanDir($ConfPath);
        foreach ($files as $file) {
            $data = require_once $file;
            $Conf->setConf(strtolower(basename($file, '.php')), (array)$data);
        }
    }
}