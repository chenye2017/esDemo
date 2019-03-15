<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2019/3/1
 * Time: 15:43
 */

namespace App\HttpController;


use App\Lib\ClassInit;
use App\Model\User;

use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Http\AbstractInterface\Controller;
use EasySwoole\Core\Utility\Validate\Rule;
use EasySwoole\Core\Utility\Validate\Rules;
use EasySwoole\Core\Utility\Validate\Validate;

class Index extends Controller
{
    public function index()
    {

        $this->response()->write('hello world');
    }

    public function test()
    {
        $redis = Di::getInstance()->get('REDIS');
        var_dump($redis->get('easyswoole'));

    }

    public function data()
    {
        $user = new User();
        var_dump($user->getUserInfoList());
    }

    public function addTask()
    {
        $id = $this->request()->getQueryParam('id');
        $redis = Di::getInstance()->get('REDIS');
        $redis->lpush('task_list', $id);
    }

    /*
     * 单文件上传
     * */
    public function uploadFile()
    {
        $file = $this->request()->getUploadedFiles();

        $keys = array_keys($file);

        $type = $keys[0];


        $uri = ClassInit::classInit($type ,['actionName'=>'__construct', 'request'=>$this->request(), 'response'=>$this->response()])->upload($type);

        $this->writeJson(200, $uri, 'success');
    }


    public function addArticle()
    {
        $data = array(
            //"a"=>1,
           /* "b"=>array(
                "age"=>2,
                "b2"=>null
            ),*/
            "c"=>array(
                "age"=>3,
                "b2"=>"asas"
            ),
            "URL"=>'http://www.baidu.com',
            "regex"=>"121sssss212"
        );
        $validate = new Validate();
        $rules = new Rules();
        $rules->add('a', 'a必须给值')->withRule(Rule::REQUIRED)->withRule(Rule::MIN_LEN, 3);
        $rules->add('b', 'b必须给值')->withRule(Rule::REQUIRED);
        //var_dump($rules);
        $res = $validate->validate($data, $rules);
var_dump($res);
        /*$validate->validate($data, (new Rules())->add('a', 'a必须给值'))
            ->withMsg("a字段不能为空")->withRule(Rule::BETWEEN,-1,3)
            ->withMsg("区间范围错误");*/
        /*$validate->addField("b.b2")->withRule(Rule::REQUIRED)
            ->withMsg('b字段不能为空')->withMsg('b2的全局错误信息')
            ->withRule(Rule::ALPHA);
        $validate->addField("*.age")->withRule(Rule::NUMERIC)
            ->withRule(Rule::BETWEEN,1,2);
        $validate->addField("URL")->withRule(Rule::ACTIVE_URL);
        $validate->addField("regex")
            ->withRule(Rule::REGEX,"/^\d*$/")->withMsg('不符合正则');
        $result = $validate->validate($data);
        var_dump($result->hasError());
        var_dump($result->all());
        var_dump($result->getError("b.b2")->first());
        var_dump($result->getError("not exist")->first());*/

        /*$user = new User();
        $id = $user->addUser($title, $author, $submissionDate);

        $this->writeJson(200, $id, 'success');*/
    }

}