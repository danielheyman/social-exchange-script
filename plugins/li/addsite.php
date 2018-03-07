<?php
$num1 = mysql_query("SELECT * FROM `linkedin` WHERE `url`='{$posts['url']}'");
$num = mysql_num_rows($num1);
if($num > 0){
    $error = "Page already exists!";
}else{
    mysql_query("INSERT INTO `linkedin` (user, url, title, cpc) VALUES('{$data->id}', '{$posts['url']}', '{$posts['title']}', '{$posts['cpc']}') ");
    $success = "Page successfully created!";
}
?>