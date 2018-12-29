<?php
// 处理登录
include('../public/conn.php');
session_start();

$username = $_POST['username'];
$password = md5($_POST['password']);

/*
 这个地方发生了一次神奇的bug
 注册时md5加密存进去的数据和登录md5加密后的数据居然对不上
 打印出来对比才发现
 原来是数据库字段给的varchar太小了
 */
$sql = "select * from user where username='$username' and password='$password'";

$r = mysqli_query($conn,$sql);

if(mysqli_num_rows($r) > 0) {
	$rows = mysqli_fetch_assoc($r);

	// 开启session,自动登录
	session_start();
	$_SESSION['username'] = $rows['username'];
	$_SESSION['user_id'] = $rows['id'];

	header('Location:../index.php');
} else{
	echo "用户名或密码错误,请重新<a href='login.php'>登录</a>";
	var_dump($password);
}