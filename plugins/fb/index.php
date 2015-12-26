<?php
if(!mysql_num_rows(mysql_query("SHOW TABLES LIKE 'facebook'")))
{
   executeSql("plugins/fb/db.sql");
}

register_filter('index_icons','facebook_icon');
function facebook_icon($icons) {
	return $icons . '<td align="center" width="14%" valign="top"><img src="60/facebook.png" alt="Get Facebook Likes"><br><b>Facebook Likes</b></td>';
}

register_filter('top_menu_earn','facebook_top_menu');
function facebook_top_menu($menu) {
	return $menu . "<li><a href='xchange.php?p=fb'>Facebook</a></li>";
}

register_filter('site_menu','facebook_site_menu');
function facebook_site_menu($menu) {
    $selected = "";
    if(isset($_GET["p"]) && $_GET["p"] == "fb")
    {
        $selected = "class='selected'";
    }
    else
    {
        $selected = "href='sites.php?p=fb'";
    }
	return $menu . "<a {$selected}>Facebook</a>";
}

register_filter('fb_info','facebook_info');
function facebook_info($type) {
    if($type == "db")
    {
        return "facebook";
    }
    else if($type == "type")
    {
        return "Facebook";
    }
}

register_filter('add_site_select','facebook_add_select');
function facebook_add_select($menu) {
    if(isset($_POST["type"]) && $_POST["type"] == "fb")
    {
	    return $menu . "<option value='fb' selected>Facebook</option>";
    }
    else
    {
        return $menu . "<option value='fb'>Facebook</option>";
    }
}


register_filter('stats','facebook_stats');
function facebook_stats($stats) {
    $stat = mysql_query("SELECT * FROM `facebook`");
    $stat = mysql_num_rows($stat);
    $clicks = mysql_fetch_object(mysql_query("SELECT SUM( `exchanges` ) AS `visits` FROM `facebook`"));
    $clicks = $clicks->visits;
    if($clicks == "") { $clicks = 0; }
    return $stats . "<tr><td>Facebook</td><td>{$stat}</td><td>{$clicks}</td></tr>";
}


/*register_action('initialize','facebook2');

function facebook2() {
	echo "Ich mag Facebook!";
}*/

?>