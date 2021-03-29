<?php
/**
 * 封装PDODB类 使用命名空间
 */

//namespace tool;
class EPDO
{
    /**
     * 定义相关属性
     */
    private $host;   //主机地址
    private $port;     //端口号
    private $user;     //用户名
    private $pass;     //密码
    private $dbname; //数据库名
    private $charset;//字符集
    private $dsn;      //数据源名称
    private $pdo;    //用于存放PDO的一个对象
    // 静态私有属性用于保存单例对象
    private static $instance;

    /**
     * [__construct 构造方法]
     * @param [array] $config [配置数组]
     */
    private function __construct($config)
    {
        // 初始化属性
        $this->initParams($config);
        // 初始化dsn
        $this->initDSN();
        // 实例化PDO对象
        $this->initPDO();
        // 初始化PDO对象的属性
        $this->initAttribute();
    }

    /**
     * [getInstance 获取PDO单例对象的公开方法]
     * @param  [array] $config [description]
     * @return [PDOobject] self::$instance [pdo对象]
     */
    public static function getInstance($config)
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * [initParams 初始化属性]
     * @param  [array] $config [配置数组]
     */
    private function initParams($config)
    {
        $this->host = isset($config['host']) ? $config['host'] : 'localhost';
        $this->port = isset($config['port']) ? $config['port'] : '3306';
        $this->user = isset($config['user']) ? $config['user'] : 'root';
        $this->pass = isset($config['pass']) ? $config['pass'] : '';
        $this->dbname = isset($config['dbname']) ? $config['dbname'] : '';
        $this->charset = isset($config['charset']) ? $config['charset'] : 'utf8';
    }

    /**
     * [initDSN 初始化dsn]
     */
    private function initDSN()
    {
        $this->dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=$this->charset";
    }

    /**
     * [initPDO 实例化PDO对象]
     * @return [boolean] [false|none]
     */
    private function initPDO()
    {
        // 在实例化PDO对象的时候自动的走异常模式（也是唯一走异常模式的地方）
        try {
            $this->pdo = new PDO($this->dsn, $this->user, $this->pass);
        } catch (PDOException $e) {
            $this->my_error($e);
        }
    }

