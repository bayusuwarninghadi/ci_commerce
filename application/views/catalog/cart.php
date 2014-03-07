<div class="content container shadow white">
    <div class="pad1">
        <table width="100%">
            <tr>
                <th>ITEM</th>
                <th style="width:170px;" class="right">QTY</th>
                <th style="width:170px;" class="right">PRICE</th>
            </tr>
            <? $this->load->view('catalog/list')?>
        </table>
        <div class="right">
            <a class="button" href="/checkout">Checkout &nbsp;<i class="icon-check"></i></a>
        </div>
    </div>
</div>