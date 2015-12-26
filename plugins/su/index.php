<?php
if(!mysql_num_rows(mysql_query("SHOW TABLES LIKE 'stumbleupon'")))
{
   executeSql("plugins/su/db.sql");
}

$sql=mysql_query("SELECT stumbleupon FROM users");
if (!$sql){
    mysql_query("ALTER TABLE users ADD stumbleupon varchar(255) NOT NULL");
}

register_filter('index_icons','stumbleupon_icon');
function stumbleupon_icon($icons) {
	return $icons . '<td align="center" width="14%" valign="top"><img src="60/stumbleupon.png" alt="Get StumbleUpon Followers"><br><b>StumbleUpon Followers</b></td>';
}
            
register_filter('top_menu_earn','stumbleupon_top_menu');
function stumbleupon_top_menu($menu) {
	return $menu . "<li><a href='xchange.php?p=su'>Stumbleupon</a></li>";
}

register_filter('site_menu','stumbleupon_site_menu');
function stumbleupon_site_menu($menu) {
    $selected = "";
    if(isset($_GET["p"]) && $_GET["p"] == "su")
    {
        $selected = "class='selected'";
    }
    else
    {
        $selected = "href='sites.php?p=su'";
    }
	return $menu . "<a {$selected}>Stumbleupon</a>";
}

register_filter('su_info','stumbleupon_info');
function stumbleupon_info($type) {
    if($type == "db")
    {
        return "stumbleupon";
    }
    else if($type == "type")
    {
        return "Stumbleupon";
    }
}

register_filter('add_site_select','stumbleupon_add_select');
function stumbleupon_add_select($menu) {
    if(isset($_POST["type"]) && $_POST["type"] == "su")
    {
	    return $menu . "<option value='su' selected>Stumbleupon</option>";
    }
    else
    {
        return $menu . "<option value='su'>Stumbleupon</option>";
    }
}


register_filter('stats','stumbleupon_stats');
function stumbleupon_stats($stats) {
    $stat = mysql_query("SELECT * FROM `stumbleupon`");
    $stat = mysql_num_rows($stat);
    $clicks = mysql_fetch_object(mysql_query("SELECT SUM( `exchanges` ) AS `visits` FROM `stumbleupon`"));
    $clicks = $clicks->visits;
    if($clicks == "") { $clicks = 0; }
    return $stats . "<tr><td>Stumbleupon</td><td>{$stat}</td><td>{$clicks}</td></tr>";
}


/*register_action('initialize','facebook2');

function facebook2() {
	echo "Ich mag Facebook!";
}*/

?>