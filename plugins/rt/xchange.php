<div class="contentbox">
    <div class="head">Retweet</div>
    <div class="contentinside">
        <?php
        $mysite = mysql_query("SELECT * FROM `retweet` WHERE `active` = '0' AND (SELECT `coins` FROM `users` WHERE `id` = `retweet`.`user` ) >= `cpc` AND `id` NOT IN (SELECT `site_id` FROM `retweeted` WHERE `user_id`='{$data->id}') ORDER BY `cpc` DESC LIMIT 0, 10");
        $ext = mysql_num_rows($mysite);
        if($ext > 0){
            ?>
            <script language="javascript">
            function skipuser(str,user) {
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('Skipping User...');
                $.ajax({
                    type: "POST",
                    url: "plugins/rt/complete.php?step=skip",
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
            
            (function($) {
            $(document).ready(function() {
                $.getScript("http://platform.twitter.com/widgets.js", function(){
                    twttr.events.bind('tweet', function(event) {
                        var targetUrl = event.target.src;
                        var query = getQueryParams(targetUrl);
                        click_callback(query.url);
                    });
                });
            });
            })(jQuery);
            
            function getQueryParams(qs) {
                qs = qs.split("+").join(" ");
                var params = {}, tokens,
                    re = /[?&]?([^=]+)=([^&]*)/g;
                while (tokens = re.exec(qs)) {
                    params[decodeURIComponent(tokens[1])]
                        = decodeURIComponent(tokens[2]);
                }
                return params;
            }

            function click_callback(id){
                var user = "<? echo $data->id;?>";
                document.getElementById("Hint").style.display='block';
                $("#Hint").html('Confirming Tweet...');
                $.ajax({
                    type: "POST",
                    url: "plugins/rt/complete.php",
                    data: "id="+ id + "&user=" + user,
                    success: function(msg){
                        $("#Hint").html('Tweeted! You have gained coins!');
                        var coins = $("#coins").html().replace(" Coins", "");
                        coins = parseInt(coins) + parseInt($("#" + id + "points").html().replace("Coins: <b>","").replace("</b>",""));
                        $("#coins").html(coins + " Coins");
                        removeElement('boxes', id);
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
                        <div id="<? echo $site2->url;?>" style="display:none;"><? echo $site2->id;?></div>
                        <a href="https://twitter.com/share" class="twitter-share-button" data-url="<? echo $site2->id;?>" data-text="<? echo $site2->title;?> <? echo $site2->url;?>" data-count="horizontal">Tweet</a>
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