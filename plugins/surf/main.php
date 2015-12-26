<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<style>
    body
    {
        padding:0;
        margin:0;
        overflow:hidden;
    }
    
    .header
    {
        height:30px;
        width:100%;
        line-height:30px;
        background-color:Silver;
        border-bottom:2px solid black;
        padding-left:10px;
    }
    
    iframe
    {
        width:100%;
        min-height:90%;
        border:0;
    }
</style>    
<script type="text/javascript" src="jquery.js"></script>
<?php
foreach($_GET as $key => $value) {
$gets[$key] = filter($value);
}
    if(isset($_GET['a'])){if($_GET['a'] == "skip"){
    $sit1 = mysql_query("SELECT * FROM `surf` WHERE `id`='{$gets['id']}'");
    $sit = mysql_num_rows($sit1);
    if($sit > 0){
    mysql_query("INSERT INTO `surfed` (user_id, site_id) VALUES('{$data->id}','{$gets['id']}')");
}}}

$mysite = mysql_query("SELECT * FROM `surf` WHERE `active` = '0' AND (SELECT `coins` FROM `users` WHERE `id` = `surf`.`user` ) >= `cpc` AND `id` NOT IN (SELECT `site_id` FROM `surfed` WHERE `user_id`='{$data->id}') ORDER BY `cpc` DESC LIMIT 0, 1");
$site2 = mysql_fetch_object($mysite);
$ext = mysql_num_rows($mysite);
if($ext > 0){
    ?>
<script type="text/javascript">
    var calcHeight = function() {
        $('iframe').height($(window).height() - 30);
    }
    
    $(window).resize(function() {
        calcHeight();
    }).load(function() {
        calcHeight();
    });
    setTimeout("start()",1000);
    var timer = <?php echo $site->surftime; ?>;
    function start() {
        if (timer>1) {
            timer = timer - 1;
            $("#seconds").html(timer);
            setTimeout("start()",1000);
        } else {
            $("#seconds").html("0");
            var response = '<? echo $site2->id;?>';
            var userid = "<? echo $data->id;?>";
            $.ajax({
                type: "POST",
                url: "plugins/surf/complete.php",
                data: "site=" + response +"&userid=" + userid,
                success: function(msg){
                    document.getElementById(response).style.display='inline';
                }
            });
        }
    }

function refreshpage()
{
    window.location.reload();
}
</script>
<div class="header">
<a href="index.php" style="margin-right:20px;"><?php echo $site->site_name; ?></a>
<font style="margin-right:20px;">You have <?php echo $data->coins; ?> coins!</font>
Gain <? echo $site2->cpc - 1;?> coins in <font id="seconds"><?php echo $site->surftime; ?></font> Seconds
<button onclick="javascript:window.location = document.location.href + '&a=skip&id=<? echo $site2->id;?>';" style="margin-left:20px;">Skip</button>
<button onclick="javascript:refreshpage()" style="display:none; margin-left:20px;" id="<?php echo $site2->id; ?>">Next</button>
</div>
<iframe src="<? echo $site2->url;?>"></iframe>
<?php
}else{ echo ' Tut uns leid: Es sind keine Coins mehr vorhanden! Bitte versuchen sie es in ein paar Minuten erneut! <a href="index.php">Go Back</a>'; } ?>
    