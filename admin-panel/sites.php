<?php
include 'header.php';
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
?>
<div class="contentbox">
    <div class="head">Sites</div>
    <div class="contentinside">
        <div class="site_menu">
            <?php $menu = hook_filter('site_menu', ""); echo $menu; ?>
        </div>
        <?php if(isset($gets["p"])) { 
            echo '<div class="site_content">';
            $db = hook_filter($gets["p"] . '_info', "db");
            $sites = mysql_query("SELECT * FROM `{$db}`");
            ?>
            <table cellpadding="5" class="siteslist"><tr><td width="60">User</td><td>Title</td><td width="60">CPC</td><td width="60">Status</td><td width="60">Edit</td></tr>
            <?php
            for($x=1; $mysite = mysql_fetch_object($sites); $x++)
            {
                $status = $mysite->active;
                if($status == 0)
                {
                    $status = "Enabled";
                }
                else
                {
                    $status = "Disabled";
                }
                echo "<tr><td>{$mysite->user}</td><td>{$mysite->title}</td><td>{$mysite->cpc}</td><td>{$status}</td><td><a href='editsite.php?x={$mysite->id}&y={$gets['p']}'>Edit</a></td></tr>";
            }
            ?>
            </table>
            <?php
            echo '</div>';
        } ?>
    </div>
</div>
<?php
include 'footer.php';
?>