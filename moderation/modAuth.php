<?
include"../theme/header.php";
if($user['imod'] != "1" && $user['smod'] != "1"){
header("location: /");
exit;
}

?>
