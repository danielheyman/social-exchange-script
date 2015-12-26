<?php
if(!mysql_num_rows(mysql_query("SHOW TABLES LIKE 'digg'")))
{
   executeSql("plugins/dg/db.sql");
}

$sql=mysql_query("SELECT digg FROM users");
if (!$sql){
    mysql_query("ALTER TABLE users ADD digg varchar(255) NOT NULL");
}

register_filter('index_icons','digg_icon');
function digg_icon($icons) {
	return $icons . '<td align="center" width="14%" valign="top"><img src="60/digg.png" alt="Get Diggs"><br><b>Diggs</b></td>';
}

            
register_filter('settings','digg_settings');
function digg_settings($settings) {
    $user = mysql_query("SELECT digg FROM `users` WHERE `username`='{$_SESSION['username']}'");
    $data = mysql_fetch_object($user);
	return $settings . 'Digg<br/><input name="digg" type="text" value="' . $data->digg . '"><br/><br/>';
}
            
register_filter('settings_sumbit','digg_settings_submit');
function digg_settings_submit($settings) {
	return $settings . ", `digg` = '{$_POST['digg']}'";
}
            
register_filter('top_menu_earn','digg_top_menu');
function digg_top_menu($menu) {
	return $menu . "<li><a href='xchange.php?p=dg'>Digg</a></li>";
}

register_filter('site_menu','digg_site_menu');
function digg_site_menu($menu) {
    $selected = "";
    if(isset($_GET["p"]) && $_GET["p"] == "dg")
    {
        $selected = "class='selected'";
    }
    else
    {
        $selected = "href='sites.php?p=dg'";
    }
	return $menu . "<a {$selected}>Digg</a>";
}

register_filter('dg_info','digg_info');
function digg_info($type) {
    if($type == "db")
    {
        return "digg";
    }
    else if($type == "type")
    {
        return "Digg";
    }
}

register_filter('add_site_select','digg_add_select');
function digg_add_select($menu) {
    if(isset($_POST["type"]) && $_POST["type"] == "dg")
    {
	    return $menu . "<option value='dg' selected>Digg</option>";
    }
    else
    {
        return $menu . "<option value='dg'>Digg</option>";
    }
}


register_filter('stats','digg_stats');
function digg_stats($stats) {
    $stat = mysql_query("SELECT * FROM `digg`");
    $stat = mysql_num_rows($stat);
    $clicks = mysql_fetch_object(mysql_query("SELECT SUM( `exchanges` ) AS `visits` FROM `digg`"));
    $clicks = $clicks->visits;
    if($clicks == "") { $clicks = 0; }
    return $stats . "<tr><td>Digg</td><td>{$stat}</td><td>{$clicks}</td></tr>";
}


/*register_action('initialize','facebook2');

function facebook2() {
	echo "Ich mag Facebook!";
}*/

?>