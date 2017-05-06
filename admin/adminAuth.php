<?php
include"../theme/header.php";
if($user['admin'] != "1"){
header("location: /");
exit;
}


?>
