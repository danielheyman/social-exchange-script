<?php
$num1 = mysql_query("SELECT * FROM `digg` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "This page already exists!";
}else if(!strstr($posts['url'], 'digg.com')) {
    $error = "The URL must contain 'digg.com'! ";
}else{
    mysql_query("INSERT INTO `digg` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Page successfully created!";
}
?>