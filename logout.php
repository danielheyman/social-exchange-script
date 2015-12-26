<?php
    setcookie("login",'',time()-24*60*60,"/","");
    setcookie("validate",'',time()-24*60*60,"/","");
    include("config.php");
    mysql_query("UPDATE `users` SET `online`='0000-00-00 00:00:00' WHERE `username`='{$_SESSION['username']}'");
    session_destroy();
?> 
<script>window.location = "index.php"</script>