<?php
include 'header.php';
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}

if(isset($posts['name'])){
    mysql_query("INSERT INTO `packs`(name, coins, price) values('{$posts['name']}', '{$posts['coins']}', '{$posts['price']}')");
    $success = "The package has been added!";
}

?>
<div class="contentbox">
    <div class="head">Packages</div>
    <div class="contentinside">
        <?php if(isset($error)) { ?>
        <div class="error">ERROR: <?php echo $error; ?></div>
        <?php }
        if(isset($success)) { ?>
        <div class="success">SUCCESS: <?php echo $success; ?></div>
        <?php }
        if(isset($warning)) { ?>
        <div class="warning">WARNING: <?php echo $warning; ?></div>
        <?php } 
        $packs = mysql_query("SELECT * FROM `packs`");
        ?>
        <table cellpadding="5" class="siteslist"><tr><td>Name</td><td width="150">Coins</td><td width="150">Price</td><td width="60">Edit</td></tr>
        <?php
        for($x=1; $pack = mysql_fetch_object($packs); $x++)
        {
            echo "<tr><td>{$pack->name}</td><td>{$pack->coins}</td><td>$ {$pack->price}</td><td><a href='editpack.php?x={$pack->id}'>Edit</a></td></tr>";
        }
        ?>
        </table>
    </div>
</div>
<div class="sidebox">
    <div class="head">Add Package</div>
    <div class="contentinside">
        <form class="sideform" method="post">
            Name<br/>
            <input name="name" type="text" value="200 Point Pack"/><br/><br/>
            Coins<br/>
            <input name="coins" type="text" value="200"/><br/><br/>
            Price<br/>
            <input name="price" type="text" value="1.00"/><br/><br/>
            <input style="width:100%;" type="submit" value="Add"/>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>
