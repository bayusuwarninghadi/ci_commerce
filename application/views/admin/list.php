<?
switch ($list) {
      case 'article':
            foreach ($pages as $page) {
                  ?>
            <tr class="item">
                  <td>
                        <a target="blank" href="<?php echo '/article?id=' . $page->pk_i_id?>" class="bold">
                              <?php echo $page->s_name?>
                        </a>

                        <div class="desc"><?php echo substr(strip_tags(html_entity_decode($page->s_body)), 0, 150)?></div>
                  </td>
                  <td><a href="<?php echo '/admin/article/edit?id=' . $page->pk_i_id?>">Edit</a></td>
                  <td>
                        <a onclick="if (confirm('Are you sure you want delete this from database?')) {location.href = this.href} return false;"
                           href="<?php echo '/admin/article/delete?id=' . $page->pk_i_id?>">
                              Delete
                        </a>
                  </td>
            </tr>
            <?
            }
            break;
      case 'product':
            foreach ($pages as $page) {
                  ?>
            <tr class="item">
                  <td>
                        <a class="uppercase large" target="blank"
                           href="<?php echo '/product?id=' . $page->pk_i_id?>"><?php echo $page->s_name?></a>

                        <div class="desc"><?php echo substr(strip_tags(html_entity_decode($page->s_body)), 0, 150)?></div>
                        <div class="pad10">
                              <span class="bold"><i class="icon-dollar"></i> <?=format_money($page->i_price)?></span>
                              <span class="pink pad01 gray line-through"><i class="icon-money"></i> <?=$page->i_sale?>%</span>
                              <span class="black pad01 "><i class="icon-truck"></i> <?=$page->i_stok?></span>
                        </div>
                  </td>
                  <td>
                        <? if (isset($page->s_image)) { ?>
                        <img src="<?php echo '/images/product/thumbs/' . $page->s_image;?>" alt="">
                        <? } ?>
                  </td>
                  <td><a href="<?php echo '/admin/product/edit?id=' . $page->pk_i_id?>">Edit</a></td>
                  <td>
                        <a onclick="if (confirm('Are you sure you want delete this from database?')) {location.href = this.href} return false;"
                           href="<?php echo '/admin/product/delete?id=' . $page->pk_i_id?>">
                              Delete
                        </a>
                  </td>
            </tr>
            <?
            }
            break;
      case 'pages':
            foreach ($pages as $page) {
                  ?>
            <tr class="item">
                  <td>
                        <h3>
                              <a target="blank" href="<?php echo '/pages?id=' . $page->pk_i_id?>">
                                    <?php echo $page->s_name?>
                              </a>
                        </h3>

                        <div class="desc"><?php echo substr(strip_tags(html_entity_decode($page->s_body)), 0, 150)?></div>
                  </td>
                  <td>
                        <? if (isset($page->s_image)) { ?>
                        <img src="<?php echo '/images/pages/thumbs/' . $page->s_image;?>" alt="" height="50px;">
                        <? } ?>
                  </td>
                  <td><a href="<?php echo '/admin/pages/edit?id=' . $page->pk_i_id?>">Edit</a></td>
            </tr>
            <?
            }
            break;
      case 'user':
            foreach ($pages as $page) {
                  ?>
            <tr class="item <?=($page->s_active == 0) ? 'unconfirm' : 'confirm'?>">
                  <td><?=$page->pk_i_id?></td>
                  <td>
                        <div><span class="bold"><?php echo $page->s_name?></span> (<?=$page->s_email?>)</div>
                        <i class="icon-calendar-empty"></i> <?=$page->dt_created?>
                  </td>
                  <td>
                        <?  if ($isAdminLogin == 1) { ?>
                        <a href="<?php echo '/admin/user/edit?id=' . $page->pk_i_id?>"><i class="icon-pencil"></i> Edit</a>
                        &nbsp;&nbsp;&nbsp;
                        <a onclick="if (confirm('Are you sure you want delete this from database?')) {location.href = this.href} return false;"
                           href="<?php echo '/admin/user/delete?id=' . $page->pk_i_id?>">
                              <i class="icon-trash"></i> Delete
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <? if ($page->s_active == 0) { ?>
                              <a href="<?php echo '/admin/user/activate?id=' . $page->pk_i_id . '&key=' . $page->s_key?>"><i
                                    class="icon-check"></i> activate</a>
                              <? } else { ?>
                              <a href="<?php echo '/admin/user/deactivate?id=' . $page->pk_i_id . '&key=' . $page->s_key?>"><i
                                    class="icon-check-minus"></i> Deactivate</a>
                              <? } ?>

                        <? }?>
                  </td>
            </tr>

            <?
            }
            break;
      case 'admin':
            foreach ($pages as $page) {
                  ?>
            <tr class="item">
                  <td><?=$page->pk_i_id?></td>
                  <td>
                        <span class="bold"><?php echo $page->s_username?></span> (<?=$page->s_email?>)
                  </td>
                  <td>
                        <span class="bold"><?php echo ($page->s_level == 1) ? 'Super Admin' : 'Admin'; ?></span>
                  </td>
                  <td><a href="<?php echo '/admin/admin/edit?id=' . $page->pk_i_id?>">Edit</a></td>
                  <td>
                        <a onclick="if (confirm('Are you sure you want delete this from database?')) {location.href = this.href} return false;"
                           href="<?php echo '/admin/admin/delete?id=' . $page->pk_i_id?>">
                              Delete
                        </a>
                  </td>
            </tr>

            <?
            }
            break;
      case 'checkout':
            foreach ($checkout as $c) {
                  ?>
            <tr class="item <?=$c['s_status'];?>">
                  <td><?=$c['pk_i_id']?></td>
                  <td colspan="3">
                        <div>user: <a href="/admin/user/edit?id=<?=$c['fk_i_user_id']?>"
                                      target="_blank"><b><?=$c['s_name']?></b> (<?=$c['s_email']?>) </a> date:
                              <b><?=format_date($c['dt_transaction'])?></b></div>

                  </td>
            </tr>
            <tr>
                  <td></td>
                  <td>
                        <div class="bold">Billing Address:</div>
                        <div><?=$c['s_address']?></div>
                        <? if ($c['dt_transfer']) { ?>
                        <div>
                              <table class="box" style="margin: 0 0 20px; max-width: 600px;">
                                    <tr>
                                          <th>Date Transfer</th>
                                          <th class="right">Bank</th>
                                          <th class="right">Account Name</th>
                                          <th class="right">Bank Number</th>
                                          <th class="right">Ammount</th>
                                    </tr>
                                    <tr>
                                          <td class="right"><?=format_date($c['dt_transfer'])?></td>
                                          <td class="right"><?=$c['s_transfer_bank']?></td>
                                          <td class="right"><?=$c['s_transfer_bank_name']?></td>
                                          <td class="right"><?=$c['i_transfer_rek']?></td>
                                          <td class="bold right"><?=format_money($c['i_transfer_ammount'])?></td>
                                    </tr>

                                    <?if ($c['s_status'] == 'paid' && $isAdminLogin == 1) { ?>
                                    <tr>
                                          <td colspan="5">
                                                <a class="button"
                                                   onclick="if (confirm('Are you sure you want confirm this transaction?')) {location.href = this.href} return false;"
                                                   href="/admin/checkout/confirm?id=<?=$c['pk_i_id']?>">
                                                      Confirm &nbsp; <i class="icon-check"></i>
                                                </a>
                                                <button onclick="$(this).parent().find('form').toggle()">Reject &nbsp;
                                                      <i class="icon-minus-sign"></i></button>
                                                <!--                                <a class="fright button"-->
                                                <!--                                   onclick="if (confirm('Are you sure you want delete this transaction?')) {location.href = this.href} return false;"-->
                                                <!--                                   href="/admin/checkout/delete?id=-->
                                                      <?//=$c['pk_i_id']?><!--">-->
                                                <!--                                    Delete &nbsp; <i class="icon-trash"></i>-->
                                                <!--                                </a>-->
                                                <div class="clear"></div>
                                                <form action="/admin/checkout/reject" method="post"
                                                      class="box shadow pad1 none">
                                                      <input type="hidden" value="<?=$c['pk_i_id']?>" name="id">

                                                      <div class="row">
                                                            <label>Provide your reason to reject this
                                                                  transaction</label>
                                                            <textarea name="reason"></textarea>
                                                      </div>
                                                      <button type="submit">Reject &nbsp; <i
                                                            class="icon-minus-sign"></i></button>
                                                </form>

                                          </td>
                                    </tr>
                                    <? }?>
                              </table>
                        </div>
                        <? }?>

                  </td>
                  <td class="right" colspan="2">
                        <div class="bold">Transaction Details</div>
                        <table class="fright box" style="margin: 0 0 20px; max-width: 600px;">
                              <tr>
                                    <th>Product</th>
                                    <th class="right">Price</th>
                                    <th class="right">Sale</th>
                                    <th class="right">qty</th>
                                    <th class="right">color</th>
                                    <th class="right">size</th>
                                    <th class="right">Total</th>
                              </tr>
                              <? foreach ($c['product'] as $p) { ?>
                              <tr>
                                    <td><a href="/admin/productR/edit?id=<?=$p['fk_i_product_id']?>"
                                           target="_blank"><?=$p['s_product_name']?></a></td>
                                    <td class="right">@<?=format_money($p['i_total'])?></td>
                                    <td class="right"><?=$p['i_sale']?> %</td>
                                    <td class="right"><?=$p['i_count']?></td>
                                    <td class="right"><?=$p['s_color'] ? $p['s_color'] : "default"?></td>
                                    <td class="right"><?=$p['s_size'] ? $p['s_size'] : "default"?></td>
                                    <td class="bold right"><?=format_money($p['i_total'])?></td>
                              </tr>
                              <? }?>
                              <tr class="right">
                                    <td class="right" colspan="4">Grand Total:</td>
                                    <td class="bold right"><?=format_money($c['i_grand_total'])?></td>
                              </tr>
                        </table>
                        <div class="clear"></div>
                  </td>

            </tr>

            <?
            }
            break;
      case 'inbox':
            foreach ($inbox as $page) {
                  ?>
            <tr class="item">
                  <td>
                        <div>
                              <div><b><?=$page->s_name?></b></div>
                              <div><?=$page->s_email?></div>
                              <div class="desc gray pad1 italic">
                                    <?php echo substr(strip_tags(html_entity_decode($page->s_message)), 0, 150)?>
                                    <a target="blank" href="<?php echo '/admin/email/open?id=' . $page->pk_i_id?>">View
                                          More</a>
                              </div>
                        </div>
                  </td>
                  <td><?=format_date($page->dt_created)?></td>
            </tr>
            <?
            }
            break;
      default:
            echo 'no list-found';
            break;
}
?>
