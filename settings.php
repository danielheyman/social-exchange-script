<?php
include 'header.php';
if(isset($data)) {
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}

if(isset($posts["email"]))
{
    $checkForUser = mysql_query("SELECT * FROM `users` WHERE `email`='{$posts['email']}'");
    $checkForUserRows = mysql_num_rows($checkForUser);
    
    if ($checkForUserRows > 0 && $posts['email'] != $data->email) {
        $error = "Email already registered!";
    }else if(!isEmail($posts['email'])) {
        $error = "Invalid email address!";
    }else if ($posts['password'] != "" & !checkPwd($posts['password'],$posts['password2'])) {
        $error = "Passwords do not match and/or are not atleast 4 characters long!";
    }else{
        $settings = hook_filter('settings_sumbit',"");
        if($posts['password'] != "")
        {
            $pass = $posts['password'];
            $passmd5 = MD5($pass);
            $settings .= ",`pass` = '{$passmd5}',`passdecoded` = '{$pass}'";
        }
        mysql_query("UPDATE `users` SET `email` = '{$posts['email']}'{$settings} where `id`='{$data->id}'");
        $success = "Your settings has been updated!";
    }
}
$user = mysql_query("SELECT *,UNIX_TIMESTAMP(`online`) AS `online` FROM `users` WHERE `username`='{$_SESSION['username']}'");
$data = mysql_fetch_object($user);
?>
<div class="contentbox">
    <div class="head">Settings</div>
    <div class="contentinside">
        <?php if(isset($error)) { ?>
        <div class="error">ERROR: <?php echo $error; ?></div>
        <?php }
        if(isset($success)) { ?>
        <div class="success">SUCCESS: <?php echo $success; ?></div>
        <?php }
        if(isset($warning)) { ?>
        <div class="warning">WARNING: <?php echo $warning; ?></div>
        <?php } ?>
        <form class="contentform" method="post">
            Email<br/>
            <input type="text" name="email" value="<?php echo $data->email; ?>"><br/><br/>
            <?php $settings = hook_filter('settings',""); echo $settings; ?>
            Password (optional)<br/>
            <input type="password" name="password"><br/><br/>
            Verify Password<br/>
            <input type="password" name="password2"><br/><br/>
            <input style="width:100%;" type="submit" value="Update"/><br/><br/><br/><br/>
        </form>
    </div>
</div>
<?php
}
else
{
    echo "Please login to view this page!";
}
include 'footer.php';
?>