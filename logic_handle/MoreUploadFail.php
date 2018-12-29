<?php
header('Content-Type:text/html;charset=utf-8');
$up = new Upload();
$up -> uploadFile('file');

// 文件上传类
class Upload {

    // 文件上传后保存路径
    protected $path = '../video/';
    // 允许的后缀
    protected $allowSuffix = ['jpg','mp4'];
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

    // 上传函数，对外公开的方法  $key是上传文件表单的name值
    function uploadFile($key) {
        // 得到上传文件个数
        $fileNum = count($_FILES[$key]['name']);

        // 判断有没有设置路径 path 如果没有设置，那么设置一个错误码
        if(empty($this -> path)) {
            return false;
        }
        // 判断文件是否存在 是否可写
        if(!$this -> check()) {
            return false;
        }

        // 判断 $__FILES的错误码 且 错误码为0时得到文件信息
        $err = $_FILES[$key]['error'];
        // 得到文件个数
        for($i = 0; $i < $fileNum; $i++) {
            if($err[$i]) {
                var_dump($err);
                echo "第".$i."个文件出现了错误";
                return false;
            } else {
                $this -> getInfo($key);
            }
        }
        

        // 检验上传文件是否合乎要求
        if(!$this -> checkSize() || !$this -> checkMime() || !$this -> checkSuffix()) {
            return false;
        }

        // 得到新名字
        $this -> newName = $this -> createNewName();

        // 移动至指定文件夹
        for($i = 0; $i < $fileNum; $i++) {
            if(is_uploaded_file($_FILES[$key]['tmp_name'][$i])) {
            if(move_uploaded_file($_FILES[$key]['tmp_name'][$i], $this -> path.$this -> newName)) {
                echo '上传成功！';
            } else {
                echo '上传失败！';
            }
        } else {
            echo '不是上传文件';
        }
        } 

    }

    // 检查文件是否存在、可写
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
        for($i=0; $i<2; $i++) {
            // 得到文件名字
            $this -> oldName = $_FILES[$key]['name'][$i];
            // 得到文件mime类型
            $this -> mime = $_FILES[$key]['type'][$i];
            // 得到文件临时路径
            $this -> tempName = $_FILES[$key]['tmp_name'][$i];
            // 得到文件大小
            $this -> size = $_FILES[$key]['size'][$i];
            // 得到文件后缀
            $this -> suffix = pathinfo($this -> oldName)['extension'];
        }
        
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
    protected function createNewName() {
        if($this -> isRandName) {
            $name = $this -> prefix.uniqid().'.'.$this -> suffix;
        } else {
            $name = $this -> prefix.$oldName;
        }

        return $name;
    }

}

?>