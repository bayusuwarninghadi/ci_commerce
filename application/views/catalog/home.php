<script type="text/javascript" src="/js/nivo-slider/jquery.nivo.slider.js"></script>
<script type="text/javascript" src="/js/carousel.js"></script>
<link rel="stylesheet" href="/js/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/js/nivo-slider/themes/bar/bar.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
<div class="content home">
    <div class="container slider shadow">
        <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
                <? foreach ($slider as $item) { ?>
                    <a href="<?=$item->s_link?>">
                        <img src="/images/slider/thumbs/<?=$item->s_image?>" data-thumb="/images/slider/<?=$item->s_image?>" alt="" title="<?=$item->s_name?>" />
                    </a>
                <? } ?>
            </div>
        </div>
    </div>
    <div class="container shadow white">
        <div id="new-product" class="home-box">
            <ul class="new-product no-over">
                <? $i = 0;?>
                <? foreach ($new_product as $prod) { ?>
                <li>

                    <a href="/product?id=<?=$prod->pk_i_id?>" >
                        <div class="product fleft transition shadow" style="background-image: url('/images/product/thumbs/<?=$prod->s_image?>')">
                            <div class="title center"><?=$prod->s_name?></div>
                            <div class="price"><?=format_money($prod->i_price)?></div>
                        </div>
                    </a>
                </li>
                <?
                $i++;
                if ($i == 10) break;
                ?>
                <?}?>
                <div class="clear"></div>
            </ul>
        </div>

        <div class="home-box">
            <h2 class="line"><?=$promo->s_name?> <a href="/page/42" class="fright">See More >></a></h2>
            <div class="center">
                <a href="/page/42"><img src="/images/pages/<?=$promo->s_image?>" width="100%"></a>
            </div>
        </div>
        <div class="home-box carousel-box">
            <h2 class="line">HOT SALE <a href="/product?sale=1" class="fright">See More >></a></h2>
            <ul class="carousel">
                <? foreach ($sale as $prod) { ?>
                <li>
                    <div class="product transition shadow" style="background-image: url('/images/product/thumbs/<?=$prod->s_image?>')">
                        <div class="price">
                            <div class="title"><?=$prod->s_name?></div>
                            <div class="gros"><?=format_money($prod->i_price)?></div>
                            <div class="sale"><?=$prod->i_sale?> %</div>
                            <div class="net"><?=format_money($prod->i_price * (100 - $prod->i_sale) / 100)?></div>
                        </div>
                        <? if ($prod->i_stok > 0 && $isLogin) {?>
                        <a href="/cart/add?id=<?=$prod->pk_i_id?>" class="transition add-to-cart">Checkout &nbsp;<i class="icon-ok"></i></a>
                        <? } ?>

                    </div>
                </li>
                <?}?>
                <div class="clear"></div>
            </ul>
            <div class="navi">
                <span class="prev fleft icon-step-backward icon-large"></span>
                <span class="next fright icon-step-forward icon-large"></span>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
        $('.carousel').carousel({
            next: $('.next'),
            prev: $('.prev'),
            slidespeed: 700,
            auto: 5000,
            width:250,
            height:260,
            visible: 4
        });
        $('.new-product').carousel({
            slidespeed: 700,
            auto: 5000,
            width:200,
            height:250,
            visible: 5
        });
    });
</script>
