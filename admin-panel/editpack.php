<?php
include 'header.php';
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}
$id = $gets["x"];

if(isset($posts["name"]))
{
    mysql_query("UPDATE `packs` SET `name` = '{$posts['name']}', `coins` = '{$posts['coins']}', `price` = '{$posts['price']}' where `id` = '{$id}'");
    $success = "Your package has been updated!";
}
if(isset($gets["f"]))
{
    if($gets["f"] == "delete")
    {
        mysql_query("DELETE from `packs` where `id` = '{$id}'");
        ?><script>window.location = "packages.php";</script><?php
        exit;
    }
}
$mypack = mysql_query("SELECT * FROM `packs` WHERE `id`='{$id}'");
$mypack = mysql_fetch_object($mypack);
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
    <div class="head">Edit Package</div>
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
            Name<br/>
            <input name="name" type="text" value="<?php echo $mypack->name; ?>"/><br/><br/>
            Coins<br/>
            <input name="coins" type="text" value="<?php echo $mypack->coins; ?>"/><br/><br/>
            Price<br/>
            <input name="price" type="text" value="<?php echo $mypack->price; ?>"/><br/><br/>
            <input style="width:100%;" type="submit" value="Update"/><br/><br/><br/><br/>
            <center><input onclick="javascript:deletesite();" style="width:100px;" type="button" value="Delete"/></center>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>