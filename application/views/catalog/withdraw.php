<div class="content">
    <div class="container">
        <div class="fleft banner">
            <img src="/images/logo-image.png" alt="" width="300px">

            <div class="blue">
                <h2>fill your ammount</h2>
            </div>
        </div>
        <form action="/withdraw" class="fleft" method="post">
            <h1>Add New withdraw</h1>

            <div class="field">
                <div class="label">withdraw ammount</div>
                <input type="text" class="numeric" name="i_withdraw_ammount">
            </div>
            <div class="field">
                <div class="label">withdraw date</div>
                <input type="date" name="dt_withdraw" value="<?=date('Y-m-d')?>">
            </div>
            <div class="field">
                <div class="label">Your Bank Account</div>
                <input type="text" name="<?=$loggedUser->s_bank?>>
            </div>
            <div class="field">
                <div class="label">Your Bank Number</div>
                <input type="text" class="numeric" name="<?=$loggedUser->i_rek?>>
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
        <h2>withdraw History</h2>
        
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
            <a data-href="/withdraw" class="load-more" href="?page">Load More</a>
        </div>
    </div>
</div>