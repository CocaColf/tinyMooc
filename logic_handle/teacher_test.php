<?php
header('Content-Type:text/html;charset=utf-8');
$teacher_code = $_POST['teacher_code'];
if($teacher_code == 123456) {
    header('Location:../view/choice.php');
} else {
    echo "教师码输入错误";
}