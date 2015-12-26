<?php
if(!isset($site))
{
    include 'config.php'; 
}
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}

if(isset($gets['r']))
{
    $refid = $gets['r'];
    if(isset($_SERVER['HTTP_REFERER']))
    {
        $httpref = $_SERVER['HTTP_REFERER'];
    }
    else
    {
        $httpref = "";
    }   
    $ip = VisitorIP();
    
    $sameid = mysql_fetch_object(mysql_query("SELECT ip FROM `users` WHERE `id`='{$refid}'"));
    if(!isset($sameid->ip))
    {
        setcookie("ref", $refid, time()+ (365 * 24 * 60 * 60));
    }
    else if($sameid->ip != $ip)
    {
        setcookie("ref", $refid, time()+ (365 * 24 * 60 * 60));
    }
    
    
    $visits = mysql_query("SELECT id FROM `visits` WHERE `ip`='{$ip}' AND `user`='{$refid}'");
    $num = mysql_num_rows($visits);
    if($num == 0 && !preg_match("/\bhost-tracker\b/i", $httpref)) {
        mysql_query("UPDATE `users` SET `coins`=`coins`+'1', `promote`=`promote`+'1' WHERE `id`='{$refid}'");
        mysql_query("INSERT INTO `visits` (user, ip, referer, date) VALUES('{$refid}', '{$ip}', '{$httpref}', NOW())");
    }
}

if(isset($_POST['loginUsername'])) {
    $accounts = mysql_query("SELECT * FROM `users` WHERE `username`='{$_POST['loginUsername']}' AND `pass`=MD5('{$_POST['loginPassword']}')");
    $exists = mysql_num_rows($accounts);
    $userdata = mysql_fetch_object($accounts);
    if($exists == 0){
        ?><script>alert("Incorrect Username/Password!");</script><?php
    }else if($userdata->banned > 0){
        ?><script>alert("Your account is banned!");</script><?php
    }else if($userdata->activate > 0){
        ?><script>alert("You need to confirm your email first!");</script><?php
    }else if($exists > 0) {
        $_SESSION['IP']	= VisitorIP();
        mysql_query("UPDATE `users` SET `online`=NOW() WHERE `username`='{$_POST['loginUsername']}'");
        $user = mysql_query("SELECT * FROM `users` WHERE `username`='{$_POST['loginUsername']}'");
        $_SESSION['data'] = mysql_fetch_object($user);
        $_SESSION['username'] = $_POST['loginUsername'];
        echo "<script>document.location.href='index.php'</script>";
    }
    else{
        ?><script>alert("Incorrect Username/Password!");</script><?php
    }
}

if(isset($_SESSION['username'])){
    $user = mysql_query("SELECT *,UNIX_TIMESTAMP(`online`) AS `online` FROM `users` WHERE `username`='{$_SESSION['username']}'");
    $data = mysql_fetch_object($user);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $site->site_name; ?> - Get Facebook Fans, Twitter Followers, Youtube Views, Google +1's, Stumbleupon Followers, Digg Followers, Website Hits, Twitter ReTweets, and MORE!</title>
        <meta name="description" content="<?php echo $site->site_description; ?>" />
        <link rel="stylesheet" href="style.css" type="text/css" />
        <script type="text/javascript" src="jquery.js"></script>
        


    </head>
    <body>
    <center><a href="index.php"><img src="images/headerlogo.png"></a></center>
        <div class="menu">
            <div class="menu-wrap">
                <ul id="main_menu">
                    <?php if(!isset($data)) { ?>
                    <li><a href="register.php">Register</a></li>
                    <?php } else { ?>
                    <li>
                        <a href="#">Earn Coins</a>
                        <ul>
                            <?php
                            $menu = hook_filter('top_menu_earn',"");
                            echo $menu;
                            ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="stats.php">Stats</a></li>
                    <?php if(isset($data) && $data->admin == 1) { ?>
                    <li><a href="admin-panel/settings.php">Admin Panel</a></li>
                    <?php } ?>
                </ul></center>
                <?php if(isset($data)) { ?>
                <div class='loggedin'>Logged in as: <?php echo $data->username; ?></div>
                <?php } ?>
            </div>
        </div>
        <div class="content">