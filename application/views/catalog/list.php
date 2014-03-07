<?
switch ($list) {
    case 'product':
        foreach ($product as $page) {
            if ($page->s_name != '') { ?>
                <div onclick="location.href='<?php echo '/product?id=' . $page->pk_i_id?>'" class="article shadow fleft transition" style="background-image:url(/images/product/thumbs/<?=$page->s_image?>); cursor: pointer">
                    <h2><?php echo $page->s_name?></h2>
                    <div class="desc">
                        <div class="<?=($page->i_sale > 0) ? 'gros' : 'net'?>"><?=format_money($page->i_price)?></div>
                        <? if ($page->i_sale > 0) {?>
                            <div class="sale"><?=$page->i_sale?> %</div>
                            <div class="net"><?=format_money($page->i_price * (100 - $page->i_sale) / 100)?></div>
                        <? } ?>
                        <? if ($page->i_stok > 0 && $isLogin) {?>
                            <a href="/cart/add?id=<?=$page->pk_i_id?>" class="button add-to-cart">Checkout &nbsp;<i class="icon-ok"></i></a>
                        <? } ?>
                    </div>
                </div>
            <?php }
        }
        break;
    case 'article':
        foreach ($article as $page) {
            if ($page->s_name != '') { ?>
            <div onclick="location.href='<?php echo '/article?id=' . $page->pk_i_id?>'" class="article shadow fleft transition" style="background-image:url(/images/article/thumbs/<?=$page->s_image?>); cursor: pointer">
                <h2><?php echo $page->s_name?></h2>
                <div class="desc">
                    <?php echo substr(strip_tags($page->s_body), 0, 200)?>
                </div>
            </div>
            <?php }
        }
        break;
    case 'cart':
        $total = 0;
        foreach ($cart as $c) {?>
        <tr data-id="<?=$c->pk_i_id?>" class="item">
            <td valign="top">
                <a href="/product?id=<?=$c->pk_i_id?>">
                    <div>
                        <b style="text-transform: uppercase"><?=$c->s_name?></b><br/>
                        color: <b><?=$c->order_color ? $c->order_color : "default"?></b><br/>
                        size: <b><?=$c->order_size ? $c->order_size : "default"?></b><br/>
                        <img src="/images/product/thumbs/<?=$c->s_image?>" width="50" class="item-image fright" />
                        <div class="clear"></div>
                    </div>
                </a>
                <a class="button"
                   onclick="if (confirm('Are you sure you want delete this item from your cart?')) {location.href = this.href} return false;"
                   href="/cart/delete?id=<?=$c->pk_i_cart_id?>">
                    Delete &nbsp; <i class="icon-trash"></i>
                </a>
            </td>
            <td class="right" valign="top">
                <form method="post" action="/cart/add?id=<?=$c->pk_i_id?>">
                    <input type="number" name="i_count" value="<?=$c->i_count?>">
                    <div>Stock Availability: <?=$c->i_stok?></div>
                    <button type="submit">Update &nbsp;<i class="icon-pencil"></i> </button>
                </form>
            </td>
            <td class="right" valign="top">
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
                <? } ?>
            </td>
        </tr>
        <? } ?>
        <tr>
            <td>
                <h2>BILLING ADDRESS</h2>
                <?=$loggedUser->s_address?>
                <div>
                    <a class="button" href="/profile#address">Update Billing Address &nbsp;<i class="icon-truck"></i></a>
                </div>
            </td>
            <td>Grand Total</td>
            <td class="right"><b><?=format_money($total)?></b></td>
        </tr>
        <? break;
    case 'checkout':
    default:
        echo 'no list-found';
        break;
}
?>
