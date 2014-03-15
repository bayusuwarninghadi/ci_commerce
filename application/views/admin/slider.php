<div class="content">
    <div class="container">
        <?php if ($act == 'edit') { ?>
        <h3><?php echo $page->s_name?></h3>
        <?php if (isset($page->s_image)) { ?>
            <a class="preview" href="<?php echo '/images/slider/' . $page->s_image;?>">
                <img src="<?php echo '/images/slider/thumbs/' . $page->s_image;?>" alt="" width="300">
            </a>
            <? } ?>
        <form action="/admin/slider/edit?id=<?=$page->pk_i_id?>" id="pageEdit" enctype="multipart/form-data"
              method="post">
            <?php echo form_upload('s_image'); ?>
            <input name="pk_i_id" type="hidden" value="<?php echo $page->pk_i_id; ?>">

            <div class="row">
                <label>Name</label>
                <input name="s_name" type="text" value="<?php echo $page->s_name; ?>">
            </div>
            <div class="row">
                <label>Url</label>
                <input name="s_link" type="text" value="<?php echo $page->s_link; ?>">
            </div>
            <?php echo form_submit('upload', 'Upload'); ?>
        </form>
        <?php } elseif ($act == 'new') { ?>
        <h3>Post New</h3>
        <form action="/admin/slider/new" id="pageNew" enctype="multipart/form-data" method="post">
            <?php echo form_upload('s_image'); ?>
            <div class="row">
                <label>Name</label>
                <input name="s_name" type="text">
            </div>
            <div class="row">
                <label>Url</label>
                <input name="s_link" type="text">
            </div>
            <?php echo form_submit('upload', 'Upload'); ?>
        </form>
        <?php } else { ?>
        <h1 class="fleft">sliders</h1>
        <a href="/admin/slider/new" class="button fright">Add New</a>
        <div class="clear"></div>
        <hr/>
        <table class="items-table">
            <tr>
                <th colspan="2">Name</th>
                <th colspan="2">options</th>
            </tr>
            <? foreach ($pages as $page) { ?>
            <tr class="item">
                <td>
                    <h3>
                        <a target="blank" href="<?php echo '/slider?id=' . $page->pk_i_id?>">
                            <?php echo $page->s_name?>
                        </a>
                    </h3>
                </td>
                <td>
                    <? if (isset($page->s_image)) { ?>
                    <img src="<?php echo '/images/slider/thumbs/' . $page->s_image;?>" alt="" maxwidth="100">
                    <? } ?>
                </td>
                <td><a class="button" href="<?php echo '/admin/slider/edit?id=' . $page->pk_i_id?>">Edit</a></td>
                <td>
                    <a class="button"
                       onclick="if (confirm('Are you sure you want delete this into the database?')) {location.href = this.href} return false;"
                       href="<?php echo '/admin/slider/delete?id=' . $page->pk_i_id?>">
                        Delete
                    </a>
                </td>
            </tr>
            <? } ?>
        </table>
        <?php }?>
    </div>
</div>
