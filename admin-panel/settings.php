<?php
include 'header.php';

if(isset($_POST['name'])){
    mysql_query("UPDATE `settings` SET `site_name`='{$_POST['name']}', `site_description`='{$_POST['description']}', `site_url`='{$_POST['url']}', `paypal`='{$_POST['paypal']}', `site_email`='{$_POST['email']}'");
    $success = "Settings changed";
}

if(isset($_POST['cpc'])){
    $settings_post = hook_filter('admin_settings_post',"");
    mysql_query("UPDATE `settings` SET `cpc`='{$_POST['cpc']}', `refbonus`='{$_POST['refbonus']}', `sale`='{$_POST['sale']}'{$settings_post}");
    $success3 = "Settings changed";
}

if(isset($_POST['coins'])){
    mysql_query("ALTER TABLE  `users` CHANGE  `coins`  `coins` FLOAT( 255, 2 ) NOT NULL DEFAULT '{$_POST['coins']}'");
    $success2 = "Settings changed";
}
$site = mysql_fetch_object(mysql_query("SELECT * FROM `settings`"));

$registerCoins = mysql_fetch_object(mysql_query("SELECT DEFAULT( `coins` ) as coins FROM `users` LIMIT 1"));

?>
<div class="contentbox">
    <div class="head">General Settings</div>
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
            Site Name<br/>
            <input name="name" type="text" value="<?php echo $site->site_name; ?>"/><br/><br/>
            Site Description<br/>
            <input name="description" type="text" value="<?php echo $site->site_description; ?>"/><br/><br/>
            Site URL<br/>
            <input name="url" type="text" value="<?php echo $site->site_url; ?>"/><br/><br/>
            Contact Email<br/>
            <input name="email" type="text" value="<?php echo $site->site_email; ?>"/><br/><br/>
            Paypal Email<br/>
            <input name="paypal" type="text" value="<?php echo $site->paypal; ?>"/><br/><br/>
            <input style="width:100%;" type="Submit"/>
        </form>
    </div>
</div>
<div class="sidebox">
    <div class="head">Coins on Register</div>
    <div class="contentinside">
        <?php if(isset($error2)) { ?>
        <div class="error">ERROR: <?php echo $error2; ?></div>
        <?php }
        if(isset($success2)) { ?>
        <div class="success">SUCCESS: <?php echo $success2; ?></div>
        <?php }
        if(isset($warning2)) { ?>
        <div class="warning">WARNING: <?php echo $warning2; ?></div>
        <?php } ?>
        <form class="sideform" method="post">
            Coins<br/>
            <input name="coins" type="text" value="<?php echo $registerCoins->coins; ?>"/><br/><br/>
            <input style="width:100%;" type="Submit"/>
        </form>
    </div>
</div>
<div class="sidebox">
    <div class="head">Other</div>
    <div class="contentinside">
        <?php if(isset($error3)) { ?>
        <div class="error">ERROR: <?php echo $error3; ?></div>
        <?php }
        if(isset($success3)) { ?>
        <div class="success">SUCCESS: <?php echo $success3; ?></div>
        <?php }
        if(isset($warning3)) { ?>
        <div class="warning">WARNING: <?php echo $warning3; ?></div>
        <?php } ?>
        <form class="sideform" method="post">
            CPC (Cost Per Click) (2 - infinite)<br/>
            <input name="cpc" type="text" value="<?php echo $site->cpc; ?>"/><br/><br/>
            Referral Bonus (0 - 1)<br/>
            <input name="refbonus" type="text" value="<?php echo $site->refbonus; ?>"/><br/><br/>
            Coins Discount (0 - 1)<br/>
            <input name="sale" type="text" value="<?php echo $site->sale; ?>"/><br/><br/>
            <?php $settings = hook_filter('admin_settings',""); echo $settings; ?>
            <input style="width:100%;" type="Submit"/>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>