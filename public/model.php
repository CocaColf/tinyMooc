<?php
header('Content-Type:text/html;charset=utf-8');

$config = include('config.php');
$m = new Model($config);

// 增加数据 insert
/* 
$data = [
    'username' => '肖磊',
    'password' => 123456
];
$m->table('user')->insert($data); 
*/

// 删除数据
/* 
$m->table('user')->where('username="肖磊"')->delete();
 */ 

// 修改数据
/* 
$data = [
    'username' => '肖磊',
    'password' => 123456
];
$m->table('user')->where('id=3')->update($data);
 */

 // 查找数据
/* 
$arr = $m->field('username')->table('user')->where('id=3')->select();
echo $arr[0]['username']; 
var_dump($m -> sql);
 */


class Model {
    // 数据库主机
    protected $host;
    // 用户名
    protected $username;
    protected $pwd;
    // 数据库名
    protected $dbname;
    // 数据库字符集
    protected $charset;   

    // 数据库连接资源
    protected $link;
    // 表名
    protected $tableName;

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
        $this -> link = $this -> connent();

        // 得到表名
        $this -> tableName = $this -> getTableName();

        // 初始化options数组
        $this -> options = $this -> initOptions();
        
    }

    // 连接数据库
    protected function connent() {
        
        $link = mysqli_connect($this -> host, $this -> username, $this -> pwd, $this -> dbname);
        if(!$link) {
            die('数据库连接错误');
        }

        mysqli_set_charset($link, $this -> charset);
        return $link;
    }


    // 得到表名
    protected function getTableName() {
        // 如果已经设置了表名，那么直接返回
        if(!empty($this -> tableName)) {
            return $tableName;
        }

        // 如果没有设置表名，那么通过类名获取表名。 因为按照规则来继承Model类，如 user表对应 UserModel类
            // 得到当前类类名
        $className = get_class($this);
        $tableName = strtolower(substr($className, 0, -5));
        return $tableName;
    }

    // 初始化options数组
    protected function initOptions() {
        $arr = ['where', 'table', 'field', 'order', 'group', 'having', 'limit'];
        // 把options数组里的操作对应的值清空
        foreach($arr as $value) {
            $this -> options[$value] = ' ';
            // 将table默认设置为tableName
            if($value == 'table') {
                $this -> options[$value] = $this -> tableName;
            }
        }
    }

    // field方法 (参数)
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

    // table方法
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

    // select方法
    function select() {
        // 先预写一个具有占位符的sql语句
        $sql = 'select %FIELD% from %TABLE% %WHERE% %GROUP% %HAVING% %ORDER% %LIMIT%';
        // 将options里的值依次替换上面的占位符  其中加入 @ 是为了屏蔽掉在没有调用某个函数时出现的 notice:undefined index
        $sql = str_replace(['%FIELD%', '%TABLE%', '%WHERE%', '%GROUP%', '%HAVING%', '%ORDER%', '%LIMIT%'], [@$this -> options['field'], @$this -> options['table'], @$this -> options['where'], @$this -> options['group'], @$this -> options['having'], @$this -> options['order'], @$this -> options['limit']], $sql);

        // 保存一份sql语句
        $this -> sql = $sql;

        // 执行sql语句 返回结果集
         return $this -> query($sql);
    }

    // query方法 用于执行sql
    function query($sql) {
        $this -> initOptions();
        $newData = [];
        // var_dump($sql);
        // die();
        $result = mysqli_query($this -> link, $this -> sql);
        if($result && mysqli_affected_rows($this -> link)) {
            while($data = mysqli_fetch_assoc($result)) {
                $newData[] = $data;
            }
        }

        return $newData;
    }

    // insert方法
    // $data是关联数组，键是字段名，值是字段对应的插入值
    function insert($data) {
        // 要更新的值如果是一个字符串，那么需要加上双引号
       $data = $this -> parseValue($data);
        // 提取字段
        $keys = array_keys($data);
        // 提取值
        $values = array_values($data);
        // 插入语句模版
        $sql = 'insert into %TABLE%(%FIELD%) values(%VALUES%)';
        // 模版替换
        $sql = str_replace(['%TABLE%', '%FIELD%', '%VALUES%'], [$this -> options['table'], join(',', $keys), join(',', $values)], $sql);
        
        $this -> sql = $sql;

        return $this -> exec($sql, true);
    }

    // 删除函数
    function delete() {
        $sql = 'delete from %TABLE% %WHERE%';
        $sql = str_replace(['%TABLE%', '%WHERE%'], [$this -> options['table'], $this -> options['where']], $sql);

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

    protected function parseValue($data) {
        $newData = [];
        foreach($data as $key => $value) {
            if(is_string($value)) {
                $value= '"'.$value.'"';
            }
            $newData[$key] = $value;
        }

        return $newData;
    }

    protected function parseUpdate($data) {
        $newData = [];
        foreach($data as $key => $value) {
            $newData[] = $key.'='.$value;
        }

        return join(',', $newData);
    }
    // 插入 修改 删除 处理函数
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