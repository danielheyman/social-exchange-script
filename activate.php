<?php 
include 'config.php';
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
if($gets['ac'] != "" && $gets['ac'] != 0){
    $userQuery = mysql_query("SELECT * FROM `users` WHERE `activate`='{$gets['ac']}'");
    $user = mysql_fetch_object($userQuery);
    $exists = mysql_num_rows($userQuery);
    if($exists > 0){
        if($user->ref > 0){
            mysql_query("UPDATE `referals` SET `registered`='true' WHERE `referal`='{$user->username}'");
            
            $ref = mysql_query("SELECT * FROM `users` WHERE `id`='{$user->ref}'");
            $ref = mysql_fetch_object($ref);
            if($ref->IP != $user->IP)
            {
                mysql_query("UPDATE `users` SET `coins`=`coins`+'50' WHERE `id`='{$user->ref}'");
            }
        }
        mysql_query("UPDATE `users` SET `activate`='0' WHERE `activate`='{$gets['ac']}'");
        $result = "<center><b>Email confirmed successful! You may now login!</b> <a href='index.php'>Continue</a></center>";
    }else{
        $result = "<center><b>Incorrect Link!</b> <a href='index.php'>Continue</a></center>";}
}else{
    $result = "<center><b>Incorrect Link!</b> <a href='index.php'>Continue</a></center>";}
echo $result;
?>