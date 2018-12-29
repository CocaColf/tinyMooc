<?php
include('../public/conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../static/css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../static/css/vedio.css">
    <title>湘潭大学邵峰课堂</title>
</head>
<body>
    
        <?php
        include('../public/header.php');
        ?>
   

    <div class="classList">
    <?php
        include('../public/conn.php');

        $id = $_GET['classId'];
        $sql = "select * from video where id=".$id;
        $r = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($r);
        
        echo '
        <div class="col-sm-2 col-md-2 col-lg-2 classInfo">
            <div class="classname"><h4>'.$rows['name'].'</h4></div>
            <div class="classname"><h4>'.$rows['acmy'].'-'.$rows['author'].'</h4></div>
            <div class="classIntro">
                <p>'.$rows['description'].'</p>
            </div>
        </div>
        ';
        
        
        echo '
        <div class="classVideo col-sm-6 col-md-6 col-lg-6 col-md-offset-1">
            <div class="classTitle">
                <div class="className"><h4>'.$rows['name'].'</h4></div>
                <div class="classTime">
                    <div class="col-sm-6 col-md-10 col-lg-6">
                        <p>创建于'.$rows['up_time'].'</p>
                    </div>
                </div>
            </div>

            <div class="videoArea"><video src="../video/' . $id. '/'. $id.'.'.'mp4'.'"  controls></video></div>
            <div class="classOprate">
                <div class="col-sm-3 col-md-3 col-lg-3 ">
                <a href=""><span class="glyphicon glyphicon-send share"> 分享</span></a>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 ">
                    <a href=""><span class="glyphicon glyphicon-star share"> 收藏<span><a>
                </div>
            </div>
        </div>
        ';

        // 引入自定义函数库，避免路径发生交叉错误，使用绝对路径
        include('D:\phpStudy\WWW\graduate\tinyMooc/getImageFix.php');
        // 引入数据库处理类
        include('../dataModel/dataModel.php');

        // 得到 video目录下所有的文件夹数目，这个数目和生成随机数的范围有关
        $a = countDir('../video')[0];
        $recomend = [];
        for($i=0;$i<6;$i++) {
                $m = mt_rand(1, $a);
                array_push($recomend, $m);
        }

        // 去重
        $recomends = array_unique($recomend);
        // 只需要得到数组值,因为去重时会把重复的那个数字的键去掉,所以不会形成一个有序的排列
        $recomends = array_values($recomends);

        echo '
        <div class="col-sm-2 col-md-2 col-lg-2 classtuijian">
            <div class="classname"><h4>推荐视频</h4></div>
        ';

        // 遍历,从数据库内获取相应的内容
        foreach($recomends as $res) {
            // 这个地方要注意,每次遍历后只会得到一个数组,并不是一次性会取出所有的数组对应的内容
            $ans = $dop->field('*')->table('video')->where('id='.$res)->select();

            // 使用 getImageFix函数获得文件后缀，避免重复判断
            echo '
            <div class="content">
                <img src="../video/'.$res.'/'.$res.'.'.getImageFix($res).'">
                <a href="./vedio.php?classId='. $res.'">'.$ans[0]["name"].'</a>
            </div> ';

        }
        echo '</div>';

        ?>        
    </div>

    <div class="container discuss">
            <div class="info_num">
                <div>
                    <h4>发表评论</h4>
                    <span>当前一共 条评论</span>
                </div>
            </div>
            <hr>
            <div class="info_choose">
                <ul>
                    <li><a href="#">所有评论</a> </li>
                </ul>
            </div>
            
            <div class="show_choose">
                <!-- 显示评论 -->
                <?php
                        $sql_comment = 'select * from comment where v_id='.$id;
                        $rcomment = mysqli_query($conn, $sql_comment);
                        while($rows_comment = mysqli_fetch_assoc($rcomment)) {
                            echo '
                                <div id="choose_info_title">
                                    <span>'.$rows_comment["subTime"].'</span>
                                    <span>'.$rows_comment["user"].'</span>
                                </div>
    
                                <div class="choose_info_content">
                                    <p>'.$rows_comment["content"].'</p>
                                </div>
                        ';
                        }
                    ?>
            </div>
            

            <div class="input_comment">
                <form action="../logic_handle/commit.php?" method="post" id="comment_save">
                    <textarea name="content" class="form-control" rows="3"></textarea>
                    <input type="submit" class="form-control btn btn-primary">
                </form>
            </div>
        </div>
        
</body>
<script>

    function GetUrlPara() {
        var url = document.location.toString();
        var arrUrl = url.split("?");
        var para = arrUrl[1];
　　　　 return para;
    }

    var comment_save = document.getElementById('comment_save');
    comment_save.onsubmit = function() {
        comment_save.action = comment_save.action + GetUrlPara();
    }
</script>
</html>