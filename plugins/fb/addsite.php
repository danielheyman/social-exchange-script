<?php
$num1 = mysql_query("SELECT * FROM `facebook` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Seite bereits vorhanden!";
}else if(!strstr($posts['url'], 'facebook.com')) {
    $error = "Falsche URL! URL muss 'facebook.com' enthalten!";
}else{
    mysql_query("INSERT INTO `facebook` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Seite erfolgreich erstellt!";
}
?>