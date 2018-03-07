<div class="contentbox">
    <div class="head">Stumbleupon</div>
    <div class="contentinside">
        <?php
        $mysite = mysql_query("SELECT * FROM `stumbleupon` WHERE `active` = '0' AND (SELECT `coins` FROM `users` WHERE `id` = `stumbleupon`.`user` ) >= `cpc` AND `id` NOT IN (SELECT `site_id` FROM `stumbled` WHERE `user_id`='{$data->id}') ORDER BY `cpc` DESC LIMIT 0, 10");
        $ext = mysql_num_rows($mysite);
        if($ext > 0){
            ?>
            <script language="javascript">
            function skipuser(str,user) {
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('Skipping User...');
                $.ajax({
                    type: "POST",
                    url: "plugins/su/complete.php?step=skip",
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
            function stumbleuser(str, id)
            {
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('We are verifying your follow...');
                $.ajax({
                    type: "POST",
                    url: "plugins/su/complete.php",
                    data: "me="+str+"&him="+id+"&count="+count,
                    success: function(msg){
                        $("#Hint").html(msg);
                        var coins = $("#coins").html().replace(" Coins", "");
                        coins = parseInt(coins) + parseInt($("#" + id + "points").html().replace("Coins: <b>","").replace("</b>",""));
                        $("#coins").html(coins + " Coins");
                        removeElement('boxes', id);
                    }
                });
            }
            var count = 1000000;
            function stumbleopen(url,encodedurl)
            {
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('We are opening stumbleupon...');
                $.ajax({
                    type: "GET",
                    url: "plugins/su/getcount.php",
                    data: "url="+encodedurl,
                    success: function(msg){
                        if(!isNaN(msg))
                        {
                            $("#Hint").html('SUCCESS: We are contacted stumbleopen...');
                            count = msg;
                            window.open(url,'Stumbleupon','status=0,toolbar=0,width=1000,height=500,resizable=0,menubar=0,location=0,directories=0');
                        }
                        else
                        {
                            $("#Hint").html('We cannot contact stumbleopen...');
                        }
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
                    ?>	
                    <div class="xchangebox" id="<? echo $site2->id;?>">
                        <? echo $title;?><br/>
                        <a href="javascript:void(0);" onclick="stumbleopen('<? echo $site2->url;?>','<? echo urlencode($site2->url);?>');"><button>Follow</button></a>
                        <br/><a href="javascript:void(0);" onclick="stumbleuser('<? echo $data->id;?>','<? echo $site2->id;?>');"><button>Confirm</button></a>
                        <div class="points" id="<? echo $site2->id;?>points">Coins: <b><? echo $site2->cpc - 1;?></b></div>
                        (<a href="#" onclick="skipuser('<? echo $data->id;?>','<? echo $site2->id;?>');">skip</a>)
                    </div>
                    <?php 
                } 
            ?></div><input onclick='refreshpage();' class="refresh" type='button' value='Refresh'><?php
        }else{ echo '<div class="error">ERROR: Sorry, there are no coins left! Please try again in a few minutes!</div>'; } ?>
    </div>
</div>