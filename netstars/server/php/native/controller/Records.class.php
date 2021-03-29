<?php
// php 相对定位与绝对定位的关系 参看文档
require 'D:\project\netstars\netstars\server\php\native\tool\EPDO.class.php';

/**
 * 测试控制器
 * 使用面向对象完成
 * 封装
 * 继承
 * 多态
 *
 */
class Records
{
    private $db;

    public function __construct()
    {
        $CONFIG = ['dbname' => 'netstars'];
        $this->db = EPDO::getInstance($CONFIG);
    }


    public function b()
    {

        echo $_SERVER['DOCUMENT_ROOT'];
        echo 'hello';
    }

    public function getRecords()
    {
        $sql = 'select * from log where  1=1 ';
        $result = $this->db->fetchAll($sql);

        exit(json_encode(['status' => 1, 'result' => $result]));
    }

    public function saveData()
    {
        $content = $_GET['content'];
        $title = $_GET['title'];
        $sql = " INSERT INTO log (title,content) VALUE ('$title','$content')";
        $result = $this->db->my_query($sql);
        exit(json_encode(['status' => 1, 'result' => $result]));
    }

    public function getDetail()
    {
        $id = $_GET['id'];
        $sql = 'select * from log where  id= ' . $id;
        $result = $this->db->fetchRow($sql);
        exit(json_encode(['status' => 1, 'result' => $result]));
    }
}


