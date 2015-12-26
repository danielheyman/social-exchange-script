<?php
include 'version.php';
foreach( glob("plugins/*/version.php")  as $plugin) {  
  echo ",";
  require_once($plugin);  
}  
?>