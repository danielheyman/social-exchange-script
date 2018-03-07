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
mysql_query("INSERT INTO `followed` (user_id, site_id) VALUES('{$posts['me']}', '{$posts['him']}')");
echo "Done!";
}else{
$dbres1	= mysql_query("SELECT * FROM `users` WHERE `id`='{$posts['me']}'");
$data3 = mysql_fetch_object($dbres1);
$site2 = mysql_fetch_object(mysql_query("SELECT * FROM `twitter` WHERE `id`='{$posts['him']}'"));
$id = explode("/", $site2->url);
$id = $id[count($id) - 1];
$url  = "http://api.twitter.com/1/friendships/exists.json?screen_name_a=" . $data3->twitter . "&screen_name_b=".$id;
$page = get_data($url);
$json_a = json_decode($page,true);


$plused1 = mysql_query("SELECT * FROM `followed` WHERE `site_id`='{$posts['him']}' AND `user_id`='{$posts['me']}'");
$plused  = mysql_num_rows($plused1);
if ($page == FALSE) { 
    echo "Error: We can not confirm the follow!";
}else if($plused > 0){
echo "Error: You have already followed @".$id."!";
}else if (strpos($page, "true") !== FALSE) {
$coins = number_format($site2->cpc - 1);
$bonuscoins = hook_filter('bonus_coins',$coins);

mysql_query("UPDATE `users` SET `coins`=`coins`+'{$bonuscoins}' WHERE `id`='{$posts['me']}'");
mysql_query("UPDATE `twitter` SET `exchanges`=`exchanges`+'1' WHERE `id`='{$posts['him']}'");
mysql_query("UPDATE `users` set `coins`=`coins`-'{$site2->cpc}' WHERE `id`='{$site2->user}'");
mysql_query("INSERT INTO `followed` (user_id, site_id) VALUES('{$posts['me']}', '{$posts['him']}')");

$aff1 = mysql_query("SELECT ref FROM `users` WHERE `id`='{$posts['me']}'");
$aff = mysql_fetch_object($aff1);
if($aff->ref > 0){
$coins = $coins * $site->refbonus;
mysql_query("UPDATE `users` SET `coins`=`coins`+'$coins' WHERE `id`='{$aff->ref}'");
}

echo "SUCCESS: Follow successfully! You receive {$coins} coins!";
}else{
echo "Twitter says: You have not yet followed @" . $id . "! Please try again when logged in" . $data3->twitter;
}
}
}
?>