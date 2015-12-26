<?php
$num1 = mysql_query("SELECT * FROM `digg` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Diese Seite ist bereits vorhanden!";
}else if(!strstr($posts['url'], 'digg.com')) {
    $error = "In der URL muss'digg.com' enthalten sein! ";
}else{
    mysql_query("INSERT INTO `digg` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Seite erfolgreich erstellt!";
}
?>