    /**
     * [initAttribute 初始化PDO对象属性]
     * @return [boolean] [false|none]
     */
    private function initAttribute()
    {
        // 修改错误模式为异常模式
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * [my_error 输出异常信息]
     * @param  [PDOException] $e [异常对象]
     * @return [boolean]    [false|none]
     */
    private function my_error($e, $sql)
    {
        echo "执行sql语句失败!<br/>";
        echo "错误语句为:", $sql, "<br/>";
        echo "错误的代码是:", $e->getCode(), "<br/>";
        echo "错误的信息是:", $e->getMessage(), "<br/>";
        echo "错误的脚本是:", $e->getFile(), "<br/>";
        echo "错误的行号是:", $e->getLine(), '<br/>';
        return false;
    }

    /**
     * [my_query 执行一条sql语句，实现增删改]
     * @param  [string] $sql [sql语句]
     * @return [array] $result [资源结果集]
     */
    public function my_query($sql)
    {
        // 其实就是调用pdo对象中的exec方法
        try {
            $result = $this->pdo->exec($sql);
        } catch (PDOException $e) {
            $this->my_error($e, $sql);
        }
        return $result;
    }

    /**
     * [fetchAll 查询所有]
     * @param  [string] $sql [sql语句]
     * @return [arry] $result [资源结果集]
     */
    public function fetchAll($sql)
    {
        // 其实就是调用PDOStatment对象里面的fetchAll方法
        try {
            $stmt = $this->pdo->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // 关闭游标，释放结果集
            $stmt->closeCursor();
        } catch (PDOException $e) {
            $this->my_error($e, $sql);
        }
        return $result;
    }

    /**
     * [fetchRow 查询一条]
     * @param  [string] $sql [sql语句]
     * @return [arry] $result [资源结果集]
     */
    public function fetchRow($sql)
    {
        // 其实就是调用PDOStatment对象里面的fetch方法
        try {
            $stmt = $this->pdo->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // 关闭游标，释放结果集
            $stmt->closeCursor();
        } catch (PDOException $e) {
            $this->my_error($e, $sql);
        }
        return $result;
    }

    /**
     * [fetchColumn 查询单行单列]
     * @param  [string] $sql [sql语句]
     * @return [arry] $result [资源结果集]
     */
    public function fetchColumn($sql)
    {
        // 其实就是调用PDOStatment对象里面的fetchColumn方法
        try {
            $stmt = $this->pdo->query($sql);
            $result = $stmt->fetchColumn();
            // 关闭游标，释放结果集
            $stmt->closeCursor();
        } catch (PDOException $e) {
            $this->my_error($e, $sql);
        }
        return $result;
    }

    /**
     * [my_prepare sql预处理]
     * @param  [string] $sql [有占位符的sql语句]
     * @param  [array] $arr [对象数组]
     */
    public function my_prepare($sql, $arr)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($arr);
        } catch (PDOException $e) {
            $this->my_error($e, $sql);
        }
    }

    /**
     * [my_rowCount 查询结果中的总行数]
     * @param  [string] $sql [有占位符的sql语句]
     * @return [string] $count [查询结果的总行数]
     */
    public function my_rowCount($sql)
    {
        try {
            $stmt = $this->pdo->query($sql);
            $count = $stmt->rowCount();
        } catch (PDOException $e) {
            $this->my_error($e, $sql);
        }
        return $count;
    }

    /**
     * [my_rowCount 获取查询结果中的总列数（总字段数）]
     * @param  [string] $sql [有占位符的sql语句]
     * @return [string] $count [获取查询结果中的总列数（总字段数）]
     */
    public function my_columnCount($sql)
    {
        try {
            $stmt = $this->pdo->query($sql);
            $count = $stmt->columnCount();
        } catch (PDOException $e) {
            $this->my_error($e, $sql);
        }
        return $count;
    }

    /**
     * [fetchObject 查询一个对象]
     * @param  [string] $sql [查询一行的sql语句]
     * @return [object] $object [目标对象]
     */
    public function fetchObject($sql)
    {
        try {
            $stmt = $this->pdo->query($sql);
            //$stmt->fetch(PDO::FETCH_BOJ);
            $object = $stmt->fetchObject();
        } catch (PDOException $e) {
            $this->my_error($e, $sql);
        }
        return $object;
    }


    /**
     * [__clone 私有化克隆方法，保护单例模式]
     */
    private function __clone()
    {
    }


    /**
     * [__set 为一个不可访问的属性赋值的时候自动触发]
     * @param [string] $name  [属性名]
     * @param [mixed] $value [属性值]
     */
    public function __set($name, $value)
    {
        $allow_set = array('host', 'port', 'user', 'pass', 'dbname', 'charset');
        if (in_array($name, $allow_set)) {
            //当前属性可以被赋值
            $this->$name = $value;
        }
    }


    /**
     * [__get *获得一个不可访问的属性的值的时候自动触发]
     * @param  [string] $name [属性名]
     * @return [string] $name的value [该属性名的值]
     */
    public function __get($name)
    {
        $allow_get = array('host', 'port', 'user', 'pass', 'dbname', 'charset');
        if (in_array($name, $allow_get)) {
            return $this->$name;
        }
    }


    /**
     * [__call 访问一个不可访问的对象方法的时候触发]
     * @param  [string] $name     [属性名]
     * @param  [array] $argument [参数列表]
     */
    public function __call($name, $argument)
    {
        echo "对不起,您访问的" . $name . "()方法不存在!<br/>";
    }

    /**
     * [__callstatic 访问一个不可访问的类方法(静态方法)的时候触发]
     * @param  [string] $name     [属性名]
     * @param  [array] $argument [参数列表]
     */
    public static function __callStatic($name, $argument)
    {
        echo "对不起,您访问的" . $name . "()静态方法不存在!<br/>";
    }
}