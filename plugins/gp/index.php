<?php
if(!mysql_num_rows(mysql_query("SHOW TABLES LIKE 'googleplus'")))
{
   executeSql("plugins/gp/db.sql");
}

register_filter('index_icons','googleplus_icon');
function googleplus_icon($icons) {
	return $icons . '<td align="center" width="14%" valign="top"><img src="60/google.png" alt="Get Google Plus"><br><b>Google Plus</b></td>';
}

register_filter('top_menu_earn','googleplus_top_menu');
function googleplus_top_menu($menu) {
	return $menu . "<li><a href='xchange.php?p=gp'>Google Plus</a></li>";
}

register_filter('site_menu','googleplus_site_menu');
function googleplus_site_menu($menu) {
    $selected = "";
    if(isset($_GET["p"]) && $_GET["p"] == "gp")
    {
        $selected = "class='selected'";
    }
    else
    {
        $selected = "href='sites.php?p=gp'";
    }
	return $menu . "<a {$selected}>Google Plus</a>";
}

register_filter('gp_info','googleplus_info');
function googleplus_info($type) {
    if($type == "db")
    {
        return "googleplus";
    }
    else if($type == "type")
    {
        return "Google Plus";
    }
}

register_filter('add_site_select','googleplus_add_select');
function googleplus_add_select($menu) {
    if(isset($_POST["type"]) && $_POST["type"] == "gp")
    {
	    return $menu . "<option value='gp' selected>Google PLus</option>";
    }
    else
    {
        return $menu . "<option value='gp'>Google Plus</option>";
    }
}


register_filter('stats','googleplus_stats');
function googleplus_stats($stats) {
    $stat = mysql_query("SELECT * FROM `googleplus`");
    $stat = mysql_num_rows($stat);
    $clicks = mysql_fetch_object(mysql_query("SELECT SUM( `exchanges` ) AS `visits` FROM `googleplus`"));
    $clicks = $clicks->visits;
    if($clicks == "") { $clicks = 0; }
    return $stats . "<tr><td>Google Plus</td><td>{$stat}</td><td>{$clicks}</td></tr>";
}
?>