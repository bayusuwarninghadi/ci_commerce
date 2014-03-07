<div class="content">
    <div class="container">
        <h1>Transaction</h1>
        <hr/>
        <form action="/admin/checkout" id="checkout_form" method="post">
            <input type="hidden" value="<?=$page?>" name="page">
            <div class="fleft row">
                <label>Search</label>
                <input type="text" name="s_key" value="<?=$s_key?>" style="margin-right: 20px;" placeholder="name, email, address">
            </div>
            <div class="fleft row">
                <label>Show as</label>
                <select name="status" onchange="$('#checkout_form').submit();">
                    <option value="" <? if ($status == '') echo 'selected="selected"';?>>Show All</option>
                    <option value="unpaid" <? if ($status == 'unpaid') echo 'selected="selected"';?>>Unpaid</option>
                    <option value="paid" <? if ($status == 'paid') echo 'selected="selected"';?>>Has Paid</option>
                    <option value="approved" <? if ($status == 'approved') echo 'selected="selected"';?>>Approved</option>
                    <option value="rejected" <? if ($status == 'rejected') echo 'selected="selected"';?>>Rejected</option>
                </select>
            </div>

            <div class="fright row">
                <label>&nbsp;</label>
                <button type="submit" style="margin: 0;">Search &nbsp;<i class="icon-search"></i></button>
            </div>
            <div class="clear"></div>
        </form>
        <table class="items-table">
            <tr>
                <th>id</th>
                <th colspan="3">transaction</th>
            </tr>
            <? $this->load->view('admin/list');?>
        </table>
        <div class='load-more'>Load More</div>
    </div>
</div>