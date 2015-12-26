<?php
include 'header.php';
if(isset($data)) {
?>
<div class="contentbox">
    <div class="head">Promote/Refer <?php echo $site->site_name; ?></div>
    <div class="contentinside">
        <font size="2" style="line-height:25px;">Promote our link and you will earn 1 coin for every unique user who clicks on your link.
        <br/>For each user that signs up to <?echo $site->site_name;?> from your Referral Link, you get 50 coins.
        <br/><b>Bonus: </b>Earn <?php echo $site->refbonus * 100; ?>% of all your referral's earnings.<br/><br/>
        </font>
            <div class="contentform">
            <?php
                $num = $data->promote;
                $refer = mysql_query("SELECT id FROM `referals` WHERE `user`='{$data->username}' and  `registered`='true'");
                $num2 = mysql_num_rows($refer);
                ?>  
                <input type="text" style="text-align:center;" value="Total Referals: <?php echo $num2; ?>" size="33" onclick="this.select()" readonly="true"/>
                <input type="text" style="text-align:center;" value="Total Page Views: <?php echo $num; ?>" size="33" onclick="this.select()" readonly="true"/><br><br>
			    <center><b>Your Referral Link:</b><br>
                <input type="text" style="text-align:center;" value="<?php echo $site->site_url;?>/?r=<?php echo $data->id;?>" size="33" onclick="this.select()" readonly="true"/></center><br/>
                <center><b>Your HTML Code</b><br>
                <input type="text" style="text-align:center;" onclick="this.select()" readonly="true" value='<a href="<?php echo $site->site_url;?>/?r=<?php echo $data->id;?>" target="_blank"><?php echo $site->site_name;?></a>'/></center><br/>
                <center><b>Your BB/Forum Code</b><br>
                <input type="text" style="text-align:center;" onclick="this.select()" readonly="true" value="[url=<?php echo $site->site_url;?>/?r=<?php echo $data->id;?>]<?php echo $site->site_name;?>[/url]"/></center><br><br><br><br><br>
                <center><b>Banner #1 Code</b><br>
                <center><img src="http://you-like-hits.com/promo/banner1.png"></center><br>
                <input type="text" style="text-align:center;" onclick="this.select()" readonly="true" value='<a href="<?php echo $site->site_url;?>/?r=<?php echo $data->id;?>" target="_blank"><img src="http://you-like-hits.com/promo/banner1.gif" alt="You-Like-Hits.Com"></a>'/></center><br/>
                
                <br/><br/>
                <?php
                $num = $data->promote;
                $refer = mysql_query("SELECT id FROM `referals` WHERE `user`='{$data->username}' and  `registered`='true'");
                $num2 = mysql_num_rows($refer);
                ?>  
                <input type="text" style="text-align:center;" value="Total Referals: <?php echo $num2; ?>" size="33" onclick="this.select()" readonly="true"/>
                <input type="text" style="text-align:center;" value="Total Page Views: <?php echo $num; ?>" size="33" onclick="this.select()" readonly="true"/>
            </div>
	
    </div>
</div>
<?php
}
else
{
    echo "Please login to view this page!";
}
include 'footer.php';
?>