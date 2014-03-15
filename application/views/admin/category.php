<div class="content">
	<div class="container">
		<?php if ($act == 'edit') { ?>
		<h1>Edit <?php echo $page->s_name?></h1>
		<form name="categoryPost" action="/admin/category/edit" method="post">
			<input name="pk_i_id" type="hidden" value="<?php echo $page->pk_i_id; ?>">
			<input name="i_parent_id" type="hidden" value="<?php echo $page->i_parent_id; ?>">

			<div class="row">
				<label>Category Name</label>
				<input name="s_name" type="text" value="<?php echo $page->s_name; ?>">
			</div>
			<div class="row">
				<label>Parrent Category</label>
				<? $this->load->view('admin/category-cb')?>
			</div>
			<input type="submit" value="Edit">
		</form>
		<?php } elseif ($act == 'new') { ?>
		<h1>POST NEW</h1>
		<form name="categoryPost" action="/admin/category/new" method="post">
			<input name="i_parent_id" type="hidden" value="0">

			<div class="row">
				<div class="row">
					<label>Category Name</label>
					<input name="s_name" type="text">
				</div>
				<div class="row">
					<label>Parrent Category</label>
					<? $this->load->view('admin/category-cb')?>
				</div>

			</div>
			<input type="submit" value="Post">
		</form>
		<?php } else { ?>
		<h1 class="fleft">Category</h1>
		<a href="/admin/category/new" class="button fright">Add New</a>
		<div class="clear"></div>
		<hr>
		<? function render_categories_table($categories = array())
		{ ?>
			<? foreach ($categories as $cat) { ?>

			<tr class="article">
				<td><?php echo $cat['pk_i_id']?></td>
				<td>
					<?=str_repeat("&nbsp;&nbsp;&nbsp;", $cat['i_depth'])?>
					<?=$cat['s_name']?>
				</td>
				<td><a href="<?php echo '/admin/category/edit?id=' . $cat['pk_i_id']?>">Edit</a></td>
				<td><a href="<?php echo '/admin/category/delete?id=' . $cat['pk_i_id']?>">Delete</a></td>
			</tr>

			<?= render_categories_table($cat['sub']) ?>
			<?php } ?>
			<? } ?>
		<table style="width: auto;">
			<tr>
				<th>#</th>
				<th>Name</th>
				<th colspan="2">options</th>
			</tr>
			<?=render_categories_table($categories)?>
		</table>
		<?php }?>
	</div>
</div>