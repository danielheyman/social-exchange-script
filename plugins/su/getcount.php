<?php
include '../../functions.php';
$url = urldecode($_GET["url"]);
$response = @file_get_contents($url . '/following/');
$page = explode('followers/">', $response);
$page = explode('<', $page[1]);
$page = preg_replace('/\s+/', '', $page[0]);
echo number_format($page);
?>