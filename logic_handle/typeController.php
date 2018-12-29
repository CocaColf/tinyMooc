<?php
$type = $_GET['type'];

if($type == 'class') {
    header('Location:../view/type.php');
} else if($type == 'discuss') {
    header('Location:./type/discuss.php');
} else if($type == 'compete') {
    header('Location:./type/info.php');
}

?>