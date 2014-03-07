<div class="content container shadow white">
    <div class="pad1">
        <? $this->load->view('catalog/user-sidebar')?>
        <h1>Confirmation</h1>
        <? if ($transaction) {?>
        <table class="items-table">
            <tr>
                <th colspan="3">Your Transaction Detail</th>
            </tr>
            <tr class="item <?=($transaction['dt_confirm'] == '') ? 'unconfirm' : 'confirm';?>">
                <td colspan="3">
                    <div>user: <b><?=$transaction['s_name']?></b> (<?=$transaction['s_email']?>) date: <b><?=format_date($transaction['dt_transaction'])?></b></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="bold">Billing Address:</div>
                    <div><?=$transaction['s_address']?></div>
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
                        <? foreach ($transaction['product'] as $p) { ?>
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
                            <td class="bold right"><?=format_money($transaction['i_grand_total'])?></td>
                        </tr>
                    </table>
                    <div class="clear"></div>
                </td>

            </tr>
        </table>
        <? } ?>
        <div class="box shadow pad1">
            <h3>Please check your transaction, fill transaction ID and amount that you have tansfer on form bellow</h3>
            <form action="/confirmation" method="POST">
                <div class="row">
                    <label>Transaction ID</label>
                    <? if ($transaction) {?>
                    <input type="text" name="fk_i_checkout_id" value="<?=$transaction['pk_i_id']?>" readonly="readonly">
                    <?} else {?>
                    <input type="text" name="fk_i_checkout_id">
                    <? }?>
                </div>
                <div class="row">
                    <? if ($transaction) {?>
                    <p>Total Ammount you must transfer: <b><?=format_money($transaction['i_grand_total'])?></b></p>
                    <?}?>
                    <label>Ammount</label>
                    <input type="text" name="i_ammount" class="numeric" placeholder="total amount have you transferred">
                </div>
                <div class="row">
                    <label>Date Transfer</label>
                    <input type="date" name="dt_transfer" value="<?=date('Y-m-d')?>">
                </div>
                <div class="row">
                    <label>Bank Name</label>
                    <input type="text" name="s_bank" value="<?=$loggedUser->s_bank?>">
                </div>
                <div class="row">
                    <label>Bank Account Name</label>
                    <input type="text" name="s_bank_name" value="<?=$loggedUser->s_bank_name?>">
                </div>
                <div class="row">
                    <label>Bank Number</label>
                    <input type="text" name="i_rek" value="<?=$loggedUser->i_rek?>">
                </div>
                <input type="submit" value="Confirm">
            </form>
        </div>

        <div class="clear"></div>
    </div>
</div>