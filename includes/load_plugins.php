<?php

foreach( glob("../plugins/*.php")  as $plugin) {  
  require_once($plugin);  
}  

?>