<div class="content">
    <div class="container">
        <?php if ($act == 'edit') { ?>
        <a href="/admin/pages/" class="button fright">Back</a>
        <div class="clear"></div>
        <?php if (isset($page->s_image)) { ?>
            <a class="preview" href="<?php echo '/images/pages/' . $page->s_image;?>">
                <img src="<?php echo '/images/pages/thumbs/' . $page->s_image;?>" alt="">
            </a>
        <? } ?>
        <form action="/admin/pages/edit?id=<?=$page->pk_i_id?>" id="pageEdit" enctype="multipart/form-data"
              method="post">
            <?php echo form_upload('s_image'); ?>
            <input name="pk_i_id" type="hidden" value="<?php echo $page->pk_i_id; ?>">
            <div class="row">
                <label>Name</label>
                <input name="s_name" type="text" value="<?php echo $page->s_name; ?>">
            </div>
            <div class="row">
                <label>Content</label>
                <textarea class="ckeditor" name="s_body" id="s_body"><?php echo $page->s_body; ?></textarea>
            </div>
            <?php echo form_submit('upload', 'Edit'); ?>
        </form>
        <?php } elseif ($act == 'new') { ?>
        <h3>Post New</h3>
        <a href="/admin/pages/" class="button fright">Back</a>
        <div class="clear"></div>
        <form action="/admin/pages/new" id="pageNew" enctype="multipart/form-data" method="post">
            <?php echo form_upload('s_image'); ?>
            <div class="row">
                <label>Name</label>
                <input name="s_name" type="text">
            </div>
            <div class="row">
                <label>Content</label>
                <textarea class="ckeditor" name="s_body" id="s_body"></textarea>
            </div>
            <?php echo form_submit('upload', 'Upload'); ?>
        </form>
        <?php } else { ?>
        <h1 class="fleft">pages</h1>
        <div class="clear"></div>
        <hr/>
        <table class="items-table">
            <tr>
                <th colspan="2">Pages</th>
                <th>options</th>
            </tr>
            <? $this->load->view('admin/list'); ?>
        </table>
        <?php }?>

    </div>
</div>
