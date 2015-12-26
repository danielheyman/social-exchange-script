<?php
if(!mysql_num_rows(mysql_query("SHOW TABLES LIKE 'youtube'")))
{
   executeSql("plugins/yt/db.sql");
}

register_filter('index_icons','youtube_icon');
function youtube_icon($icons) {
	return $icons . '<td align="center" width="14%" valign="top"><img src="60/youtube.png" alt="Get Youtube Views"><br><b>Youtube Views</b></td>';
}

            
register_filter('top_menu_earn','youtube_top_menu');
function youtube_top_menu($menu) {
	return $menu . "<li><a href='xchange.php?p=yt'>Youtube</a></li>";
}

register_filter('site_menu','youtube_site_menu');
function youtube_site_menu($menu) {
    $selected = "";
    if(isset($_GET["p"]) && $_GET["p"] == "yt")
    {
        $selected = "class='selected'";
    }
    else
    {
        $selected = "href='sites.php?p=yt'";
    }
	return $menu . "<a {$selected}>Youtube</a>";
}

register_filter('yt_info','youtube_info');
function youtube_info($type) {
    if($type == "db")
    {
        return "youtube";
    }
    else if($type == "type")
    {
        return "Youtube";
    }
}

register_filter('add_site_select','youtube_add_select');
function youtube_add_select($menu) {
    if(isset($_POST["type"]) && $_POST["type"] == "yt")
    {
	    return $menu . "<option value='yt' selected>Youtube</option>";
    }
    else
    {
        return $menu . "<option value='yt'>Youtube</option>";
    }
}


register_filter('stats','youtube_stats');
function youtube_stats($stats) {
    $stat = mysql_query("SELECT * FROM `youtube`");
    $stat = mysql_num_rows($stat);
    $clicks = mysql_fetch_object(mysql_query("SELECT SUM( `exchanges` ) AS `visits` FROM `youtube`"));
    $clicks = $clicks->visits;
    if($clicks == "") { $clicks = 0; }
    return $stats . "<tr><td>Youtube</td><td>{$stat}</td><td>{$clicks}</td></tr>";
}

?>