<? if (!$isLogin && !$subscribe) { ?>
<div class="subscribe pad1 white shadow2">
      <div class="content"> 
            <div class="close pad1 white bold">&times;</div>
            <form class="search" action="/subscribe" method="post">
                  <div class="row">
                        <label>Newsletter: </label>
                        <hr>
                        <p>Read latest news from us by subscribe our website, provide your email below</p>
                  </div>
                        <input class="fleft" type="text" placeholder="Enter your email here" name="s_email" >
                        <button class="fleft" type="submit" style="margin: 0 -5px;"><i class="icon-envelope"></i></button>
                        <div class="clear"></div>

            </form>
      </div>
</div>
<script type="text/javascript">
      $(".subscribe .close").click(function(){
            $('.subscribe').toggle();
            $.post("/session/set?key=subscribe&value=1");
      })
</script>
<??>
<? } ?>
</body>

<footer class="white shadow2">
      <div class="container center pad1">
            <div class="to-top icon-arrow-up"></div>
            <div>
                  <div class="social desktop fleft box-left left">
                        <a href="/store">
                              <span style="font-size: 30px;"><i class="icon-map-marker"></i> OUR STORE</span>
                        </a>

                        <div style="line-height: normal; color: #666; font-size: 10px; max-width: 100%;">
                              <?=$store->s_body?>
                        </div>
                  </div>

                  <div class="social fright box-right right">
                        <a href="<?=$setting['facebook_url']?>"><span class="icon-facebook"></span> </a>
                        <a href="<?=$setting['twitter_url']?>"><span class="icon-twitter"></span> </a>
                        <a href="<?=$setting['instagram_url']?>"><span class="icon-instagram"></span> </a>                        
                  </div>
                  <div class="clear"></div>

            </div>
            <div class="logo" style="margin: 20px 0;"><?=$setting['site_name']?></div>

            <hr>
            <div class="content-bottom">
                  <a href="/about">About Us</a>
                  <a href="/contact">Contact Us</a>
                  <a href="/article">Article</a>
                  <a href="/carrer">Carrer</a>
                  <a href="/page/29">Privacy policy</a>
                  <a href="/page/30">Terms of service</a>
            </div>
            <hr>
            COPYRIGHT &copy; 2013 FLOW SHOP. All Right Reserved
            <div class="clear"></div>
      </div>
</footer>
</html>