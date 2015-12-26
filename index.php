<?php include 'header.php';
if(!isset($data)) {
?>
<div class="contentbox">
    <div class="head"><center>Welcome to <?php echo $site->site_name; ?></center></div>
    <div class="contentinside">
        <center>
            <b><?php echo $site->site_name; ?> is a system that will help you increase your social presence for FREE.  We allow you to pick and choose who you want to exchange with and skip those who you're not interested in.</b></font><br><br>
            <br/>
            <font size="2" color="blue"><b>You Like Hits helps you to increase all of the following:</b></font><br/><br/>
            <table width="100%">
                <tr style="font-size:13px;">
                    <?php $icons = hook_filter('index_icons',""); echo $icons; ?>
                    <!--<td align="center" width="14%" valign="top"><img src="60/newsvine.png" alt="And MORE"><br><b>And MORE</b></td>-->
                </tr>
            </table>
            <br/>
            <br/>
            
        </center>
        <br/><center>
        <p><b>Only exchange who and what you're interested in!</b></p>
        <ul>
        <li><font><b> We don't sell exchanges.</b></font></li>
        <li><font><b> We abide by all Social Network Policies.</li>
        <li><font><b> We don't ask for your account passwords.</b></font></li>
        </ul></center>
       </div>
</div>
<?php } else { ?>
<div class="contentbox">
    <div class="head">Welcome: <?php echo $data->username; ?></div>
    <div class="contentinside">
        <center><b>Thank you for being a member of <?php echo $site->site_name; ?>!</b><br><br>
        >>There is no site news<<
        
        <br/>
        <br/>
        
    </div>
</div>
<?php } ?>
<?php include 'footer.php'; ?>