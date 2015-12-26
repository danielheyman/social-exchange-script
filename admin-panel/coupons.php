<?php
include 'header.php';
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}

if(isset($posts['code'])){
    mysql_query("INSERT INTO `coupons`(code, coins, uses) values('{$posts['code']}', '{$posts['coins']}', '{$posts['uses']}')");
    $success = "The coupon has been added!";
}
$n1 = rand(1000, 9999);
$n2 = rand(1000, 9999);
$n3 = rand(1000, 9999);
$n4 = rand(1000, 9999);
$code = $n1."-".$n2."-".$n3."-".$n4;

?>
<div class="contentbox">
    <div class="head">Coupons</div>
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
        <?php
        $coupons = mysql_query("SELECT * FROM `coupons`");
        ?>
        <table cellpadding="5" class="siteslist"><tr><td width="60">ID</td><td width="60">Coins</td><td>Code</td><td width="60">Uses Left</td><td width="60">Edit</td></tr>
        <?php
        for($x=1; $coupon = mysql_fetch_object($coupons); $x++)
        {
            echo "<tr><td>{$coupon->id}</td><td>{$coupon->coins}</td><td>{$coupon->code}</td><td>{$coupon->uses}</td><td><a href='editcoupon.php?x={$coupon->id}'>Edit</a></td></tr>";
        }
        ?>
        </table>
    </div>
</div>
<div class="sidebox">
    <div class="head">Add Coupon</div>
    <div class="contentinside">
        <form class="sideform" method="post">
            Code<br/>
            <input name="code" type="text" value="<?php echo $code; ?>"/><br/><br/>
            Coins<br/>
            <input name="coins" type="text" value="50"/><br/><br/>
            Uses (Enter "u" for unlimited)<br/>
            <input name="uses" type="text" value="1"/><br/><br/>
            <input style="width:100%;" type="submit" value="Add"/>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>
