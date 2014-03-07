<div class="content container shadow white">
    <div class="pad1">
        <h1>Change Password</h1>
        <form action="/change_password" id="pageEdit" enctype="multipart/form-data" method="post">
            <div class="row">
                <label>Current Password:</label>
                <input name="old_password" type="password" value="">
            </div>
            <div class="row">
                <label>New Password</label>
                <input name="password1" type="password" value="">
            </div>
            <div class="row">
                <label>Repeat Password</label>
                <input name="password2" type="password" value="">
            </div>
            <?php echo form_submit('upload', 'Upload'); ?>
        </form>
    </div>
</div>