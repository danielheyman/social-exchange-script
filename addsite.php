<?php
include 'header.php';
if(isset($data)) {
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}
if(isset($posts['type'])){
    if($posts['url'] == "http://" || $posts['url'] == ""){
    $error = "Add your page link!";
    }else if($posts['title'] == ""){
    $error = "Add your page title!";
    }else if(!preg_match("/\bhttp\b/i", $posts['url'])){
    $error = "URL must contain http://";
    }else if(!preg_match("/^[A-Za-z]([A-Za-z\s]*[A-Za-z])*$/", $posts['title'])){
    $error = "Please only use alphabetical characters in your title.";
    }else if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $posts['url'])){
    $error = "Please do not use special characters in the url.<";
    }else{
        include "plugins/" . $posts['type'] . "/addsite.php";
    }
}
?>
<div class="contentbox">
    <div class="head">Add Site</div>
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
            <select name="type"><?php $select = hook_filter('add_site_select', ""); echo $select; ?></select><br/><br/>
            Link<br/>
            <input name="url" type="text" value="<?php if(isset($posts["url"])) { echo $posts["url"]; } ?>"/><br/><br/>
            Title<br/>
            <input name="title" type="text" value="<?php if(isset($posts["title"])) { echo $posts["title"]; } ?>"/><br/><br/>
            Cost Per Click<br/>
            <select name="cpc"><?php for($x = 2; $x <= $site->cpc; $x++) { if(isset($posts["cpc"]) && $posts["cpc"] == $x) { echo "<option selected>$x</option>"; } else { echo "<option>$x</option>"; } } ?></select><br/><br/>
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