<div class="contentbox">
    <div class="head">Facebook</div>
    <div class="contentinside">
        <?php
        $mysite = mysql_query("SELECT * FROM `facebook` WHERE `active` = '0' AND (SELECT `coins` FROM `users` WHERE `id` = `facebook`.`user` ) >= `cpc` AND `id` NOT IN (SELECT `site_id` FROM `liked` WHERE `user_id`='{$data->id}') ORDER BY `cpc` DESC LIMIT 0, 10");
        $ext = mysql_num_rows($mysite);
        if($ext > 0){
            ?>
            <script language="javascript">
            function refreshpage()
            {
                window.location.reload();
            }
            </script>
            <div id="fb-root"></div>
            <script>
            function skipuser(str,user) {
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('Skipping User...');
                $.ajax({
                    type: "POST",
                    url: "plugins/fb/complete.php?step=skip",
                    data: "id="+user+"&user="+str,
                    success: function(msg){
                        $("#Hint").html(msg);
                    }
                });
                removeElement('boxes',user);
            }
            window.fbAsyncInit = function() {
            FB.init({status: true, cookie: true, xfbml: true});
            var user= "<? echo $data->id;?>";
            FB.Event.subscribe('edge.create', function(response) {
                var id = document.getElementById(response).innerHTML;
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('Liking...');
                $.ajax({
                    type: "POST",
                    url: "plugins/fb/complete.php",
                    data: "id="+id + "&user=" + user,        
                    cache: false,
                    success: function(msg){
                        $("#Hint").html('Liked with success!');
                        var coins = $("#coins").html().replace(" Coins", "");
                        coins = parseInt(coins) + parseInt($("#" + id + "points").html().replace("Coins: <b>","").replace("</b>",""));
                        $("#coins").html(coins + " Coins");
                        removeElement('boxes', id);
                    }
                });
            });
            };
            (function() {
            var e = document.createElement('script');
            e.type = 'text/javascript';
            e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
            e.async = true;
            document.getElementById('fb-root').appendChild(e);
            }());
            
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
                        <div id="<? echo $site2->url;?>" style="display:none;"><? echo $site2->id;?></div>
                        <div><fb:like href="<? echo $site2->url;?>" send="false" layout="button_count" show_faces="false" font=""></fb:like></div>
                        <div class="title"><a href="<? echo $site2->url;?>" target="_blank"><? echo $title;?></a></div>
                        <div class="points" id="<? echo $site2->id;?>points">Coins: <b><? echo $site2->cpc - 1;?></b></div>
                        (<a href="#" onclick="skipuser('<? echo $data->id;?>','<? echo $site2->id;?>');">skip</a>)
                    </div>
                    <?php 
                }   
            ?></div><input onclick='refreshpage();' class="refresh" type='button' value='Refresh'><?php
        }else{ echo '<div class="error">Sorry, there are no coins left! Please try again in a few minutes!</div>'; } ?>
    </div>
</div>