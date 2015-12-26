            <?php if(!isset($data)) { ?>
            <div class="sidebox">
                <div class="head">Login</div>
                <div class="contentinside">
                    <form class="login" method="post">
                        Username<br/>
                        <input name="loginUsername" type="text" value="<?php if(isset($_POST["loginUsername"])) { echo $_POST["loginUsername"]; } ?>"/><br/><br/>
                        Password<br/>
                        <input name="loginPassword" type="password"/><br/><br/>
                        
                        <input type="submit" value="Login" style="width:100%;"/><br/>
                        <input onclick='javascript:window.location = "resetpassword.php";' type="button" value="Reset Password" style="width:49%;"/>
                        <input onclick='javascript:window.location = "resendactivation.php";' type="button" value="Resend Activation" style="width:49%;"/>
                    </form>
                </div>
            </div>
            <div class="sidebox">
                <div class="head">Vote for Us!</div>
                <div class="contentinside">
                    <center><br><a href="http://topsocialexchanges.com/"><img src="http://topsocialexchanges.com/button.php?u=YouLikeHits" alt="Top Social Exchanges" border="0" /></a></center><br><br>
                </div>
            </div>
            <?php $sidebox = hook_filter('sidebox_loggedout',""); echo $sidebox; ?>
            <?php } else {?>
            <div class="sidebox">
                <div class="head">Menu</div>
                <div class="contentinside sidemenu">    
                    <?php
                    $menu = "<p><a href='addsite.php'>Add Site</a></p>";
                    $menu .= "<p><a href='sites.php'>My Sites</a></p>";
                    $menu .= "<p><a href='buy.php'>Buy Coins</a></p>";
                    $menu .= "<p><a href='coupon.php'>Coupon</a></p>";
                    $menu .= "<p><a href='refer.php'>Promote/Refer</a></p>";
                    $menu = hook_filter('side_menu',$menu);
                    $menu .= "<p><a href='settings.php'>Settings</a></p>";
                    $menu .= "<p><a href='logout.php'>Logout</a></p>";
                    $menu = hook_filter('side_menu_wrapper',$menu);
                    echo $menu;
                    ?>
                </div>
            </div>
            <div class="sidebox">
                <div class="head">Coins</div>
                <div class="contentinside coins">
                    <center><font size="5"><b id="coins"><?php echo $data->coins; ?> Coins</b></font><br/>
                    <a href="buy.php">[Buy Coins]</a></center>
                </div>
            </div>
            <?php $sidebox = hook_filter('sidebox_loggedin',""); echo $sidebox; ?>
            <?php } ?>
        </div>
        <div class="footer">
            Copyright &copy; 2012 <a class="footername" href="<?php echo $site->site_url; ?>"><?php echo $site->site_name; ?></a>
        </div>
        <br><center>
        <font color="white" size="1">We are neither affiliated with nor endorsed by Twitter, Facebook, MySpace, Digg, StumbleUpon, Google, YouTube, or Linkedin.</font></center>
        </body>
</html>