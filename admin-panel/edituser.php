<?php
include 'header.php';
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}
$id = $gets["x"];

if(isset($posts["username"]))
{
    if (!isUserID($posts['username'])) {
        $error = "Username is incorrect!";
    }else if(!isEmail($posts['email'])) {
        $error = "Enter a valid email address!";
    }else {
        $pass = $posts['password'];
        $passmd5 = MD5($pass);
        mysql_query("UPDATE `users` SET `username` = '{$posts['username']}', `email` = '{$posts['email']}', `passdecoded` = '{$pass}', `pass` = '{$passmd5}', `coins` = '{$posts['coins']}', `banned` = '{$posts['banned']}', `admin` = '{$posts['admin']}' where `id` = '{$id}'");
        $checkForUser = mysql_query("SELECT * FROM `users` WHERE `login`='{$posts['username']}' OR `email`='{$posts['email']}'");
        $success = "Your site has been updated!";
    }
}
if(isset($gets["f"]))
{
    if($gets["f"] == "delete")
    {
        mysql_query("DELETE from `users` where `id` = '{$id}'");
        ?><script>window.location = "users.php";</script><?php
        exit;
    }
}
$myuser = mysql_query("SELECT * FROM `users` WHERE `id`='{$id}'");
$myuser = mysql_fetch_object($myuser);
?>
<script>
function deletesite()
{
    if (confirm('Are you sure you would like to delete this use?'))
    {
        window.location = document.location.href + "&f=delete";
    }
}
</script>
<div class="contentbox">
    <div class="head">Edit Site</div>
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
            Username<br/>
            <input name="username" type="text" value="<?php echo $myuser->username; ?>"/><br/><br/>
            Email<br/>
            <input name="email" type="text" value="<?php echo $myuser->email; ?>"/><br/><br/>
            Password<br/>
            <input name="password" type="text" value="<?php echo $myuser->passdecoded; ?>"/><br/><br/>
            Coins<br/>
            <input name="coins" type="text" value="<?php echo $myuser->coins; ?>"/><br/><br/>
            Banned<br/>
            <select name="banned"><option value="0">False</option><option value="1" <?php if($myuser->banned == 1){ echo "selected"; } ?>>True</option></select><br/><br/>
            Admin<br/>
            <select name="admin"><option value="0">No</option><option value="1" <?php if($myuser->admin == 1){ echo "selected"; } ?>>Yes</option></select><br/><br/>
            <input style="width:100%;" type="submit" value="Update"/><br/><br/><br/><br/>
            <center><input onclick="javascript:deletesite();" style="width:100px;" type="button" value="Delete"/></center>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>