<div class="content container shadow white">
    <div class="pad1">
        <h1>Change Email</h1>
        <form action="/change_email" id="pageEdit" enctype="multipart/form-data" method="post">
            <div class="row">
                <b>Current Email:</b> <?php echo $page->s_email; ?> <a href="/email">change</a>
            </div>
            <div class="row">
                <label>New Email</label>
                <input name="s_email" type="text" value="">
            </div>
            <?php echo form_submit('upload', 'Upload'); ?>
        </form>
    </div>
</div>