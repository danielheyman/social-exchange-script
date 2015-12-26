<?php
include '../config.php';

include_once '../functions.php';
require_once "../includes/pluggable.php";
foreach( glob("../plugins/*/index.php")  as $plugin) {  
  require_once($plugin);  
}  

if(isset($_SESSION['username'])){
    $user = mysql_query("SELECT *,UNIX_TIMESTAMP(`online`) AS `online` FROM `users` WHERE `username`='{$_SESSION['username']}'");
    $data = mysql_fetch_object($user);
}

if(isset($data) && $data->admin == 1)
{
}
else
{
    echo "Please login at " . $site->site_url;
    exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Grow Through Exchange</title>
        <link rel="stylesheet" href="../style.css" type="text/css" />
        <script type="text/javascript" src="../jquery.js"></script>
    </head>
    <body>
        <div class="menu">
            <div class="menu-wrap">
                <a href="../index.php" class="logo"><?php echo $site->site_name; ?></a>
                <ul id="main_menu">
                    <li><a href="sales.php">Sales</a></li>
                    <li><a href="sites.php">Sites</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="cheaters.php">Cheaters</a></li>
                    <li><a href="coupons.php">Coupons</a></li>
                    <li><a href="packages.php">Packages</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    </ul>
            </div>
        </div>
        <div class="content">