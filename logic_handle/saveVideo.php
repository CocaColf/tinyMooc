<?php
include('../public/conn.php');

$name = $_POST['name'];
$author = $_POST['author'];
$description = $_POST['description'];
$acmy = $_POST['acmy'];

$classId = null;
if(!empty($name) || !empty($author) || !empty($description) || !empty($acmy)) {
    $sql = "insert into video(name,author,description,acmy) values('$name','$author','$description','$acmy')";
    mysqli_query($conn, $sql);
}

header('Location:../view/teach.html');

?>