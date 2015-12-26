<?php
include 'header.php';
if(isset($data)) {
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
?>
<div class="contentbox">
    <div class="head">My Sites</div>
    <div class="contentinside">
        <div class="site_menu">
            <?php $menu = hook_filter('site_menu', ""); echo $menu; ?>
        </div>
        <?php if(isset($gets["p"])) { 
            echo '<div class="site_content">';
            $db = hook_filter($gets["p"] . '_info', "db");
            $sites = mysql_query("SELECT * FROM `{$db}` WHERE `user`='{$data->id}'");
            ?>
            <table cellpadding="5" class="siteslist"><tr><td>Title</td><td width="100">Exchanges</td><td width="60">CPC</td><td width="60">Status</td><td width="60">Edit</td></tr>
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
                echo "<tr><td>{$mysite->title}</td><td>{$mysite->exchanges}</td><td>{$mysite->cpc}</td><td>{$status}</td><td><a href='editsite.php?x={$mysite->id}&y={$gets['p']}'>Edit</a></td></tr>";
            }
            ?>
            </table>
            <?php
            echo '</div>';
        } ?>
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