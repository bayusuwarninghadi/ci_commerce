<div class="content">
    <div class="container">
        <?php if ($act == 'edit') { ?>
        <h3><?php echo $page->s_name?></h3>
        <form action="/admin/product/edit?id=<?=$page->pk_i_id?>" id="pageEdit" enctype="multipart/form-data" method="post">
            <input name="pk_i_id" type="hidden" value="<?php echo $page->pk_i_id; ?>">

            <div data-image='<?=$page->s_image?>' style="background-image: url('<?= '/images/product/thumbs/' . $page->s_image;?>') " class="preview fleft">
	            <a class="delete <? if (!isset($page->s_image)) echo 'none'?>" href="<?='/admin/product/delete-image?field=s_image&id='.$page->pk_i_id.'&image-id=' . $page->s_image;?>"><i class="icon icon-trash"></i> </a>
	            <?php echo form_upload('s_image'); ?>
            </div>

	        <div data-image='<?=$page->s_image2?>' style="background-image: url('<?= '/images/product/thumbs/' . $page->s_image2;?>')" class="preview fleft">
                <a class="delete <? if (!isset($page->s_image2)) echo 'none'?>" href="<?='/admin/product/delete-image?field=s_image2&id='.$page->pk_i_id.'&image-id=' . $page->s_image2;?>"><i class="icon icon-trash"></i> </a>
                <?php echo form_upload('s_image2'); ?>
            </div>

            <div data-image='<?=$page->s_image3?>' style="background-image: url('<?= '/images/product/thumbs/' . $page->s_image3;?>')" class="preview fleft">
	            <a class="delete <? if (!isset($page->s_image3)) echo 'none'?>" href="<?='/admin/product/delete-image?field=s_image3&id='.$page->pk_i_id.'&image-id=' . $page->s_image3;?>"><i class="icon icon-trash"></i> </a>
	            <?php echo form_upload('s_image3'); ?>
            </div>

	        <div data-image='<?=$page->s_image4?>' style="background-image: url('<?= '/images/product/thumbs/' . $page->s_image4;?>')" class="preview fleft">
	            <a class="delete <? if (!isset($page->s_image4)) echo 'none'?>" href="<?='/admin/product/delete-image?field=s_image4&id='.$page->pk_i_id.'&image-id=' . $page->s_image4;?>"><i class="icon icon-trash"></i> </a>
	            <?php echo form_upload('s_image4'); ?>
            </div>

	        <div class="clear"></div>
            <div class="row">
                <label>Name</label>
                <input name="s_name" type="text" value="<?php echo $page->s_name; ?>">
            </div>
            <div class="row">
                <label>Category</label>
                <? $this->load->view('admin/category-cb')?>
            </div>
            <div class="row">
                <label>Price</label>
                <input name="i_price" type="text" value="<?php echo $page->i_price; ?>">IDR
            </div>

            <? $this->load->view('color_check')?>

            <div class="row">
                <label>Sale</label>
                <input name="i_sale" type="text" value="<?php echo $page->i_sale; ?>">%
            </div>
            <div class="row">
                <label>Stock</label>
                <input name="i_stok" class="numeric" type="text" value="<?php echo $page->i_stok; ?>">
            </div>
            <div class="row">
                <label>Content</label>
                <textarea class="ckeditor" name="s_body" id="s_body"><?php echo $page->s_body; ?></textarea>
            </div>
            <?php echo form_submit('upload', 'Submit'); ?>
        </form>
        <?php } elseif ($act == 'new') { ?>
        <h3>Post New</h3>
        <form action="/admin/product/new" id="pageNew" enctype="multipart/form-data" method="post">

	        <div class="preview fleft">
		        <a class="delete none" href="#"><i class="icon icon-trash"></i> </a>
		        <?php echo form_upload('s_image'); ?>
	        </div>
	        <div class="preview fleft">
		        <a class="delete none" href="#"><i class="icon icon-trash"></i> </a>
		        <?php echo form_upload('s_image2'); ?>
	        </div>
	        <div class="preview fleft">
		        <a class="delete none" href="#"><i class="icon icon-trash"></i> </a>
		        <?php echo form_upload('s_image3'); ?>
	        </div>
	        <div class="preview fleft">
		        <a class="delete none" href="#"><i class="icon icon-trash"></i> </a>
		        <?php echo form_upload('s_image4'); ?>
	        </div>

	        <div class="clear"></div>
	        <div class="row">
                <label>Name</label>
                <input name="s_name" type="text">
            </div>
            <div class="row">
                <label>Category</label>
                <? $this->load->view('admin/category-cb')?>
            </div>
            <div class="row">
                <label>Price</label>
                <input name="i_price" type="text">IDR
            </div>

            <? $this->load->view('color_check')?>

            <div class="row">
                <label>Sale</label>
                <input name="i_sale" type="text">%
            </div>
            <div class="row">
                <label>Stock</label>
                <input name="i_stok" class="numeric" type="text">
            </div>
            <div class="row">
                <label>Content</label>
                <textarea class="ckeditor" name="s_body" id="s_body"></textarea>
            </div>
            <?php echo form_submit('upload', 'Submit'); ?>
        </form>
        <?php } else { ?>
        <h1 class="fleft">products</h1>
        <a href="/admin/product/new" class="button fright">Add New</a>
        <div class="clear"></div>
        <hr/>
        <form class="search product" action="/admin/product" method="post">
            <input type="hidden" value="<?=$page?>" name="page">
            <div class="fleft row picker">
                <label>Category</label>
                <? $this->load->view('admin/category-cb')?>
            </div>
            <div class="fleft">
                <? $this->load->view('color_check')?>
            </div>
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
                <th colspan="2">Name</th>
                <th colspan="2">options</th>
            </tr>
            <? $this->load->view('admin/list');?>
        </table>
        <div class="clear"></div>
        <div class='load-more'>Load More</div>
        <?php }?>

    </div>
</div>