<?php
include 'header.php';
if(isset($data)) {
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}

if(isset($posts['coupon'])) {
    $coupon = mysql_query("SELECT * FROM `coupons` WHERE `code`='{$posts['coupon']}' AND (`uses` !='0' OR `uses` = 'u')");
    $exists = mysql_num_rows($coupon);
    $coupon = mysql_fetch_object($coupon);
    $used = mysql_num_rows(mysql_query("SELECT * FROM `coupon` WHERE `user_id`='{$data->id}' AND `coupon_id`='{$posts['coupon']}'"));
    if($exists && $used == 0){
        mysql_query("UPDATE `users` SET `coins`=`coins`+'{$coupon->coins}' WHERE `id`='{$data->id}'");
        if($coupon->uses != "u")
        {
            $uses = $coupon->uses - 1;
            mysql_query("UPDATE `coupons` SET `uses`='$uses' WHERE `code`='{$posts['coupon']}'");
        }
        mysql_query("INSERT INTO `coupon` (user_id, coupon_id) VALUES('{$data->id}','{$posts['coupon']}')");
        $success = "Success! You have received <b>{$coupon->coins} coins";
    }else{
        $error = "This coupon code doesn't exist or is already used!";
    }
}?>

<div class="contentbox">
    <div class="head">Reedem a Coupon</div>
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
            Coupon<br/>
            <input type="text" name="coupon"/><br/><br/>
            <input style="width:100%;" type="Submit"/>
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