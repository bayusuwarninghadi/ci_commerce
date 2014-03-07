<div class="content container shadow white">
    <div class="pad1">
        <h1>Change Password</h1>
        <form action="/admin/user/change_password?id=<?=$page->pk_i_id?>" id="pageEdit" enctype="multipart/form-data" method="post">
            <div class="row">
                <label>New Password</label>
                <input name="password" type="password" value="">
            </div>
            <?php echo form_submit('upload', 'Submit'); ?>
        </form>
    </div>
</div>