<?php
$num1 = mysql_query("SELECT * FROM `retweet` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Seite bereits vorhanden!";
}else{
    mysql_query("INSERT INTO `retweet` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Seite erfolgreich erstellt!";
}
?>