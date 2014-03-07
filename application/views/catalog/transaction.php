<div class="content">
    <div class="container white shadow pad1">
        <? $this->load->view('catalog/user-sidebar')?>
        <table class="items-table" width="100%">
            <tr>
                <th colspan="3">Your Transactions</th>
                <th>Status</th>
            </tr>
            <? foreach ($transaction as $trx) {?>
            <tr class="item <?=$trx['s_status'];?>">
                <td>
                    <div><b>#<?=$trx['pk_i_id']?></b> date: <b><?=format_date($trx['dt_transaction'])?></b></div>
                    <div class="bold">Billing Address:</div>
                    <div><?=$trx['s_address']?></div>
                </td>
                <td class="right" colspan="2">
                    <table class="fright box" style="margin: 0 0 20px; max-width: 600px;">
                        <tr>
                            <th>Product</th>
                            <th class="right">Price</th>
                            <th class="right">Sale</th>
                            <th class="right">QTY</th>
                            <th class="right">Color</th>
                            <th class="right">Size</th>
                            <th class="right">Total</th>
                        </tr>
                        <? foreach ($trx['product'] as $p) { ?>
                        <tr>
                            <td><a href="/product?id=<?=$p['fk_i_product_id']?>" target="_blank" ><?=$p['s_product_name']?></a></td>
                            <td class="right">@<?=format_money($p['i_total'])?></td>
                            <td class="right"><?=$p['i_sale']?> %</td>
                            <td class="right"><?=$p['i_count']?></td>
                            <td class="right"><?=$p['s_color'] ? $p['s_color'] : "default"?></td>
                            <td class="right"><?=$p['s_size'] ? $p['s_size'] : "default"?></td>
                            <td class="bold right"><?=format_money($p['i_total'])?></td>
                        </tr>
                        <? }?>
                        <tr class="right">
                            <td class="right" colspan="4">Grand Total:</td>
                            <td class="bold right"><?=format_money($trx['i_grand_total'])?></td>
                        </tr>
                    </table>
                    <div class="clear"></div>
                </td>
                <td>
                    <? if ($trx['s_status'] == 'unpaid')  { ?>
                        <div><i class="icon-dollar"></i> &nbsp; unpaid or unconfirmed</div>
                        <a href="/confirmation/<?=$trx['pk_i_id']?>" class="button">Confirm &nbsp; <i class="icon-dollar"></i></a>
                    <? } elseif ($trx['s_status'] == 'paid') {?>
                        <i class="icon-time"></i> &nbsp; Waiting approval
                    <? } elseif ($trx['s_status'] == 'rejected') {?>
                        <i class="icon-minus-sign"></i> &nbsp; Rejected
                        <div class="bold">Reason:</div>
                        "<?=$trx['s_optional_notes']?>"

                    <? } else {?>
                        <i class="icon-check"></i> &nbsp; confirmed
                <? }?>
                </td>
            </tr>
            <? } ?>
        </table>
        <div class="clear"></div>
    </div>
</div>