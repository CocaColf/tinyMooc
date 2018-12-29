<?php
/*
数据库操作类
*/
$config = [
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PWD' => 'root',
    'DB_CHARSET' => 'utf8',
    'DB_NAME' => 'graduate'
];

$dop = new DataModel($config);

// 查找
// $res = $dop->field('book_id, username')->table('comment')->where('id=3')->select();
// var_dump($res);

// 增加
// $data = [
//     'book_id' => 9,
//     'username' => 'cocacolf',
//     'content' => 'this is a test'
// ];
// $id = $dop->table('comment')->insert($data);
// var_dump($id);
// var_dump($dop -> sql);

// 修改
// $data = [
//     'book_id' => 12,
//     'username' => 'colf',
//     'content' => 'test over'
// ];
// $dop->table('comment')->where('id=7')->update($data);
// var_dump($dop -> sql);

// 删除
// $dop->table('comment')->where('username="colf"')->delete();
// var_dump($dop->sql);

class DataModel {
    // 主机名
    protected $host;
    // 用户名
    protected $username;
    // 密码
    protected $pwd;
    // 数据库名
    protected $dbname;
    // 字符集
    protected $charset;

    // 数据库连接资源
    protected $link;
    // 表名
    protected $taleName;
    
    // sql语句
    protected $sql;

    // 操作数组
    protected $options;

    function __construct($config) {
        $this -> host = $config['DB_HOST'];
        $this -> username = $config['DB_USER'];
        $this -> pwd = $config['DB_PWD'];
        $this -> dbname = $config['DB_NAME'];
        $this -> charset = $config['DB_CHARSET'];

        // 连接数据库
        $this -> link = $this -> connect();

        // 得到表名
        $this -> tablename = $this -> getTableName();

        // 初始化options数组
        $this -> options = $this -> initOptions();
    }

    // 连接数据库
    // 返回一个 资源（数据库句柄）
    protected function connect() {
        $link = mysqli_connect($this -> host, $this -> username, $this -> pwd, $this -> dbname);

        if(!$link) {
            die('数据库连接错误');
        }

        mysqli_set_charset($link, $this -> charset);

        return $link;
    }

    // 获取表名
    protected function getTableName() {
        // 如果表名已经设置，则直接返回
        if(!empty($this -> tablename)) {
            return $this -> tablename;
        }

        // 如果没有设置，则从类名获取
        $className = get_class($this);
        $tablename = strtolower(substr($className, 0, -5));

        return $tablename;
    }

    // 初始化options数组
    protected function initOptions() {
        $arr = ['where', 'table', 'field', 'order', 'group', 'having', 'limit'];

        // 把options数组里的操作对应的值清空
        foreach($arr as $value) {
            $this -> options[$value] = '';

            // 表要使用已经设置好的表
            if($value == 'table') {
                $this -> options[$value] = $this -> tablename;
            }
        }
    }  

    // field方法 接收操作的参数
    function field($field) {
        if(!empty($field)) {
            if(is_string($field)) {
                $this -> options['field'] = $field;
            } else if(is_array($field)) {
                $this -> options['field'] = join(',', $field);
            }
        }

        return $this;
    }

    // table 方法
    function table($table) {
        if(!empty($table)) {
            $this -> options['table'] = $table;
        }

        return $this;
    }

    // where方法
    function where($where) {
        if(!empty($where)) {
            $this -> options['where'] = 'where '.$where;
        }

        return $this;
    }

    // group方法
    function group($group) {
        if(!empty($group)) {
            $this -> options['group'] = 'group by '.$group;
        }

        return $this;
    }

    // having方法
    function having($having) {
        if(!empty($having)) {
            $this -> options['having'] = 'having '.$having;            
        }

        return $this;
    }

    // order方法
    function order($order) {
        if(!empty($order)) {
            $this -> options['order'] = 'order by '.$order;
        }

        return $this;
    }

