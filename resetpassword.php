<?php 
include 'header.php';
if(isset($_POST['email'])){
    foreach($_POST as $key => $value) {
        $posts[$key] = filter($value);
    }
    
    $checkForUser = mysql_query("SELECT username FROM `users` WHERE `email`='{$posts['email']}'");
    $user = mysql_fetch_object($checkForUser);
    $checkForUserRows = mysql_num_rows($checkForUser);
    
    if ($checkForUserRows == 0) {
        $error = "Email could not be found!";
    }else{
        $length = 8;
        $password = "";
        $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
        $maxlength = strlen($possible);
        $i = 0; 
        while ($i < $length) { 
            $char = substr($possible, mt_rand(0, $maxlength-1), 1);
            if (!strstr($password, $char)) { 
                $password .= $char;
                $i++;
            }
        }
        mail($posts['email'],"{$site->site_name} Password",
"Hello {$user->username},

Your new password is:
$password

You can now login to {$site->site_name}!
    
Best Regards!","From: {$site->site_name} <{$site->site_email}>");
        $passmd5 = MD5($password);
        mysql_query("UPDATE `users` set `passdecoded` = '{$password}', `pass` = '{$passmd5}' WHERE `email`='{$posts['email']}'")or die(mysql_error());
        $success = "We have sent you a new password! Please check your spam folder if you cannot find it!";
    }
}
?>	

<div class="contentbox">
    <div class="head">Reset Password</div>
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
        
        <form class="register" method="post">
            Email<br/>
            <input name="email" type="text" value="<?php if(isset($posts["email"])) { echo $posts["email"]; } ?>"/><br/><br/>
            <input style="width:100%;" type="Submit"/>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>