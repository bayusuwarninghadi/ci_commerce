<div class="content">
    <div class="container">
        <?php if ($act == 'edit') { ?>
        <form action="/admin/user/edit?id=<?=$page->pk_i_id?>" id="pageEdit" enctype="multipart/form-data"
              method="post">
            <?php if (isset($page->s_image)) { ?>
            <a class="preview" href="<?php echo '/images/user/' . $page->s_image;?>">
                <img src="<?php echo '/images/user/thumbs/' . $page->s_image;?>" alt="">
            </a>
            <? } ?>
            <?php echo form_upload('s_image'); ?>
            <div class="row">
                <label>Name</label>
                <input name="s_name" type="text" value="<?php echo $page->s_name; ?>">
            </div>
            <div class="row">
                <label>Email</label>
                <input name="s_email" type="text" value="<?php echo $page->s_email; ?>">
            </div>
            <div class="row">
                <a class="button" href="/admin/user/change_password?id=<?=$page->pk_i_id?>">Change Password</a>
            </div>

            <div class="row">
                <label>Phone Number</label>
                <input name="s_phone" class="numeric" type="text" value="<?php echo $page->s_phone; ?>">
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
            <?php echo form_submit('upload', 'Edit'); ?>
        </form>
        <?php } elseif ($act == 'new') { ?>
        <h1>POST NEW</h1>
        <form action="/admin/user/new" id="pageNew" enctype="multipart/form-data" method="post">
            <?php echo form_upload('s_image'); ?>
            <div class="row">
                <label>Name</label>
                <input name="s_name" type="text">
            </div>
            <div class="row">
                <label>Email</label>
                <input name="s_email" type="text">
            </div>
            <div class="row">
                <label>Phone Number</label>
                <input name="s_phone" class="numeric" type="text">
            </div>
            <div class="row" id="address">
                <label>Address (billing address)</label>
                <textarea name="s_address"></textarea>
            </div>
            <div class="row">
                <label>Bank Account</label>
                <input name="s_bank" type="text">
            </div>
            <div class="row">
                <label>Bank Account Name</label>
                <input name="s_bank_name" type="text">
            </div>
            <div class="row">
                <label>Bank Account Number</label>
                <input name="i_rek" class="numeric" type="text">
            </div>
            <?php echo form_submit('upload', 'Upload'); ?>
        </form>
        <?php } else { ?>
        <h1 class="fleft">User List</h1>
        <a href="/admin/user/new" class="button fright">Add New</a>
        <div class="clear"></div>
        <hr/>
        <form action="/admin/user" method="POST">
            <input type="hidden" value="<?=$page?>" name="page">
            <div class="fleft row">
                <label>Search</label>
                <input type="text" name="s_key" value="<?=$s_key?>" style="margin-right: 20px;" placeholder="Name, Email">
            </div>
            <div class="fright row">
                <label>&nbsp;</label>
                <button type="submit" style="margin: 0;">Search &nbsp;<i class="icon-search"></i></button>
            </div>
            <div class="clear"></div>
        </form>
        <table class="items-table" style="width: auto;">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <?  if ($isAdminLogin == 1) { ?>
                <th>options</th>
                <?} ?>
            </tr>
            <? $this->load->view('admin/list');?>
        </table>
        <div id='load-more'>
            <input type="hidden" value="1" name="page">
            <a data-href="/admin/user" class="load-more" href="?page">Load More</a>
        </div>
        <?php }?>
    </div>
</div>