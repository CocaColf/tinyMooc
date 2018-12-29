<?php
include('../dataModel/dataModel.php');

$name = $_POST['name'];
$author = $_POST['author'];

$dop->table('video')->where('name='.$name.'and author='.$author)->delete();
header('Location:../view/delete.html');

?>