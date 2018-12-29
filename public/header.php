<!--导航栏-->

<nav class="navbar navbar-default container " role="navigation" id="nav">
            <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="navbar-header ">
                    <a class="navbar-brand" href="../index.php">湘潭大学邵峰课堂</a>
                </div>
            </div>

          

            <div class="col-sm-4 col-md-4 col-lg-4">
                <form class="navbar-form navbar-left " role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <a href="#" type="submit" class="btn btn-default">搜索课程</a>
                </form>
            </div>

            
            <div class="col-sm-4 col-md-4 col-lg-4">
                <ul class="nav navbar-nav pull-right">
                    <li><a href="./view/person.php">我的学习</a></li>
                    <?php
                    session_start();
                    if(@$_SESSION['user_id']) {
                        $username = $_SESSION["username"];
                        echo '<li><a>'.$username.'</a></li>';
                        echo '<li><a href="./logic_handle/login_out.php">退出</a></li>';
                    } else {
                        echo '<li><a id="log">登录</a></li>';
                        echo '<li><a id="reg">注册</a><li>';
                    }
                    ?>
                    
                </ul>
            </div>
            
</nav>



        