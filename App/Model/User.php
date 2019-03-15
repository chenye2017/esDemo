<?php
/**
 * Created by PhpStorm.
 * User: cy
 * Date: 2019/3/4
 * Time: 16:00
 */

namespace App\Model;


use EasySwoole\Core\Component\Di;

class User
{
    protected $db;
    protected $tableName = 'article';
    public function __construct()
    {
        $db = Di::getInstance()->get("MYSQL");

        if($db instanceof \MysqliDb){
            $this->db = $db;
        }
    }

    public function getUserInfoList()
    {
        return $this->db->get($this->tableName);
    }

    public function addUser($title, $author, $submissionDate)
    {
        $data = [
            'title' => $title,
            'author' => $author,
            'submission_date' => $submissionDate
        ];

        return $this->db->insert($this->tableName, $data);
    }
}