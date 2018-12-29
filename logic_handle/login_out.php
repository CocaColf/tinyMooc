<?php
// 处理退出登录
include('../public/conn.php');

session_start();
$_SESSION = [];

session_destroy();

header('Location:../index.php');
?>