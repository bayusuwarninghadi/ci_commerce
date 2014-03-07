<div class="content">
    <div class="container">
        <div class="fleft banner">
            <img src="/images/logo-image.png" alt="" width="300px">
            <div class="blue">
                <h2>fill your ammount</h2>
            </div>
        </div>
        <form action="/deposit" class="fleft" method="post">
            <h1>Add New Deposit</h1>
            <div class="field">
                <div class="label">deposit ammount</div>
                <input type="text" class="numeric" name="i_deposit_ammount">
            </div>
            <div class="field">
                <div class="label">deposit date</div>
                <input type="date" name="dt_deposit" value="<?=date('Y-m-d')?>">
            </div>
            <div class="field">
                <div class="label">Message</div>
                <textarea name="s_message"></textarea>
                <div>
                    <small>you can leave us an message eg : your bank account, your bank number, etc.</small>
                </div>
            </div>
            <input type="submit" value="Send">

            <div class="clear"></div>
        </form>
        <div class="clear"></div>
    </div>
    <div class="container">
        <h2>Deposit History</h2>
        <table class="items-table">
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Status</th>
                <th>price</th>
            </tr>
            <? $this->load->view('catalog/list');?>
        </table>
        <div id='load-more'>
            <input type="hidden" value="1" name="page">
            <a data-href="/deposit" class="load-more" href="?page">Load More</a>
        </div>
    </div>
</div>