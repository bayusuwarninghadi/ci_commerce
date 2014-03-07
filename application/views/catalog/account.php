<div class="content container shadow white">
    <div class="pad1">
        <? $this->load->view('catalog/user-sidebar')?>
        <table>
            <tr>
                <th>SHOPPING CART</th>
                <th class="right">QTY</th>
                <th class="right">PRICE</th>
            </tr>
            <?if ($cart) { ?>
            <? $total = 0;
            foreach ($cart as $c) {?>
                <tr>
                    <td valign="top">
                        <a href="/product?id=<?=$c->pk_i_id?>">
                            <div>
                                <div class="uppercase bold"><?=$c->s_name?></div>
                                <img src="/images/product/thumbs/<?=$c->s_image?>" width="50" class="item-image mar10" />
                                <div class="clear"></div>
                            </div>
                        </a>
                    </td>
                    <td class="right" valign="top"><?=$c->i_count?></td>
                    <td class="right" valign="top">
                        <?
                        $price = $c->i_sale / 100 * $c->i_price * $c->i_count;
                        $total += $price;
                        echo format_money($price);
                        ?>
                    </td>
                </tr>
                <? } ?>
            <tr>
                <td class="right pad01" colspan="3">
                    <a class="button" href="/cart">Checkout &nbsp;<i class="icon-check"></i></a>
                </td>
            </tr>
            <? } else { ?>
            <tr>
                <td colspan="3"> You don't have item(s)</td>
            </tr>
            <? } ?>
        </table>
    </div>
</div>