<?php
include 'header.php';
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
?>
<div class="contentbox">
    <div class="head">Sales</div>
    <div class="contentinside">
        <?php $sales = mysql_query("SELECT * FROM `transactions`"); ?>
        <table cellpadding="5" class="siteslist"><tr><td width="60">ID</td><td width="200">User</td><td width="60">Points</td><td width="60">Money</td><td>Date</td></tr>
        <?php
        for($x=1; $sale = mysql_fetch_object($sales); $x++)
        {
            if($sale->points != 0)
            {
                echo "<tr><td>{$sale->id}</td><td>{$sale->user}</td><td>{$sale->points}</td><td>$ {$sale->money}</td><td>{$sale->date}</td></tr>";
            }
        }
        ?>
        </table>
    </div>
</div>
<?php
include 'footer.php';
?>