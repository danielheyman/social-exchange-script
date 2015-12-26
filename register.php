<?php 
include 'header.php';
if(isset($_POST['username'])){
    foreach($_POST as $key => $value) {
        $posts[$key] = filter($value);
    }
    
    $checkForUser = mysql_query("SELECT id FROM `users` WHERE `username`='{$posts['username']}' OR `email`='{$posts['email']}'");
    $checkForUserRows = mysql_num_rows($checkForUser);
    
    $ip = VisitorIP();
    $checkForIP = mysql_query("SELECT id FROM `users` WHERE `ip`='{$ip}'");
    $checkForIPRows = mysql_num_rows($checkForIP);
    
    if ($checkForUserRows > 0) {
        $error = "Username or email already registered!";
    }else if ($checkForIPRows > 0)  {
        $error = "You may only have one account per IP!";
    }else if (!isUserID($posts['username'])) {
        $error = "Username is incorrect!";
    }else if(!isEmail($posts['email'])) {
        $error = "Enter a valid email address!";
    }else if (!checkPwd($posts['password'],$posts['password2'])) {
        $error = "Passwords do not match and/or are not atleast 4 characters long!";
    }else{
        $ref = "";
        if(isset($_COOKIE['ref'])){
        $ref = $_COOKIE['ref'];
        $refInfo = mysql_query("SELECT * FROM `users` WHERE `id`='{$ref}'");
        $refInfo = mysql_fetch_object($refInfo);
        mysql_query("INSERT INTO `referals`(user,referal,date) values('{$refInfo->username}','{$posts['username']}',NOW())");
        }
        $activationCode = rand(000000000, 999999909);
        mail($posts['email'],"{$site->site_name} Activation",
"Hello {$posts['username']},

Welcome to {$site->site_name}. Start earning coins to promote your website now!

Click on this link to activate your account: 
{$site->site_url}/activate.php?ac={$activationCode}
    
Best Regards!","From: {$site->site_name} <{$site->site_email}>");
        $ip = VisitorIP();
        $pass = $posts['password'];
        $passmd5 = MD5($pass);
        mysql_query("INSERT INTO `users`(email,username,IP,passdecoded,pass,ref,signup,activate) values('{$posts['email']}','{$posts['username']}','$ip','$pass','$passmd5','{$ref}',NOW(),'{$activationCode}')")or die(mysql_error());
        $success = "You are now registered! Please confirm your email address!";
    }
}
?>	

<div class="contentbox">
    <div class="head">Register</div>
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
            Username<br/>
            <input name="username" type="text" value="<?php if(isset($posts["username"])) { echo $posts["username"]; } ?>"/><br/><br/>
            Email (Use your real email, We send your account activation to it)<br/>
            <input name="email" type="text" value="<?php if(isset($posts["email"])) { echo $posts["email"]; } ?>"/><br/><br/>
            Password<br/>
            <input name="password" type="password"/><br/><br/>
            Repeat Password<br/>
            <input name="password2" type="password"/><br/><br/>
            <p>
            <input style="width:100%;" type="Submit"/>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>