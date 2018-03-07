<?php
$num1 = mysql_query("SELECT * FROM `twitter` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Page already exists!";
}else if(!strstr($posts['url'], 'twitter.com')) {
    $error = "Wrong URL! The URL must contain 'twitter.com'!";
}else{
    mysql_query("INSERT INTO `twitter` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Page successfully created";
}
?>