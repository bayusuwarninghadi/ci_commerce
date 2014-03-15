<div class="content">
      <div class="container">
            <?php if ($act == 'edit') { ?>
            <form action="/admin/admin/edit?id=<?=$page->pk_i_id?>" id="pageEdit" enctype="multipart/form-data"
                  method="post">
                  <div class="row">
                        <label>Email</label>
                        <input name="s_email" type="text" value="<?php echo $page->s_email; ?>">
                  </div>
                  <div class="row">
                        <label>Username</label>
                        <input name="s_username" type="text" value="<?php echo $page->s_username; ?>">
                  </div>
                  <div class="row">
                        <a class="button" href="/admin/admin/change_password?id=<?=$page->pk_i_id?>">Change Password</a>
                  </div>
                  <div class="row">
                        <label>Level</label>
                        <select name="s_level">
                              <option value="1" <?if ($page->s_level == 1) echo 'selected="selected"';?>>Super Admin
                              </option>
                              <option value="2" <?if ($page->s_level == 2) echo 'selected="selected"';?>>Admin</option>
                        </select>
                  </div>
                  <?php echo form_submit('upload', 'Edit'); ?>
            </form>

            <?php } elseif ($act == 'new') { ?>
            <h1>POST NEW</h1>
            <form action="/admin/admin/new" id="pageNew" enctype="multipart/form-data" method="post">
                  <div class="row">
                        <label>Email</label>
                        <input name="s_email" type="text">
                  </div>
                  <div class="row">
                        <label>Username</label>
                        <input name="s_username" type="text">
                  </div>
                  <div class="row">
                        <label>Password</label>
                        <input name="s_password" type="password">
                  </div>
                  <div class="row">
                        <label>Level</label>
                        <select name="s_level">
                              <option value="1">Super Admin</option>
                              <option value="2">Admin</option>
                        </select>
                  </div>
                  <?php echo form_submit('upload', 'Add'); ?>
            </form>
            <?php } else { ?>
            <h1 class="fleft">Admin List</h1>
            <a href="/admin/admin/new" class="button fright">Add New</a>
            <div class="clear"></div>
            <hr/>
            <form action="/admin/admin" method="POST">
                  <input type="hidden" value="<?=$page?>" name="page">

                  <div class="fleft row">
                        <label>Search</label>
                        <input type="text" name="s_key" value="<?=$s_key?>" style="margin-right: 20px;"
                               placeholder="Name, Email">
                  </div>
                  <div class="fright row">
                        <label>&nbsp;</label>
                        <button type="submit" style="margin: 0;">Search &nbsp;<i class="icon-search"></i></button>
                  </div>
                  <div class="clear"></div>
            </form>
            <table class="items-table" style="width: auto;">
                  <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Level</th>
                        <th colspan="2">options</th>
                  </tr>
                  <? $this->load->view('admin/list');?>
            </table>
            <div id='load-more'>
                  <input type="hidden" value="1" name="page">
                  <a data-href="/admin/admin" class="load-more" href="?page">Load More</a>
            </div>
            <?php }?>
      </div>
</div>