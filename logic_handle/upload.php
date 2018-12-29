<?php
header('Content-Type:text/html;charset=utf-8');

$up = new Upload();
$up -> uploadFile('file');
// var_dump($up -> uploadFile('file'));
// var_dump($classId);
// 文件上传类
class Upload {
    
    // 文件上传后保存路径
    protected $path = '../video/';
    // 允许的后缀
    protected $allowSuffix = ['jpg','mp4','png','JPG'];
    // 允许的mime类型
    protected $allowMime = ['image/png', 'image/jpeg','video/mp4'];
    // 允许上传的最大大小
    protected $maxSize = 23221225000;
    // 是否使用随机名
    protected $isRandName = true;
    protected $prefix = 'up_';

    // 文件的信息
    // 上传时的名字
    protected $oldName;
    // 后缀
    protected $suffix;
    protected $mime;
    protected $size;
    // 临时上传文件夹
    protected $tempName;

    // 文件新名字
    protected $newName;
    // 数据库最新插入的id
    protected $classId;
    // 内层文件名
    protected $innerPath;

    // 上传函数，对外公开的方法  $key是上传文件表单的name值
    function uploadFile($key) {
        // 判断有没有设置路径 path 如果没有设置，那么设置一个错误码
        if(empty($this -> path)) {
            return false;
        }
        // 判断文件是否存在 是否可写
        if(!$this -> check()) {
            return false;
        }

        // 判断 $__FILES的错误码 且 错误码为0时得到文件信息
        @$err = $_FILES[$key]['error'];
        if($err) {
            // var_dump($err);
            return false;
        } else {
            $this -> getInfo($key);
        }

        // 检验上传文件是否合乎要求
        if(!$this -> checkSize() || !$this -> checkMime() || !$this -> checkSuffix()) {
            return false;
        }

        $this -> classId = $this -> getClassId();

        // 得到新名字
        $this -> newName = $this -> createNewName($this -> classId);

        // 创建一个有着数据库id的文件夹放置匹配的视频和文件
        $this -> innerPath = $this -> createInnerPath($this -> classId);

        // 移动至指定文件夹
        if(is_uploaded_file($_FILES[$key]['tmp_name'])) {
            if(move_uploaded_file($_FILES[$key]['tmp_name'], 
                $this -> path.$this -> classId.'/'.$this -> newName)) {
                echo "ok";
                // header('Location:../view/teach.html');
            } else {
                echo '上传失败！';
            }
            
        } else {
            echo '不是上传文件';
        }
        
    }

    // 检查文件夹是否存在、可写
    protected function check() {
        if(!file_exists($this -> path) || !is_dir($this -> path)) {
            mkdir($this -> path, 0777, true);
        }

        if(!is_writeable($this -> path)) {
            chmod($this -> path,0777);
        }

        return true;
    }

    // 得到文件信息
    protected function getInfo($key) {
        // 得到文件名字
        @$this -> oldName = $_FILES[$key]['name'];
        // 得到文件mime类型
        @$this -> mime = $_FILES[$key]['type'];
        // 得到文件临时路径
        @$this -> tempName = $_FILES[$key]['tmp_name'];
        // 得到文件大小
        @$this -> size = $_FILES[$key]['size'];
        // 得到文件后缀
        @$this -> suffix = pathinfo($this -> oldName)['extension'];
    }

    // 检查文件的大小、mime、后缀是否合乎要求
    protected function checkSize() {
        if($this -> size > $this -> maxSize) {
            return false;
        }

        return true;
    }
    protected function checkMime() {
        if(!in_array($this ->mime, $this -> allowMime)) {
            return false;
        }

        return true;
    }
    protected function checkSuffix() {
        if(!in_array($this ->suffix, $this -> allowSuffix)) {
            return false;
        }

        return true;
    }

    // 新名字
    protected function createNewName($classId) {
        if($this -> isRandName) {
            $name = $classId.'.'.$this -> suffix;
        } else {
            $name = $this -> prefix.$oldName;
        }

        return $name;
    }

    // 获取数据库里视频最新的id，将其作为这个新上传视频的名字以做到数据库和文件存储目录一致
    protected function getClassId() {
        include('../public/conn.php');
        $sql = "select count(*) from video";
        $r = mysqli_query($conn,$sql);
        if($r) {
            $rows = mysqli_fetch_assoc($r);
        }
        $classId = array_values($rows)[0];

        return $classId;
    }

    protected function createInnerPath($classId) {
        if(!file_exists($this -> path.$classId) || !is_dir($this -> path.$classId)) {
            mkdir($this -> path.$classId, 0777, true);
        }

        if(!is_writeable($this -> path.$classId)) {
            chmod($this -> path.$classId,0777);
        }

        return true;
    }
}

?>