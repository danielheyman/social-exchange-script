<?php
$num1 = mysql_query("SELECT * FROM `facebook` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Page already exists!";
}else if(!strstr($posts['url'], 'facebook.com')) {
    $error = "Wrong URL! URL must contain 'facebook.com'!";
}else{
    mysql_query("INSERT INTO `facebook` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Page successfully created!";
}
?>