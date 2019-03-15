<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2019/3/4
 * Time: 20:43
 */

namespace App\Lib;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;
use EasySwoole\Core\Swoole\Process\AbstractProcess;
use Swoole\Process;

class Consumer extends AbstractProcess
{
    private $isRun = false;
    public function run(Process $process)
    {
        // TODO: Implement run() method.
        /*
         * 举例，消费redis中的队列数据
         * 定时500ms检测有没有任务，有的话就while死循环执行
         */
        $this->addTick(500,function (){

            if(!$this->isRun){
                $this->isRun = true;
                $redis = Di::getInstance()->get('REDIS');//此处为伪代码，请自己建立连接或者维护redis连接
                while (true){
                    try{
                        $task = $redis->lPop('task_list');
                        if($task){
                            // do you task
                            Logger::getInstance()->log('task is num:'.$task.' is handle by process:'.$this->getProcessName().' pid is :'.$this->getPid());
                        }else{
                            break;
                        }
                    }catch (\Throwable $throwable){
                        break;
                    }
                }
                $this->isRun = false;
            }
            //var_dump($this->getProcessName().' task run check');
        });
    }

    public function onShutDown()
    {
        // TODO: Implement onShutDown() method.
    }

    public function onReceive(string $str, ...$args)
    {
        // TODO: Implement onReceive() method.
    }
}