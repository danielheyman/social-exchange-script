<div class="contentbox">
    <div class="head">Twitter</div>
    <div class="contentinside">
        <?php
        $mysite = mysql_query("SELECT * FROM `twitter` WHERE `active` = '0' AND (SELECT `coins` FROM `users` WHERE `id` = `twitter`.`user` ) >= `cpc` AND `id` NOT IN (SELECT `site_id` FROM `followed` WHERE `user_id`='{$data->id}') ORDER BY `cpc` DESC LIMIT 0, 10");
        $ext = mysql_num_rows($mysite);
        if($data->twitter != ""){
        if($ext > 0){
            ?>
            <script language="javascript">
            function skipuser(str,user) {
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('User Skippen...');
                $.ajax({
                    type: "POST",
                    url: "plugins/tw/complete.php?step=skip",
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
            function followuser(str,user,name)
            {
            document.getElementById("Hint").style.display='block';
                $("#Hint").html('Verifiziere@'+name+'...');
                $.ajax({
                    type: "POST",
                    url: "plugins/tw/complete.php",
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
            <div id="Hint" class="hint"></div>
            <div id="boxes">
                <?php
                for($j=1; $site2 = mysql_fetch_object($mysite); $j++)
                {
                    $title = substr($site2->title,0,13);
                    $id = explode("/", $site2->url);
                    $id = $id[count($id) - 1];
                    ?>	
                    <div class="xchangebox" id="<? echo $site2->id;?>">
                        <? echo $title;?><br/>
                        <a href="javascript:void(0);" onclick="window.open('<? echo $site2->url;?>','Twitter','status=0,toolbar=0,width=1000,height=500,resizable=0,menubar=0,location=0,directories=0');"><button>Follow</button></a>
                        <br/><a href="javascript:void(0);" onclick="followuser('<? echo $data->id;?>','<? echo $site2->id;?>','<? echo $id;?>');"><button>Confirm</button></a>
                        <div class="points" id="<? echo $site2->id;?>points">Coins: <b><? echo $site2->cpc - 1;?></b></div>
                        (<a href="#" onclick="skipuser('<? echo $data->id;?>','<? echo $site2->id;?>');">skip</a>)
                    </div>
                    <?php 
                } 
            ?></div><input onclick='refreshpage();' class="refresh" type='button' value='Refresh'><?php
        }else{ echo '<div class="error">ERROR: Sorry kein content mehr.</div>'; }
        }else{ echo '<div class="error">ERROR: <a href="settings.php">Bitte Twitter Account unter einstellungen eingeben!</a></div>'; }?>
    </div>
</div>