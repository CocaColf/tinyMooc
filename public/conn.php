<?php
//数据库统一文件
// header('Content-Type:text/html;charset=utf-8');

$conn = mysqli_connect('localhost','root','root','graduate') or die('数据库连接错误');
mysqli_query($conn, 'set names utf8');
?>