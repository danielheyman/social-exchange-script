<?php
include 'header.php';
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}
$id = $gets["x"];

if(isset($posts["code"]))
{
    mysql_query("UPDATE `coupons` SET `code` = '{$posts['code']}', `coins` = '{$posts['coins']}', `uses` = '{$posts['uses']}' where `id` = '{$id}'");
    $success = "Your coupon has been updated!";
}
if(isset($gets["f"]))
{
    if($gets["f"] == "delete")
    {
        mysql_query("DELETE from `coupons` where `id` = '{$id}'");
        ?><script>window.location = "coupons.php";</script><?php
        exit;
    }
}
$mycoupon = mysql_query("SELECT * FROM `coupons` WHERE `id`='{$id}'");
$mycoupon = mysql_fetch_object($mycoupon);
?>
<script>
function deletesite()
{
    if (confirm('Are you sure you would like to delete this coupon?'))
    {
        window.location = document.location.href + "&f=delete";
    }
}
</script>
<div class="contentbox">
    <div class="head">Edit Coupon</div>
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
            Code<br/>
            <input name="code" type="text" value="<?php echo $mycoupon->code; ?>"/><br/><br/>
            Coins<br/>
            <input name="coins" type="text" value="<?php echo $mycoupon->coins; ?>"/><br/><br/>
            Uses (Enter "u" for unlimited)<br/>
            <input name="uses" type="text" value="<?php echo $mycoupon->uses; ?>"/><br/><br/>
            <input style="width:100%;" type="submit" value="Update"/><br/><br/><br/><br/>
            <center><input onclick="javascript:deletesite();" style="width:100px;" type="button" value="Delete"/></center>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>