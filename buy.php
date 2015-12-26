<?php
include 'header.php';
if(isset($data)) {
?>
<div class="contentbox">
    <div class="head">Buy Coins</div>
    <div class="contentinside">
        <?php
        if($site->sale != 0)
        {
            $percent = $site->sale * 100;
            echo "<div class='success'>ATTENTION: THERE IS CURRENTLY A $percent% SALE!</div>";
        }
        $pack2 = mysql_query("SELECT * FROM `packs` ORDER BY `id` ASC");
        for($j=1; $pack = mysql_fetch_object($pack2); $j++)
        {
            $saleprice = number_format($pack->price * (1 - $site->sale),2);
            $regularprice = $pack->price;
            ?>
            <div class="purchase">
            <div class="purchase-hdr" style="padding:10px 18px;"><? echo number_format($pack->coins, 0);?> Coins - $<? if($regularprice != $saleprice) { echo $saleprice; } else { echo $regularprice; } ?></div>
            1 point = <? if($regularprice != $saleprice) { echo '<strike>$' . round($regularprice / $pack->coins, 4) . '</strike> <font color="red">$' . round($saleprice / $pack->coins, 4) . '</font><br>'; } else { echo "$" . round($regularprice / $pack->coins, 4); } ?>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="<? echo $site->paypal;?>">
            <input type="hidden" name="item_name" value="<? echo $pack->name;?>">
            <input type="hidden" name="item_number" value="<? echo $pack->coins;?>">
            <input type="hidden" name="custom" value="<? echo $data->id; ?>">
            <input type="hidden" name="amount" value="<? echo $saleprice;?>">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="button_subtype" value="services">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="no_shipping" value="2">
            <input type="hidden" name="rm" value="1">
            <input type="hidden" name="return" value="<?echo $site->site_url;?>">
            <input type="hidden" name="cancel_return" value="<?echo $site->site_url;?>">
            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHosted">
            <input type="hidden" name="notify_url" value="<?echo $site->site_url;?>/ipn.php">
            <br/><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" />
            <img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
            </form>
            </div>
        <? }?>
    </div>
</div>
<?php
}
else
{
    echo "Please login to view this page!";
}
include 'footer.php';
?>