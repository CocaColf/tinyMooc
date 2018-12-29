<?php
header('Content-Type:text/html;charset=utf-8');
include('../public/conn.php');
session_start();

$classId = $_GET['classId'];
$content = $_POST['content'];
@$username = $_SESSION["username"];

if(isset($_SESSION["username"])) {
    $sql = 'insert into comment(content,user,v_id) values("'.$content.'","'.$username.'",'.$classId.')';
    $r = mysqli_query($conn, $sql);
    var_dump($sql);
    if($r) {
        header('Location:'.getenv("HTTP_REFERER"));
    } else {
        echo '评论失败';
    }
} else {
    echo "请登录";
}


?>