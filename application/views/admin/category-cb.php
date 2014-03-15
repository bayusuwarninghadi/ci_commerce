<? function create_combobox_view($categories = array(), $selected = ''){ ?>
      <?php foreach ($categories as $cat) { ?>
      <option <? if ($selected == $cat['pk_i_id']) echo 'selected="selected"'?>
            data-depth='<?php echo $cat['i_depth']?>'
            data-slug='<?php echo $cat['s_slug']?>'
            value='<?php echo $cat['pk_i_id']?>'>
            <?=str_repeat("&nbsp;&nbsp;&nbsp;", $cat['i_depth'])?> <?php echo $cat['s_name']?>
      </option>
      <? if ($cat['sub']) echo create_combobox_view($cat['sub'], $selected);?>
      <?php } ?>

<? } ?>
<select name="fk_i_cat_id">
      <option selected="selected" value=''>Select Category</option>
      <?=create_combobox_view($categories, $fk_i_cat_id)?>
</select>