<?php
if(!mysql_num_rows(mysql_query("SHOW TABLES LIKE 'twitter'")))
{
   executeSql("plugins/tw/db.sql");
}

$sql=mysql_query("SELECT twiter FROM users");
if (!$sql){
    mysql_query("ALTER TABLE users ADD twitter varchar(255) NOT NULL");
}

register_filter('index_icons','twitter_icon');
function twitter_icon($icons) {
	return $icons . '<td align="center" width="14%" valign="top"><img src="60/twitter.png" alt="Get Twitter Followers"><br><b>Twitter Followers</b></td>';
}

            
register_filter('settings','twitter_settings');
function twitter_settings($settings) {
    $user = mysql_query("SELECT twitter FROM `users` WHERE `username`='{$_SESSION['username']}'");
    $data = mysql_fetch_object($user);
	return $settings . 'Twitter<br/><input name="twitter" type="text" value="' . $data->twitter . '"><br/><br/>';
}
            
register_filter('settings_sumbit','twitter_settings_submit');
function twitter_settings_submit($settings) {
	return $settings . ", `twitter` = '{$_POST['twitter']}'";
}
            
register_filter('top_menu_earn','twitter_top_menu');
function twitter_top_menu($menu) {
	return $menu . "<li><a href='xchange.php?p=tw'>Twitter</a></li>";
}

register_filter('site_menu','twitter_site_menu');
function twitter_site_menu($menu) {
    $selected = "";
    if(isset($_GET["p"]) && $_GET["p"] == "tw")
    {
        $selected = "class='selected'";
    }
    else
    {
        $selected = "href='sites.php?p=tw'";
    }
	return $menu . "<a {$selected}>Twitter</a>";
}

register_filter('tw_info','twitter_info');
function twitter_info($type) {
    if($type == "db")
    {
        return "twitter";
    }
    else if($type == "type")
    {
        return "Twitter";
    }
}

register_filter('add_site_select','twitter_add_select');
function twitter_add_select($menu) {
    if(isset($_POST["type"]) && $_POST["type"] == "tw")
    {
	    return $menu . "<option value='tw' selected>Twitter</option>";
    }
    else
    {
        return $menu . "<option value='tw'>Twitter</option>";
    }
}


register_filter('stats','twitter_stats');
function twitter_stats($stats) {
    $stat = mysql_query("SELECT * FROM `twitter`");
    $stat = mysql_num_rows($stat);
    $clicks = mysql_fetch_object(mysql_query("SELECT SUM( `exchanges` ) AS `visits` FROM `twitter`"));
    $clicks = $clicks->visits;
    if($clicks == "") { $clicks = 0; }
    return $stats . "<tr><td>Twitter</td><td>{$stat}</td><td>{$clicks}</td></tr>";
}


/*register_action('initialize','facebook2');

function facebook2() {
	echo "Ich mag Facebook!";
}*/

?>