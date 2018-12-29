<?php
include('../public/conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>个人主页</title>
    <link rel="stylesheet" href="../static/css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../static/css/home.css">
</head>
<body>
    <?php
    include('../public/header.php');
    ?>
    <div>
        <h3><?php echo @$_SESSION["username"]?$_SESSION["username"]:'用户名'; ?></h3>
        <h4>我的学习</h4>
        <h4>我的收藏</h4>
        <h4>我的评论</h4>
    </div>
</body>
</html>