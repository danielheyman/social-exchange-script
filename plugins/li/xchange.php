<div class="contentbox">
    <div class="head">Linkedin</div>
    <div class="contentinside">
        <?php
        $mysite = mysql_query("SELECT * FROM `linkedin` WHERE `active` = '0' AND (SELECT `coins` FROM `users` WHERE `id` = `linkedin`.`user` ) >= `cpc` AND `id` NOT IN (SELECT `site_id` FROM `linked` WHERE `user_id`='{$data->id}') ORDER BY `cpc` DESC LIMIT 0, 10");
        $ext = mysql_num_rows($mysite);
        if($ext > 0){
            ?>
            <script language="javascript">
            function skipuser(str,user) {
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('Skipping User...');
                $.ajax({
                    type: "POST",
                    url: "plugins/li/complete.php?step=skip",
                    data: "me="+str+"&him="+user,
                    success: function(msg){
                        $("#Hint").html(msg);
                    }
                });
                removeElement('boxes',user);
            }
            function refreshpage()
            {
                window.location.reload();
            }
            function click_callback(str,user)
            {
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('We are verifying your share!');
                $.ajax({
                    type: "POST",
                    url: "plugins/li/complete.php",
                    data: "me="+str+"&him="+user,
                    success: function(msg){
                        $("#Hint").html(msg);
                        var coins = $("#coins").html().replace(" Coins", "");
                        coins = parseInt(coins) + parseInt($("#" + user + "points").html().replace("Coins: <b>","").replace("</b>",""));
                        $("#coins").html(coins + " Coins");
                        removeElement('boxes', user);
                    }
                });
            }
            
            function removeElement(parentDiv, childDiv){
                if (document.getElementById(childDiv)) {     
                    var child = document.getElementById(childDiv);
                    var parent = document.getElementById(parentDiv);
                    parent.removeChild(child);
                }
            }
            </script>
            <script src="http://platform.linkedin.com/in.js" type="text/javascript"></script> 
            <div id="Hint" class="hint"></div>
            <div id="boxes">
                <?php
                for($j=1; $site2 = mysql_fetch_object($mysite); $j++)
                {
                    $title = substr($site2->title,0,13);
                    ?>	
                    <div class="xchangebox" id="<? echo $site2->id;?>">
                        <a href="<? echo $site2->url;?>" target="_blank"><? echo $title;?></a><br/>
                        <div style="height:40px;"><script type="IN/Share" data-url="<? echo $site2->url;?>" data-counter="right" data-onSuccess="shared<? echo $site2->id;?>"></script></div>
                        <div class="points" id="<? echo $site2->id;?>points">Coins: <b><? echo $site2->cpc - 1;?></b></div>
                        (<a href="#" onclick="skipuser('<? echo $data->id;?>','<? echo $site2->id;?>');">skip</a>)
                    </div>
                    <script type="text/javascript">
                    function shared<? echo $site2->id;?>(){
                        click_callback('<? echo $data->id;?>','<? echo $site2->id;?>');	
                    }
                    </script>
                    <?php 
                } 
            ?></div><input onclick='refreshpage();' class="refresh" type='button' value='Refresh'><?php
        }else{ echo '<div class="error">ERROR: Sorry, there are no coins left! Please try again in a few minutes!</div>'; }?>
    </div>
</div>