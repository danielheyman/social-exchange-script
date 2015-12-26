<div class="contentbox">
    <div class="head">Youtube</div>
    <div class="contentinside">
        <?php
        foreach($_GET as $key => $value) {
        $gets[$key] = filter($value);
        }
            if(isset($_GET['a'])){if($_GET['a'] == "skip"){
            $sit1 = mysql_query("SELECT * FROM `youtube` WHERE `id`='{$gets['id']}'");
            $sit = mysql_num_rows($sit1);
            if($sit > 0){
            mysql_query("INSERT INTO `watched` (user_id, site_id) VALUES('{$data->id}','{$gets['id']}')");
        }}}

        $mysite = mysql_query("SELECT * FROM `youtube` WHERE `active` = '0' AND (SELECT `coins` FROM `users` WHERE `id` = `youtube`.`user` ) >= `cpc` AND `id` NOT IN (SELECT `site_id` FROM `watched` WHERE `user_id`='{$data->id}') ORDER BY `cpc` DESC LIMIT 0, 1");
        $site2 = mysql_fetch_object($mysite);
        $ext = mysql_num_rows($mysite);
        if($ext > 0){
            ?>
            <script src="swfobject.js"></script>
        <script type="text/javascript">
        var playing = false;
        var fullyPlayed = false;
        var interval = '';
        var played = 0;
        var length = 10;
        
        function YouTubePlaying(){
            played += 0.1;
            roundedPlayed = Math.ceil(played);
            document.getElementById("played").innerHTML = Math.min(roundedPlayed,length);
            if (roundedPlayed == length){
                if (fullyPlayed == false){
                    YouTubePlayed();
                    fullyPlayed = true;
                }
            }
        }
        function YouTubePlayed(){
            document.getElementById("Hint").style.display='block';
            $("#Hint").html('Please Wait...');
            var response = '<? echo $site2->id;?>';
            var cpc = '<? echo $site2->cpc - 1;?>';
            var userid = "<? echo $data->id;?>";
            $.ajax({
                type: "POST",
                url: "plugins/yt/complete.php",
                data: "site=" + response +"&userid=" + userid,
                success: function(msg){
                    var coins = $("#coins").html().replace(" Coins", "");
                    coins = parseInt(coins) + parseInt(cpc);
                    $("#coins").html(coins + " Coins");
                    $("#Hint").html('You have gained ' + cpc + ' coins!');
                }
            });
            document.getElementById(response).style.visibility = "visible";
        }
        
        function onYouTubePlayerReady(playerId){
            ytplayer = document.getElementById("myytplayer");
            ytplayer.addEventListener("onStateChange", "onYouTubePlayerStateChange");
        }
        function onYouTubePlayerStateChange(newState){
            if (newState == 1){
                playing = true;
                interval = window.setInterval('YouTubePlaying()',100);
            }else if (newState == 0){
                if (playing) window.clearInterval(interval);
                playing = false;
                ytplayer.stopVideo();
                ytplayer.playVideo();
            }else{
                if (playing) window.clearInterval(interval);
                playing = false;
            }
        }
        function refreshpage()
        {
            window.location.reload();
        }
        </script>
        <?php
        $url = explode('watch?v=', $site2->url);
        $url = $url[1];
        ?>
        <div id="Hint" class="hint"></div>
        <center>
        View this video for 10 seconds and after that you will receive <? echo $site2->cpc - 1;?> coins<br/><br/>
        <div id="ytPlayer">You need Flash player 8+ and JavaScript enabled to view this video.</div>
        <script type="text/javascript">
        var params = { allowScriptAccess: "always" };
        var atts = { id: "myytplayer" };
        swfobject.embedSWF("http://www.youtube.com/v/<? echo $url;?>?enablejsapi=1&playerapiid=ytplayer", "ytPlayer", "425", "356", "8", null, null, params, atts);
        </script>
        <br/>
        
        <br />Must play for <span id="played">0</span>/10 seconds (<a href="xchange.php?p=yt&a=skip&id=<? echo $site2->id;?>" style="color:blue">Skip</a>)
        <div id="<? echo $site2->id;?>" style="visibility:hidden"><a href="javascript:refreshpage()">View Next Video</a></div>
        </center>
    
    
        <?php
        }else{ echo '<div class="error">ERROR: Tut uns leid: Es sind keine Coins mehr vorhanden! Bitte versuchen sie es in ein paar Minuten erneut!</div>'; } ?>
    </div>
</div>