    // limit方法
    function limit($limit) {
        if(!empty($limit)) {
            if(is_string($limit)) {
                $this -> options['limit'] = 'limit '.$limit;
            } else if(is_array($limit)) {
                $this -> options['limit'] = 'limit '.join(',', $limit);
            }
            
        }

        return $this;
    }

    // 查询 方法
    function select() {
        // 预写一个sql语句
        $sql = 'select %FIELD% from %TABLE% %WHERE% %GROUP% %HAVING% %ORDER% %LIMIT%';
        // 把sql语句里的占位符用存在options数组内的具体参数给替换
        $sql = str_replace(['%FIELD%', '%TABLE%', '%WHERE%', '%GROUP%', '%HAVING%', '%ORDER%', '%LIMIT%'],
                            [@$this -> options['field'], @$this -> options['table'], @$this -> options['where'], @$this -> options['group'], @$this -> options['having'], @$this -> options['order'], @$this -> options['limit']],
                            $sql                     
                            );
        
        // 保存一份 sql
        $this -> sql = $sql;

        // 执行sql语句, 返回结果集
        return $this -> query($sql);
    }

    // query方法 用于执行sql
    function query($sql) {
        // 清空options，以防没有使用的参数被上一次参数所污染
        $this -> initOptions();
        
        // 存放查找出来的数据库内容
        $newData = [];

        $result = mysqli_query($this -> link, $sql);

        if($result) {
            while($data = mysqli_fetch_assoc($result)) {
                $newData[] = $data;
            }
        }

        return $newData;
    }

    // insert方法
    // $data是关联数组，键是字段名，值是字段对应的插入值
    function insert($data) {
        // 插入数据时，对于字符串需要加双引号
        $data = $this -> parseValue($data);

        // 提取字段
        $keys = array_keys($data);
        // 提取值
        $values = array_values($data);

        // 插入语句模版
        $sql = 'insert into %TABLE%(%FIELD%) values(%VALUES%)';
        // 模版替换
        $sql = str_replace(['%TABLE%', '%FIELD%', '%VALUES%'], 
                            [$this -> options['table'], join(',', $keys), join(',', $values)], 
                            $sql
                        );

        $this -> sql = $sql;

        return $this -> exec($sql, true);
    }

    // 删除方法
    function delete() {
        $sql = 'delete from %TABLE% %WHERE%';
        $sql = str_replace(['%TABLE%', '%WHERE%'], 
                            [$this -> options['table'], $this -> options['where']], 
                            $sql
                        );
        
        $this -> sql = $sql;
        $this -> exec($sql);
    }

    // 更新函数
    // update 表名 set 字段=值，字段=值 where ;
    function update($data) {
        $data  = $this -> parseValue($data);
        $value = $this -> parseUpdate($data);
        $sql = 'update %TABLE% set %VALUE% %WHERE%';
        $sql = str_replace(['%TABLE%', '%VALUE%', '%WHERE%'], [$this -> options['table'], $value, $this -> options['where']], $sql);

        $this -> sql = $sql;
        $this -> exec($sql);
    }

    // 把数组里的字符串加上双引号
    protected function parseValue($data) {
        $newData = [];
        foreach($data as $key => $value) {
            if(is_string($value)) {
                $value = '"'.$value.'"';
            }

            $newData[$key] = $value;
        }

        return $newData;
    }

    // 把数组里的key value 转为update sql 的形式
    protected function parseUpdate($data) {
        $newData = [];
        foreach($data as $key => $value) {
            $newData[] = $key.'='.$value;
        }

        return join(',', $newData);
    }

    // 插入 修改 删除 这几个操作的处理函数
    function exec($sql, $isInsert = false) {
        $this -> initOptions();
        $result = mysqli_query($this -> link, $sql);

        if($result && mysqli_affected_rows($this -> link)) {
            if($isInsert) {
                return mysqli_insert_id($this -> link);
            } else {
                return mysqli_affected_rows($this -> link);
            }
        }

        return false;
    }

    function __get($name) {
        if($name == 'sql') {
            return $this -> sql;
        }

        return false;
    }

    function __destruct() {
        mysqli_close($this -> link);
    }
}
?>