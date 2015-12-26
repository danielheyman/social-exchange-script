<?php
$num1 = mysql_query("SELECT * FROM `youtube` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Seite bereits vorhanden!";
}else if(!strstr($posts['url'], 'youtube.com/watch?v=')) {
    $error = "Falsche URL! Die URL muss 'youtube.com/watch?v='enthalten!";
}else{
    mysql_query("INSERT INTO `youtube` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Seite erfolgreich erstellt!";
}
?>