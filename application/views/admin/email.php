<div class="content">
      <div class="container">
            <?php if ($act == 'edit') { ?>
            <h1>Edit <?php echo $page->s_name?></h1>
            <h3><?php echo $page->s_name?></h3>
            <form action="/admin/email/edit?id=<?=$page->pk_i_id?>" id="pageEdit" enctype="multipart/form-data"
                  method="post">
                  <div class="row">
                        <label>Name</label>
                        <input name="s_name" type="text" value="<?php echo $page->s_name; ?>">
                  </div>
                  <div class="row">
                        <label>Content</label>
                        <textarea class="ckeditor" name="s_body" id="s_body"><?php echo $page->s_body; ?></textarea>
                  </div>
                  <?php echo form_submit('upload', 'save'); ?>
            </form>
            <?php } elseif ($act == 'new') { ?>
            <h1>POST NEW</h1>
            <form action="/admin/email/new" id="pageNew" enctype="multipart/form-data" method="post">
                  <div class="row">
                        <label>Name</label>
                        <input name="s_name" type="text">
                  </div>
                  <div class="row">
                        <label>Content</label>
                        <textarea class="ckeditor" name="s_body" id="s_body"></textarea>
                  </div>
                  <?php echo form_submit('upload', 'save'); ?>
            </form>
            <?php } elseif ($act == 'open') { ?>
            <h3>Posted Name: <?php echo $page->s_name?></h3>
            <div>Posted Email: <b><?php echo $page->s_email?></b></div>
            <div>Date Posted: <?php echo format_date($page->dt_created)?></div>
            <div><?php echo $page->s_message?></div>
            <hr/>
            <form action="/admin/email/reply" method="post">
                  <input type="hidden" name="id" value="<?=$page->pk_i_id?>">

                  <div class="row">
                        <label>Reply to <?=$page->s_email?></label>
                        <textarea class="ckeditor" name="message"></textarea>
                  </div>
                  <button type="submit">Reply <i class="icon-reply"></i></button>
            </form>
            <?php } elseif ($act == 'send') { ?>
            <form action="/admin/email/send" method="post">
                  <div class="row">
                        <div class="fleft pad1">
                              <label>To:</label>
                              <select name="users">
                                    <option value="all">All</option>
                                    <option value="member">Member</option>
                              </select>
                        </div>
                        <div class="fleft pad1">
                              <label>Subject:</label>
                              <input type="text" name="subject">
                        </div>
                        <div class="clear"></div>
                  </div>
                  <div class="row">
                        <label>Message:</label>
                        <textarea class="ckeditor" name="message"></textarea>
                  </div>
                  <button type="submit">Reply <i class="icon-reply"></i></button>
            </form>
            <?php } else { ?>
            <div class="fleft" style="width: 50%">
                  <div class="pad01">
                        <h1 class="fleft">Email Template</h1>
                        <!--                <a class="button fright" href="/admin/email/new"><i class="icon-pencil"></i> &nbsp;Add New</a>-->
                        <div class="clear"></div>
                        <hr/>
                        <table class="items-table">
                              <tr>
                                    <th>Name</th>
                                    <th>options</th>
                              </tr>
                              <? foreach ($emails as $p) { ?>
                              <tr class="item">
                                    <td>
                                          <div class="bold uppercase"><?php echo $p->s_name?></div>
                                          <div class="desc"><?php echo substr(strip_tags(html_entity_decode($p->s_body)), 0, 150)?></div>
                                    </td>
                                    <td><a href="<?php echo '/admin/email/edit?id=' . $p->pk_i_id?>">Edit</a></td>
                              </tr>
                              <? } ?>
                        </table>
                  </div>
            </div>

            <div class="fleft" style="width: 50%">
                  <div class="pad01">
                        <div>
                              <a class="button" href="/admin/email/send">Send Email</a>
                              <h1 class="fright">Messages</h1>
                              <div class="clear"></div>

                        </div>

                        <hr/>
                        <form action="/admin/email" method="post">
                              <input type="hidden" value="<?=$page?>" name="page">

                              <div class="fleft row">
                                    <label>Search</label>
                                    <input type="text" name="s_key" value="<?=$s_key?>" style="margin-right: 20px;">
                              </div>
                              <div class="fright row">
                                    <label>&nbsp;</label>
                                    <button type="submit" style="margin: 0;">Search &nbsp;<i class="icon-search"></i>
                                    </button>
                              </div>
                              <div class="clear"></div>
                        </form>
                        <table class="items-table">
                              <tr>
                                    <th>Message</th>
                                    <th>Date Post</th>
                              </tr>
                              <? $this->load->view('admin/list');?>
                        </table>
                        <div class='load-more'>Load More</div>
                  </div>
            </div>
            <div class="clear"></div>
            <?php }?>
      </div>
</div>