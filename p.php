<?php
include 'config.php';
if(isset($_SESSION['username'])){
    $user = mysql_query("SELECT *,UNIX_TIMESTAMP(`online`) AS `online` FROM `users` WHERE `username`='{$_SESSION['username']}'");
    $data = mysql_fetch_object($user);
}
if(isset($data)) {
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
include ("plugins/" . $gets["p"] . "/main.php");
}
else
{
    echo "Please login to view this page!";
}
?>