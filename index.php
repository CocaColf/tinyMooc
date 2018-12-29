<?php
    include('./public/conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>湘潭大学MOOC</title>
    <link rel="stylesheet" href="./static/css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./static/css/home.css">
</head>
<body>
    <!-- 模态框 -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
       
            <!-- 模态框头部 -->
            <div class="modal-header">
              <p class="modal-title">请输入教师后台密码</p>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
       
            <!-- 模态框主体 -->
            <div class="modal-body">
              <form action="./logic_handle/teacher_test.php" method="post">
                  <input type="password" class="form-control" name="teacher_code">
                  <br>
                  <input type="submit" class="form-control btn-info">
              </form>
            </div>
          </div>
        </div>
      </div>

    <!--教学管理中心-->
    <div class="nav nav-bar container">
        <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a  class="pull-right" data-toggle="modal" data-target="#myModal">教学管理中心</a>
        </div>
    </div>
        
        <?php
        include('./public/header.php');
        ?>

        <div id="blackdiv"></div>
        <form class="regin" action="./logic_handle/login.php" method="post" id="regin">
            <div class="pannel">
                    <div class="g_modal_closeBtn" id="close">X</div>
            </div>

            <div class="form-oprate">
                <div class="info">
                    <p>注册邵峰学堂帐号</p>
                </div>
                <div class="inputarea">
                        <div class="inputplace">
                                <input type="text" placeholder="输入您的邮箱或手机号">
                                <span>仅支持Gmail邮箱</span>
                                <input type="text" placeholder="输入您的用户名" name="username">
                                <span>不能包含&%等特殊字符</span>
                                <input type="password" placeholder="输入密码" name="password">
                                <span>密码长度不能少于6位</span>
                                <input type="submit" value="注册">
                                <span class="changeway">已有帐号，立即<a href="" id="toReg">登录</a></span>
                        </div>
                </div>
            </div>
        </form>

        <form class="login" action="./logic_handle/reg.php" method="post" id="login">
            <div class="pannel">
                    <div class="g_modal_closeBtn" id="close2">X</div>
            </div>

            <div class="form-oprate">
                <div class="info">
                    <p>登录邵峰学堂帐号</p>
                </div>
                <div class="inputarea">
                        <div class="inputplace">
                                <input type="text" placeholder="输入您的用户名" name="username">
                                <span>不能包含&%等特殊字符</span>
                                <input type="password" placeholder="输入密码" name="password">
                                <span>密码长度不能少于6位</span>
                                <input type="submit" value="登录">
                        </div>
                </div>
            </div>
        </form>

    <!-- 轮播图 -->
    <div class="container">
        <div id="myCarousel" class="carousel slide">  
            <ol class="carousel-indicators">  
                <li data-target="#myCarousel" data-slide-to="0" class="active"> </li>  
                <li data-target="#myCarousel" data-slide-to="1"> </li>  
                <li data-target="#myCarousel" data-slide-to="2"> </li>  
                
            </ol>   
            <div class="carousel-inner">  
                <div class="item active" style="background:#223240;">  
                    <img src="./static//image/1.png" alt="第一张" />  
                </div>  
                <div class="item" style="background:#F5E4DC;">  
                    <img src="./static/image/2.jpg" alt="第二张" />  
                </div>  
                <div class="item" style="background:#DE2A2D;">  
                    <img src="./static/image/3.jpg" alt="第三张" />  
                </div>  
            
            </div>  
        
            <a href="#myCarousel" data-slide="prev" class="carousel-control left">  
                <span class="glyphicon glyphicon-chevron-left"> </span>  
            </a>  
            <a href="#myCarousel" data-slide="next" class="carousel-control right">  
                <span class="glyphicon glyphicon-chevron-right"> </span>  
            </a>  
        </div>  
    </div>

    <div class="container">
        <h3>热门标签</h3>
        <div class="btn-group" role="group" aria-label="..." id="tag-list">
            <span type="button" class="btn btn-sm btn-info"><a href="./logic_handle/typeController.php?type=class">院系</a></span>            
            <span type="button" class="btn btn-sm btn-info"><a href="">计算机</a></span>
            <span type="button" class="btn btn-sm btn-warning"><a href="">数学</a></span>
            <span type="button" class="btn btn-sm btn-success"><a href="">物理</a></span>
            <span type="button" class="btn btn-sm btn-danger"><a href="">哲学</a></span>            
        </div>
    </div>

    <!--课程列表-->
    <div class="container ">
        <h3>最新视频</h3>
        <div class="row">

        <?php
        // include('./public/conn.php');
        include('./dataModel/dataModel.php');
        include('./getImageFix.php');
        
        $res = $dop->field('*')->table('video')->order('up_time desc')->limit(12)->select();
        foreach($res as $rows) {
            echo '
            <div class="col-sm-6 col-md-4 col-lg-3" id="thumbnail">
            
                <a href="./view/vedio.php?classId='. $rows['id'].'" class="thumbnail" >
                    <img src="./video/'.$rows['id'].'/'.$rows['id'].'.'.getImageFix($rows['id']).'" alt="课程名字" id="img">
                    <p>'.$rows['name'].'</p>
                    <span>'.$rows['acmy'].' '.$rows['author'].'</span>
                </a>
            </div>
            ';
        }
        ?>
       
    </div>

<?php

// 得到 video目录下所有的文件夹数目，这个数目和生成随机数的范围有关
$a = countDir('./video')[0];
    $recomend = [];
    for($i=0;$i<6;$i++) {
            $m = mt_rand(1, $a);
            array_push($recomend, $m);
    }

    // 去重
    $recomends = array_unique($recomend);
    // 只需要得到数组值,因为去重时会把重复的那个数字的键去掉,所以不会形成一个有序的排列
    $recomends = array_values($recomends);
?>
    <div><h3>猜你喜欢</h3></div>
        <div class="row">
            <?php
                foreach($recomends as $res) {
                    $ans = $dop->field('*')->table('video')->where('id='.$res)->select();
                    echo '
                    <div class="col-sm-6 col-md-4 col-lg-3" id="thumbnail">
            
                        <a href="./view/vedio.php?classId='. $res.'" class="thumbnail" >
                            <img src="./video/'.$res.'/'.$res.'.'.getImageFix($res).'">
                            <p>'.$ans[0]["name"].'</p>
                            <span>'.$ans[0]['acmy'].' '.$ans[0]['author'].'</span>
                        </a>
                    </div>
                    ';
                }
            ?>   
        </div>

    
    
   
    <div class="footer">
        <div class="copyright">
            <h4>Copyright 2018 湘潭大学</h4>
            <h6>开发人员：肖磊</h6>
        </div>
    </div>



</body>
<script src="./static/js/alertReg.js"></script>
<script src="./static/js/jquery.js"></script>
<script src="./static/js/bootstrap.js"></script>
<script>
     //自动播放  
     $("#myCarousel").carousel({  
            interval :3000,  
        });  

    
</script>
</html>