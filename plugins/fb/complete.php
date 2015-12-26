<?
include('../../config.php');
require_once "../../includes/pluggable.php";
foreach( glob("../../plugins/*/index.php")  as $plugin) {
  require_once($plugin); 
}  
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}
if(isset($posts['id'])){
if(isset($_GET['step']) && $_GET['step'] == "skip"){
mysql_query("INSERT INTO `liked` (user_id, site_id) VALUES('{$posts['user']}', '{$posts['id']}')");
echo "Erfolgreich!";
}else{
$id = $posts['id'];
$user = $posts['user'];
$mysite = mysql_fetch_object(mysql_query("SELECT cpc, user FROM `facebook` WHERE `id`='{$id}'"));
$check = mysql_num_rows(mysql_query("SELECT id FROM `liked` WHERE `user_id`='{$user}' AND `site_id`='{$id}'"));
if($id != "" && $user != "" && $check == 0){
$coins = number_format($mysite->cpc - 1);
$bonuscoins = hook_filter('bonus_coins',$coins);

mysql_query("UPDATE `users` SET `coins`=`coins`+'{$bonuscoins}' WHERE `id`='{$user}'");
mysql_query("UPDATE `facebook` SET `exchanges`=`exchanges`+'1' WHERE `id`='{$id}'");
mysql_query("UPDATE `users` SET `coins`=`coins`-'{$mysite->cpc}' WHERE `id`='{$mysite->user}'");
mysql_query("INSERT INTO `liked` (user_id, site_id) VALUES('{$user}','{$id}')");

$aff1 = mysql_query("SELECT ref FROM `users` WHERE `id`='{$user}'");
$aff = mysql_fetch_object($aff1);
if($aff->ref > 0){
$coins = $coins * $site->refbonus;
mysql_query("UPDATE `users` SET `coins`=`coins`+'$coins' WHERE `id`='{$aff->ref}'");
}
}
}}
?>