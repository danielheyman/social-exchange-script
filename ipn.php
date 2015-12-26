<?php
require("config.php");

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$custom = $_POST['custom'];

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
$pack = mysql_fetch_object(mysql_query("SELECT * FROM `packs` WHERE `name`='{$item_name}' AND `coins`='{$item_number}'"));
$user = mysql_fetch_object(mysql_query("SELECT * FROM `users` WHERE `id`='{$custom}'"));
$saleprice = $pack->price * (1 - $site->sale);
if (
    ($receiver_email == $site->paypal) &&
    ("$payment_amount" == "$saleprice") &&
	($payment_status == 'Completed')
    ) {
mysql_query("UPDATE `users` SET `coins`=`coins`+'{$pack->coins}' WHERE `id`='{$custom}'");			
mysql_query("INSERT INTO `transactions` (user, points, pack, money, date) VALUES('{$user->username}', '{$pack->coins}', '{$item_name}', '{$payment_amount}', NOW())");
}
}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
}
}
fclose ($fp);
}
?>