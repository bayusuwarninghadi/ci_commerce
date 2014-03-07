<div class="content">
    <div class="container">
        <h2>Profit History</h2>

        <form action="/profit">
            <div class="row">
                <label>Periode</label>
                <select name="y">
                    <? for ($i = (int)date('Y'); $i >= 2000; $i-- ) {?>
                        <option <? if ($year == $i) echo'selected="selected"'?> value="<?=$i?>"><?=$i?></option>
                    <? } ?>
                </select>
                <select name="m">
                    <? $period = ($loggedUser->i_profit_type == 1) ? monthArray() : quarterMonthArray();
                    foreach($period as $m) {?>
                        <option <? if ($month == $m['id']) echo'selected="selected"'?> value="<?=$m['id']?>"><?=$m['name']?></option>
                    <? } ?>
                </select>
            </div>
            <input type="submit" value="Submit">
        </form>
        <table class="items-table">
            <tr>
                <th>Date</th>
                <th>Deposit</th>
                <th>Profit</th>
            </tr>
            <? $this->load->view('catalog/list');?>
        </table>
        <div id='load-more'>
            <input type="hidden" value="1" name="page">
            <a data-href="/profit" class="load-more" href="?page">Load More</a>
        </div>
    </div>
</div>