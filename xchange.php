<?php
include 'header.php';
if(isset($data)) {
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
include ("plugins/" . $gets["p"] . "/xchange.php");
}
else
{
    echo "Please login to view this page!";
}
include 'footer.php';
?>