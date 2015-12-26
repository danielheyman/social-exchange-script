<?php
$num1 = mysql_query("SELECT * FROM `stumbleupon` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Seite bereits vorhanden!";
}else if(!strstr($posts['url'], 'stumbleupon.com/stumbler')) {
    $error = "Falsche URL! Die URL muss 'stumbleupon.com/stumbler' enthalten!";
}else if(substr($posts['url'], -1) == "/") {
    $error = "Das letzte Zeichen kann kein / sein";
}else{
    mysql_query("INSERT INTO `stumbleupon` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Seite erfolgreich erstellt!";
}
?>