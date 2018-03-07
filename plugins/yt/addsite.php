<?php
$num1 = mysql_query("SELECT * FROM `youtube` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Page already exists!";
}else if(!strstr($posts['url'], 'youtube.com/watch?v=')) {
    $error = "Wrong URL! The URL must contain 'youtube.com/watch?v='";
}else{
    mysql_query("INSERT INTO `youtube` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Page successfully created!";
}
?>