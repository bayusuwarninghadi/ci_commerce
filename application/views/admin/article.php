<div class="content">
    <div class="container">
        <?php if ($act == 'edit') { ?>
            <h3><?php echo $page->s_name?></h3>
            <?php if (isset($page->s_image)) { ?>
                <a class="preview" href="<?php echo '/images/article/' . $page->s_image;?>">
                    <img src="<?php echo '/images/article/thumbs/' . $page->s_image;?>" alt="">
                </a>
            <? } ?>
            <form action="/admin/article/edit?id=<?=$page->pk_i_id?>" id="pageEdit" enctype="multipart/form-data" method="post">
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
                <?php echo form_submit('upload', 'Upload'); ?>
            </form>
        <?php } elseif ($act == 'new') { ?>
            <h3>Post New</h3>
            <form action="/admin/article/new" id="pageNew" enctype="multipart/form-data" method="post">
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
        <h1 class="fleft">Articles</h1>
        <a href="/admin/article/new" class="button fright">Add New</a>
        <div class="clear"></div>
        <hr/>
        <form action="/admin/article" method="POST">
            <input type="hidden" value="<?=$page?>" name="page">
            <div class="fleft row">
                <label>Search</label>
                <input type="text" name="s_key" value="<?=$s_key?>" style="margin-right: 20px;">
            </div>
            <div class="fright row">
                <label>&nbsp;</label>
                <button type="submit" style="margin: 0;">Search &nbsp;<i class="icon-search"></i></button>
            </div>
            <div class="clear"></div>
        </form>
        <table class="items-table">
            <tr>
                <th >Name</th>
                <th colspan="2">options</th>
            </tr>
            <? $this->load->view('admin/list');?>
        </table>
        <div class='load-more'>Load More</div>
        <?php }?>

    </div>
</div>