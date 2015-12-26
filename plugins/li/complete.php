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
mysql_query("INSERT INTO `linked` (user_id, site_id) VALUES('{$posts['me']}', '{$posts['him']}')");
echo "Erfolgreich!";
}else{
$dbres1	= mysql_query("SELECT * FROM `users` WHERE `id`='{$posts['me']}'");
$data3 = mysql_fetch_object($dbres1);
$site2 = mysql_fetch_object(mysql_query("SELECT * FROM `linkedin` WHERE `id`='{$posts['him']}'"));

$plused1 = mysql_query("SELECT * FROM `linked` WHERE `site_id`='{$posts['him']}' AND `user_id`='{$posts['me']}'");
$plused  = mysql_num_rows($plused1);
if($plused > 0){
echo "Error: Sie haben diese Website bereits geteilt!";
}else{
$coins = number_format($site2->cpc - 1);
$bonuscoins = hook_filter('bonus_coins',$coins);

mysql_query("UPDATE `users` SET `coins`=`coins`+'{$bonuscoins}' WHERE `id`='{$posts['me']}'");
mysql_query("UPDATE `linkedin` SET `exchanges`=`exchanges`+'1' WHERE `id`='{$posts['him']}'");
mysql_query("UPDATE `users` set `coins`=`coins`-'{$site2->cpc}' WHERE `id`='{$site2->user}'");
mysql_query("INSERT INTO `linked` (user_id, site_id) VALUES('{$posts['me']}', '{$posts['him']}')");

$aff1 = mysql_query("SELECT ref FROM `users` WHERE `id`='{$posts['me']}'");
$aff = mysql_fetch_object($aff1);
if($aff->ref > 0){
$coins = $coins * $site->refbonus;
mysql_query("UPDATE `users` SET `coins`=`coins`+'$coins' WHERE `id`='{$aff->ref}'");
}

echo "Sie haben erfolgreich geteilt und erhalten {$coins} Coins!";
}
}
}
?>