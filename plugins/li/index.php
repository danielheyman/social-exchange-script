<?php
if(!mysql_num_rows(mysql_query("SHOW TABLES LIKE 'linkedin'")))
{
   executeSql("plugins/li/db.sql");
}

register_filter('index_icons','linkedin_icon');
function linkedin_icon($icons) {
	return $icons . '<td align="center" width="14%" valign="top"><img src="60/linkedin.png" alt="Get Linkedin Shares"><br><b>Linkedin Shares</b></td>';
}
            
register_filter('top_menu_earn','linkedin_top_menu');
function linkedin_top_menu($menu) {
	return $menu . "<li><a href='xchange.php?p=li'>Linkedin</a></li>";
}

register_filter('site_menu','linkedin_site_menu');
function linkedin_site_menu($menu) {
    $selected = "";
    if(isset($_GET["p"]) && $_GET["p"] == "li")
    {
        $selected = "class='selected'";
    }
    else
    {
        $selected = "href='sites.php?p=li'";
    }
	return $menu . "<a {$selected}>Linkedin</a>";
}

register_filter('li_info','linkedin_info');
function linkedin_info($type) {
    if($type == "db")
    {
        return "linkedin";
    }
    else if($type == "type")
    {
        return "Linkedin";
    }
}

register_filter('add_site_select','linkedin_add_select');
function linkedin_add_select($menu) {
    if(isset($_POST["type"]) && $_POST["type"] == "li")
    {
	    return $menu . "<option value='li' selected>Linkedin</option>";
    }
    else
    {
        return $menu . "<option value='li'>Linkedin</option>";
    }
}


register_filter('stats','linkedin_stats');
function linkedin_stats($stats) {
    $stat = mysql_query("SELECT * FROM `linkedin`");
    $stat = mysql_num_rows($stat);
    $clicks = mysql_fetch_object(mysql_query("SELECT SUM( `exchanges` ) AS `visits` FROM `linkedin`"));
    $clicks = $clicks->visits;
    if($clicks == "") { $clicks = 0; }
    return $stats . "<tr><td>Linkedin</td><td>{$stat}</td><td>{$clicks}</td></tr>";
}


/*register_action('initialize','facebook2');

function facebook2() {
	echo "Ich mag Facebook!";
}*/

?>