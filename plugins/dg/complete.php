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
mysql_query("INSERT INTO `dugg` (user_id, site_id) VALUES('{$posts['me']}', '{$posts['him']}')");
echo "Erledigt!";
}else{
$dbres1	= mysql_query("SELECT * FROM `users` WHERE `id`='{$posts['me']}'");
$data3 = mysql_fetch_object($dbres1);
$site2 = mysql_fetch_object(mysql_query("SELECT * FROM `digg` WHERE `id`='{$posts['him']}'"));
$id = explode("/", $site2->url);
$id = $id[count($id) - 1];
$key = rand(10000,20000);
$url  = "http://services.digg.com/1.0/endpoint?method=fan.getAll&username=".$id."&count=".$key;
$page = get_data($url);

$plused1 = mysql_query("SELECT * FROM `dugg` WHERE `site_id`='{$posts['him']}' AND `user_id`='{$posts['me']}'");
$plused  = mysql_num_rows($plused1);
$x = $data3->digg;
if ($page == FALSE) { 
    echo "Error: No connection to Digg! Please try later!";
}else if($plused > 0){
    echo "Error: You have already signed this user!";
}else if (preg_match("/$x/i", $page)) {
$coins = number_format($site2->cpc - 1);
$bonuscoins = hook_filter('bonus_coins',$coins);

mysql_query("UPDATE `users` SET `coins`=`coins`+'{$bonuscoins}' WHERE `id`='{$posts['me']}'");
mysql_query("UPDATE `digg` SET `exchanges`=`exchanges`+'1' WHERE `id`='{$posts['him']}'");
mysql_query("UPDATE `users` set `coins`=`coins`-'{$site2->cpc}' WHERE `id`='{$site2->user}'");
mysql_query("INSERT INTO `dugg` (user_id, site_id) VALUES('{$posts['me']}', '{$posts['him']}')");

$aff1 = mysql_query("SELECT ref FROM `users` WHERE `id`='{$posts['me']}'");
$aff = mysql_fetch_object($aff1);
if($aff->ref > 0){
$coins = $coins * $site->refbonus;
mysql_query("UPDATE `users` SET `coins`=`coins`+'$coins' WHERE `id`='{$aff->ref}'");
}
    echo "You have completed the Digg. You will receive {$coins} coins!";
}else{
    echo "ERROR: You have not completed the Digg. Please close the Digg first!";
}
}
}
?>