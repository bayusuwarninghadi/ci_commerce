<div class="content container shadow white">
    <div class="pad1">
        <h1>Transaction Summary</h1>
        <?$total = 0;?>
        <div class="fleft" style="width:500px;">
            <? foreach ($cart as $c) { ?>
            <a href="/product?id=<?=$c->pk_i_id?>">
                <div class="shadow pad1 box">
                    <img src="/images/product/thumbs/<?=$c->s_image?>" class="item-image fright" width="90"/>
                    <div STYLE="text-transform: uppercase; font-size: 20px; line-height: 150%"><?=$c->s_name?></div>
                    <div>
                        Quantity: <b><?=$c->i_count?></b>
                        Color: <b><?=$c->order_color ? $c->order_color : 'Default'?></b>
                        Size: <b><?=$c->order_size ? $c->order_size : 'Default'?></b>
                    </div>
                    <?
                    $gross = $c->i_price * $c->i_count;
                    $price = (100 - $c->i_sale) / 100 * $gross;
                    $total += $price;
                    ?>
                    <div class="">@ <?=format_money($c->i_price)?></div>
                    <div class="<?=($c->i_sale > 0) ? 'gros' : 'net'?>"><?=format_money($gross)?></div>
                    <? if ($c->i_sale > 0) {?>
                    <div class="sale"><?=$c->i_sale?> %</div>
                    <div class="net"><?=format_money($price)?></div>
                    <?}?>
                    <div class="clear"></div>
                </div>
            </a>
            <? } ?>
        </div>
        <div class="fright pad1" style="width: 400px">
            <a class="button" href="/cart">Review Your Cart &nbsp;<i class="icon-shopping-cart"></i></a>
            <div>
                GRAND TOTAL:
                <h2><?=format_money($total)?></h2>
                BILLING ADDRESS:
                <h2><?=$loggedUser->s_address?></h2>
            </div>
            <hr/>
            <h3>How to pay</h3>

            please transfer to one of this bank account bellow:
            <div class="mar10 bold">
                <?php echo $setting['shop_bank_account'] ?>
            </div>
            <div class="right">
                <div><input type="checkbox" checked="checked"> Accept our <a href="/page/30">terms &amp; aggrement</a> </div>
                <a class="button" href="/checkout/add">Checkout &nbsp;<i class="icon-check"></i></a>
            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>