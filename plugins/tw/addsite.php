<?php
$num1 = mysql_query("SELECT * FROM `twitter` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Seite bereits vorhanden!";
}else if(!strstr($posts['url'], 'twitter.com')) {
    $error = "Falsche URL! Die URL muss 'twitter.com' enthalten!";
}else{
    mysql_query("INSERT INTO `twitter` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Seite erfolgreich erstellt";
}
?>