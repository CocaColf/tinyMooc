<?php
include('../public/conn.php');
session_start();
// 处理注册

//  接收数据
$username = $_POST['username'];
$password = $_POST['password'];

// 加密处理
$password = md5($password);

// 校验数据格式
if(!empty($username) || !empty($password)) {
	$sql = "insert into user(username,password) values('$username', '$password')";
	$r = mysqli_query($conn,$sql);
	if($r) {
		$id = mysqli_insert_id($conn);
		//自动登录
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['user_id'] = $id;

		header('Location:../home.php');
	}
} else {
	echo "注册出现错误";
	echo mysqli_error($conn);
}

?>