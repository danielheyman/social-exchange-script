<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$host		=	"localhost"; // your mysql server address
$user		=	"SQLUSERNAME"; // your mysql username
$pass		=	"SQLPASSWORD"; // your mysql password
$tablename	=	"SQLDATABASENAME"; // your mysql table

session_start();
$data = null;
if(!(@mysql_connect("$host","$user","$pass") && @mysql_select_db("$tablename"))) {
    ?>
    <html>
    MSQL ERROR
    <?
    exit;
}

include_once 'functions.php';
require_once "includes/pluggable.php";
foreach( glob("plugins/*/index.php")  as $plugin) {  
  require_once($plugin);  
}  

hook_action('initialize');

$site = mysql_fetch_object(mysql_query("SELECT * FROM settings"));
?>