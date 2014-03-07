<div class="content container shadow white">
    <div class="pad1">
        <?php if ($id) { ?>
        <div class="article">
            <? if ($page->s_image) { ?>
            <img src="/images/article/<?=$page->s_image?>" alt="" style="max-width: 100%">
            <? }?>
            <h1><?php echo $page->s_name?></h1>
            <div class="desc">
                <?php echo $page->s_body;?>
            </div>
        </div>
        <a href="/article"><input type="submit" value="<< back to home"></a>
        <?php } else { ?>
        <form action="/article">
            <input type="hidden" value="<?=$page?>" name="page">
        </form>
        <div class="articles">
            <h1>article</h1>
            <div class="items-table">
                <? $this->load->view('catalog/list')?>
            </div>
            <div class="clear"></div>
        </div>
        <div class='load-more'>Load More</div>
        <?php }?>
        <div class="clear"></div>
    </div>
</div>