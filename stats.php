<?php
include 'header.php';
$users1 = mysql_query("SELECT * FROM `users`");
$users = mysql_num_rows($users1);
$banned1 = mysql_query("SELECT * FROM `users` WHERE `banned`='1'");
$banned = mysql_num_rows($banned1);
?>
<div class="contentbox">
    <div class="head">Stats</div>
    <div class="contentinside">
        <h2>Members</h2>
        <table cellpadding="5" class="siteslist">
            <tr><td width="60">Users</td><td width="200">Banned</td><td width="200">Total</td></tr>
            <tr><td><?echo $users - $banned;?></td><td><?echo $banned;?></td><td><?echo $users;?></td></tr>
        </table>
        <br/>
        <h2>Websites</h2>
        <table cellpadding="5" class="siteslist">
            <tr><td width="60">Type</td><td width="200">Website</td><td width="200">Clicks</td></tr>
            <?php
            $stats = hook_filter('stats',"");
            echo $stats;
            ?>
        </table>
    </div>
</div>
<?php
include 'footer.php';
?>