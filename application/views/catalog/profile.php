<div class="content container shadow white">
    <div class="pad1">
        <? $this->load->view('catalog/user-sidebar')?>
        <form action="/profile" id="pageEdit" enctype="multipart/form-data" method="post">
            <?php if (isset($page->s_image)) { ?>
            <a class="preview" href="<?php echo '/images/user/' . $page->s_image;?>">
                <img src="<?php echo '/images/user/thumbs/' . $page->s_image;?>" width="100px;" alt="">
            </a>
            <? } ?>
            <div class="row">
                <?php echo form_upload('s_image'); ?>
            </div>
            <div class="row">
                <label>Full Name</label>
                <input name="s_name" type="text" value="<?php echo $page->s_name; ?>">
            </div>
            <div class="row">
                <b>Email:</b> <?php echo $page->s_email; ?>
            </div>
            <div class="row">
                <a class="button" href="/change_email">Change Email</a>
                <a class="button" href="/change_password">Change Password</a>
            </div>

            <div class="row">
                <label>Phone Number</label>
                <input name="s_phone" class="numeric" type="text" value="<?php echo $page->s_phone; ?>">
            </div>
            <div class="row">
                <label>Identity Number (ktp)</label>
                <input name="i_ktp" class="numeric" type="text" value="<?php echo $page->i_ktp; ?>">
            </div>
            <div class="row" id="address">
                <label>Address (billing address)</label>
                <textarea name="s_address"><?php echo $page->s_address; ?></textarea>
            </div>
            <div class="row">
                <label>Bank Account</label>
                <input name="s_bank" type="text" value="<?php echo $page->s_bank; ?>">
            </div>
            <div class="row">
                <label>Bank Account Name</label>
                <input name="s_bank_name" type="text" value="<?php echo $page->s_bank_name; ?>">
            </div>
            <div class="row">
                <label>Bank Account Number</label>
                <input name="i_rek" class="numeric" type="text" value="<?php echo $page->i_rek; ?>">
            </div>
            <?php echo form_submit('upload', 'Upload'); ?>
        </form>
        <div class="clear"></div>
    </div>
</div>