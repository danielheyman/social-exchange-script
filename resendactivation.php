<?php 
include 'header.php';
if(isset($_POST['email'])){
    foreach($_POST as $key => $value) {
        $posts[$key] = filter($value);
    }
    
    $checkForUser = mysql_query("SELECT username, activate FROM `users` WHERE `email`='{$posts['email']}'");
    $user = mysql_fetch_object($checkForUser);
    $checkForUserRows = mysql_num_rows($checkForUser);
    
    if ($checkForUserRows == 0) {
        $error = "Email could not be found!";
    }else{
        mail($posts['email'],"{$site->site_name} Activation",
"Hello {$user->username},

Welcome to {$site->site_name}. Start earning coins to promote your website now!

Click on this link to activate your account: 
{$site->site_url}/activate.php?ac={$user->activate}
    
Best Regards!","From: {$site->site_name} <{$site->site_email}>");
        $success = "We have sent you your activation email! Please check your spam folder if you cannot find it!";
    }
}
?>	

<div class="contentbox">
    <div class="head">Resend Activation</div>
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