<?
include('../../config.php');
require_once "../../includes/pluggable.php";
foreach( glob("../../plugins/*/index.php")  as $plugin) {
  require_once($plugin); 
}  
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}
if(isset($posts['me'])){
if(isset($_GET['step']) && $_GET['step'] == "skip"){
mysql_query("INSERT INTO `stumbled` (user_id, site_id) VALUES('{$posts['me']}', '{$posts['him']}')");
echo "Done!";
}else{
$site2 = mysql_fetch_object(mysql_query("SELECT * FROM `stumbleupon` WHERE `id`='{$posts['him']}'"));
$count = file_get_contents($site->site_url . '/plugins/su/getcount.php?url=' . urlencode($site2->url));
if($count > $posts['count'])
{
$plused1 = mysql_query("SELECT * FROM `stumbled` WHERE `site_id`='{$posts['him']}' AND `user_id`='{$posts['me']}'");
$plused  = mysql_num_rows($plused1);
if ($plused == 0){
$coins = number_format($site2->cpc - 1);
$bonuscoins = hook_filter('bonus_coins',$coins);

mysql_query("UPDATE `users` SET `coins`=`coins`+'{$bonuscoins}' WHERE `id`='{$posts['me']}'");
mysql_query("UPDATE `stumbleupon` SET `exchanges`=`exchanges`+'1' WHERE `id`='{$posts['him']}'");
mysql_query("UPDATE `users` set `coins`=`coins`-'{$site2->cpc}' WHERE `id`='{$site2->user}'");
mysql_query("INSERT INTO `stumbled` (user_id, site_id) VALUES('{$posts['me']}', '{$posts['him']}')");

$aff1 = mysql_query("SELECT ref FROM `users` WHERE `id`='{$posts['me']}'");
$aff = mysql_fetch_object($aff1);
if($aff->ref > 0){
$coins = $coins * $site->refbonus;
mysql_query("UPDATE `users` SET `coins`=`coins`+'$coins' WHERE `id`='{$aff->ref}'");
}

echo "SUCCESS: Follow erfolgreich! Sie erhalten {$coins} Coins!";
}else{
echo "Error: Sie haben den User bereits 'gefollowed'!";
}
}
else
{
echo "ERROR: Stumbleupon meldet: Sie haben diesen user nicht 'gefollowed' ! Versuchen sie den user zu entfollowen und versuchen sie es dann erneut!";
}
}
}
?>