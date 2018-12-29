<?php
    function getImageFix($classId) {
        $path = 'D:\phpStudy\WWW\graduate\tinyMooc\video';
        $dir = opendir('D:\phpStudy\WWW\graduate\tinyMooc\video');
        
        // 跳过两个特殊的文件夹 . 和 ..
        for($i = 0; $i < (@$classId + 1); $i++) {
            readdir($dir);
        }
        // 需要用到的文件夹
        $new_dirName = readdir($dir);
        
        // 扫描文件夹下的文件
        $list = scandir($path.'/'.$new_dirName);

        // 判断每个文件夹下的文件后缀
        for($i = 0; $i < count($list); $i++) {
            $fix = substr($list[$i], -3);
            if($fix == 'jpg') {
                return $fix;
            }
            if($fix == 'png') {
                return $fix;
            }
        }
    }

    function countDir($dirname) {
        global $dirnum, $filenum;

        if(!file_exists($dirname)) {
                return false;
        }

        $dir = opendir($dirname);
        readdir($dir);
        readdir($dir);
        
        while($filename = readdir($dir)) {
                $newfile = $dirname.'/'.$filename;
                if(is_dir($newfile)) {
                        countDir($newfile);
                        $dirnum++;
                } else {
                        $filenum++;
                }
        }

        return array($dirnum, $filenum);
}

