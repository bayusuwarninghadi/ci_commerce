<div class="content">
    <div class="container">
        <div class="fleft" style="width: 50%">
            <div class="pad01">
            <h3 class="uppercase">last transaction</h3>
                <table class="items-table">
                    <tr>
                        <th>id</th>
                        <th colspan="3">transaction</th>
                    </tr>
                    <? foreach ($checkout as $c) { ?>
                    <tr class="item <?=$c['s_status'];?>">
                        <td><?=$c['pk_i_id']?></td>
                        <td colspan="3">
                            <div>user: <a href="/admin/user/edit?id=<?=$c['fk_i_user_id']?>" target="_blank" ><b><?=$c['s_name']?></b> (<?=$c['s_email']?>) </a> date: <b><?=format_date($c['dt_transaction'])?></b></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div class="bold">Billing Address:</div>
                            <div><?=$c['s_address']?></div>
                        </td>
                        <td class="right" colspan="2">
                            <table class="fright box" style="margin: 0 0 20px; max-width: 600px;">
                                <tr class="box bold uppercase">
                                    <td>Product</td>
                                    <td class="right">Price</td>
                                    <td class="right">Sale</td>
                                    <td class="right">qty</td>
                                    <td class="right">Total</td>
                                </tr>
                                <? foreach ($c['product'] as $p) { ?>
                                <tr>
                                    <td><a href="/admin/productR/edit?id=<?=$p['fk_i_product_id']?>" target="_blank" ><?=$p['s_product_name']?></a></td>
                                    <td class="right"><?=format_money($p['i_total'])?></td>
                                    <td class="right"><?=$p['i_sale']?> %</td>
                                    <td class="right"><?=$p['i_count']?></td>
                                    <td class="bold right"><?=format_money($p['i_total'])?></td>
                                </tr>
                                <? }?>
                                <tr class="right">
                                    <td class="right" colspan="4">Grand Total:</td>
                                    <td class="bold right"><?=format_money($c['i_grand_total'])?></td>
                                </tr>
                            </table>
                            <div class="clear"></div>
                        </td>

                    </tr>
                    <?}?>
                </table>
            </div>
        </div>
        <div class="fleft" style="width: 50%">
            <div class="pad01">
                <h3 class="uppercase">Last Product</h3>
                <table class="items-table">
                    <tr>
                        <th>Name</th>
                        <th width="80">options</th>
                    </tr>
                    <? foreach ($product as $page) {
                    ?>
                    <tr class="item">
                        <td>
                            <a target="blank" class="uppercase bold" href="<?php echo '/product?id=' . $page->pk_i_id?>"><?php echo $page->s_name?></a>
                        </td>
                        <td>
                            <a class="fleft" href="<?php echo '/admin/product/edit?id=' . $page->pk_i_id?>">Edit</a>
                            <a class="fright" onclick="if (confirm('Are you sure you want delete this into the database?')) {location.href = this.href} return false;"
                               href="<?php echo '/admin/product/delete?id=' . $page->pk_i_id?>">Delete
                            </a>
                        </td>
                    </tr>
                    <? }?>
                </table>
                <h3 class="uppercase">Incoming Messages</h3>
                <table class="items-table">
                    <tr>
                        <th>Message</th>
                        <th>Date Post</th>
                    </tr>
                    <? foreach ($inbox as $page) {?>
                    <tr class="item">
                        <td>
                            <div>
                                <div><b><?=$page->s_name?></b> <?=$page->s_email?></div>
                                <div class="desc gray pad1 italic">
                                    <?php echo substr(strip_tags(html_entity_decode($page->s_message)), 0, 150)?>
                                    <a target="blank" href="<?php echo '/admin/email/open?id=' . $page->pk_i_id?>">View More</a>
                                </div>
                            </div>
                        </td>
                        <td><?=format_date($page->dt_created)?></td>
                    </tr>
                    <?}?>
                </table>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>