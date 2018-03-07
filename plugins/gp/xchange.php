<div class="contentbox">
    <div class="head">Google Plus</div>
    <div class="contentinside">
        <?php
        $mysite = mysql_query("SELECT * FROM `googleplus` WHERE `active` = '0' AND (SELECT `coins` FROM `users` WHERE `id` = `googleplus`.`user` ) >= `cpc` AND `id` NOT IN (SELECT `site_id` FROM `googleplused` WHERE `user_id`='{$data->id}') ORDER BY `cpc` DESC LIMIT 0, 10");
        $ext = mysql_num_rows($mysite);
        if($ext > 0){
            ?>
            <script language="javascript">
            function skipuser(str,user) {
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('Skipping User...');
                $.ajax({
                    type: "POST",
                    url: "plugins/gp/complete.php?step=skip",
                    data: "id="+user+"&user="+str,
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
            
            function click_callback(plusone){
                if(plusone.state == "on")
                {
                    document.getElementById("Hint").style.display='block';
                    $("#Hint").html('Google Plusing...');
                    var user = "<? echo $data->id;?>";
                    var url = plusone.href;
                    if(url.charAt(url.length-1) == "/")
                    {
                        url = url.substring(0, url.length-1);
                    }
                    id = document.getElementById(url).innerHTML;
                    $.ajax({
                        type: "POST",
                        url: "plugins/gp/complete.php",
                        data: "id="+id + "&user=" + user,        
                        cache: false,
                        success: function(msg){
                            $("#Hint").html('Google Plused with success!');
                            var coins = $("#coins").html().replace(" Coins", "");
                            coins = parseInt(coins) + parseInt($("#" + id + "points").html().replace("Coins: <b>","").replace("</b>",""));
                            $("#coins").html(coins + " Coins");
                            removeElement('boxes', id);
                        }
                    });
                }
            }
            
            function removeElement(parentDiv, childDiv){
                if (document.getElementById(childDiv)) {     
                    var child = document.getElementById(childDiv);
                    var parent = document.getElementById(parentDiv);
                    parent.removeChild(child);
                }
            }
            </script>
            <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
            
            <div id="Hint" class="hint"></div>
            <div id="boxes">
                <?php
                for($j=1; $site2 = mysql_fetch_object($mysite); $j++)
                {
                    $url = $site2->url;
                    if(substr($url, -1) == "/")
                    {
                        $url = substr($url, 0, -1);
                    }
                    $title = substr($site2->title,0,13);
                    ?>	
                    <div class="xchangebox" id="<? echo $site2->id;?>">
                        <div id="<? echo $url;?>" style="display:none;"><? echo $site2->id;?></div>
                        <g:plusone callback='click_callback' href="<? echo $site2->url;?>" size="medium"></g:plusone>
                        <div class="title"><a href="<? echo $site2->url;?>" target="_blank"><? echo $title;?></a></div>
                        <div class="points" id="<? echo $site2->id;?>points">Coins: <b><? echo $site2->cpc - 1;?></b></div>
                        (<a href="#" onclick="skipuser('<? echo $data->id;?>','<? echo $site2->id;?>');">skip</a>)
                    </div>
                    <?php 
                }   
            ?></div><input onclick='refreshpage();' class="refresh" type='button' value='Refresh'><?php
        }else{ echo '<div class="error">ERROR: Sorry, there are no coins left! Please try again in a few minutes!</div>'; } ?>
    </div>
</div>