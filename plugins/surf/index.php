<?php
if(!mysql_num_rows(mysql_query("SHOW TABLES LIKE 'surf'")))
{
   executeSql("plugins/surf/db.sql");
}

$sql=mysql_query("SELECT surftime FROM settings");
if (!$sql){
    mysql_query("ALTER TABLE settings ADD surftime varchar(50) NOT NULL DEFAULT '10'");
}

register_filter('admin_settings','surf_settings');
function surf_settings($settings)
{
    $site = mysql_fetch_object(mysql_query("SELECT surftime FROM `settings`"));
    return $settings . 'Surf Time (2 - infinite)<br/><input name="surftime" type="text" value="' . $site->surftime . '"/><br/><br/>';
}

register_filter('admin_settings_post','surf_settings_post');
function surf_settings_post($settings)
{
    return $settings . ", `surftime`='{$_POST['surftime']}'";
}

register_filter('index_icons','surf_icon');
function surf_icon($icons) {
	return $icons . '<td align="center" width="14%" valign="top"><img src="60/yelp.png" alt="Get Website Traffic"><br><b>Website Traffic</b></td>';
}

            
register_filter('top_menu_earn','surf_top_menu');
function surf_top_menu($menu) {
	return $menu . "<li><a target='_blank' href='p.php?p=surf'>Surf</a></li>";
}

register_filter('site_menu','surf_site_menu');
function surf_site_menu($menu) {
    $selected = "";
    if(isset($_GET["p"]) && $_GET["p"] == "surf")
    {
        $selected = "class='selected'";
    }
    else
    {
        $selected = "href='sites.php?p=surf'";
    }
	return $menu . "<a {$selected}>Surf</a>";
}

register_filter('surf_info','surf_info');
function surf_info($type) {
    if($type == "db")
    {
        return "surf";
    }
    else if($type == "type")
    {
        return "Surf";
    }
}

register_filter('add_site_select','surf_add_select');
function surf_add_select($menu) {
    if(isset($_POST["type"]) && $_POST["type"] == "surf")
    {
	    return $menu . "<option value='surf' selected>Surf</option>";
    }
    else
    {
        return $menu . "<option value='surf'>Surf</option>";
    }
}


register_filter('stats','surf_stats');
function surf_stats($stats) {
    $stat = mysql_query("SELECT * FROM `surf`");
    $stat = mysql_num_rows($stat);
    $clicks = mysql_fetch_object(mysql_query("SELECT SUM( `exchanges` ) AS `visits` FROM `surf`"));
    $clicks = $clicks->visits;
    if($clicks == "") { $clicks = 0; }
    return $stats . "<tr><td>Surf</td><td>{$stat}</td><td>{$clicks}</td></tr>";
}

?>