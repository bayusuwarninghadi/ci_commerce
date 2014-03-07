<div class="content">
    <div class="container">
        <form action="/admin/setting" method="post">
            <? foreach ($setting as $k => $v) {?>
                <div class="row">
                    <label><?=$k?></label>
                    <textarea name="<?=$k?>"><?=$v?></textarea>
                </div>
            <? } ?>
            <?php echo form_submit('upload', 'Update'); ?>
        </form>
    </div>
</div>