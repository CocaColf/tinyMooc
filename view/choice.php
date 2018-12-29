<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../static/css/bootstrap.css">
</head>
<body>
        <ol class="breadcrumb">
                <li>选择你要进行的操作:</li>
                <li><a href="choice.php?choice=1" class="upload">上传视频</a></li>
                <li><a href="choice.php?choice=2" class="delete">删除视频</a></li>
                <li><a href="choice.php?choice=3" class="update">编辑视频</a></li>
        </ol>
        <?php
          @$choice = $_GET['choice'];
          if(empty($choice)) {
                include('./teach.html');                
          } else {
                if($choice == 1) {
                        include('./teach.html');
                } else if($choice == 2) {
                        include('./delete.html');
                } else if($choice == 3) {
                        include('./update.html');
                }
          }
          
        ?>
</body>
</html>