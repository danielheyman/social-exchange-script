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
            mysql_query("INSERT INTO `watched` ('user_id', 'site_id') VALUES('{$data->id}','{$gets['id']}')");
        }}}

        $mysite = mysql_query("SELECT * FROM `youtube` WHERE `active` = '0' AND (SELECT `coins` FROM `users` WHERE `id` = `youtube`.`user` ) >= `cpc` AND `id` NOT IN (SELECT `site_id` FROM `watched` WHERE `user_id`='{$data->id}') ORDER BY `cpc` DESC LIMIT 0, 1");
        $site2 = mysql_fetch_object($mysite);
        $ext = mysql_num_rows($mysite);
        if($ext > 0){
            ?>
            <script src="swfobject.js"></script>

        <script type="text/javascript">
        </script>
        <?php
        $url = explode('watch?v=', $site2->url);
        $url = $url[1];

        ?>
        <div id="Hint" class="hint"></div>
        <center>
        View this video for 10 seconds and after that you will receive <? echo $site2->cpc - 1;?> coins<br/><br/>
<div id="player"></div>
<script src="https://www.youtube.com/player_api"></script>
<script>
    /**
     * Put your video IDs in this array
     */
    var videoIDs = [
        '<? echo $url;?>',// PHP Code Display
        '<? echo $url;?>', // PHP Code Display

    ];
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = false;
    ga.src = 'http://www.youtube.com/player_api';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
    var player, currentVideoId = 0;
    var timestamp = 10;
    var timer;
    var done = false;
    var response = '<? echo $site2->id;?>';
    var cpc = '<? echo $site2->cpc - 1;?>';
    var userid = '<? echo $data->id;?>';
    
                       

 
    function timestamp_reached() {
       alert('you have gained ' + cpc + ' coins!');
            document.getElementById("Hint").style.display='block';
            $("#Hint").html('Please Wait...');
            $.ajax({
                type: 'POST',
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
    }

    function timestamp_callback() {
        clearTimeout(timer);
            
        current_time = player.getCurrentTime();
            //alert(current_time);
        remaining_time = timestamp - current_time;
            //alert(remaining_time);
        if (remaining_time > 0) {
            timer = setTimeout(timestamp_reached, remaining_time * 1000);
        }    
    }
    
    function onPlayerStateChange(evt) {
            //alert(evt.data);
        if (evt.data == YT.PlayerState.PLAYING) {
            timestamp_callback();
        }
    };
 
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            height: '350',
            width: '425',
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerReady(event) {
        event.target.loadVideoById(videoIDs[currentVideoId]);
    }


</script>

        <br/>
        
        <br /><div>Must play for <span id="played" style="color:blue"></span>10 seconds (<a href="xchange.php?p=yt&id=<? echo $site2->id;?>" style="color:blue">Skip</a>)</div>
        <div id="<? echo $site2->id;?>" style="visibility:hidden"><a href="javascript:refreshpage()">View Next Video</a></div>
        </center>
    
    
        <?php
        }else{ echo '<div class="error">ERROR: Sorry, there are no coins left! Please try again in a few minutes!</div>'; } ?>
    </div>
</div>
