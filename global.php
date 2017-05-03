<?php
/*
SANS 3.0 Global.php
!!! DO NOT EDIT UNLESS YOU KNOW WHAT YOU ARE DOING !!!

Author: Database
Created: 5/3/17
(c) 2017 SANS Development and the site owner(s)
*/
session_start();
ob_start();
date_default_timezone_set("America/New_York");
// include DB connect set by user
include"connect.php";

$User = $_SESSION['User'];
$Password = $_SESSION['Password'];
$Dev = $_SESSION['Dev'];

// fetch IP w/cloudflare bypass
if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
		  $IP=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
		  $IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		elseif(!empty($_SERVER['HTTP_CF_CONNECTING_IP'])){
		  $IP=$_SERVER['HTTP_CF_CONNECTING_IP']; 
		}
		else
		{
		  $IP=$_SERVER['REMOTE_ADDR'];
		}
		
		
			function time_ago($tm, $rcs = 0) {
  $cur_tm = time(); 
  $dif = $cur_tm - $tm;
  $pds = array('second','minute','hour','day','week','month','year','decade');
  $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);

  for ($v = count($lngh) - 1; ($v >= 0) && (($no = $dif / $lngh[$v]) <= 1); $v--);
    if ($v < 0)
      $v = 0;
  $_tm = $cur_tm - ($dif % $lngh[$v]);

  $no = ($rcs ? floor($no) : round($no)); // if last denomination, round

  if ($no != 1)
    $pds[$v] .= 's';
  $x = $no . ' ' . $pds[$v];

  if (($rcs > 0) && ($v >= 1))
    $x .= ' ' . $this->time_ago($_tm, $rcs - 1);

  return $x." ago";
}

if($User){
$getUser = mysqli_query($db,"SELECT * FROM Users WHERE Username='$User'");
$user = mysqli_fetch_array($getUser);
$userExists = mysqli_num_rows($getUser);
if($userExists == "0" || $user['password'] != $Password){
session_destroy();
header("location: /");
exit;
}else{
// log all ip's for security
$fetchIP = mysqli_query($db,"SELECT * FROM iprecords WHERE ip='$IP' AND linkedTo='".$user['id']."'");
$IPKnown = mysqli_num_rows($fetchIP);
if($IPKnown == "0"){
mysqli_query($db,"INSERT INTO iprecords(ip,linkedTo)VALUES('$IP','".$user['id']."')");
}



    
}

}

?>
