<?php
include('../public/conn.php');
header('Content-Type:text/html;charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../static/css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../static/css/home.css">
    <title>院系</title>
    <style>
        .acmy {
            
        }
        h3.acmyName {
            text-align: left;
        }
        .nextAcmy {
            padding: 5px;
            border-bottom: 1px solid rgba(40,41,43,0.25);
        }
        .classChoice {
            border:1px solid rgba(39,41,43,0.15);
            background-color:#f9f9f9;
            margin-bottom: 2%;
        }
        
        .classChoice .breadcrumb a {
            color:#000;
            font-size: 16px;
            background-color: #fafafa;
        }
        ul.acmyList li {
            float: left;
            padding: 3px;
        }
    </style>
</head>
<body>
    <?php
        include('../public/header.php');
    ?>
    <div class="container classChoice">
        <ol class="breadcrumb">
            <li><a href="../home.php">首页</a></li>
            <li><a href="#">院系</a></li>
        </ol>
        <ul class="acmyList">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=哲学系">哲学系</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=历史系">历史系</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=商学院">商学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=公共管理学院">公共管理学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=法学院 知识产权学院">法学院 知识产权学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=信用风险管理学院">信用风险管理学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=马克思主义学院">马克思主义学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=文学与新闻学院">文学与新闻学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=外国语学院">外国语学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=数学与计算科学学院">数学与计算科学学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=物理与光电工程学院">物理与光电工程学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=材料科学与工程学院">材料科学与工程学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=化学学院">化学学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=化工学院">化工学院</a> </li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=机械工程学院">机械工程学院</a> </li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=信息工程学院">信息工程学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=土木工程与力学学院">土木工程与力学学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=环境与资源学院">环境与资源学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=体育教学部">体育教学部</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=艺术学院">艺术学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=国际交流学院">国际交流学院</a></li></div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><li><a href="../logic_handle/classList.php?acmy=兴湘学院">兴湘学院</a></li></div>
            
        </ul>                                                               
    </div>
    <div class="container acmy clearfix">
        <?php
        // header('Content-Type:text/html;charset=utf-8');
            // 获取院系
            include('../public/conn.php');

            //  得到图片的格式
            function getImageFix($classId) {
                $path = '../video';
                $dir = opendir('../video');

                for($i = 0; $i < ($classId + 1); $i++) {
                    readdir($dir);
                }
                $new_dirName = readdir($dir);
                // $a = opendir($path.'/'.$new_dirName);
                // var_dump(count($a));
                $list = scandir($path.'/'.$new_dirName);
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

            $sql = "select distinct acmy from video";
            $r = mysqli_query($conn, $sql);
           
        while($rows = mysqli_fetch_assoc($r)) {
            echo '
                
                <h3 class="acmyName">'.$rows['acmy'].'</h3>';
                echo '<div class="row nextAcmy">';
               
                $sql2 = "select * from video where acmy=".'"'.$rows['acmy'].'"';
                $r2 = mysqli_query($conn, $sql2);
                
            
                while($rows2 = mysqli_fetch_assoc($r2)) {
                    // var_dump($rows2);
                    $classId = $rows2['id'];
                    $className = $rows2['name'] ;
                    $author = $rows2['author'];
                    $acmy = $rows2['acmy'];
                    
                    echo '
                    <div class="col-sm-6 col-md-4 col-lg-3" id="thumbnail" data-toggle="modal" data-target="#myModal">
                    
                        <a href="./vedio.php?classId='. $classId.'" class="thumbnail" >
                            <img src="../video/'.$classId.'/'.$classId.'.'.getImageFix($classId).'" alt="课程名字" id="img">
                            <p>'.$className.'</p>
                            <span>'.$acmy.' '.$author.'</span>
                        </a>
                    </div>
                    ';
                }
                    
                echo '</div>';
        }
        ?>
        
    </div>

    

</body>
<script src="../static/js/alertReg.js"></script>
<script src="../static/js/jquery.js"></script>
<script src=".../static/js/bootstrap.js"></script>
</html>