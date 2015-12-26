<?php
include 'header.php';
if(isset($data)) {
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}
$id = $gets["x"];
$db = $gets["y"];

$type = hook_filter($db . '_info', "type");
$db = hook_filter($db . '_info', "db");
if(isset($posts["title"]))
{
    mysql_query("UPDATE `{$db}` SET `title` = '{$posts['title']}', `cpc` = '{$posts['cpc']}', `active` = '{$posts['active']}' where `id` = '{$id}' and `user`='{$data->id}'");
    $success = "Your site has been updated!";
}
if(isset($gets["f"]))
{
    mysql_query("DELETE from `{$db}` where `id` = '{$id}' and `user`='{$data->id}'");
    ?><script>window.location = "sites.php";</script><?php
    exit;
}
$mysite = mysql_query("SELECT * FROM `{$db}` WHERE `id`='{$id}' and `user`='{$data->id}'");
$mysite = mysql_fetch_object($mysite);
?>
<script>
function deletesite()
{
    if (confirm('Are you sure you would like to delete your site?'))
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
            Type<br/>
            <input type="text" disabled="disabled" value="<?php echo $type; ?>"><br/><br/>
            Link<br/>
            <input type="text" disabled="disabled" value="<?php echo $mysite->url; ?>"/><br/><br/>
            Title<br/>
            <input name="title" type="text" value="<?php echo $mysite->title; ?>"/><br/><br/>
            Cost Per Click<br/>
            <select name="cpc"><?php for($x = 2; $x <= $site->cpc; $x++) { if($mysite->cpc == $x) { echo "<option selected>$x</option>"; } else { echo "<option>$x</option>"; } } ?></select><br/><br/>
            Status<br/>
            <select name="active"><option value="0">Enabled</option><option value="1" <?php if($mysite->active == 1) { echo 'selected'; }?>>Disabled</option></select><br/><br/>
            <input style="width:100%;" type="submit" value="Update"/><br/><br/><br/><br/>
            <center><input onclick="javascript:deletesite();" style="width:100px;" type="button" value="Delete"/></center>
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