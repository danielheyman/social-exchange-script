<?php
if(!mysql_num_rows(mysql_query("SHOW TABLES LIKE 'retweet'")))
{
   executeSql("plugins/rt/db.sql");
}

register_filter('index_icons','retweet_icon');
function retweet_icon($icons) {
	return $icons . '<td align="center" width="14%" valign="top"><img src="60/twitter.png" alt="Get Twitter Retweets"><br><b>Twitter Retweets</b></td>';
}

register_filter('top_menu_earn','retweet_top_menu');
function retweet_top_menu($menu) {
	return $menu . "<li><a href='xchange.php?p=rt'>Retweet</a></li>";
}

register_filter('site_menu','retweet_site_menu');
function retweet_site_menu($menu) {
    $selected = "";
    if(isset($_GET["p"]) && $_GET["p"] == "rt")
    {
        $selected = "class='selected'";
    }
    else
    {
        $selected = "href='sites.php?p=rt'";
    }
	return $menu . "<a {$selected}>Retweet</a>";
}

register_filter('rt_info','retweet_info');
function retweet_info($type) {
    if($type == "db")
    {
        return "retweet";
    }
    else if($type == "type")
    {
        return "Retweet";
    }
}

register_filter('add_site_select','retweet_add_select');
function retweet_add_select($menu) {
    if(isset($_POST["type"]) && $_POST["type"] == "rt")
    {
	    return $menu . "<option value='rt' selected>Retweet</option>";
    }
    else
    {
        return $menu . "<option value='rt'>Retweet</option>";
    }
}


register_filter('stats','retweet_stats');
function retweet_stats($stats) {
    $stat = mysql_query("SELECT * FROM `retweet`");
    $stat = mysql_num_rows($stat);
    $clicks = mysql_fetch_object(mysql_query("SELECT SUM( `exchanges` ) AS `visits` FROM `retweet`"));
    $clicks = $clicks->visits;
    if($clicks == "") { $clicks = 0; }
    return $stats . "<tr><td>Retweet</td><td>{$stat}</td><td>{$clicks}</td></tr>";
}
?>