<?php
$num1 = mysql_query("SELECT * FROM `stumbleupon` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Page already exists!";
}else if(!strstr($posts['url'], 'stumbleupon.com/stumbler')) {
    $error = "Wrong URL! The URL must include 'stumbleupon.com/stumbler'!";
}else if(substr($posts['url'], -1) == "/") {
    $error = "The last character can not be /";
}else{
    mysql_query("INSERT INTO `stumbleupon` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Page successfully created!";
}
?>