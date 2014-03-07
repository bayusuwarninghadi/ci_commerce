<? function render_navbar_menu($categories)
{ ?>
<?php foreach ($categories as $cat) { ?>
<li class="fleft root no-over">
      <a class="root-link transition link <?php echo $cat['s_slug']?>"
         href="/product<?php echo $cat['s_url']?>"><?php echo $cat['s_name']?></a>
      <?php if ($cat['sub']) { ?>
      <ul class="sub no-over sub-menu-1">
            <?foreach ($cat['sub'] as $cat) { ?>
            <li class="no-over">
                  <a class="link <?php echo $cat['s_slug']?>"
                     href="/product<?php echo $cat['s_url']?>"><?php echo $cat['s_name']?></a>
                  <?php if (isset($cat['sub'])) { ?>
                  <ul class="sub no-over sub-menu-2">
                        <?foreach ($cat['sub'] as $cat) { ?>
                        <li class="no-over">
                              <a class="link <?php echo $cat['s_slug']?>"
                                 href="/product<?php echo $cat['s_url']?>"><?php echo $cat['s_name']?></a>
                        </li>
                        <?php } ?>
                        <div class="clear"></div>
                  </ul>
                  <?php } ?>
            </li>
            <?php } ?>
            <div class="clear"></div>
      </ul>
      <?php } ?>
</li>
<?php } ?>

<? } ?>
<ul class="navbar no-over">
      <li class="fleft root no-over">
            <a class="root-link transition link" href="/">Home</a>
      </li>

      <?=render_navbar_menu($categories)?>

      <? if ($isLogin == 1) { ?>
      <li class="fleft root no-over desktop">
            <a class="root-link transition link" href="/logout">Logout</a>
      </li>

      <? } ?>
      <div class="clear"></div>
</ul>