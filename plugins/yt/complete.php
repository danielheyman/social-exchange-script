<?
include('../../config.php');
require_once "../../includes/pluggable.php";
foreach( glob("../../plugins/*/index.php")  as $plugin) {
  require_once($plugin); 
}  
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}

if(isset($posts['site'])){
$site2 = mysql_fetch_object(mysql_query("SELECT * FROM `youtube` WHERE `id`='{$posts['site']}'"));
$check = mysql_num_rows(mysql_query("SELECT * FROM `watched` WHERE `user_id`='{$posts['userid']}' AND `site_id`='{$posts['site']}'"));
if($posts['site'] != "" && $posts['userid'] != "" && $check == 0){
$coins = number_format($site2->cpc - 1);
$bonuscoins = hook_filter('bonus_coins',$coins);

mysql_query("UPDATE `users` SET `coins`=`coins`+'{$bonuscoins}' WHERE `id`='{$posts['userid']}'");
mysql_query("UPDATE `youtube` SET `exchanges`=`exchanges`+'1' WHERE `id`='{$site2->id}'");
mysql_query("UPDATE `users` SET `coins`=`coins`-'{$site2->cpc}' WHERE `id`='{$site2->user}'");
mysql_query("INSERT INTO `watched` (user_id, site_id) VALUES('{$posts['userid']}','{$posts['site']}')");
$aff1 = mysql_query("SELECT ref FROM `users` WHERE `id`='{$posts['userid']}'");
$aff = mysql_fetch_object($aff1);
if($aff->ref > 0){
$coins = $coins * $site->refbonus;
mysql_query("UPDATE `users` SET `coins`=`coins`+'$coins' WHERE `id`='{$aff->ref}'");
}

}}

?>