<?php
include 'header.php';
foreach($_GET as $key => $value) {
	$gets[$key] = filter($value);
}
?>
<div class="contentbox">
    <div class="head">Users</div>
    <div class="contentinside">
        <?php
        $find = "";
        if(isset($gets["user"]))
        {
            $find = " where username='{$gets['user']}'";
        }
        $users = mysql_query("SELECT * FROM `users`{$find}");
        ?>
        <table cellpadding="5" class="siteslist"><tr><td width="60">ID</td><td width="150">Username</td><td>Email</td><td width="60">Edit</td></tr>
        <?php
        for($x=1; $myuser = mysql_fetch_object($users); $x++)
        {
            echo "<tr><td>{$myuser->id}</td><td>{$myuser->username}</td><td>{$myuser->email}</td><td><a href='edituser.php?x={$myuser->id}'>Edit</a></td></tr>";
        }
        ?>
        </table>
    </div>
</div>
<div class="sidebox">
    <div class="head">Search Users</div>
    <div class="contentinside">
        <?php if(isset($error)) { ?>
        <div class="error">ERROR: <?php echo $error; ?></div>
        <?php }
        if(isset($success)) { ?>
        <div class="success">SUCCESS: <?php echo $success; ?></div>
        <?php }
        if(isset($warning)) { ?>
        <div class="warning">WARNING: <?php echo $warning; ?></div>
        <?php } ?>
        <form class="sideform" method="get">
            Username<br/>
            <input name="user" type="text"/><br/><br/>
            <input style="width:100%;" type="submit" value="Search"/>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>