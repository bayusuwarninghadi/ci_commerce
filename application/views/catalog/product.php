<div class="content container shadow white">
      <div class="pad1">
            <?php if ($id) { ?>
            <div class="article">
                  <div class="fleft" style="width: 30%">
                        <img class="image-preview" data-zoom-image="/images/product/<?=$page->s_image?>"
                             src="/images/product/thumbs/<?=$page->s_image?>" alt="" style="max-width: 100%">

                        <div id="navigator" class="navigator">
                              <?if ($page->s_image) { ?>
                              <a href="#" data-zoom-image="/images/product/<?=$page->s_image?>" data-image="/images/product/thumbs/<?=$page->s_image?>">
                                    <div class="img-thumb active" style="background-image: url('/images/product/thumbs/<?=$page->s_image?>')"></div>
                              </a>
                              <? }?>
                              <?if ($page->s_image2) { ?>
                              <a href="#" data-zoom-image="/images/product/<?=$page->s_image2?>" data-image="/images/product/thumbs/<?=$page->s_image2?>">
                                    <div class="img-thumb" style="background-image: url('/images/product/thumbs/<?=$page->s_image2?>')"></div>
                              </a>
                              <? }?>
                              <?if ($page->s_image3) { ?>
                              <a href="#" data-zoom-image="/images/product/<?=$page->s_image3?>" data-image="/images/product/thumbs/<?=$page->s_image3?>">
                                    <div class="img-thumb" style="background-image: url('/images/product/thumbs/<?=$page->s_image3?>')"></div>
                              </a>
                              <? }?>

                              <?if ($page->s_image4) { ?>
                              <a href="#" data-zoom-image="/images/product/<?=$page->s_image4?>" data-image="/images/product/thumbs/<?=$page->s_image4?>">
                                    <div class="img-thumb" style="background-image: url('/images/product/thumbs/<?=$page->s_image4?>')"></div>
                              </a>
                              <? }?>
                              <div class="clear"></div>
                        </div>
                  </div>
                  <div class="fright desc" style="width: 70%">
                        <div class="mar01">
                              <h1><?php echo $page->s_name?></h1>

                              <div><b>Size:</b> <?=($page->s_size != '') ? $page->s_size : 'All Size'?></div>
                              <div><b>Color:</b> <?=($page->s_color != '') ? $page->s_color : 'Color Not Available'?>
                              </div>
                              <div>
                                    <b>Stock:</b> <?=($page->i_stok != 0) ? $page->i_stok : 'Item currently not available'?>
                              </div>
                              <h2 class="<?=($page->i_sale > 0) ? 'gros' : 'net'?>"><?=format_money($page->i_price)?></h2>
                              <? if ($page->i_sale > 0) { ?>
                              <div class="sale"><?=$page->i_sale?> %</div>
                              <div class="net"><?=format_money($page->i_price * (100 - $page->i_sale) / 100)?></div>
                              <? } ?>
                              <? if ($page->i_stok > 0 && $isLogin) { ?>
                              <form action="/cart/add" method="get">
                                    <input type="hidden" value="<?=$page->pk_i_id?>" name="id">
                                    <? if ($page->s_color) { ?>
                                    <div class="row">
                                          <label>Select Color</label>
                                          <select name="c">
                                                <? foreach (explode(',', $page->s_color) as $color) { ?>
                                                <option value="<?=$color?>"><?=$color?></option>
                                                <? }?>
                                          </select>
                                    </div>
                                    <? }?>
                                    <? if ($page->s_size) { ?>
                                    <div class="row">
                                          <label>Select Size</label>
                                          <select name="s">
                                                <? foreach (explode(',', $page->s_size) as $size) { ?>
                                                <option value="<?=$size?>"><?=$size?></option>
                                                <? }?>
                                          </select>
                                    </div>
                                    <? }?>
                                    <div class="clear"></div>
                                    <button type="submit">Checkout &nbsp;<i class="icon-ok"></i></button>
                              </form>
                              <? } ?>
                              <?php echo $page->s_body;?>
                        </div>
                  </div>
                  <div class="clear"></div>
            </div>
            <a href="/article"><input type="submit" value="<< back to home"></a>
            <?php } else { ?>
            <form class="search product" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
                  <input type="hidden" value="<?=$page?>" name="page">

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
            <hr>
            <div class="articles items-table">
                  <? $this->load->view('catalog/list')?>
            </div>
            <div class="clear"></div>
            <div class='load-more'>Load More</div>
            <?php }?>
            <div class="clear"></div>
      </div>
</div>