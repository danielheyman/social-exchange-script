<?php
include 'header.php';
foreach($_POST as $key => $value) {
	$posts[$key] = filter($value);
}

if(isset($posts['name'])) {
    if($posts['name'] == ""){
        $error = "Please enter your real name!";
    }else if(!isEmail($posts['email'])){
        $error = "Please enter a valid email address!";
    }else if($posts['message'] == ""){
        $error = "Please enter your message!";
    }else{
        $subject ="Contact";
        $message="{$posts['message']}";
        $header="From: {$posts['name']} <{$posts['email']}>";
        $to = $site->site_email;
        $send_contact=mail($to,$subject,$message,$header);
        $success = "Message Sent!";
    }
}
  ?>
<div class="contentbox">
    <div class="head">Contact</div>
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
        
        <form class="contentform" method="post">
            Name<br/>
            <input name="name" type="text" value="<?php if(isset($posts["name"])) { echo $posts["name"]; } ?>"/><br/><br/>
            Email<br/>
            <input name="email" type="text" value="<?php if(isset($posts["email"])) { echo $posts["email"]; } else { if(isset($data->email)) { echo $data->email; } } ?>"/><br/><br/>
            Message<br/>
            <textarea rows="10" name="message"><?php if(isset($posts["message"])) { echo $posts["message"]; } ?></textarea><br/><br/>
            <p>
            <input style="width:100%;" type="Submit"/>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>